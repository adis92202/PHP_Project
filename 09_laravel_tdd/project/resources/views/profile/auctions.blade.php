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
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Your auctions</h2>
    @include('profile.profile_menu')

    @if($auctions->isEmpty())
        <h1 class="w-10/12 text-left text-2xl py-5 font-extrabold text-lime-600">You haven't created any auctions yet!</h1>
    @endif
    @foreach($auctions as $auction)
        <!--Auction START-->
        <h2 class="w-9/12 text-left text-2xl py-5 font-extrabold {{$auction->accepted ? 'text-lime-600' : 'text-amber-700'}}">{{$auction->accepted ? 'Accepted' : 'Waiting'}}</h2>
        <div class="flex w-9/12 p-3 text-center rounded-t-lg text-sm border-4 {{$auction->accepted ? 'bg-lime-200 border-lime-200 text-lime-600' : 'bg-amber-200 border-amber-200 text-amber-600'}}">
            <div class="w-full p-5 grid gap-6 md:grid-cols-4 text-left text-2xl py-3 font-extrabold">
                <p>Game: {{$auction->title}}</p>
                <p>State: {{$auction->state}}</p>
                <p>Price: {{$auction->price}}$</p>
                <p class="text-right">
                    <a href="{{ route('auctions.edit', $auction) }}"><button class="px-5 py-3 {{$auction->accepted ? 'text-lime-600 bg-lime-300 hover:bg-lime-400 hover:text-lime-100' : 'text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100'}} font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Edit</button></a>
                    <button onclick="showPopoverID({{$auction->id}})" id="delete_{{$auction->id}}" class="px-5 py-3 {{$auction->accepted ? 'text-lime-600 bg-lime-300 hover:bg-lime-400 hover:text-lime-100' : 'text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100'}} font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete</button>
                </p>
            </div>
        </div>
        <div class="w-9/12 p-6 text-center bg-white border-4 rounded-b-lg text-sm {{$auction->accepted ? 'border-lime-200 text-lime-600' : 'border-amber-200 text-amber-600'}}">
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
        <div id="popover_{{$auction->id}}" class="w-screen h-screen top-1/4 left-0 fixed hidden">
            <h2 class="text-center bg-amber-200 text-xl py-5 font-extrabold rounded-t-lg text-amber-700 border-4 border-amber-200">Are you sure?</h2>
            <div class="p-6 text-center bg-white border-4 border-amber-200 rounded-b-lg shadow-md sm:p-8">
                <p class="p-3 text-amber-700">
                    Are you sure you want to delete your auction?
                </p>
                <br>
                <div class="grid gap-6 mb-6 md:grid-cols-7">
                    <!--Submit Button-->
                    <a href="{{url('/auctions/destroy', $auction)}}" id="Delete_yes_{{$auction->id}}" class="col-start-3"><button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete your auction</button></a>
                    <button onclick="showPopoverID({{$auction->id}})" id="cancel_delete" class="items-center justify-center flex col-start-5 px-3 py-1 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Cancel</button></a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@include('footer')
</body>
</html>
