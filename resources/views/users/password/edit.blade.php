@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @include('users.partials.tabs', ['tab' => 'password'])

            <div class="panel panel-default has-tabs">
                <form role="form" method="POST">
                    {!! csrf_field() !!}

                    <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                    <div class="panel-body">
                        <!-- Password Form Input -->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">New Password:</label>

                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <!-- Password_conf Form Input -->
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password_confirmation" class="control-label">Confirm New Password:</label>

                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="panel-footer">
                        <!-- Submit field -->
                        <input type="submit" value="Save Changes" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection