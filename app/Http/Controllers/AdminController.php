<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\UserLog;
use App\Models\SuccessStory;
use App\Services\LogService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_items' => Item::count(),
            'active_items' => Item::where('status', 'active')->count(),
            'success_stories' => SuccessStory::count(),
            'total_logs' => UserLog::count(),
        ];

        $recentItems = Item::with(['user', 'category'])->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        $recentLogs = UserLog::with('user')->latest()->take(10)->get();

        LogService::log('admin_dashboard_viewed', 'Admin accessed dashboard');

        return view('admin.dashboard', compact('stats', 'recentItems', 'recentUsers', 'recentLogs'));
    }

    public function logs(Request $request)
    {
        $query = UserLog::with('user');

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->action) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->paginate(20);
        $users = User::all();
        $actions = UserLog::distinct()->pluck('action');

        LogService::log('admin_logs_viewed', 'Admin viewed user logs', [
            'filters' => $request->only(['user_id', 'action', 'date_from', 'date_to'])
        ]);

        return view('admin.logs', compact('logs', 'users', 'actions'));
    }

    public function users()
    {
        $users = User::withCount(['items', 'logs'])->latest()->paginate(10);
        LogService::log('admin_users_viewed', 'Admin viewed users list');
        return view('admin.users', compact('users'));
    }

    public function showUser(User $user)
    {
        $user->load(['items', 'logs']);
        LogService::log('admin_user_viewed', 'Admin viewed user details', ['user_id' => $user->id]);
        return view('admin.user-show', compact('user'));
    }

    public function editUser(User $user)
    {
        LogService::log('admin_user_edit_form', 'Admin accessed user edit form', ['user_id' => $user->id]);
        return view('admin.user-edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'nullable|boolean',
        ]);

        // Handle checkbox: if not present, it means unchecked (false)
        $isAdmin = $request->has('is_admin') ? (bool)$request->is_admin : false;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $isAdmin,
        ]);

        LogService::log('admin_user_updated', 'Admin updated user', [
            'user_id' => $user->id,
            'changes' => [
                'name' => $request->name,
                'email' => $request->email,
                'is_admin' => $isAdmin
            ]
        ]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    public function destroyUser(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users')->with('error', 'Cannot delete admin user!');
        }

        LogService::log('admin_user_deleted', 'Admin deleted user', ['user_id' => $user->id]);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    public function items()
    {
        $items = Item::with(['user', 'category'])->latest()->paginate(10);
        LogService::log('admin_items_viewed', 'Admin viewed items list');
        return view('admin.items', compact('items'));
    }

    public function successStories()
    {
        $stories = SuccessStory::with(['item', 'finder', 'owner'])->latest()->paginate(10);
        $claimedItems = Item::with('user')
            ->where('status', 'claimed')
            ->whereNotIn('id', SuccessStory::pluck('item_id'))
            ->get();

        return view('admin.success-stories', compact('stories', 'claimedItems'));
    }

    public function downloadSuccessStories()
    {
        $stories = SuccessStory::with(['item', 'finder', 'owner'])->get();

        LogService::log('admin_pdf_downloaded', 'Admin downloaded success stories PDF', [
            'stories_count' => $stories->count()
        ]);

        $pdf = Pdf::loadView('admin.success-stories-pdf', compact('stories'));
        return $pdf->download('success-stories.pdf');
    }

    public function createSuccessStory(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'finder_id' => 'required|exists:users,id',
            'owner_id' => 'required|exists:users,id',
            'story' => 'required|string',
        ]);

        $story = SuccessStory::create($request->all());
        Item::findOrFail($request->item_id)->update(['status' => 'claimed']);

        LogService::log('success_story_created', 'Admin created success story', [
            'story_id' => $story->id,
            'item_id' => $request->item_id
        ]);

        return redirect()->route('admin.success-stories')->with('success', 'Success story created!');
    }

    public function destroySuccessStory(SuccessStory $story)
    {
        LogService::log('success_story_deleted', 'Admin deleted success story', [
            'story_id' => $story->id,
            'item_id' => $story->item_id
        ]);

        $story->delete();

        return redirect()->route('admin.success-stories')->with('success', 'Success story deleted!');
    }
}