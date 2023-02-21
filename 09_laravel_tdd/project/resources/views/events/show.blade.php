<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
<div id="popover" class="w-screen h-screen fixed hidden">
    <h2 class="text-center bg-amber-200 text-xl py-5 font-extrabold rounded-t-lg text-amber-700 border-4 border-amber-200">Are you sure?</h2>
    <div class="p-6 text-center bg-white border-4 border-amber-200 rounded-b-lg shadow-md sm:p-8">
        <p class="p-3 text-amber-700">
            Are you sure you want to delete this event?
        </p>
        <br>
            <div class="grid gap-6 mb-6 md:grid-cols-7">
                <!--Submit Button-->
                <a href="{{route('events.destroy',["id"=>$event->id])}}" class="col-start-3"><button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete this event</button></a>
                <button onclick="showPopover()" id="cancel_delete" class="items-center justify-center flex col-start-5 px-3 py-1 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Cancel</button>
            </div>
    </div>
</div>
@php($user = Auth::user())
    <div class="flex flex-col items-center">
        <!--Messages-->
        @if(isset($message))
            <div class="flex items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ml-3 text-sm font-normal">{{$message}}</div>
            </div>
        @endif
        <div class="grid gap-6 md:grid-cols-5 w-9/12 flex items-center justify-center">
            <!--Event info-->
            <div class="col-start-1 col-end-6">
                <div class="flex p-3 text-center bg-amber-200 border-4 border-amber-200 rounded-t-lg text-sm text-amber-700 border-4">
                    <div class="w-full p-5 flex grid md:grid-cols-3 text-left text-2xl py-2 font-extrabold text-amber-700">
                        <p>{{$event->title}}</p>
                        <p class="text-right col-start-2 col-end-4">
                            @php($show = true)
                            @php($going = false)
                            @if(!$user)
                                Login to join this event!
                                @php($show = false)
                            @else
                                @foreach($user->events as $check)
                                    @if(($check->pivot->event_id == $event->id))
                                        @php($going=true)
                                    @endif
                                @endforeach
                                {{$user->id == $event->creator_id ? "You're organizing this event!" : ""}}
                                {{(\App\Http\Controllers\EventController::numberOfAttendees($event->id) >= $event->size) && ($user->id != $event->creator_id) && !$going ? 'Sorry, this event is already full :(' : ''}}
                            @if((\App\Http\Controllers\EventController::numberOfAttendees($event->id) >= $event->size) || ($user->id == $event->creator_id))
                                    @php($show = false)
                                @endif
                                @if($user->admin)
                                    <button onclick="showPopover()" id='delete' class="px-5 py-3 text-amber-600 bg-amber-400 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete</button>
                                @endif
                            @endif

                            <a href="{{$going ?  route('events.show.cancel',["id"=>$event->id]) : route('events.show.update',['id' => $event->id]) }}"><button id="{{$going ? 'cancel' : 'join'}}" class="px-5 py-3 shadow {{$show || $going ? 'hover:bg-amber-400 hover:text-amber-100 text-amber-600 bg-amber-400' : 'text-amber-300 bg-amber-100'}} font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none" {{$show || $going ? '' : 'disabled'}}>{{$going ? 'Cancel' : 'Join this event!'}}</button></a>
                        </p>
                        </td>
                        </tr>
                        <div id="popover" class="w-screen h-screen top-1/4 left-0 fixed hidden">
                            <h2 class="text-center bg-amber-200 text-xl py-5 font-extrabold rounded-t-lg text-amber-700 border-4 border-amber-200">Are you sure?</h2>
                            <div class="p-6 text-center bg-white border-4 border-amber-200 rounded-b-lg shadow-md sm:p-8">
                                <p class="p-3 text-amber-700">
                                    Are you sure you want to delete this game?
                                </p>
                                <br>
                                <div class="grid gap-6 mb-6 md:grid-cols-7">
                                    <!--Submit Button-->
                                    <a href="{{ route('events.destroy', $event)}}" class="col-start-3"><button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete this game</button></a>
                                    <div onclick="showPopover()" class="items-center justify-center flex col-start-5 px-3 py-1 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Cancel</div></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6 text-center bg-white border-4 border-amber-200 rounded-b-lg text-sm text-green-800 border-40">
                    <div class="grid gap-6 md:grid-cols-3 text-left text-xl py-3 font-extrabold text-amber-600">
                        <p>City: {{$event->city}}</p>
                        <p>Address: {{$event->location}}</p>
                        <p>Number of players attending: {{\App\Http\Controllers\EventController::numberOfAttendees($event->id)}}/{{$event->size}}</p>
                        <p class="col-start-1 col-end-4 text-lg font-medium">Description: {{$event->description}}</p>
                    </div>
                </div>
        </div>
        <br>
    </div>
    <br>
</div>
@include('footer')
</body>
</html>
