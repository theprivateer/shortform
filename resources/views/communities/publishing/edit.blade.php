@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @include('communities.partials.tabs', ['tab' => 'publishing'])

            <div class="panel panel-default has-tabs">
                <div class="panel-body">
                    <p>In order to publish you content to another Shortform community you must first create a new Oauth client.</p>

                    <p>Log in to the other Shortform community and navigate to the Syndation tab in the Community section.</p>

                    <p>Click 'Create New Client' and enter <code>{{ route('community.callback') }}</code> as the Redirect URL.  Enter the resulting credentials below:</p>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Connection Details</h3>
                </div>

                <form role="form" method="POST">
                    {!! csrf_field() !!}
                <div class="panel-body">

                    <input type="hidden" name="id" value="{{ $client->id }}">

                    <!-- Url Form Input -->
                    <div class="form-group{{ $errors->has('base_url') ? ' has-error' : '' }}">
                        <label for="base_url" class="control-label">Base URL:</label>

                        <input id="base_url" type="text" class="form-control" name="base_url" value="{{ old('base_url', $client->base_url) }}">

                        @if ($errors->has('base_url'))
                            <span class="help-block">
                            <strong>{{ $errors->first('base_url') }}</strong>
                        </span>
                        @endif
                    </div>

                    <!-- Client_id Form Input -->
                    <div class="form-group{{ $errors->has('client_id') ? ' has-error' : '' }}">
                        <label for="client_id" class="control-label">Client ID:</label>

                        <input id="client_id" type="text" class="form-control" name="client_id" value="{{ old('client_id', $client->client_id) }}">

                        @if ($errors->has('client_id'))
                            <span class="help-block">
                            <strong>{{ $errors->first('client_id') }}</strong>
                        </span>
                        @endif
                    </div>

                    <!-- Secret Form Input -->
                    <div class="form-group{{ $errors->has('secret') ? ' has-error' : '' }}">
                        <label for="secret" class="control-label">Secret:</label>

                        <input id="secret" type="text" class="form-control" name="secret" value="{{ old('secret', $client->secret) }}">

                        @if ($errors->has('secret'))
                            <span class="help-block">
                            <strong>{{ $errors->first('secret') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="panel-footer">
                    <!-- Submit field -->
                    <input type="submit" value="Save" class="btn btn-primary">
                </div>
                </form>

            </div>

            @if(Auth::user()->client)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Authorisation</h3>
                </div>

                <div class="panel-body">
                    @if(Auth::user()->token)
                        <p>You are currently automatically publishing all new posts to <code>{{ Auth::user()->token->client->base_url }}</code>. To stop, simply remove this authorisation below and/or revoke access within your community account.</p>

                        <form action="{{ route('community.publishing.delete') }}" method="POST" role="delete-form">
                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="id" type="hidden" value="{{ Auth::user()->token->id }}">

                            <!-- Submit field -->
                            <input type="submit" value="Remove Authorisation" class="btn btn-default">

                        </form>
                    @else
                        <p>Now that you have an Oauth client set up you can authenticate with the community and authorise this application to publish to it.</p>

                    <a href="{{ route('community.redirect') }}" class="btn btn-primary">Authenticate with Community</a>
                    @endif
                </div>
            </div>
            @endif

            {{--@if(Auth::user()->token)--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<h3 class="panel-title">Publishing</h3>--}}
                    {{--</div>--}}

                    {{--<div class="panel-body">--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endif--}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent

    <script>
        $(document).on('submit', '[role="delete-form"]', function (e) {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to remove this authorisation?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection
