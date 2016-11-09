<?php

namespace App\Http\Controllers;

use App\Forms\CemeteryForm;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cemetery;
use App\Models\City;
use App\Models\Grave;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Session;

class CemeteriesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cemeteries = Cemetery::paginate(25);

        return view('cemeteries.index', compact('cemeteries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(CemeteryForm::class, [
        'method' => 'POST',
        'url' => url("/cemeteries"),
    ]);
        return view('cemeteries.create',["form" => $form]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $requestData = $request->all();

        if ($requestData["idParentCemetery"] == "")
            unset($requestData["idParentCemetery"]);
        if (!isset($requestData["hasTestData"]))
            $requestData["hasTestData"] = 0;

        Cemetery::create($requestData);

        Session::flash('flash_message', 'Cemetery added!');

        return redirect('cemeteries');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $cemetery = Cemetery::findOrFail($id);

        return view('cemeteries.show', compact('cemetery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $cemetery = Cemetery::findOrFail($id);
        $form = $formBuilder->create(CemeteryForm::class, [
            'method' => 'PATCH',
            'url' => url('/cemeteries',[$cemetery->id]),
            'model' => $cemetery,

         ]);
        $graves = Grave::where("idCemetery",$id)
            ->paginate(25);

        return view('cemeteries.edit', ["cemetery" => $cemetery, "form" => $form, "graves" => $graves]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $requestData = $request->all();

        $cemetery = Cemetery::findOrFail($id);
        if ($requestData["idParentCemetery"] == "")
            unset($requestData["idParentCemetery"]);
        if (!isset($requestData["hasTestData"]))
            $requestData["hasTestData"] = 0;
        $cemetery->update($requestData);




        Session::flash('flash_message', 'Cemetery updated!');

        return redirect('cemeteries',301);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Cemetery::destroy($id);

        Session::flash('flash_message', 'Cemetery deleted!');

        return redirect('cemeteries');
    }

    public function geojson()
    {
        $result = [];

        $cemeteries = Cemetery::all();
        foreach ($cemeteries as $cemetery)
        {
            $result[] = $cemetery->getAsGeoJson();
        }
        return $result;
    }

    public function info()
    {
        $result = [];
        $cemeteries = Cemetery::whereNull("idParentCemetery")
            ->get();
        foreach ($cemeteries as $cemetery)
        {
            $array = ["id" => $cemetery->id];
            $array["heatmap"] = $cemetery->getHeatmap();
            $array["geo"] = $cemetery->getAsGeoJson();
            $result[] = $array;
        }
        return $result;
    }



    /**
     * Load cadastr info from internet
     * @param $id id of cemetery
     * @param Request $request request with cadastr_num to set to cemetery
     * @return array geoJson array
     */
    public function cadastr($id, Request $request)
    {
        $cadastr_num = $request->get("cadastr_num");
        $cemetery = Cemetery::findOrFail($id);
        if ($cemetery->cadastr_num != $cadastr_num)
        {
            $cemetery->cadastr_num = $cadastr_num;
            $cemetery->save();
        }
        $points = $cemetery->getCoords();

        if (count($points) == 0)
            abort(404);

        return $cemetery->getAsGeoJson();
    }



}
