<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Cemetery
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
 */
class Cemetery extends Model
{
    //
}
