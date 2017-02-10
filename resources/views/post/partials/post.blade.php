<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('post.show', $post->uuid) }}">{{ $post->created_at->diffForHumans() }}</a>
                @if(Auth::check() && Auth::user()->id == $post->user_id)
                    <a href="{{ route('post.edit', $post->uuid) }}" class="pull-right">Edit</a>
                @endif
            </div>

            @if($image = $post->image())
                <a href="{{ route('post.show', $post->uuid) }}">
                    {!! $image->getTag(['w' => 560], ['class' => 'img-responsive']) !!}
                </a>
            @endif

            @if( ! empty($post->html))
            <div class="panel-body">
                {!! $post->html !!}
            </div>
            @endif
        </div>
    </div>
</div>