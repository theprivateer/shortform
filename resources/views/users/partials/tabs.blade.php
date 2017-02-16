<ul class="nav panel-nav">
    <li role="presentation" @if($tab == 'profile') class="active" @endif><a href="{{ route('user.edit') }}">Profile</a></li>
    <li role="presentation" @if($tab == 'avatar') class="active" @endif><a href="{{ route('user.avatar') }}">Avatar</a></li>
    <li role="presentation" @if($tab == 'password') class="active" @endif><a href="{{ route('user.password') }}">Password</a></li>
</ul>