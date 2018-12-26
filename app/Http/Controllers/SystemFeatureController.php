<?php

namespace App\Http\Controllers;

use App\Authorization;
use App\Role;
use App\RolesAuthorization;
use App\SystemFeature;
use Illuminate\Http\Request;

class SystemFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = new Role();
        return view('authorizations.createSysFeatureAndAuthorizeRoles');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $systemFeature = new SystemFeature();

        $systemFeature->model =  ucfirst($request->model);
        $systemFeature->action = ucfirst($request->action);
        $systemFeature->lang_key_for_feature = 'feature' .
            str_replace(' ', '', ucfirst($request->model)) .
            str_replace(' ', '', ucfirst($request->action));
        $systemFeature->lang_key_for_description = 'desc' .
            str_replace(' ', '', ucfirst($request->model)) .
            str_replace(' ', '', ucfirst($request->action));

        $systemFeature->save();

        $systemFeature->where('model',$request->model )->where('action', $request->action)->get();

        //** create an authorization object and
        // call its "store" method to save permissions of all roles related to newly store system feature */
        $rolesAuthorization = new RolesAuthorization();
        $rolesAuthorization->store($systemFeature->id, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SystemFeature  $systemFeature
     * @return \Illuminate\Http\Response
     */
    public function show(SystemFeature $systemFeature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SystemFeature  $systemFeature
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemFeature $systemFeature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SystemFeature  $systemFeature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemFeature $systemFeature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SystemFeature  $systemFeature
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemFeature $systemFeature)
    {
        //
    }
}
