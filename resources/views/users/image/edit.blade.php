@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                @include('users.partials.tabs', ['tab' => 'avatar'])

                <div class="panel panel-default has-tabs">

                    <form role="form" method="POST" id="userForm">
                        {!! csrf_field() !!}

                        <input type="hidden" name="user" value="{{ Auth::user()->id }}">

                        <input type="hidden" name="images">

                        <div role="media-dropzone">
                            <div class="panel-body">

                                @if($avatar = Auth::user()->avatar)
                                    {!! $avatar->getTag(['w' => 560, 'h' => 560, 'fit' => 'crop'], ['class' => 'avatar-image img-responsive']) !!}
                                @endif
                            </div>

                            <div class="dropzone">
                                <div class="dropzone-previews"></div>
                            </div>


                            <div class="panel-footer">
                                <!-- Submit field -->
                                <input type="submit" value="Save Changes" class="btn btn-primary">
                                <button type="button" class="image-clickable btn btn-default">Upload Image</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        var imageArray = [];

        Dropzone.autoDiscover = false;

        $('[role="media-dropzone"]').each(function () {
            if (this.dropzone == undefined) {
                var clickable = $('.image-clickable', this);
                var previews = $('.dropzone-previews', this);

                if ( ! $('.avatar-image', this).length) {
                    $('.panel-body', this).prepend('<img class="img-responsive avatar-image" />');
                }

                var image = $('.avatar-image', this);

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
                            formData.append('preview_parameters', '{{ http_build_query(['w' => 560, 'h' => 560, 'fit' => 'crop']) }}');
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

        $('#userForm').on('submit', function(e) {
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