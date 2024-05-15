<?php

namespace App\Http\Controllers;

use App\DataTables\BlogDataTable;
use App\Facades\UtilityFacades;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-blog')) {
            return $dataTable->render('blog.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->can('create-blog')) {
            $categories = BlogCategory::where('status', 1)->pluck('name', 'id');
            return view('blog.create', compact('categories'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('create-blog')) {
            request()->validate([
                'title'             => 'required|max:191|unique:blogs',
                'images'            => 'required|image|mimes:jpg,jpeg,png',
                'description'       => 'required',
                'short_description' => 'required',
                'category_id'       => 'required',
            ]);
            if ($request->hasFile('images')) {
                request()->validate([
                    'images' => 'mimes:jpg,jpeg,png',
                ]);
                $path = $request->file('images')->store('blogs');
            }
              Blog::create([
                'title'             => $request->title,
                'description'       => $request->description,
                'category_id'       => $request->category_id,
                'images'            => $path,
                'short_description' => $request->short_description,
                'created_by'        => \Auth::user()->id,
            ]);
            return redirect()->route('blogs.index')->with('success', __('Blog created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        if (\Auth::user()->can('edit-blog')) {
            $categories = BlogCategory::where('status', 1)->pluck('name', 'id');
            return view('blog.edit', compact('blog', 'categories'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-blog')) {
            request()->validate([
                'title'             => 'required|max:191',
                'description'       => 'required',
                'short_description' => 'required',
                'category_id'       => 'required',
            ]);
            $blog = Blog::find($id);
            if ($request->hasFile('images')) {
                request()->validate([
                    'images' => 'required|image|mimes:jpg,png,jpeg',
                ]);
                $path           = $request->file('images')->store('blogs');
                $blog->images   = $path;
            }
            $blog->title                = $request->title;
            $blog->description          = $request->description;
            $blog->category_id          = $request->category_id;
            $blog->short_description    = $request->short_description;
            $blog->created_by           = \Auth::user()->id;
            $blog->save();
            return redirect()->route('blogs.index')->with('success', __('blogs updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('delete-blog')) {
            $post = Blog::find($id);
            $post->delete();
            return redirect()->route('blogs.index')->with('success', __('Posts deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function viewBlog($slug)
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        $blog       =  Blog::where('slug', $slug)->first();
        if (!$blog) {
            abort(404);
        }
        $allBlogs  =  Blog::all();
        return view('blog.view-blog', compact('blog', 'allBlogs', 'slug', 'lang'));
    }

    public function seeAllBlogs(Request $request)
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        if ($request->category_id != '') {
            $allBlogs = Blog::where('category_id', $request->category_id)->paginate(3);
            $blogHtml = '';
            foreach ($allBlogs as $blog) {
                $imageUrl = $blog->images ? Storage::url($blog->images) : asset('vendor/landing-page2/image/blog-card-img-2.png');
                $redirectUrl = route('view.blog', $blog->slug);
                $createdAt = UtilityFacades::date_time_format($blog->created_at);
                $shortDescription = $blog->short_description ? $blog->short_description : 'A step-by-step guide on how to configure and implement multi-tenancy in a Laravel application, including tenant isolation and database separation.';
                $blogHtml .= '<div class="article-card">
                    <div class="article-card-inner">
                        <div class="article-card-image">
                            <a href="#">
                                <img src="' . $imageUrl . '" alt="blog-card-image">
                            </a>
                        </div>
                        <div class="article-card-content">
                            <div class="author-info d-flex align-items-center justify-content-between">
                                <div class="date d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                                        <!-- SVG path for date icon -->
                                    </svg>
                                    <span>' . $createdAt . '</span>
                                </div>
                            </div>
                            <h3>
                                <a href="' . $redirectUrl . '">' . $blog->title . '</a>
                            </h3>
                            <p>' . $shortDescription . '</p>
                        </div>
                    </div>
                </div>';
            }
            return response()->json(['appendedContent' => $blogHtml]);
        } else {
            $allBlogs = Blog::paginate(3);
        }
        $recentBlogs    = Blog::latest()->take(3)->get();
        $lastBlog       = Blog::latest()->first();
        $categories     = BlogCategory::all();
        return view('blog.view-all-blogs', compact('allBlogs', 'recentBlogs', 'lastBlog', 'categories', 'lang'));
    }
}
