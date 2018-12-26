<?php

namespace App\Http\Controllers\Auth;

use App\Dealer;
use App\Office;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function createEmployee($dealerID){
        // Employee to be created needs to belong an office of the dealer
        // so office list of the related dealer must be sent to  'dealers.employees.create'
        $offices = \App\Office::where('dealer_id', $dealerID)->orderBy('id')->get();

        return view('dealers.employees.create', compact('offices'));
    }
    protected function storeEmployee(Request $request)
    {
        $user = new User();
        $user->status = 'on';
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->role_id = 5; //description: role_id 5, Tokas user in dealers
        $user->office_id = $request->officeID;
        // determine dealer_id the user to be stored.
        $office = Office::where('id', $request->officeID)->first();
        $user->dealer_id = $office->dealer_id;

        $user->password = Hash::make("123.qaz");
        $user->save();

        return back();
    }
    public function listEmployee($dealerID){
        // retrieve all employees belonging to the dealer whose ID is equal to the dealerID sent from dealers.index and offices.index
        $employees = User::where('dealer_id', $dealerID)->get();

        return view('dealers.employees.list', compact('employees', 'dealerID'));

    }

    public function editEmployee(User $employee){

        // Employee to be created needs to belong an office of the dealer
        // so office list of the related dealer must be sent to  'dealers.employees.edit'
        //if (auth()->check()) $dealerID = auth()->user()->dealer_id;
        $offices = \App\Office::where('dealer_id', $employee->dealer_id)->orderBy('id')->get();

        return view('dealers.employees.edit', compact('employee', 'offices'));
    }
    protected function updateEmployee(Request $request, User $employee)
    {

        // Contact Person can not be inactivated. FIND A SOLUTION
        /*if ($request->officeType == 1){
            \UxWeb\SweetAlert\SweetAlert::success('Main Office can not be inactivated!');
        }
        else{
            */
            if ($request->status == 'on')
                $employee->status = $request->status;
            else
                $employee->status = 'off';

        $employee->name = $request->name;
        $employee->surname = $request->surname;
        $employee->email = $request->email;
        $employee->mobile = $request->mobile;
        //$employee->role_id = 5; //description: role_id 5, Tokas user in dealers
        $employee->office_id = $request->officeID;
        //$user->password = Hash::make("123.qaz");
        $employee->save();

        return back();
    }
}
