<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use App\Traits\ResponseTrait;
use App\Traits\camelCaseTrait;
use App\Traits\ImageDelete;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Constants\ResponseConstants;
use Illuminate\Support\Facades\Storage;


use App\Models\Category;
use App\Models\ListSubCategory;
use App\Models\subCategory;

class ListsubCategoryController extends Controller
{

    use ImageTrait;
    use ResponseTrait;
    use camelCaseTrait;
    use ImageDelete;
    /**
     * Display a listing of the resource.
     */
    public function Create()

    {

        $categories=Category::all();
        $sub_categories=subCategory::all();
        return view('admin.listsubcategories.add',compact('categories','sub_categories'));
    }

   

   

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
    
        $query = ListSubCategory::query();
    
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

    
        if ($status === 'all') {
            $query->whereIn('status', [0, 1, null]);
        } elseif ($status =="0") {
            $query->where('status', 0); // Assuming 0 represents inactive
        } elseif ($status) {
            $query->where('status', $status);
        }
    
        $all_categories = $query->latest()->paginate(10);
    
        return view('admin.listsubcategories.index', compact('all_categories', 'search', 'status'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'category_id'=>'required',
            'sub_category_id'=>'required',
            'appIcon' => 'image|mimes:jpeg,png',
            'webIcon' => 'image|mimes:jpeg,png',
            'mainImage' => 'image|mimes:jpeg,png',
            'status'=>'required',
            'priority' => ['required', 'numeric', 'regex:/^\d{1,2}(\.\d{1,2})?$/'],
           

        ]);




        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }





        try {
            $record_check = ListSubCategory::where('title', $request->title)->first();
            if ($record_check) {

                $errors = ['title' => ['Record Already Exists']];
                return redirect()->back()->withErrors($errors);
            } else {

                if(isset($request->appIcon)){
                    $appIconPath = $this->compressAndStoreImagewithDimensions($request->file('appIcon'), 100, 100, true, 75);

                }


                if(isset($request->webIcon)){

                    $webIconPath = $this->compressAndStoreImagewithDimensions($request->file('webIcon'), 100, 100, true, 75);

                }

                if(isset($request->mainImage)){
                    $mainImagePath = $this->compressAndStoreImagewithDimensions($request->file('mainImage'), 100, 100, true, 75);

                }


                $newData = ListSubCategory::create([
                    'category_id'=>$request->category_id,
                    'sub_category_id'=>$request->sub_category_id,
                    'title' => $request->title,
                    'app_icon' => $appIconPath ?? '',
                    'web_icon' => $webIconPath ?? '',
                    'main_image' => $mainImagePath ?? '',
                    'priority' => $request->priority,
                    'status' => $request->status ?? '1',
                    'trash' => '0',
                    'front_status'=>$request->front_status ?? '1',
                ]);
                if ($newData) {

                    return redirect()->back()->with('success', 'List Sub Category Created Successfully!');
                }
            }
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());

            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $list_sub_category = ListSubCategory::find($id);
        $sub_categories=subCategory::all();
        $categories=Category::all();
        return view('admin.listsubcategories.edit', compact('list_sub_category','categories','sub_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|regex:/^[a-zA-Z\s]+$/',
            'appIcon' => 'image|mimes:jpeg,png',
            'webIcon' => 'image|mimes:jpeg,png',
            'mainImage' => 'image|mimes:jpeg,png',
            'priority' => ['required', 'numeric', 'regex:/^\d{1,2}(\.\d{1,2})?$/'],
            'category_id'=>'required',
            'sub_category_id'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {

                $categoryId = $request->id;
                $category = ListSubCategory::find($categoryId);


                if ($request->file('appIcon')) {
                    $appIconPath = $this->compressAndStoreImagewithDimensions($request->file('appIcon'), 100, 100, true, 75);
                    Storage::delete('public/'.$category->app_icon);

                }else{
                    $appIconPath=$category->app_icon;
                }

                if (isset($request->webIcon)) {
                    $webIconPath = $this->compressAndStoreImagewithDimensions($request->file('webIcon'), 100, 100, true, 75);
                    Storage::delete('public/'.$category->web_icon);

                }else{
                    $webIconPath=$category->web_icon;

                }
                if (isset($request->mainImage)) {
                    $mainImagePath = $this->compressAndStoreImagewithDimensions($request->file('mainImage'), 100, 100, true, 75);
                    Storage::delete('public/'.$category->main_image);

                }else{

                    $mainImagePath=$category->main_image;


                }
               

                if ($category) {
                    $updated =   $category->update([
                        'title' => $request->title,
                        'category_id'=>$request->category_id,
                        'app_icon' => $appIconPath,
                        'web_icon' => $webIconPath,
                        'main_image' => $mainImagePath,
                        'priority' => $request->priority,
                        'status' => $request->status ?? '1',
                        'trash' => '0',
                        'seo_title'=>$request->seo_title,
                        'seo_description'=>$request->seo_description,
                        'seo_keywords'=>$request->seo_keywords,
                    ]);
                }


                if ($updated) {

                    return redirect()->back()->with('success', 'List Sub Category Updated Successfully!');
                }
            } catch (\Exception $e) {
                Log::error('An error occurred: ' . $e->getMessage());

                return response()->json([
                    'errors' => $e->getMessage()
                ], 422);
            }
        }
    }

    public function appIconDelete($id){

        $category = ListSubCategory::findOrFail($id);

        // Delete the image file from storage
        if ($category->app_icon) {
            Storage::delete('public/'.$category->app_icon);
        }
    
        // Remove the image path from the database
        $category->app_icon = null;
        $category->save();
    
        return redirect()->back()->with('success', 'App icon deleted successfully.');


    }

    public function webIconDelete($id){

        $category = ListSubCategory::findOrFail($id);

        // Delete the image file from storage
        if ($category->web_icon) {
            Storage::delete('public/'.$category->web_icon);
        }
    
        // Remove the image path from the database
        $category->web_icon = null;
        $category->save();
    
        return redirect()->back()->with('success', 'Web icon deleted successfully.');


    }

    public function mainIconDelete($id){

        $category = ListSubCategory::findOrFail($id);

        // Delete the image file from storage
        if ($category->main_image) {
            Storage::delete('public/'.$category->main_image);
        }
    
        // Remove the image path from the database
        $category->main_image = null;
        $category->save();
    
        return redirect()->back()->with('success', 'Main icon deleted successfully.');


    }

    public function deleteSelectedsubCategories(Request $request)
{
    $ids = $request->input('ids');

    if ($ids) {
        // Deleting the categories
        ListSubCategory::whereIn('id', $ids)->delete();

        return response()->json(['success' => 'List Sub Categories deleted successfully.']);
    }

    return response()->json(['error' => 'No categories selected.']);
}

public function trashSelectedsubCategories(Request $request)
{
    $ids = $request->input('ids');

    if ($ids) {
        // Deleting the categories
        ListSubCategory::whereIn('id', $ids)->update([
            'trash'=>'1'
        ]);

        return response()->json(['success' => 'List Sub Categories Moved To Trash Successfully.']);
    }

    return response()->json(['error' => 'No categories selected.']);
}


public function activeSelectedsubCategories(Request $request)
{
    $ids = $request->input('ids');

    if ($ids) {
        // Deleting the categories
        ListSubCategory::whereIn('id', $ids)->update([
            'status'=>'1'
        ]);

        return response()->json(['success' => 'List Sub Categories Status Changed Successfully.']);
    }

    return response()->json(['error' => 'No categories selected.']);
}


public function inactiveSelectedsubCategories(Request $request)
{
    $ids = $request->input('ids');

    if ($ids) {
        // Deleting the categories
        ListSubCategory::whereIn('id', $ids)->update([
            'status'=>'0'
        ]);

        return response()->json(['success' => 'List Sub Categories Status Changed Successfully.']);
    }

    return response()->json(['error' => 'No categories selected.']);
}

public function frontactiveSelectedsubCategories(Request $request)
{
    $ids = $request->input('ids');

    if ($ids) {
        // Deleting the categories
        ListSubCategory::whereIn('id', $ids)->update([
            'front_status'=>'1'
        ]);

        return response()->json(['success' => 'List Sub Categories frontend  Status Changed Successfully.']);
    }

    return response()->json(['error' => 'No categories selected.']);
}


public function frontinactiveSelectedsubCategories(Request $request)
{
    $ids = $request->input('ids');

    if ($ids) {
        // Deleting the categories
        ListSubCategory::whereIn('id', $ids)->update([
            'front_status'=>'0'
        ]);

        return response()->json(['success' => 'List Sub Categories frontend  Status Changed Successfully.']);
    }

    return response()->json(['error' => 'No categories selected.']);
}




}
