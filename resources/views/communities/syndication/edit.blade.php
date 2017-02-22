@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @include('communities.partials.tabs', ['tab' => 'syndication'])

            <div class="panel panel-default has-tabs">
                <div class="panel-body">
                    <p>When setting up a new publishing client, the base URL for this community is <code>{{ url('') }}</code></p>
                </div>
            </div>

            <passport-clients></passport-clients>

            <passport-authorized-clients></passport-authorized-clients>
        </div>
    </div>
</div>
@endsection