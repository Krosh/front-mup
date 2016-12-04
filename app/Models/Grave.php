<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Grave
 *
 * @property integer $id
 * @property integer $idCemetery
 * @property integer $numDeads
 * @property string $sizeGrave
 * @property boolean $hasBorder
 * @property string $border
 * @property integer $state
 * @property boolean $ww2
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property float $latitude
 * @property float $longitude
 * @property integer $square
 * @property float $center_lat
 * @property float $center_lon
 * @property integer $idFromRegsystem
 * @property-read \App\Models\Cemetery $cemetery
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereIdCemetery($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereNumDeads($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereSizeGrave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereHasBorder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereBorder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereWw2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereSquare($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereCenterLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereCenterLon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grave whereIdFromRegsystem($value)
 * @mixin \Eloquent
 */
class Grave extends Model
{
    protected $fillable = ['sizeGrave','hasBorder','border', "state", "idCemetery"];


    public static $STATE_OK = 1;
    public static $STATE_NON_OK = 2;
    public static $STATE_FORGOTTEN = 3;
    public static $STATE_EMPTY = 4;

    public function setCemeteryByString($name)
    {
        $cemetery = Cemetery::firstOrCreate(["name" => $name]);
        $this->idCemetery = $cemetery->id;
    }

    private function prepareString($string)
    {
        $string = mb_strtolower($string);
        $string = trim($string);
        return $string;
    }

    public function setStateByString($state)
    {
        $state = $this->prepareString($state);
        if ($state == "неудовлетворительно")
            $this->state = self::$STATE_NON_OK;
        elseif ($state == "удовлетворительно")
            $this->state = self::$STATE_OK;
        elseif ($state == "заброшено")
            $this->state = self::$STATE_FORGOTTEN;
        else
            $this->state = self::$STATE_EMPTY;
    }

    public static function getStates()
    {
        return [self::$STATE_NON_OK => "Неудовлетворительно", self::$STATE_OK => "Удовлетворительно", self::$STATE_FORGOTTEN => "Заброшено"];
    }

    public function setHasBorderByString($hasBorder)
    {
        $hasBorder = $this->prepareString($hasBorder);
        if ($hasBorder == "да")
            $this->hasBorder = true;
        else
            $this->hasBorder = false;
    }

    public function setWw2ByString($ww2)
    {
        $ww2 = $this->prepareString($ww2);
        if ($ww2 == "да")
            $this->ww2 = true;
        else
            $this->ww2 = false;
    }


    private  $_deads = [];

    /**
     * @return Dead[]
     */
    public function getDeads()
    {
        return $this->_deads;
    }

    // TODO:: Убрать когда начнут использоваться даты
    private function addDead($fio, $yearBorn,$yearDeath,$memorial,$sizeMemorial,$memorialMaterial)
    {
        $dead = new Dead();
        $dead->parseFio($fio);
        $dead->setYearBorn($yearBorn);
        $dead->setYearDeath($yearDeath);
        $dead->memorial = $memorial;
        $dead->sizeMemorial = $sizeMemorial;
        $dead->memorialMaterial = $memorialMaterial;
        $this->_deads[] = $dead;
        $this->numDeads++;
    }

    private function addDeadWithDates($fio, $dateBorn,$dateDeath,$memorial,$sizeMemorial,$memorialMaterial)
    {
        $dead = new Dead();
        $dead->parseFio($fio);
        $dead->setDateBorn($dateBorn);
        $dead->setDateDeath($dateDeath);
        $dead->memorial = $memorial;
        $dead->sizeMemorial = $sizeMemorial;
        $dead->memorialMaterial = $memorialMaterial;
        $this->_deads[] = $dead;
        $this->numDeads++;
    }

    public function save(array $options = [])
    {
        $this->numDeads = count($this->_deads);
        if (!parent::save($options))
            return false;

        foreach ($this->getDeads() as $dead)
        {
            $dead->idGrave = $this->id;
        }

        $this->_deads = array_map(function($item)
        {
            $duplicate = $item->findDuplicate();
            if ($duplicate == null)
                return $item;
            else
            {
                $duplicate->copyFrom($item);
                return $duplicate;
            }
        },$this->_deads);

       foreach ($this->getDeads() as $dead)
        {
            if (!$dead->save())
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Считает площадь захоронения
     * Хранит значение площади в мм2
     * @param $size строка из двух значений с разделителем, значения в мм
     */
    public function setSizeGrave($size)
    {
        $this->sizeGrave = $size;
        $size = mb_strtolower(trim($size));
        $arr = explode("x",$size);
        if (count($arr) == 1)
            $arr = explode("х",$size);// Русский и английский x
        if (count($arr) == 1)
            $arr = explode("*",$size);
        if (count($arr) == 1)
            $arr = explode(" ",$size);
       if (count($arr) == 1)
            $this->square = 0;
        else
            $this->square = $arr[0] * $arr[1];
    }

    /**
     * Ищет Grave по numGrave и idCemetery и устанавливает ему параметры из массива,
     * если не находит, то возвращает новосозданную запись с установленными параметрами
     * используется при импорте из Excel
     * @param $data Данные из excel
     * @return \App\Models\Grave
     */
    public static function loadFromData($data)
    {
        $grave = new Grave();
        $grave->makeFromData($data);

        $duplicate = Grave::where("numGrave",$grave->numGrave)
            ->where("idCemetery",$grave->idCemetery)
            ->first();
        if ($duplicate == null)
        {
            return $grave;
        }  else
        {
            $duplicate->makeFromData($data);
            return $duplicate;
        }
    }

    /**
     * Установка передаваемых параметров из excel
     * @param $data данные из excel
     */
    public function makeFromData($data)
    {
        $this->setCemeteryByString($data[0]["nameCemetery"]);
        $this->setStateByString($data[0]["state"]);

        $hasBorder = "";
        $border = "";
        $ww2 = "";
        $sizeGrave = "";
        $numGrave = "";
        $this->_deads = [];
        for ($i = 0; $i<count($data); $i++)
        {
            $numGrave = ($data[$i]["numGrave"] != "") ? $data[$i]["numGrave"] : $numGrave;
            $hasBorder = ($data[$i]["hasBorder"] != "") ? $data[$i]["hasBorder"] : $hasBorder;
            $border = ($data[$i]["border"] != "") ? $data[$i]["border"] : $border;
            $ww2 = ($data[$i]["ww2"] != "") ? $data[$i]["ww2"] : $ww2;
            $sizeGrave = ($data[$i]["sizeGrave"] != "") ? $data[$i]["sizeGrave"] : $sizeGrave;
            $fio = $data[$i]["fioDead"];
            $yearBorn = $data[$i]["yearBorn"];
            $yearDeath = $data[$i]["yearDeath"];
            $memorial = $data[$i]["memorial"];
            $memorialMaterial = $data[$i]["memorialMaterial"];
            $sizeMemorial = $data[$i]["sizeMemorial"];
            $this->addDead($fio,$yearBorn,$yearDeath,$memorial,$sizeMemorial,$memorialMaterial);
        }

        $this->setHasBorderByString($hasBorder);
        $this->border = $border;
        $this->setSizeGrave($sizeGrave);
        $this->numGrave = $numGrave;

        $this->setWw2ByString($ww2);
    }


    /**
     * Возвращает объект Grave по данным из regsystem или ложь в случае нахождения дубля в БД
     * @param Array $data Данные распарсенные из json
     * @return Grave|false
     */
    public static function loadFromRegsystem($data)
    {
        $duplicate = Grave::where("idFromRegsystem",$data->id)
            ->first();
        if ($duplicate == null)
        {
            $cemetery = Cemetery::where("idFromRegsystem",$data->cemetery)->first();

            $grave = new Grave();
            $grave->idCemetery = $cemetery->id;
            $grave->idFromRegsystem = $data->id;
            $grave->addDeadWithDates($data->family." ".$data->name." ".$data->patron,$data->dateBirth,$data->dateDeath,"","","");
            $grave->latitude = $data->latitude;
            $grave->square = (int)$data->sizeOfArea;
            $grave->sizeGrave = "";
            $grave->state = Grave::$STATE_EMPTY;
            $grave->longitude = $data->longitude;
        } else
            $grave = $duplicate;
        return $grave;
    }


    public function loadDeads()
    {
        $this->_deads = Dead::where("idGrave",$this->id)
            ->get();
    }

    /**
     * @return Cemetery
     */
    public function getCemetery()
    {
        return Cemetery::findOrFail($this->idCemetery);
    }

    public function cemetery()
    {
        return $this->belongsTo('\App\Models\Cemetery',"idCemetery");
    }



    //
}
