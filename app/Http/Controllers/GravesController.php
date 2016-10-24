<?php

namespace App\Http\Controllers;

use App\Forms\GraveForm;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        $graves = Grave::paginate(25);

        return view('graves.index', compact('graves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('graves.create');
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
        
        Grave::create($requestData);

        Session::flash('flash_message', 'Grave added!');

        return redirect('graves');
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
        $grave->loadDeads();

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

        return redirect('graves');
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
        Grave::destroy($id);

        Session::flash('flash_message', 'Grave deleted!');

        return redirect('graves');
    }
}
