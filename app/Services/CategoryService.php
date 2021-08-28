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

}
