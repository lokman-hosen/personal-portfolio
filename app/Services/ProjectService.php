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
        $query = $this->model->with('category');
        if (isset($request->name)){
            $query = $query->where('name', 'like', '%'.$request->name.'%');
        }
        if (isset($request->status)){
            $query = $query->where('status', $request->status);
        }
        return $query->latest()->paginate(10);
    }

}
