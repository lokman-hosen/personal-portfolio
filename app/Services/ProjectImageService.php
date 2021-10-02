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
            $query = $query->where('title', 'like', '%'.$request->name.'%');
        }
        if (isset($request->project_id)){
            $query = $query->where('project_id', $request->project_id);
        }
        if (isset($request->status)){
            $query = $query->where('status', $request->status);
        }
        return $query->latest()->paginate(10);
    }

}
