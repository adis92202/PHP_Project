<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test10_DeleteAllCest
{
    public function DeleteAll(AcceptanceTester $I): void
    {
        //login as admin
        $I->amOnPage('/');
        $I->click('Login');
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'adminadmin');
        $I->click('Log in');
        $I->see('Welcome admin!');

        //deleting all auctions
        $I->click('Market');
        $I->click('#delete_1');
        $I->click('#Delete_yes_1');
        $I->click('#delete_3');
        $I->click('#Delete_yes_3');
        $I->click('#delete_4');
        $I->click('#Delete_yes_4');

        //deleting all events
        $I->click('Events');
        $I->click('#first_image');
        $I->click('#delete');
        $I->click('Delete this event');
        $I->click('Events');
        $I->click('#first_image');
        $I->click('#delete');
        $I->click('Delete this event');
        $I->click('Events');
        $I->click('#first_image');
        $I->click('#delete');
        $I->click('Delete this event');
        $I->click('Events');
        $I->click('#first_image');
        $I->click('#delete');
        $I->click('Delete this event');
        $I->click('Events');
        $I->see("No events planned yet! Be the first one!");

        //deleting all games
        $I->click('Library');
        $I->click('#delete_1');
        $I->click('#Delete_yes_1');
        $I->click('#delete_2');
        $I->click('#Delete_yes_2');
        $I->click('#delete_3');
        $I->click('#Delete_yes_3');
        $I->click('#delete_4');
        $I->click('#Delete_yes_4');
        $I->click('#delete_5');
        $I->click('#Delete_yes_5');
    }
}
