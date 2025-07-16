<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ItemController extends Controller
{
    use AuthorizesRequests;
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
        'image' => 'nullable|image|max:2048',
    ]);

    $data = $request->all();
    $data['user_id'] = Auth::id();
    $data['status'] = 'active'; // Set default status for new items

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('items', 'public');
    }

    $item = Item::create($data);

    LogService::log('item_created', 'Created new item', [
        'item_id' => $item->id,
        'title' => $item->title,
        'type' => $item->type
    ]);

    return redirect()->route('items.index')->with('success', 'Item posted successfully!');
}

    public function show(Item $item)
    {
        $item->load(['user', 'category']);
        LogService::log('item_viewed', 'Viewed item', ['item_id' => $item->id, 'title' => $item->title]);
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

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:lost,found',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,claimed,closed',
        ]);

        $oldData = $item->only(['title', 'status', 'type']);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($data);

        LogService::log('item_updated', 'Updated item', [
            'item_id' => $item->id,
            'title' => $item->title,
            'changes' => array_diff_assoc($data, $oldData)
        ]);

        return redirect()->route('items.index')->with('success', 'Item updated successfully!');
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        LogService::log('item_deleted', 'Deleted item', [
            'item_id' => $item->id,
            'title' => $item->title,
            'type' => $item->type
        ]);

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully!');
    }
}