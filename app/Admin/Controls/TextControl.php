<?php
namespace App\Admin\Controls;

use Illuminate\Support\Facades\DB;

class TextControl extends Control
{
    protected const TYPE_NAME = 'text';

    protected mixed $dataType = 'varchar';

    public function __construct($fieldName, $length, $validRule, $validMsg, $comment, $isNull, $default, $config = [])
    {
        $this->fieldName = $fieldName;
        $this->length = $length;
        $this->validRule = $validRule;
        $this->validMsg = $validMsg;
        $this->comment = $comment;
        $this->isNull = ($isNull != 1) ? 'NULL' : 'NOT NULL';
        $this->default = $default ? "DEFAULT $default" : '';
        $this->config = $config;
    }

    public function createField($tableName): array
    {
        return DB::select("alter table `{$tableName}` Add column `{$this->fieldName}` {$this->dataType}({$this->length}) {$this->isNull} {$this->default};");
    }
}
