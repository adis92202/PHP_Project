<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test08_CommentsAndRatingsCest
{
    public function CommentsAndRatings(AcceptanceTester $I): void
    {
        //game page as quest
        $I->amOnPage("/library");
        $I->see('Title', 'th');
        $I->see('Monopoly', 'th');

        $I->click('More', ['id' => 'more_1']);
        $I->seeCurrentUrlEquals('/library/1');
        $I->see('Please login to comment');
        $I->see('Login to add your rating');
        $I->seeElement('#add_rating:disabled');
        $I->seeElement('#add_comment:disabled');

        //login
        $I->click("Login");
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'john.doe@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');

        //check library
        $I->amOnPage('/library');
        $I->see('Rating star N/A');
        $I->see('Rating star 4.4');
        $I->dontSee('Rating star 3');
        $I->dontSee('Rating star 3.8');
        $I->see('0 reviews');
        $I->see('5 reviews');
        $I->dontSee('1 reviews');

        //change rating
        $I->amOnPage("/library/1");
        $I->see("Average rating of 4.4", 'p');
        $I->see("with 5 reviews");
        $I->seeInDatabase('ratings', [
            'user_id' => 1,
            'rating' => 5,
            'game_id' => 1
        ]);
        $I->see('Change rating');
        $I->dontSee('Add rating');
        $I->dontSeeElement('#star1:checked');
        $I->dontSeeElement('#star2:checked');
        $I->dontSeeElement('#star3:checked');
        $I->dontSeeElement('#star4:checked');
        $I->seeElement('#star5:checked');
        $I->selectOption('input[name="rating"]', "2");
        $I->click('Change rating');
        $I->see('Your rating was added');
        $I->dontSeeElement('#star1:checked');
        $I->seeElement('#star2:checked');
        $I->dontSeeElement('#star3:checked');
        $I->dontSeeElement('#star4:checked');
        $I->dontSeeElement('#star5:checked');
        $I->seeInDatabase('ratings', [
            'user_id' => 1,
            'rating' => 2,
            'game_id' => 1
        ]);
        $I->dontSeeInDatabase('ratings', [
            'user_id' => 1,
            'rating' => 5,
            'game_id' => 1
        ]);
        $I->see("Average rating of 3.8", 'p');
        $I->see("with 5 reviews");

        //add rating
        $I->amOnPage("/library/5");
        $I->see('Average rating of N/A', 'p');
        $I->see('with 0 reviews');
        $I->dontSee('Change rating');
        $I->see('Add rating');
        $I->dontSeeElement('#star1:checked');
        $I->dontSeeElement('#star2:checked');
        $I->dontSeeElement('#star3:checked');
        $I->dontSeeElement('#star4:checked');
        $I->dontSeeElement('#star5:checked');
        $I->click('Add rating');
        $I->see('The rating field is required.');
        $I->dontSeeElement('#star1:checked');
        $I->dontSeeElement('#star2:checked');
        $I->dontSeeElement('#star3:checked');
        $I->dontSeeElement('#star4:checked');
        $I->dontSeeElement('#star5:checked');

        $I->selectOption('input[name="rating"]', "3");
        $I->click('Add rating');
        $I->see('Your rating was added');
        $I->dontSeeElement('#star1:checked');
        $I->dontSeeElement('#star2:checked');
        $I->seeElement('#star3:checked');
        $I->dontSeeElement('#star4:checked');
        $I->dontSeeElement('#star5:checked');
        $I->seeInDatabase('ratings', [
            'user_id' => 1,
            'rating' => 3,
            'game_id' => 5
        ]);
        $I->dontSee('Average rating of N/A', 'p');
        $I->dontSee('with 0 reviews');
        $I->see('Average rating of 3', 'p');
        $I->see('with 1 reviews');

        //check library
        $I->amOnPage('/library');
        $I->see('Rating star N/A');
        $I->dontSee('Rating star 4.4');
        $I->see('Rating star 3');
        $I->see('Rating star 3.8');
        $I->see('0 reviews');
        $I->see('5 reviews');
        $I->see('1 reviews');

        //comments
        $I->amOnPage("/library/1");
        $I->see('jdoe', 'div');
        $I->see('admin', 'div');
        $I->see('Leave your review!', 'label');
        $I->see('Brajanek kocha');
        $I->see('Czasochłonna ta gra');
        $text = 'The best game ever!';

        $I->click("Add comment");
        $I->see('The description field is required.');
        $I->fillField('description', $text);
        $I->click('Add comment');
        $I->see('Your comment was added.', 'div');
        $I->seeInDatabase('comments', [
            'user_id' => 1,
            'text' => $text,
            'game_id' => 1
        ]);

        $I->see($text);
        $I->see('Brajanek kocha');
        $I->see('Czasochłonna ta gra');
    }
}
