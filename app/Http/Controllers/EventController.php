<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use Amranidev\Ajaxis\Ajaxis;
use URL;

/**
 * Class EventController.
 *
 * @author  The scaffold-interface created at 2017-01-24 02:17:15am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index - event';
        $events = Event::paginate(6);
        return view('event.index',compact('events','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - event';
        
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event();

        
        $event->name = $request->name;

        
        $event->startDateTime = $request->startDateTime;

        
        $event->endDateTime = $request->endDateTime;

        
        $event->description = $request->description;

        
        $event->save();

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'A new event has been created !!']);

        return redirect('event');
    }

    /**
     * Display the specified resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $title = 'Show - event';

        if($request->ajax())
        {
            return URL::to('event/'.$id);
        }

        $event = Event::findOrfail($id);
        return view('event.show',compact('title','event'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - event';
        if($request->ajax())
        {
            return URL::to('event/'. $id . '/edit');
        }

        
        $event = Event::findOrfail($id);
        return view('event.edit',compact('title','event'  ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $event = Event::findOrfail($id);
    	
        $event->name = $request->name;
        
        $event->startDateTime = $request->startDateTime;
        
        $event->endDateTime = $request->endDateTime;
        
        $event->description = $request->description;
        
        
        $event->save();

        return redirect('event');
    }

    /**
     * Delete confirmation message by Ajaxis.
     *
     * @link      https://github.com/amranidev/ajaxis
     * @param    \Illuminate\Http\Request  $request
     * @return  String
     */
    public function DeleteMsg($id,Request $request)
    {
        $msg = Ajaxis::BtDeleting('Warning!!','Would you like to remove This?','/event/'. $id . '/delete');

        if($request->ajax())
        {
            return $msg;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     	$event = Event::findOrfail($id);
     	$event->delete();
        return URL::to('event');
    }
}