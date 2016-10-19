<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\CemeteryCoord
 *
 * @property integer $id
 * @property integer $idCemetery
 * @property float $latitude
 * @property float $longitude
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $num_point
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CemeteryCoord whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CemeteryCoord whereIdCemetery($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CemeteryCoord whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CemeteryCoord whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CemeteryCoord whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CemeteryCoord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CemeteryCoord whereNumPoint($value)
 * @mixin \Eloquent
 */
class CemeteryCoord extends Model
{
    //
}
