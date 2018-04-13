<?php
namespace frontend\tests\models;
use frontend\tests\fixtures\UserFixture;
class SignupFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
     public function _fixtures()
    {
        return ['users' => UserFixture::className()];
       
    }
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testTrimUsername()
    {
        $model = new \frontend\modules\user\models\SignupForm([
            'username' => '  some_user ',
            'email' => 'some_email@gmail.com',
            'password' => 'some_password',
        ]);
        $model->signup();
        expect($model->username)->equals('some_user');

    }
    public function testRequiredUsername()
    {
        $model = new \frontend\modules\user\models\SignupForm([
            'username' => '',
            'email' => 'some_email@gmail.com',
            'password' => 'some_password',
        ]);
        $model->signup();
        expect($model->getFirstError('username'))->equals('Username cannot be blank.');
   }
    public function testTooShortUsername()
    {
        $model = new \frontend\modules\user\models\SignupForm([
            'username' => '2',
            'email' => 'some_email@gmail.com',
            'password' => 'some_password',
        ]);
        $model->signup();
        expect($model->getFirstError('username'))->equals('Username should contain at least 2 characters.');
   }
    public function testUniqueEmail()
    {
        $model = new \frontend\modules\user\models\SignupForm([
            'username' => '2vcb',
            'email' => 'dima.maimesko@gmail.com',
            'password' => 'some_password',
        ]);
        $model->signup();
        expect($model->getFirstError('email'))->equals('This email address has already been taken.');
   }
   
}