
<nav>
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl px-4 md:px-6 py-2.5">
        <a href="/" class="flex items-center">
            <img src="{{asset('images/logo.png')}}" class="h-16 mr-3" alt="Logo" />
            <span class="self-center text-3xl font-semibold whitespace-nowrap text-transparent bg-clip-text bg-gradient-to-r to-amber-400 from-lime-500">Board Games</span>
        </a>
        <div class="flex items-center">
            @if(!Auth::user())
                <a href="/login" class="px-5 py-3 rounded-lg shadow-md mr-6 text-amber-700 bg-amber-400 hover:text-amber-100">Login</a>
                <a href="/register" class="px-5 py-3 rounded-lg shadow-md mr-6 text-amber-700 bg-amber-400 hover:text-amber-100">Register</a>
            @else
                <a href="/profile" class="px-5 py-3 rounded-lg shadow-md mr-6 text-amber-700 bg-amber-400 hover:text-amber-100">Profile</a>
                <a href="/logout" class="px-5 py-3 rounded-lg shadow-md mr-6 text-amber-700 bg-amber-400 hover:text-amber-100">Logout</a>
            @endif
        </div>
    </div>
</nav>
<br>
<!--Menu bar-->
<nav>
    <div class="flex flex-col items-center">
    <div class="w-10/12 bg-lime-500 rounded px-4 py-3 mx-auto md:px-6 shadow-md">

        <div class="flex flex-wrap justify-between items-center">
            <ul class="flex flex-row mt-0 mr-6 space-x-8 font-medium text-lime-100 items-center">
                <li>
                    <a href="/" class="hover:text-lime-700 font-semibold" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="/library" class="hover:text-lime-700 font-semibold">Library</a>
                </li>
                <li>
                    <a href="/events" class="hover:text-lime-700 font-semibold">Events</a>
                </li>
                <li>
                    <a href="/auctions" class="hover:text-lime-700 font-semibold">Market</a>
                </li>
                <li>
                    <a href="/places" class="hover:text-lime-700 font-semibold">Places to play</a>
                </li>
            </ul>
            <!--Search bar-->
            <div class="float-right">
                <form class="flex items-center" method="GET" action="{{url('search')}}" role="search">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="search" id="search" name="search" value="{{Request::get('search')}}" class="bg-lime-100 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-lime-700 block w-full pl-10 p-2.5" placeholder="Search">
                    </div>
                    <button type="submit" id="search_main" class="p-2.5 ml-2 text-sm font-medium text-white bg-lime-200 text-lime-700 rounded-lg hover:bg-lime-700 hover:text-lime-200 focus:outline-none focus:ring-lime-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span class="sr-only">Search</span>
                    </button>
                </form>

            </div>
        </div>
    </div>
    </div>
</nav>
<br>
