<!doctype html>
<html>
<head>
    @include('head')
</head>

<body class="bg-white">
@include('menu')

<div class="flex flex-col items-center">
    <!--Header-->
    <h2 class="w-10/12 text-left text-4xl py-5 font-extrabold text-lime-700">Places to play with friends</h2>

    <div class="w-9/12 flex flex-col items-center">
        <!--Header-->
        <h2 class="w-full text-left p-5 bg-amber-200 text-xl py-2 font-semibold rounded-t-lg text-amber-700 bordder-0 border-lime-200">Here you can find where to play</h2>
        <div class="h-screen w-full">
            <div id="map" class="w-full text-center bg-white border-0 border-lime-200 rounded-b-lg shadow-md sm:p-8 h-full"></div>
        </div>
    </div>
@include('map')
@include('footer')
</body>
</html>
