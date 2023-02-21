<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test04_EventsCest
{
    public function Events(AcceptanceTester $I): void
    {
        //creating event
        $I->amOnPage("/events");
        $I->see('Events');
        $I->see('Want to make an event?', 'h5');
        $I->see('Login', 'a');
        $I->click('Add new event here!');
        $I->seeCurrentUrlEquals("/login");
        $I->fillField('email', 'john.doe@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/events/create');

        $I->click('Create event');
        $I->seeCurrentUrlEquals('/events/create');
        $I->see('The event title field is required.', 'li');
        $I->see('The city field is required.', 'li');
        $I->see('The location field is required.', 'li');
        $I->see('The description field is required.', 'li');
        $I->see('The date field is required.', 'li');
        $I->see('The time field is required.', 'li');
        $I->see('The size field is required.', 'li');

        $title="Playing Uno";
        $city="Krakow";
        $location="Boardowa";
        $description="We want to play Uno in a big group";
        $old_date='2022-02-02';
        $time='18:00';
        $size='50';

        $I->fillField('event_title', $title);
        $I->fillField('city', $city);
        $I->fillField('location', $location);
        $I->fillField('description', $description);
        $I->fillField('date', $old_date);
        $I->fillField('time', $time);
        $I->fillField('size', $size);
        $I->click('Create event');

        $I->see('The date must be a date after today.', 'li');
        $I->dontSee('The event title field is required.', 'li');
        $I->dontSee('The city field is required.', 'li');
        $I->dontSee('The location field is required.', 'li');
        $I->dontSee('The description field is required.', 'li');
        $I->dontSee('The date field is required.', 'li');
        $I->dontSee('The time field is required.', 'li');
        $I->dontSee('The size field is required.', 'li');

        $I->seeInField('event_title', $title);
        $I->seeInField('location', $location);
        $I->seeInField('description', $description);
        $I->seeInField('date', $old_date);
        $I->seeInField('time', $time);
        $I->seeInField('size', $size);

        $date='2023-02-02';
        $I->fillField('date', $date);
        $I->click('Create event');

        $I->seeCurrentUrlEquals('/events');
        $I->see("Check icon Wait for admin to accept your event!");
        $I->seeInDatabase('events', [
            'title' => $title,
            'city' => $city,
            'location' => $location,
            'description' => $description,
            'date' => $date,
            'time' => $time,
            'size' => $size
        ]);
        $I->dontSee($title);

        //checking specific event as creator
        $I->click(['id'=>'first_image']);
        $I->seeCurrentUrlEquals('/events/1');
        $I->see("Carcassonne lovers");
        $I->seeInDatabase('events', [
            'id'=>1,
            'creator_id'=>1
        ]);
        $I->dontSeeInDatabase('event_user', ['user_id'=>'1']);
        $I->see("You're organizing this event!");
        $I->seeElement('#join:disabled');

        //checking specific event as guest
        $I->click('Logout');
        $I->amOnPage("/events");
        $I->see('Events');
        $I->click(['id'=>'first_image']);
        $I->seeCurrentUrlEquals('/events/1');
        $I->see("Carcassonne lovers");
        $I->see("Login to join this event!");
        $I->seeElement('#join:disabled');

        //checking specific event as participant
        $I->click("Login");
        $I->fillField('email', 'adam@gmail.com');
        $I->fillField('password', 'skarpetki');
        $I->click('Log in');
        $I->amOnPage("/events");
        $I->see('Events');
        $I->click(['id'=>'first_image']);
        $I->seeCurrentUrlEquals('/events/1');
        $I->see("Carcassonne lovers");
        $I->dontSee("Login to join this event!");
        $I->dontSee("You're organizing this event!");
        $I->dontSeeElement('#join:disabled');
        $I->seeElement('#join');
        $I->dontSeeElement('#delete');

        //joining event
        $I->see('0/50');
        $I->see('Join this event!', 'button');
        $I->dontSeeElement('#cancel');
        $I->dontSeeInDatabase('event_user', ['user_id'=>'5']);
        $I->click('Join this event!');
        $I->seeinDataBase('event_user', ['user_id'=>'5']);
        $I->see('1/50');
        $I->see('Check icon Thank you for joining the event!');
        $I->dontSee('Join this event!', 'button');
        $I->seeElement('#cancel');

        //canceling joining event
        $I->click('Cancel');
        $I->dontSeeInDatabase('event_user', ['user_id'=>'5']);
        $I->see('Check icon Your submission for this event was cancelled');
        $I->see('0/50');
        $I->see('Join this event!', 'button');
        $I->dontSeeElement('#cancel');
        $I->click('Join this event!');

        //checking specific event as admin
        $I->click('Logout');
        $I->click("Login");
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'adminadmin');
        $I->click('Log in');
        $I->amOnPage("/events");
        $I->see('Events');
        $I->see("Carcassonne lovers");
        $I->seeInDatabase('events', ['id'=>1]);
        $I->click(['id'=>'first_image']);
        $I->seeCurrentUrlEquals('/events/1');
        $I->see("Carcassonne lovers");
        $I->see('Join this event!', 'button');
        $I->dontSeeElement('#cancel');
        $I->seeElement('#delete');

        //deleting event by admin
        $I->seeInDatabase('event_user', [
            'user_id'=>5,
            'event_id'=>1
        ]);
        $I->click('#delete');
        $I->see("Are you sure you want to delete this event?");
        $I->see("Delete this event", 'button');
        $I->seeElement('#cancel_delete');
        $I->click('#cancel_delete');
        $I->seeInDatabase('event_user', [
            'user_id'=>5,
            'event_id'=>1
        ]);
        $I->dontSee('Are you sure you want to delete this event?"');
        $I->click('#delete');
        $I->see("Are you sure you want to delete this event?");
        $I->click('Delete this event');
        $I->seeInCurrentUrl("/events");
        $I->see('Event was deleted!');
        $I->dontSee("Carcassonne lovers");
        $I->dontSeeInDatabase('events', ['id'=>1]);
        $I->dontSeeInDatabase('event_user', [
            'user_id'=>5,
            'event_id'=>1
        ]);
    }
}
