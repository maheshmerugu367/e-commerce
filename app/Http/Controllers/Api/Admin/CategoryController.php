<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Constants\ResponseConstants;


class CategoryController extends Controller
{
    use ImageTrait;
    use ResponseTrait;

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

    public function  index(Request $request){

        dd($request->all());

    }
}
