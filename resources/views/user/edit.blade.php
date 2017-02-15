@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form role="form" method="POST" id="userForm">
                {!! csrf_field() !!}

                <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Profile</h3>
                    </div>

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
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Avatar</h3>
                    </div>

                    <input type="hidden" name="images">

                    <div role="media-dropzone">
                        @if($avatar = Auth::user()->avatar)
                            {!! $avatar->getTag(['w' => 560, 'h' => 560, 'fit' => 'crop'], ['class' => 'avatar-image img-responsive']) !!}
                        @endif

                        <div class="dropzone">
                            <div class="dropzone-previews"></div>
                        </div>


                        <div class="panel-footer">
                            <!-- Submit field -->
                            <input type="submit" value="Save Changes" class="btn btn-primary">
                            <button type="button" class="image-clickable btn btn-default">Upload Image</button>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Update Password</h3>
                    </div>

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
                        <div class="form-group{{ $errors->has('password_conf') ? ' has-error' : '' }}">
                            <label for="password_conf" class="control-label">Confirm New Password:</label>

                            <input id="password_conf" type="password" class="form-control" name="password_conf">

                            @if ($errors->has('password_conf'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_conf') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="panel-footer">
                        <!-- Submit field -->
                        <input type="submit" value="Save Changes" class="btn btn-primary">
                    </div>
                </div>
            </form>
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
                    $(this).prepend('<img class="img-responsive avatar-image" />');
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