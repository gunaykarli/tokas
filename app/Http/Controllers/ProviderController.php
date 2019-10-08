<?php

namespace App\Http\Controllers;

use App\Provider;
use App\Address;
use Illuminate\Http\Request;

class ProviderController extends Controller
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
        //$providers = new Provider();
        //$providers -> all()->get();
        $providers = Provider::all();
        return view ('providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        Provider::create([
            'name' => request('name')
        ]);
        */

        //add the provider's name to the database
        $provider = new Provider();
        $provider->name = $request->name;
        $provider->save();

        //To add address of the provider which has been added to the database in previous step, take its ID and transfer it to addAddressProvider()
        $name = $request->name;
        //$provider = Provider::where('name', $name)->get();
        $provider->where('name', $name)->get();
        //$provider = Provider::find(1);
        $address = new Address();
        $address->addAddressOfProvider($provider->id, request());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provider $provider)
    {
        //$provider = new Provider();// No need, because of Route-Model binding...
        //The provider is updated...
        $provider->name = $request->name;
        $provider->save();

        //$name=$request->name;
        //$provider = Provider::where('name', $name)->get();
        //$provider->where('name', $name)->get();
        //$provider = Provider::find(1);

        //$providerID=$provider->id;
        $address = new Address();
        //ÇALIŞIYOR...$addressID=$provider->addresses->first()->id;
        //ÇALIŞMIYOR...$addressID = $provider->addresses->where('entityType', '=', 'Dealer')->id;
        //ÇALIŞMIYOR...$addressID = $provider->addresses->where('entityType', '=', 'Dealer')->get()->id;
        //ÇALIŞIYOR...$addressID = $provider->addresses()->where('entityType', '=', 'Dealer')->first()->id;
        //$addressID = $provider->addresses()->where('entityType', '=', 'Dealer')->first()->id;
        //$addressID = $address->id;

        //the address row which belongs to the provider in the database is determined.
        $address = $provider->addresses()->where('entity_type', '=', 'Provider')->first();
        //$address->updateAddressOfProvider($addressID, request());
        // to update the address of the provider, updateAddressOfProvider() is called with following parameters...
        $address->updateAddressOfProvider($address, request());
        return redirect('/provider/index')->with('success', 'Provider has been updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        //$provider = Provider::find($id); // it is not necessary because of Route Model binding...
        $provider->delete();

        // MESAJ ÇALIŞMIYOR...
        return redirect('/provider/index')->with('success', 'Provider has been deleted Successfully');
    }
}
