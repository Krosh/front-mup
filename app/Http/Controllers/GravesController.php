<?php

namespace App\Http\Controllers;

use App\Forms\GraveForm;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cemetery;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\Grave;
use Illuminate\Http\Request;
use Session;

class GravesController extends Controller
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
        abort(404,"Not used");
    }

    public function create()
    {
        abort(404,"Not used");
    }

    public function by_cemetery(Request $request, $id)
    {
        if ($request->get("page") != null)
        {
            $request->session()->set("grave_page",$request->get("page"));
        }
        $page = $request->session()->get("grave_page",1);
        $cemetery = Cemetery::findOrFail($id);
        $graves = Grave::where("idCemetery",$id)
            ->paginate(25,['*'],'page',$page);
        return view('graves.index', ["graves" => $graves, "cemetery" => $cemetery]);

    }

    public function add($id, FormBuilder $formBuilder)
    {
        $model = new Grave();
        $model->idCemetery = $id;

        $form = $formBuilder->create(GraveForm::class, [
            'method' => 'POST',
            'url' => url('/graves'),
            'model' => $model,
        ]);

        return view('graves.create', ["form" => $form]);
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
        
        $grave = Grave::create($requestData);

        Session::flash('flash_message', 'Grave added!');

        return redirect('cemeteries/'.$grave->idCemetery."/graves");
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
        $grave = Grave::findOrFail($id);

        return view('graves.show', compact('grave'));
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
        $grave = Grave::findOrFail($id);

        $form = $formBuilder->create(GraveForm::class, [
            'method' => 'PATCH',
            'url' => url('/graves',[$grave->id]),
            'model' => $grave,
        ]);

        $deads = $grave->getDeads();

        return view('graves.edit', ["grave" => $grave, "form" => $form, "deads" => $deads]);
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
        
        $grave = Grave::findOrFail($id);
        $grave->update($requestData);

        Session::flash('flash_message', 'Grave updated!');

        return redirect('cemeteries/'.$grave->idCemetery."/graves");
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
        $grave = Grave::find($id);
        $grave->delete();

        Session::flash('flash_message', 'Grave deleted!');

        return redirect('cemeteries/'.$grave->idCemetery."/graves");
    }
}
