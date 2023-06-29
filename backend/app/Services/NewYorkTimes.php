<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Models\ArticleCategory;
use Carbon\Carbon;

class NewYorkTimes
{
    private $apiKey;

    private $apiEndPoint;

    private $hostUrl;

    public function __construct()
    {
        $this->apiEndPoint = \Config::get('services.articles_sources.new_york_times_end_point');
        $this->apiKey = \Config::get('services.articles_sources.new_york_times_api_key');
        $this->hostUrl = \Config::get('services.articles_sources.new_york_times_host_url');
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
        $apiUrl = "$this->apiEndPoint/svc/search/v2/articlesearch.json";
        $currentDate = Carbon::now()->toDateString();
        $response = Http::get($apiUrl, [
            'api-key' => $this->apiKey,
            'fq' => 'news_desk:("' . $categoryName . '") AND pub_date:("' . $currentDate . '")'
        ]);

        $articles = [];
        if ($response->successful()) {
            $responseCollection = $response->collect()->toArray();
            $responseArticles = $responseCollection["response"]["docs"];

            foreach ($responseArticles as $responseArticle) {
                $title = isset($responseArticle["headline"]) && isset($responseArticle["headline"]["main"]) ?
                        $responseArticle["headline"]["main"] : "";
                $author = isset($responseArticle["byline"]) && isset($responseArticle["byline"]["original"]) ?
                        $responseArticle["byline"]["original"] : "Unknown";

                $articleMedia = [];

                if (isset($responseArticle["multimedia"])) {
                    $index = 0;
                    foreach ($responseArticle["multimedia"] as $multimedia) {
                        $articleMedia[] = [
                            "url" => $this->hostUrl . "/" . $multimedia["url"]
                        ];
                        $index++;

                        //get max of 3 media files
                        if ($index === 3) {
                            break;
                        }
                    }
                }
                
                $articles[] = [
                    "title" => $title,
                    "author" => $author,
                    "trail_text"=> $responseArticle["abstract"],
                    "description" => $responseArticle["lead_paragraph"],
                    "url" => $responseArticle["web_url"],
                    "published_date" => $responseArticle["pub_date"],
                    "source" => "New York Times",
                    "sub_source" => null,
                    "category" => $categoryName,
                    "article_media" => $articleMedia
                ];
            }
        }

        return $articles;
    }
}
