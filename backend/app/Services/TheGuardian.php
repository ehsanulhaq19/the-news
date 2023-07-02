<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Models\ArticleCategory;
use Carbon\Carbon;

class TheGuardian
{
    private $apiKey;

    private $apiEndPoint;

    public function __construct()
    {
        $this->apiEndPoint = \Config::get('services.articles_sources.the_guardian_end_point');
        $this->apiKey = \Config::get('services.articles_sources.the_guardian_api_key');
    }

    public function fetchAllArticles()
    {
        $articleCategories = ArticleCategory::all()->pluck('name');
        
        $articles = [];
        foreach($articleCategories as $articleCategory) {
            $categoryName = strtolower($articleCategory);
            $articles[] = $this->fetchArticleByCategory($categoryName);
        }
        
        return \Arr::flatten($articles, 1);
    }

    public function fetchArticleByCategory(string $categoryName)
    {
        $apiUrl = "$this->apiEndPoint/$categoryName";
        $response = Http::get($apiUrl, [
            'api-key' => $this->apiKey,
            'from-date' => Carbon::now()->toDateString(),
            'show-fields' => 'headline,trailText,byline,firstPublicationDate,shortUrl,thumbnail,bodyText,publication',
            'show-elements' => 'all',
            'page-size' => 20
        ]);

        $articles = [];
        if ($response->successful()) {
            $responseCollection = $response->collect()->toArray();
            $responseArticles = $responseCollection["response"]['results'];

            foreach ($responseArticles as $responseArticle) {
                $articleFields = $responseArticle["fields"];
                $articles[] = [
                    "title" => $articleFields["headline"],
                    "author" => isset($articleFields["byline"]) && $articleFields["byline"] ? $articleFields["byline"] : "Unknown",
                    "trail_text"=> $articleFields["trailText"],
                    "description" => $articleFields["bodyText"],
                    "url" => $articleFields["shortUrl"],
                    "published_date" => $articleFields["firstPublicationDate"],
                    "source" => "The Guardian",
                    "sub_source" => null,
                    "category" => $categoryName,
                    "article_media" => [
                        [
                          "url" => $articleFields["thumbnail"]
                        ]
                    ]
                ];
          }
        }

        return $articles;
    }
}
