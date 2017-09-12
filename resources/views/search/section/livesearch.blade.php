<?php
use App\Category;
use Illuminate\Support\Str;

$categories = isset($categories) ? $categories : Category::all();
?>
        <!-- Sidebar Column -->
<div class="col-xs-12 col-md-12 col-lg-12 mb-4">
    <div class="list-group">
        <form class="filter-detail-page" action="/search/results" autocomplete="on" method="get">

            <input id="search-key" type="text" class="form-control col-md-4 list-group-item mb-3 mt-3" placeholder="Keyword" value="{{old('search_key')}}" name="search_key" required="true">
            <select id="search-category" class="form-control list-group-item mb-3 mt-3" name="search_category" required="true">
                <option value="0">All categories</option>

                @foreach($categories as $category)
                    <option value="{{$category->id }}">{{$category->name }}</option>
                @endforeach

            </select>
            <div class="mb-3 mt-3">
                <button type="submit" class="btn btn-primary btn-block mb-3 mt-3">search</button>
            </div>
        </form>
    </div>
    <div class="col-xs-12" id="live-search-container">
        <button id="close-livesearch-btn" class="btn btn-default display-hide mb-2" style="display: none;">
            <i class="fa fa-close"></i>Clear search results
        </button>
        <div id="search-results" class="list-group">
        </div>

    </div>
</div>


@push('footerscripts')
<script>
    var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();
    $('#close-livesearch-btn').click(function () {
        $('#search-results').empty();
        $(this).hide();
    });
    $("#search-key").keyup(function () {

        if (!this.value) {
            $('#search-results').empty();
            $('#close-livesearch-btn').hide();
        }

    });
    function showLiveResults(data) {
        data                = JSON.parse(data);
        var resultContainer = $('#search-results');
        if (Object.keys(data).length > 0) {
            var element = "";
            resultContainer.empty();
            for (var i in data) {
                element += '<a href="/business/' + data[i].id + '" class="list-group-item">' + data[i].name + '</a>';
            }
            resultContainer.append(element);
            $('#close-livesearch-btn').show();

        } else {
            resultContainer.each(function () {
                $(this).fadeOut();
            });
        }

    }

    $(document).ready(function () {
        $("#search-key").keypress(function (e) {

            delay(function () {
                var searchKey = $("#search-key");
                if (searchKey.val().trim().length > 0) {
                    var category  = $("select[id=search_category]").val();
                    var searchKey = $("input[id=search-key]").val();

                    $.ajax(
                            {
                                url: '/lcs/' + searchKey,
                                type: "GET",
                                success: function (data) {
                                    showLiveResults(data);
                                },
                                error: function (data) {
                                    alert(data);
                                }
                            }
                    );
                }
            }, 300);
        });
    });

</script>
@endpush