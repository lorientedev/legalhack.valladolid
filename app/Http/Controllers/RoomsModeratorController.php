<?php

namespace App\Http\Controllers;

use App\RoomsModerator;
use Illuminate\Http\Request;

class RoomsModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = RoomsModerator::all();
        return $rooms;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(['room_id' => 'integer']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'room_id' => 'required',
            'user_id' => 'required'
        ]);

        $user = auth()->user();
        $roomModerator = RoomsModerator::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id
        ]);

        return response()->json(['room_moderator', $roomModerator]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function edit(Rooms $rooms)
    {
        return response()->json(['room_id' => 'integer']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rooms $rooms)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'room_id' => 'required',
        ]);
        $roomModerator = RoomsModerator::where('room_id', $request->room_id)->update(['user_id' => $request->user_id]);
        return response()->json(["room_moderator" => $roomModerator]);
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
