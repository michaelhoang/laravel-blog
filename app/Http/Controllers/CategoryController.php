<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo '<pre>';
        print_r("Get all categories");
        echo '</pre>';
        exit(__FILE__ . ':' . __LINE__);
        $_ENV['mdebug'] = 1;
//        $images = Post::find(9)->image;
//        $images = User::find(2)->image;

//        echo '<pre>';
//        print_r($images->toArray());
//        echo '</pre>';

//        $image = Image::find(1);
//        $imageable = $image->imageable;
//        echo '<pre>';
//        print_r($imageable);
//        echo '</pre>';


//        $categories = DB::table('categories')->pluck('id', 'name', 'slug');
        $_ENV['mdebug'] = 1;

//        $category = DB::table('categories')->where('id', '<', [1, 2, 3])->get();
//        $result = DB::select("SELECT * FROM `blog_app`.`categories` LIMIT 0, 1000");
        $result = DB::table('categories')->limit(1000)->get();

        echo '<pre>';
        print_r($result);
        echo '</pre>';
        exit(__FILE__ . ':' . __LINE__);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        return view('category', ['category' => $category, 'posts' => $category->posts]);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @param Category $post
     * @return \Illuminate\Http\Response
     */
    public function post(Category $category, Post $post)
    {
        return view('post', compact('category', 'post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
