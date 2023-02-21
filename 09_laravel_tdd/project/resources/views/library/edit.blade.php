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
                @foreach($errors->get('category') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('description') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('year') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('time') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('players') as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!--Header-->
    <h2 class="w-1/2 text-center bg-lime-200 text-4xl py-5 font-extrabold rounded-t-lg text-lime-700 border-4 border-lime-200">Edit game</h2>
    <div class="w-1/2 p-6 text-center bg-white border-4 border-lime-200 rounded-b-lg shadow-md sm:p-8">
        <!--Form START-->
        <form method="POST" action="{{ route('library.update', $game) }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <!--Title-->
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                    <input type="text" id="title" name="title" value="{{$game->title}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Category-->
                <div>
                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                    <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="Action" {{ $game->category == "Action" ? 'selected' : '' }}>Action</option>
                        <option value="Adventure" {{ $game->category == "Adventure" ? 'selected' : '' }}>Adventure</option>
                        <option value="Cards" {{ $game->category == "Cards" ? 'selected' : '' }}>Cards</option>
                        <option value="Children" {{ $game->category == "Children" ? 'selected' : 'Children' }}>Children</option>
                        <option value="Economic" {{ $game->category == "Economic" ? 'selected' : '' }}>Economic</option>
                        <option value="Educational" {{ $game->category == "Educational" ? 'selected' : '' }}>Educational</option>
                        <option value="Fantasy" {{ $game->category == "Fantasy" ? 'selected' : '' }}>Fantasy</option>
                        <option value="Horror" {{ $game->category == "Horror" ? 'selected' : '' }}>Horror</option>
                        <option value="Humor" {{ $game->category == "Humor" ? 'selected' : '' }}>Humor</option>
                        <option value="Murder/Mystery" {{ $game->category == "Murder/Mystery" ? 'selected' : '' }}>Murder/Mystery</option>
                        <option value="Party" {{ $game->category == "Party" ? 'selected' : '' }}>Party</option>
                        <option value="Science Fiction" {{ $game->category == "Science Fiction" ? 'selected' : '' }}>Science Fiction</option>
                        <option value="Strategy" {{ $game->category == "Strategy" ? 'selected' : '' }}>Strategy</option>
                    </select>
                </div>
                <!--Year-->
                <div>
                    <label for="year" class="block mb-2 text-sm font-medium text-gray-900">Year published</label>
                    <input type="number" id="year" name="year" value="{{$game->year}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <!--Adding Image-->
                <div>
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Image</label>
                    <input id="image" type="file" name="image" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Description-->
                <div class="col-start-2 col-end-4">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                    <textarea type="text" id="description" name="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">{{$game->description}}}</textarea>
                </div>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!--Time-->
                <div>
                    <label for="time" class="block mb-2 text-sm font-medium text-gray-900">Duration in minutes</label>
                    <input type="number" id="time" name="time" value="{{$game->time}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Players-->
                <div>
                    <label for="players" class="block mb-2 text-sm font-medium text-gray-900">Number of players (write range with -)</label>
                    <input type="text" id="players" name="players" value="{{$game->players}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <!--Submit Button-->
            <button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Edit game</button>
            <!--Form END-->
        </form>
    </div>
</div>

@include('footer')
</body>
</html>
