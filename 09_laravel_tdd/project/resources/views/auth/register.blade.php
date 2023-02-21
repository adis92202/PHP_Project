<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')

<div class="flex flex-col items-center">
    @if(!$errors->isEmpty())
        <div class="p-4 mb-4 text-sm text-amber-800 bg-amber-400 rounded-lg" role="alert">
            <ul class="mt-1.5 ml-4 list-disc list-inside">
                @foreach($errors->get('email') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('username') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('password') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('password_confirmation') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('city') as $error)
                    <li>{{$error}}</li>
                @endforeach
                @foreach($errors->get('age') as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!--Header-->
    <h2 class="w-1/2 text-center bg-lime-200 text-4xl py-5 font-extrabold rounded-t-lg text-lime-700 border-4 border-lime-200">Join us!</h2>
    <div class="w-1/2 p-6 text-center bg-white border-4 border-lime-200 rounded-b-lg shadow-md sm:p-8">
        <!--Form START-->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!--Username-->
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                    <input type="text" id="username" name="username" value="{{old('username')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Email-->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">E-mail</label>
                    <input type="text" id="email" name="email" value="{{old('email')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Password-->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <input type="password" id="password" name="password" autocomplete="new-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Confirm password-->
                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <p class="p-3 text-lime-700">This information is optional:</p>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!--City-->
                <div>
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900">City</label>
                    <input type="text" id="city" name="city" value="{{old('city')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Age-->
                <div>
                    <label for="age" class="block mb-2 text-sm font-medium text-gray-900">Age</label>
                    <input type="number" id="age" name="age" value="{{old('age')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <!--Already registered-->
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-amber-600 hover:text-amber-900 rounded-md focus:outline-none" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
            <!--Submit Button-->
            <button type="submit" id="register_sub" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Register</button>
            <!--Form END-->
        </form>
    </div>
</div>

@include('footer')
</body>
</html>
