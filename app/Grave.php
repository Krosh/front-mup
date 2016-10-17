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
 * @property string $memorial
 * @property string $sizeMemorial
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
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereMemorial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereSizeMemorial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereWw2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grave whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Grave extends Model
{
    //
}
