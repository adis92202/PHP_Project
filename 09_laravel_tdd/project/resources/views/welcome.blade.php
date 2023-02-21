<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
<div class="flex flex-col items-center">
    <!--Header-->
        <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Welcome {{$user = Auth::user()->username ?? "player"}}!</h2>
    <!--Four last games-->
    @if(count($games)!=0)
    <div class="w-7/12 grid gap-6 mb-6 md:grid-cols-2">
        @foreach($games as $game)
            <div class="w-50 h-50">
                <figure class="relative"><a id="game_{{$game->id}}" href="{{route('library.show', $game->id)}}">
                        @if(!$game->image)
                            <img src="{{asset('images/no-image.png')}}" alt="Game pic" class="w-96 h-96 object-cover rounded-lg opacity-50 shadow transition-all duration-300 hover:opacity-75" />
                        @elseif(str_starts_with($game->image, 'seeder'))
                            <img src="{{asset('images/' . $game->image)}}" alt="Game pic" class="w-96 h-96 object-cover rounded-lg opacity-50 shadow transition-all duration-300 hover:opacity-75" />
                        @else
                            <div>
                                <img src="{{ url('storage/images/'.$game->image) }}" alt="Game pic" class="w-96 h-96 object-cover rounded-lg opacity-50 shadow transition-all duration-300 hover:opacity-75" />
                            </div>
                        @endif
                        <figcaption class="absolute top-0 px-4 text-lg text-gray-900 font-semibold bg-amber-100 rounded-lg opacity-90">
                            <p class="text-2xl">Title: {{$game->title}}</p>
                            <p class="text-xl">Category: {{$game->category}}</p>
                        </figcaption>
                    </a>
                </figure>
            </div>
        @endforeach
    </div>
    @else
        <h1 class="text-left text-2xl py-5 font-extrabold text-lime-600">No games added yet! Be the first one to add!</h1>
    @endif
    <!--Card with event-->
    @if($event)
        <div class="fixed right-0 w-1/4 p-6 bg-white border border-lime-200 rounded-lg shadow-md bg-amber-100">
            <h5 class="mb-2 text-3xl font-bold tracking-tight text-amber-700">This event starts soon!</h5>
            <br>
            <p class="text-2xl text-amber-600 font-bold">Event: {{$event->title}} </p>
            <p class="text-xl text-amber-600 font-semibold">City: {{$event->city}} </p>
            <p class="text-xl text-amber-600 font-semibold">Date: {{$event->date}} </p>
            <p class="text-xl text-amber-600 font-semibold">Time: {{$event->time}} </p>
            <br>
            <p class="text-lg text-amber-600">Description: {{$event->description}} </p>
            <br>
            <a href="{{ route('events.show', $event->id) }}"><button class="float-right px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Check it out!</button></a>
        </div>
    @else
        <div class="fixed right-0 w-1/4 p-6 bg-white border border-lime-200 rounded-lg shadow-md bg-amber-100">
            <h5 class="mb-2 text-3xl font-bold tracking-tight text-amber-700">No events planned :(</h5>
        </div>
    @endif
</div>

@include('footer')
</body>
</html>
