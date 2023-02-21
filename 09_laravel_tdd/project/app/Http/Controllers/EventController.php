<?php

namespace App\Http\Controllers;

use App\Helpers\Convert;
use App\Helpers\HasEnsure;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class EventController extends Controller
{
    use HasEnsure;
    use Convert;

    public function index(): View
    {
        $events = Event::all();
        return view('events.index')->with('events', $events->where('accepted', '=', '1')->sortBy(['date', 'time']))->with('title', 'Events');
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function edit(Event $event): View
    {
        return view('events.edit')->with('event', $event);
    }

    /**
     * @return Collection<int, Event>
     */
    private function loadPart_Events(): Collection
    {
        $part_events = $this->ensureIsUser(User::find(Auth::id()))->events;
        return $part_events->where('accepted', '=', '1');
    }

    /**
     * @return Collection<int, Event>
     */
    private function loadYour_Events(): Collection
    {
        return $this->ensureIsUser(User::find(Auth::id()))->myEvents->sortBy('event_title');
    }

    public function update_event(Request $request, int $id): View
    {
        $event=Event::find($id);
        EventController::validation($request);
        if ($event != null) {
            $this->updateAndSave($this->ensureIsEvent($event), $request);
        }
        //return Redirect::route('profile.events')->with('message', 'Your event was updated.');
        //$part_events = EventController::loadPart_Events();
        //$your_events = EventController::loadYour_Events();
        return view('profile.events')->with('title', 'Your Events')->with('your_events', EventController::loadYour_Events())->with('part_events', EventController::loadPart_Events()->sortBy('title'))->with('message', 'Your event was updated!');
    }

    public function destroy(int $id): View
    {
        $event = Event::find($id);
        if ($event != null) {
            $event->delete();
        }
        if (str_contains(url()->previous(), "profile")) {
            //$part_events = $this->ensureIsUser(User::find(Auth::id()))->events;
            $your_events = EventController::loadYour_Events();
            return view('profile.events')->with('title', 'Your Events')->with('your_events', $your_events)->with('part_events', EventController::loadPart_Events()->sortBy('title'))->with('message', 'Your event was deleted!');
        }
        $events = Event::all();
        return view('events.index')->with('title', 'Events')->with('message', 'Event was deleted!')->with('events', $events->where('accepted', '==', '1')->sortBy(['date', 'time']));
    }

    public function show(int $id): View
    {
        $event = Event::find($id);
        return view('events.show')->with('event', $event)->with("message_planning", "You are planning to join this event")->with('title', $this->ensureIsEvent($event)->title);
    }

    public function validation(Request $request): void
    {
        $request->validate([
            'event_title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'city' => 'required',
            'date' => 'required|after:today',
            'time' => 'required',
            'size' => 'required'
        ]);
    }

    private function updateAndSave(Event $event, Request $request): void
    {
        $event->title=$this->ensureIsString($request->event_title);
        $event->description=$this->ensureIsString($request->description);
        $event->location=$this->ensureIsString($request->location);
        $event->city=$this->ensureIsString($request->city);
        $event->date=$this->ensureIsString($request->date);
        $event->time=$this->ensureIsString($request->time);
        $size = $this->convertString($request->size);
        $event->size=$this->ensureIsInteger($size);
        $event->creator_id=$this->ensureIsInteger(Auth::id());
        $event->save();
    }

    public function store(Request $request): View
    {
        EventController::validation($request);
        $event = new Event();
        $message = "Wait for admin to accept your event!";
        if ($this->ensureIsUser(Auth::user())->admin) {
            $message = "Event added!";
            $event->accepted = 1;
        }
        $this->updateAndSave($event, $request);
        $events = Event::all();
        return view('events.index')->with('title', 'Events')->with('events', $events->where('accepted', '==', '1')->sortBy(['date', 'time']))->with("message", $message);
    }

    public function update(int $id): View
    {
        $user = $this->ensureIsNotNullUser(Auth::user());
        $event = $this->ensureIsEvent(Event::find($id));
        if (!$event->users->contains($this->ensureIsInteger(Auth::id()))) {
            $event->users()->save($user);
        }
        return view('events.show')->with('event', $event)->with('message', 'Thank you for joining the event!');
    }

    public function cancel(int $id): RedirectResponse|view
    {
        $user = $this->ensureIsNotNullUser(Auth::user());
        $event = $this->ensureIsEvent(Event::find($id));
        $event->users()->detach($user);
        if (str_contains(url()->previous(), "profile")) {
            $your_events = $this->ensureIsUser(User::find(Auth::id()))->myEvents->sortBy('event_title');
            $part_events = $this->ensureIsUser(User::find(Auth::id()))->events->where('accepted', '=', '1')->sortBy('title');
            return view('profile.events')->with('title', 'Your Events')->with('your_events', $your_events)->with('part_events', $part_events)->with('message', 'Your submission for this event was cancelled');
        } elseif (str_contains(url()->previous(), 'events')) {
            return view('events.show')->with('event', $event)->with('message', 'Your submission for this event was cancelled');
        }
        return view('events.show')->with('event', $event)->with('message', 'Your submission for this event was cancelled');
    }

    public static function numberOfAttendees(int $event_id): int
    {
        return DB::table('event_user')->where('event_id', '=', $event_id)->count();
    }
}
