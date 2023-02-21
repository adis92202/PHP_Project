<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
@php($user = \Illuminate\Support\Facades\Auth::user())
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
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Our game library</h2>
    <!--Search-->
    <div class="w-9/12 flex flex-col items-center">
        <!--Header-->
        <h2 class="w-full text-left p-5 bg-amber-200 text-xl py-2 font-semibold rounded-t-lg text-amber-700 bordder-0 border-lime-200">Find what you're looking for!</h2>
        <div class="w-full text-center bg-white border-0 border-lime-200 rounded-b-lg shadow-md sm:p-8">

            <!--Search Form START-->
            <form method="GET" action="{{url('filter_games')}}">
                <div class="grid gap-6 md:grid-cols-5">
                    <!--Title-->
                    <div>
                        <label for="title_filter" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                        <input type="text" id="title_filter" name="title_filter" value="{{Request::get('title_filter')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                    </div>
                    <!--Category-->
                    <div>
                        <label for="category_filter" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                        <select id="category_filter" name="category_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                            <option disabled selected value> {{Request::get('category_filter') ?? " -- select an option -- "}} </option>
                            <option value="Action" {{ old('category_filter') == "Action" ? 'selected' : '' }}>Action</option>
                            <option value="Adventure" {{ old('category_filter') == "Adventure" ? 'selected' : '' }}>Adventure</option>
                            <option value="Cards" {{ old('category_filter') == "Cards" ? 'selected' : '' }}>Cards</option>
                            <option value="Children" {{ old('category_filter') == "Children" ? 'selected' : 'Children' }}>Children</option>
                            <option value="Economic" {{ old('category_filter') == "Economic" ? 'selected' : '' }}>Economic</option>
                            <option value="Educational" {{ old('category_filter') == "Educational" ? 'selected' : '' }}>Educational</option>
                            <option value="Fantasy" {{ old('category_filter') == "Fantasy" ? 'selected' : '' }}>Fantasy</option>
                            <option value="Horror" {{ old('category_filter') == "Horror" ? 'selected' : '' }}>Horror</option>
                            <option value="Humor" {{ old('category_filter') == "Humor" ? 'selected' : '' }}>Humor</option>
                            <option value="Murder/Mystery" {{ old('category_filter') == "Murder/Mystery" ? 'selected' : '' }}>Murder/Mystery</option>
                            <option value="Party" {{ old('category_filter') == "Party" ? 'selected' : '' }}>Party</option>
                            <option value="Science Fiction" {{ old('category_filter') == "Science Fiction" ? 'selected' : '' }}>Science Fiction</option>
                            <option value="Strategy" {{ old('category_filter') == "Strategy" ? 'selected' : '' }}>Strategy</option>
                        </select>
                    </div>
                    <!--Time-->
                    <div>
                        <label for="time_filter" class="block mb-2 text-sm font-medium text-gray-900">Time range</label>
                        <select id="time_filter" name="time_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                            <option disabled selected value> {{Request::get('time_filter') ? Request::get('time_filter') . ' Min' : " -- select an option -- "}} </option>
                            <option value="0-30" {{ old('time_filter') == "0-30" ? 'selected' : '' }}>0-30 Min</option>
                            <option value="30-60" {{ old('time_filter') == "30-60" ? 'selected' : '' }}>30-60 Min</option>
                            <option value="60-90" {{ old('time_filter') == "60-90" ? 'selected' : '' }}>60-90 Min</option>
                            <option value="90-120" {{ old('time_filter') == "90-120" ? 'selected' : '' }}>90-120 Min</option>
                            <option value="120-180" {{ old('time_filter') == "120-180" ? 'selected' : '' }}>120-180 Min</option>
                            <option value="180+" {{ old('time_filter') == "180+" ? 'selected' : '' }}>180+ Min</option>
                        </select> </div>
                    <!--Players-->
                    <div>
                        <label for="players_filter" class="block mb-2 text-sm font-medium text-gray-900">Players</label>
                        <input type="number" id="players_filter" name="players_filter" value="{{Request::get('players_filter')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                    </div>
                    <!--Search button-->
                    <div class="flex items-center justify-center">
                        <button id="filter" type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Search</button>
                    </div>
                </div>
                <!--Search Form END-->
            </form>
        </div>
    </div>
    <br>

    <div class="w-9/12 text-center bg-white border-4 border-lime-200 rounded-lg shadow-md sm:p-8">
        <!--Table START-->
        <table class="w-full text-sm text-center text-green-800">
            <!--Column names-->
            <thead class="text-md text-gray-700 uppercase bg-lime-100 rounded border-b-4 border-lime-200">
            <tr>
                <th scope="col" class="py-3 px-6">
                    Title
                </th>
                <th scope="col" class="py-3 px-6">
                    Category
                </th>
                <th scope="col" class="py-3 px-6">
                    Rating
                </th>
                <th scope="col" class="py-3 px-6">
                    Time
                </th>
                <th scope="col" class="py-3 px-6">
                    Players
                </th>
                <th>
                </th>
            </tr>
            </thead>

            <tbody>
            <!--Filters logic-->
            @foreach($games as $game)
                <!--Games-->
                <tr class="bg-white text-gray-700 border-b text-lg border-lime-200 hover:bg-amber-50">
                    <th scope="row" class="py-4 flex items-center justify-left font-medium whitespace-nowrap">
                        @if(!$game->image)
                            <img src="{{asset('images/no-image.png')}}" class="h-32 w-32 object-cover mr-3" alt="Logo" />
                        @elseif(str_starts_with($game->image, 'seeder'))
                            <img src="{{asset('images/' . $game->image)}}" class="h-32 w-32 object-cover mr-3" alt="Logo" />
                        @else
                            <img src="{{ url('storage/images/'.$game->image) }}" class="h-32 w-32 object-cover mr-3" alt="Logo" />
                        @endif
                        {{$game->title}}<p class="text-gray-400">({{$game->year}})</p>
                    </th>
                    <td class="py-4">
                        {{$game->category}}
                    </td>
                    <td class="py-4">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Rating star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <p class="ml-2 text-sm font-bold text-gray-900">{{\App\Http\Controllers\RatingController::avg_rating($game->id)}}</p>
                            <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                            <p class="text-sm font-medium text-gray-900 underline">{{\App\Http\Controllers\RatingController::numberOfRatings($game->id)}} reviews</p>
                        </div>

                    </td>
                    <td class="py-4 px-6">
                        {{$game->time}} Min
                    </td>
                    <td class="py-4 px-6">
                        @php($players = explode('-', $game->players))
                        {{isset($players[1]) && ($players[0] == $players[1]) ? $players[0] : $game->players}}
                    </td>
                    <td>
                        <a href="{{ route('library.show', $game)}}" id="more_{{$game->id}}"><button class="px-5 py-3 text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">More</button></a>
                        @if($user && $user->admin)
                            <a href="{{ route('library.edit', $game)}}" id="edit_{{$game->id}}"><button class="px-5 py-3 text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Edit</button></a>
                            <button onclick="showPopoverID({{$game->id}})" id="delete_{{$game->id}}" class="px-5 py-3 text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete</button>
                        @endif
                    </td>
                </tr>
                <div id="popover_{{$game->id}}" class="w-screen h-screen top-1/4 left-0 fixed hidden">
                    <h2 class="text-center bg-amber-200 text-xl py-5 font-extrabold rounded-t-lg text-amber-700 border-4 border-amber-200">Are you sure?</h2>
                    <div class="p-6 text-center bg-white border-4 border-amber-200 rounded-b-lg shadow-md sm:p-8">
                        <p class="p-3 text-amber-700">
                            Are you sure you want to delete this game?
                        </p>
                        <br>
                        <div class="grid gap-6 mb-6 md:grid-cols-7">
                            <!--Submit Button-->
                            <a href="{{ route('library.destroy', $game->id)}}" id="Delete_yes_{{$game->id}}" class="col-start-3"><button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete this game</button></a>
                            <div onclick="showPopoverID({{$game->id}})" id="cancel_delete" class="items-center justify-center flex col-start-5 px-3 py-1 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Cancel</div></a>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
        <!--Table END-->
    </div>
    <br>
    <!--Card for creation-->
    <div class="fixed right-0 w-44 p-6 bg-white border border-lime-200 rounded-lg shadow-md">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-lime-700">Can't see your favourite game?</h5>
        <!--Create button-->
        <a href="{{ route('library.create') }}"><button class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Add it here!</button></a>
    </div>
</div>

@include('footer')
</body>
</html>
