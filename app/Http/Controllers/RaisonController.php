<?php

namespace App\Http\Controllers;

use App\Demande;
use App\RaisonRejet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RaisonController extends Controller
{
    public function postRejet($demande_id, Request $request)
    {
        $demande = Demande::where('demande_id', $demande_id)->firstOrFail();


        if ($raison = RaisonRejet::create([
            'demande_id' => $demande->id,
            'message' => $request->input('message'),
        ])) {


            if (Auth::user()->is_admin == 1) {
                $demande->status = 'Rejetée';
                $demande->save();
            } elseif (Auth::user()->is_manager == 1) {

                \DB::table('demande_manager')->where('demande_id', $demande->id)->where('user_id', Auth::user()->id)->update(['status' => 'Rejetée par '.Auth::user()->name]);

            }
            $demandes_manager = \DB::table('demande_manager')->where('demande_id', $demande->id)->get();


            $contains = true;
            foreach($demandes_manager as $demande_manager) {

                if (!str_contains($demande_manager->status, 'Rejetée')) {
                    $contains = false;
                }
            }
            if($contains == true){
                $demande->status = "Rejetée par les managers";
                $demande->save();
            }elseif(!str_contains($demande_manager->status, 'Rejetée') && $demande_manager->status != null) {
                $demande->status = "Rejetée par un des managers";
                $demande->save();
            }

            return redirect()->back()->with("status", "La demande a été rejetée");

        }
    }
}