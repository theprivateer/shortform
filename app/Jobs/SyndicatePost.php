<?php

namespace App\Jobs;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyndicatePost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Post
     */
    private $post;

    /**
     * Create a new job instance.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->post->user;

        if($token = $user->token)
        {
            // Syndicate!
            $data = [
                'source'    => route('post.show', [$this->post->user_id, $this->post->uuid]),
                'uuid'      => $this->post->uuid,
                'markdown'  => $this->post->markdown,
            ];

            if($image = $this->post->image())
            {
                $data['image'] = [
                    'lg'    => $image->getPath('lg'),
                    'md'    => $image->getPath('md'),
                    'sm'    => $image->getPath('sm'),
                ];
            }

            if($place = $this->post->place)
            {
                $data['place'] = [
                    'object_id' => $place->object_id,
                    'name'      => $place->name,
                    'value'     => $place->value,
                    'latitude'  => $place->latitude,
                    'longitude' => $place->longitude
                ];
            }

            // Now send it...
            $http = new \GuzzleHttp\Client;

            try
            {
                $response = $http->post($token->client->base_url . '/api/community/post',
                    [
                        'headers' => [
                            'Authorization'      => 'Bearer '. $token->access_token
                        ],
                        'form_params'   => $data
                    ]
                    );
            } catch (\Exception $e)
            {
            }
        }

        return;
    }
}
