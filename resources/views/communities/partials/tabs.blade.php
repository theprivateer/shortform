<ul class="nav panel-nav">
    <li role="presentation" @if($tab == 'publishing') class="active" @endif><a href="{{ route('community.publishing.edit') }}">Publishing</a></li>
    @if(config('shortform.community-mode'))
    <li role="presentation" @if($tab == 'syndication') class="active" @endif><a href="{{ route('community.syndication.edit') }}">Syndication</a></li>
    @endif
    {{--<li role="presentation" @if($tab == 'password') class="active" @endif><a href="{{ route('user.password') }}">Settings</a></li>--}}
</ul>