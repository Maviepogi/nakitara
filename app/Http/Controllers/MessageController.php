<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Item;
use App\Models\UserLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('viewAny', Message::class);

        $messages = Message::where(function ($query) {
                $query->where('receiver_id', Auth::id())
                      ->orWhere('sender_id', Auth::id());
            })
            ->with(['sender', 'receiver', 'item.category'])
            ->latest()
            ->paginate(10);

        return view('messages.index', compact('messages'));
    }

    public function create(Item $item)
    {
        $this->authorize('create', Message::class);

        if ($item->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot message yourself.');
        }

        $categories = Category::all();

        return view('messages.create', compact('item', 'categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Message::class);

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'message' => 'required|string|min:10|max:1000',
        ]);

        $item = Item::findOrFail($request->item_id);

        if ($item->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot message yourself.');
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $item->user_id,
            'item_id' => $item->id,
            'message' => $request->message,
        ]);

        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'message_sent',
            'description' => 'Sent message about item: ' . $item->title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'data' => ['item_id' => $item->id]
        ]);

        return redirect()->route('messages.index')->with('success', 'Message sent successfully!');
    }

    public function show(Message $message)
    {
        $this->authorize('view', $message);

        if (Auth::id() === $message->receiver_id && !$message->read) {
            $message->update(['read' => true]);
        }

        $message->load(['sender', 'receiver', 'item.category']);

        return view('messages.show', compact('message'));
    }

    public function getUnreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
            ->where('read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
