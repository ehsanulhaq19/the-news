<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Models\ArticleCategory;
use Carbon\Carbon;

class NewsOrg
{
    private $apiKey;

    private $apiEndPoint;

    public function __construct()
    {
        $this->apiEndPoint = \Config::get('services.articles_sources.news_org_end_point');
        $this->apiKey = \Config::get('services.articles_sources.news_org_api_key');
    }

    public function fetchAllArticles()
    {
        $articleCategories = ArticleCategory::all()->pluck('name');
        
        $articles = [];
        foreach($articleCategories as $articleCategory) {
            $articles[] = $this->fetchArticleByCategory($articleCategory);
        }
        
        return \Arr::flatten($articles, 1);
    }

    public function fetchArticleByCategory(string $categoryName)
    {
        $apiUrl = "$this->apiEndPoint/top-headlines";
        $response = Http::get($apiUrl, [
            'apiKey' => $this->apiKey,
            'category' => $categoryName,
            'from' => Carbon::now()->toDateString(),
            'sortBy' => 'publishedAt',
            'pageSize' => 20
        ]);

        $articles = [];
        if ($response->successful()) {
            $responseCollection = $response->collect();
            $responseArticles = $responseCollection['articles'];
            
            foreach ($responseArticles as $responseArticle) {
                $subSource = $responseArticle["source"] && isset($responseArticle["source"]["name"]) ? 
                        $responseArticle["source"]["name"] : null;
                $articles[] = [
                    "title" => $responseArticle["title"],
                    "author" => $responseArticle["author"] ? $responseArticle["author"] : "Unknown",
                    "trail_text" => $responseArticle["description"],
                    "description" => $responseArticle["content"],
                    "url" => $responseArticle["url"],
                    "published_date" => $responseArticle["publishedAt"],
                    "source" => "News.org",
                    "sub_source" => $subSource,
                    "category" => $categoryName,
                    "article_media" => [
                        [
                            "url" => $responseArticle["urlToImage"]
                        ]
                    ]
                ];
            }
        }

        return $articles;
    }
}
