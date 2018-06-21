<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function uploadEvent(Request $request) {
        $image = $request->image;
        $name = $image->getClientOriginalName();

        $event = new Event ([
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'dayStart'=>$request->input('dayStart'),
            'dayEnd'=>$request->input('dayEnd'),
            'timeStart'=>$request->input('timeStart'),
            'timeEnd'=>$request->input('timeEnd'),
            'image'=>$name,
        ]);

        $event->save();
        $image->move(public_path().'/events/', $name);

        return redirect()->back()->with('status', 'Evènement ajouté avec succès');
    }

    public function showUpload(){
        return view('events.upload_event');
    }

    public function listEvents(){
        $events = Event::all();
        return $events;
    }


public function participate($id, Request $request) {
        $event = Event::find($id);
        if($event->participants()->attach($request->user_id)) {
            return response()->json([
                "status" => "success"
            ]);
        } else {
            return response()->json([
                "status" => "success"
            ]);
        }

}

}
