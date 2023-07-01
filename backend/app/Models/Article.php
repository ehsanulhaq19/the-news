<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Article extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['headline_placeholder_image'];

    /**
     * Get related properties data with $with parameter.
     *
     * @var array
     */
    protected $with = [
        "source",
        "subSource",
        "category",
        "author",
        "mediaFiles"
    ];

    /**
     * Get the source associated with the article.
     */
    public function source()
    {
        return $this->hasOne(ArticleSource::class, "id", "source_id");
    }

    /**
     * Get the subSource associated with the article.
     */
    public function subSource()
    {
        return $this->hasOne(ArticleSource::class, "id", "sub_source_id");
    }

    /**
     * Get the category associated with the article.
     */
    public function category()
    {
        return $this->hasOne(ArticleCategory::class, "id", "category_id");
    }

    /**
     * Get the author associated with the article.
     */
    public function author()
    {
        return $this->hasOne(ArticleAuthor::class, "id", "author_id");
    }

    /**
     * Get the author associated with the article.
     */
    public function mediaFiles()
    {
        return $this->hasMany(ArticleMedia::class, "article_id", "id");
    }

    /**
     * Placeholder headline image.
     *
     * @return string
     */
    public function getHeadlinePlaceholderImageAttribute()
    {
        $domain = config('app.url');
        return $domain . "/images/placeholders/news_title.png";
    }
}
