<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPrefrence extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        "source_ids" => "array",
        "category_ids" => "array",
        "author_ids" => "array"
    ];

    /**
     * Get related properties data with $with parameter.
     *
     * @var array
     */
    protected $with = [
        "user"
    ];

    /*
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'sources',
        'categories',
        'authors'
    ];

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the author associated with the article.
     */
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    /**
     * Get the sources associated with the user prefrence.
     */
    public function getSourcesAttribute()
    {
        if ($this->source_ids) {
            return ArticleSource::whereIn("id", $this->source_ids)->get();
        }
    }

    /**
     * Get the authors associated with the user prefrence.
     */
    public function getAuthorsAttribute()
    {
        if ($this->author_ids) {
            return ArticleAuthor::whereIn("id", $this->author_ids)->get();
        }
    }

    /**
     * Get the categories associated with the user prefrence.
     */
    public function getCategoriesAttribute()
    {
        if ($this->category_ids) {
            return ArticleCategory::whereIn("id", $this->category_ids)->get();
        }
    }
}
