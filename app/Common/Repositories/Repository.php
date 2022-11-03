<?php
namespace App\Common\Repositories;

use App\Models\User;

/**
 * 数据仓库抽象基类
 */
abstract class Repository
{
    /**
     * 模型名
     *
     * @var string
     */
    protected string $model = User::class;

    /**
     * 获取一条记录
     *
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, array $columns = ['*']): mixed
    {
        return $this->model::query()->select($columns)->find($id);
    }

    /**
     * 查询一条记录
     *
     * @param array $conditions
     * @param array $columns
     * @return mixed
     */
    public function findOne(array $conditions = [], array $columns = ['*']): mixed
    {
        return $this->model::query()->select($columns)->where($conditions)->first();
    }

    /**
     * 获取多条记录
     *
     * @param array $conditions
     * @param array $columns
     * @param string $orderBy
     * @param string $groupBy
     * @param array $having
     */
    protected function query(array $conditions = [], array $columns = ['*'], string $orderBy = '', string $groupBy = '', array $having = [])
    {
        $query = $this->model::query()->select($columns);

        if (count($conditions) > 0) {
            $query = $query->where($conditions);
        }

        if (! empty($orderBy)) {
            $query = $query->orderByRaw($orderBy);
        }

        if (! empty($groupBy)) {
            $query = $query->groupByRaw($groupBy);
        }

        if (! empty($having)) {
            $query = $query->havingRaw($having[0], $having[1]);
        }

        return $query;
    }

    /**
     * 查询多条记录
     *
     * @param array $conditions
     * @param array $columns
     * @param string $orderBy
     * @param string $groupBy
     * @param array $having
     * @param int $limit
     * @return mixed
     */
    public function findWhere(array $conditions = [], array $columns = ['*'], string $orderBy = '', string $groupBy = '', array $having = [], int $limit = 0): mixed
    {
        $query = $this->query($conditions, $columns, $orderBy, $groupBy, $having);

        if (! empty($limit)) {
            $query = $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * 分页
     *
     * @param array $conditions
     * @param array $columns
     * @param int $limit
     * @param string $orderBy
     * @param string $groupBy
     * @param array $having
     * @return mixed
     */
    public function pagination(array $conditions = [], array $columns = ['*'], int $limit = 20, string $orderBy = '', string $groupBy = '', array $having = []): mixed
    {
        $query = $this->query($conditions, $columns, $orderBy, $groupBy, $having);

        return $query->paginate($limit);
    }

    /**
     * 获取数量
     *
     * @param array $conditions
     * @return mixed
     */
    public function count(array $conditions = []): mixed
    {
        return  $this->where($conditions)->count();
    }

    /**
     * 创建
     *
     * @param $data
     * @return mixed
     */
    public function create($data): mixed
    {
        return $this->model::create($data);
    }

    /**
     * 更新
     *
     * @param array $conditions
     * @param $data
     * @return mixed
     */
    public function update(array $conditions, $data): mixed
    {
        return $this->model::where($conditions)->update($data);
    }

    /**
     * 删除
     *
     * @param array $conditions
     * @return mixed
     */
    public function deleteWhere(array $conditions): mixed
    {
        return $this->model::where($conditions)->delete();
    }

    /**
     * 按id删除
     *
     * @param $ids
     * @return mixed
     */
    public function delete($ids): mixed
    {
        return $this->model::whereIn('id', $ids)->delete();
    }
}
