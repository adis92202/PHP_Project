<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test03_AuctionsCest
{
    public function Auctions(AcceptanceTester $I): void
    {
        $title = 'Taboo';

        //visit page as guest
        $I->amOnPage("/auctions");
        $I->see("Monopoly");
        $I->see("Everdell");
        $I->see("Robinson Crusoe");
        $I->dontSee("Cluedo");
        $I->dontSee($title);

        $I->see('Please login to see contact information');
        $I->dontSee('E-mail:');
        $I->dontSee('Telephone number:');
        $I->click('Please login to see contact information');
        $I->seeCurrentUrlEquals('/login');

        $I->click('Market');
        $I->seeCurrentUrlEquals("/auctions");
        $I->see('Marketplace');
        $I->see('Want to sell your game?', 'h5');
        $I->click('Add auction here!');

        $I->seeCurrentUrlEquals('/login');
        $email = 'john.doe@gmail.com';
        $I->fillField('email', $email);
        $I->fillField('password', 'secret');
        $I->click('Log in');

        //add auction
        $I->seeCurrentUrlEquals('/auctions/create');
        $I->seeInField('email', $email);
        $I->click('Create auction');

        $I->seeCurrentUrlEquals('/auctions/create');
        $I->see('The description field is required.', 'li');
        $I->see('The game title field is required.', 'li');
        $I->see('The price field is required.', 'li');
        $I->see('The phone field is required.', 'li');
        $I->dontSee('The phone must be 9 digits.', 'li');
        $I->dontSee('The email field is required.', 'li');
        $I->seeInField('email', $email);
        //$I->see('The state field is required.', 'li');

        $price = 20;
        $description = 'Delivery cost: 2.50$';
        $phone = 123456789;
        $wrong_phone = 123;
        $option = $I->grabTextFrom('select option:nth-child(2)');

        $I->fillField('game_title', $title);
        $I->selectOption('select', $option);
        $I->fillField('price', $price);
        $I->fillField('description', $description);
        $I->fillField('phone', $wrong_phone);
        $I->fillField('email', '');
        $I->click('Create auction');

        $I->seeCurrentUrlEquals('/auctions/create');
        $I->dontSee('The description field is required.', 'li');
        $I->dontSee('The game title field is required.', 'li');
        $I->dontSee('The price field is required.', 'li');
        $I->dontSee('The phone field is required.', 'li');
        $I->see('The phone must be 9 digits.', 'li');
        $I->see('The email field is required.', 'li');
        $I->seeInField('email', $email);
        $I->dontSee('The state field is required.', 'li');

        $I->seeInField('select', $option);
        $I->seeInField('game_title', $title);
        $I->seeInField('price', $price);
        $I->seeInField('description', $description);
        $I->seeInField('phone', $wrong_phone);

        $I->fillField('phone', $phone);
        $I->click('Create auction');

        $I->seeCurrentUrlEquals('/auctions');
        $I->seeInDatabase('auctions', [
            'title' => $title,
            'price' => $price,
            'state' => $option,
            'description' => $description,
            'phone' => $phone,
            'email' => 'john.doe@gmail.com'
        ]);

        $I->see('Check icon Wait for admin to accept your auction!');
        $I->see("Monopoly");
        $I->see("Everdell");
        $I->see("Robinson Crusoe");
        $I->dontSee("Cluedo");
        $I->dontSee($title);

        //page as user
        $I->dontSee('Please login to see contact information');
        $I->see('E-mail:');
        $I->see('Telephone number:');

        //visit page as admin
        $I->click('Logout');
        $I->click("Login");
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'adminadmin');
        $I->click('Log in');

        $I->amOnPage("/auctions");
        $I->see('Marketplace');
        $I->dontSee('Please login to see contact information');
        $I->see('E-mail:');
        $I->see('Telephone number:');
        $I->see("Monopoly");
        $I->see("Everdell");
        $I->see("Robinson Crusoe");
        $I->dontSee("Cluedo");
        $I->dontSee($title);

        //deleting event by admin
        $I->seeInDatabase('auctions', [
            'id' => 1,
            'title' => 'Monopoly'
        ]);
        $I->seeElement('#delete_1');
        $I->click('#delete_1');
        $I->see("Are you sure you want to delete this auction?");
        $I->see("Delete this auction", 'button');
        $I->seeElement('#cancel_delete');
        $I->click('#cancel_delete');
        $I->seeInDatabase('auctions', [
            'id' => 1,
            'title' => 'Monopoly'
        ]);
        $I->dontSee('Are you sure you want to delete this auction?"');

        $I->click('#delete_1');
        $I->see("Are you sure you want to delete this auction?");
        $I->see("Delete this auction", 'button');
        $I->click('Delete this auction');
        $I->seeInCurrentUrl("/auctions");
        $I->see('Auction was deleted');
        $I->dontSee("Monopoly");
        $I->see("Everdell");
        $I->see("Robinson Crusoe");
        $I->dontSee("Cluedo");
        $I->dontSee($title);
        $I->dontSeeInDatabase('auctions', [
            'id' => 1,
            'title' => 'Monopoly'
        ]);
    }
}
