<?php

namespace App\Http\Controllers;

use App\Imports\ImportArticles;
use App\Models\Article;
use App\Models\Magazine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class ArticleController extends Controller
{
    public function create(){
        $magazines = Magazine::select('issue_no','id')->get();
        return view('admin.article-upload',compact('magazines'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'issue_no' => 'required|unique:magazines,title',
            'file' => 'required',
        ]);

        ini_set('memory_limit', '256M');

        Excel::import(new ImportArticles($request->issue_no), $request->file('file'));

        return redirect('admin/file-manager')->with('message', 'Uploaded articles successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::whereSlug($slug)->first();

        return view('read', compact('article'));
    }

    public function urls(){
        $urls = \AshAllenDesign\ShortURL\Models\ShortURL::paginate(10);
        return view('admin.urls',compact('urls'));
    }
}
