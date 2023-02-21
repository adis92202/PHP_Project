<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')

<div class="flex flex-col items-center">
    <!--Errors-->
    @if(!$errors->isEmpty())
        <div class="p-4 mb-4 text-sm text-amber-800 bg-amber-400 rounded-lg" role="alert">
            <ul class="mt-1.5 ml-4 list-disc list-inside">
                @foreach($errors->get('title') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('city') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('location') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('description') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('date') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('time') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('size') as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!--Header-->
    <h2 class="w-1/2 text-center bg-lime-200 text-4xl py-5 font-extrabold rounded-t-lg text-lime-700 border-4 border-lime-200">Edit your event</h2>
    <div class="w-1/2 p-6 text-center bg-white border-4 border-lime-200 rounded-b-lg shadow-md sm:p-8">
        <!--Form START-->
        <form method="POST" action="{{ route('events.update_event',["id"=>$event->id]) }}">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <!--ATTENTION Adding Image-->
                <!--Title-->
                <div>
                    <label for="event_title" class="block mb-2 text-sm font-medium text-gray-900">Name of event</label>
                    <input type="text" id="event_title" name="event_title" value="{{$event->title}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--City-->
                <div>
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900">City</label>
                    <input type="text" id="city" name="city" value="{{$event->city}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Address/Location-->
                <div>
                    <label for="location" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
                    <input type="text" id="location" name="location" value="{{$event->location}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-1">
                <!--Description-->
                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Tell us what are we going to play!</label>
                    <textarea type="text" id="description" name="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">{!!$event->description!!}</textarea>
                </div>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <!--Date-->
                <div>
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                    <input type="date" id="date" name="date" value="{{$event->date}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Time-->
                <div>
                    <label for="time" class="block mb-2 text-sm font-medium text-gray-900">Time</label>
                    <input type="time" id="time" name="time" value="{{$event->time}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Size-->
                <div>
                    <label for="size" class="block mb-2 text-sm font-medium text-gray-900">How many people can come?</label>
                    <input type="number" id="size" name="size" value="{{$event->size}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <!--Submit Button-->
            <button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Edit event</button>
            <!--Form END-->
        </form>
    </div>
</div>

@include('footer')
</body>
</html>
