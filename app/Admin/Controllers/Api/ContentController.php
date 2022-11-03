<?php
namespace App\Admin\Controllers\Api;

use App\Admin\Services\ContentService;
use App\Common\Controllers\ApiController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Admin\Requests\Model;

class ContentController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ContentService $service)
    {
        $this->service = $service;
    }

    /**
     * 获取列表
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function nav(Request $request): JsonResponse
    {
        $res = $this->service->getNav();

        return $this->response()->withSuccess($res);
    }

    /**
     * 创建
     *
     * @param Model\CreateRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function create(Model\CreateRequest $request): JsonResponse
    {
        $data = [
            'name' => $request->input('name'),
            'table_name' => $request->input('table_name'),
            'description' => $request->input('description', ''),
            'status' => $request->input('status', 0) == 'on' ? 1: 0,
            'open_category' => $request->input('open_category', 0) == 'on' ? 1: 0,
            'fields' => $request->input('fields', []),
        ];

        $res = $this->service->create($data);

        return $this->response()->withSuccess($res);
    }

    /**
     * 更新
     *
     * @param Model\UpdateRequest $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Model\UpdateRequest $request, $id): JsonResponse
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
     * @param Model\ListRequest $request
     * @param $model
     * @return JsonResponse
     */
    public function list(Model\ListRequest $request, $model): JsonResponse
    {
        $perPage = $request->input('per_page', 15);

        $res = $this->service->getList($perPage, $model);

        return $this->response()->withSuccess($res);
    }

    /**
     * 详情
     *
     * @param Model\DeleteRequest $request
     * @return JsonResponse
     */
    public function delete(Model\DeleteRequest $request): JsonResponse
    {
        $res = $this->service->delete($request->input('ids'));

        return $this->response()->withSuccess($res);
    }
}
