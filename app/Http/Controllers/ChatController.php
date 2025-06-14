<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Send message
    public function send(Request $request)
    {
        $chat = Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($chat))->toOthers();

        return response()->json(['success' => true]);
    }

// Get users who messaged the authenticated vendor
    public function getSenders()
    {
        $vendorId = auth()->id();

        $senders = Chat::where('receiver_id', $vendorId)
            ->with('sender')
            ->groupBy('sender_id')
            ->select('sender_id')
            ->get();

        return response()->json($senders);
    }

    // Get messages between two users
    public function getMessages($userId)
    {
        $authId = auth()->id();

        $messages = Chat::where(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $authId)->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $authId);
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }

    public function showVendors()
    {
        $vendors = User::where('role_id', '2')->get(); // assuming 'role' column exists
        return view('chat.vendors', compact('vendors'));
    }

    public function chatWithVendor(User $vendor)
    {
        $authId = auth()->id();

        $messages = Chat::where(function ($q) use ($authId, $vendor) {
            $q->where('sender_id', $authId)->where('receiver_id', $vendor->id);
        })->orWhere(function ($q) use ($authId, $vendor) {
            $q->where('sender_id', $vendor->id)->where('receiver_id', $authId);
        })->with('sender')->get();

        return view('chat.chat', compact('vendor', 'messages'));
    }


    // vendor chat with users functions started
    public function users()
    {
        $vendorId = Auth::id();

        // Get unique users who sent messages to this vendor
        $userIds = Chat::where('receiver_id', $vendorId)
            ->pluck('sender_id')
            ->unique();

        $users = User::whereIn('id', $userIds)->get();

        return view('panel.vendor.chat.users', compact('users'));
    }

    public function chatWithUser($userId)
    {
        $vendorId = Auth::id();

        $messages = Chat::where(function($query) use ($vendorId, $userId) {
            $query->where('sender_id', $vendorId)->where('receiver_id', $userId);
        })->orWhere(function($query) use ($vendorId, $userId) {
            $query->where('sender_id', $userId)->where('receiver_id', $vendorId);
        })->orderBy('created_at', 'asc')->get();

        $user = User::findOrFail($userId);

        return view('panel.vendor.chat.chat', compact('messages', 'user'));
    }

    public function sendVendor(Request $request)
    {
        $chat = Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        broadcast(new \App\Events\MessageSent($chat))->toOthers();

        return response()->json(['success' => true]);
    }

}
