@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">

                <form role="form" method="POST" action="{{ route('post.create') }}" id="postForm">
                    {{ csrf_field() }}

                    <input type="hidden" name="images">

                    <div role="media-dropzone">

                        <div class="panel-body dropzone">
                            <div class="dropzone-previews"></div>

                            <!-- Markdown Form Input -->
                            <div class="form-group{{ $errors->has('markdown') ? ' has-error' : '' }}">
                                <label for="markdown" class="control-label sr-only">Markdown:</label>

                                <textarea id="markdown" class="form-control" name="markdown" rows="10" placeholder="Post something...">{{ old('markdown') }}</textarea>

                                @if ($errors->has('markdown'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('markdown') }}</strong>
                            </span>
                                @endif
                            </div>

                            <!-- Location Form Input -->
                            <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                <label for="location" class="control-label sr-only">Location:</label>

                                <input id="location" type="text" class="form-control" name="location" value="{{ old('location') }}" placeholder="Where are you?">

                                <input type="hidden" name="raw_place" value="{{ old('raw_place') }}">

                                @if ($errors->has('location'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('location') }}</strong>
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
        @include('post.partials.post', ['hide_identity' => true])
    @endforeach

    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="text-center">
                {!! $posts->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent

    <!-- Algolia Search API Client - latest version -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>

    <script src="https://cdn.jsdelivr.net/places.js/1/places.min.js"></script>
    <script>
        var placesAutocomplete = places({
            container: document.querySelector('#location')
        });

        placesAutocomplete.on('change', e => $('[name="raw_place"]').val(JSON.stringify(e.suggestion)));

        var imageArray = [];

        $(function() {
            // #1 - Search configuration - To replace with your own
            var ALGOLIA_APPID = 'EN1I47F2O7';
            var ALGOLIA_SEARCH_APIKEY = 'a128afb78de8395665b5c5f370066bd0';
            var ALGOLIA_INDEX_NAME = 'tags';
            var NB_RESULTS_DISPLAYED = 5;
            // #2- Algolia API Client Initialization
            var algoliaClient = new algoliasearch(ALGOLIA_APPID, ALGOLIA_SEARCH_APIKEY);
            var index = algoliaClient.initIndex(ALGOLIA_INDEX_NAME);
            var lastQuery = '';
            $('#markdown').textcomplete([
                {
                    // #3 - Regular expression used to trigger the autocomplete dropdown
                    match: /(^|\s)#(\w*(?:\s*\w*))$/,
                    // #4 - Function called at every new keystroke
                    search: function(query, callback) {
                        lastQuery = query;
                        index.search(lastQuery, { hitsPerPage: NB_RESULTS_DISPLAYED })
                            .then(function searchSuccess(content) {
                                if (content.query === lastQuery) {
                                    callback(content.hits);
                                }
                            })
                            .catch(function searchFailure(err) {
                                console.error(err);
                            });
                    },
                    // #5 - Template used to display each result obtained by the Algolia API
                    template: function (hit) {
                        // Returns the highlighted version of the name attribute
                        return '#' + hit._highlightResult.slug.en.value;
                    },
                    // #6 - Template used to display the selected result in the textarea
                    replace: function (hit) {
                        return ' #' + hit.slug.en.trim() + ' ';
                    }
                }
            ], {
                footer: '<div style="text-align: center; display: block; font-size:12px; margin: 5px 0 0 0;">Powered by <a href="http://www.algolia.com"><img src="https://www.algolia.com/assets/algolia128x40.png" style="height: 14px;" /></a></div>'
            });
        });

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