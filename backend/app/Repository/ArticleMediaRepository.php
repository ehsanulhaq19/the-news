<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\ArticleMedia;
use App\Models\MediaType;

class ArticleMediaRepository
{

    /**
     * Save bulk articles media data into database
     * @param array $articleMediaArray
     */

     public function saveArticleMedias($article, $articleMediaArray)
     {
        if (!$article || !isset($articleMediaArray) || !count($articleMediaArray)) {
            return;
        }

        foreach ($articleMediaArray as $articleMedia) {
            if (isset($articleMedia["url"]) && $articleMedia["url"]) {
                $newArticleMedia = new ArticleMedia();
                $newArticleMedia->url = $articleMedia["url"];
                $newArticleMedia->article_id = $article->id;
                $newArticleMedia->type_id = MediaType::IMAGE_MEDIA_TYPE;
                $newArticleMedia->save();
            }
        }
     }
}
