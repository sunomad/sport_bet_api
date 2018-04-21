<?php


class UserCest
{
    /**
     * The default user we create through the api
     *
     * @var array 
     */
    public $user = [
        "username"   => "testuser",
        "email"      => "testuser@test.net",
        "password"   => "HJ68gja765h",
        "first_name" => "Edwin",
        "last_name"  => "de Ridder",
        "address"    => "Triq something",
        "country"    => "Malta",
        "language"   => "en",
        "currency"   => "EUR",
        "phone"      => "+356123456789",
    ];
    
    /**
     * The updated user
     *
     * @var array 
     */
    public $updated_user = [
        "username"   => "testuser_new",
        "address"    => "Triq something else",
        "currency"   => "USD",
    ];
        
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function testCreateUser(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('users', $this->user);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED); // 201
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"success":true}');
        
        $user = $this->user;
        unset($user['password']);
        $I->canSeeInDatabase('users', $user);
    }
    
    public function testGetUser(ApiTester $I)
    {
        
    }
    
    public function testUpdateUser(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPATCH('users/1', $this->updated_user);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 201
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"success":true}');
        
        $I->canSeeInDatabase('users', $this->updated_user);
    }
    
    public function testDeleteUser(ApiTester $I)
    {
    }
}
