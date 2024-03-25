<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(){
        //get all category
       try {
        $category = Category::latest()->get();

        return ResponseFormatter::success(
            $category,
            'Data Category Berhasil Diambil'
        );
       } catch (\Exception $error) {
            return ResponseFormatter::error([
            'message' => 'Something went wrong',
            'error' => $error
            ], 'Authentication Failed', 500);
            }
    }

    public function show($id){
        try {
            $category = Category::findOrFail($id);
            
            return ResponseFormatter::success(
                $category,
                'Data category by id'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }
}