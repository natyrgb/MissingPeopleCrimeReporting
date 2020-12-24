<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    /**
     * @return view of blogs index with news object
     */
    public function index() {
        return view('superadmin.blogs.index', ['blogs' => Blog::all()]);
    }

    /**
     * @return view to create new blog
     */
    public function create() {
        return view('superadmin.blogs.create');
    }

    /**
     * @param Illuminate\Http\Request object
     * validates and create blogs entry
     * @return redirect to view of blogs index with success message
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'article' => 'required|string',
            'url' => 'required|file|image|max:4000'
        ]);
        $date = Carbon::createFromFormat('Y-m-d H:i:s', now())->format('d-m-Y');
        $file = $request->file('url');               // you can also use the original name
        $imageName = time().'-'.$file->getClientOriginalName();
        $file->move(public_path("images/blogs/$date/"), $imageName);
        Blog::create([
            'article' => $request['article'],
            'title' => $request['title'],
            'url' => "images/blogs/$date/".$imageName
        ]);
        event(new \App\Events\BlogAdded());
        return redirect()->route('superadmin.blogs.index')->with(['success' => true]);
    }

    public function show(Blog $blog) {}

    /**
     * @param App\Models\Blog object
     * @return view to edit blog with the blog object
     */
    public function edit(Blog $blog) {
        return view('superadmin.blogs.edit', ['blog' => $blog]);
    }

    /**
     * @param Illuminate\Http\Request,App\Models\Blog objects
     * validates and update the blog object
     * @return redirect to view of blogs index with success message
     */
    public function update(Request $request, Blog $blog) {
        $request->validate([
            'title' => 'required|string',
            'article' => 'required|string',
            'url' => 'nullable|file|image|max:2000'
        ]);
        if($request->hasFile('url')) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', now())->format('d-m-Y');
            $file = $request->file('url');               // you can also use the original name
            $imageName = time().'-'.$file->getClientOriginalName();
            $file->move(public_path("images/blogs/$date/"), $imageName);
            $blog->url = "images/blogs/$date/".$imageName;
        }
        $blog->title = $request['title'];
        $blog->article = $request['article'];
        $blog->save();
        return redirect()->route('superadmin.blogs.index')->with(['success' => true]);
    }

    /**
     * @param App\Models\Blog objects
     * deletes the blog object
     * @return redirect to view of blogs index with success message
     */
    public function destroy(Blog $blog) {
        $blog->delete();
        return redirect()->route('superadmin.blogs.index')->with(['success' => true]);
    }
}
