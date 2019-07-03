<?php

namespace App\Http\Controllers;

use App\LawText;
use Illuminate\Http\Request;

class LawTextController extends Controller
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
        // Fetch all law texts
        $lawTexts = LawText::all();

        return view('lawTexts.index', compact('lawTexts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lawTexts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // form a law text instance
        $lawText = new LawText();

        $lawText->code = $request->lawTextCode;
        $lawText->content = $request->lawTextContent;

        $lawText->save();

        return redirect()->back()->with('message', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LawText  $lawText
     * @return \Illuminate\Http\Response
     */
    public function show(LawText $lawText)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LawText  $lawText
     * @return \Illuminate\Http\Response
     */
    public function edit(LawText $lawText)
    {
        return view('lawTexts.edit', compact('lawText'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LawText  $lawText
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LawText $lawText)
    {
        $lawText->code = $request->lawTextCode;
        $lawText->content = $request->lawTextContent;

        $lawText->save();
        return redirect('/law-text/index')->with('updateMessage', 'updateSuccess');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LawText  $lawText
     * @return \Illuminate\Http\Response
     */
    public function destroy(LawText $lawText)
    {
        //
    }
}
