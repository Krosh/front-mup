<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Cemetery
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $cadastr_num
 * @property integer $idCity
 * @property integer $cadastr_size
 * @property string $cadastr_adres
 * @property float $center_lat
 * @property float $center_lon
 * @property string $watcher_name
 * @property string $watcher_phone
 * @property string $organisation_name
 * @property integer $idFromRegion22
 * @property integer $idParentCemetery
 * @property boolean $hasTestData
 * @property integer $test_square
 * @property integer $test_graveCount
 * @property integer $idFromRegsystem
 * @property boolean $hasImport
 * @property boolean $isClosed
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCadastrNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereIdCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCadastrSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCadastrAdres($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCenterLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCenterLon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereWatcherName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereWatcherPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereOrganisationName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereIdFromRegion22($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereIdParentCemetery($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereHasTestData($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereTestSquare($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereTestGraveCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereIdFromRegsystem($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereHasImport($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereIsClosed($value)
 * @mixin \Eloquent
 */
class Cemetery extends Model
{
    protected $fillable = ['name','cadastr_num','idCity', 'watcher_phone', 'watcher_name', 'organisation_name', 'idParentCemetery', 'hasTestData', 'test_square', 'test_graveCount', "idFromRegsystem","idFromRegion22", "isClosed"];

    public $_coords = null;

    static public $defaultValues = [
        "test_square" => 0,
        "test_graveCount" => 0,
        "idFromRegsystem" => -1,
        "idFromRegion22" => 0,
        "hasTestData" => 0,
    ];

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
            echo $json;
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
        $new = !$this->exists;
        if (!$new && $this->isDirty("cadastr_num"))
            $this->loadCoords();

        $result = parent::save($options);

        if ($new)
        {
            if ($this->loadCoords())
                $result = parent::save($options);
        }
        return $result;

    }

    public function getDiagramNumGravesByDates()
    {
        $queryResults = DB::table("deads")
            ->join("graves","deads.idGrave","=","graves.id")
            ->select(DB::raw("COUNT(deads.id) as numDeads"))
            ->addSelect("yearDeath as year_death") // TODO:: Когда вместо годов начнут использоваться даты, тут нужно будет переделать
            ->where("idCemetery","=",$this->id)
            ->groupBy("year_death")
            ->having("year_death", ">", 0)
            ->orderBy("year_death")
            ->get();

        $categories = [];
        $data = [];
        foreach ($queryResults as $item)
        {
            $categories[] = $item->year_death;
            $data[] = $item->numDeads;
        }
        $result = [];
        $result["title"] = ["text" => "Динамика кол-ва захоронений"];
        $result["xAxis"] = ["categories" => $categories];
        $result["yAxis"] = ["title" => ["text" => "Кол-во захоронений"]];
        $result["series"] = [["name" => "Кол-во", "data" => $data]];
        return json_encode($result);
    }

    public function getDiagramNumGravesByStates()
    {
        $queryResults = DB::table("deads")
            ->join("graves","deads.idGrave","=","graves.id")
            ->select(DB::raw("COUNT(deads.id) as numDeads"))
            ->addSelect("state")
            ->where("idCemetery","=",$this->id)
            ->groupBy("state")
            ->get();
        $categories = [];
        $data = [];
        foreach ($queryResults as $item)
        {
            $data[] = ["name" => Grave::getStates()[$item->state], "y" => $item->numDeads];
        }
        $result = [];
        $result["chart"] = [
            "type" => "pie",
        ];
        $result["title"] = ["text" => "Захоронения, сгруппированые по состоянию"];
        $result["series"] = [["name" => "Кол-во", "data" => $data]];
        return json_encode($result);
    }

    public function getDeadsSquare()
    {
        $MM_TO_METERS_COEF = 1000*1000;
        if ($this->hasTestData)
        {
            return $this->test_square;
        } else
        {
            $sum = DB::table("graves")
                ->where("idCemetery","=",$this->id)
                ->sum("square") / $MM_TO_METERS_COEF;
            $sum += DB::table("graves")
                ->join("cemeteries","graves.idCemetery","=","cemeteries.id")
                ->where("idParentCemetery","=",$this->id)
                ->sum("square")/ $MM_TO_METERS_COEF;
            return $sum;
        }
    }

    public function getFilledSize()
    {
        $MM_TO_METERS_COEF = 1000*1000;
        $ADDITIVE_SIZE_TO_GRAVE = 2.5;
        if ($this->hasTestData)
        {
            return $this->test_square;
        } else
        {
            $sum = DB::table("graves")
                    ->where("idCemetery","=",$this->id)
                    ->sum("square") / $MM_TO_METERS_COEF;
            $sum += DB::table("graves")
                    ->join("cemeteries","graves.idCemetery","=","cemeteries.id")
                    ->where("idParentCemetery","=",$this->id)
                    ->sum("square")/ $MM_TO_METERS_COEF;
            $sum += $this->getGraveCount() * $ADDITIVE_SIZE_TO_GRAVE;
            return $sum;
        }
    }


    public function getGraveCount()
    {
        if ($this->hasTestData)
        {
            return $this->test_graveCount;
        } else
        {
            return DB::table("graves")
                ->where("idCemetery","=",$this->id)
                ->count()
             + DB::table("graves")
                ->join("cemeteries","graves.idCemetery","=","cemeteries.id")
                ->where("idParentCemetery","=",$this->id)
                ->count();
        }
    }

    public function getDeadCount()
    {
        if ($this->hasTestData)
        {
            return $this->test_graveCount;
        } else
        {
            return DB::table("deads")
                ->join("graves","deads.idGrave","=","graves.id")
                ->where("idCemetery","=",$this->id)
                ->count()
            + DB::table("deads")
                ->join("graves","deads.idGrave","=","graves.id")
                ->join("cemeteries","graves.idCemetery","=","cemeteries.id")
                ->where("idParentCemetery","=",$this->id)
                ->count();
        }
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

    public function getChildCemeteries()
    {
        return Cemetery::where("idParentCemetery",$this->id)
            ->get();
    }

    public function getAsGeoJson()
    {
        $result = [];
        $result["type"] = "FeatureCollection";
        $result["features"] = [];

        $cemeteryFeature = [];
        $cemeteryFeature["type"] = "Feature";
        $cemeteryFeature["geometry"] = [];
        $cemeteryFeature["geometry"]["type"] = "MultiPolygon";
        $cemeteryFeature["geometry"]["coordinates"] = [];
        $cemeteryFeature["geometry"]["coordinates"][0] = [];
        $cemeteryFeature["properties"]["id"] = $this->id;
        $cemeteryFeature["properties"]["name"] = $this->name;
        $cemeteryFeature["properties"]["status"] = $this->isClosed;
        $cemeteryFeature["properties"]["centerLat"] = $this->getCoords()[0]->latitude;
        $cemeteryFeature["properties"]["centerLon"] = $this->getCoords()[0]->longitude;
        $cemeteryFeature["properties"]["totalSize"] = $this->cadastr_size/10000;
        $cemeteryFeature["properties"]["fillSize"] = $this->getFilledSize()/10000;
        $cemeteryFeature["properties"]["adres"] = $this->cadastr_adres;
        $cemeteryFeature["properties"]["popup"] = $this->name;
        $cemeteryFeature["properties"]["watcher_name"] = $this->watcher_name;
        $cemeteryFeature["properties"]["watcher_phone"] = $this->watcher_phone;
        $cemeteryFeature["properties"]["cadastr_num"] = [$this->cadastr_num];
        $cemeteryFeature["properties"]["organisation_name"] = $this->organisation_name;
        $cemeteryFeature["properties"]["square_total"] = number_format($this->cadastr_size/10000,0,","," ")." га";
        $cemeteryFeature["properties"]["deads_square"] = number_format($this->getDeadsSquare()/10000,0,","," ")." га";
        $cemeteryFeature["properties"]["square_filled"] = number_format($this->getFilledSize()/10000,0,","," ")." га";
        $cemeteryFeature["properties"]["graves_count"] = $this->getGraveCount();
        $cemeteryFeature["properties"]["deads_count"] = $this->getDeadCount();
        $cemeteryFeature["properties"]["graves_dynamic"] = $this->getDiagramNumGravesByDates();
        $cemeteryFeature["properties"]["graves_by_states"] = $this->getDiagramNumGravesByStates();

        foreach ($this->getCoords() as $point)
        {
            $coords = [$point->longitude*1,$point->latitude*1];
            $cemeteryFeature["geometry"]["coordinates"][0][0][] = $coords;
        }
        $numCemetery = 1;
        foreach ($this->getChildCemeteries() as $childCemetery)
        {
            foreach ($childCemetery->getCoords() as $point)
            {
                $coords = [$point->longitude*1,$point->latitude*1];
                $cemeteryFeature["geometry"]["coordinates"][$numCemetery][0][] = $coords;
            }
            $cemeteryFeature["properties"]["cadastr_num"][] = $childCemetery->cadastr_num;
            $numCemetery++;
        }
//        $cemeteryFeature["geometry"]["coordinates"][0][] = $cemeteryFeature["geometry"]["coordinates"][0][0];
         $result["features"][] = $cemeteryFeature;
         return $result;
    }

}
