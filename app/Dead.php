<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Dead
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
 * @method static \Illuminate\Database\Query\Builder|\App\Dead whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dead whereIdGrave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dead whereFamily($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dead whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dead wherePatron($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dead whereYearBorn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dead whereYearDeath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dead whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dead whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dead extends Model
{
    //
}
