<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
<div class="flex flex-col items-center">
    <!--Header-->
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Your games</h2>
    @include('profile.profile_menu')
    @if($games->isEmpty())
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">You didn't add any games yet!</h1>
    @endif
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
                    Your rating
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
            @foreach($games as $game)
            <tbody>
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
                    <div class="flex items-center justify-center">
                        <p class="ml-2 text-lg text-gray-900">{{(count($ratings->where('game_id', '=', $game->id))!=0) ? $ratings->where('game_id', '=', $game->id)->first()->rating : 'N/A'}}</p>
                        <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Rating star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                </td>
                <td class="py-4 px-6">
                    {{$game->time}} Min
                </td>
                <td class="py-4 px-6">
                    {{$game->players}}
                </td>
                <td>
                    <a href="{{ route('library.show', $game)}}"><button class="px-5 py-3 text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">More</button></a>
                    <button onclick="showPopoverID({{$game->id}})" id="delete_{{$game->id}}" class="px-5 py-3 text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete from your games</button>
                </td>
            </tr>
            <div id="popover_{{$game->id}}" class="w-screen h-screen top-1/4 left-0 fixed hidden">
                <h2 class="text-center bg-amber-200 text-xl py-5 font-extrabold rounded-t-lg text-amber-700 border-4 border-amber-200">Are you sure?</h2>
                <div class="p-6 text-center bg-white border-4 border-amber-200 rounded-b-lg shadow-md sm:p-8">
                    <p class="p-3 text-amber-700">
                        Are you sure you want to delete this game from your games?
                    </p>
                    <br>
                    <div class="grid gap-6 mb-6 md:grid-cols-7">
                        <!--Submit Button-->
                        <a href="{{route('library.deleteFromGames',["id"=>$game->id])}}" id="Delete_yes_{{$game->id}}" class="col-start-3"><button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete this game from your games</button></a>
                        <button onclick="showPopoverID({{$game->id}})" id="cancel_delete" class="items-center justify-center flex col-start-5 px-3 py-1 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Cancel</button></a>
                    </div>
                </div>
            </div>
            @endforeach
            </tbody>
        </table>
    </div>

</div>

@include('footer')
</body>
</html>
