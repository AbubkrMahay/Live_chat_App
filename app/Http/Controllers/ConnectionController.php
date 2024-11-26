<?php

namespace App\Http\Controllers;
use App\Models\Connection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function accept($id)
    {
        //dd($id);
        $connection = Connection::findOrFail($id);
        
        // Update the status to 'accepted'
        $connection->status = 'accepted';
        $connection->save();

        return redirect()->back()->with('status', 'Connection Accepted!');
    }
    public function reject($id)
    {
        $connection = Connection::find($id);
        if ($connection) {
            $connection->status = 'rejected'; // Update the status to rejected
            $connection->save(); // Save the changes
        }

        return redirect()->back()->with('status', 'Connection rejected!');
    }
    public function send($rec_id)
    {
        $user = Auth::user();
        //dd($user->id);
        DB::table('connections')->insert([
            'user_id' => $user->id,
            'connected_user_id' => $rec_id,
            'status' => "pending",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return redirect()->back()->with('status', 'Connection rejected!');
        
    }
}
