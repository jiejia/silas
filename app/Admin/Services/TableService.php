<?php
namespace App\Admin\Services;

use Illuminate\Support\Facades\DB;

class TableService
{
    protected string $tableName = '';

    protected const MODEL_TABLE_PREFIX = 'm_';

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
}
