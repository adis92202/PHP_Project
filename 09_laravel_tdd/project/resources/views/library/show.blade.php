<?php use App\Models\User;

?>
<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
@php($user=Auth::user())

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
    <div class="grid gap-6 md:grid-cols-4 w-9/12 flex items-center justify-center">
        <!--Game pic-->

        @if(!$game->image)
            <img src="{{asset('images/no-image.png')}}" class="w-96 h-80 object-cover mr-3 shadow rounded-lg" alt="Logo" />
        @elseif(str_starts_with($game->image, 'seeder'))
            <img src="{{asset('images/' . $game->image)}}" class="w-96 h-80 object-cover mr-3 shadow rounded-lg" alt="Logo" />
        @else
            <img src="{{ url('storage/images/'.$game->image) }}" class="w-96 h-80 object-cover mr-3 shadow rounded-lg" alt="Logo" />
        @endif
        <!--Game info-->
        <div class="col-start-2 col-end-5">
            <div class="flex p-3 text-center bg-amber-200 border-4 border-amber-200 rounded-t-lg text-sm text-amber-700 border-4">
                <div class="w-full p-5 flex text-left text-2xl py-2 font-extrabold text-amber-700">
                    {{$game->title}}<p class="text-amber-500">({{$game->year}})</p>
                </div>
                @php($show = true)
                @if($user)
                    @foreach($user->games as $check)
                        @if($check->pivot->game_id == $game->id)
                            @php($show=false)
                       @endif
                    @endforeach
                @endif
                <div class="w-full p-5 text-right text-2xl py-2 font-extrabold text-amber-700">
                    <a href="{{ route('library.show.add',['id' => $game->id]) }}"><button id="add_game" class="px-5 py-3 shadow {{$user && $show ? 'hover:bg-amber-400 hover:text-amber-100 text-amber-600 bg-amber-400' : 'text-amber-300 bg-amber-100'}} font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none" {{$user && $show ? '' : 'disabled'}}>{{$user && !$show ? 'This game is already in your games' : 'Add to your games'}}</button></a>
                </div>
            </div>
            <div class="p-6 text-center bg-white border-4 border-b-0 border-amber-200 text-sm text-green-800 border-40">
                <div class="grid gap-6 md:grid-cols-3 text-left text-xl py-3 font-extrabold text-amber-600">
                    <p>Category: {{$game->category}}</p>
                    <p>Play time: {{$game->time}} minutes</p>
                    <p>Number of players: {{$game->players}}</p>
                    <p class="col-start-1 col-end-4 text-lg font-medium">Description: {{$game->description}}</p>
                </div>
            </div>
        </div>
        <div class="col-start-1 col-end-5">
            <div class="p-6 text-center bg-white border-4 border-t-0 border-amber-200 rounded-b-lg text-sm text-green-800 border-40">
                <div class="grid gap-6 md:grid-cols-3 text-left text-xl py-3 font-extrabold text-amber-600">
                    <p>{{\App\Http\Controllers\GameController::numberOfGamers($game->id)}} of players have this game</p>
                    <p class="flex">Average rating of {{\App\Http\Controllers\RatingController::avg_rating($game->id)}}<svg aria-hidden="true" class="w-7 h-7 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Rating star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        with {{\App\Http\Controllers\RatingController::numberOfRatings($game->id)}} reviews</p>
                    <!-- Rating -->
                    <form class="py-2 px-4" action="{{route('ratings.store')}}" method="POST" autocomplete="off">
                        @csrf
                        <p>{{$user ? 'Your rating:' : 'Login to add your rating'}}</p>
                        <div class="form-group row">
                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                            <div class="flex items-center justify-center">
                                <div class="rate flex items-center">
                                    @php(($user && isset($ratings)) ? $your_rating = $ratings->where('user_id','=',$user->id)->first() : $your_rating = 0)
                                    <label for="star1" title="1 star" class="{{$user ? 'text-yellow-400' : 'text-gray-300'}} peer-checked:text-gray-300"><svg aria-hidden="true" class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg></label>
                                    <input type="radio" id="star1" class="peer hidden" name="rating" value="1" {{$user ? '' : 'disabled'}} {{($your_rating && $your_rating->rating==1) ? 'checked' : ''}}/>
                                    <label for="star2" title="text" class="{{$user ? 'text-yellow-400' : 'text-gray-300'}} peer-checked:text-gray-300"><svg aria-hidden="true" class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg></label>
                                    <input type="radio" id="star2" class="peer hidden" name="rating" value="2" {{$user ? '' : 'disabled'}} {{($your_rating && $your_rating->rating==2) ? 'checked' : ''}}/>
                                    <label for="star3" title="text" class="{{$user ? 'text-yellow-400' : 'text-gray-300'}} peer-checked:text-gray-300"><svg aria-hidden="true" class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg></label>
                                    <input type="radio" id="star3" class="peer hidden" name="rating" value="3" {{$user ? '' : 'disabled'}} {{($your_rating && $your_rating->rating==3) ? 'checked' : ''}}/>
                                    <label for="star4" title="text" class="{{$user ? 'text-yellow-400' : 'text-gray-300'}} peer-checked:text-gray-300"><svg aria-hidden="true" class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg></label>
                                    <input type="radio" id="star4" class="peer hidden" name="rating" value="4" {{$user ? '' : 'disabled'}} {{($your_rating && $your_rating->rating==4) ? 'checked' : ''}}/>
                                    <label for="star5" title="text" class="{{$user ? 'text-yellow-400' : 'text-gray-300'}} peer-checked:text-gray-300"><svg aria-hidden="true" class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg></label>
                                    <input type="radio" id="star5" class="peer hidden" name="rating" value="5" {{$user ? '' : 'disabled'}} {{($your_rating && $your_rating->rating==5) ? 'checked' : ''}}/>
                                </div>
                            </div>
                            <div class="text-right">
                                <button id="add_rating" class="px-5 py-3 shadow {{$user ? 'hover:bg-amber-400 hover:text-amber-100 text-amber-600 bg-amber-300' : 'text-amber-300 bg-amber-100'}} font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none" {{$user ? '' : 'disabled'}}>{{$your_rating ? 'Change rating' : 'Add rating'}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="w-1/2 p-6 text-center bg-white rounded-lg sm:p-8">

        <!--Errors-->
        @if(!$errors->isEmpty())
            <div class="p-4 mb-4 text-sm text-amber-800 bg-amber-400 rounded-lg" role="alert">
                <ul class="mt-1.5 ml-4 list-disc list-inside">
                    @foreach($errors->get('description') as $error)
                        <li>{{$error}}</li>
                    @endforeach
                        @foreach($errors->get('rating') as $error)
                            <li>{{$error}}</li>
                        @endforeach
                </ul>
            </div>
        @endif

        <!--Form START-->
        <form method="POST" action="{{ route('comments.store', ['id' => $game->id]) }}">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-6">
                <!--Comment-->
                <input type="hidden" name="game_id" value="{{ $game->id }}">
                <div class="col-start-1 col-end-5">
                    <label for="description" class="block mb-2 text-xl py-3 font-extrabold text-lime-600">Leave your review!</label>
                    <textarea type="text" id="description" name="description" rows="4" class="bg-gray-50 border border-gray-300 {{$user ? 'text-gray-900 text-sm' : 'text-gray-500 text-md'}} rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5" {{!$user ? 'disabled' : ''}}>{{$user ? '' : "Please login to comment"}}</textarea>
                </div>
                <!--Submit Button-->
                <div class="flex items-center justify-center">
                    <button type="submit" id="add_comment" class="px-5 py-3 shadow {{$user ? 'hover:bg-amber-400 hover:text-amber-100 text-amber-600 bg-amber-300' : 'text-amber-300 bg-amber-100'}} font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none" {{!$user ? 'disabled' : ''}}>Add comment</button>
                </div>
            </div>
            <!--Form END-->
        </form>
    </div>

    @foreach($comments as $comment)
        <!--Comments START-->
        <div class="w-7/12 text-sm text-left text-green-800">
            <!--Username-->
            <div class="text-md w-full p-4 px-20 text-gray-700 uppercase font-extrabold bg-lime-100 rounded border-b-4 border-lime-200">
                {{ User::find($comment->user_id)->username }}
            </div>
            <!--Comment-->
            <div class="bg-white text-gray-700 border-b text-lg border-lime-400">
                <div class="py-4 px-20 flex items-center justify-left font-medium whitespace-nowrap">
                    {{$comment->text}}
                </div>
            </div>
        </div>
    @endforeach
</div>
@include('footer')
</body>
</html>
