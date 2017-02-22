<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('post.show', [$post->user_id, $post->uuid]) }}">{{ $post->created_at->diffForHumans() }}</a>


                <ul class="pull-right list-inline">
                    @if(Auth::check() && Auth::user()->id == $post->user_id)
                    <li>
                        <a href="{{ route('post.edit', [$post->user_id, $post->uuid]) }}">Edit</a>
                    </li>
                    @endif
                </ul>
            </div>

            @if($image = $post->image())
                <a href="{{ route('post.show', [$post->user_id, $post->uuid]) }}">
                    {!! $image->getTag('md', ['class' => 'img-responsive']) !!}
                </a>
            @endif

            @if( ! empty($post->html))
            <div class="panel-body">
                {!! $post->html !!}
            </div>
            @endif

            @if( $place = $post->place)
            <div class="panel-footer">
                <a href="{{ route('place.index', $place->id) }}"><i class="fa fa-map-marker"></i> {!! $place->name !!}</a>
            </div>
            @endif
        </div>
    </div>
</div>