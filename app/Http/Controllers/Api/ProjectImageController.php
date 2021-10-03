<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectImageRequest;
use App\Http\Resources\ProjectImageCollection;
use App\Models\ProjectImage;
use App\Services\ProjectImageService;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectImageController extends Controller
{

    protected $service;
    public function __construct(ProjectImageService $projectImageService){
        $this->service = $projectImageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return new ProjectImageCollection($this->service->getPaginatedDate($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectImageRequest $request)
    {
        $projectImage = $this->service->saveProjectImage($request);
        if ($projectImage){
            return response()->json(['status' => true, 'data' => $projectImage, 'message' => 'Project Created']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectImage  $projectImage
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectImage $projectImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectImage  $projectImage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectImage $projectImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectImage  $projectImage
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectImageRequest $request, ProjectImage $projectImage)
    {
        $project = $this->service->updateProjectImage($request, $projectImage);
        if ($project){
            return response()->json(['status' => true,  'message' => 'Category Updated Successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectImage  $projectImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectImage $projectImage)
    {
        //delete old image if exist
        if (file_exists('uploads/project/'.$projectImage->file)){
            unlink('uploads/project/'.$projectImage->file);
        }
        $projectImage->delete();
        return response()->json(['status' => true, 'message' => 'Project Image Deleted Successfully']);
    }
}
