<div class="mb-4 border-b-2 border-lime-300 text-lime-800">
    <ul class="flex flex-wrap -mb-px text-xl font-medium text-center">
        <li class="mr-2">
            <a href="/profile"><button class="inline-block p-4 rounded-t-lg focus:outline-none {{($title == 'Profile') ? 'border-b-2 border-b-lime-500 bg-lime-100' : 'hover:border-b-2 hover:border-b-lime-500 hover:bg-lime-100'}}">Profile</button></a>
        </li>
        <li class="mr-2">
            <a href="/profile/games"><button class="inline-block p-4 rounded-t-lg focus:outline-none {{($title == 'Your Games') ? 'border-b-2 border-b-lime-500 bg-lime-100' : 'hover:border-b-2 hover:border-b-lime-500 hover:bg-lime-100'}}">Games</button></a>
        </li>
        <li class="mr-2">
            <a href="/profile/events"><button class="inline-block p-4 rounded-t-lg focus:outline-none {{($title == 'Your Events') ? 'border-b-2 border-b-lime-500 bg-lime-100' : 'hover:border-b-2 hover:border-b-lime-500 hover:bg-lime-100'}}">Events</button></a>
        </li>
        <li class="mr-2">
            <a href="/profile/auctions"><button class="inline-block p-4 rounded-t-lg focus:outline-none {{($title == 'Your Auctions') ? 'border-b-2 border-b-lime-500 bg-lime-100' : 'hover:border-b-2 hover:border-b-lime-500 hover:bg-lime-100'}}">Auctions</button></a>
        </li>
        <li class="{{Auth::user()->admin ? 'mr-2' : ''}}">
            <a href="/profile/settings"><button class="inline-block p-4 rounded-t-lg focus:outline-none {{($title == 'Settings') ? 'border-b-2 border-b-lime-500 bg-lime-100' : 'hover:border-b-2 hover:border-b-lime-500 hover:bg-lime-100'}}">Settings</button></a>
        </li>
        @if(Auth::user()->admin)
            <li>
                <a href="/profile/acceptance"><button class="inline-block p-4 rounded-t-lg focus:outline-none {{($title == 'Acceptance') ? 'border-b-2 border-b-lime-500 bg-lime-100' : 'hover:border-b-2 hover:border-b-lime-500 hover:bg-lime-100'}}">Acceptance</button></a>
            </li>
        @endif
    </ul>
</div>
