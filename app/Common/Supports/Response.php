<?php
namespace App\Common\Supports;

use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Response
{
    private static Response $instance;

    const CODE_NAME = 'code';

    const MESSAGE_NAME = 'msg';

    /**
     * HTTP Response.
     *
     * @var ResponseFactory
     */
    private ResponseFactory $response;

    /**
     * HTTP status code.
     *
     * @var int
     */
    private int $statusCode = HttpResponse::HTTP_OK;


    /**
     * Create a new class instance.
     *
     * @param ResponseFactory $response
     */
    private function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * 获取实例
     *
     * @return Response
     */
    public static function getInstance(): Response
    {
        if (empty(self::$instance))
            self::$instance = new self(response());
        return self::$instance;
    }

    /**
     * Return a 201 response with the given created resource.
     *
     * @param null $resource
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function withCreated($resource = null): JsonResponse
    {
        $this->statusCode = HttpResponse::HTTP_CREATED;

        return $this->withSuccess($resource);
    }

    /**
     * Make a 204 no content response.
     *
     * @return JsonResponse
     */
    public function withNoContent(): JsonResponse
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_NO_CONTENT
        )->json();
    }

    /**
     * Make a 400 'Bad Request' response.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function withBadRequest(string $message = 'Bad Request'): JsonResponse
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_BAD_REQUEST
        )->withError(HttpResponse::HTTP_BAD_REQUEST, $message);
    }

    /**
     * Make a 401 'Unauthorized' response.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function withUnauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_UNAUTHORIZED
        )->withError(HttpResponse::HTTP_UNAUTHORIZED, $message);
    }

    /**
     * Make a 403 'Forbidden' response.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function withForbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_FORBIDDEN
        )->withError(HttpResponse::HTTP_FORBIDDEN, $message);
    }

    /**
     * Make a 404 'Not Found' response.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function withNotFound(string $message = 'Not Found'): JsonResponse
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_NOT_FOUND
        )->withError(HttpResponse::HTTP_NOT_FOUND, $message);
    }

    /**
     * Make a 429 'Too Many Requests' response.
     *
     * @param string $message
     * @return JsonResponse
     */
    public function withTooManyRequests(string $message = 'Too Many Requests'): JsonResponse
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_TOO_MANY_REQUESTS
        )->withError(HttpResponse::HTTP_TOO_MANY_REQUESTS, $message);
    }

    /**
     * Make a 500 'Internal Server Error' response.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function withInternalServer(string $message = 'Internal Server Error'): JsonResponse
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_INTERNAL_SERVER_ERROR
        )->withError(HttpResponse::HTTP_INTERNAL_SERVER_ERROR, $message);
    }

    /**
     *
     *
     * @param $code
     * @param $message
     * @param null $data
     * @return JsonResponse
     */
    public function withError($code, $message, $data = null): JsonResponse
    {
        $return = [
            self::CODE_NAME  => $code,
            self::MESSAGE_NAME => $message
        ];
        if ($data) {
            $return['data'] = $data;
        }
        return $this->json($return);
    }

    /**
     * 请求成功
     *
     * @param null $data
     * @return JsonResponse
     */
    public function withSuccess($data = null): JsonResponse
    {
        $return = [
            self::CODE_NAME => 200,
            self::MESSAGE_NAME => '请求成功',
        ];
        if ($data) {
            $return['data'] = $data;
        }
        return $this->json($return);
    }

    /**
     * @param array $data
     * @param array $headers
     * @return JsonResponse
     */
    public function json(array $data = [], array $headers = []): JsonResponse
    {
        return $this->response->json($data, $this->statusCode, $headers);
    }

    /**
     * Set HTTP status code.
     *
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode(int $statusCode): Response
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Gets the HTTP status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
}
