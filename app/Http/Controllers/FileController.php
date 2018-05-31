<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function create() {
        return view('Files.create');
    }
    public function showFiles() {
        $files = File::paginate(5);
        return view('Files.files', compact('files'));
    }

    public function showFilesJson() {
        $files = File::with('user')->get();
        return $files;
    }

    public function store(Request $request) {
        $this->validate($request, [

            'filename' => 'required',
            'filename.*' => 'mimes:doc,pdf,docx,zip,xlsx,png,jpg,jpeg,ppt'

        ]);


        if($request->hasfile('filename'))
        {

            foreach($request->file('filename') as $file)
            {
                $name=$file->getClientOriginalName();

                $file->move(public_path().'/files/', $name);
                // $data[] = $name;
            }
        }

        $file= new File();
        $file->user_id = Auth::user()->id;
        $file->filename=$name;

       if( $file->save()) {
           return back()->with('success', 'Your files has been successfully added');
       }


    }
    public function deleteFile($id) {
        $file = File::findOrFail($id);
        $file->delete();

        return redirect()->back()->with("status", "File deleted");
    }
}
