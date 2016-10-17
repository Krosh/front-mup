<?php

use App\Grave;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GraveTest extends TestCase
{
    public function testState()
    {
        $data = ["Удовлетворительно" => Grave::$STATE_OK, " неудовлетворительно  " => Grave::$STATE_NON_OK, "заброшено" => Grave::$STATE_FORGOTTEN, "" => Grave::$STATE_EMPTY, "asdasd" => Grave::$STATE_EMPTY];
        $grave = new Grave();
        foreach ($data as $key => $value)
        {
            $grave->setStateByString($key);
            $this->assertEquals($grave->state,$value,$key." - error");
        }
    }


    public function testCemetery()
    {
        $cemetery = \App\Cemetery::whereId(1)->first();
        $grave = new Grave();
        $grave->setCemeteryByString($cemetery->name);
        $this->assertEquals($grave->idCemetery,$cemetery->id);
    }

    public function testHasBorder()
    {
        $data = ["Да" => true, "нет" => false, "" => false];
        $grave = new Grave();
        foreach ($data as $key => $value)
        {
            $grave->setHasBorderByString($key);
            $this->assertEquals($grave->hasBorder,$value, $key." error");
        }

    }

    public function testWw2()
    {
        $data = ["Да" => true, "нет" => false, "" => false];
        $grave = new Grave();
        foreach ($data as $key => $value)
        {
            $grave->setWw2ByString($key);
            $this->assertEquals($grave->ww2,$value, $key." error");
        }

    }


    public function testMakeFromData()
    {
        $data = [];
        $data[] = ["numGrave" => 1, "nameCemetery" => "Кладбище п.Ерестной", "fioDead" => "", "yearBorn" => 1970, "yearDeath" => 2011, "numDeads" => 1, "sizeGrave" => "2600x1200", "hasBorder" => "да", "border" => "дерево", "memorial" => "", "memorialMaterial" => "", "sizeMemorial" => "", "state" => "удовлетворительно", "ww2" => "да"];
        $grave = new Grave();
        $grave->makeFromData($data);
        $this->assertEquals($grave->idCemetery,1,"Cemetery is wrong");
        $this->assertEquals($grave->state, Grave::$STATE_OK, "State is wrong");
        $this->assertEquals($grave->hasBorder, true, "[{$grave->hasBorder}] hasBorder is wrong");
        $this->assertEquals($grave->ww2,true,"ww2 is wrong");
        $this->assertEquals($grave->sizeGrave,"2600x1200","sizeGrave is wrong");
        $this->assertEquals($grave->border,"дерево","border is wrong");
        $this->assertEquals($grave->numGrave,"1","numGrave is wrong");

        $data = [];
        $data[] = ["numGrave" => 1, "nameCemetery" => "Кладбище п.Ерестной", "fioDead" => "", "yearBorn" => 1970, "yearDeath" => 2011, "numDeads" => 1, "sizeGrave" => "2600x1200", "hasBorder" => "да", "border" => "дерево", "memorial" => "", "memorialMaterial" => "", "sizeMemorial" => "", "state" => "неудовлетворительно", "ww2" => ""];
        $grave = new Grave();
        $grave->makeFromData($data);
        $this->assertEquals($grave->state, Grave::$STATE_NON_OK, "State is wrong");
        $this->assertEquals($grave->ww2,false,"ww2 is wrong");


        $data = [];
        $data[] = ["numGrave" => 1, "nameCemetery" => "Кладбище п.Ерестной", "fioDead" => "", "yearBorn" => 1970, "yearDeath" => 2011, "numDeads" => 1, "sizeGrave" => "2600x1200", "hasBorder" => "Нет", "border" => "дерево", "memorial" => "", "memorialMaterial" => "", "sizeMemorial" => "", "state" => "Заброшено", "ww2" => ""];
        $grave = new Grave();
        $grave->makeFromData($data);
        $this->assertEquals($grave->state, Grave::$STATE_FORGOTTEN, "State with caps is wrong");

        $data = [];
        $data[] = ["numGrave" => 1, "nameCemetery" => "Кладбище п.Ерестной", "fioDead" => "", "yearBorn" => 1970, "yearDeath" => 2011, "numDeads" => 1, "sizeGrave" => "2600x1200", "hasBorder" => "да", "border" => "дерево", "memorial" => "", "memorialMaterial" => "", "sizeMemorial" => "", "state" => "", "ww2" => ""];
        $grave = new Grave();
        $grave->makeFromData($data);
        $this->assertEquals($grave->state, Grave::$STATE_EMPTY, "State is wrong");


    }
}
