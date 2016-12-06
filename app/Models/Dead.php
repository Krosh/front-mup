<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dead
 *
 * @property integer $id
 * @property integer $idGrave
 * @property string $family
 * @property string $name
 * @property string $patron
 * @property integer $yearBorn
 * @property integer $yearDeath
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $memorial
 * @property string $sizeMemorial
 * @property string $memorialMaterial
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereIdGrave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereFamily($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead wherePatron($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereYearBorn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereYearDeath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereMemorial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereSizeMemorial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereMemorialMaterial($value)
 * @mixin \Eloquent
 * @property string $dateBorn
 * @property string $dateDeath
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereDateBorn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dead whereDateDeath($value)
 * @property-read \App\Models\Grave $grave
 */
class Dead extends Model
{

    protected $fillable = ['family', 'name', 'patron', 'dateBorn', 'dateDeath', 'material', 'sizeMaterial', 'memorialMaterial', 'idGrave'];

    public function findDuplicate()
    {
        $duplicate = Dead::where("idGrave",$this->idGrave)
            ->where("family",$this->family)
            ->where("name",$this->name)
            ->where("patron",$this->patron)
            ->first();

        return $duplicate;
    }

    public function setDateBorn($value)
    {
        $mas = explode(".",$value);
        $this->dateBorn = implode("-",array_reverse($mas));
    }

    public function setDateDeath($value)
    {
        $mas = explode(".",$value);
        $this->dateDeath = implode("-",array_reverse($mas));
    }

    public function setYearBorn($value)
    {
        $this->yearBorn = (int)$value;
    }

    public function setYearDeath($value)
    {
        $this->yearDeath = (int)$value;
    }

    public function copyFrom(Dead $item)
    {
        $this->yearBorn = $item->yearBorn;
        $this->yearDeath = $item->yearDeath;
        $this->memorialMaterial = $item->memorialMaterial;
        $this->memorial = $item->memorial;
        $this->sizeMemorial = $item->sizeMemorial;
    }


    public function grave()
    {
        return $this->belongsTo('App\Models\Grave',"idGrave","id");
    }

    public function cemetery()
    {
        return $this->grave->cemetery;
    }

    /**
     * @return Grave
     */
    public function getGrave()
    {
        return Grave::findOrFail($this->idGrave);
    }

    public function getCemetery()
    {
        return $this->getGrave()->getCemetery();
    }

    public function getFio()
    {
        return $this->family." ".$this->name." ".$this->patron;
    }

    public function parseFio($fio)
    {
        $this->family = "";
        $this->name = "";
        $this->patron = "";

        $fio = trim($fio);
        $elements = explode(" ",$fio);
        $elements = array_filter($elements,function($elem) {
            return strlen($elem) > 0;
        });
        $elements = array_map(function($elem) {
            return mb_strtoupper(mb_substr($elem,0,1)).mb_substr($elem,1);

        }, $elements);

        if (count($elements)>0)
            $this->family = $elements[0];
        if (count($elements)>1)
            $this->name = $elements[1];
        if (count($elements)>2)
            $this->patron = $elements[2];
    }


    public function getDescription()
    {
        $result = "";
        $grave = $this->grave;
        return $grave->id;
    }

    public function getGraveUrl()
    {
        return url("/graves/".$this->idGrave."/edit#dead");
    }

    public function getImagePath()
    {
        return "http://placehold.it/350x150";
    }

    public function getSearchInfo()
    {
        $arr = [];
        $arr["fio"] = $this->getFio();
        // TODO:: Заменить year на date, когда будет совершен переход на использование полных дат
        $arr["dateBorn"] = $this->yearBorn;
        $arr["dateDeath"] = $this->yearDeath;
        $arr["cemetery"] = $this->getCemetery()->name;
        $arr["city"] = $this->getCemetery()->getCity()->name;
        $arr["id"] = $this->id;
        $arr["description"] = $this->getDescription();
        $arr["image"] = $this->getImagePath();
        return $arr;
    }

}
