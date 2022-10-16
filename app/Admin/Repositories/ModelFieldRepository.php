<?php
namespace App\Admin\Repositories;

use App\Common\Repositories\Repository;
use App\Admin\Models\ModelFIeld;

class ModelFieldRepository extends Repository
{
    protected string $model = ModelField::class;
}
