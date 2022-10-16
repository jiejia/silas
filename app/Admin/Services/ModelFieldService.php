<?php
namespace App\Admin\Services;

use App\Common\Services\Service;
use App\Admin\Repositories\ModelFieldRepository;

/**
 * 模型字段服务类
 */
class ModelFieldService extends Service
{
    protected string $repositoryClassName = ModelFieldRepository::class;
}
