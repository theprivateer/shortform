<?php

namespace App;

use App\Images\Image;
use App\Parsers\HashtagParser;
use Embera\Embera;
use Embera\Formatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use Privateer\Uuid\EloquentUuid;
use Spatie\Tags\HasTags;

class Post extends Model
{
    use EloquentUuid, HasTags, SoftDeletes;

    protected $fillable = ['markdown'];

    public static function boot()
    {
        parent::boot();

        self::saving( function($model) {
            // Oembed
            $embera = new Embera();
            $embera = new Formatter($embera);

            $embera->setTemplate('<div class="embed-{provider_name}">{html}</div>');

            $markdown = $embera->transform($model->markdown);

            // Set up a container for any hashtags that get parsed
            App::singleton('tagqueue', function() {
                return new TagQueue;
            });

            // Markdown
            $environment = Environment::createCommonMarkEnvironment();
            $environment->addInlineParser(new HashtagParser());
            $parser = new DocParser($environment);
            $htmlRenderer = new HtmlRenderer($environment);

            $text = $parser->parse($markdown);
            $model->html = $htmlRenderer->renderBlock($text);
        });

        self::saved( function($model) {
            // Handle hashtag syncing
            $model->syncTags(app('tagqueue')->getTags());
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class);
    }

    public function image()
    {
        return $this->images->first();
    }
}
