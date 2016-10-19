<?php

namespace App\Http\Controllers;

use App\Models\Cemetery;
use App\Models\CemeteryCoord;
use Illuminate\Http\Request;

use App\Http\Requests;

class CemeteryController extends Controller
{
    public function loadCoordsFromSite($id)
    {
        $cemetery = Cemetery::findOrFail($id);

        $url = "http://getpkk.ru/get/{$cemetery->cadastr_num}/1";

        $data = json_decode(file_get_contents($url));

        $coords = $data->coordinates[0][0];

        $numCoords = CemeteryCoord::where("idCemetery",$cemetery->id)
            ->count();
        if ($numCoords <> count($coords))
        {
            CemeteryCoord::where("idCemetery",$cemetery->id)
                ->delete();
            $i = 0;
            foreach ($coords as $item)
            {
                $coord = new CemeteryCoord();
                $coord->idCemetery = $cemetery->id;
                $coord->num_point = $i++;
                $coord->longitude = $item[0];
                $coord->latitude = $item[1];
                $coord->save();
            }
        }
    }

    public function map()
    {
        return view("map");
    }
}
