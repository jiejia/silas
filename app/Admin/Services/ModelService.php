<?php
namespace App\Admin\Services;

use App\Common\Services\Service;
use App\Admin\Repositories\ModelRepository;
use App\Exceptions\ValidationException;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Admin\Controls\Control;

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
     * @throws Exception
     */
    public function create($data): mixed
    {
        DB::beginTransaction();

        // 保存模型
        $model = $this->repository->create($data);

        // 保存模型字段
        $fieldService = app(ModelFieldService::class);
        foreach ($data['fields'] as &$field) {
            $field['model_id'] = $model->id;
            $field['length'] = $field['length'] ?? null;
            $field['valid_rule'] = $field['valid_rule'] ?? null;
            $field['valid_msg'] = $field['valid_msg'] ?? null;
            $field['comments'] = $field['comments'] ?? null;
            $field['is_null'] = (int) $field['is_null'];
            $field['default'] = $field['default'] ?? null;
            $field['config'] = $field['config'] ?? null;
            $fieldService->create($field);
        }

        DB::commit();

        // 创建表
        $tableService = new TableService($data['table_name']);
        $tableService->createTable();
        foreach ($data['fields'] as $v) {
            $control = Control::factory($tableService, $v['form_control'], $v['table_field_name'], $v['length'], $v['valid_rule'], $v['valid_msg'], $v['comments'], $v['is_null'], $v['default'], $v['config']);
            $control->createField();
        }

        return $model;
    }

    /**
     * 创建
     *
     * @param $id
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function update($id, $data): mixed
    {
        DB::beginTransaction();

        $fields = $data['fields'];

        unset($data['fields']);

        // 保存模型
        $model = $this->repository->update(['id' => $id], $data);

        // 保存模型字段
        $fieldService = app(ModelFieldService::class);
        foreach ($fields as &$field) {
            $field['model_id'] = $id;
            $field['length'] = $field['length'] ?? null;
            $field['valid_rule'] = $field['valid_rule'] ?? null;
            $field['valid_msg'] = $field['valid_msg'] ?? null;
            $field['comments'] = $field['comments'] ?? null;
            $field['is_null'] = (int) $field['is_null'];
            $field['default'] = $field['default'] ?? null;
            $field['config'] = $field['config'] ?? null;

            if (empty($field['id'])) {
                $fieldService->create($field);
            } else {
                $oldField = $fieldService->detail($field['id']);

                if (! $oldField) {
                    throw new ValidationException(["字段ID不存在"]);
                }
                $fieldId = $field['id'];
                unset($field['id']);
                $fieldService->update($id, $field);
                $field['id'] = $fieldId;
                $field['old_table_field_name'] = $oldField->table_field_name;
            }
        }

        DB::commit();

        // 创建字段
        $tableService = new TableService($data['table_name']);
        foreach ($fields as $v) {
            $control = Control::factory($tableService, $v['form_control'], $v['table_field_name'], $v['length'], $v['valid_rule'], $v['valid_msg'], $v['comments'], $v['is_null'], $v['default'], $v['config']);
            if (empty($v['id'])) {
                $control->createField();
            } else {
                $control->updateField($v['old_table_field_name']);
            }
        }

        return $model;
    }

    /**
     * 详情
     *
     * @param $id
     * @return mixed
     */
    public function detail($id): mixed
    {
        $model = $this->repository->find($id);

        $model->fields;

        return $model;
    }
}
