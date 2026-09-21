<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponseTrait
{
    protected function successResponse(
        mixed $data = null,
        ?string $message = 'Success',
        int $code = 200
    ): JsonResponse {
        return response()->json([
            'success' => true, 
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function createdResponse(mixed $data = null, ?string $message = 'Created successfully.'): JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    protected function noContentResponse(): JsonResponse
    {
        return response()->json(null, 204);
    }

    protected function errorResponse(
        string $message = 'An error occurred.',
        int $code = 400,
        mixed $errors = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }

    protected function deletedResponse(?string $message = 'Deleted successfully.'): JsonResponse
    {
        return response()->json([
            'success' => true, 
            'message' => $message
        ], 200);
    }

    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    protected function forbiddenResponse(string $message = 'You do not have permission to perform this action.'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }

    protected function notFoundResponse(string $message = 'Resource not found.'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    protected function validationErrorResponse(mixed $errors, string $message = 'The given data was invalid.'): JsonResponse
    {
        return $this->errorResponse($message, 422, $errors);
    }

    protected function paginatedResponse(
        LengthAwarePaginator $paginator,
        ?string $resource = null,
        ?string $message = null
    ): JsonResponse {
        $items = $resource
            ? $resource::collection($paginator->getCollection())->resolve()
            : $paginator->items();

        return response()->json([
            'success' => true,
            'message' => $message ?? 'Data retrieved successfully.',
            'data'    => $items,
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ], 200);
    }
}