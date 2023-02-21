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
                @foreach($errors->get('state') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('description') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('price') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('email') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('phone') as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!--Header-->
    <h2 class="w-1/2 text-center bg-lime-200 text-4xl py-5 font-extrabold rounded-t-lg text-lime-700 border-4 border-lime-200">Edit your auction</h2>
    <div class="w-1/2 p-6 text-center bg-white border-4 border-lime-200 rounded-b-lg shadow-md sm:p-8">
        <!--Form START-->
        <form method="POST" action="{{ route('auctions.update', $auction) }}">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <!--Title-->
                <div>
                    <label for="game_title" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                    <input type="text" id="game_title" name="game_title" value="{{$auction->title}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--State-->
                <div>
                    <label for="state" class="block mb-2 text-sm font-medium text-gray-900">State</label>
                    <select id="state" name="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="New" {{ $auction->state == "New" ? 'selected' : '' }}>New</option>
                        <option value="Very good" {{ $auction->state == "Very good" ? 'selected' : '' }}>Very good</option>
                        <option value="Good" {{ $auction->state == "Good" ? 'selected' : '' }}>Good</option>
                        <option value="Defective" {{ $auction->state == "Defective" ? 'selected' : '' }}>Defective</option>
                    </select>
                </div>
                <!--Price-->
                <div>
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Price</label>
                    <input type="number" step="0.01" id="price" name="price" value="{{$auction->price}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-1">
                <!--Description-->
                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                    <textarea type="text" id="description" name="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">{{$auction->description}}</textarea>
                </div>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!--Email-->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">E-mail</label>
                    <input type="text" id="email" name="email" value="{{ $auction->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Phone-->
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone number</label>
                    <input type="text" id="phone" name="phone" value="{{ $auction->phone }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <!--Submit Button-->
            <button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Edit auction</button>
            <!--Form END-->
        </form>
    </div>
</div>

@include('footer')
</body>
</html>
