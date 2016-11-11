<?php

use App\Models\Cemetery;
use App\Models\Grave;
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

    public function testSize()
    {
        $grave = new Grave();
        $grave->setSizeGrave("100x200");
        $this->assertEquals(20000,$grave->square,$grave->sizeGrave);
        $grave->setSizeGrave("100Х200");
        $this->assertEquals(20000,$grave->square,$grave->sizeGrave);
        $grave->setSizeGrave("100 200");
        $this->assertEquals(20000,$grave->square,$grave->sizeGrave);
        $grave->setSizeGrave("фывфыв");
        $this->assertEquals(0,$grave->square,$grave->sizeGrave);
    }

    public function testCemetery()
    {
        $cemetery = Cemetery::whereId(1)->first();
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


    public function testImportFromJson()
    {
        $data = '[{"id":"156","dateDeath":"29.10.2016","family":"Иванов","name":"иван","patron":"иванович","dateBirth":"01.08.1950","cemetery":"1","quarter":"66","area":null,"hasTalon":null,"latitude":"53","longitude":"83.56553000","sizeOfArea":"5"}]';
        $obj = json_decode($data);
        $grave = Grave::loadFromRegsystem($obj[0]);
        $deads = $grave->getDeads();
        $this->assertEquals(1,count($deads),"count deads is wrong");
        $this->assertEquals("Иванов Иван Иванович",$deads[0]->getFio(), "FIO IS wrong");
        $this->assertEquals("1950-08-01",$deads[0]->dateBorn, "date born is wrong");
        $this->assertEquals("2016-10-29",$deads[0]->dateDeath, "date death is wrong");
        $this->assertEquals(5,$grave->square,"square is wrong");
        $this->assertEquals(83.56553000,$grave->longitude,"longitude is wrong");
        $this->assertEquals(53,$grave->latitude,"latitude is wrong");
        $this->assertEquals(156,$grave->idFromRegsystem,"idFromRegsystem is wrong");
    }

    public function testMakeFromData()
    {
        $data = [];
        $data[] = ["numGrave" => 1, "nameCemetery" => "Кладбище п.Ерестной", "fioDead" => "Иванов Иван Иванович", "yearBorn" => 1970, "yearDeath" => 2011, "numDeads" => 2, "sizeGrave" => "2600x1200", "hasBorder" => "да", "border" => "дерево", "memorial" => "Крест", "memorialMaterial" => "Бетон", "sizeMemorial" => "20x20x20", "state" => "удовлетворительно", "ww2" => "да"];
        $data[] = ["numGrave" => "", "nameCemetery" => "Кладбище п.Ерестной", "fioDead" => "Петров Петр Петрович", "yearBorn" => 1980, "yearDeath" => 2003, "numDeads" => "", "sizeGrave" => "", "hasBorder" => "да", "border" => "", "memorial" => "Памятник", "memorialMaterial" => "Дерево", "sizeMemorial" => "10x20x30", "state" => "удовлетворительно", "ww2" => "да"];
        $grave = new Grave();
        $grave->makeFromData($data);
        $this->assertEquals($grave->idCemetery,1,"Cemetery is wrong");
        $this->assertEquals($grave->state, Grave::$STATE_OK, "State is wrong");
        $this->assertEquals($grave->hasBorder, true, "[{$grave->hasBorder}] hasBorder is wrong");
        $this->assertEquals($grave->ww2,true,"ww2 is wrong");
        $this->assertEquals($grave->sizeGrave,"2600x1200","sizeGrave is wrong");
        $this->assertEquals($grave->border,"дерево","border is wrong");
        $this->assertEquals($grave->numGrave,"1","numGrave is wrong");
        $this->assertEquals(count($grave->getDeads()),2,"num deads is wrong");

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
