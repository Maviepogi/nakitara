<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\SuccessStory;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Item::where('user_id', Auth::id())->with('category')->latest()->paginate(10);
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:lost,found',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Multiple images
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        $imagePaths = [];
        
        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('items', 'public');
                $imagePaths[] = $imagePath;
            }
        }
        
        $data['images'] = $imagePaths;

        $item = Item::create($data);

        LogService::log('item_created', 'User created new item', [
            'item_id' => $item->id,
            'type' => $item->type
        ]);

        return redirect()->route('items.index')->with('success', 'Item created successfully!');
    }

    public function show(Item $item)
    {
        $item->load('category', 'user');
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item);

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:lost,found',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,claimed,closed',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_images' => 'nullable|array', // For removing specific images
            'remove_images.*' => 'string',
        ];

        // Add validation for success story fields if status is claimed
        if ($request->status === 'claimed') {
            $rules['finder_name'] = 'required|string|max:255';
            $rules['finder_email'] = 'required|email|max:255';
            $rules['success_story'] = 'required|string|min:10';
        }

        $request->validate($rules);

        $data = $request->only(['title', 'description', 'type', 'location', 'category_id', 'status']);

        // Handle image updates
        $currentImages = $item->images ?? [];
        
        // Remove selected images
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageToRemove) {
                if (($key = array_search($imageToRemove, $currentImages)) !== false) {
                    // Delete file from storage
                    Storage::disk('public')->delete($imageToRemove);
                    unset($currentImages[$key]);
                }
            }
            $currentImages = array_values($currentImages); // Re-index array
        }
        
        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (count($currentImages) < 5) { // Limit to 5 images
                    $imagePath = $image->store('items', 'public');
                    $currentImages[] = $imagePath;
                }
            }
        }
        
        $data['images'] = $currentImages;

        $item->update($data);

        // Create success story if status is claimed and story details are provided
        if ($request->status === 'claimed' && $request->filled(['finder_name', 'finder_email', 'success_story'])) {
            $this->createSuccessStory($item, $request);
        }

        LogService::log('item_updated', 'User updated item', [
            'item_id' => $item->id,
            'status' => $item->status
        ]);

        return redirect()->route('items.index')->with('success', 'Item updated successfully!');
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        // Delete all images if they exist
        if ($item->images) {
            foreach ($item->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        LogService::log('item_deleted', 'User deleted item', [
            'item_id' => $item->id
        ]);

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully!');
    }

    private function createSuccessStory(Item $item, Request $request)
    {
        // Check if success story already exists for this item
        if ($item->successStory) {
            return;
        }

        // Find or create finder user
        $finder = User::where('email', $request->finder_email)->first();
        
        if (!$finder) {
            // Create a basic user record for the finder
            $finder = User::create([
                'name' => $request->finder_name,
                'email' => $request->finder_email,
                'password' => bcrypt('temp_password_' . time()), // Temporary password
                'email_verified_at' => now(), // Auto-verify since admin is creating
            ]);
        }

        // Create success story
        SuccessStory::create([
            'item_id' => $item->id,
            'finder_id' => $finder->id,
            'owner_id' => $item->user_id,
            'story' => $request->success_story,
        ]);

        LogService::log('success_story_created', 'Success story created via item update', [
            'item_id' => $item->id,
            'finder_id' => $finder->id,
            'owner_id' => $item->user_id
        ]);
    }
}