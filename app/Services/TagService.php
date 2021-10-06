<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Tag;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class TagService extends BaseService
{

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */


    public function __construct(Tag $tag){
        $this->model = $tag;
    }

    public function getPaginatedDate(){
        $query = $this->model->query();
        return $query->latest()->get();
    }


}
