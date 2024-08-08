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

use App\Models\Category;


class CategoryController extends Controller
{

    use ImageTrait;
    use ResponseTrait;
    use camelCaseTrait;
    use ImageDelete;
    /**
     * Display a listing of the resource.
     */
    public function CategoryCreate()
    {
        return view('admin.category.add');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function index()
    {

        $all_categories = Category::all();
        return view('admin.category.index', compact('all_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'appIcon' => 'required|image|mimes:jpeg,png',
            'webIcon' => 'required|image|mimes:jpeg,png',
            'mainImage' => 'required|image|mimes:jpeg,png',
            'priority' => 'required',
        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }





        try {
            $record_check = Category::where('title', $request->title)->first();
            if ($record_check) {

                $errors = ['title' => ['Record Already Exists']];
                return redirect()->back()->withErrors($errors);
            } else {

                $appIconPath = $this->compressAndStoreImagewithDimensions($request->file('appIcon'), 100, 100, true, 75);
                $webIconPath = $this->compressAndStoreImagewithDimensions($request->file('webIcon'), 100, 100, true, 75);
                $mainImagePath = $this->compressAndStoreImagewithDimensions($request->file('mainImage'), 100, 100, true, 75);


                $newData = Category::create([
                    'title' => $request->title,
                    'app_icon' => $appIconPath,
                    'web_icon' => $webIconPath,
                    'main_image' => $mainImagePath,
                    'priority' => $request->priority,
                    'status' => $request->status ?? '1',
                    'trash' => '0',
                ]);
                if ($newData) {

                    return redirect()->back()->with('success', 'Category Created Successfully!');
                }
            }
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());

            return response()->json([
                'errors' => $$e->getMessage()
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
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            // 'appIcon' => 'required|image|mimes:jpeg,png',
            // 'webIcon' => 'required|image|mimes:jpeg,png',
            // 'mainImage' => 'required|image|mimes:jpeg,png',
            // 'priority' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {

                $categoryId = $request->id;
                $category = Category::find($categoryId);


                if ($request->file('appIcon')) {
                    $appIconPath = $this->compressAndStoreImagewithDimensions($request->file('appIcon'), 100, 100, true, 75);
                }else{
                    $appIconPath=$category->app_icon;
                }

                if (isset($request->webIcon)) {
                    $webIconPath = $this->compressAndStoreImagewithDimensions($request->file('webIcon'), 100, 100, true, 75);
                }else{
                    $webIconPath=$category->web_icon;

                }
                if (isset($request->mainImage)) {
                    $mainImagePath = $this->compressAndStoreImagewithDimensions($request->file('mainImage'), 100, 100, true, 75);
                }else{

                    $mainImagePath=$category->main_image;


                }
               

                if ($category) {
                    $updated =   $category->update([
                        'title' => $request->title,
                        'app_icon' => $appIconPath,
                        'web_icon' => $webIconPath,
                        'main_image' => $mainImagePath,
                        'priority' => $request->priority,
                        'status' => $request->status ?? '1',
                        'trash' => '0',
                    ]);
                }


                if ($updated) {

                    return redirect()->route('admin.category.index')->with('success', 'Category Created Successfully!');
                }
            } catch (\Exception $e) {
                Log::error('An error occurred: ' . $e->getMessage());

                return response()->json([
                    'errors' => $e->getMessage()
                ], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
