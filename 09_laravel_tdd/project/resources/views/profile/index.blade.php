<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')
<div class="flex flex-col items-center">
    <!--Header-->
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Welcome {{Auth::user()->username}}!</h2>
    @include('profile.profile_menu')


</div>

@include('footer')
</body>
</html>
