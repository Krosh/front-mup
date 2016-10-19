<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\City
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    public function __toString()
    {
        return $this->name;
    }

    public static function allInList($idColumn,$nameColumn)
    {
        $models = self::all();
        $result = [];
        foreach ($models as $item)
        {
            $result[$item->$idColumn] = $item->$nameColumn;
        }
        return $result;
    }

    protected $fillable = ['name'];
}
