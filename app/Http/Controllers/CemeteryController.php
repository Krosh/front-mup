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
        $cemetery->loadCoords();
    }

    public function map()
    {
        return view("map");
    }
}
