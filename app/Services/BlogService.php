<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class BlogService extends BaseService
{

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */


    public function __construct(Blog $blog)
    {
        $this->model = $blog;
    }

    public function getPaginatedDate($request): LengthAwarePaginator
    {
        $query = $this->model->query();
        if (isset($request->name)){
            $query = $query->where('name', 'like', '%'.$request->name.'%');
        }
        if (isset($request->category_id)){
            $query = $query->where('category_id', $request->category_id);
        }
        if (isset($request->status)){
            $query = $query->where('status', $request->status);
        }
        return $query->latest()->paginate(50);
    }

    public function saveBlog($request){
       return $this->create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => 'default.png',
            'status' => 1,
        ]);
    }

}
