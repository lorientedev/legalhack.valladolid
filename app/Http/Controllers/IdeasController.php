<?php

namespace App\Http\Controllers;

use App\Ideas;
use App\RoomsModerator;
use Illuminate\Http\Request;

class IdeasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($room_id)
    {
        $ideas = Ideas::where('room_id', $room_id)->get();
        return $ideas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(['text' => 'string', 'room_id' => 'integer']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($room_id, Request $request)
    {
        $this->validate($request, [
            'text' => 'required|min:3'
        ]);

        $user = auth()->user();
        $idea = Ideas::create([
            'user_id' => $user->id,
            'text' => $request->text,
            'room_id' => $room_id
        ]);

        return response()->json(['idea', $idea]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $idea = Ideas::where('id', $request->id)->first();
        return response()->json(['idea' => $idea]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function edit(Ideas $ideas)
    {
        return response()->json(['id' => 'integer','approved' => 'boolean']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function update($room_id, Request $request)
    {
        $this->validate($request, [
            'approved' => 'required',
            'id' => 'required'
        ]);
        $user = auth()->user();
        $idea = Ideas::where('id', $request->id)->first();
        $room_moderators = RoomModerator::where('room_id', $idea->room_id)->first();

        if($user->id == $room_moderators->user_id){
            $idea = Ideas::where('id', $request->id)->update(['approved' => $request->approved, '']);
            return response()->json(["idea" => $idea]);
        }else{
            return response()->json(['error' => "you don't have permission to view this"]);
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
}
