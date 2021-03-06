@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @include('users.partials.tabs', ['tab' => 'profile'])

            <div class="panel panel-default has-tabs">

                <form role="form" method="POST" >
                    {!! csrf_field() !!}

                    <input type="hidden" name="user" value="{{ Auth::user()->id }}">

                    <div class="panel-body">
                        <!-- Username Form Input -->
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="control-label">Username:</label>

                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username', Auth::user()->username) }}">

                            @if ($errors->has('username'))
                                <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                            @endif
                        </div>

                        <!-- Name Form Input -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Name:</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <!-- Email Form Input -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">Email:</label>

                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
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