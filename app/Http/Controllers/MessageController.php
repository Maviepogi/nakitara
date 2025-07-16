<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Item;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    public function index()
    {
        $messages = Message::where('receiver_id', Auth::id())
            ->with(['sender', 'item'])
            ->latest()
            ->paginate(10);

        return view('messages.index', compact('messages'));
    }

    public function create(Item $item)
    {
        return view('messages.create', compact('item'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'message' => 'required|string',
        ]);

        $item = Item::findOrFail($request->item_id);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $item->user_id,
            'item_id' => $request->item_id,
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
        $message->update(['read' => true]);
        $message->load(['sender', 'item']);
        return view('messages.show', compact('message'));
    }
}