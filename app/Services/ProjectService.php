<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class ProjectService extends BaseService
{

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */


    public function __construct(Project $project)
    {
        $this->model = $project;
    }

    public function getPaginatedDate($request): LengthAwarePaginator
    {
        $query = $this->model->with('category:id,name');
        if (isset($request->name)){
            $query = $query->where('name', 'like', '%'.$request->name.'%');
        }
        if (isset($request->category_id)){
            $query = $query->where('category_id', $request->category_id);
        }
        if (isset($request->status)){
            $query = $query->where('status', $request->status);
        }
        return $query->latest()->paginate(10);
    }

}
