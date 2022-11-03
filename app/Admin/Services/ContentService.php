<?php
namespace App\Admin\Services;

use App\Admin\Repositories\ModelFieldRepository;
use App\Common\Services\Service;
use App\Admin\Repositories\ModelRepository;
use App\Exceptions\ValidationException;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Admin\Controls\Control;

/**
 * 内容服务类
 */
class ContentService extends Service
{
    protected string $repositoryClassName = ModelRepository::class;

    /**
     * 获取菜单
     *
     * @return array
     */
    public function getNav(): array
    {
        $models = $this->repository->findWhere(['status' => 1], ['id', 'name', 'table_name', 'description', 'open_category']);
        if (! $models) {
            return [];
        }

        return $models->toArray();
    }

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

        // 获取旧模型
        $oldModel = $this->repository->find($id);

        // 获取旧字段
        $oldFields = app(ModelFieldRepository::class)->findWhere(['model_id' => $id], ['id', 'table_field_name'])->toArray();
        $oldFieldIds = array_column($oldFields, 'id');
        $newFieldIds = array_column($fields, 'id');
        $diffFieldIds = array_diff($oldFieldIds, $newFieldIds);
        $diffFields = [];

        foreach ($oldFields as $v) {
            if (in_array($v['id'], $diffFieldIds)) {
                $diffFields []= $v;
            }
        }

        // 保存模型
        $model = $this->repository->update(['id' => $id], $data);

        // 删除老字段
        $fieldService = app(ModelFieldService::class);
        $fieldService->delete($diffFieldIds);

        // 保存模型字段
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
                $fieldService->update($fieldId, $field);
                $field['id'] = $fieldId;
                $field['old_table_field_name'] = $oldField->table_field_name;
            }
        }

        DB::commit();

        // 修改表名
        $tableService = new TableService($data['table_name']);
        $tableService->updateTable($oldModel->table_name);

        // 删除老字段
        if (! empty($diffFields)) {
            foreach ($diffFields as $v) {
                $tableService->deleteField($v['table_field_name']);
            }
        }

        // 保存模型字段
        foreach ($fields as $v) {
            $control = Control::factory($tableService, $v['form_control'], $v['table_field_name'], $v['length'], $v['valid_rule'], $v['valid_msg'], $v['comments'], $v['is_null'], $v['default'], $v['config']);
            if (empty($v['id'])) {
                // 创建新字段
                $control->createField();
            } else {
                // 修改老字段
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

    /**
     * 获取模型信息
     *
     * @param $perPage
     * @param $tableName
     * @return array
     */
    public function getList($perPage, $tableName): array
    {
        $model = $this->repository->findOne(['table_name' => $tableName]);

        if (! $model) {
            return [];
        }

        $tableService = new TableService($tableName);

        $pagination = $tableService->pagination()->toArray();

        return array_merge($pagination, ['fields' => $model->fields]);
    }
}
