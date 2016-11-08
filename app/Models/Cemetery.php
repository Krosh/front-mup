<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Cemetery
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $cadastr_num
 * @property integer $cadastr_size
 * @property string $cadastr_adres
 * @property integer $idCity
 * @property float $center_lat
 * @property float $center_lon
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCadastrNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereIdCity($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCadastrSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCadastrAdres($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCenterLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCenterLon($value)
 * @property integer $square_filled
 * @property string $watcher_name
 * @property string $watcher_phone
 * @property string $organisation_name
 * @property integer $graveCount
 * @property integer $idFromRegion22
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereSquareFilled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereWatcherName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereWatcherPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereOrganisationName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereGraveCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereIdFromRegion22($value)
 */
class Cemetery extends Model
{
    protected $fillable = ['name','cadastr_num','idCity', 'square_filled', 'watcher_phone', 'watcher_name', 'organisation_name'];


    public $_coords = null;
    public function getCoords()
    {
        if ($this->_coords == null)
        {
            $this->_coords =
                CemeteryCoord::where("idCemetery",$this->id)
                    ->orderBy("num_point","ASC")
                    ->get();
        }
        return $this->_coords;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return City::findOrFail($this->idCity);
    }

    public function loadCoords()
    {
        $url = "http://getpkk.ru/get/{$this->cadastr_num}/1";


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = '';
        if( ($json = curl_exec($ch) ) === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }
        $data = json_decode($json);


        if (!isset($data) || !isset($data->coordinates))
        {
            return false;
        }

        $this->cadastr_adres = $data->attrs->address;
        $this->cadastr_size = $data->attrs->area_value;

        $coords = $data->coordinates[0][0];

        $numCoords = CemeteryCoord::where("idCemetery",$this->id)
            ->count();
        if ($numCoords <> count($coords))
        {
            CemeteryCoord::where("idCemetery",$this->id)
                ->delete();
            $i = 0;
            foreach ($coords as $item)
            {
                $coord = new CemeteryCoord();
                $coord->idCemetery = $this->id;
                $coord->num_point = $i++;
                $coord->longitude = $item[0];
                $coord->latitude = $item[1];
                $coord->save();
            }
        }
        return true;
    }

    public function save(array $options = [])
    {
        if ($this->exists && $this->isDirty("cadastr_num"))
            $this->loadCoords();


        return parent::save($options);
    }

    public function getDynamicGrave()
    {
        $result = [];
        $result["title"] = ["text" => "Динамика кол-ва захоронений"];
        $result["xAxis"] = ["categories" => ["январь", "февраль", "март"]];
        $result["yAxis"] = ["title" => ["text" => "Кол-во захоронений"]];
        $result["series"] = [["name" => "Кол-во", "data" => [10,20,30]]];
        return json_encode($result);
    }

    public function getFilledSize()
    {
        return $this->square_filled;
    }

    public function getGraveCount()
    {
        return 100;
    }

    public function getGraves()
    {
        return Grave::where("idCemetery",$this->id)
            ->get();
    }

    public function getHeatmap()
    {
        $graves = $this->getGraves();
        $result = [];
        foreach ($graves as $grave)
        {
            $arr = [floatval($grave->latitude),floatval($grave->longitude),1];
            $result[] = $arr;
        }
        return ["points" => $result, "radius" => 15];
    }

    public function getAsGeoJson()
    {
        $result = [];
        $result["type"] = "FeatureCollection";
        $result["features"] = [];

        $cemeteryFeature = [];
        $cemeteryFeature["type"] = "Feature";
        $cemeteryFeature["geometry"] = [];
        $cemeteryFeature["geometry"]["type"] = "Polygon";
        $cemeteryFeature["geometry"]["coordinates"] = [];
        $cemeteryFeature["geometry"]["coordinates"][0] = [];
        $cemeteryFeature["properties"]["id"] = $this->id;
        $cemeteryFeature["properties"]["name"] = $this->name;
        $cemeteryFeature["properties"]["centerLat"] = $this->getCoords()[0]->latitude;
        $cemeteryFeature["properties"]["centerLon"] = $this->getCoords()[0]->longitude;
        $cemeteryFeature["properties"]["totalSize"] = $this->cadastr_size;
        $cemeteryFeature["properties"]["fillSize"] = $this->getFilledSize();
        $cemeteryFeature["properties"]["adres"] = $this->cadastr_adres;
        $cemeteryFeature["properties"]["popup"] = $this->name;
        $cemeteryFeature["properties"]["watcher_name"] = $this->watcher_name;
        $cemeteryFeature["properties"]["watcher_phone"] = $this->watcher_phone;
        $cemeteryFeature["properties"]["cadastr_num"] = $this->cadastr_num;
        $cemeteryFeature["properties"]["organisation_name"] = $this->organisation_name;
        $cemeteryFeature["properties"]["square_info"] = number_format($this->getFilledSize(),0,","," ")." м<sup>2</sup>"."/".number_format($this->cadastr_size,0,","," ")." м<sup>2</sup>";
        $cemeteryFeature["properties"]["graves_count"] = $this->getGraveCount();
        $cemeteryFeature["properties"]["graves_dynamic"] = $this->getDynamicGrave();

        foreach ($this->getCoords() as $point)
        {
            $coords = [$point->longitude*1,$point->latitude*1];
            $cemeteryFeature["geometry"]["coordinates"][0][] = $coords;
        }
//        $cemeteryFeature["geometry"]["coordinates"][0][] = $cemeteryFeature["geometry"]["coordinates"][0][0];
         $result["features"][] = $cemeteryFeature;
         return $result;
    }

}
