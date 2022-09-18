<?php
namespace App\Admin\Repositories;

use App\Common\Repositories\Repository;
use App\Admin\Models\Model;

class ModelRepository extends Repository
{
    protected string $model = Model::class;
}
