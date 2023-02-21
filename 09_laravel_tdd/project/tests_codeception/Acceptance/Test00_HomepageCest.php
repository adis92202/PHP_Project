<?php

namespace TestsCodeception\Acceptance;

use App\Models\Event;
use TestsCodeception\Support\AcceptanceTester;

class Test00_HomepageCest
{
    public function homepageTest(AcceptanceTester $I): void
    {
        //homepage as guest
        $I->amOnPage('/');
        $I->see('Login', 'a');
        $I->see('Register', 'a');
        $I->dontSee('Profile', 'a');
        $I->dontSee('Logout', 'a');
        $I->see('Welcome player!');

        //homepage as user
        $I->click("Login");
        $I->fillField('email', 'adam@gmail.com');
        $I->fillField('password', 'skarpetki');
        $I->click('Log in');
        $I->amOnPage("/");
        $I->see('Welcome AdamP!');

        //closest event
        $title = 'Playing Dracula';
        $description = 'Looking for four people to kill Dracula';
        $location = 'Boardowa';
        $city = 'Krakow';
        $date = date('y-m-d');
        $time = '10:00';
        $size = 5;

        $I->haveInDatabase('events', [
            'title' => $title,
            'location' => $location,
            'city' => $city,
            'description' => $description,
            'date' => $date,
            'time' => $time,
            'size' => $size,
            'accepted' => true,
            'creator_id' => 1
        ]);

        $I->amOnPage('/');
        $I->see("This event starts soon!");
        $I->see($title);
        $I->click("Check it out!");
        $I->seeCurrentUrlEquals("/events/5");
        $I->see($title);

        //newest games
        $title1 = "Fury of Dracula";
        $category1 = 'Horror';
        $description1 = 'Classic horror deduction game.';
        $year1 = 2015;
        $time1 = 180;
        $players1 = '2-5';
        $created_at1 = date("Y-m-d H:i:s", strtotime("-4 days"));

        $title2 = "Eldritch Horror";
        $category2 = 'Horror';
        $description2 = 'Cooperative game of Lovecraft horror.';
        $year2 = 2013;
        $time2 = 240;
        $players2 = '1-8';

        $title3 = "Spirit Island";
        $category3 = 'Fantasy';
        $description3 = 'Complex and thematic cooperative game about defending your island home from colonizing Invaders.';
        $year3 = 2017;
        $time3 = 120;
        $players3 = '1-4';

        $title4 = "Spirits of the Forest";
        $category4 = 'Strategy';
        $description4 = 'Players represent the four elements that nourish the forces of nature.';
        $year4 = 2018;
        $time4 = 20;
        $players4 = '1-4';

        $title5 = "Ramen Fury";
        $category5 = 'Cards';
        $description5 = 'Rush to prepare and slurp up delicious bowls of ramen filled with tasty ingredients.';
        $year5 = 2019;
        $time5 = 30;
        $players5 = '2-5';

        $I->amOnPage('/');
        $I->dontSee($title1);
        $I->dontSee($title2);
        $I->dontSee($title3);
        $I->dontSee($title4);
        $I->dontSee($title5);

        $I->haveInDatabase('games', [
            'title' => $title1,
            'category' => $category1,
            'description' => $description1,
            'year' => $year1,
            'time' => $time1,
            'players' => $players1,
            'accepted' => 1,
            'created_at' => $created_at1
        ]);

        $I->amOnPage('/');
        $I->see($title1);
        $I->dontSee($title2);
        $I->dontSee($title3);
        $I->dontSee($title4);
        $I->dontSee($title5);

        $I->haveInDatabase('games', [
            'title' => $title2,
            'category' => $category2,
            'description' => $description2,
            'year' => $year2,
            'time' => $time2,
            'players' => $players2,
            'accepted' => 1,
            'created_at' => date("Y-m-d H:i:s", strtotime("-3 days"))
        ]);

        $I->amOnPage('/');
        $I->see($title1);
        $I->see($title2);
        $I->dontSee($title3);
        $I->dontSee($title4);
        $I->dontSee($title5);

        $I->haveInDatabase('games', [
            'title' => $title3,
            'category' => $category3,
            'description' => $description3,
            'year' => $year3,
            'time' => $time3,
            'players' => $players3,
            'accepted' => 1,
            'created_at' => date("Y-m-d H:i:s", strtotime("-2 days"))
        ]);

        $I->amOnPage('/');
        $I->see($title1);
        $I->see($title2);
        $I->see($title3);
        $I->dontSee($title4);
        $I->dontSee($title5);

        $I->haveInDatabase('games', [
            'title' => $title4,
            'category' => $category4,
            'description' => $description4,
            'year' => $year4,
            'time' => $time4,
            'players' => $players4,
            'accepted' => 1,
            'created_at' => date("Y-m-d H:i:s", strtotime("-1 days"))
        ]);

        $I->amOnPage('/');
        $I->see($title1);
        $I->see($title2);
        $I->see($title3);
        $I->see($title4);
        $I->dontSee($title5);

        $I->haveInDatabase('games', [
            'title' => $title5,
            'category' => $category5,
            'description' => $description5,
            'year' => $year5,
            'time' => $time5,
            'players' => $players5,
            'accepted' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        $I->amOnPage('/');
        $I->dontSee($title1);
        $I->see($title2);
        $I->see($title3);
        $I->see($title4);
        $I->see($title5);

        $I->click('#game_11');
        $I->seeCurrentUrlEquals("/library/11");
        $I->see($title5);

        //search bar
        /*$I->amOnPage('/library');
        $I->see($title1);
        $I->see($title2);
        $I->see($title3);
        $I->see($title4);
        $I->see($title5);

        $I->amOnPage('/');
        $I->fillField('#search', 'fury');
        $I->click('#search_main');
        $I->seeCurrentUrlEquals('/search?search=fury');
        $I->see($title1);
        $I->see($title5);
        $I->dontSee($title2);
        $I->dontSee($title3);
        $I->dontSee($title4);

        $I->fillField('#search', 'nothing');
        $I->click('#search_main');
        $I->seeCurrentUrlEquals('/search?search=nothing');
        $I->see('Check icon Empty search');
        $I->see('Check icon Empty search');

        $I->amOnPage('/');
        $I->fillField('#search', '');
        $I->click('#search_main');
        $I->seeCurrentUrlEquals('/search?search=');
        $I->dontSee('Check icon Empty search');
        $I->see($title1);
        $I->see($title5);
        $I->see($title2);
        $I->see($title3);
        $I->see($title4);*/
    }
}
