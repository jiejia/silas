<?php
namespace App\Admin\Services;

use App\Common\Services\Service;
use App\Admin\Repositories\ModelRepository;

/**
 * 模型服务类
 */
class ModelService extends Service
{
    protected string $repositoryClassName = ModelRepository::class;

    /**
     * 创建
     *
     * @param $data
     * @return mixed
     */
    public function create($data): mixed
    {
        return $this->repository->create($data);
    }
}
