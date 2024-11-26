<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Connection;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $groupName = null;
        $user = Auth::user();
        $friends = Connection::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('connected_user_id', $user->id);
        })
            ->where('status', 'accepted')
            ->get();

        $pendingfriends = Connection::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('connected_user_id', $user->id);
        })
            ->where('status', 'pending')
            ->get();
        $friendUsers = [];
        $pendingRequests = [];
        $messages = [];

        foreach ($friends as $friend) {
            $friendId = $friend->user_id == $user->id ? $friend->connected_user_id : $friend->user_id;
            $friendUser = User::find($friendId); // Fetch user details
            if ($friendUser) {
                //dd($friendUser);
                $friendUsers[] = $friendUser;
            }
        }
        foreach ($pendingfriends as $pendingfriend) {
            // Determine the friend ID based on who sent the request
            $friendId = $pendingfriend->user_id == $user->id ? $pendingfriend->connected_user_id : $pendingfriend->user_id;

            // Fetch the user details for the determined friend ID
            $friendDetails = User::find($friendId);

            // Check if the user exists before adding to the pending requests array
            if ($friendDetails) {
                $pendingRequests[] = [
                    'connection_id' => $pendingfriend->id, // Store the connection ID
                    'user' => $friendDetails // Store the user details
                ];
            }
        }
        $allUsers = User::all();
        $groups = Group::all();
        $frndname = null;
        $groupUsers = Group::with('users')->get();
        //dd($friends->all());
        return view('home', [
            'messages' => $messages,
            'user' => $user,
            'friendUsers' => $friendUsers,
            'pendingRequests' => $pendingRequests,
            'frndname' => $frndname,
            'allusers' => $allUsers,
            'pendingfriends' => $pendingfriends,
            'allGroups' => $groups,
            'groupUser' => $groupUsers,
            'groupName' => $groupName,
        ]);
    }
    public function showHome(Request $request, $friendId)
    {
        $frnd = User::find($friendId);
        $frndname = $frnd->name;
        $receiver_id = $friendId;
        $groupName = null;

        $user = Auth::user();
        $friends = Connection::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('connected_user_id', $user->id);
        })
            ->where('status', 'accepted')
            ->get();

        $pendingfriends = Connection::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('connected_user_id', $user->id);
        })
            ->where('status', 'pending')
            ->get();
        $friendUsers = [];
        $pendingRequests = [];
        //$messages = [];

        foreach ($friends as $friend) {
            $friendId = $friend->user_id == $user->id ? $friend->connected_user_id : $friend->user_id;
            $friendUser = User::find($friendId); // Fetch user details
            if ($friendUser) {
                //dd($friendUser);
                $friendUsers[] = $friendUser;
            }
        }
        foreach ($pendingfriends as $pendingfriend) {
            // Determine the friend ID based on who sent the request
            $friendId = $pendingfriend->user_id == $user->id ? $pendingfriend->connected_user_id : $pendingfriend->user_id;

            // Fetch the user details for the determined friend ID
            $friendDetails = User::find($friendId);

            // Check if the user exists before adding to the pending requests array
            if ($friendDetails) {
                $pendingRequests[] = [
                    'connection_id' => $pendingfriend->id, // Store the connection ID
                    'user' => $friendDetails // Store the user details
                ];
            }
        }
        $messages = Message::where(function ($query) use ($user, $receiver_id) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $receiver_id)
                ->orWhere('sender_id', $receiver_id)
                ->where('receiver_id', $user->id);
        })
            ->orderBy('created_at', 'asc')
            ->get();
        $allUsers = User::all();
        $groups = Group::all();
        $groupUsers = Group::with('users')->get();
        //dd($receiver_id);
        return view('home', [
            'receiver_id' => $receiver_id,
            'messages' => $messages,
            'user' => $user,
            'friendUsers' => $friendUsers,
            'pendingRequests' => $pendingRequests,
            'frndname' => $frndname,
            'allusers' => $allUsers,
            'pendingfriends' => $pendingfriends,
            'allGroups' => $groups,
            'groupUser' => $groupUsers,
            'groupName' => $groupName,
        ]);
    }

    public function groupChat($groupId)
    {
        // $groupName = $group->name;
        $group = Group::find($groupId);
        $groupName = $group->name;
        $frndname = null;
        $user = Auth::user();
        $friends = Connection::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('connected_user_id', $user->id);
        })
            ->where('status', 'accepted')
            ->get();

        $pendingfriends = Connection::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('connected_user_id', $user->id);
        })
            ->where('status', 'pending')
            ->get();
        $friendUsers = [];
        $pendingRequests = [];
        //$messages = [];

        foreach ($friends as $friend) {
            $friendId = $friend->user_id == $user->id ? $friend->connected_user_id : $friend->user_id;
            $friendUser = User::find($friendId); // Fetch user details
            if ($friendUser) {
                //dd($friendUser);
                $friendUsers[] = $friendUser;
            }
        }
        foreach ($pendingfriends as $pendingfriend) {
            // Determine the friend ID based on who sent the request
            $friendId = $pendingfriend->user_id == $user->id ? $pendingfriend->connected_user_id : $pendingfriend->user_id;

            // Fetch the user details for the determined friend ID
            $friendDetails = User::find($friendId);

            // Check if the user exists before adding to the pending requests array
            if ($friendDetails) {
                $pendingRequests[] = [
                    'connection_id' => $pendingfriend->id, // Store the connection ID
                    'user' => $friendDetails // Store the user details
                ];
            }
        }
        $messages = $group->messages()->orderBy('created_at', 'asc')->get();
        $allUsers = User::all();
        $groups = Group::all();
        $groupUsers = Group::with('users')->get();
        //dd($receiver_id);
        return view('home', [
            'messages' => $messages,
            'user' => $user,
            'friendUsers' => $friendUsers,
            'pendingRequests' => $pendingRequests,
            'allusers' => $allUsers,
            'pendingfriends' => $pendingfriends,
            'allGroups' => $groups,
            'groupUser' => $groupUsers,
            'groupName' => $groupName,
            'frndname' => $frndname,
            'groupId' => $groupId,
        ]);
    }
}
