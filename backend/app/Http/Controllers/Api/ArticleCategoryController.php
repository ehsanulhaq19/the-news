<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Validation\ValidationException;

class ArticleCategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/article-categories",
     *      operationId="getArticleCategoriesCollection",
     *      tags={"ArticleCategory"},
     *      security={ {"sanctum": {} }},
     *      summary="getArticleCategoriesCollection",
     *      description="Get article categories collection",
     *      @OA\RequestBody(
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(
     *                  property="article_categories",
     *                  type="array", 
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="name",type="string")
     *                  )
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=400, description="Bad request error",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="400"),
     *             @OA\Property(property="message", type="string", example="Error message")
     *          )
     *       ),
     *      @OA\Response(
     *          response=404, description="Not found error",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="404"),
     *             @OA\Property(property="message", type="string", example="Error message")
     *          )
     *       ),
     *      @OA\Response(
     *          response=500, description="Internal server error",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="500"),
     *             @OA\Property(property="message", type="string", example="Error message")
     *          )
     *       )
     *  )
     */

    public function getArticleCategoriesCollection(Request $request)
    {
        try {
            $articleCategories = ArticleCategory::all();

            $statusCode = SymfonyResponse::HTTP_OK;
            return response()->json([
                'status' => $statusCode, 
                'article_categories' => $articleCategories
            ], $statusCode);

        } catch (Exception $e) {
            $statusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json([
                'status' => $statusCode, 
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }
}