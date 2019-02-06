<?php

namespace App\Http\Controllers;

use App\RolesAuthorization;
use Illuminate\Http\Request;

class RolesAuthorizationController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('authorizations.editRolesPermissions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RolesAuthorization  $rolesAuthorization
     * @return \Illuminate\Http\Response
     */
    public function show(RolesAuthorization $rolesAuthorization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RolesAuthorization  $rolesAuthorization
     * @return \Illuminate\Http\Response
     */
    public function edit(RolesAuthorization $rolesAuthorization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RolesAuthorization  $rolesAuthorization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RolesAuthorization $rolesAuthorization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RolesAuthorization  $rolesAuthorization
     * @return \Illuminate\Http\Response
     */
    public function destroy(RolesAuthorization $rolesAuthorization)
    {
        //
    }
}
