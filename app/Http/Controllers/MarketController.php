<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
{
    public function uploadForm()

    {
        return view('market.upload_form');
    }

    public function uploadSubmit(Request $request)

    {
        $item = new Item();

        $this->validate($request, [

            'name' => 'required',
            'photos.*' => 'required|mimes:png,jpg,jpeg',
            'price' => 'required|numeric',

        ]);


        $item = Item::create($request->all());


        foreach ($request->photos as $photo) {


            $name = $photo->getClientOriginalName();
            $photo->move(public_path().'/market/', $name);

            ItemDetails::create([
                'item_id' => $item->id,
                'filename' => $name
            ]);

        }
        return redirect()->back()->with('status', 'Produit ajouté avec succès');
  }
  public function showMarket() {
        $items = Item::with('itemDetails', 'user')->get();
        return $items;
  }

}

