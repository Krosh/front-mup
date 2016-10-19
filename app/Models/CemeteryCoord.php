<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CemeteryCoord
 *
 * @property integer $id
 * @property integer $idCemetery
 * @property float $latitude
 * @property float $longitude
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\CemeteryCoord whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CemeteryCoord whereIdCemetery($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CemeteryCoord whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CemeteryCoord whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CemeteryCoord whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CemeteryCoord whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $num_point
 * @method static \Illuminate\Database\Query\Builder|\App\CemeteryCoord whereNumPoint($value)
 */
class CemeteryCoord extends Model
{
    //
}
