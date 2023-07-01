<?php
namespace App\Services;

use App\Models\User;
use App\Repository\ArticleRepository;
use App\Repository\UserPrefrenceRepository;

class ArticleService
{
    private ArticleRepository $articleRepository;

    private UserPrefrenceRepository $userPrefrenceRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        UserPrefrenceRepository $userPrefrenceRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->userPrefrenceRepository = $userPrefrenceRepository;
    }

    /**
     * Get user news feed articles
     * @param User $user
     * @return array $articles
     */
    public function getUserNewsFeedArticles(User $user)
    {
        $mostRecentArticlesLimit = 4;
        $mostRecentArticles = $this->articleRepository->getMostRecentArticles($mostRecentArticlesLimit);
        
        $userPrefrence = $this->userPrefrenceRepository->getUserPrefrence($user);
        if ($userPrefrence) {
            $articles = $this->articleRepository->getArticleByCategories(
                $userPrefrence->source_ids,
                $userPrefrence->author_ids,
                $userPrefrence->category_ids
            );
        } else {
            $articles = $this->articleRepository->getArticleByCategories();
        }
        $articles["recent"] = $mostRecentArticles;

        return $articles;
    }

    /**
     * Get articles by provided filters
     * @param string $searchString
     * @param array $sourceIds
     * @param array $authorIds
     * @param array $categoryIds
     * @param string $publishedDate
     * @return array $articles
     */

    public function getArticlesBySearch(
        $searchString,
        $sourceIds,
        $authorIds,
        $categoryIds,
        $publishedDate
    ) {
        return $this->articleRepository->getArticlesBySearch(
            $searchString,
            $sourceIds,
            $authorIds,
            $categoryIds,
            $publishedDate
        );
    }
}