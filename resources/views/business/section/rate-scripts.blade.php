<script>
    $(document).ready(function () {
        $('.business-wrapper form i.glyphicon.glyphicon-minus-sign').each(function (i) {
            $(this).click(function () {
                $.ajax({
                    url: 'http://najikme.dev/business/rate/delete/' + $(this).parents('.business-wrapper').attr('business-id'),
                    method: 'get',
                    success: function () {
                        alert('deleted rate');
                    }
                });
            })
        });
    });
</script>
<script>
    jQuery(document).ready(function () {
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
                            url: '/business/rate/' + $(this).parents('.business-wrapper').attr('business-id'),
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
    });

</script>