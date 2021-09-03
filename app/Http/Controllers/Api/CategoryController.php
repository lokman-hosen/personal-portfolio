<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    protected $service;
    public function __construct(CategoryService $categoryService){
        $this->service = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CategoryCollection($this->service->getPaginatedDate());
        /*$categories = CategoryResource::collection($this->service->getPaginatedDate());
        if ($categories){
            return response()->json(['status' => true, 'data' => $categories, 'message' => 'Category List']);
        }*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
        ]);

        $category = $this->service->create($request->all());
        if ($category){
            return response()->json(['status' => true, 'data' => $category, 'message' => 'Category Created']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required',
            'name' => [
                'required',
                Rule::unique('categories')->ignore($id),
            ],
        ]);
        $category = $this->service->update($request->all(), $id);
        if ($category){
            return response()->json(['status' => true,  'message' => 'Category Updated Successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->service->find($id);
        $category->delete();
        return response()->json(['status' => true, 'message' => 'Category Deleted Successfully']);

    }
}
