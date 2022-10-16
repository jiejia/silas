<?php
namespace App\Common\Services;

use App\Common\Repositories\Repository;
use App\Common\Repositories\UserRepository;

/**
 * 服务抽象基类
 */
abstract class Service
{
    protected string $repositoryClassName = UserRepository::class;

    protected Repository $repository;

    public function __construct()
    {
        $this->repository = new $this->repositoryClassName();
    }

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

    /**
     * 更新
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data): mixed
    {
        return $this->repository->update(['id' => $id], $data);
    }

    /**
     * 详情
     *
     * @param $id
     * @return mixed
     */
    public function detail($id): mixed
    {
        return $this->repository->find($id);
    }

    /**
     * 获取分页
     *
     * @param $params
     * @param $perPage
     * @return mixed
     */
    public function list($params, $perPage): mixed
    {
        return $this->repository->pagination($params, ['*'], $perPage);
    }

    /**
     * 删除
     *
     * @param $ids
     * @return mixed
     */
    public function delete($ids): mixed
    {
        return $this->repository->delete($ids);
    }
}
