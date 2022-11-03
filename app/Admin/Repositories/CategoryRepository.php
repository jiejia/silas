<?php
namespace App\Admin\Repositories;

use App\Admin\Models\Category;
use App\Common\Repositories\Repository;
use App\Admin\Models\Model;

class CategoryRepository extends Repository
{
    protected string $model = Category::class;
}
