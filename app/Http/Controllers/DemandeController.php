<?php

namespace App\Http\Controllers;

use App\Collaborateur;
use App\Demande;
use App\User;
use App\Mailers\AppMailer;
use App\Manager;
use App\RaisonRejet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DemandeController extends Controller
{
   /* public function __construct()
    {
       $this->middleware('auth');
    }*/

    public function create(){
       return view('demandes.create');
   }

    public function store(Request $request, AppMailer $mailer)
    {


        $to = Carbon::createFromFormat('Y-m-d', $request->input('lastDay'));
        $from = Carbon::createFromFormat('Y-m-d',$request->input('firstDay'));
        $diff_in_days = $to->diffInDays($from);

        $this->validate($request, [
            'type'     => 'required',
            'priority'  => 'required',
            'congeType'=>'required',
            'firstDay'=>'required',
            'lastDay'=>'required',
            'totalDays'=>'required',
            'arriveOn'=>'required',



        ]);

        Demande::create([
            'user_id' => Auth::user()->id,
            'demande_id' => strtoupper(str_random(10)),
            'priority' => $request->input('priority'),
            'type' => $request->input('type'),
            'firstDay'=> $request->input('firstDay'),
            'lastDay'=>$request->input('lastDay'),
            'arriveOn'=>$request->input('arriveOn'),
            'totalDays'=>$request->input('totalDays'),
            'congeType'=>$request->input('congeType'),
            "status" => "En attente"

        ]);

        //$mailer->sendDemandeInformation(Auth::user(), $demande);


        return redirect()->back()->with("status", "La demande identifiée par: #$request->demande_id a été envoyée à l'administration.");
    }

    // mobile add demande
public function addDemande(Request $request) {
    $demande = new Demande([
        'user_id' => $request->user_id,
        'demande_id' => $request->demande_id,
        'priority' => $request->priority,
        'type' => $request->type,
        'firstDay'=> $request->firstDay,
        'lastDay'=>$request->lastDay,
        'arriveOn'=>$request->arriveOn,
        'totalDays'=>$request->totalDays,
        'congeType'=>$request->congeType,
        "status" => "En attente"

    ]);

if ($demande->save()){
    return response()->json([
        'status'=>'success',


    ]);
} else {
    return response()->json([
        'status'=>'failure',


    ]);
}
}

public function demandeDetails($demande_id) {
        $demande = Demande::where('demande_id', $demande_id)->firstOrFail();
        return view('demandes.showDetails', compact('demande'));
}
    // Collaborateur :

    public function afficherDemandes()
    {
        $demandes = Demande::where('user_id', Auth::user()->id)->paginate(5);

        return view('demandes.user_demandes', compact('demandes'));
    }

    public function deleteDemande($id) {
        $demande = Demande::find($id);
        $demande->delete();
        return redirect('mes_demandes');
    }




    // Managers :

    public function afficherDemandesManager() {

        //$demandes = Demande::where('manager_id', Auth::user()->id)->paginate(10);
        //$managers = Manager::where('user_id', Auth::user()->id)->get();
        $user = Auth::user();
       // dd($user->demandesAssignees->map->toArray());

        $demandes = $user->demandesAssignees;
        return view('demandes.manager_demandes', compact('demandes'));
    }


    // Admin:


    public function afficherDemandesAdmin() {
        $demandes = Demande::where('status', '<>', ['En attente', 'Envoyée aux managers'])->paginate(5);
        return view('demandes.admin_demandes', compact('demandes'));
    }

    public function accepterDemande($demande_id){

        $demande = Demande::where('demande_id', $demande_id)->firstOrFail();
        //dd($demande->id);

        if(Auth::user()->is_admin == 1) {

        $demande->status = "Acceptée";
        $demande->save();

        }
        elseif(Auth::user()->is_manager == 1) {

    DB::table('demande_manager')->where('demande_id', $demande->id)->where('user_id', Auth::user()->id)->update(['status' => "Acceptée par ".Auth::user()->name]);
    }

    $demandes_manager = DB::table('demande_manager')->where('demande_id', $demande->id)->get();
        $contains = true;
        foreach($demandes_manager as $demande_manager) {

            if (!str_contains($demande_manager->status, 'Acceptée')) {
                $contains = false;
            }
        }
            if($contains == true){
                $demande->status = "Acceptée par les managers";
                $demande->save();
            } elseif(!str_contains($demande_manager->status, 'Acceptée') && $demande_manager->status != null) {
        $demande->status = "Rejetée par un des managers";
        $demande->save();

                 }

        $demande->save();

        return redirect()->back()->with("status", "La demande a été acceptée avec succès");

    }
    // Admin qui rejete définiivement

    public function Rejeter($demande_id){
        $demande = Demande::where('demande_id', $demande_id)->firstOrFail();

        $demande->status = 'Rejetée ';
        $demande->save();

        return redirect()->back()->with("status", "La demande est rejetée");

    }

    public function enCours($demande_id){
        $demande = Demande::where('demande_id', $demande_id)->firstOrFail();

        $demande->status = "En cours";
        $demande->save();

        return redirect()->back()->with("status", "Le statut a été modifiée, la demande est en cours de traitement");

    }

    public function show($demande_id)
    {
        $demande = Demande::where('demande_id', $demande_id)->firstOrFail();
        $raisons = \DB::table('raison_rejets')->where('demande_id', $demande->id)->get();
        // $comments = $demande->comments;

        return view('demandes.reject', compact('demande', 'raisons'));
    }


    // Assistante:

    public function afficherDemandesAssistanteActive() {
    $demandes = Demande::where('status', 'En attente')->paginate(5);
    $managers = \App\User::where('is_manager', 1)->get();

    return view('demandes.assistante_demande_active', compact('demandes', 'managers'));
}
    public function afficherDemandesAssistanteInactive() {
        $demandes = Demande::where('status', '<>', 'En attente')->orderBy('created_at', 'DESC')->paginate(5);
      //  $managers = \App\User::where('is_manager', 1)->get();
        $managers = \App\User::where('is_manager', 1)->get();

        return view('demandes.assistante_demande_inactive', compact('demandes', 'managers'));
    }

    public function forwardToManager(Request $request, $demande_id) {
        $demande = Demande::where('demande_id', $demande_id)->firstOrFail();
        $id = $demande->id;



        $managersSelected = $request->managers;

        foreach ($managersSelected as $manager => $value){
            //$user = \App\User::where('id', $value)->first(); // $value is the id of the manager selected
            $manager = new Manager();

            $manager->user_id = $value;
            $manager->demande_id = $id;
            //$manager->manager_id = $user->manager_id;

            $manager->save();
        }

       // $demande->manager_id = $request->input('manager');
        $demande->status = "Envoyée aux managers";
        $demande->save();

        return redirect()->back()->with("status", "La demande a été envoyée aux managers avec succès");
    }



    // Mobile

    public function  afficherDemandesJson($id) {
        $demandes = Demande::where('user_id', $id)->orderBy('created_at', 'DESC')->get();
        return $demandes;
    }
}
