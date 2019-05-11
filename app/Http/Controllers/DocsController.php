<?php

namespace App\Http\Controllers;

use App\Docs;
use App\Rooms;
use Illuminate\Http\Request;

class DocsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($room_id, Request $request)
    {
        if(isset($request->version)){
            print("here");
            $docs = Docs::where('room_id', $room_id)->where('version', $request->version)->first();
        }else{
            $docs = Docs::where('room_id', $room_id)->orderBy('version', 'desc')->first();
        }
        
        return $docs;
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
        $room = Rooms::where('id', $room_id)->first();

        if( $user->id == $room->creator){
            $doc = Docs::create([
                'editor' => $user->id,
                'text' => $request->text,
                'room_id' => $room_id
            ]);
    
            return response()->json(['doc', $doc]);
        }else{
            return response()->json(['error', "you don't have permissions"]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function show($room_id, Request $request)
    {
        $doc = Docs::where('room_id', $room_id)->orderBy('version', 'desc')->first();
        return response()->json(['idea' => $doc]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function edit(Docs $docs)
    {
        return response()->json(['room_id' => 'integer','text' => 'string']);
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
            'text' => 'required'
        ]);
        $user = auth()->user();
        $room = Rooms::where('id', $room_id)->first();
        
        if( $user->id == $room->creator){
            $doc_past = Docs::where('room_id', $room_id)->orderBy('version', 'desc')->first();
            $doc = Docs::create([
                'editor' => $user->id,
                'text' => $request->text,
                'room_id' => $room_id,
                'version' => $doc_past->version+1
            ]);
            return response()->json(["doc" => $doc]);
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
