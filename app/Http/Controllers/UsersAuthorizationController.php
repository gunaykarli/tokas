<?php

namespace App\Http\Controllers;

use App\RolesAuthorization;
use App\SystemFeature;
use App\User;
use App\UsersAuthorization;
use Illuminate\Http\Request;

class UsersAuthorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $employeesAuthorizations = UsersAuthorization::all();

        //** take all employee working in the dealer whose owner is 'authed user'. */
        $employees = User
            ::where('dealer_id', Auth()->user()->dealer_id)
            ->where('role_id', 5)
            ->get();

        //** take all system features (IDs) that super user in dealer is authorized but the employees are not authorized.
        // if 'where('permission_of_role4', 1)'  is not used, some system features that ONLY system admin and super user in Toker are authorized are listed*/
        $authorizationsForRole4NotRole5 = RolesAuthorization::where('permission_of_role4', 1)->where('permission_of_role5', 0)->get();


        return view('authorizations.authorizeUser', compact('authorizationsForRole4NotRole5', 'employees', 'employeesAuthorizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($employeeID)
    {
        if($employeeID == 1)
            dd($employeeID);

        if(Auth()->check()){
            //** take all employee working in the dealer whose owner is 'authed user'. */
            $employees = User
                ::where('dealer_id', Auth()->user()->dealer_id)
                ->get();

            //** take all system features (IDs) that super user in dealer is authorized but the employees are not authorized.
            // if 'where('permission_of_role4', 1)'  is not used, some system features that ONLY system admin and super user in Toker are authorized are listed*/
            $rolesAuthorizations = RolesAuthorization
                ::where('permission_of_role4', 1)
                ->where('permission_of_role5', 0)
                ->get();

            //** take all system features (IDs) that the selected employee (in authorizeUser.blade.php) is authorized. */
            if($employeeID != 0 )
                $authorizationsOfTheEmployee = UsersAuthorization
                    ::where('user_id', $employeeID)
                    ->get();
        }
        //** $rolesAuthorizations includes system_feature_id that can allow us to reach SystemFeatures */
        if($employeeID != 0 ){
            //return view('authorizations.authorizeUser', compact('employees', 'rolesAuthorizations', 'authorizationsOfTheEmployee'));
            $data['rolesAuthorizations'] = $rolesAuthorizations;
            $data['authorizationsOfTheEmployee'] = $authorizationsOfTheEmployee;
            $data['systemFeatures'] = SystemFeature::all();
            return response()->json($data);
        }
        else{
            return view('authorizations.authorizeUser', compact('employees', 'rolesAuthorizations'));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store1(Request $request)
    {

                $userAuthorization = new UsersAuthorization();
                $rolesAuthorizations = RolesAuthorization
                    ::where('permission_of_role4', 1)
                    ->where('permission_of_role5', 0)
                    ->get();
                $systemFeature = new SystemFeature();


               foreach ($rolesAuthorizations as $rolesAuthorization){
                   $key = $rolesAuthorization->system_feature_id;
                   $array = $request->action;
                   if(array_key_exists($key, $array)){
                       if ($request->action[$rolesAuthorization->system_feature_id]== 'on') {
                           $userAuthorization->system_feature_id = $rolesAuthorization->system_feature_id;
                           //$userAuthorization->system_feature_id = $rolesAuthorization->system_feature_id;
                           $userAuthorization->user_id = $request->employeeID;
                           $userAuthorization->save();
                       }
                   }
               }

                return redirect()->back();
    }

    public function store(Request $request, $systemFeatureID)
    {
        //** take all employee ('role_id', 5) working in the dealer whose owner is 'authed user'. */
        $employees = User
            ::where('dealer_id', Auth()->user()->dealer_id)
            ->where('role_id', 5)
            ->get();

        $usersAuthorizations = UsersAuthorization::all();
        foreach ($employees as $employee){
            //** If permission of the current system feature is removed from all the employees, the action array is not generated in authorizeUser.blade.php.
            // So, the situation must be checked first */
            if(is_array($request->action)){
            //** if a switch in authorizeUser.blade.php is off, no data is store in the action[] for the switch. So it must be checked if the key exist in the array.
            //$employee->id is assigned as a key in authorizeUser.blade.php. In this function $employee->id is used as a key in the following array_key_exists()  */
                if(array_key_exists($employee->id, $request->action[$systemFeatureID])){
                    if ($request->action[$systemFeatureID][$employee->id]== 'on')
                        //** if the current switch "$request->action[$systemFeatureID][$employee->id]" on then it must be controlled that if its status has ben changed from off to on,
                        // or it is already exist in the user_authorization table in the DB */
                        $exist = 0;
                        foreach ($usersAuthorizations as $userAuthorization){
                            //**if it the permission for the employee already exist in the table then break the loop and pass for the next employee.
                            if((($userAuthorization->system_feature_id == $systemFeatureID) && ($userAuthorization->user_id == $employee->id))){
                                $exist = 1;
                                break;
                            }
                        }
                        //** if the permission of the system feature for the current employee is not in the table then save it. */
                        if($exist == 0){
                            $newUsersAuthorization = new UsersAuthorization();
                            $newUsersAuthorization->system_feature_id = $systemFeatureID;
                            $newUsersAuthorization->user_id = $employee->id;
                            $newUsersAuthorization->save();
                        }
                }
                //**if the key is not exist in the array it means;
                // 1.the status of the switch changed from ON to OFF. So the following loop control this. If it is already exist in the table then delete it.
                // 2.the permission of the system feature had been assigned to the current employee.
                else{
                    foreach ($usersAuthorizations as $userAuthorization){
                        if((($userAuthorization->system_feature_id == $systemFeatureID) && ($userAuthorization->user_id == $employee->id))){
                            $userAuthorization->delete();
                            break;
                        }
                    }

                }
            }
            else{
                foreach ($usersAuthorizations as $userAuthorization) {
                    if ((($userAuthorization->system_feature_id == $systemFeatureID) && ($userAuthorization->user_id == $employee->id))) {
                        $userAuthorization->delete();
                        break;
                    }
                }
            }
        }

        $employeesAuthorizations = UsersAuthorization::all();

        //** take all employee working in the dealer whose owner is 'authed user'. */
        $employees = User::where('dealer_id', Auth()->user()->dealer_id)->where('role_id', 5)->get();

        //** take all system features (IDs) that super user in dealer is authorized but the employees are not authorized.
        // if 'where('permission_of_role4', 1)'  is not used, some system features that ONLY system admin and super user in Toker are authorized are listed*/
        $authorizationsForRole4NotRole5 = RolesAuthorization::where('permission_of_role4', 1)->where('permission_of_role5', 0)->get();


        return view('authorizations.authorizeUser', compact('authorizationsForRole4NotRole5', 'employees', 'employeesAuthorizations'));
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\UsersAuthorization  $usersAuthorization
     * @return \Illuminate\Http\Response
     */
    public function show(UsersAuthorization $usersAuthorization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UsersAuthorization  $usersAuthorization
     * @return \Illuminate\Http\Response
     */
    public function edit(UsersAuthorization $usersAuthorization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UsersAuthorization  $usersAuthorization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UsersAuthorization $usersAuthorization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UsersAuthorization  $usersAuthorization
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsersAuthorization $usersAuthorization)
    {
        //
    }
}
