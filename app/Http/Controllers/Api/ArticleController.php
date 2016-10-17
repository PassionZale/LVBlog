<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Article::orderBy('id','desc')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Article $article)
    {
        $article->title = $request->input('title');
        $article->desc = $request->input('desc');
        $article->content = $request->input('content');

        if($article->save()){
            // article_category
            $category = $request->input('categorySelected');
            if($category){
                DB::table('article_category')->insert([
                    'article_id'=>$article->id,
                    'category_id'=>$category['id'],
                    'created_at'=>date('Y-m-d H:i:s',time()),
                    'updated_at'=>date('Y-m-d H:i:s',time()),
                ]);
            }
            // article_tag
            $tags = $request->input('tagSelected');
            if($tags){
                foreach($tags as $tag){
                    DB::table('article_tag')->insert([
                        'article_id'=>$article->id,
                        'tag_id'=>$tag['id'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                        'updated_at'=>date('Y-m-d H:i:s',time()),
                    ]);
                }
            }
            return response()->json(1);
        }else{
            return response()->json(0);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tagSelected = [];
        $categorySelected = '';
        $article = Article::find($id);

        $tags = $article->tags;
        $category = $article->category;

        // 封装 tagSelected & categorySelected
        if(count($tags)){
            foreach($tags->toArray() as $tag){
                $tag['isSelected'] = TRUE;
                $tagSelected[] = array_only($tag,['id','name','isSelected','created_at','updated_at']);
            }
        }

        if(count($category)){
            $categorySelected = array_only($category->first()->toArray(),['id','name','created_at','updated_at']);
        }

        // 封装数据返回
        $response = [
            'id'=>$article->id,
            'title'=>$article->title,
            'desc'=>$article->desc,
            'content'=>$article->content,
            'categorySelected'=>$categorySelected,
            'tagSelected'=>$tagSelected,
        ];
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $article = Article::find($request->input('id'));
        $article->title = $request->input('title');
        $article->desc = $request->input('desc');
        $article->content = $request->input('content');

        // 更新 categorySelected tagSelected
        if($article->save()){

            $category = $request->input('categorySelected');
            if($category){
                DB::table('article_category')->where('article_id',$article->id)->delete();
                DB::table('article_category')->insert([
                    'article_id'=>$article->id,
                    'category_id'=>$category['id'],
                    'created_at'=>date('Y-m-d H:i:s',time()),
                    'updated_at'=>date('Y-m-d H:i:s',time()),
                ]);
            }

            $tags = $request->input('tagSelected');
            if($tags){
                DB::table('article_tag')->where('article_id',$article->id)->delete();
                foreach($tags as $tag){
                    DB::table('article_tag')->insert([
                        'article_id'=>$article->id,
                        'tag_id'=>$tag['id'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                        'updated_at'=>date('Y-m-d H:i:s',time()),
                    ]);
                }
            }
            return response()->json(1);
        }else{
            return response()->json(0);
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
        return Article::destroy($id);
    }
}
