<?php

namespace App\Http\Controllers;

use App\Service;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('profile', 'update_profile');
    }

    public function profile()
    {
        $user = Auth::user();

        $services = Service::all();
        return view('profile', compact('services', 'user' ));
    }

    public function update_profile(Request $request)
    {

        $this->validate($request, [
            'avatar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ]);

        $filename = Auth::id() . '_' . time() . '.' . $request->avatar->getClientOriginalExtension();
        $request->avatar->move(public_path('uploads/avatars'), $filename);

       // $user = Auth::user();


        User::where('id',Auth::user()->id)->update([
            'post' => $request->post,
            'telephone' => $request->telephone,
            'date_naissance' => $request->date_naissance,
            'service_id' => $request->service,
            'adresse' => $request->adresse,
            'avatar'=> $filename
        ]);


        return redirect()->back()->with('status', 'Profil modifié avec succès!');

    }

    public function addManagers()
    {
        $users = User::paginate(10);
        return view('Settings.managers', compact('users'));
    }

    public function addManagersFunc($id)
    {
        $user = User::findOrFail($id);

            $user->is_manager = 1;
            $user->save();

        return redirect()->back()->with("status", "Manager ajouté avec succès" );
    }

    public function removeManager($id) {
        $user = User::findOrFail($id);
        $user->is_manager = 0;
        $user->save();

        return redirect()->back()->with("status", "Manager retiré avec succès" );
    }


   // FOR MOBILE APP
    //


    public function userLogin(Request $request){

        if ($user = \DB::table('users')->where('email', $request->email)->where('date_naissance', $request->password)->first()) {
            return response()->json([
                'status' => 'success',
                'email'=> $request->email,
                'password' => $request->password,
                'image' =>$user->avatar,
                'name'=>$user->name,
                'id' =>$user->id
            ]);
        }
        else {
            return response()->json([
                'status' => 'failed',

            ]);
        }

    }
    public function findUserByEmail($email){
        if ($user = \DB::table('users')->where('email', $email)->first()) {
            return response()->json([
                'status' => 'success',
                'email'=> $user->email,
                'image' =>$user->avatar,
                'name'=>$user->name,
                'telephone'=> $user->telephone,
                'post'=>$user->post,
                'adresse'=>$user->adresse

            ]);
        } else {
            return response()->json([
                'status' => 'failed',

            ]);
        }
    }
    public function editProfile($email, Request $request){

        //Check if the user I want to edit, identified by his email exists in DB
        if ($user = \DB::table('users')->where('email', $email)->first()) {
// check if the new email doesn't already exist in the database except in 1 record which is current logged in user
            if ( \DB::table('users')->where('email', $request->email)->where('email', '<>', $email)->count() == 0) {

                $this->validate(request(), [
                    'adresse' => 'required',
                    'email' => 'required|email',
                    'post' => 'required',
                    'telephone' => 'required'

                ]);



                \DB::table('users')
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












}