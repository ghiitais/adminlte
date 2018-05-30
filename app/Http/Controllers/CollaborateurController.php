<?php

namespace App\Http\Controllers;

use App\Collaborateur;
use App\Service;
use Illuminate\Http\Request;

class CollaborateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        //$this->middleware('auth');
    }

   public function userLogin(Request $request){

        if ($collab = \DB::table('collaborateurs')->where('email', $request->email)->where('date_naissance', $request->password)->first()) {
            return response()->json([
                'status' => 'success',
                'email'=> $request->email,
                'password' => $request->password,
                'image' =>$collab->image,
                'nom'=>$collab->nom,
                'prenom'=>$collab->prenom

            ]);
        }
        else {
            return response()->json([
                'status' => 'failed',

            ]);
        }

    }
    public function findUserByEmail($email){
        if ($collab = \DB::table('collaborateurs')->where('email', $email)->first()) {
             return response()->json([
                'status' => 'success',
                'email'=> $collab->email,
                'image' =>$collab->image,
                'nom'=>$collab->nom,
                'prenom'=>$collab->prenom,
                 'telephone'=> $collab->telephone,
                 'post'=>$collab->post,
                 'adresse'=>$collab->adresse

            ]);
        } else {
            return response()->json([
                'status' => 'failed',

            ]);
        }
        }
        public function editProfile($email, Request $request){

        //Check if the user I want to edit, identified by his email exists in DB
        if ($collab = \DB::table('collaborateurs')->where('email', $email)->first()) {
// check if the new email doesn't already exist in the database except in 1 record which is current logged in user
            if ( \DB::table('collaborateurs')->where('email', $request->email)->where('email', '<>', $email)->count() == 0) {

                $this->validate(request(), [
                    'adresse' => 'required',
                    'email' => 'required|email',
                    'post' => 'required',
                    'telephone' => 'required'

                ]);



                \DB::table('collaborateurs')
                    ->where('email', $email)
                    ->update(['email' => $request->email, 'post'=>$request->post, 'telephone'=>$request->telephone, 'adresse'=>$request->adresse]);
                //$collab->save();
                return response()->json([
                    'status'=>'success',
                    'email'=>$request->email,
                    'adresse'=> $request->adresse,
                    'post'=>$request->post,
                    'telephone'=>$request->telephone
                ]);
            } else {
                return response()->json([
                    'status' => 'failed, new email exists',

                ]);
            }

        } else {
            return response()->json([
                'status' => 'failed',

            ]);
        }

         }




    public function home() {

        $servicesResult = Service::all();
        $managers = Collaborateur::where('is_manager', 1)->get();

        return view('collaborateurs', compact('servicesResult', 'managers'));
    }


    public function index()
    {
        return Collaborateur::with(['service', 'manager'])->orderBy('created_at', 'DESC')->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    /*    $collaborateur  = new Collaborateur();
        $collaborateur->nom = $request ->nom;
        $collaborateur->prenom = $request->prenom;
        $collaborateur->date_naissance = $request->date_naissance;
        $collaborateur->post = $request->post;
        $collaborateur->email = $request->email;
        $collaborateur->telephone = $request->telephone;
        $collaborateur->adresse = $request->adresse;
        $collaborateur->service_id = $request->service_id;
        $collaborateur->is_manager = $request->is_manager;
        $collaborateur->manager_id = $request->manager_id;

        $collaborateur->save();
    return $collaborateur;

    */
       \Log::info($request->all());
        $exploded=explode(',',$request->image);
        $decoded=base64_decode($exploded[1]);
        if(str_contains($exploded[0],'jpeg')){
            $exte='png';
        }else{
            $exte='jpg';
        }
        $filename=str_random().'.'.$exte;
        $path=public_path().'/'.$filename;
        file_put_contents($path,$decoded);


        $collaborateur = Collaborateur::create($request->except('image')+[
                'image'=>$filename
            ]);

        return $collaborateur;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Collaborateur  $collaborateur
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Collaborateur::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Collaborateur  $collaborateur
     * @return \Illuminate\Http\Response
     */
    public function edit(Collaborateur $collaborateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Collaborateur  $collaborateur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $collaborateur = Collaborateur::findOrFail($id);
        if($request->image) {
            \Log::info($request->all());
            $exploded=explode(',',$request->image);
            if (count($exploded) != 2) {

            } else {
                $decoded=base64_decode($exploded[1]);
                if(str_contains($exploded[0],'jpeg')){
                    $exte='png';
                }else{
                    $exte='jpg';
                }
                $filename=str_random().'.'.$exte;
                $path=public_path().'/'.$filename;
                file_put_contents($path,$decoded);
                $collaborateur->update([
                    'image'=>$filename
                ]);
            }


            if($collaborateur->count()){
                $collaborateur->update($request->except('image'));
                return $collaborateur;
            }


        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Collaborateur  $collaborateur
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collaborateur = Collaborateur::findOrFail($id);
        $collaborateur->delete();

        return '';
    }
}
