<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class CategoryService extends BaseService
{

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */


    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function getPaginatedDate($request){
        $query = $this->model->query();
        if (isset($request->name)){
            $query = $query->where('name', 'like', '%'.$request->name.'%');
        }
        if (isset($request->status)){
            $query = $query->where('status', $request->status);
        }
        return $query->latest()->paginate(10);
    }

    public function getCategoryList(){
        return $this->model->orderByName()->get();
    }

}
