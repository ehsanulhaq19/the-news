<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\ArticleAuthor;
use App\Models\ArticleCategory;
use App\Models\ArticleSource;
use App\Repository\ArticleMediaRepository;
use Carbon\Carbon;

class ArticleRepository
{

    private ArticleMediaRepository $articleMediaRepository;

    public function __construct(
        ArticleMediaRepository $articleMediaRepository
    ) {
        $this->articleMediaRepository = $articleMediaRepository;
    }

    /**
     * Save bulk articles data into database
     * @param array $articles
     */

     public function saveArticles($articles)
     {
        if (!isset($articles) || !count($articles)) {
            return;
        }

        foreach ($articles as $article) {
            $this->saveArticle($article);
        }
     }

     /**
     * Save single article data into database
     * @param array $articles
     */
     public function saveArticle($article)
     {
        try {
            DB::beginTransaction();

            $articleSubSource = null;
            if (isset($article["sub_source"]) && $article["sub_source"]) {
                $articleSubSource = ArticleSource::firstOrNew(["name" => $article["sub_source"]]);
                $articleSubSource->save();
            }

            $articleCategory = ArticleCategory::firstOrNew(["name" => $article["category"]]);
            $articleCategory->save();
            $articleSource = ArticleSource::firstOrNew(["name" => $article["source"]]);
            $articleSource->save();
            $articleAuthor = ArticleAuthor::firstOrNew(["name" => $article["author"]]);
            $articleAuthor->save();

            $newArticle = Article::where([
                "title" => $article['title'],
                "source_id" => $articleSource->id,
                "category_id" => $articleCategory->id,
                "author_id" => $articleAuthor->id
            ])->first();

            if (!$newArticle) {
                $newArticle = new Article();
                $newArticle->title = $article['title'];
                $newArticle->trail_text = $article['trail_text'];
                $newArticle->description = $article['description'];
                $newArticle->url = $article['url'];
                $newArticle->published_date = $article['published_date'] ? Carbon::parse($article['published_date']) : null;
                $newArticle->author_id = $articleAuthor->id;
                $newArticle->source_id = $articleSource->id;
                $newArticle->sub_source_id = $articleSubSource ? $articleSubSource->id : null;
                $newArticle->category_id = $articleCategory->id;
                $newArticle->save();
    
                if (isset($article["article_media"]) && count($article["article_media"])) {
                    $this->articleMediaRepository->saveArticleMedias($newArticle, $article["article_media"]);
                }
            }

            DB::commit();
        }
        catch(Exception|Error $exception) {
            DB::rollBack();
        }
     }

     /**
      * Get articles by categories
      * @return array $articles
      */

      public function getArticleByCategories($sourceIds=null, $authorIds=null, $categoryIds=null)
      {
          if ($categoryIds) {
            $categories = ArticleCategory::whereIn("id", $categoryIds)->get();
          } else {
            $categories = ArticleCategory::all();
          }

          $articles = [];
          foreach ($categories as $category) {
              $categoryName = strtolower($category->name);
              $articles[$categoryName] = $this->getArticleByFilters($category->id, $sourceIds, $authorIds);
          }

          return $articles;
      }

      /**
      * Get article by categoryId
      * @param int $categoryId
      * @return array $articles
      */

      public function getArticleByFilters($categoryId, $sourceIds=null, $authorIds=null)
      {
        $articlesQuery = Article::where("category_id", $categoryId);
        
        if ($sourceIds || $authorIds) {
            $articlesQuery = $articlesQuery->where(function ($query) use ($sourceIds, $authorIds){
                if ($sourceIds) {
                    $query = $query->whereIn("source_id", $sourceIds);
                    $query = $query->orWhereIn("sub_source_id", $sourceIds);
                }
                if ($authorIds) {
                    $query = $query->orWhereIn("author_id", $authorIds);
                }

                return $query;
            });
        }

        $articles = $articlesQuery->orderBy("published_date", "desc")
                                    ->limit(5)
                                    ->get();

        return $articles;
      }

      /**
      * Get most recent published articles
      * @param int $limit
      * @return array $articles
      */

      public function getMostRecentArticles($limit=4) 
      {
        $articles = Article::orderBy("published_date", "desc")
            ->limit($limit)
            ->get();

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
        $articlesQuery = Article::select("*");
        if ($searchString) {
            $articlesQuery = $articlesQuery->where("title", "like", "%" . $searchString .  "%" );
        }

        if ($sourceIds) {
            $articlesQuery = $articlesQuery->where(function($query) use ($sourceIds) {
                return $query->whereIn("source_id", $sourceIds)
                        ->orWhereIn("source_id", $sourceIds);
            });
        }

        if ($authorIds) {
            $articlesQuery = $articlesQuery->whereIn("author_id", $authorIds);
        }

        if ($categoryIds) {
            $articlesQuery = $articlesQuery->whereIn("category_id", $categoryIds);
        }

        if ($publishedDate) {
            $articlesQuery = $articlesQuery->whereDate("published_date", $publishedDate);
        }

        return $articlesQuery->orderBy("published_date", "desc")->get();
    }
}
