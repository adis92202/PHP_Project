<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test07_LibraryCest
{
    public function Library(AcceptanceTester $I): void
    {
        //adding new game
        $I->amOnPage("/library");
        $I->see('Login', 'a');
        $I->see('Library');
        $I->see('Title', 'th');
        $I->see('Category', 'th');
        $I->see('Rating', 'th');
        $I->see('Time', 'th');
        $I->see('Players', 'th');

        $I->see('Patchwork');
        $I->see('Anachrony');
        $I->see('Cluedo');
        $I->see('Codenames');
        $I->see('Monopoly');

        $I->dontSee('Edit', 'button');
        $I->dontSeeElement('#delete_2');

        $I->see("Can't see your favourite game?");
        $I->click('Add it here!');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'john.doe@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/library/create');
        $I->see('Adding new game');

        $I->click('Add game');
        $I->see('The title field is required.');
        $I->see('The description field is required.');
        $I->see('The year field is required.');
        $I->see('The time field is required.');
        $I->see('The players field is required.');
        $I->dontSee('The year must be 4 digits.');
        $I->dontSee('The time must be between 2 and 3 digits.');

        $title = "Terraforming Mars";
        $wrong_year = 202;
        $year = 2021;
        $description = "Terraform planet";
        $time = 180;
        $players = "3-5";
        $option = $I->grabTextFrom('select option:nth-child(2)');
        $wrong_time1 = 5;
        $wrong_time2 = 1000;

        $I->dontSeeInDatabase('games', [
            'title' => $title,
            'category' => $option,
            'year' => 2021,
            'description' => $description,
            'time' => 180,
            'players'=> $players,
            'accepted' => 0
        ]);

        $I->fillField('title', $title);
        $I->fillField('year', $wrong_year);
        $I->fillField('description', $description);
        $I->fillField('time', $wrong_time1);
        $I->fillField('players', $players);
        $I->selectOption('select', $option);

        $I->click('Add game');
        $I->dontSee('The title field is required.');
        $I->dontSee('The description field is required.');
        $I->dontSee('The year field is required.');
        $I->dontSee('The time field is required.');
        $I->dontSee('The players field is required.');
        $I->see('The year must be 4 digits.');
        $I->see('The time must be between 2 and 3 digits.');

        $I->seeInField('title', $title);
        $I->seeInField('year', $wrong_year);
        $I->seeInField('description', $description);
        $I->seeInField('time', $wrong_time1);
        $I->seeInField('players', $players);
        $I->seeInField('select', $option);

        $I->fillField('year', $year);
        $I->fillField('time', $wrong_time2);

        $I->click('Add game');
        $I->dontSee('The title field is required.');
        $I->dontSee('The description field is required.');
        $I->dontSee('The year field is required.');
        $I->dontSee('The time field is required.');
        $I->dontSee('The players field is required.');
        $I->dontSee('The year must be 4 digits.');
        $I->see('The time must be between 2 and 3 digits.');

        $I->seeInField('title', $title);
        $I->seeInField('year', $year);
        $I->seeInField('description', $description);
        $I->seeInField('time', $wrong_time2);
        $I->seeInField('players', $players);
        $I->seeInField('select', $option);

        $I->fillField('time', $time);
        $I->click('Add game');
        $I->seeCurrentUrlEquals('/library');
        $I->see('Wait for admin to accept the game!');
        $I->dontSee($title);

        $I->seeInDatabase('games', [
            'title' => $title,
            'category' => $option,
            'year' => 2021,
            'description' => $description,
            'time' => 180,
            'players'=> $players,
            'accepted' => 0
        ]);

        //adding different edition game
        $I->amOnPage('/library/create');

        $old_title = 'Monopoly';
        $old_year = '1935';
        $new_year = '2020';
        $description = "An old classic with a new look";
        $time = 90;
        $players = '2-6';

        $I->dontSeeInDatabase('games', [
            'title' => $old_title,
            'year' => $new_year,
        ]);
        $I->seeInDatabase('games', [
            'title' => $old_title,
            'year' => $old_year,
        ]);

        $I->fillField('title', $old_title);
        $I->fillField('year', $old_year);
        $I->fillField('description', $description);
        $I->fillField('time', $time);
        $I->fillField('players', $players);
        $I->selectOption('select', $option);

        $I->click('Add game');
        $I->see('The title has already been taken.');

        $I->fillField('year', $new_year);

        $I->click('Add game');
        $I->seeCurrentUrlEquals('/library');
        $I->see('Wait for admin to accept the game!');
        $I->see($old_title);
        $I->see($old_year);
        $I->dontSee($new_year);

        $I->seeInDatabase('games', [
            'title' => $old_title,
            'year' => $new_year,
        ]);
        $I->seeInDatabase('games', [
            'title' => $old_title,
            'year' => $old_year,
        ]);

        //game page
        $title_c = 'Cluedo';
        $category_c = 'Murder/Mystery';
        $year_c = 1949;
        $time_c = 45;
        $players_c = '2-6';

        $I->click('More', ['id' => 'more_2']);
        $I->seeCurrentUrlEquals('/library/2');
        $I->see($title_c.'('.$year_c.')');
        $I->see('Category: '.$category_c, 'p');
        $I->see('Play time: '.$time_c.' minutes', 'p');
        $I->see('Number of players: '.$players_c, 'p');

        //as user
        $I->see("Add to your games");
        $I->dontSee('This game is already in your games');
        $I->dontSeeElement('#add_game:disabled');
        $I->see('0 of players have this game', 'p');
        $I->dontSeeInDatabase('game_user', ['game_id' => 2, 'user_id' => 1]);

        $I->click('Add to your games');
        $I->see('Added to your games.');
        $I->see('1 of players have this game');
        $I->dontSee("Add to your games");
        $I->see('This game is already in your games');
        $I->seeElement('#add_game:disabled');
        $I->seeInDatabase('game_user', ['game_id' => 2, 'user_id' => 1]);

        //as guest
        $I->click('Logout');
        $I->amOnPage('/library/2');
        $I->see("Add to your games");
        $I->dontSee('This game is already in your games');
        $I->seeElement('#add_game:disabled');
        $I->see('1 of players have this game', 'p');

        //library as admin
        $I->click("Login");
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'adminadmin');
        $I->click('Log in');

        $I->amOnPage('/library');
        $I->see('Edit', 'button');
        $I->see('Delete', 'button');
        $I->see($title_c.'('.$year_c.')');
        $I->see($category_c);
        $I->see($time_c.' Min');
        $I->see($players_c);

        $I->seeInDatabase('games', [
            'title' => $title_c,
            'year' => $year_c,
        ]);

        //editing game
        $I->click('#edit_2');
        $I->see('Edit game');
        $I->seeInField('title', $title_c);
        $I->seeInField('year', $year_c);
        $I->seeInField('time', $time_c);
        $I->seeInField('players', $players_c);
        $I->seeInField('select', $category_c);

        $title_c2 = 'Sherlock Holmes';
        $year_c2 = 2012;

        $I->fillField('title', $title_c2);
        $I->fillField('year', $year_c2);

        $I->click('Edit game');
        $I->see('Game was updated');

        $I->dontSee($title_c.'('.$year_c.')');
        $I->see($title_c2.'('.$year_c2.')');
        $I->see($category_c);
        $I->see($time_c.' Min');
        $I->see($players_c);

        $I->dontSeeInDatabase('games', [
            'title' => $title_c,
            'year' => $year_c,
        ]);
        $I->seeInDatabase('games', [
            'title' => $title_c2,
            'year' => $year_c2,
        ]);

        //deleting game
        $I->click('#delete_2');
        $I->see("Are you sure you want to delete this game?");
        $I->see("Delete this game", 'button');
        $I->seeElement('#cancel_delete');
        $I->click('#cancel_delete');
        $I->seeInDatabase('games', [
            'title' => $title_c2,
            'year' => $year_c2,
        ]);
        $I->dontSee('Are you sure you want to delete this game?"');
        $I->click('#delete_2');
        $I->see("Are you sure you want to delete this game?");
        $I->click('#Delete_yes_2');
        $I->seeInCurrentUrl("/library");
        $I->see('Game was deleted!');
        $I->dontSee($title_c2.'('.$year_c2.')');
        $I->dontSeeInDatabase('games', [
            'title' => $title_c2,
            'year' => $year_c2,
        ]);
    }
}
