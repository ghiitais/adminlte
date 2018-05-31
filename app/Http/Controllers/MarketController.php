<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class MarketController extends Controller
{
    public function uploadForm()
    {
        return view('market.upload_form');
    }

    public function index()
    {
        return view('market.view');
    }

    public function show($id)
    {
        $item = Item::where('id',$id)->first();
        return view('market.showitem',compact('item'));
    }

    public function edit($id)
    {
        $item = Item::where('id',$id)->first();
        return view('market.edit',compact('item'));
    }



    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'name' => 'required',
            'photos.*' => 'required|mimes:png,jpg,jpeg',
            'price' => 'required|numeric',

        ]);
        $item = Item::where('id',$id)->first();
        $item->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'details'=> $request->details
        ]);

        if($request->hasFile('photos')){
        foreach ($request->photos as $photo) {


            $name = $photo->getClientOriginalName();
            $photo->move(public_path().'/market/', $name);

            ItemDetails::create([
                'item_id' => $item->id,
                'filename' => $name
            ]);

        }
    }
        return redirect()->back()->with('status', 'Produit ajouté avec succès');
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

  public function getdatatable(){
    
    $items = Item::all();
    
    return Datatables::of($items)
            ->addColumn('seller', function ($ne) {
                return $ne->user->name;
            })
            ->addColumn('image', function ($ne) {
                $carosalId = $ne->id."-generic";
                $sec1 = "<div id='{$carosalId}' class='carousel slide' data-ride='carousel'>
                <ol class='carousel-indicators'>";
                    $count = 0;
                    $sec2 = "";
                    foreach($ne->itemDetails as $item)
                    {
                        if($count==0)
                        {
                            $sec2 = "<li data-target='#{$carosalId}' data-slide-to='0' class='active'></li>";
                            $count++;
                        }else
                        {
                            $sec2 = $sec2."<li data-target='#{$carosalId}' data-slide-to='0'></li>";
                            $count++;
                        }
                    }
                    
                
                $sec3 = "</ol><div class='carousel-inner'>";
                    $count = 0;
                    $sec4="";
                    foreach($ne->itemDetails as $item)
                    {
                       if($count==0){ 
                       $sec4 = "<div class='item active'>
                            <img src='".url("/market/{$item->filename}")."' style='height:289px;width:509px'>
                        </div>";
                        $count++;
                       }else
                       {
                        $sec4 = $sec4."<div class='item'>
                            <img src='".url("/market/{$item->filename}")."' style='height:289px;width:509px'>
                        </div>";
                       }
                    }

                $sec5 = "</div>
                <a class='left carousel-control' href='#{$carosalId}' data-slide='prev'>
                    <span class='fa fa-angle-left'></span>
                </a>
                <a class='right carousel-control' href='#{$carosalId}' data-slide='next'>
                    <span class='fa fa-angle-right'></span>
                </a>
            </div>";

                
            return $sec1." ".$sec2." ".$sec3." ".$sec4." ".$sec5;  


            })
            ->addColumn('action', function ($ne) {
                if($ne->user_id==Auth::user()->id){
                    return '<a id="view" href="'.url("/itemsview/{$ne->id}/view").'" data-token="' . csrf_token() . '" val="' . $ne->id . '" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a id="edit" href="'.url("/itemsview/{$ne->id}/edit").'" data-token="' . csrf_token() . '" val="' . $ne->id . '" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i></a>
                        <a id="delete" href="javascript:void(0);" data-token="' . csrf_token() . '" val="' . $ne->id . '" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
                }else
                {
                    return '<a id="view" href="'.url("/itemsview/{$ne->id}/view").'" data-token="' . csrf_token() . '" val="' . $ne->id . '" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i></a>';
                }
            })
            ->make(true);

    }

    public function delete($id)
    {
        
        ItemDetails::where('item_id',$id)->delete();
        Item::destroy($id);
        return 'true';
    }

}

