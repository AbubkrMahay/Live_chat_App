<?php

namespace App\Http\Controllers;

use App\Models\Group;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function create(Request $request)
    {
        $group = Group::create(['name' => $request->name]);
        $group->users()->attach($request->user_ids); // Add users to the group
        return response()->json($group);
    }

    public function addUser(Request $request, Group $group)
    {
        $group->users()->attach($request->user_id);
        return redirect()->back()->with('status', 'Added to Group!');
    }

    public function removeUser(Request $request, Group $group)
    {
        $group->users()->detach($request->user_id);
        return response()->json('User removed from group.');
    }
}
