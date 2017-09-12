<script>
    $(document).ready(function () {
        $('.business-profile-wrapper form i.glyphicon.glyphicon-minus-sign').each(function (i) {
            $(this).click(function () {
                $.ajax({
                    url: '/business/rate/delete/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                    method: 'get',
                    success: function () {
                        alert('deleted rate');
                    }
                });
            });
        });

        $('input[role="rating-input"]').each(function (index, element) {
                $(this).rating({
                    starCaptions: function (val) {
                        if (val < 3) {
                            return val;
                        } else {
                            return 'high';
                        }
                    },
                    starCaptionClasses: function (val) {
                        if (val < 3) {
                            return 'label label-danger';
                        } else {
                            return 'label label-success';
                        }
                    },
                    hoverOnClear: false
                });
                $(this).on('rating.change', function (event, value, caption) {
                    $.ajax({
                        type: "GET",
                        url: '/business/rate/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                        data: {rate: $(this).val()},
                        success: function (message) {
                            alert(message);
                        }
//                dataType: 'json'
                    });
                });
            }
        );

        $("#input-21f").rating({
            starCaptions: function (val) {
                if (val < 3) {
                    return val;
                } else {
                    return 'high';
                }
            },
            starCaptionClasses: function (val) {
                if (val < 3) {
                    return 'label label-danger';
                } else {
                    return 'label label-success';
                }
            },
            hoverOnClear: false
        });
        var $inp = $('#rating-input');

        $inp.rating({
            min: 0,
            max: 5,
            step: 1,
            size: 'lg',
            showClear: false
        });

        $('#btn-rating-input').on('click', function () {
            $inp.rating('refresh', {
                showClear: true,
                disabled: !$inp.attr('disabled')
            });
        });

        $('.btn-danger').on('click', function () {
            $("#kartik").rating('destroy');
        });

        $('.btn-success').on('click', function () {
            $("#kartik").rating('create');
        });

        $inp.on('rating.change', function () {
            alert($('#rating-input').val());
        });

        //review codes

            var formEl = '<form id="business-review-edit-form" class="form-horizontal" action="/review/'+ $('.business-profile-wrapper').attr('business-id')+ '" method="post">' +
                '                                                {{csrf_field()}}' +
                '                                                <div class="form-group user-review-form-group">\n' +
                '                                                    <label for="user-review-box" class="col-md-4 control-label"></label>\n' +
                '                                                    <div class="col-md-6">\n' +
                '                                                        <textarea type="text" id="user-review-box" name="review_comment" class="form-control mb-3" required></textarea>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="col-md-6 col-md-offset-4">\n' +
                '                                                        <button type="submit" href="#" class="btn btn-success">Edit Review</button>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </form>';
        $('#business-review-form').submit(function (e) {
            e.preventDefault();
            $.ajax(
                {
                    url: '/review/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                    type: 'post',
                    data: {
                        'review_comment': $('#user-review-box').val(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        var el =
                                '<div class="user-review" user-id=' + data.data.userId + '>' +
                                '<p>' + data.data.comment + '</p> ' +
                                '<small class="text-muted">Posted by ' + data.data.username + ' on ' + data.data.time + '</small>' +
                                '<i class="fa fa-minus-circle delete-review"></i>' +
                                '<i class="fa fa-edit edit-review"></i>' +
                                '<hr>' +
                                '</div>';

                        $('.user-review').each(function (i, e) {
                            if ($(this).attr('user-id') == data.data.userId) {
                                $(this).hide();
                            }
                        });

                        if ($('.user-review').length < 1) {
                            $('.no-reviews').html('No reviews');
                        } else {
                            $('.no-reviews').html("");
                        }
                        $("#business-reviews").append(el);
                        var deleteReview = $('.delete-review');
                        deleteReview.click(function (e) {
                            $.ajax({
                                url: '/business/review/delete/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                                method: 'get',
                                success: function () {
                                    deleteReview.parents('.user-review').remove();
                                    $('#business-review-form').show();
                                },
                                error: function (err) {
                                    console.log(err);
                                }
                            });
                        });
                        var editReview = $('.edit-review');
                        editReview.click(function (e) {
                            if($('#business-review-edit-form').length === 0 ) {
                                $('.user-review[user-id={{Auth::id()}}]>hr').before($(formEl));
                                $('#business-review-edit-form').submit(function (e) {
                                    e.preventDefault();
                                    $.ajax(
                                        {
                                            url: '/review/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                                            type: 'post',
                                            data: {
                                                'review_comment': $('#user-review-box').val(),
                                                '_token': $('input[name=_token]').val()
                                            },
                                            success: function (data) {
                                                var el =
                                                        '<div class="user-review" user-id=' + data.data.userId + '>' +
                                                        '<p>' + data.data.comment + '</p> ' +
                                                        '<small class="text-muted">Posted by ' + data.data.username + ' on ' + data.data.time + '</small>' +
                                                        '<i class="fa fa-minus-circle delete-review"></i>' +
                                                        '<i class="fa fa-edit edit-review"></i>' +
                                                        '<hr>' +
                                                        '</div>';

                                                $('.user-review').each(function (i, e) {
                                                    if ($(this).attr('user-id') == data.data.userId) {
                                                        $(this).remove();
                                                    }
                                                });

                                                if ($('.user-review').length == 0) {
                                                    $('.no-reviews').html('No reviews');
                                                } else {
                                                    $('.no-reviews').html("");
                                                }
                                                $("#business-reviews").append(el);
                                                var deleteReview = $('.delete-review');
                                                deleteReview.click(function (e) {
                                                    $.ajax({
                                                        url: '/business/review/delete/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                                                        method: 'get',
                                                        success: function () {
                                                            deleteReview.parents('.user-review').remove();
                                                            $('#business-review-form').show();
                                                        },
                                                        error: function (err) {
                                                            console.log(err);
                                                        }
                                                    });
                                                });
                                                var editReview = $('.edit-review');
                                                editReview.click(function (e) {
                                                    if($('#business-review-edit-form').length === 0 ) {
                                                        $('.user-review[user-id={{Auth::id()}}] .edit-review').after(formEl);
                                                    }
                                                    if ($('#business-review-edit-form').is(':visible')) {
                                                        $('#business-review-edit-form').hide();

                                                    } else {
                                                        $('#business-review-edit-form').show();
                                                    }
                                                });
                                                $('textarea[name=review_comment]').val('');
                                                $('input[name =_token]').attr('value', data.csrf_token);
                                                console.log($('input[name=_token]').val());
                                                console.log(data.csrf_token);
                                                $('#user-review-box').parent('.user-review-form-group').hide();
                                            },
                                            error: function (err) {
                                                console.log(err);
                                            }
                                        }
                                    );
                                });

                            }
                            if ($('#business-review-edit-form').is(':visible')) {
                                $('#business-review-edit-form').hide();
                            } else {
                                $('#business-review-edit-form').show();
                            }
                        });
                        $('input[name =_token]').attr('value', data.csrf_token);
                        console.log($('input[name=_token]').val());
                        console.log(data.csrf_token);
                        $('#user-review-box').parent('.user-review-form-group').hide();
                        $('#user-review-box').parent('.user-review-form-group').val("");
                        $('#business-review-form').hide();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                }
            );
        });

        $('#business-review-edit-form').submit(function (e) {
            e.preventDefault();
            $.ajax(
                {
                    url: '/review/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                    type: 'post',
                    data: {
                        'review_comment': $('#user-review-box').val(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        var el =
                                '<div class="user-review" user-id=' + data.data.userId + '>' +
                                '<p>' + data.data.comment + '</p> ' +
                                '<small class="text-muted">Posted by ' + data.data.username + ' on ' + data.data.time + '</small>' +
                                '<i class="fa fa-minus-circle delete-review"></i>' +
                                '<i class="fa fa-edit edit-review"></i>' +
                                '<hr>' +
                                '</div>';

                        $('.user-review').each(function (i, e) {
                            if ($(this).attr('user-id') == data.data.userId) {
                                $(this).remove();
                            }
                        });

                        if ($('.user-review').length == 0) {
                            $('.no-reviews').html('No reviews');
                        } else {
                            $('.no-reviews').html("");
                        }
                        $("#business-reviews").append(el);
                        var deleteReview = $('.delete-review');
                        deleteReview.click(function (e) {
                            $.ajax({
                                url: '/business/review/delete/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                                method: 'get',
                                success: function () {
                                    deleteReview.parents('.user-review').remove();
                                    $('#business-review-form').show();
                                },
                                error: function (err) {
                                    console.log(err);
                                }
                            });
                        });
                        var editReview = $('.edit-review');
                        editReview.click(function (e) {
                            if($('#business-review-edit-form').length === 0 ) {
                                $('.user-review[user-id={{Auth::id()}}] .edit-review').after(formEl);
                            }
                            if ($('#business-review-edit-form').is(':visible')) {
                                $('#business-review-edit-form').hide();

                            } else {
                                $('#business-review-edit-form').show();
                            }
                        });
                        $('textarea[name=review_comment]').val('');
                        $('input[name =_token]').attr('value', data.csrf_token);
                        console.log($('input[name=_token]').val());
                        console.log(data.csrf_token);
                        $('#user-review-box').parent('.user-review-form-group').hide();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                }
            );
        });

        var deleteReview = $('.delete-review');
        deleteReview.click(function (e) {
            $.ajax({
                url: '/business/review/delete/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                method: 'get',
                success: function () {
                    deleteReview.parents('.user-review').remove();
                    $('#business-review-form').show();
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
        $('#business-review-edit-form').hide();
        var editReview = $('.edit-review');
        editReview.click(function (e) {
            if($('#business-review-edit-form').length === 0 ) {
                $('.user-review[user-id={{Auth::id()}}]>hr').before($(formEl));
                $('#business-review-edit-form').submit(function (e) {
                    e.preventDefault();
                    $.ajax(
                        {
                            url: '/review/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                            type: 'post',
                            data: {
                                'review_comment': $('#user-review-box').val(),
                                '_token': $('input[name=_token]').val()
                            },
                            success: function (data) {
                                var el =
                                        '<div class="user-review" user-id=' + data.data.userId + '>' +
                                        '<p>' + data.data.comment + '</p> ' +
                                        '<small class="text-muted">Posted by ' + data.data.username + ' on ' + data.data.time + '</small>' +
                                        '<i class="fa fa-minus-circle delete-review"></i>' +
                                        '<i class="fa fa-edit edit-review"></i>' +
                                        '<hr>' +
                                        '</div>';

                                $('.user-review').each(function (i, e) {
                                    if ($(this).attr('user-id') == data.data.userId) {
                                        $(this).remove();
                                    }
                                });

                                if ($('.user-review').length == 0) {
                                    $('.no-reviews').html('No reviews');
                                } else {
                                    $('.no-reviews').html("");
                                }
                                $("#business-reviews").append(el);
                                var deleteReview = $('.delete-review');
                                deleteReview.click(function (e) {
                                    $.ajax({
                                        url: '/business/review/delete/' + $(this).parents('.business-profile-wrapper').attr('business-id'),
                                        method: 'get',
                                        success: function () {
                                            deleteReview.parents('.user-review').remove();
                                            $('#business-review-form').show();
                                        },
                                        error: function (err) {
                                            console.log(err);
                                        }
                                    });
                                });
                                var editReview = $('.edit-review');
                                editReview.click(function (e) {
                                    if($('#business-review-edit-form').length === 0 ) {
                                        $('.user-review[user-id={{Auth::id()}}] .edit-review').after(formEl);
                                    }
                                    if ($('#business-review-edit-form').is(':visible')) {
                                        $('#business-review-edit-form').hide();

                                    } else {
                                        $('#business-review-edit-form').show();
                                    }
                                });
                                $('textarea[name=review_comment]').val('');
                                $('input[name =_token]').attr('value', data.csrf_token);
                                console.log($('input[name=_token]').val());
                                console.log(data.csrf_token);
                                $('#user-review-box').parent('.user-review-form-group').hide();
                            },
                            error: function (err) {
                                console.log(err);
                            }
                        }
                    );
                });

            }
            if ($('#business-review-edit-form').is(':visible')) {
                $('#business-review-edit-form').hide();

            } else {
                $('#business-review-edit-form').show();
            }
        });
    });

</script>