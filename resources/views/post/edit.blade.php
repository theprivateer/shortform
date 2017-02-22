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

                        <!-- Location Form Input -->
                        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                            <label for="location" class="control-label sr-only">Location:</label>

                            <input id="location" type="text" class="form-control" name="location" value="{{ old('location', ($post->place) ? $post->place->value : null) }}" placeholder="Where are you?">

                            <input type="hidden" name="raw_place" value="{{ old('raw_place', ($post->place) ? $post->place->raw() : null) }}">

                            @if ($errors->has('location'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('location') }}</strong>
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

    <!-- Algolia Search API Client - latest version -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>

    <script src="https://cdn.jsdelivr.net/places.js/1/places.min.js"></script>

    <script>
        var placesAutocomplete = places({
            container: document.querySelector('#location')
        });

        placesAutocomplete.on('change', e => $('[name="raw_place"]').val(JSON.stringify(e.suggestion)));

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

        $(function() {
            // #1 - Search configuration - To replace with your own
            var ALGOLIA_APPID = '{{ env('ALGOLIA_APPLICATION_ID') }}';
            var ALGOLIA_SEARCH_APIKEY = '{{ env('ALGOLIA_SEARCH_KEY') }}';
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
    </script>
@endsection
