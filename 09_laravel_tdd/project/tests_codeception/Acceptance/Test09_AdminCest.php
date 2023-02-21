<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test09_AdminCest
{
    public function Admin(AcceptanceTester $I): void
    {
        //login as admin
        $I->amOnPage('/');
        $I->click('Login');
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'adminadmin');
        $I->click('Log in');
        $I->see('Welcome admin!');
        $I->click('Profile');
        $I->see('Acceptance');

        //settings as admin
        $I->click('Settings');
        $I->see('Delete your account');
        $I->see("You can't delete your account, you're the only admin.");
        $I->seeElement('#delete:disabled');

        //create auction as admin
        $title_au = 'Taboo';
        $price = 20;
        $description = 'Delivery cost: 2.50$';
        $phone = 123456789;

        $I->amOnPage('/auctions');
        $I->dontSee($title_au);

        $I->amOnPage('/auctions/create');
        $option = $I->grabTextFrom('select option:nth-child(2)');
        $I->fillField('game_title', $title_au);
        $I->selectOption('select', $option);
        $I->fillField('price', $price);
        $I->fillField('description', $description);
        $I->fillField('phone', $phone);
        $I->fillField('email', 'admin@gmail.com');
        $I->click('Create auction');

        $I->seeCurrentUrlEquals('/auctions');
        $I->see('Check icon Auction added!');
        $I->see($title_au);
        $I->seeInDatabase('auctions', [
            'title' => $title_au,
            'price' => $price,
            'state' => $option,
            'description' => $description,
            'phone' => $phone,
            'email' => 'admin@gmail.com',
            'accepted' => 1
        ]);

        //creating event as admin
        $title_ev="Playing Uno";
        $city="Krakow";
        $location="Boardowa";
        $description="We want to play Uno in a big group";
        $time='18:00';
        $date='2023-02-02';
        $size='50';

        $I->amOnPage("/events");
        $I->dontSee($title_ev);

        $I->amOnPage('/events/create');
        $I->fillField('event_title', $title_ev);
        $I->fillField('city', $city);
        $I->fillField('location', $location);
        $I->fillField('description', $description);
        $I->fillField('date', $date);
        $I->fillField('time', $time);
        $I->fillField('size', $size);
        $I->click('Create event');

        $I->seeCurrentUrlEquals('/events');
        $I->see("Check icon Event added!");
        $I->see($title_ev);
        $I->seeInDatabase('events', [
            'title' => $title_ev,
            'city' => $city,
            'location' => $location,
            'description' => $description,
            'date' => $date,
            'time' => $time,
            'size' => $size,
            'accepted' => 1
        ]);

        //creating game as admin
        $title_ga = "Fury of Dracula";
        $description = 'Classic horror deduction game.';
        $year = 2015;
        $time = 180;
        $players = '2-5';

        $I->amOnPage("/library");
        $I->dontSee($title_ga);

        $I->amOnPage('/library/create');
        $option = $I->grabTextFrom('select option:nth-child(9)');
        $I->fillField('title', $title_ga);
        $I->selectOption('select', $option);
        $I->fillField('year', $year);
        $I->fillField('description', $description);
        $I->fillField('time', $time);
        $I->fillField('players', $players);
        $I->click('Add game');

        $I->seeCurrentUrlEquals('/library');
        $I->see("Check icon Game added!");
        $I->see($title_ga);
        $I->seeInDatabase('games', [
            'title' => $title_ga,
            'category' => $option,
            'year' => $year,
            'description' => $description,
            'time' => $time,
            'players' => $players,
            'accepted' => 1
        ]);

        //admin profile
        $I->click('Profile');
        $I->click('Auctions');
        $I->see('Accepted');
        $I->see($title_au);
        $I->click('Events', 'button');
        $I->see('Accepted');
        $I->see($title_ev);

        $I->click('Acceptance');
        $I->dontSee($title_au);
        $I->dontSee($title_ev);

        $I->click('Logout');

        //login as user
        $I->amOnPage('/');
        $I->click('Login');
        $I->fillField('email', 'adam@gmail.com');
        $I->fillField('password', 'skarpetki');
        $I->click('Log in');
        $I->see('Welcome AdamP!');

        //creating event as user
        $title = 'Playing Dracula';
        $description = 'Looking for four people to kill Dracula';
        $date = '2023-02-17';
        $time = '10:00:00';
        $size = 5;

        $I->amOnPage("/events");
        $I->dontSee($title);

        $I->amOnPage('/events/create');
        $I->fillField('event_title', $title);
        $I->fillField('city', $city);
        $I->fillField('location', $location);
        $I->fillField('description', $description);
        $I->fillField('date', $date);
        $I->fillField('time', $time);
        $I->fillField('size', $size);
        $I->click('Create event');

        $I->seeCurrentUrlEquals('/events');
        $I->see("Check icon Wait for admin to accept your event!");
        $I->dontSee($title);
        $I->seeInDatabase('events', [
            'title' => $title,
            'city' => $city,
            'location' => $location,
            'description' => $description,
            'date' => $date,
            'time' => $time,
            'size' => $size,
            'accepted' => 0
        ]);
        $I->click('Logout');

        //accepting
        $I->amOnPage('/');
        $I->click('Login');
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'adminadmin');
        $I->click('Log in');
        $I->see('Welcome admin!');
        $I->click('Profile');
        $I->click('Acceptance');

        //acceptance
        $I->click('Acceptance');
        $I->seeCurrentUrlEquals('/profile/acceptance');
        $I->see('Games:');
        $I->see('Scythe');
        $I->dontSee($title_ga);
        $I->see('Events');
        $I->see($title);
        $I->dontSee($title_ev);
        $I->see('Auctions');
        $I->see('Cluedo');
        $I->dontSee($title_au);

        $I->click('#accept_game6');
        $I->click('#accept_event6');
        $I->click('#decline_auction2');

        $I->see('No games to accept');
        $I->see('No events to accept');
        $I->see('No auctions to accept');

        $I->amOnPage('/library');
        $I->see('Scythe');
        $I->amOnPage('/events');
        $I->see($title);
        $I->amOnPage('/auctions');
        $I->dontSee('Cludeo');
    }
}
