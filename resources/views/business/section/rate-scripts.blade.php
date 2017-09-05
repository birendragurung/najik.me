<script>
    jQuery(document).ready(function () {


        $('input[id^="input-"][role="rating-input"]').filter(
                function(){
                    return this.id.match(/\d+$/);
                })
                .each(function(index, element){
                    this.rating({
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
            });}
        );


        @foreach($businesses as $business)
            $("#input-{{$business->id }}").rating({
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
            /* starCaptions: {
             0.5: '0.5',
             1: '1',
             1.5: '1.5',
             2: '2',
             2.5: '2.5',
             3: '3',
             3.5: '3.5',
             4: '4',
             4.5: '4.5',
             5: '5'
             }*/
        });
        $("#input-{{$business->id }}").click(function () {
            alert('clicked');
            $.post("{{url('/business/rate/'.$business->id)}}",
                    {
                        'rating': $("#rating-{{$business->id}}}").val()
                    },
                    function (data, status) {
                        alert("Data: " + data + "\nStatus: " + status);
                    }
            );
        });
        $('#input-{{$business->id}}').on('rating.change', function (event, value, caption) {
            $.ajax({
                type: "GET",
                url: '{{url('business/rate/'.$business->id )}}',
                data: {rate: $('#input-{{$business->id}}').val()},
                success: function () {
                    alert('You have rated ' + $('#input-{{$business->id}}').val() + ' stars to ' + '{{$business->name}}');
                },
//                dataType: 'json'
            });
        });
        @endforeach
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