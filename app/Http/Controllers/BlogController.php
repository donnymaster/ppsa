<?php

namespace App\Http\Controllers;

use App\Filters\Blog\BlogFilter;
use App\Http\Requests\BlogArticleRequest;
use App\Models\Blog;
use App\Services\BlogService;
use App\Services\DoctorService;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    private $blogService;
    private $doctorService;

    public function __construct(BlogService $blogService, DoctorService $doctorService)
    {
        $this->blogService = $blogService;
        $this->doctorService = $doctorService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogFilter $request)
    {
        $articles = $this->blogService->all($request);
        return view('pages.blog.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\BlogArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogArticleRequest $request)
    {
        $this->blogService->create($request->validated(), Auth::user()->doctor->id);

        return redirect()->route('blog.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Blog::findOrFail($id);

        return view('pages.blog.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $this->doctorService->checkIsEditArticle($blog->doctor_id);

        return view('pages.blog.edit', ['article' => $blog]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\BlogArticleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogArticleRequest $request, $id)
    {
        $this->blogService->update($request->validated(), $id);

        return redirect()->route('blog.my');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Blog::findOrFail($id);
        $this->doctorService->checkIsEditArticle($article->doctor_id);

        $this->blogService->delete($article);

        return redirect()->route('blog.my');
    }

    public function my(BlogFilter $request)
    {
        $doctorId = Auth::user()->doctor->id;
        $articles = $this->blogService->getDoctorArticles($request, $doctorId);

        return view('pages.blog.doctor.index', compact('articles'));
    }
}
