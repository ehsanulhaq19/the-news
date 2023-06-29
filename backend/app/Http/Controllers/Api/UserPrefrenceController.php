<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPrefrence;
use Illuminate\Http\Request;
use App\Http\Requests\UserPrefrenceRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Validation\ValidationException;
use App\Repository\UserPrefrenceRepository;

class UserPrefrenceController extends Controller
{
    private UserPrefrenceRepository $userPrefrenceRepository;

    public function __construct(
        UserPrefrenceRepository $userPrefrenceRepository
    ) {
        $this->userPrefrenceRepository = $userPrefrenceRepository;
    }

    /**
     * @OA\Post(
     *      path="/user-prefrences",
     *      operationId="postUserPrefrenceItem",
     *      tags={"UserPrefrence"},
     *      security={ {"sanctum": {} }},
     *      summary="postUserPrefrenceItem",
     *      description="Post UserPrefrence item operation",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            @OA\Property(property="source_ids", type="array", format="array", example="[1]",
     *              @OA\Items(type="integer", example="1")
     *            ),
     *            @OA\Property(property="author_ids", type="array", format="array", example="[1]",
     *              @OA\Items(type="integer", example="1")
     *            ),
     *            @OA\Property(property="category_ids", type="array", format="array", example="[1]",
     *              @OA\Items(type="integer", example="1")
     *            )
     *         ),
     *      ),
     *     @OA\Response(
     *          response=201, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="201"),
     *             @OA\Property(
     *                  property="user_prefrence",
     *                  type="object",
     *                  @OA\Property(property="user",type="object"),
     *                  @OA\Property(property="sources",type="array", 
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id",type="integer", example="1"),
     *                          @OA\Property(property="name",type="string")
     *                      )
     *                  ),
     *                  @OA\Property(property="categories",type="array", 
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id",type="integer", example="1"),
     *                          @OA\Property(property="name",type="string")
     *                      )
     *                  ),
     *                  @OA\Property(property="authors",type="array", 
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id",type="integer", example="1"),
     *                          @OA\Property(property="name",type="string")
     *                      )
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
     *          response=500, description="Internal server error",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="500"),
     *             @OA\Property(property="message", type="string", example="Error message")
     *          )
     *       )
     *  )
     */

    public function postUserPrefrenceItem(UserPrefrenceRequest $request)
    {
        $sourceIds = $request->source_ids;
        $categoryIds = $request->category_ids;
        $authorIds = $request->author_ids;
        $authUser = \Auth::user();

        try {
            $userPrefrence = $this->userPrefrenceRepository->createOrUpdateUserPrefrence(
                $sourceIds,
                $categoryIds,
                $authorIds,
                $authUser
            );

            $statusCode = SymfonyResponse::HTTP_CREATED;
            return response()->json([
                'status' => $statusCode, 
                'user_prefrence' => $userPrefrence 
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
     *      path="/user-prefrences",
     *      operationId="getUserPrefrenceItem",
     *      tags={"UserPrefrence"},
     *      security={ {"sanctum": {} }},
     *      summary="getUserPrefrenceItem",
     *      description="Get user prefrence item",
     *      @OA\RequestBody(
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(
     *                  property="user_prefrence",
     *                  type="object",
     *                  @OA\Property(property="user",type="object"),
     *                  @OA\Property(property="sources",type="array", 
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id",type="integer", example="1"),
     *                          @OA\Property(property="name",type="string")
     *                      )
     *                  ),
     *                  @OA\Property(property="categories",type="array", 
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id",type="integer", example="1"),
     *                          @OA\Property(property="name",type="string")
     *                      )
     *                  ),
     *                  @OA\Property(property="authors",type="array", 
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id",type="integer", example="1"),
     *                          @OA\Property(property="name",type="string")
     *                      )
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

    public function getUserPrefrenceItem(UserPrefrenceRequest $request)
    {
        try {
            $authUser = \Auth::user();
            $userPrefrence = $this->userPrefrenceRepository->getUserPrefrence($authUser);

            if (!$userPrefrence) {
                $statusCode = SymfonyResponse::HTTP_NOT_FOUND;
                return response()->json([
                        'status' => $statusCode, 
                        'message' => "UserPrefrence not found"
                    ], $statusCode
                );
            }

            $statusCode = SymfonyResponse::HTTP_OK;
            return response()->json([
                'status' => $statusCode, 
                'user_prefrence' => $userPrefrence
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