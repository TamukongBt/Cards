<?php

namespace App\Http\Controllers;

Use Illuminate\Pagination\LengthAwarePaginator;
use App\Cards;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards=Cards::all();
        return view('pages.cards')->with('cards',$cards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Cards  $Cards
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req= new Cards();
        $data = $this->validate ($request, [


            'name' => 'required|string|max:50',


        ]);
        $req = Cards::create($data);
         return redirect()->route('cards.index')->with('success','New Entry created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cards= Cards::findbyId($id);
        return view('pages.reqview')->with('cards', $cards);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cards= Cards::find($id);
        return view('cards.edit', compact('cards','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Cards  $Cards
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $this->validate ($request, [


            'cards' => 'required|string|max:50',

        ]);
        Cards::whereId($id)->update($data);
        return redirect('pages.reqview')->with('success', 'Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cards = Cards::findorFail($id);
        Cards::whereId($cards['id'])->delete();
        return redirect('pages.cards')->with('success', 'Cards has been deleted!!');
    }
}
