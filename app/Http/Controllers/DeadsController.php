<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Dead;
use Illuminate\Http\Request;
use Session;

class DeadsController extends Controller
{

    public function filterRequestData($requestData)
    {
        $result = $requestData;
        if ($result["dateBorn"] == "")
            unset($result["dateBorn"]);
        if ($result["dateDeath"] == "")
            unset($result["dateDeath"]);
        return $result;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $deads = Dead::paginate(25);

        return view('deads.index', compact('deads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($idGrave)
    {
        $dead = new Dead();
        $dead->idGrave = $idGrave;
        return view('deads.create',["dead" => $dead]);
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
        
        $requestData = $this->filterRequestData($request->all());
        
        $dead = Dead::create($requestData);

        Session::flash('flash_message', 'Dead added!');

        return redirect($dead->getGraveUrl());
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
        $dead = Dead::findOrFail($id);

        return view('deads.show', compact('dead'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $dead = Dead::findOrFail($id);

        return view('deads.edit', compact('dead'));
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
        
        $requestData = $this->filterRequestData($request->all());

        $dead = Dead::findOrFail($id);
        $dead->update($requestData);

        Session::flash('flash_message', 'Dead updated!');

        return redirect($dead->getGraveUrl());
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
        $dead = Dead::findOrFail($id);
        $backUrl = $dead->getGraveUrl();
        $dead->delete();

        Session::flash('flash_message', 'Dead deleted!');

        return redirect($backUrl);
    }

    public function info(Request $request)
    {
        $id = $request->get("id");
        $dead = Dead::findOrFail($id);
        return [
            "idCemetery" => $dead->getCemetery()->id,
            "lat" => $dead->getGrave()->latitude,
            "lng" => $dead->getGrave()->longitude,
        ];
    }

    public function search(Request $request)
    {
        $fio = $request->get("fio");
        $arr = explode(" ",$fio);
        $deads = Dead::where("family","LIKE", "%{$arr[0]}%");
        if (count($arr)>1)
            $deads = $deads->where("name","LIKE","%{$arr[1]}%");
        if (count($arr)>2)
            $deads = $deads->where("patron","LIKE","%{$arr[2]}%");
        $deads = $deads->where("family", "<>", "")
            ->where("name", "<>", "")
            ->where("patron", "<>", "");
        $deads = $deads->take(20)->get();
        $result = [];
        foreach ($deads as $item)
        {
            $result[] = $item->getSearchInfo();
        }
        return $result;

    }
}
