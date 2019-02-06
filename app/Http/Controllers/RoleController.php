<?php

namespace App\Http\Controllers;

use App\Role;
use App\RolesAuthorization;
use App\SystemFeature;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     *
     * To redirect to login page when session timeout
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rolesAuthorizations = RolesAuthorization::all();
        $systemFeatures = SystemFeature::all();

        return view('authorizations.edit-roles-permissions', compact('rolesAuthorizations', 'systemFeatures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $systemFeatureID)
    {
        $rolesAuthorization = RolesAuthorization::where('system_feature_id', $systemFeatureID)->first();

        if(array_key_exists(1, $request->action[$systemFeatureID])){
            if ($request->action[$systemFeatureID][1]== 'on')
                $rolesAuthorization->permission_of_role1 = 1;
        }
        else
            $rolesAuthorization->permission_of_role1 = 0;

        if(array_key_exists(2, $request->action[$systemFeatureID])){
            if ($request->action[$systemFeatureID][2]== 'on')
                $rolesAuthorization->permission_of_role2 = 1;
        }
        else
            $rolesAuthorization->permission_of_role2 = 0;

        if(array_key_exists(3, $request->action[$systemFeatureID])){
            if ($request->action[$systemFeatureID][3]== 'on')
                $rolesAuthorization->permission_of_role3 = 1;
        }
        else
            $rolesAuthorization->permission_of_role3 = 0;

        if(array_key_exists(4, $request->action[$systemFeatureID])){
            if ($request->action[$systemFeatureID][4]== 'on')
                $rolesAuthorization->permission_of_role4 = 1;
        }
        else
            $rolesAuthorization->permission_of_role4 = 0;

        if(array_key_exists(5, $request->action[$systemFeatureID])){
            if ($request->action[$systemFeatureID][5]== 'on')
                $rolesAuthorization->permission_of_role5 = 1;
        }
        else
            $rolesAuthorization->permission_of_role5 = 0;

        if(array_key_exists(6, $request->action[$systemFeatureID])){
            if ($request->action[$systemFeatureID][6]== 'on')
                $rolesAuthorization->permission_of_role6 = 1;
        }
        else
            $rolesAuthorization->permission_of_role6 = 0;

        $rolesAuthorization->save();

        $rolesAuthorizations = RolesAuthorization::all();
        $systemFeatures = SystemFeature::all();

        return view('authorizations.edit-roles-permissions', compact('rolesAuthorizations', 'systemFeatures'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
