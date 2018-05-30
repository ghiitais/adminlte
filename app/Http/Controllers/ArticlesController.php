<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\ArticleCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Http\Resources\Article as ArticleResource;

class ArticlesController extends Controller
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

    public function home(){
        // $articles = Article::with('author')->orderBy('created_at', 'desc')->get();
        return view('index');
    }

    public function index()
    {
        $articles = Article::with('author')->orderBy('created_at', 'desc')->get();
        return response()->json([
            'posts'=>$articles
        ]);


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



        $article = Article::create($request->except('image')+['image'=>$filename, 'author_id' => Auth::user()->id]);

        return response()->json(['status' => 'success','msg'=>'post created successfully']);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Article::with('author')->findOrFail($id);
        //return new ArticleResource(Article::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article  = Article::findOrFail($id);
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
                $article->update([
                    'image'=>$filename
                ]);
            }


            if($article->count()){
                $article->update($request->except('image'));
                return $article;
            }


        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $article = Article::findOrFail($id);
       $article->delete();

       return '';
    }
}
