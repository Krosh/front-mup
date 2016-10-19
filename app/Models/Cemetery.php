<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cemetery
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Cemetery whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cemetery whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cemetery whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Cemetery whereName($value)
 * @property string $cadastr_num
 * @method static \Illuminate\Database\Query\Builder|\App\Cemetery whereCadastrNum($value)
 * @property integer $idCity
 * @method static \Illuminate\Database\Query\Builder|\App\Cemetery whereIdCity($value)
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
