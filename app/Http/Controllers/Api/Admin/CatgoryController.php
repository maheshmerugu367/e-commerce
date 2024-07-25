<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ImageTrait;
use App\Traits\CamelCaseTrait;



use Illuminate\Support\Facades\Validator;



class CatgoryController extends Controller
{
    use ImageTrait;
    use CamelCaseTrait;

   
        public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:categories',
            'app_icon' => 'required|image',
            'menu_image' => 'required|image',
            'app_main_image' => 'required|image',
            'priority' => 'required|string',
            'status' => 'required|in:1,2',
            'parent_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $app_icon_path = $this->compressAndStoreImage($request->file('app_icon'), 'uploads/categories/app_icons');
            $menu_image_path = $this->compressAndStoreImage($request->file('menu_image'), 'uploads/categories/menu_images');
            $app_main_image_path = $this->compressAndStoreImage($request->file('app_main_image'), 'uploads/categories/app_main_images');

            $newData = Categories::create([
                'title' => $request->title,
                'app_icon' => $app_icon_path,
                'menu_image' => $menu_image_path,
                'app_main_image' => $app_main_image_path,
                'priority' => $request->priority,
                'status' => $request->status,
                'parent_id' => $request->parent_id,
            ]);

            $newDataArray = $newData->toArray();

            // Convert array keys to camel case
            $response = $this->arrayKeysToCamelCase($newDataArray);

            return response()->json([
                'message' => 'Category Created successfully',
                'data' => $response,
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while storing data',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
       

       
    
    
}
