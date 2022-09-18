<?php
namespace App\Admin\Controllers\Api;

use App\Common\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use App\Admin\Requests\Model;
use App\Admin\Services\ModelService;

class ModelController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ModelService $service)
    {
        $this->service = $service;
    }

    /**
     * 创建
     *
     * @param Model\CreateRequest $request
     * @return JsonResponse
     */
    public function create(Model\CreateRequest $request): JsonResponse
    {
        $data = [
            'name' => $request->input('name'),
            'table_name' => $request->input('table_name'),
            'description' => $request->input('description', ''),
            'status' => $request->input('status', 0) == 'on' ? 1: 0,
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
     */
    public function update(Model\UpdateRequest $request, $id): JsonResponse
    {
        $data = [
            'name' => $request->input('name'),
            'table_name' => $request->input('table_name'),
            'description' => $request->input('description', ''),
            'status' => $request->input('status', 0) == 'on' ? 1: 0,
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
     * @return JsonResponse
     */
    public function list(Model\ListRequest $request): JsonResponse
    {
        $params = [

        ];
        $perPage = $request->input('per_page', 15);

        $res = $this->service->list($params, $perPage);

        return $this->response()->withSuccess($res);
    }
}
