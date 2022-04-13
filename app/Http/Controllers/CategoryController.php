<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        /* $categories=DB::table('categories')->get(); */

        return view('category.category', compact('categories'));
    }
    public function categoryAddShow()
    {
        return view('category.add');
    }
    public function categoryAdd(Request $request)
    {
        $name = $request->name;
        $status = $request->status ? 1 : 0;
        //$user_id = auth()->user()->id;

        //Eloquent -> with model ->first way
        Category::create([
            'name' => $name,
            'status' => $status
        ]);
        toast($name . ' has been submited!', 'success');
        return redirect()->route('category.index');

        //Eloquent -> with model ->second way
        /* 
        $category = new Categories();
        $category->name = $name;
        $category->status = $status;
        $category->save(); 
        */

        //Raw Query -> third way -> without model
        //DB::insert('insert into categories (name, status) values (?, ?)', [$name, $status]);

        //Query Builder -> fourth way -> without model
        //DB::table('categories')->insert(['name' => $name, 'status' => $status]);
    }

    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        $status = $category->status;
        $category->status = $status ? 0 : 1;
        $category->save();
        return response()->json(['message' => 'success', 'status' =>  $category->status], 200);
    }
    public function delete(Request $request)
    {
        Category::destroy($request->id);
        return response()->json(['message' => 'success'], 200);
    }
    public function updateShow(Request $request)
    {
        $category = Category::find($request->id);
        return response()->json(['category' => $category], 200);
    }
    public function update(Request $request)
    {
        $category = Category::find($request->id);
        $oldName = $category->name;
        $category->name = $request->name;
        $category->status = $request->status ? 1 : 0;
        $category->save();
        toast($oldName . ' has been changed!', 'success');
        return redirect()->route('category.index');
    }
}
