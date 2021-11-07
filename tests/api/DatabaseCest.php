<?php

class DatabaseCest
{
    public function databaseUsuarios(ApiTester $I)
    {
        $I->seeInDatabase('users', ['name' => 'Murillo', 'id' => 1]);
        $I->haveInDatabase('users', ['id' => 3, 'name' => 'Automation']);
        $I->seeInDatabase('users', ['name' => 'Automation', 'id' => 3]);
        $I->updateInDatabase('users', array('name' => 'Murillo123'), array('id' => 1));
        $I->seeInDatabase('users', ['name' => 'Murillo123', 'id' => 1]);
        $I->updateInDatabase('users', array('name' => 'Cris123'), array('id' => 2));
        $I->updateInDatabase('users', array('name' => 'Automation1'), array('id' => 3));
        $I->seeInDatabase('users', ['name' => 'Automation1', 'id' => 3]);
    }
}
