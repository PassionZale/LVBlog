<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Api\ApiController;
use App\Category;

class CategoryController extends ApiController
{
    // 列表
    public function index(){
        return Category::paginate(10);
    }

    // 查询
    public function show($id){
        return Category::find($id);
    }

    // 创建
    public function store(Request $request,Category $category){
        $category->name = $request->input('name');
        return $category->save() === TRUE ? 1 : 0;
    }

    // 更新
    public function update(Request $request, Category $category){
        return $category->where('id',$request->input('id'))
            ->update(['name'=>$request->input('name')]);
    }

    // 删除
    public function destroy($id){
        return Category::destroy($id);
    }

}
