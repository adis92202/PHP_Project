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
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Marketplace</h2>
    <!--Info if empty-->
    @if(\App\Models\Auction::where('accepted', '=', '1')->count()<1)
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">No auctions added yet! Be the first one!</h1>
    @endif

    <!--Search-->
    <div class="w-9/12 flex flex-col items-center">
        <!--Header-->
        <h2 class="w-full text-left p-5 bg-amber-200 text-xl py-2 font-semibold rounded-t-lg text-amber-700 bordder-0 border-lime-200">Find what you're looking for!</h2>
        <div class="w-full text-center bg-white border-0 border-lime-200 rounded-b-lg shadow-md sm:p-8">

            <!--Search Form START-->
            <form method="GET" action="{{url('filter_auctions')}}">
                <div class="grid gap-6 md:grid-cols-4">
                    <!--Title-->
                    <div>
                        <label for="title_filter" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                        <input type="text" id="title_filter" name="title_filter" value="{{Request::get('title_filter')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                    </div>
                    <!--State-->
                    <div>
                        <label for="state_filter" class="block mb-2 text-sm font-medium text-gray-900">State</label>
                        <select id="state_filter" name="state_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                            <option disabled selected value> {{Request::get('state_filter') ?? " -- select an option -- "}} </option>
                            <option value="New" {{ old('state_filter') == "New" ? 'selected' : '' }}>New</option>
                            <option value="Very good" {{ old('state_filter') == "Very good" ? 'selected' : '' }}>Very good</option>
                            <option value="Good" {{ old('state_filter') == "Good" ? 'selected' : '' }}>Good</option>
                            <option value="Defective" {{ old('state_filter') == "Defective" ? 'selected' : '' }}>Defective</option>
                        </select>
                    </div>
                    <!--Price-->
                    <div>
                        <label for="price_filter" class="block mb-2 text-sm font-medium text-gray-900">Price range</label>
                        <select id="price_filter" name="price_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                            <option disabled selected value> {{Request::get('price_filter') ? Request::get('price_filter') . '$' : " -- select an option -- "}} </option>
                            <option value="0-10" {{ old('price_filter') == "0-10" ? 'selected' : '' }}>0-10$</option>
                            <option value="10-25" {{ old('price_filter') == "10-25" ? 'selected' : '' }}>10-25$</option>
                            <option value="25-50" {{ old('price_filter') == "25-50" ? 'selected' : '' }}>25-50$</option>
                            <option value="50-100" {{ old('price_filter') == "50-100" ? 'selected' : '' }}>50-100$</option>
                            <option value="100-200" {{ old('price_filter') == "100-200" ? 'selected' : '' }}>100-200$</option>
                            <option value="200+" {{ old('price_filter') == "200+" ? 'selected' : '' }}>200+$</option>
                        </select> </div>
                    <!--Search button-->
                    <div class="flex items-center justify-center">
                        <button id='filter' type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Search</button>
                    </div>
                </div>
                <!--Search Form END-->
            </form>
        </div>
    </div>
    <br>

    <!--Search logic-->
    @foreach($auctions as $auction)
        <!--Auction START-->
        <div class="flex w-9/12 p-3 text-center bg-lime-200 border-4 border-lime-200 rounded-t-lg text-sm text-green-800 border-4 border-lime-200">
            <div class="w-full p-5 grid gap-6 md:grid-cols-4 text-left text-2xl py-3 font-extrabold text-lime-600">
                <p>Game: {{$auction->title}}</p>
                <p>State: {{$auction->state}}</p>
                <p>Price: {{$auction->price}}$</p>
                <p class="text-right">
                    @if(Auth::user() && Auth::user()->admin)
                        <button onclick="showPopoverID({{$auction->id}})" id="delete_{{$auction->id}}" class="px-5 py-3 text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete</button>
                    @endif
                </p>
            </div>
        </div>
        <div class="w-9/12 p-6 text-center bg-white border-4 border-lime-200 rounded-b-lg text-sm text-green-800 border-4 border-lime-200">
            <div class="grid gap-6 md:grid-cols-2 text-center text-xl py-3 font-extrabold text-lime-600">
                <p>{{$auction->description}}</p>
                <div>
                    @if(Auth::user())
                        <p>E-mail: {{$auction->email}}</p>
                        <p>Telephone number: {{$auction->phone}}</p>
                    @else
                        <p class="text-amber-500">
                            <a class="underline text-amber-500 hover:text-amber-600 rounded-md focus:outline-none" href="{{ route('login') }}">
                                Please login to see contact information
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <!--Auction END-->
        <br>
        <div id="popover_{{$auction->id}}" class="w-screen h-screen top-1/4 left-0 fixed hidden">
            <h2 class="text-center bg-amber-200 text-xl py-5 font-extrabold rounded-t-lg text-amber-700 border-4 border-amber-200">Are you sure?</h2>
            <div class="p-6 text-center bg-white border-4 border-amber-200 rounded-b-lg shadow-md sm:p-8">
                <p class="p-3 text-amber-700">
                    Are you sure you want to delete this auction?
                </p>
                <br>
                <div class="grid gap-6 mb-6 md:grid-cols-7">
                    <!--Submit Button-->
                    <a href="{{url('/auctions/destroy', $auction)}}" id="Delete_yes_{{$auction->id}}" class="col-start-3"><button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete this auction</button></a>
                    <button onclick="showPopoverID({{$auction->id}})" id="cancel_delete" class="items-center justify-center flex col-start-5 px-3 py-1 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Cancel</button></a>
                </div>
            </div>
        </div>
    @endforeach
    <br>

    <!--Card for creation-->
    <div class="fixed right-0 w-44 p-6 bg-white border border-lime-200 rounded-lg shadow-md">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-lime-700">Want to sell your game?</h5>
        <!--Create button-->
        <a href="{{ route('auctions.create') }}"><button class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Add auction here!</button></a>
    </div>
</div>

@include('footer')
</body>
</html>
