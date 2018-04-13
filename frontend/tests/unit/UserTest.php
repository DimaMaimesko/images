<?php
namespace frontend\tests;
use frontend\tests\fixtures\UserFixture;
use Yii;
class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    public function _fixtures()
    {
        return ['users' => UserFixture::className()];
       
    }
    
    public function _before()
    {
      Yii::$app->setComponents([
          'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 1,
           ],
        ]);
       
    }
   

    // tests
   
    public function testGetNickname()
    {
        $user = $this->tester->grabFixture('users','user1');
         expect($user->getNickname())->equals(1);
         
    }
    
    public function testGetNicknameOnEmptyNickname()
    {
        $user = $this->tester->grabFixture('users','user3');
        expect($user->getNickname())->equals('sex_guru');
    }
    public function testGetPostCount()
    {
        $user = $this->tester->grabFixture('users','user1');
        expect($user->countUserPosts($user->id))->equals(4);
    }
    public function testFollowUser()
    {
        $user1 = $this->tester->grabFixture('users','user1');
        $user3 = $this->tester->grabFixture('users','user3');
        $user1->followUser($user3);
        $user3->followUser($user1);
        
        $this->tester->seeRedisKeyContains('user:1:subscriptions', 3);
        $this->tester->seeRedisKeyContains('user:3:subscriptions', 1);
        $this->tester->seeRedisKeyContains('user:1:followers', 3);
        $this->tester->seeRedisKeyContains('user:3:followers', 1);
        //sleep(20);
        $this->tester->sendCommandToRedis('del', 'user:1:subscriptions');
        $this->tester->sendCommandToRedis('del', 'user:3:followers');
        $this->tester->sendCommandToRedis('del', 'user:3:subscriptions');
        $this->tester->sendCommandToRedis('del', 'user:1:followers');
        
    }
  
    
    
   
}