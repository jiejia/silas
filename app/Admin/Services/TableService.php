<?php
namespace App\Admin\Services;

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
}
