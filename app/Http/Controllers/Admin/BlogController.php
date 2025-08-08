<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(){
        $blogs = Blog::orderBy('id','desc')->paginate(100);
        return view('admin.blogs',[
            'page_title'=>'Blogs',
            'blogs' => $blogs,
        ]);
    }


    public function add(){
        return view('admin.blogs-add',[
            'page_title'=>'Blogs',
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'title'=>'required',
            'short_description'=>'required',
            'description'=>'required',
        ]);

        $image_url = "";

        if($req->hasFile('cover_image')){
            $image = $req->file('cover_image');
            $image_url = $image->store('blogs', 'public');
        }

        $blog = new Blog();
        $blog->title = $req->title;
        $blog->body = $req->description;
        $blog->short_description = $req->short_description;
        $blog->image_url = $image_url;
        $blog->save();

        return back()->with('msg','New blog was successfully posted');
       
    }

    public function show($id){
        $blog = Blog::find($id);
        $blogs = Blog::orderBy('id','desc')->paginate(100);
        return view('admin.blogs-show',[
            'page_title' => "Detail",
            'blog'=>$blog,
            'blogs'=>$blogs,
        ]);
    }

    public function edit($id){
        $blog = Blog::find($id);
        return view('admin.blogs-edit',[
            'page_title' => "Edit",
            'blog'=>$blog,
        ]);
    }

    public function modify(Request $req, $id){

        $blog = Blog::find($id);

        $req->validate([
            'title'=>'required',
            'short_description'=>'required',
            'description'=>'required',
        ]);

        $old_image_url = $blog->image_url;
        if($req->hasFile('cover_image')){
            $image = $req->file('cover_image');
            $image_url = $image->store('blogs', 'public');
            $blog->image_url = $image_url;
            Storage::disk('public')->delete($old_image_url);
        }

        $blog->title = $req->title;
        $blog->body = $req->description;
        $blog->short_description = $req->short_description;
       
        $blog->save();

        return back()->with('msg','The blog was successfully updated');
    }

    public function destroy($id){
        $blog = Blog::find($id);
        
        $htmlString = $blog->body;
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $htmlString, $matches);

        foreach ($matches[1] as $src) {
            $old_path = strchr($src,"blogs/");
            if ($old_path) {
                Storage::disk('public')->delete($old_path); // Delete old image
            }
        }

        Storage::disk('public')->delete($blog->image_url);
        $blog->delete();

        return back()->with('msg','The blog was successfully deleted');
    }
}
