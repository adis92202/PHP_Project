<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test01_RegisterAndVerifyEmailCest
{
    public function Register(AcceptanceTester $I): void
    {
        //already registered
        $I->amOnPage('/');
        $I->see('Login', 'a');
        $I->see('Register', 'a');
        $I->dontSee('Profile', 'a');
        $I->dontSee('Logout', 'a');

        $I->click('Register');
        $I->seeCurrentUrlEquals('/register');
        $I->see('Join us!');
        $I->see('Already registered?');
        $I->click('Already registered?');
        $I->seeCurrentUrlEquals('/login');

        //register new user
        $I->click('Register');
        $I->seeCurrentUrlEquals('/register');

        $old_username = 'AdamP';
        $old_email = 'adam@gmail.com';
        $bad_password = 'abc';
        $username = 'Werka';
        $email = 'werka@gmail.com';
        $password = 'werkabokserka';
        $city = 'Krakow';

        $I->click('#register_sub');
        $I->dontSee('The email has already been taken.', 'li');
        $I->dontSee('The username has already been taken.', 'li');
        $I->dontSee('The password confirmation does not match.', 'li');
        $I->dontSee('The password must be at least 8 characters.', 'li');
        $I->see('The email field is required.', 'li');
        $I->see('The password field is required.', 'li');
        $I->see('The username field is required.', 'li');
        $I->dontSee('The age field is required.', 'li');
        $I->dontSee('The city field is required.', 'li');

        $I->fillField('username', $old_username);
        $I->fillField('email', $old_email);
        $I->fillField('password', $bad_password);
        $I->fillField('city', $city);
        $I->click('#register_sub');

        $I->see('The email has already been taken.', 'li');
        $I->see('The username has already been taken.', 'li');
        $I->see('The password confirmation does not match.', 'li');
        $I->see('The password must be at least 8 characters.', 'li');
        $I->dontSee('The email field is required.', 'li');
        $I->dontSee('The password field is required.', 'li');
        $I->dontSee('The username field is required.', 'li');
        $I->dontSee('The age field is required.', 'li');
        $I->dontSee('The city field is required.', 'li');

        $I->seeInField('email', $old_email);
        $I->seeInField('username', $old_username);
        $I->dontSeeInField('password', $bad_password);
        $I->seeInField('city', $city);

        $I->fillField('username', $username);
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->fillField('password_confirmation', $password);
        $I->click('#register_sub');

        //email verification
        $I->seeCurrentUrlEquals('/register');
        $I->dontSee('Join us!');
        $I->see('Email verification');
        $I->see("Resend Verification Email");
        $I->see('Logout');
        $I->click('Logout');
        $I->seeCurrentUrlEquals('/');

        $I->click('Login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/');
        $I->see('Welcome Werka!');

        $I->click('Profile');
        $I->seeCurrentUrlEquals('/verify-email');
        $I->see('Email verification');

        $I->click('Market');
        $I->dontSee('Please login to see contact information');
        $I->see('E-mail:');
        $I->see('Telephone number:');
        $I->click('Add auction here!');
        $I->seeCurrentUrlEquals('/verify-email');
        $I->see('Email verification');

        $I->click('Events');
        $I->click(['id'=>'first_image']);
        $I->seeCurrentUrlEquals('/events/1');
        $I->click('Join this event!');
        $I->seeCurrentUrlEquals('/verify-email');
        $I->see('Email verification');

        $I->click('Events');
        $I->click('Add new event here!');
        $I->seeCurrentUrlEquals('/verify-email');
        $I->see('Email verification');

        $I->click('Library');
        $I->click('Add it here!');
        $I->seeCurrentUrlEquals('/verify-email');
        $I->see('Email verification');

        $I->click('Library');
        $I->click('#more_5');
        $I->seeCurrentUrlEquals('/library/5');
        $I->click('Add to your games');
        $I->seeCurrentUrlEquals('/verify-email');
        $I->see('Email verification');

        $I->click('Library');
        $I->click('#more_5');
        $I->seeCurrentUrlEquals('/library/5');
        $I->click('Add rating');
        $I->seeCurrentUrlEquals('/verify-email');
        $I->see('Email verification');

        $I->click('Library');
        $I->click('#more_5');
        $I->seeCurrentUrlEquals('/library/5');
        $I->click('Add comment');
        $I->seeCurrentUrlEquals('/verify-email');
        $I->see('Email verification');

        $I->see("Resend Verification Email");
        $I->see('Logout');
        $I->click('Resend Verification Email');
        $I->seeCurrentUrlEquals('/verify-email');
    }
}
