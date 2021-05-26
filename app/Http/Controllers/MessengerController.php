<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\Messenger\LoadRoomRequest;
use App\Http\Requests\Messenger\MessageRequest;
use App\Http\Resources\Chat\MessageResource;
use App\Http\Resources\Chat\RoomResource;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $rooms = ChatRoom::with('users')->whereHas('users', function ($query) use ($user) {
            return $query->where('user_id', $user->id);
        })->get();

        $role = $user->isDoctor() ? Role::USER : Role::DOCTOR;
        $userId = $user->id;

        return view('pages.messenger.index', compact('rooms', 'role', 'userId'));
    }

    public function getMessages($roomId)
    {
        // check access
        $messages = Message::where('chat_name', $roomId)->with('user')->get();

        return response()->json(MessageResource::collection($messages));
    }

    public function sendMessage(MessageRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        $message = $user->messages()->create($validated);

        $messageBody = [
            'chat_name' => $message->chat_name,
            'user' => $user->full_name,
            'message' => $message->body,
        ];

        broadcast(new MessageSent($messageBody, $message->chat_name, $user->id))->toOthers();

        return response()->json([
            'data' => $message
        ]);
    }

    public function loadRoom(LoadRoomRequest $request)
    {
        $validated = $request->validated();
        $usersId = array_values($validated);
        $userOwner = Auth::user();

        $roomName = implode('', $usersId);
        $users = User::whereIn('id', $usersId)->get();
        $room = ChatRoom::firstOrCreate(['name' => $roomName]);
        $interlocutor = $users->where('id', '!=', $userOwner->id)->first();

        foreach ($users as $user) {
            $user->chatRooms()->syncWithoutDetaching($room->id);
        }

        return response()->json([
            'room_name' => $room->name,
            'interlocutor' => $interlocutor->full_name,
            'interlocutor_id' => $interlocutor->id,
        ]);
    }

    public function getRoom($id)
    {
        $room = ChatRoom::where('name', $id)->firstOrFail();
        return response()->json(new RoomResource($room));
    }
}
