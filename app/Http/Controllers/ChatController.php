<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $authId = Auth::id();
    
        $users = \App\Models\User::where('id', '!=', $authId)->get();
    
        // Hitung unread messages per user dengan Eloquent Collection
        $unreadCounts = \App\Models\Message::unreadByUser($authId)->get()
            ->groupBy('from_user_id')
            ->map(function ($messages) {
                return $messages->count();
            });
    
        return view('chat.index', compact('users', 'unreadCounts'));
    }
    
    
    public function show($userId)
    {
        $authId = Auth::id();
    
        // Update semua pesan dari $userId ke user yang login menjadi 'sudah dibaca'
        Message::where('from_user_id', $userId)
            ->where('to_user_id', $authId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    
        // Ambil data user lawan chat
        $user = \App\Models\User::findOrFail($userId);
    
        // Ambil semua pesan antara user login dan user tersebut
        $messages = Message::where(function ($q) use ($userId, $authId) {
            $q->where('from_user_id', $authId)->where('to_user_id', $userId);
        })->orWhere(function ($q) use ($userId, $authId) {
            $q->where('from_user_id', $userId)->where('to_user_id', $authId);
        })->orderBy('created_at')->get();
    
        return view('chat.show', compact('user', 'messages'));
    }
    public function markAsRead($userId)
{
    $authId = Auth::id();

    Message::where('from_user_id', $userId)
        ->where('to_user_id', $authId)
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return response()->json(['success' => true]);
}
    

    public function sendMessage(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'message' => $request->message,
        ]);

        // Broadcast event ke user tujuan dan pengirim
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'Message sent!', 'message' => $message]);
    }

    // Method baru untuk polling pesan terbaru
    public function fetchMessages($userId)
    {
        $messages = Message::where(function ($q) use ($userId) {
            $q->where('from_user_id', Auth::id())->where('to_user_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('from_user_id', $userId)->where('to_user_id', Auth::id());
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }
}
