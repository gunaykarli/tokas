<?php

namespace App\Http\Controllers\Auth;

use App\Dealer;
use App\Mail\SendMailable;
use App\Office;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    use RegistersUsers; //vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php

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
        // V1. set up the user_name of the newly created employee: $userNameOfAdminOfDealer . "-" . $request->name . $request->surname (00074-İsimSoyisim
        $userNameOfAdminOfDealer = User
            ::where('dealer_id', Office::where('id', $data['officeID'])->first()->dealer_id)
            ->where('role_id', 4)
            ->first()
            ->user_name;
        //$userNameOfEmployee = $userNameOfAdminOfDealer . "-" . $request->name . $request->surname;

        // V1. set up the user_name of the newly created employee: $userNameOfAdminOfDealer . "-"
        $theNumberOfEmployeeofDealer = User::where('dealer_id', Office::where('id', $data['officeID'])->first()->dealer_id)->count();
        $userNameOfEmployee = $userNameOfAdminOfDealer . "-" . ($theNumberOfEmployeeofDealer+1);

        // send mail to the new user
        Mail::to($data['email'])->send(new SendMailable($data['name'], $userNameOfEmployee,$data['password']));

        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),

            'mobile' => '+49 177',
            'user_name' => $userNameOfEmployee,
            'status' => 'on',
            'role_id' => 5,
            'office_id' => $data['officeID'],
            'dealer_id' => Office::where('id', $data['officeID'])->first()->dealer_id,
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

        // V1. set up the user_name of the newly created employee: $userNameOfAdminOfDealer . "-" . $request->name . $request->surname (00074-İsimSoyisim
        $userNameOfAdminOfDealer = User
            ::where('dealer_id', $office->dealer_id)
            ->where('role_id', 4)
            ->first()
            ->user_name;
        //$userNameOfEmployee = $userNameOfAdminOfDealer . "-" . $request->name . $request->surname;

        // V1. set up the user_name of the newly created employee: $userNameOfAdminOfDealer . "-"
        $theNumberOfEmployeeofDealer = User::where('dealer_id', $office->dealer_id)->count();
        $userNameOfEmployee = $userNameOfAdminOfDealer . "-" . ($theNumberOfEmployeeofDealer+1);
        $user->user_name = $userNameOfEmployee;
        $user->password = Hash::make("123.qaz");
        $user->save();

        Mail::to($request->email)->send(new SendMailable($request->name, $userNameOfEmployee,"123.qaz"));

        return redirect('/employee/office/list/'.$office->id)->with('newEmployee', 'created');
    }
    public function listEmployeesOfDealer(Dealer $dealer){
        // retrieve all employees belonging to the dealer whose ID is equal to the dealerID sent from dealers.index and offices.index
        $employees = User::where('dealer_id', $dealer->id)->get();

        return view('dealers.employees.list', compact('employees', 'dealer'));
    }
    public function listEmployeesOfOffice(Office $office){
        // retrieve all employees belonging to the office whose ID is equal to the office sent from offices.index
        $employees = User::where('dealer_id', $office->dealer_id)->where('office_id', $office->id)->get();

        $dealer = Dealer::find($office->dealer_id);
        return view('dealers.employees.list', compact('employees', 'dealer', 'office'));
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
        $employee->update();

        return redirect('/employee/office/list/'.$employee->office_id)->with('updateEmployee', 'updated');
    }
}
