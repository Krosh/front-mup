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
 * @property integer $idCity
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereCadastrNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cemetery whereIdCity($value)
 * @mixin \Eloquent
 */
class Cemetery extends Model
{
    protected $fillable = ['name','cadastr_num','idCity'];

    public function getCoords()
    {
        return CemeteryCoord::where("idCemetery",$this->id)
            ->orderBy("num_point","ASC")
            ->get();
    }

    public function getCity()
    {
        return City::find($this->idCity);
    }

    public function loadCoords()
    {
        $url = "http://getpkk.ru/get/{$this->cadastr_num}/1";

        $data = json_decode(file_get_contents($url));

        if (!isset($data) || !isset($data->coordinates))
        {
            return false;
        }

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

}
