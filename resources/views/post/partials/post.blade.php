<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
            <table class="panel-masthead">
                <tbody>
                <tr>
                    @if(empty($hide_identity))
                    <td class="avatar">
                        <a href="{{ route('user.show', $post->user->username) }}">
                            @if($avatar = $post->user->avatar)
                            {!! $avatar->getTag(['w' => 40, 'h' => 40, 'fit' => 'crop'], ['class' => 'img-circle']) !!}
                            @else
                            <img src="/img/default-avatar.png" width="40px" height="40px" class="img-circle">
                            @endif
                        </a>
                    </td>
                    @endif

                    <td>
                        @if(empty($hide_identity))<a href="{{ route('user.show', $post->user->username) }}"><strong>{{ $post->user->username }}</strong></a>@endif
                        @if( $place = $post->place)
                            @if(empty($hide_identity))<br />@endif
                            <a href="{{ route('place.index', $place->id) }}"><i class="fa fa-map-marker"></i> {!! $place->name !!}</a>
                        @endif
                    </td>

                    <td class="text-right">
                        <a href="{{ route('post.show', [$post->user_id, $post->uuid]) }}">{{ $post->created_at->diffForHumans() }}</a>
                    </td>
                </tr>
                </tbody>
            </table>

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


            <div class="panel-footer">
                <div class="clearfix">
                    &nbsp;
                    @if(Auth::check() && Auth::user()->id == $post->user_id)
                        <a href="{{ route('post.edit', [$post->user_id, $post->uuid]) }}" class="pull-right">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>