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
    public function getCoords()
    {
        return CemeteryCoord::where("idCemetery",$this->id)
            ->orderBy("num_point","ASC")
            ->get();
    }
}
