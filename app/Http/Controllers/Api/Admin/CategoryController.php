<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use App\Traits\ResponseTrait;
use App\Traits\camelCaseTrait;
use App\Traits\ImageDelete;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Constants\ResponseConstants;


class CategoryController extends Controller
{
    use ImageTrait;
    use ResponseTrait;
    use camelCaseTrait;
    use ImageDelete;

    public function store(Request $request)
    {
        $rawJson = $request->data;
        $data = json_decode($rawJson, true);
        $title = $data['title'] ?? null;
        $priority = $data['priority'] ?? null;
        $status = $data['status'] ?? null;
        $parentId = $data['parentId'] ?? null;

        $jsonValidator = Validator::make($data, [
            'title' => 'required|string|min:3',
            'priority' => 'required|integer',
            'status' => 'required|in:1,0',
            'parentId' => 'nullable|integer',
        ]);

        if ($jsonValidator->fails()) {
            return $this->failureResponse(
                ResponseConstants::FAILURE_STATUS,
                ResponseConstants::FAILURE_MESSAGE,
                ResponseConstants::FAILURE_STATUS_CODE,
                $jsonValidator->errors()
            );
        }
        $fileValidator = Validator::make($request->all(), [
            'appIcon' => 'required|image',
            'menuImage' => 'required|image',
            'appMainImage' => 'required|image',
        ]);
        if ($fileValidator->fails()) {
            return $this->failureResponse(
                ResponseConstants::FAILURE_STATUS,
                ResponseConstants::FAILURE_MESSAGE,
                ResponseConstants::FAILURE_STATUS_CODE,
                $fileValidator->errors()
            );
        }
        try {
            $record_check = Category::where('title', $title)->first();
            if ($record_check) {
                $errors = ['Record Already Exists'];
                return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::FAILURE_MESSAGE, ResponseConstants::FAILURE_STATUS_CODE, $errors);
            } else {
                $appIcon_path = $this->compressAndStoreImage($request->file('appIcon'), ResponseConstants::PUBLIC_PATH . '/categories/app_icons');
                $menuImage_path = $this->compressAndStoreImage($request->file('menuImage'), ResponseConstants::PUBLIC_PATH . '/categories/menu_images');
                $appMainImage_path = $this->compressAndStoreImage($request->file('appMainImage'), ResponseConstants::PUBLIC_PATH . '/categories/app_main_images');
                $newData = Category::create([
                    'title' => $title,
                    'app_icon' => $appIcon_path,
                    'menu_image' => $menuImage_path,
                    'app_main_image' => $appMainImage_path,
                    'priority' => $priority,
                    'status' => $status,
                    'parent_id' => $parentId,
                    'trash' => '0',
                ]);
                if ($newData) {
                    return $this->successResponse(ResponseConstants::SUCCESS_STATUS, ResponseConstants::SUCCESS_MESSAGE, ResponseConstants::SUCCESS_STATUS_CODE);
                }
            }
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::FAILURE_MESSAGE, ResponseConstants::FAILURE_STATUS_CODE, $e->getMessage());
        }
    }

    public function  index(Request $request)
    {

        try {

            $categories = Category::all();
            $data = $categories->toArray();
            $final_data = $this->arrayKeysToCamelCaseCollection($data);
            if ($final_data) {
                return $this->successResponse(ResponseConstants::SUCCESS_STATUS, ResponseConstants::SUCCESS_MESSAGE, ResponseConstants::SUCCESS_STATUS_CODE, [], $final_data);
            } else {
                return $this->successResponse(ResponseConstants::SUCCESS_STATUS, ResponseConstants::NO_DATA_FOUND, ResponseConstants::SUCCESS_STATUS_CODE, [], []);
            }
        } catch (\Exception $e) {

            Log::error('An error occurred: ' . $e->getMessage());
            return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::FAILURE_MESSAGE, ResponseConstants::FAILURE_STATUS_CODE, $e->getMessage());
        }
    }

    public function Category(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'categoryId' => 'required',
        ]);
        if ($Validator->fails()) {
            return $this->failureResponse(
                ResponseConstants::FAILURE_STATUS,
                ResponseConstants::FAILURE_MESSAGE,
                ResponseConstants::FAILURE_STATUS_CODE,
                $Validator->errors()
            );
        } else {

            try {

                $category = Category::find($request->categoryId);

                if ($category) {
                    return $this->successResponse(ResponseConstants::SUCCESS_STATUS, ResponseConstants::SUCCESS_MESSAGE, ResponseConstants::SUCCESS_STATUS_CODE, [], $category);
                } else {
                    return $this->successResponse(ResponseConstants::SUCCESS_STATUS, ResponseConstants::NO_DATA_FOUND, ResponseConstants::SUCCESS_STATUS_CODE, [], []);
                }
            } catch (\Exception $e) {

                Log::error('An error occurred: ' . $e->getMessage());
                return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::FAILURE_MESSAGE, ResponseConstants::FAILURE_STATUS_CODE, $e->getMessage());
            }
        }
    }


    public function CategoryUpdate(Request $request)
    {

        $rawJson = $request->data;
        $data = json_decode($rawJson, true);
        $title = $data['title'] ?? null;
        $priority = $data['priority'] ?? null;
        $status = $data['status'] ?? null;
        $parentId = $data['parentId'] ?? null;
        $categoryId = $data['categoryId'];


        $jsonValidator = Validator::make($data, [
            'title' => 'required|string|min:3',
            'priority' => 'required|integer',
            'status' => 'required|in:1,0',
            'parentId' => 'nullable|integer',
            'categoryId' => 'required'
        ]);

        if ($jsonValidator->fails()) {
            return $this->failureResponse(
                ResponseConstants::FAILURE_STATUS,
                ResponseConstants::FAILURE_MESSAGE,
                ResponseConstants::FAILURE_STATUS_CODE,
                $jsonValidator->errors()
            );
        }


        $fileValidator = Validator::make($request->all(), [
            'appIcon' => 'required|image|min:1',
            'menuImage' => 'required|image',
            'appMainImage' => 'required|image',
        ]);
        if ($fileValidator->fails()) {
            return $this->failureResponse(
                ResponseConstants::FAILURE_STATUS,
                ResponseConstants::FAILURE_MESSAGE,
                ResponseConstants::FAILURE_STATUS_CODE,
                $fileValidator->errors()
            );
        }



        try {

            $category_data = Category::where('id', $categoryId)->first();


            if ($category_data) {
                if (isset($request->appIcon)) {
                    $app_delete_icon = $category_data->app_icon;
                    $this->deleteImage($app_delete_icon);
                    $appIcon_path = $this->compressAndStoreImage($request->file('appIcon'), ResponseConstants::PUBLIC_PATH . '/categories/app_icons');
                } else {
                    $appIcon_path = $category_data->app_icon;
                }

                if (isset($request->menuImage)) {

                    $menu_delete_icon = $category_data->menu_image;

                    $this->deleteImage($menu_delete_icon);

                    $menuImage_path = $this->compressAndStoreImage($request->file('menuImage'), ResponseConstants::PUBLIC_PATH . '/categories/menu_images');
                } else {
                    $menuImage_path = $category_data->menu_image;
                }

                if (isset($request->appMainImage)) {

                    $appMainImage = $category_data->app_main_image;
                    $this->deleteImage($appMainImage);

                    $appMainImage_path = $this->compressAndStoreImage($request->file('appMainImage'), ResponseConstants::PUBLIC_PATH . '/categories/app_main_images');
                } else {
                    $appMainImage_path = $category_data->app_main_image;
                }

                $category = Category::where('id', $categoryId)
                    ->update([
                        'title' => $title,
                        'app_icon' => $appIcon_path,
                        'menu_image' => $menuImage_path,
                        'app_main_image' => $appMainImage_path,
                        'priority' => $priority,
                        'status' => $status,
                        'parent_id' => $parentId,
                        'trash' => '0',
                    ]);

                if ($category) {
                    return $this->successResponse(ResponseConstants::SUCCESS_STATUS, ResponseConstants::SUCCESS_MESSAGE, ResponseConstants::SUCCESS_STATUS_CODE, [], []);
                } else {
                    return $this->successResponse(ResponseConstants::SUCCESS_STATUS, ResponseConstants::NO_DATA_FOUND, ResponseConstants::SUCCESS_STATUS_CODE, [], []);
                }
            } else {

                return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::RECORD_NOT_FOUND, ResponseConstants::FAILURE_STATUS_CODE);
            }
        } catch (\Exception $e) {

            Log::error('An error occurred: ' . $e->getMessage());
            return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::FAILURE_MESSAGE, ResponseConstants::FAILURE_STATUS_CODE, $e->getMessage());
        }
    }


    public function CategoryMoveToTrash(Request $request)
    {

        $Validator = Validator::make($request->all(), [

            'categoryId' => 'required',
            'trash' => 'required',
        ]);
        if ($Validator->fails()) {
            return $this->failureResponse(
                ResponseConstants::FAILURE_STATUS,
                ResponseConstants::FAILURE_MESSAGE,
                ResponseConstants::FAILURE_STATUS_CODE,
                $Validator->errors()
            );
        }

        try {

            $categoryId = $request->categoryId;
            $trash = $request->trash;

            $record_check=Category::where('id',$categoryId)->first();
            if($record_check){
                if (isset($categoryId)) {
                    if (isset($trash) && $trash == 0)
                        $categoryId = $request->categoryId;

                    $category_data = Category::where('id', $categoryId)
                        ->update([
                            'trash' => 1
                        ]);

                    return $this->successResponse(ResponseConstants::SUCCESS_STATUS, ResponseConstants::SUCCESS_MESSAGE, ResponseConstants::SUCCESS_STATUS_CODE, [], []);
                } else {
                    return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::FAILURE_MESSAGE, ResponseConstants::FAILURE_STATUS_CODE);
                }

            }else{

                return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::RECORD_NOT_FOUND, ResponseConstants::FAILURE_STATUS_CODE);


            }
           
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::FAILURE_MESSAGE, ResponseConstants::FAILURE_STATUS_CODE, $e->getMessage());
        }
    }

    public function CategoryDelete(Request $request)
    {

        $Validator = Validator::make($request->all(), [

            'categoryId' => 'required',
            'trash' => 'required',
        ]);
        if ($Validator->fails()) {
            return $this->failureResponse(
                ResponseConstants::FAILURE_STATUS,
                ResponseConstants::FAILURE_MESSAGE,
                ResponseConstants::FAILURE_STATUS_CODE,
                $Validator->errors()
            );
        }

        try {

            $categoryId = $request->categoryId;
            $trash = $request->trash;

            $record_check=Category::where('id',$categoryId)->first();
            if($record_check){
                if (isset($categoryId)) {
                    if (isset($trash) && $trash == 1){
                        $categoryId = $request->categoryId;
                    $category_data = Category::where('id', $categoryId)->delete();
                    return $this->successResponse(ResponseConstants::SUCCESS_STATUS, ResponseConstants::SUCCESS_MESSAGE, ResponseConstants::SUCCESS_STATUS_CODE, [], []);

                    }else{
                        return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::RECORD_NOT_FOUND, ResponseConstants::FAILURE_STATUS_CODE);

                    }
                
                } else {
                    return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::FAILURE_MESSAGE, ResponseConstants::FAILURE_STATUS_CODE);
                }

            }else{

                return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::RECORD_NOT_FOUND, ResponseConstants::FAILURE_STATUS_CODE);


            }
           
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            return $this->failureResponse(ResponseConstants::FAILURE_STATUS, ResponseConstants::FAILURE_MESSAGE, ResponseConstants::FAILURE_STATUS_CODE, $e->getMessage());
        }
    }
}
