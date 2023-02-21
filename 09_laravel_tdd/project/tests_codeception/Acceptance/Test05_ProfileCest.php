<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test05_ProfileCest
{
    public function Profile(AcceptanceTester $I): void
    {
        //login
        $email = 'agata@gmail.com';
        $password = 'agatkaszmatka';
        $username = $I->grabFromDatabase('users', 'username', ["id" => '4']);
        $city = $I->grabFromDatabase('users', 'city', ["id" => '4']);
        $age = $I->grabFromDatabase('users', 'age', ['id' => '4']);

        $I->amOnPage("/login");
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click('Log in');
        $I->click('Profile');

        //profile page when empty
        $I->seeCurrentUrlEquals('/profile');
        $I->dontSee('Acceptance');
        $I->see("Welcome " . $username);
        $I->see('City: ' . $city);
        $I->see('Age: ' . $age);
        $I->see('You have 0 games');
        $I->see("You're organizing 0 events");
        $I->see("and attending 0 events");
        $I->see("You've posted 0 auctions");
        $I->see("Your average rating is 0");
        $I->see("with 0 reviews");
        $I->see("You've posted 0 comments");

        //creating events
        $I->click('Events', 'button');
        $I->see("You're not organizing any events right now!");
        $I->see("You're not signed up for any events right now!");
        $I->amOnPage("/events/create");

        $title = "Playing Stable Unicorns";
        $city = "Krakow";
        $location = "Krakow al. Adama Mickiewicza 30";
        $description = "Looking for a crazy people to play";
        $date = '2024-05-05';
        $time = '18:00';
        $size = '10';

        $I->fillField('event_title', $title);
        $I->fillField('city', $city);
        $I->fillField('location', $location);
        $I->fillField('description', $description);
        $I->fillField('date', $date);
        $I->fillField('time', $time);
        $I->fillField('size', $size);
        $I->click('Create event');
        $I->see("Check icon Wait for admin to accept your event");

        $I->amOnPage('/profile');
        $I->see('You have 0 games');
        $I->see("You're organizing 1 events");
        $I->see("and attending 0 events");
        $I->see("You've posted 0 auctions");
        $I->see("Your average rating is 0");
        $I->see("with 0 reviews");
        $I->see("You've posted 0 comments");

        $I->amOnPage('/profile/events');
        $I->dontSee("You're not organizing any events right now!");
        $I->see("You're not signed up for any events right now!");
        $I->see("You're organizing:");
        $I->see("Waiting");
        $I->see($title);

        //editing event
        $title2 = "Playing Unstable Unicorns";
        $I->click("Edit");
        $I->seeInField('event_title', $title);
        $I->seeInField('city', $city);
        $I->seeInField('location', $location);
        $I->seeInField('description', $description);
        $I->seeInField('date', $date);
        $I->seeInField('time', '18:00:00');
        $I->seeInField('size', $size);
        $I->fillField('event_title', $title2);
        $I->click("Edit event");
        $I->seeInDatabase('events', ['title' => $title2, 'creator_id' => 4]);
        $I->seeInCurrentUrl("/profile/events");
        $I->see('Your event was updated!');
        $I->dontSee($title);
        $I->see($title2);

        //deleting event
        $I->click("#delete_5");
        $I->see("Are you sure you want to delete your event?");
        $I->see("Delete your event", 'button');
        $I->seeElement('#cancel_delete');
        $I->click('#cancel_delete');
        $I->seeInDatabase('events', ['title' => $title2, 'creator_id' => 4]);
        $I->dontSee('Are you sure you want to delete your event?"');
        $I->click('#delete_5');
        $I->see("Are you sure you want to delete your event?");
        $I->click('Delete your event');
        $I->seeInCurrentUrl("/profile/events");
        $I->see('Your event was deleted!');
        $I->dontSee($title2);
        $I->dontSeeInDatabase('events', ['title' => $title2, 'creator_id' => 4]);

        $I->see("You're not organizing any events right now!");
        $I->see("You're not signed up for any events right now!");

        $I->amOnPage('/profile');
        $I->see('You have 0 games');
        $I->see("You're organizing 0 events");
        $I->see("and attending 0 events");
        $I->see("You've posted 0 auctions");
        $I->see("Your average rating is 0");
        $I->see("with 0 reviews");
        $I->see("You've posted 0 comments");

        //joining event
        $I->amOnPage('/events');
        $I->click(['id' => 'first_image']);
        $I->seeCurrentUrlEquals('/events/1');
        $I->see("Carcassonne lovers");
        $I->click('Join this event!');
        $I->seeInDatabase('event_user', ['event_id' => 1, 'user_id' => 4]);

        $I->amOnPage('/profile');
        $I->see('You have 0 games');
        $I->see("You're organizing 0 events");
        $I->see("and attending 1 events");
        $I->see("You've posted 0 auctions");
        $I->see("Your average rating is 0");
        $I->see("with 0 reviews");
        $I->see("You've posted 0 comments");

        $I->amOnPage('/profile/events');
        $I->see("You're not organizing any events right now!");
        $I->dontSee("You're not signed up for any events right now!");
        $I->see("You're signed up for:");
        $I->see('Carcassonne lovers', 'p');

        //canceling joining event
        $I->click('#cancel_1');
        $I->see("Are you sure you want to cancel attending this event?");
        $I->see("I'm not going", 'button');
        $I->see("I'm going");
        $I->click("#going");
        $I->seeInDatabase('event_user', ['event_id' => 1, 'user_id' => 4]);
        $I->dontSee('Are you sure you want to cancel attending this event?"');
        $I->click("#cancel_1");
        $I->see("Are you sure you want to cancel attending this event?");
        $I->click("I'm not going");

        $I->seeInCurrentUrl("/events");
        $I->dontSeeInDatabase('event_user', ['event_id' => 1, 'user_id' => 4]);
        $I->see('Your submission for this event was cancelled');
        $I->dontSee('Carcassonne lovers', 'p');
        $I->see("You're not organizing any events right now!");
        $I->see("You're not signed up for any events right now!");

        $I->amOnPage('/profile');
        $I->see('You have 0 games');
        $I->see("You're organizing 0 events");
        $I->see("and attending 0 events");
        $I->see("You've posted 0 auctions");
        $I->see("Your average rating is 0");
        $I->see("with 0 reviews");
        $I->see("You've posted 0 comments");

        //creating auction
        $I->click("Auctions");
        $I->seeCurrentUrlEquals("/profile/auctions");
        $I->see("You haven't created any auctions yet!");

        $I->amOnPage('/auctions/create');
        $title = 'Taboo';
        $price = 20;
        $description = 'Delivery cost: 2.50$';
        $phone = 123456789;
        $option = $I->grabTextFrom('select option:nth-child(2)');

        $I->fillField('game_title', $title);
        $I->selectOption('select', $option);
        $I->fillField('price', $price);
        $I->fillField('description', $description);
        $I->fillField('phone', $phone);
        $I->click('Create auction');
        $I->see("Check icon Wait for admin to accept your auction");

        $I->amOnPage('/profile');
        $I->see('You have 0 games');
        $I->see("You're organizing 0 events");
        $I->see("and attending 0 events");
        $I->see("You've posted 1 auctions");
        $I->see("Your average rating is 0");
        $I->see("with 0 reviews");
        $I->see("You've posted 0 comments");

        $I->amOnPage('/profile/auctions');
        $I->dontSee("You haven't created any auctions yet!");
        $I->see("Waiting");
        $I->see($title);

        //editing auction
        $title2 = "Uno";
        $I->click("Edit");
        $I->seeInField('select', $option);
        $I->seeInField('price', $price);
        $I->seeInField('description', $description);
        $I->seeInField('phone', $phone);
        $I->fillField('game_title', $title2);
        $I->click("Edit auction");
        $I->seeInDatabase('auctions', ['title' => $title2, 'user_id' => 4]);
        $I->seeInCurrentUrl("/profile/auctions");
        $I->see('Your auction was updated!');
        $I->dontSee($title);
        $I->see($title2);

        //deleting auction
        $I->click("#delete_5");
        $I->see("Are you sure you want to delete your auction?");
        $I->see("Delete your auction", 'button');
        $I->seeElement('#cancel_delete');
        $I->click('#cancel_delete');
        $I->seeInDatabase('auctions', ['title' => $title2, 'user_id' => 4]);
        $I->dontSee('Are you sure you want to delete your auction?"');
        $I->click('#delete_5');
        $I->see("Are you sure you want to delete your auction?");
        $I->click('Delete your auction');
        $I->seeInCurrentUrl("/auctions");
        $I->see('Your auction was deleted!');
        $I->dontSee($title2);
        $I->dontSeeInDatabase('auctions', ['title' => $title2, 'user_id' => 4]);

        $I->see("You haven't created any auctions yet!");

        $I->amOnPage('/profile');
        $I->see('You have 0 games');
        $I->see("You're organizing 0 events");
        $I->see("and attending 0 events");
        $I->see("You've posted 0 auctions");
        $I->see("Your average rating is 0");
        $I->see("with 0 reviews");
        $I->see("You've posted 0 comments");

        //adding games, ratings and comments
        $I->click("Games");
        $I->seeCurrentUrlEquals("/profile/games");
        $I->see("You didn't add any games yet!");

        $I->click('Library');
        $I->click('#more_1');
        $I->see('Monopoly');
        $I->click("Add to your games");
        $I->see("Added to your games");
        $I->selectOption('rating', '2');
        $I->click("Add rating");
        $I->see("Your rating was added");
        $I->fillField('description', 'Zawsze przegrywam, nie podoba mi się');
        $I->click('Add comment');
        $I->see('Your comment was added');

        $I->click('Library');
        $I->click('#more_2');
        $I->see('Cluedo');
        $I->click("Add to your games");
        $I->see("Added to your games");
        $I->selectOption('rating', '4');
        $I->click("Add rating");
        $I->see("Your rating was added");

        $I->click('Library');
        $I->click('#more_3');
        $I->see('Patchwork');
        $I->click("Add to your games");
        $I->see("Added to your games");

        $I->amOnPage('/profile');
        $I->see('You have 3 games');
        $I->see("You're organizing 0 events");
        $I->see("and attending 0 events");
        $I->see("You've posted 0 auctions");
        $I->see("Your average rating is 3");
        $I->see("with 2 reviews");
        $I->see("You've posted 1 comments");

        $I->amOnPage('/profile/games');
        $I->dontSee("You didn't add any games yet!");
        $I->see("Monopoly");
        $I->see('2 Rating star');
        $I->see('Cluedo');
        $I->see('4 Rating star');
        $I->see("Patchwork");
        $I->see('N/A Rating star');

        //deleting game from your games
        $I->click("#delete_1");
        $I->see("Are you sure you want to delete this game from your games?");
        $I->see("Delete this game from your games", 'button');
        $I->seeElement('#cancel_delete');
        $I->click('#cancel_delete');
        $I->seeInDatabase('game_user', ['game_id' => 1, 'user_id' => 4]);
        $I->seeInDatabase('game_user', ['game_id' => 2, 'user_id' => 4]);
        $I->seeInDatabase('game_user', ['game_id' => 3, 'user_id' => 4]);
        $I->seeInDatabase('ratings', ['game_id' => 1, 'user_id' => 4]);
        $I->seeInDatabase('ratings', ['game_id' => 2, 'user_id' => 4]);
        $I->seeInDatabase('comments', ['game_id' => 1, 'user_id' => 4]);
        $I->dontSee('Are you sure you want to delete this game from your games?"');
        $I->click('#delete_1');
        $I->see("Are you sure you want to delete this game from your games?");
        $I->click('Delete this game from your games');
        $I->seeCurrentUrlEquals("/profile/games");
        //$I->see(message);
        $I->dontSeeInDatabase('game_user', ['game_id' => 1, 'user_id' => 4]);
        $I->seeInDatabase('game_user', ['game_id' => 2, 'user_id' => 4]);
        $I->seeInDatabase('game_user', ['game_id' => 3, 'user_id' => 4]);
        $I->seeInDatabase('ratings', ['game_id' => 1, 'user_id' => 4]);
        $I->seeInDatabase('ratings', ['game_id' => 2, 'user_id' => 4]);
        $I->seeInDatabase('comments', ['game_id' => 1, 'user_id' => 4]);

        $I->dontSee("Monopoly");
        $I->dontSee('2 Rating star');
        $I->see('Cluedo');
        $I->see('4 Rating star');
        $I->see("Patchwork");
        $I->see('N/A Rating star');
        $I->dontSee("You didn't add any games yet!");

        $I->amOnPage('/profile');
        $I->see('You have 2 games');
        $I->see("You're organizing 0 events");
        $I->see("and attending 0 events");
        $I->see("You've posted 0 auctions");
        $I->see("Your average rating is 3");
        $I->see("with 2 reviews");
        $I->see("You've posted 1 comments");

        //settings
        $city = 'Kraków';

        $I->amOnPage("/profile");
        $I->see("Welcome " . $username);
        $I->see('City: ' . $city);
        $I->see('Age: ' . $age);
        $I->click("Settings");
        $I->seeCurrentUrlEquals("/profile/settings");

        //changing username, age and city
        $I->see('Update your profile information');
        $I->seeInField('username', $username);
        $I->seeInField('city', $city);
        $I->seeInField('age', $age);
        $I->click('#save1');
        $I->see('Profile updated');
        $I->dontSee('The username has already been taken.');
        $I->dontSee('The email has already been taken.');
        $I->seeInField('username', $username);
        $I->seeInField('city', $city);
        $I->seeInField('age', $age);

        $username_wrong = 'AdamP';
        $username2 = 'Agusia';
        $city2 = 'Oslo';
        $age2 = '23';

        $I->fillField('username', $username_wrong);
        $I->fillField('city', $city2);
        $I->fillField('age', $age2);
        $I->click('#save1');
        $I->dontSee('Profile updated');
        $I->see('The username has already been taken.');
        $I->dontSee('The email has already been taken.');
        $I->seeInField('username', $username_wrong);
        $I->seeInField('city', $city2);
        $I->seeInField('age', $age2);

        $I->fillField('username', $username2);
        $I->click('#save1');
        $I->see('Profile updated');
        $I->dontSee('The username has already been taken.');
        $I->dontSee('The email has already been taken.');
        $I->seeInField('username', $username2);
        $I->seeInField('city', $city2);
        $I->seeInField('age', $age2);

        $I->amOnPage("/profile");
        $I->see("Welcome " . $username2);
        $I->see('City: ' . $city2);
        $I->see('Age: ' . $age2);

        $I->click("Settings");
        $I->seeCurrentUrlEquals("/profile/settings");
        $I->fillField('city', '');
        $I->fillField('age', '');
        $I->click('#save1');
        $I->see('Profile updated');
        $I->seeInField('city', '');
        $I->seeInField('age', '');

        $I->amOnPage("/profile");
        $I->see("Welcome " . $username2);
        $I->see('City: ');
        $I->see('Age: ');

        //changing password
        $password2 = 'agatkawariatka';

        $I->click("Settings");
        $I->seeCurrentUrlEquals("/profile/settings");
        $I->see('Change your password');
        $I->dontSeeInField('password', $password);
        $I->dontSeeInField("password_confirmation", $password);

        $I->fillField("password_confirmation", $password);
        $I->click('Save', ["id" => "save2"]);
        $I->see('The current password field is required', 'li');
        $I->see('The password field is required.', 'li');
        $I->dontSee('The password confirmation does not match.');
        $I->dontSee('The password is incorrect.');
        $I->dontSee("The password and current password must be different.");

        $I->fillField("current_password", $password2);
        $I->click('Save', ["id" => "save2"]);
        $I->dontSee('The current password field is required', 'li');
        $I->see('The password field is required.', 'li');
        $I->dontSee('The password confirmation does not match.');
        $I->see('The password is incorrect.');
        $I->dontSee("The password and current password must be different.");

        $I->fillField("password", $password2);
        $I->fillField("password_confirmation", $password);
        $I->click('Save', ["id" => "save2"]);
        $I->see('The current password field is required', 'li');
        $I->dontSee('The password field is required.', 'li');
        $I->see('The password confirmation does not match.');
        $I->dontSee('The password is incorrect.');
        $I->dontSee("The password and current password must be different.");

        $I->fillField("current_password", $password);
        $I->fillField("password", $password);
        $I->fillField("password_confirmation", $password);
        $I->click('Save', ["id" => "save2"]);
        $I->dontSee('The current password field is required', 'li');
        $I->dontSee('The password field is required.', 'li');
        $I->dontSee('The password confirmation does not match.');
        $I->dontSee('The password is incorrect.');
        $I->see("The password and current password must be different.");

        $I->fillField("current_password", $password);
        $I->fillField("password", $password2);
        $I->fillField("password_confirmation", $password2);
        $I->click('Save', ["id" => "save2"]);
        $I->dontSee('The current password field is required', 'li');
        $I->dontSee('The password field is required.', 'li');
        $I->dontSee('The password confirmation does not match.');
        $I->dontSee('The password is incorrect.');
        $I->dontSee("The password and current password must be different.");

        $I->click("Logout");
        $I->click("Login");
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click("Log in");
        $I->seeCurrentUrlEquals("/login");
        $I->see("These credentials do not match our records.");
        $I->fillField('password', $password2);
        $I->click("Log in");
        $I->dontSee("These credentials do not match our records.");
        $I->seeCurrentUrlEquals("/");

        //changing email
        $email2 = 'agacia@gmail.com';
        $email_wrong = 'adam@gmail.com';

        $I->click('Profile');
        $I->click("Settings");
        $I->seeCurrentUrlEquals("/profile/settings");
        $I->see('Update your profile information');
        $I->seeInField('email', $email);
        $I->fillField('email', $email_wrong);
        $I->click('#save1');
        $I->see('The email has already been taken.');
        $I->dontSeeInDatabase("users", ["id" => "4", "email" => $email_wrong]);
        $I->seeCurrentUrlEquals("/profile/settings");

        $I->fillField('email', $email2);
        $I->click('#save1');
        $I->dontSeeInDatabase("users", ["id" => "4", "email" => $email]);
        $I->seeInDatabase("users", ["id" => "4", "email" => $email2]);
        $I->seeCurrentUrlEquals("/profile/settings");
        $I->dontSee('The email has already been taken.');
        $I->click('Profile');
        $I->seeCurrentUrlEquals('/verify-email');
        $I->click("Logout");

        $I->click("Login");
        $I->seeCurrentUrlEquals("/login");
        $I->fillField('email', $email);
        $I->fillField('password', $password2);
        $I->click('Log in');
        $I->see("These credentials do not match our records.");
        $I->fillField('email', $email2);
        $I->fillField('password', $password2);
        $I->click("Log in");
        $I->dontSee("These credentials do not match our records.");
        $I->seeCurrentUrlEquals("/");

        //deleting account
        $email = 'john.doe@gmail.com';
        $password = 'secret';

        $I->click('Logout');
        $I->click("Login");
        $I->seeCurrentUrlEquals("/login");
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click('Log in');
        $I->click('Profile');

        $I->seeInDatabase('users', ['email' => $email, 'id' => 1]);
        $I->seeInDatabase('comments', ['user_id' => 1]);
        $I->seeInDatabase('ratings', ['user_id' => 1]);
        $I->seeInDatabase('auctions', ['user_id' => 1]);
        $I->seeInDatabase('events', ['creator_id' => 1]);

        $I->click('Settings');
        $I->seeCurrentUrlEquals('/profile/settings');
        $I->see("Delete your account");
        $I->click("#delete");
        $I->see("Are you sure?");
        $I->see('Type in password to confirm');
        $I->see("Delete your account", 'button');
        $I->seeElement('#cancel_delete');
        $I->click('#cancel_delete');
        $I->seeInDatabase('users', ['email' => $email, 'id' => 1]);
        $I->seeInDatabase('comments', ['user_id' => 1]);
        $I->seeInDatabase('ratings', ['user_id' => 1]);
        $I->seeInDatabase('auctions', ['user_id' => 1]);
        $I->seeInDatabase('events', ['creator_id' => 1]);

        $I->click('#delete');
        $I->see("Are you sure?");
        $I->see('Type in password to confirm');
        $I->click('#delete_account');
        $I->see("The password field is required.");
        $I->seeInDatabase('users', ['email' => $email, 'id' => 1]);
        $I->seeInDatabase('comments', ['user_id' => 1]);
        $I->seeInDatabase('ratings', ['user_id' => 1]);
        $I->seeInDatabase('auctions', ['user_id' => 1]);
        $I->seeInDatabase('events', ['creator_id' => 1]);

        $I->click('#delete');
        $I->see("Are you sure?");
        $I->see('Type in password to confirm');
        $I->fillField('#password2', $password);
        $I->click('#delete_account');
        $I->seeCurrentUrlEquals('/');

        $I->dontSeeInDatabase('users', ['email' => $email, 'id' => 1]);
        $I->dontSeeInDatabase('comments', ['user_id' => 1]);
        $I->dontSeeInDatabase('ratings', ['user_id' => 1]);
        $I->dontSeeInDatabase('auctions', ['user_id' => 1]);
        $I->dontSeeInDatabase('events', ['creator_id' => 1]);

        $I->click("Login");
        $I->seeCurrentUrlEquals("/login");
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click('Log in');
        $I->see("These credentials do not match our records.");
    }
}
