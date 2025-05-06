<?php
Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
    return (int) $user->id === (int) $receiverId || $user->id == Chat::find($receiverId)?->sender_id;
});
