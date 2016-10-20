<?php

namespace App\Http\Controllers;

use App\Forms\CemeteryForm;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cemetery;
use App\Models\City;
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

        return view('cemeteries.edit', ["cemetery" => $cemetery, "form" => $form]);
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
        $cemetery->update($requestData);


        Session::flash('flash_message', 'Cemetery updated!');

        return redirect('cemeteries');
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


    public function cadastr($id, Request $request)
    {
        $cadastr_num = $request->get("cadastr_num");
        $cemetery = Cemetery::findOrFail($id);
        if ($cemetery->cadastr_num != $cadastr_num)
        {
            $cemetery->cadastr_num = $cadastr_num;
            $cemetery->loadCoords();
            $cemetery->save();
        }
        $result = [];
        $result["type"] = "FeatureCollection";
        $result["features"] = [];
        $cemeteryFeature = [];
        $cemeteryFeature["type"] = "Feature";
        $cemeteryFeature["geometry"] = [];
        $cemeteryFeature["geometry"]["type"] = "Polygon";
        $cemeteryFeature["geometry"]["coordinates"] = [];
        $cemeteryFeature["geometry"]["coordinates"][0] = [];
        $cemeteryFeature["properties"]["name"] = $cemetery->name;
//        $cemeteryFeature["properties"]["popup"] = $district->getPopupText();
        $points = $cemetery->getCoords();
        foreach ($points as $point)
        {
            $coords = [$point->longitude*1,$point->latitude*1];
            $cemeteryFeature["geometry"]["coordinates"][0][] = $coords;
        }
//        $cemeteryFeature["geometry"]["coordinates"][0][] = $cemeteryFeature["geometry"]["coordinates"][0][0];
        $result["features"][] = $cemeteryFeature;

        return $result;

    }

}
