<?php
namespace App\Admin\Controls;

use App\Admin\Services\TableService;
use Illuminate\Support\Facades\DB;

class NumericControl extends Control
{
    protected const TYPE_NAME = 'numeric';

    protected mixed $dataType = 'int';

    protected function init()
    {
        $this->isNull = ($this->isNull != 1) ? 'NULL' : 'NOT NULL';
        $this->default = $this->default ? "DEFAULT {$this->default}" : 0;
        $this->length = 11;
    }
}
