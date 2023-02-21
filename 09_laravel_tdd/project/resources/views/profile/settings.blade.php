<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
@php($user = Auth::user())
<div class="flex flex-col items-center">
    <!--Header-->
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Settings</h2>
    @include('profile.profile_menu')
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
                    @foreach($errors->get('current_password') as $error)
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
    <h2 class="w-1/2 text-center bg-lime-200 text-xl py-5 font-extrabold rounded-t-lg text-lime-700 border-4 border-lime-200">Update your profile information</h2>
    <div class="w-1/2 p-6 text-center bg-white border-4 border-lime-200 rounded-b-lg shadow-md sm:p-8">
        <!--Form START-->
        <form method="POST" action="{{route('profile.update')}}">
            @csrf
            @method('patch')
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!--Username-->
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                    <input type="text" id="username" name="username" value="{{old('username', $user->username)}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Email-->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">E-mail</label>
                    <input type="text" id="email" name="email" value="{{old('email', $user->email)}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <p class="p-3 text-lime-700">This information is optional:</p>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!--City-->
                <div>
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900">City</label>
                    <input type="text" id="city" name="city" value="{{old('city', $user->city)}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Age-->
                <div>
                    <label for="age" class="block mb-2 text-sm font-medium text-gray-900">Age</label>
                    <input type="number" id="age" name="age" value="{{old('age', $user->age)}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <!--Submit Button-->
            <button type="submit" id='save1' class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Save</button>
            <!--Form END-->
        </form>
    </div>
    <br>
    <!--Header-->
    <h2 class="w-1/2 text-center bg-lime-200 text-xl py-5 font-extrabold rounded-t-lg text-lime-700 border-4 border-lime-200">Change your password</h2>
    <div class="w-1/2 p-6 text-center bg-white border-4 border-lime-200 rounded-b-lg shadow-md sm:p-8">
        <!--Form START-->
        <form method="POST" action="{{route('password.update')}}">
            @csrf
            @method('put')
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!--New Password-->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">New password</label>
                    <input type="password" id="password" name="password" autocomplete="new-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Confirm password-->
                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!--Current Password-->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Current password</label>
                    <input type="password" id="current_password" name="current_password" autocomplete="current-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Submit Button-->
                <div class="flex items-end justify-center">
                    <button type="submit" id='save2' class="px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Save</button>
                </div>
            </div>
            <!--Form END-->
        </form>
    </div>
    <br>
    <!--Header-->
    <h2 class="w-1/2 text-center bg-lime-200 text-xl py-5 font-extrabold rounded-t-lg text-lime-700 border-4 border-lime-200">Delete your account</h2>
    <div class="w-1/2 p-6 text-center bg-white border-4 border-lime-200 rounded-b-lg shadow-md sm:p-8">
        <p class="p-3 text-lime-700">
            @php($cant_delete = ($user->admin == 1) && (\App\Models\User::all()->where('admin', 1)->count()==1))
                {{$cant_delete ? "You can't delete your account, you're the only admin." : "Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain."}}
        </p>
        <div class="flex items-end justify-center">
            <button onclick="showPopover()" id="delete" class="px-5 py-3 shadow {{!$cant_delete ? 'hover:bg-amber-400 hover:text-amber-100 text-amber-600 bg-amber-300' : 'text-amber-300 bg-amber-100'}} font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none" {{$cant_delete ? 'disabled' : ''}}>Delete your account</button>
        </div>
    </div>
<div id="popover" class="w-3/4 h-screen fixed hidden">
    <h2 class="text-center bg-amber-200 text-xl py-5 font-extrabold rounded-t-lg text-amber-700 border-4 border-amber-200">Are you sure?</h2>
    <div class="p-6 text-center bg-white border-4 border-amber-200 rounded-b-lg shadow-md sm:p-8">
        <p class="p-3 text-amber-700">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </p>
        @if(!$errors->isEmpty())
            <div class="p-4 mb-4 text-sm text-amber-800 bg-amber-400 rounded-lg" role="alert">
                <ul class="mt-1.5 ml-4 list-disc list-inside">
                    @foreach($errors->get('password') as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <br>
        <!--Form START-->
        <form method="POST" action="{{route('profile.destroy')}}">
            @csrf
            @method('delete')
            <div class="grid gap-6 mb-6 md:grid-cols-7">
                <!--Password-->
                <div class="col-start-3 col-end-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Type in password to confirm</label>
                    <input type="password" id="password2" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-300 focus:border-lime-300 block w-full p-2.5">
                </div>
                <!--Submit Button-->
                    <button type="submit" id="delete_account" class="col-start-3 px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Delete your account</button>
                    <div onclick="showPopover()" id="cancel_delete" class="items-center justify-center flex col-start-5 px-5 py-3 shadow text-amber-600 bg-amber-300 hover:bg-amber-400 hover:text-amber-100 font-semibold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center focus:outline-none">Cancel</div></a>
            </div>
            <!--Form END-->
        </form>
    </div>
</div>
</div>
@include('footer')
</body>
</html>
