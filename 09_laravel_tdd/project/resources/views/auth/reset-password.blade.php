<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
<div class="flex flex-col items-center">
    @if(isset($message))
        <div class="flex items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Check icon</span>
            </div>
            <div class="ml-3 text-sm font-normal">{{$message}}</div>
        </div>
    @endif
    @if(!$errors->isEmpty())
        <div class="p-4 mb-4 text-sm text-amber-800 bg-amber-400 rounded-lg" role="alert">
            <ul class="mt-1.5 ml-4 list-disc list-inside">
                @foreach($errors->get('email') as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!--Header-->
    <h2 class="w-1/4 text-center bg-lime-200 text-4xl py-5 font-extrabold rounded-t-lg text-lime-700 border-4 border-lime-200">Password reset</h2>
    <div class="w-1/4 p-6 text-center bg-white border-4 border-lime-200 rounded-b-lg shadow-md sm:p-8">
        <!--Form START-->
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="grid gap-6 mb-6 md:grid-cols-1">
                <!--Email-->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">E-mail</label>
                    <input type="text" id="email" name="email" value="{{old('email')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Password-->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Confirm password-->
                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <!--Submit Button-->
            <button type="submit" class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Reset password</button>
            <!--Form END-->
        </form>
    </div>
</div>

@include('footer')
</body>
</html>
