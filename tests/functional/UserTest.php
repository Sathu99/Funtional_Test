<?php

namespace App\Tests;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\FunctionalTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester->amOnPage('/user/login');
    }

    protected function _after()
    {
    }

    // tests
    public function testLogin()
    {
//        $this->tester->fillField('#user_login input[name=email]','test@gmail.com');
//        $this->tester->fillField('#user_login input[name=password]','ZX!@zx12');
//        $this->tester->click('Login','#user_login');
        $this->tester->submitSymfonyForm('user_login', ['[email]' => 'test@gmail.com', '[password]' => 'ZX!@zx12']);
        $this->tester->see('You are Successfully LoggedIn.');
        $this->tester->seeResponseCodeIsSuccessful();
        $this->tester->seeInSource('<div style="background-color: lightgreen;color: #111111;font-size: xxx-large;text-align: center">
            You are Successfully LoggedIn.
        </div>');
    }

    // tests
    public function testSignUp()
    {

        $this->tester->submitSymfonyForm('user_signup', ['[name]' => 'Kamal', '[email]' => 'test123@gmail.com', '[password]' => '12345678']);
        $this->tester->see('You are Successfully SignedUp.');
        $this->tester->seeResponseCodeIsSuccessful();
        $this->tester->seeInSource('<div style="background-color: lightgreen;color: #111111;font-size: xxx-large;text-align: center">
            You are Successfully SignedUp.
        </div>');
    }

    // tests
    public function testSignUpErr()
    {

        $this->tester->submitSymfonyForm('user_signup', ['[name]' => 'Kamal', '[email]' => 'test123gmail.com', '[password]' => '123478']);
        $this->tester->see('Your Details are Not Valid.');
        $this->tester->seeInSource('<div style="background-color: darkred;color: #111111;font-size: xxx-large;text-align: center">
            Your Details are Not Valid.
        </div>');
    }

    // tests
    public function testLoginErr()
    {

        $this->tester->submitSymfonyForm('user_login', ['[email]' => 'test123@gmail.com', '[password]' => 'ZX!@zx12']);
        $this->tester->see('You are not Sign Up Yet, First You want Sign up.');
        $this->tester->seeInSource('<div style="background-color: darkred;color: #111111;font-size: xxx-large;text-align: center">
            You are not Sign Up Yet, First You want Sign up.
        </div>');
    }

    // tests
    public function testLoginInvalidPasswordErr()
    {

        $this->tester->submitSymfonyForm('user_login', ['[email]' => 'test@gmail.com', '[password]' => 'ZX!48x12']);
        $this->tester->see('Your Password is Invalid.');
        $this->tester->seeInSource('<div style="background-color: darkred;color: #111111;font-size: xxx-large;text-align: center">
            Your Password is Invalid.
        </div>');
    }

}