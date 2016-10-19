<?php

use App\Models\Dead;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeadTest extends TestCase
{

    public function testFromFio()
    {
        $dead = new Dead();

        $dead->parseFio("Иванов Иван Иванович");
        $this->assertEquals($dead->family,"Иванов","family is wrong".$dead->family);
        $this->assertEquals($dead->name,"Иван","name is wrong");
        $this->assertEquals($dead->patron,"Иванович","patron is wrong");

        $dead->parseFio("иванов иван иванович");
        $this->assertEquals($dead->family,"Иванов","family is wrong");
        $this->assertEquals($dead->name,"Иван","name is wrong");
        $this->assertEquals($dead->patron,"Иванович","patron is wrong");

        $dead->parseFio("Иванов Иван Иванович 2014-22323 ");
        $this->assertEquals($dead->family,"Иванов","family is wrong");
        $this->assertEquals($dead->name,"Иван","name is wrong");
        $this->assertEquals($dead->patron,"Иванович","patron is wrong");

        $dead->parseFio("Иванов Иван");
        $this->assertEquals($dead->family,"Иванов","family is wrong");
        $this->assertEquals($dead->name,"Иван","name is wrong");
        $this->assertEquals($dead->patron,"","patron is wrong");

    }

    public function testExample()
    {
        $this->assertTrue(true);
    }
}
