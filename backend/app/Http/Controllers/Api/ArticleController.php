<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Validation\ValidationException;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    private ArticleService $articleService;

    public function __construct(
        ArticleService $articleService
    ) {
        $this->articleService = $articleService;
    }

    /**
     * @OA\Get(
     *      path="/articles-by-categories",
     *      operationId="getArticlesByCategoryCollection",
     *      tags={"Article"},
     *      security={ {"sanctum": {} }},
     *      summary="getArticlesByCategoryCollection",
     *      description="Get articles collection",
     *      @OA\RequestBody(
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(
     *                  property="articles",
     *                  type="array", 
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="title",type="string"),
     *                      @OA\Property(property="trail_text",type="string"),
     *                      @OA\Property(property="description",type="string"),
     *                      @OA\Property(property="url",type="string"),
     *                      @OA\Property(property="published_date",type="string"),
     *                      @OA\Property(property="author",type="string"),
     *                      @OA\Property(property="source",type="string"),
     *                      @OA\Property(property="sub_source",type="string"),
     *                      @OA\Property(property="category",type="string")
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

    public function getArticleCollection(ArticleRequest $request)
    {
        try {
            $authUser = \Auth::user();
            $articles = $this->articleService->getUserNewsFeedArticles($authUser);

            $statusCode = SymfonyResponse::HTTP_OK;
            return response()->json([
                'status' => $statusCode, 
                'articles' => $articles
            ], $statusCode);

        } catch (Exception $e) {
            $statusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json([
                'status' => $statusCode, 
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    /**
     * @OA\Get(
     *      path="/articles-search",
     *      operationId="getArticlesBySearchCollection",
     *      tags={"Article"},
     *      security={ {"sanctum": {} }},
     *      summary="getArticlesBySearchCollection",
     *      description="Get articles collection by search",
     *      @OA\Parameter(
     *          name="search_string",
     *          description="Search string...",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="source_ids",
     *          description="Source ids",
     *          example="1,2",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="author_ids",
     *          description="Author ids",
     *          example="1,2",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="category_ids",
     *          description="Category ids",
     *          example="1,2",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="published_date",
     *          description="Published date filter",
     *          example="2023-04-19",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(
     *                  property="articles",
     *                  type="array", 
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="title",type="string"),
     *                      @OA\Property(property="trail_text",type="string"),
     *                      @OA\Property(property="description",type="string"),
     *                      @OA\Property(property="url",type="string"),
     *                      @OA\Property(property="published_date",type="string"),
     *                      @OA\Property(property="author",type="string"),
     *                      @OA\Property(property="source",type="string"),
     *                      @OA\Property(property="sub_source",type="string"),
     *                      @OA\Property(property="category",type="string")
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

    public function getArticleSearchCollection(ArticleRequest $request)
    {
        try {
            $searchString = $request->query("search_string");
            $sourceIds = $request->query("source_ids");
            $authorIds = $request->query("author_ids");
            $categoryIds = $request->query("category_ids");
            $publishedDate = $request->query("published_date");

            $articles = $this->articleService->getArticlesBySearch(
                $searchString,
                $sourceIds ? explode(",", $sourceIds) : [],
                $authorIds ? explode(",", $authorIds) : [],
                $categoryIds ? explode(",", $categoryIds) : [],
                $publishedDate
            );

            $statusCode = SymfonyResponse::HTTP_OK;
            return response()->json([
                'status' => $statusCode, 
                'articles' => $articles
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