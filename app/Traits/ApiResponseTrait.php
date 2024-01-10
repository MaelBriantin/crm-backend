<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Illuminate\Support\Collection;

trait ApiResponseTrait
{
    /**
     * Generates a success response in a form of a data array.
     *
     * @param object|array|int|null $data The data to be included in the response.
     * @return JsonResponse The JSON response.
     */
    private function successResponse(object | array | int $data = null): JsonResponse
    {
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }
    
        if (is_array($data)) {
            return response()->json($data, 200);
        }
    
        return response()->json([$data], 200);
    }

    /**
     * @param string $message
     * @param int $status
     * 
     * @return JsonResponse<array>
     * 
     * @throws InvalidArgumentException
     * @throws Exception If $status is within the range 200-299.
     *
     */
    private function errorResponse(string $message, int $status = 400): JsonResponse
    {
        $status = $status ?: 400;

        assert(
            $status <= 200 || $status >= 300,
            'Invalid HTTP status code for error response.'
        );

        return response()->json(['message' => $message], $status);
    }

    /**
     * Returns a JSON response indicating that no match was found with a 404 status code.
     *
     * @return JsonResponse<array>
     *
     */
    private function notFoundResponse(): JsonResponse
    {
        return $this->errorResponse('Not found.', 404);
    }

    /**
     * Returns an empty JSON response indicating success without specific data.
     *
     * @return JsonResponse<array>
     *
     */
    private function emptyResponse(): JsonResponse
    {
        return $this->successResponse([]);
    }
}
