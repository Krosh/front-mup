<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Grave
 *
 * @property integer $id
 * @property string $name
 * @property integer $idCemetery
 * @property integer $numDeads
 * @property string $sizeGrave
 * @property boolean $hasBorder
 * @property string $border
 * @property integer $state
 * @property boolean $ww2
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereIdCemetery($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereNumDeads($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereSizeGrave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereHasBorder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereBorder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereWw2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $numGrave
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereNumGrave($value)
 */
class Grave extends Model
{
    public static $STATE_OK = 1;
    public static $STATE_NON_OK = 2;
    public static $STATE_FORGOTTEN = 3;
    public static $STATE_EMPTY = 4;

    public function setCemeteryByString($name)
    {
        $cemetery = Cemetery::where("name",$name)
            ->first();
        if ($cemetery == null)
        {
            $cemetery = new Cemetery();
            $cemetery->name = $name;
            $cemetery->save();
        }
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


    public function makeFromData($data)
    {
        $this->setCemeteryByString($data[0]["nameCemetery"]);
        $this->setStateByString($data[0]["state"]);

        $hasBorder = "";
        $border = "";
        $ww2 = "";
        $sizeGrave = "";
        $numGrave = "";
        for ($i = 0; $i<count($data); $i++)
        {
            $numGrave = ($data[$i]["numGrave"] != "") ? $data[$i]["numGrave"] : $numGrave;
            $hasBorder = ($data[$i]["hasBorder"] != "") ? $data[$i]["hasBorder"] : $hasBorder;
            $border = ($data[$i]["border"] != "") ? $data[$i]["border"] : $border;
            $ww2 = ($data[$i]["ww2"] != "") ? $data[$i]["ww2"] : $ww2;
            $sizeGrave = ($data[$i]["sizeGrave"] != "") ? $data[$i]["sizeGrave"] : $sizeGrave;
        }

        $this->setHasBorderByString($hasBorder);
        $this->border = $border;
        $this->sizeGrave = $sizeGrave;
        $this->numGrave = $numGrave;

        $this->setWw2ByString($ww2);

    }


    //
}
