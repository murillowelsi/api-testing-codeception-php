<?php

class UsuariosCest
{
    public function deleteUsuario(ApiTester $I)
    {
        $I->sendGet("/usuarios");
        $usersId = $I->grabDataFromResponseByJsonPath("$.._id");

        foreach ($usersId as $userId) {
            $I->sendDelete("/usuarios/{$userId}");
            $I->seeResponseCodeIs(200);
            $I->seeResponseIsJson();
        }
    }
    
    public function getUsuarios(ApiTester $I)
    {
        $I->sendPost("/usuarios", [
            "nome" => "Dr. Art Mohr",
            "email" => "yuette.ernser@yahoo.com",
            "password" => $_ENV["PASSWORD"],
            "administrador" => $_ENV["ADMINISTRADOR"]
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->sendGet("/usuarios");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContains("quantidade");
        $expectedQuantidade = $I->grabDataFromResponseByJsonPath("quantidade")[0];
        $actualQuantidade = $I->grabDataFromResponseByJsonPath("$..usuarios")[0];
        $I->assertEquals(count($actualQuantidade), $expectedQuantidade);
    }

    public function postUsuario(ApiTester $I)
    {
        $I->haveHttpHeader("Content-Type", "application/json");
        $I->sendPost("/usuarios", [
            "nome" => $_ENV["NOME"],
            "email" => $_ENV["EMAIL"],
            "password" => $_ENV["PASSWORD"],
            "administrador" => $_ENV["ADMINISTRADOR"]
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $userId = $I->grabDataFromResponseByJsonPath("_id")[0];

        $I->sendPut("/usuarios/{$userId}", [
            "nome" => "abcd",
            "email" => $_ENV["EMAIL"],
            "password" => $_ENV["PASSWORD"],
            "administrador" => $_ENV["ADMINISTRADOR"]
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendDelete("/usuarios/{$userId}");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function dbTest(ApiTester $I)
    {
        $I->seeInDatabase('users', ['name' => 'Murillo', 'id' => 1]);
        $I->updateInDatabase('users', array('name' => 'Murillo'), array('id' => 1));
        $I->updateInDatabase('users', array('name' => 'Cris'), array('id' => 2));
    }
}
