<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Article;
use App\Category;
use Auth;
use Redirect;

class HomeController extends Controller
{

    public $categories_sidebar;

    function __construct(){
        // 分类列表
        $categories = Category::take(8)->get();
        $categories_count = Category::count();
        $this->categories_sidebar = [
            'categories'=>$categories,
            'categories_count'=>$categories_count,
        ];
    }

    // prev article ID
    private function getPrevArticleId($id){
        return Article::where('id', '<', $id)->max('id');
    }

    // next article ID
    private function getNextArticleId($id){
        return Article::where('id', '>', $id)->min('id');
    }

    // fronted
    public function index(){
        $articles = Article::orderBy('id','desc')->paginate(5);

        return view('index')->with([
            'articles'=>$articles,
            'categories_sidebar'=>$this->categories_sidebar,
            'links'=>$articles->links(),
        ]);
    }

    // article
    public function article($id){

        $article = Article::findOrFail($id);

        $article->views = $article->views + 1;
        $article->save();

        $tags = $article->tags;
        $category = $article->category;

        $prev = $this->getPrevArticleId($id);
        $next = $this->getNextArticleId($id);

        return view('article')->with([
            'article' => $article,
            'categories_sidebar' => $this->categories_sidebar,
            'article_tags' => $tags,
            'article_category' => $category->first(),
            'prev'=> $prev,
            'next' => $next,
        ]);
    }

    // category article list
    public function category($id){
        $category = category::findOrFail($id);
        $articles = $category->articles;
        return view('search')->with([
            'articles' => $articles,
            'categories_sidebar' => $this->categories_sidebar,
        ]);
    }

    // search article list
    public function search(Request $request){
        $keyword = $request->keyword;
        $articles = Article::where('title', 'like', '%'.$keyword.'%')->get();
        return view('search')->with([
            'articles' => $articles,
            'categories_sidebar' => $this->categories_sidebar,
            'keyword' => $keyword,
        ]);
    }

    // backend
    public function dashboard(){
        if(Auth::check()){
            return view('dashboard.index');
        }else{
            return Redirect::action('Auth\AuthController@showLoginForm');
        }
    }

}
