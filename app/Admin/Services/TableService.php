<?php
namespace App\Admin\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TableService
{
    protected string $tableName = '';

    protected const MODEL_TABLE_PREFIX = 'content_';

    public function __construct($tableName)
    {
        $this->tableName = self::MODEL_TABLE_PREFIX . $tableName;
    }

    /**
     * 创建表
     *
     * @return array
     */
    public function createTable(): array
    {
        DB::select("DROP TABLE IF EXISTS `{$this->tableName}`;");

        return DB::select("   CREATE TABLE `{$this->tableName}` (`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '主键 ID') ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    /**
     * 更新表
     *
     * @param $oldTableName
     * @return array
     */
    public function updateTable($oldTableName): array
    {
        $oldTableName = self::MODEL_TABLE_PREFIX . $oldTableName;
        return DB::select("ALTER TABLE `{$oldTableName}` RENAME `{$this->tableName}`");
    }

    /**
     * 创建字段
     *
     * @param $fieldName
     * @param $dataType
     * @param $length
     * @param $isNull
     * @param $default
     * @return array
     */
    public function createField($fieldName, $dataType, $length, $isNull, $default): array
    {
        return DB::select("alter table `{$this->tableName}` Add column `{$fieldName}` {$dataType}({$length}) {$isNull} {$default};");
    }

    /**
     * 更新字段
     *
     * @param $oldTableFieldName
     * @param $fieldName
     * @param $dataType
     * @param $length
     * @param $isNull
     * @param $default
     * @return array
     */
    public function updateField($oldTableFieldName, $fieldName, $dataType, $length, $isNull, $default): array
    {
        return DB::select("alter table `{$this->tableName}` CHANGE  column `$oldTableFieldName` `{$fieldName}` {$dataType}({$length}) {$isNull} {$default};");
    }

    /**
     * 删除字段
     *
     * @param $fieldName
     * @return array
     */
    public function deleteField($fieldName): array
    {
        return DB::select("ALTER TABLE `{$this->tableName}` DROP COLUMN `{$fieldName}`");
    }

    /**
     * 查询一条记录
     *
     * @param $id
     * @param array $columns
     * @return Builder|mixed
     */
    public function find($id, array $columns = ['*']): mixed
    {
        return DB::table($this->tableName)->select($columns)->find($id);
    }

    /**
     * 查询
     *
     * @param array $conditions
     * @param array $columns
     * @param string $orderBy
     * @param string $groupBy
     * @param array $having
     * @return Builder
     */
    protected function query(array $conditions = [], array $columns = ['*'], string $orderBy = '', string $groupBy = '', array $having = []): Builder
    {
        $query = DB::table($this->tableName)->select($columns);

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
     * 获取分页
     *
     * @param array $conditions
     * @param array $columns
     * @param int $limit
     * @param string $orderBy
     * @param string $groupBy
     * @param array $having
     * @return LengthAwarePaginator
     */
    public function pagination(array $conditions = [], array $columns = ['*'], int $limit = 20, string $orderBy = '', string $groupBy = '', array $having = []): LengthAwarePaginator
    {
        $query = $this->query($conditions, $columns, $orderBy, $groupBy, $having);

        return $query->paginate($limit);
    }
}
