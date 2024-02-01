<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function index() {
        $data = DB::table('categories')->get();
        return view('causes_cat')->with('data', $data);
    }


    public function GetSubCatAgainstMainCatEdit($id){
        echo json_encode(DB::table('subcategories')->where('category_id', $id)->get());
    }
}
