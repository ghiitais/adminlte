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
        $this->middleware('auth');
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
/*


        $collaborateur  = new Collaborateur();


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
    return response()->json(['status' => 'success','msg'=>'Collaborateur created successfully', 'collaborateur'=>$collaborateur]);
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
        if($request->image) {
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

            $collaborateur = Collaborateur::findOrFail($id);

            if($collaborateur->count()){
                $collaborateur->update($request->except('image')+[
                        'image'=>$filename
                    ]);
                return response()->json(['status'=>'success','msg'=>'Post updated successfully']);
            } else {
                return response()->json(['status'=>'error','msg'=>'error in updating post']);
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
