<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
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
    <!--Header-->
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Events</h2>
    <!--Info if empty-->
    @if($events->isEmpty())
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">No events planned yet! Be the first one!</h1>
    @endif
    <div class="w-10/12 grid gap-6 mb-6 md:grid-cols-3">
        @php($i=0)
        @foreach($events as $event)
            <figure class="relative"><a id="first_image" href="{{ route('events.show', $event->id) }}">
                    @if($i%3 == 0)
                        <img src="{{asset('images/event1.jpg')}}" alt="Event pic" class="max-w-full h-auto rounded-lg opacity-50 shadow transition-all duration-300 hover:opacity-75"/>
                        <figcaption class="absolute top-0 px-4 text-lg text-amber-700 font-semibold bg-amber-100 rounded-lg opacity-90">
                        @endif
                    @if($i%3 == 1)
                            <img src="{{asset('images/event2.jpg')}}" alt="Event pic" class="max-w-full h-auto rounded-lg opacity-50 shadow transition-all duration-300 hover:opacity-75"/>
                                <figcaption class="absolute bottom-1.5 px-4 text-lg text-amber-700 font-semibold bg-amber-100 rounded-lg opacity-90">
                                @endif
                        @if($i%3 == 2)
                        <img src="{{asset('images/event3.png')}}" alt="Event pic" class="max-w-full h-auto bg-amber-100 rounded-lg opacity-50 shadow transition-all duration-300 hover:opacity-75"/>
                                        <figcaption class="absolute top-0 px-4 text-lg text-amber-700 font-semibold bg-amber-100 rounded-lg opacity-90">
                                        @endif
                    <p class="text-2xl">Event: {{$event->title}}</p>
                    <p class="text-xl">City: {{$event->city}}</p>
                    <p class="text-xl">Date: {{$event->date}}</p>
                    <p class="text-xl">Time: {{$event->time}}</p>
                </figcaption>
                                </figcaption>
                        </figcaption>
                </a>
            </figure>
            @php($i++)
        @endforeach
    </div>

    <!--Card for creation-->
    <div class="fixed right-0 w-44 p-6 bg-white border border-lime-200 rounded-lg shadow-md">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-lime-700">Want to make an event?</h5>
        <!--Create button-->
        <a href="{{ route('events.create') }}"><button class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Add new event here!</button></a>
    </div>
</div>

@include('footer')
</body>
</html>
