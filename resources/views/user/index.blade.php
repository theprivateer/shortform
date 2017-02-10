@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Post something...</div>

                <form role="form" method="POST" action="{{ route('post.create') }}" id="postForm">
                    {{ csrf_field() }}

                    <input type="hidden" name="images">

                    <div role="media-dropzone">

                        <div class="panel-body dropzone">
                            <div class="dropzone-previews"></div>

                            <!-- Markdown Form Input -->
                            <div class="form-group{{ $errors->has('markdown') ? ' has-error' : '' }}">
                                <label for="markdown" class="control-label sr-only">Markdown:</label>

                                <textarea id="markdown" class="form-control" name="markdown" rows="10">{{ old('markdown') }}</textarea>

                                @if ($errors->has('markdown'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('markdown') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="panel-footer">
                            <!-- Submit field -->
                            <input type="submit" value="Post" class="btn btn-primary">
                            <button type="button" class="image-clickable btn btn-default">Upload Image</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($posts as $post)
        @include('post.partials.post')
    @endforeach

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="text-center">
                {!! $posts->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('head')
    @parent
    <link rel="stylesheet" href="/js/dropzone/dropzone.css">

@endsection

@section('scripts')
    @parent

    <script src="/js/dropzone/dropzone.js"></script>

    <script>
        var imageArray = [];

        Dropzone.autoDiscover = false;

        $('[role="media-dropzone"]').each(function () {
            if (this.dropzone == undefined) {
                var clickable = $('.image-clickable', this);
                var previews = $('.dropzone-previews', this);

                if ( ! $('.post-image', this).length) {
                    $(this).prepend('<img class="img-responsive post-image" />');
                }

                var image = $('.post-image', this);

                $(this).dropzone({
                    url: '{{ route('image.create') }}',
                    addRemoveLinks: true,
                    acceptedFiles: 'image/*',
                    maxFiles: 1,
                    maxFilesize: {{ env('UPLOAD_LIMIT', 10) }},
                    parallelUploads: 1,
                    previewsContainer: previews[0],
                    clickable: clickable[0],
                    init: function () {
                        this.on('addedfile', function (file) {
                        });

                        this.on('sending', function (file, xhr, formData) {
                            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                            formData.append('preview_parameters', '{{ http_build_query(['w' => 560, 'h' => 560, 'fit' => 'fill']) }}');
                            formData.append('user', '{{ Auth::user()->uuid }}');
                        });

                        this.on("success", function (file, responseText) {
                            console.log(responseText);

                            image.attr('src', responseText.preview);

                            imageArray.push(responseText.id);

                            this.removeFile(file);
                        });
                    }
                });
            }
        });

        $('#postForm').on('submit', function(e) {
            e.preventDefault();

            var theForm = this;

            if(imageArray.length)
            {
                $('[name="images"]', this).val(JSON.stringify(imageArray));
            }

            theForm.submit();

        });
    </script>
@endsection