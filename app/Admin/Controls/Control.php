<?php
namespace App\Admin\Controls;

use App\Admin\Services\TableService;
use Exception;

abstract class Control
{
    protected const TYPE_NAME = '';

    protected mixed $dataType;

    protected mixed $fieldName;

    protected mixed $length;

    protected mixed $validRule;

    protected mixed $validMsg;

    protected mixed $comment;

    protected mixed $isNull;

    protected mixed $default;

    protected mixed $config;

    protected TableService $tableService;


    public function __construct(TableService $tableService, $fieldName, $length, $validRule, $validMsg, $comment, $isNull, $default, $config = [])
    {
        $this->tableService = $tableService;
        $this->fieldName = $fieldName;
        $this->length = $length;
        $this->validRule = $validRule;
        $this->validMsg = $validMsg;
        $this->comment = $comment;
        $this->isNull = ($isNull != 1) ? 'IS NULL' : 'IS NOT NULL';
        $this->default = $default ? "DEFAULT $default" : '';
        $this->config = $config;

        $this->init();
    }

    abstract protected function init();

    /**
     * @throws Exception
     */
    public static function factory($tableService, $type, $fieldName, $length, $validRule, $validMsg, $comment, $isNull, $default, $config)
    {
        $controlName = "App\Admin\Controls\\" . ucfirst($type) . 'Control';
        if (! class_exists($controlName)) {
            throw new Exception("控件{$controlName}不存在");
        }
        return new $controlName($tableService, $fieldName, $length, $validRule, $validMsg, $comment, $isNull, $default, $config);
    }

    public function createField(): array
    {
        return $this->tableService->createField($this->fieldName, $this->dataType, $this->length, $this->isNull, $this->default);
    }
}
