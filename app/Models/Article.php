<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'publisher_name',
        'image_path',
        'content',
    ];

    /**
     * Get the category that this article belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user (admin) who uploaded the article.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a clean text teaser for the article, handling both JSON (Editor.js) and plain text content.
     */
    public function getTeaserAttribute()
    {
        $content = $this->content;
        
        // Convert non-breaking spaces to standard spaces
        $content = str_replace('&nbsp;', ' ', $content);
        
        if (str_starts_with(trim($content), '{')) {
            $decoded = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($decoded['blocks'])) {
                $textParts = [];
                foreach ($decoded['blocks'] as $block) {
                    if ($block['type'] === 'paragraph' && isset($block['data']['text'])) {
                        $textParts[] = strip_tags($block['data']['text']);
                    }
                }
                $teaserText = implode(' ', $textParts);
                return html_entity_decode($teaserText, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
        }
        
        $teaserText = strip_tags($content);
        // Replace unicode non-breaking space character with standard space
        $teaserText = str_replace("\xc2\xa0", ' ', $teaserText);
        return html_entity_decode($teaserText, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
