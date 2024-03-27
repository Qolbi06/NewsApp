<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request){
        try {
            //validate
            $this->validate($request, [
                'name' => 'required|unique:categories',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $image = $request->file('image');
            $image->storeAs('public/category', $image->hashName());

            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $image->hashName()
            ]);

            return ResponseFormatter::success(
                $category,
                'Data Category Berhasil Ditambahkan'
            );
            
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 400);
        }
    }

    public function update(Request $request, $id){
        try {
            //validate
            $this->validate($request, [
                'name' => 'required',
                'image' => 'image|mimes:Jpeg,png,Jpg|max:2048'
            ]);

            //Get data by id
            $category = Category::findOrFail($id);

            // Store Image
            if ($request->file('image') == '') {
                $category->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name)
                ]);

            } else {
                // jika gambar ingin di update
                // Hapus image lama
                Storage::disk('local')->delete('public/category/' .basename($category->image));
                
                // Upload image baru
                $image = $request->file('image');
                $image->storeAs('public/category/', $image->hashName());
    
                // Update data
                $category->update([
                    'name' => $request->name,
                    'slug' => Str::slug( $request->name),
                    'image' => $image->hashName()
                ]);
    
                
            } 

            return ResponseFormatter::success(
                $category,
                'Data Category Berhasil Diupdate'
            );

        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went Wrong',
                'error' => $error
            ], 'Authentication', 500);
        }
    }

    public function destroy($id){
        try {
            //get data by id
            $category = Category::findOrFail($id);

            Storage::disk('local')->delete('public/category/' . basename($category->image));

            $category->delete();

            return ResponseFormatter::success(
                null,
                'Data Category Berhasil Dihapus'
            );
            
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went Wrong',
                'error' => $error
            ], 'Authentication', 500);
        }
    }
}