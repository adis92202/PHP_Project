<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test02_LoginCest
{
    public function loginTest(AcceptanceTester $I): void
    {
        $I->wantTo('login with existing user');

        $I->amOnPage('/');
        $I->see('Login', 'a');
        $I->see('Register', 'a');
        $I->dontSee('Profile', 'a');
        $I->dontSee('Logout', 'a');
        $I->see('Welcome player!');

        $I->click("Login");
        $I->seeCurrentUrlEquals('/login');

        $I->click('Log in');
        $I->see('The email field is required.', 'li');
        $I->see('The password field is required.', 'li');

        $email = 'john.doe@gmail.com';
        $password = 'secret';
        $false_password = 'no_secret';

        $I->fillField('email', $email);
        $I->click('Log in');
        $I->dontSee('The email field is required.', 'li');
        $I->see('The password field is required.', 'li');
        $I->seeInField('email', $email);

        $I->fillField('password', $false_password);
        $I->click('Log in');
        $I->dontSee('The email field is required.', 'li');
        $I->dontSee('The password field is required.', 'li');
        $I->see('These credentials do not match our records.', 'li');
        $I->seeInField('email', $email);
        $I->dontSeeInField('password', $password);

        $I->fillField('password', $password);
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/');
        $I->dontSee('Login', 'a');
        $I->dontSee('Register', 'a');
        $I->see('Profile', 'a');
        $I->see('Logout', 'a');
        $I->see('Welcome jdoe!');

        $I->click('Logout');
        $I->amOnPage('/');
        $I->see('Login', 'a');
        $I->see('Register', 'a');
        $I->dontSee('Profile', 'a');
        $I->dontSee('Logout', 'a');
        $I->see('Welcome player!');

        $I->click('Login');
        $I->click('Forgot your password?');
        $I->seeCurrentUrlEquals('/forgot-password');
        $I->fillField('email', $email);
        $I->click('Send');
        $I->see('Reset password e-mail sent');
        $I->see('Log in');
    }
}
