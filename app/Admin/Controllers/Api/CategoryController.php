<?php
namespace App\Admin\Controllers\Api;

use App\Admin\Services\CategoryService;
use App\Common\Controllers\ApiController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Admin\Requests\Category;

class CategoryController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * 创建
     *
     * @param Category\CreateRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function create(Category\CreateRequest $request): JsonResponse
    {
        $data = [
            'model_id' => $request->input('model_id'),
            'parent_id' => $request->input('parent_id'),
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'cover' => $request->input('cover', ''),
            'status' => $request->input('status', 0) == 'on' ? 1: 0,
        ];

        $res = $this->service->create($data);

        return $this->response()->withSuccess($res);
    }

    /**
     * 更新
     *
     * @param Category\UpdateRequest $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Category\UpdateRequest $request, $id): JsonResponse
    {
        $data = [
            'name' => $request->input('name'),
            'table_name' => $request->input('table_name'),
            'description' => $request->input('description', ''),
            'status' => $request->input('status', 0) == 'on' ? 1: 0,
            'open_category' => $request->input('open_category', 0) == 'on' ? 1: 0,
            'fields' => $request->input('fields', []),
        ];

        $res = $this->service->update($id, $data);

        return $this->response()->withSuccess($res);
    }

    /**
     * 详情
     *
     * @param int $id
     * @return JsonResponse
     */
    public function detail(int $id): JsonResponse
    {
        $res = $this->service->detail($id);

        return $this->response()->withSuccess($res);
    }

    /**
     * 列表
     *
     * @param Category\ListRequest $request
     * @param $model
     * @return JsonResponse
     */
    public function list(Category\ListRequest $request, $model): JsonResponse
    {
        $perPage = $request->input('per_page', 15);

        $res = $this->service->getList($perPage, $model);

        return $this->response()->withSuccess($res);
    }

    /**
     * 详情
     *
     * @param Category\DeleteRequest $request
     * @return JsonResponse
     */
    public function delete(Category\DeleteRequest $request): JsonResponse
    {
        $res = $this->service->delete($request->input('ids'));

        return $this->response()->withSuccess($res);
    }
}
