<?php

namespace App\Services;

use App\Models\ProjectImage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class ProjectImageService extends BaseService
{

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */


    public function __construct(ProjectImage $projectImage)
    {
        $this->model = $projectImage;
    }

    public function getPaginatedDate($request): LengthAwarePaginator
    {
        $query = $this->model->with('project:id,name');
        if (isset($request->title)){
            $query = $query->where('title', 'like', '%'.$request->title.'%');
        }
        if (isset($request->project_id)){
            $query = $query->where('project_id', $request->project_id);
        }
        if (isset($request->status)){
            $query = $query->where('status', $request->status);
        }
        return $query->latest()->paginate(10);
    }

    public function saveProjectImage($request){
        //upload file
        if ($request->hasFile('file')){
            $projectImage = $request->file('file');
            $projectImageFileName = 'project'.time() . '.' . $projectImage->getClientOriginalExtension();
            if (!file_exists('uploads/project')){
                mkdir('uploads/project', 0777, true);
            }
            $projectImage->move('uploads/project', $projectImageFileName);
        }else{
            $projectImageFileName = 'default.png';
        }

       return $this->model->create([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'description' => $request->description,
            'file' => $projectImageFileName,
        ]);
    }


    public function updateProjectImage($request, $projectImage){
        //upload file
        if ($request->hasFile('file')){
            $projectImageFile = $request->file('file');
            $projectImageFileName = 'project'.time() . '.' . $projectImageFile->getClientOriginalExtension();
            if (!file_exists('uploads/project')){
                mkdir('uploads/project', 0777, true);
            }
            //delete old image if exist
            if (file_exists('uploads/project/'.$projectImage->file)){
                unlink('uploads/project/'.$projectImage->file);
            }
            $projectImageFile->move('uploads/project', $projectImageFileName);
        }else{
            $projectImageFileName = $projectImage->file;
        }
       return $projectImage->update([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'description' => $request->description,
            'file' => $projectImageFileName,
            'status' => $request->status,
        ]);

    }

}
