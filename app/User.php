<?php

namespace App;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'mobile', 'user_name', 'password', 'role_id', 'dealer_id', 'office_id', 'status', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function dealer(){
        return $this->belongsTo(Dealer::class);
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }

    /**
     * adds address of the Dealer with $dealerID sent from DealerController@store
     * forwarded from store@DealerController
     */
    public function addAdminOfDealer ($dealerID, $request){

        //$this->register($request);
        //event(new Registered($user = $this->createAdminOfDealer($dealerID, $request->all())));

        $user = new User();
        // owner of the dealer is admin of the dealer too.
        $user->user_name = $request->userName;
        $user->name = $request->ownerName;
        $user->surname = $request->ownerSurname;
        $user->email = $request->ownerEmail;
        $user->mobile = $request->ownerMobile;
        $user->password = Hash::make($request->password);
        $user->role_id = 4;
        $user->dealer_id = $dealerID;
        $user->status = 'on';

        // find the office in which the admin is stored
        $office = Office::where('dealer_id', $dealerID)->first();
        $user->office_id = $office->id;

        event(new Registered($user));
        $user->save();

        // Since admin user will be contact person of the office, $office->contact_person_id must be stored in this function
        //$admin = User::where('email', $request->accountEmail)->where('surname', $request->accountSurname )->first();
        $office->contact_person_id = $user->id;
        $office->save();

    }

    public function updateAdminOfDealer ($user, $request){

        //$this->register($request);
        //event(new Registered($user = $this->createAdminOfDealer($dealerID, $request->all())));
        $user->user_name = $request->userName;
        if ($request->status == 'on')
            $user->status = $request->status;
        else
            $user->status = 'off';
        $user->name = $request->ownerName;
        $user->surname = $request->ownerSurname;
        $user->email = $request->ownerEmail;
        $user->mobile = $request->ownerMobile;

        if ($request->passwordChange == 'on')
            $user->password = Hash::make($request->password);

        //$user->password = Hash::make($request->password);
        //$user->role_id = 4;
        //$user->dealer_id = $dealerID;
        //$user->office_id = 1;

        $user->save();

        event(new Registered($user));

    }
}
