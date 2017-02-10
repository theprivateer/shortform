@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Post</div>

                <form role="form" method="POST">
                    {{ csrf_field() }}

                    <input type="hidden" name="uuid" value="{{ $post->uuid }}">

                    @if($image = $post->image())
                        {!! $image->getTag(['w' => 560], ['class' => 'img-responsive']) !!}
                    @endif

                    <div class="panel-body">
                        <!-- Markdown Form Input -->
                        <div class="form-group{{ $errors->has('markdown') ? ' has-error' : '' }}">
                            <label for="markdown" class="control-label sr-only">Markdown:</label>

                            <textarea id="markdown" class="form-control" name="markdown" rows="10">{{ old('markdown', $post->markdown) }}</textarea>

                            @if ($errors->has('markdown'))
                            <span class="help-block">
                                <strong>{{ $errors->first('markdown') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="panel-footer">
                        <!-- Submit field -->
                        <input type="submit" value="Save Changes" class="btn btn-primary">
                        <a href="/home" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>

            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Something, something... Danger Zone!</h3>
                </div>

                <div class="panel-body">
                    <p>Delete this post and all data associated with it.</p>

                    <form role="delete-form" method="POST" action="{{ route('post.delete') }}">
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="DELETE">
                        <input type="hidden" name="post" value="{{ $post->id }}">

                        <!-- Submit field -->
                        <input type="submit" value="Kill it with fire!" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent

    <script src="/js/bootbox.js"></script>

    <script>
        $(document).on('submit', '[role="delete-form"]', function (e) {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to delete this post?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection
