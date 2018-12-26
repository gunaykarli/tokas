<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesAuthorization extends Model
{
    protected $fillable = [ 'system_feature_id',
        'permission_of_role1',
        'permission_of_role2',
        'permission_of_role3',
        'permission_of_role4',
        'permission_of_role5',
        'permission_of_role6'
    ];

    public function systemFeature(){

        return $this->belongsTo(SystemFeature::class);
    }

    public function store($systemFeatureID, $request){

        //** Called from SystemFeatureController@store */
        $rolesAuthorization = new RolesAuthorization();

        $rolesAuthorization->system_feature_id = $systemFeatureID;
        if ($request->permissionRole1 == 'on')
            $rolesAuthorization->permission_of_role1 = true;
        else
            $rolesAuthorization->permission_of_role1 = false;

        if ($request->permissionRole2 == 'on')
            $rolesAuthorization->permission_of_role2 = true;
        else
            $rolesAuthorization->permission_of_role2 = false;

        if ($request->permissionRole3 == 'on')
            $rolesAuthorization->permission_of_role3 = true;
        else
            $rolesAuthorization->permission_of_role3 = false;

        if ($request->permissionRole4 == 'on')
            $rolesAuthorization->permission_of_role4 = true;
        else
            $rolesAuthorization->permission_of_role4 = false;

        if ($request->permissionRole5 == 'on')
            $rolesAuthorization->permission_of_role5 = true;
        else
            $rolesAuthorization->permission_of_role5 = false;

        if ($request->permissionRole6 == 'on')
            $rolesAuthorization->permission_of_role6 = true;
        else
            $rolesAuthorization->permission_of_role6 = false;


        $rolesAuthorization->save();

        return redirect()->back();


    }

}
