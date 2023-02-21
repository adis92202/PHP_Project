<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
<div class="flex flex-col items-center">
    <!--Header-->
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Awaiting admin acceptance</h2>
    @include('profile.profile_menu')

    <!--Games-->
    @if($games->isEmpty())
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">No games to accept</h1>
    @else
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">Games:</h1>
    @endif
    @foreach($games as $game)
        <!--Game START-->
        <div class="flex w-9/12 p-3 text-center rounded-t-lg text-sm border-4 bg-amber-200 border-amber-200 text-amber-600">
            <div class="w-full p-5 grid gap-6 md:grid-cols-4 text-left text-2xl py-3 font-extrabold">
                @if(!$game->image)
                    <img src="{{asset('images/no-image.png')}}" class="h-32 w-32 object-cover mr-3" alt="Logo" />
                @elseif(str_starts_with($game->image, 'seeder'))
                    <img src="{{asset('images/' . $game->image)}}" class="h-32 w-32 object-cover mr-3" alt="Logo" />
                @else
                    <img src="{{ url('storage/images/'.$game->image) }}" class="h-32 w-32 object-cover mr-3" alt="Logo" />
                @endif
                <p>Game: {{$game->title}}</p>
                <p>Year: {{$game->year}}</p>
                <p class="text-right">
                    <a href="{{route('profile.acceptance.accept',['element'=> "Game", 'id'=>$game->id])}}" id="accept_game{{$game->id}}"><button class="px-5 py-3 text-lime-600 bg-lime-300 hover:bg-lime-400 hover:text-lime-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Accept</button></a>
                    <a href="{{route('profile.acceptance.decline',['element'=> "Game", 'id'=>$game->id])}}" id="decline_game{{$game->id}}"><button class="px-5 py-3 text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Decline</button></a>
                </p>
            </div>
        </div>
        <div class="w-9/12 p-6 text-center bg-white border-4 rounded-b-lg text-sm border-amber-200 text-amber-600">
            <div class="grid gap-6 md:grid-cols-4 text-left text-xl py-3 font-extrabold">
                <p>Category: {{$game->category}}</p>
                <p>Time: {{$game->time}}</p>
                <p>Players: {{$game->players}}</p>
                <p class="col-start-1 col-end-4 text-lg font-medium">Description: {{$game->description}}</p>
            </div>
        </div>
        <!--Game END-->
        <br>
    @endforeach

    <!--Events-->
    @if($events->isEmpty())
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">No events to accept</h1>
    @else
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">Events:</h1>
    @endif
    @foreach($events as $event)
        <!--Event START-->
        <div class="flex w-9/12 p-3 text-center rounded-t-lg text-sm border-4 bg-amber-200 border-amber-200 text-amber-600">
            <div class="w-full p-5 grid gap-6 md:grid-cols-2 text-left text-2xl py-3 font-extrabold">
                <p>{{$event->title}}</p>
                <p class="text-right">
                    <a href="{{route('profile.acceptance.accept',['element'=> "Event", 'id'=>$event->id])}}" id="accept_event{{$event->id}}"><button class="px-5 py-3 text-lime-600 bg-lime-300 hover:bg-lime-400 hover:text-lime-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Accept</button></a>
                    <a href="{{route('profile.acceptance.decline',['element'=> "Event", 'id'=>$event->id])}}" id="decline_event{{$event->id}}"><button class="px-5 py-3 text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Decline</button></a>
                </p>
            </div>
        </div>
        <div class="w-9/12 p-6 text-center bg-white border-4 rounded-b-lg text-sm border-amber-200 text-amber-600">
            <div class="grid gap-6 md:grid-cols-4 text-left text-xl py-3 font-extrabold">
                <p>City: {{$event->city}}</p>
                <p>Address: {{$event->location}}</p>
                <p>Number of players attending: {{\App\Http\Controllers\EventController::numberOfAttendees($event->id)}}/{{$event->size}}</p>
                <p class="col-start-1 col-end-4 text-lg font-medium">Description: {{$event->description}}</p>
            </div>
        </div>
        <!--Event END-->
        <br>
    @endforeach

    <!--Auctions-->
    @if($auctions->isEmpty())
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">No auctions to accept</h1>
    @else
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">Auctions:</h1>
    @endif
    @foreach($auctions as $auction)
        <!--Auction START-->
        <div class="flex w-9/12 p-3 text-center rounded-t-lg text-sm border-4 bg-amber-200 border-amber-200 text-amber-600">
            <div class="w-full p-5 grid gap-6 md:grid-cols-4 text-left text-2xl py-3 font-extrabold">
                <p>Game: {{$auction->title}}</p>
                <p>State: {{$auction->state}}</p>
                <p>Price: {{$auction->price}}$</p>
                <p class="text-right">
                    <a href="{{route('profile.acceptance.accept',['element'=> "Auction", 'id'=>$auction->id])}}" id="accept_auction{{$auction->id}}"><button class="px-5 py-3 text-lime-600 bg-lime-300 hover:bg-lime-400 hover:text-lime-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Accept</button></a>
                    <a href="{{route('profile.acceptance.decline',['element'=> "Auction", 'id'=>$auction->id])}}" id="decline_auction{{$auction->id}}"><button class="px-5 py-3 text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Decline</button></a>
                </p>
            </div>
        </div>
        <div class="w-9/12 p-6 text-center bg-white border-4 rounded-b-lg text-sm border-amber-200 text-amber-600">
            <div class="grid gap-6 md:grid-cols-2 text-center text-xl py-3 font-extrabold">
                <p>{{$auction->description}}</p>
                <div>
                    <p>E-mail: {{$auction->email}}</p>
                    <p>Telephone number: {{$auction->phone}}</p>
                </div>
            </div>
        </div>
        <!--Auction END-->
        <br>
    @endforeach
</div>

@include('footer')
</body>
</html>
