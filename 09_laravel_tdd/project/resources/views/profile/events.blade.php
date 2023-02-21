<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
<div class="flex flex-col items-center">
    <!--Header-->
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Your events</h2>
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
    @include('profile.profile_menu')
    @if($your_events->isEmpty())
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">You're not organizing any events right now!</h1>
    @else
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">You're organizing:</h1>
    @endif
    @foreach($your_events as $your_event)
        <!--Event START-->
        <h2 class="w-9/12 text-left text-2xl py-5 font-extrabold {{$your_event->accepted ? 'text-lime-600' : 'text-amber-700'}}">{{$your_event->accepted ? 'Accepted' : 'Waiting'}}</h2>
        <div class="flex w-9/12 p-3 text-center rounded-t-lg text-sm border-4 {{$your_event->accepted ? 'bg-lime-200 border-lime-200 text-lime-600' : 'bg-amber-200 border-amber-200 text-amber-600'}}">
            <div class="w-full p-5 grid gap-6 md:grid-cols-2 text-left text-2xl py-3 font-extrabold">
                <p>{{$your_event->title}}</p>
                <p class="text-right">
                    <a href="{{route('events.show',$your_event)}}"><button class="px-5 py-3 {{$your_event->accepted ? 'text-lime-600 bg-lime-300 hover:bg-lime-400 hover:text-lime-100' : 'text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100'}} font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">More</button></a>
                    <a href="{{route('events.edit',$your_event)}}"><button class="px-5 py-3 {{$your_event->accepted ? 'text-lime-600 bg-lime-300 hover:bg-lime-400 hover:text-lime-100' : 'text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100'}} font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Edit</button></a>
                    <button onclick="showPopoverID({{$your_event->id}})" id="delete_{{$your_event->id}}" class="px-5 py-3 {{$your_event->accepted ? 'text-lime-600 bg-lime-300 hover:bg-lime-400 hover:text-lime-100' : 'text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100'}} font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete</button>
                </p>
            </div>
        </div>
        <div class="w-9/12 p-6 text-center bg-white border-4 rounded-b-lg text-sm {{$your_event->accepted ? 'border-lime-200 text-lime-600' : 'border-amber-200 text-amber-600'}}">
            <div class="grid gap-6 md:grid-cols-4 text-left text-xl py-3 font-extrabold">
                <p>City: {{$your_event->city}}</p>
                <p>Address: {{$your_event->location}}</p>
                <p>Number of players attending: {{\App\Http\Controllers\EventController::numberOfAttendees($your_event->id)}}/{{$your_event->size}}</p>
                <p class="col-start-1 col-end-4 text-lg font-medium">Description: {{$your_event->description}}</p>
            </div>
        </div>
        <!--Event END-->
        <br>
        <div id="popover_{{$your_event->id}}" class="w-screen h-screen top-1/4 left-0 fixed hidden">
            <h2 class="text-center bg-amber-200 text-xl py-5 font-extrabold rounded-t-lg text-amber-700 border-4 border-amber-200">Are you sure?</h2>
            <div class="p-6 text-center bg-white border-4 border-amber-200 rounded-b-lg shadow-md sm:p-8">
                <p class="p-3 text-amber-700">
                    Are you sure you want to delete your event?
                </p>
                <br>
                <div class="grid gap-6 mb-6 md:grid-cols-7">
                    <!--Submit Button-->
                    <a href="{{route('events.destroy',["id" => $your_event->id])}}" id="Delete_yes_{{$your_event->id}}" class="col-start-3"><button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete your event</button></a>
                    <button id='cancel_delete' onclick="showPopoverID({{$your_event->id}})" class="items-center justify-center flex col-start-5 px-3 py-1 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Cancel</button></a>
                </div>
            </div>
        </div>
    @endforeach

    @if($part_events->isEmpty())
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">You're not signed up for any events right now!</h1>
    @else
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">You're signed up for:</h1>
    @endif
    @foreach($part_events as $part_event)
        <!--Event START-->
        <div class="flex w-9/12 p-3 text-center rounded-t-lg text-sm border-4 bg-lime-200 border-lime-200 text-lime-600">
            <div class="w-full p-5 grid gap-6 md:grid-cols-2 text-left text-2xl py-3 font-extrabold">
                <p>{{$part_event->title}}</p>
                <p class="text-right">
                    <a href="{{route('events.show', $part_event)}}"><button class="px-5 py-3 text-lime-600 bg-lime-300 hover:bg-lime-400 hover:text-lime-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">More</button></a>
                    <button id="cancel_{{$part_event->id}}" onclick="showPopover_cancelID({{$part_event->id}})" class="px-5 py-3 text-lime-600 bg-lime-300 hover:bg-lime-400 hover:text-lime-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Cancel</button>
                </p>
            </div>
        </div>
        <div class="w-9/12 p-6 text-center bg-white border-4 rounded-b-lg text-sm border-lime-200 text-lime-600">
            <div class="grid gap-6 md:grid-cols-4 text-left text-xl py-3 font-extrabold">
                <p>City: {{$part_event->city}}</p>
                <p>Address: {{$part_event->location}}</p>
                <p>Number of players attending: {{\App\Http\Controllers\EventController::numberOfAttendees($part_event->id)}}/{{$part_event->size}}</p>
                <p class="col-start-1 col-end-4 text-lg font-medium">Description: {{$part_event->description}}</p>
            </div>
        </div>
        <!--Event END-->
        <br>
        <div id="popover_cancel_{{$part_event->id}}" class="w-screen h-screen top-1/4 left-0 fixed hidden">
            <h2 class="text-center bg-amber-200 text-xl py-5 font-extrabold rounded-t-lg text-amber-700 border-4 border-amber-200">Are you sure?</h2>
            <div class="p-6 text-center bg-white border-4 border-amber-200 rounded-b-lg shadow-md sm:p-8">
                <p class="p-3 text-amber-700">
                    Are you sure you want to cancel attending this event?
                </p>
                <br>
                <div class="grid gap-6 mb-6 md:grid-cols-7">
                    <!--Submit Button-->
                    <a href="{{route('events.show.cancel',["id"=>$part_event->id])}}" class="col-start-3"><button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">I'm not going</button></a>
                    <div onclick="showPopover_cancelID({{$part_event->id}})" id="going" class="items-center justify-center flex col-start-5 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto text-center focus:outline-none">I'm going</div></a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@include('footer')
</body>
</html>
