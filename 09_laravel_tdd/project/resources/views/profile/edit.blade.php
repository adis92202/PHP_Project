<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
@php($user = Auth::user())
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
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Welcome {{Auth::user()->username}}!</h2>
    @include('profile.profile_menu')
    <div class="flex flex-col items-center">
        <!--Event START-->
        <div class="flex w-full p-3 text-center rounded-t-lg text-sm border-4 bg-lime-200 border-lime-200 text-lime-600">
            <div class="w-full p-5 grid gap-6 md:grid-cols-3 text-left text-2xl py-3 font-extrabold">
                <p>{{$user->username}}</p>
                <p class="text-lg font-medium">City: {{$user->city ?? 'N/A'}}</p>
                <p class="text-lg font-medium">Age: {{$user->age ?? 'N/A'}}</p>

            </div>
        </div>
        <div class="w-full p-6 text-center bg-white border-4 rounded-b-lg text-sm border-lime-200 text-lime-600">
            <div class="grid gap-6 md:grid-cols-4 text-left text-xl py-3 font-extrabold">
                <p>You have {{$user->games->count()}} games</p>
                <p class="col-start-2 col-end-4">You're organizing {{$user->myEvents->count()}} events and attending {{$user->events->count()}} events </p>
                <p>You've posted {{$user->auctions->count()}} auctions</p>
                <p class="flex col-start-1 col-end-3">Your average rating is {{\App\Http\Controllers\ProfileController::your_avg_rating()}}<svg aria-hidden="true" class="w-7 h-7 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Rating star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    with {{$user->ratings->count()}} reviews</p>
                <p>You've posted {{$user->comments->count()}} comments</p>
            </div>
        </div>
    </div>
</div>

@include('footer')
</body>
</html>
