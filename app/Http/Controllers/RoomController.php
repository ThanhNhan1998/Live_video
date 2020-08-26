<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpJunior\LaravelVideoChat\Models\Conversation\Conversation;
use PhpJunior\LaravelVideoChat\Models\Group\Conversation\GroupConversation;
use DB;
use App\User;

class RoomController extends Controller
{
    public function home(){
        return view('spa'); 
    }

    public function currentUser(){
        $current_user = Auth::user();

        return response([
            'currentUser' => $current_user
        ]);
    }

    public function index(){
        $current_user = Auth::user();

        $groups = DB::table('group_conversations')
        ->join('group_users', 'group_conversations.id', '=', 'group_users.group_conversation_id')
        ->where('user_id', $current_user->id)
        ->get();

        return response([
            'groups' => $groups
        ]);
    }

    public function create(Request $request){
        $group = new GroupConversation();

        $group->name = $request->roomName;

        $group->save();

        $user = Auth::user();

        $group::find($group->id)->users()->save($user);

        return response([
            'group' => $group
        ]);
    }

    public function destroy($id){

        $group = GroupConversation::find($id);

        $group->delete();

        return response([
            'message' => 'Completed'
        ]);
    }

    public function edit($id, Request $request){
        $group = GroupConversation::find($id);

        $group->name = $request->name;

        $group->save();

        return response([
            'message' => 'Completed'
        ]);
    }

    public function show($id){
        $group = GroupConversation::find($id);

        return response([
            'group' => $group,
            'group_users' => $group->users
        ]);
    }

    public function invite($id, Request $request){
        $user = User::find($request->user_id);

        $group = GroupConversation::find($id);

        $group->users()->save($user);

        return response([
            'message' => 'Completed'
        ]);
    }

    public function userNotInRoom($id){
        $group = GroupConversation::find($id);

        foreach($group->users as $user){
            $data[] = $user->id;
        }

        $userNotInRoom = User::whereNotIn('id', $data)->get();

        return response([
            'userNotInRoom' => $userNotInRoom
        ]);
    }

    public function removeUser($id, $user_id){
        $group = GroupConversation::find($id);

        $group->users()->detach($user_id);

        return response([
            'message' => 'Completed'
        ]);
    }
}
