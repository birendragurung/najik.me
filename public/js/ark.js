var ArkAdmin = new (function ($) {
    "use strict";

    /**
     * Initialise the ArkAdmin theme
     * @param charts
     */
    this.init = function (charts) {
        initDataTableBootstrapSupport();
        initControls();
        initGalleryUpload();
        initDatePickers();
        initMenus();
        initSearchForm();
        //init code highlighter
        if (typeof prettyPrint === "function"){
            prettyPrint();
        }
        initCharts(charts);
        updateContentHeight();
        $('body').resize(function (){
            updateContentHeight();
        });
        initMaps();
        initCKEditor()
    };

    //Real time chart data
    var data = [],
        totalPoints = 300;

    function getRandomData() {

        if (data.length > 0){
            data = data.slice(1);
        }

        // Do a random walk

        while (data.length < totalPoints) {

            var prev = data.length > 0 ? data[data.length - 1] : 50,
                y = prev + Math.random() * 10 - 5;

            if (y < 0) {
                y = 0;
            } else if (y > 100) {
                y = 100;
            }

            data.push(y);
        }

        // Zip the generated y values with the x values

        var res = [];
        for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]])
        }

        return res;
    }

    /**
     * Update the height of the content to match the window size
     */
    function updateContentHeight(){
        var windowHeight = $(window).height();
        var navHeight = $('.navbar-main').height();
        $('.content').css('min-height', (windowHeight - navHeight-1) + "px");
    }

    function initSearchForm(){
        $('.search').on('click', '.btn-search', function (event){
            event.preventDefault();
            $(this).parents('.search').toggleClass('active');
        });
    }

    /**
     * Init examples
     * - This method is for demo purposes only and should be removed in production code
     * - Illustrates how to initialize various plugins on the page
     */
    this.initExamples = function (){
        //Nested Lists
        if ($('#nestable').length){
            var updateOutput = function(e)
            {
                var list   = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };
            // activate Nestable for each list
            $('#nestable').nestable({ group: 1 }).on('change', updateOutput);
            $('#nestable2').nestable({ group: 1 }).on('change', updateOutput);
            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));
            $('#nestable-menu').on('click', function(e)
            {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });
        }

        //layout option handle
        $('#layout_options .options-handle').on('click', function(event){
            event.preventDefault();
            var open = $('#layout_options').hasClass('open');
            if (open){
                $('#layout_options').animate({
                    right: "-180px"
                }).removeClass('open');
            }else{
                $('#layout_options').animate({
                    right: "0px"
                }).addClass('open');
            }
        });
        $('#layout_options #fixed_container').on('click', function(event){
            if ($(event.target).prop('checked')){
                $('.wrapper').addClass('container');
            }else{
                $('.wrapper').removeClass('container');
            }
        });
        $('#layout_options #fixed_header').on('click', function(event){
            if ($(event.target).prop('checked')){
                $('body').addClass('fixed_header');
            }else{
                $('body').removeClass('fixed_header');
            }
        });
        $('#layout_options #fixed_menu').on('click', function(event){
            if ($(event.target).prop('checked')){
                $('body').addClass('fixed_menu');
            }else{
                $('body').removeClass('fixed_menu');
            }
        });

        //enable select box on checkbox click
        $(':checkbox').on( "click", function() {
            $(this).parent().nextAll('select').select2("enable", this.checked );
        });

        // update pie charts at random
        setInterval(function () {
            if ($('.pie-chart').length){
                $('.pie-chart').last().data('easyPieChart').update(Math.floor(100 * Math.random()));
            }
        }, 5000);

        // popover demo
        $("[data-toggle=popover]")
            .popover({container:'body'});

        // button state demo
        $('.ark-ex-loading')
            .click(function () {
                var btn = $(this);
                btn.button('loading');
                setTimeout(function () {
                    btn.button('reset');
                }, 3000);
            });

        // Calendar
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        if ($('#calendar').length){
            var calendar = $('#calendar').fullCalendar({
                lang: 'es',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                selectable: true,
                editable: true,
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');
                    if (title) {
                        calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                            true // make the event "stick"
                        );
                    }
                    calendar.fullCalendar('unselect');
                },
                events: [
                    {
                        title: 'All Day Event',
                        start: new Date(y, m, 1)
                    },
                    {
                        title: 'Long Event',
                        start: new Date(y, m, d-5),
                        end: new Date(y, m, d-2)
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: new Date(y, m, d-3, 16, 0),
                        allDay: false
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: new Date(y, m, d+4, 16, 0),
                        allDay: false
                    },
                    {
                        title: 'Meeting',
                        start: new Date(y, m, d, 10, 30),
                        allDay: false
                    },
                    {
                        title: 'Lunch',
                        start: new Date(y, m, d, 12, 0),
                        end: new Date(y, m, d, 14, 0),
                        allDay: false
                    },
                    {
                        title: 'Birthday Party',
                        start: new Date(y, m, d+1, 19, 0),
                        end: new Date(y, m, d+1, 22, 30),
                        allDay: false
                    },
                    {
                        title: 'Click for Google',
                        start: new Date(y, m, 28),
                        end: new Date(y, m, 29),
                        url: 'http://google.com/'
                    }
                ]
            });
        }
    };

    /**
     * Init toggle open menu functionality
     */
    function initMenus() {
        $(document).on('click', '.sidemenu-switch', function (event) {
            $('.sidebar').toggleClass('light');
            $('.content').toggleClass('light');
        });
        function toggleMenu($menu){
            $menu.toggleClass('open');
        }
        $(document).on('click', '.menu .menu-toggle', function (event){
            event.preventDefault();
            toggleMenu($(this).parents('.menu').first());
        });
    }

    /**
     * Init the form controls and other input functionality
     */
    function initControls() {
        // set up textarea autosize
        $('textarea').autosize();
        // set up tooltips
        $('[data-toggle="tooltip"]').tooltip();
        // set up checkbox/radiobox styles
        $("input:checkbox, input:radio").uniform();
        $('.datatable').dataTable({});

        // set up select2
        $('.select2').select2();

        // Pie charts
        if ($('.pie-chart').length){
            $('.pie-chart').easyPieChart({
                barColor: "#428bca",
                lineWidth: 4,
                animate: 1000,
                onStart: function () {
                    if (this.options.isInit) {
                        return;
                    }
                    this.options.isInit = true;
                    var color = $(this.el).data('barColor');
                    if (color) {
                        this.options.barColor = color;
                    }
                },
                onStep: function (oldVal, newVal, crtVal) {
                    $(this.el).find('span').text(Math.floor(crtVal) + '%');
                }
            });
        }
    }

    /**
     * Init Gallery File Upload
     */
    function initGalleryUpload() {
        $('.fileinput').fileinput();
    }

    /**
     * Init date pickers
     */
    function initDatePickers(){
        $('.datepicker').datepicker({autoclose:true});
        $('#reportrange').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().startOf('month'),
                endDate: moment().endOf('month')
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );
    }


    /**
     * Init line and bar charts
     * @param charts
     */
    function initCharts(charts) {

        var chartLines = {
            series: {
                lines: {
                    show: true,
                    lineWidth: 1,
                    fill: true,
                    fillColor: { colors: [ { opacity: 0.1 }, { opacity: 0.13 } ] }
                },
                points: {
                    show: true,
                    lineWidth: 2,
                    radius: 3
                },
                shadowSize: 0,
                stack: true
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#f9f9f9",
                borderWidth: 0
            },
            legend: {
                show: true,
                labelBoxBorderColor: "#fff"
            },
            colors: ["#a7b5c5", "#30a0eb"],
            xaxis: {
                ticks: [[1, "Jan"], [2, "Feb"], [3, "Mar"], [4, "Apr"], [5, "May"], [6, "Jun"],
                    [7, "Jul"], [8, "Aug"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dec"]],
                font: {
                    size: 12,
                    family: "Open Sans, Arial",
                    color: "#697695"
                }
            },
            yaxis: {
                ticks: 3,
                tickDecimals: 0,
                font: {size: 12, color: "#9da3a9"}
            }
        };
        // A custom label formatter used by several of the plots

        function labelFormatter(label, series) {
            return "<div class='chart-label'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
        }
        var zoomOpts = {
            series: {
                lines: {
                    show: true
                },
                shadowSize: 0
            },
            colors: ["#30a0eb"],
            xaxis: {
                zoomRange: [0.1, 10],
                panRange: [-10, 10]
            },
            yaxis: {
                zoomRange: [0.1, 10],
                panRange: [-10, 10]
            },
            zoom: {
                interactive: true
            },
            pan: {
                interactive: true
            },
            grid: {
                tickColor: "#f9f9f9",
                borderColor: "#fff"
            }
        }
        var chartBars = {
            series: {
                bars: {
                    show: true,
                    lineWidth: 1,
                    fill: true,
                    fillColor: { colors: [ { opacity: 0.1 }, { opacity: 0.13 } ] }
                }
            },
            legend: {
                show: true,
                labelBoxBorderColor: "#fff"
            },
            colors: ["#30a0eb"],
            bars: {
                horizontal: false,
                barWidth: 0.7
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#f9f9f9",
                borderWidth: 0
            },
            xaxis: {
                ticks: [[1, "Jan"], [2, "Feb"], [3, "Mar"], [4, "Apr"], [5, "May"], [6, "Jun"],
                    [7, "Jul"], [8, "Aug"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dec"]],
                font: {
                    size: 12,
                    family: "Open Sans, Arial",
                    color: "#697695"
                }
            },
            yaxis: {
                ticks: 5,
                tickDecimals: 0,
                font: {size: 12, color: "#9da3a9"}
            }
        };

        var horizontalBars = {
            series: {
                bars: {
                    show: true,
                    lineWidth: 1,
                    fill: true,
                    fillColor: { colors: [ { opacity: 0.1 }, { opacity: 0.13 } ] }
                }
            },
            colors: ["#30a0eb"],
            bars: {
                align: "center",
                barWidth: 0.7,
                horizontal: true
            },
            xaxis: {
                axisLabel: "Price (USD/oz)",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 9,
                max: 2000,
                tickFormatter: function (v, axis) {
                    return v;
                },
                color: "#697695"
            },
            yaxis: {
                axisLabel: "Precious Metals",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3,
                ticks: [ [0, "Gold"], [1, "Silver"], [2, "Platinum"], [3, "Palldium"], [4, "Rhodium"], [5, "Ruthenium"], [6, "Iridium"]],
                color: "#697695"
            },
            legend: {
                noColumns: 0,
                labelBoxBorderColor: "#fff",
                position: "ne"
            },
            grid: {
                hoverable: true,
                tickColor: "#f9f9f9",
                borderColor: "#fff"
            }
        };

        var realTimeBars = {
            series: {
                shadowSize: 0	// Drawing is faster without shadows
            },
            colors: ["#30a0eb"],
            yaxis: {
                min: 0,
                max: 100
            },
            xaxis: {
                show: false
            },
            grid: {
                tickColor: "#f9f9f9",
                borderColor: "#fff"
            }
        };
        var pieOpts = {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3/4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5
                        }
                    }
                }
            },
            legend: {
                show: false
            }
        };
        var donutOpts = {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3/4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5
                        }
                    }
                }
            },
            legend: {
                show: false
            }
        };

        function showTooltip(x, y, color, contents) {
            $('<div id="tooltip">' + contents + '</div>').css({
                top: y - 25,
                left: x - 35,
                'border-color': color
            }).appendTo("body").fadeIn(200);
        }
        function showHorizontalBarTooltip(x, y, color, contents) {
            $('<div id="tooltip">' + contents + '</div>').css({
                top: y - 10,
                left: x + 5,
                'border-color': color
            }).appendTo("body").fadeIn(200);
        }

        $.each(charts, function (id, value) {
            if (!$(id).length){
                return;
            }
            var opts = null;
            switch (value.type){
                case 'bars': opts = chartBars; break;
                case 'zoom': opts = zoomOpts; break;
                case 'horizontal': opts = horizontalBars; break;
                case 'realTime':
                    var updateInterval = value.updateInterval;
                    $("#updateInterval").val(updateInterval).change(function () {
                        var v = $(this).val();
                        if (v && !isNaN(+v)) {
                            updateInterval = +v;
                            if (updateInterval < 1) {
                                updateInterval = 1;
                            } else if (updateInterval > 2000) {
                                updateInterval = 2000;
                            }
                            $(this).val("" + updateInterval);
                        }
                    });
                    value.data = [getRandomData()];
                    opts = realTimeBars;
                    break;
                case 'pie': opts = pieOpts; break;
                case 'donut': opts = donutOpts; break;
                default:
                    opts = chartLines;
            };
            var plot = $.plot($(id), value.data, opts),
                previousPoint = null,
                previousLabel = null;

            //used on real time chart
            function update() {
                plot.setData([getRandomData()]);
                // Since the axes don't change, we don't need to call plot.setupGrid()
                plot.draw();
                setTimeout(update, updateInterval);
            }
            // little helper for taking the repetitive work out of placing
            // panning arrows
            function addArrow(dir, right, top, offset) {
                $("<img class='zoomBtn' src='img/charts/arrow-" + dir + ".gif' style='right:" + right + "px;top:" + top + "px'>")
                    .appendTo($(id))
                    .click(function (e) {
                        e.preventDefault();
                        plot.pan(offset);
                    });
            }

            switch (value.type){
                case 'bars':
                    //bind tooltip for bars chart
                    $(id).bind("plothover", function (event, pos, item) {
                        if (item) {
                            if (previousPoint != item.dataIndex) {
                                previousPoint = item.dataIndex;
                                $("#tooltip").remove();
                                var x = item.datapoint[0].toFixed(0),
                                    y = item.datapoint[1].toFixed(0),
                                    month = item.series.xaxis.ticks[item.dataIndex].label,
                                    color = item.series.color;
                                showTooltip(item.pageX, item.pageY, color,
                                    item.series.label + " of " + month + ": " + y);
                            }
                        } else {
                            $("#tooltip").remove();
                            previousPoint = null;
                        }
                    });
                    break;
                case 'zoom':
                    // show pan/zoom messages to illustrate events
                    $(id).bind("plotpan", function (event, plot) {
                        plot.getAxes();
                    });
                    $(id).bind("plotzoom", function (event, plot) {
                        plot.getAxes();
                    });
                    // add zoom out button
                    $("<div class='btn btn-primary btn-xs'>zoom out</div>")
                        .appendTo($(id))
                        .click(function (event) {
                            event.preventDefault();
                            plot.zoomOut();
                        });
                    // and add panning buttons
                    addArrow("left", 33, 35, { left: -100 });
                    addArrow("right", 3, 35, { left: 100 });
                    addArrow("up", 18, 20, { top: -100 });
                    addArrow("down", 18, 50, { top: 100 });
                    break;
                case 'horizontal':
                    //bind tooltip for horizontal chart
                    $(id).bind("plothover", function (event, pos, item) {
                        if (item) {
                            if ((previousLabel != item.series.label) ||
                                (previousPoint != item.dataIndex)) {
                                previousPoint = item.dataIndex;
                                previousLabel = item.series.label;
                                $("#tooltip").remove();
                                var x = item.datapoint[0],
                                    y = item.datapoint[1],
                                    color = item.series.color;
                                showHorizontalBarTooltip(item.pageX,
                                    item.pageY,
                                    color,
                                    "<strong>" + item.series.label + "</strong><br>" + item.series.yaxis.ticks[y].label +
                                        " : <strong>" + x + "</strong> USD/oz");
                            }
                        } else {
                            $("#tooltip").remove();
                            previousPoint = null;
                        }
                    });
                    break;
                case 'realTime':
                    update();
                    break;

            };

        });
    }

    /**
     * Init support for bootstrap within data tables
     */
    function initDataTableBootstrapSupport(){
        /* Set the defaults for DataTables initialisation */
        $.extend( true, $.fn.dataTable.defaults, {
            "sDom":
                "<'row'<'col-xs-6 records'l><'col-xs-6 search_input'f>r>"+
                    "t"+
                    "<'row'<'col-xs-6'i><'col-xs-6'p>>",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page"
            }
        } );


        /* Default class modification */
        $.extend( $.fn.dataTableExt.oStdClasses, {
            "sWrapper": "dataTables_wrapper form-inline",
            "sFilterInput": "form-control input-sm",
            "sLengthSelect": "select2"
        } );

        // In 1.10 we use the pagination renderers to draw the Bootstrap paging,
        // rather than custom plug-in
        if ( $.fn.dataTable.Api ) {
            $.fn.dataTable.defaults.renderer = 'bootstrap';
            $.fn.dataTable.ext.renderer.pageButton.bootstrap = function ( settings, host, idx, buttons, page, pages ) {
                var api = new $.fn.dataTable.Api( settings );
                var classes = settings.oClasses;
                var lang = settings.oLanguage.oPaginate;
                var btnDisplay, btnClass;

                var attach = function( container, buttons ) {
                    var i, ien, node, button;
                    var clickHandler = function ( e ) {
                        e.preventDefault();
                        if ( e.data.action !== 'ellipsis' ) {
                            api.page( e.data.action ).draw( false );
                        }
                    };

                    for ( i=0, ien=buttons.length ; i<ien ; i++ ) {
                        button = buttons[i];

                        if ( $.isArray( button ) ) {
                            attach( container, button );
                        }
                        else {
                            btnDisplay = '';
                            btnClass = '';

                            switch ( button ) {
                                case 'ellipsis':
                                    btnDisplay = '&hellip;';
                                    btnClass = 'disabled';
                                    break;

                                case 'first':
                                    btnDisplay = lang.sFirst;
                                    btnClass = button + (page > 0 ?
                                        '' : ' disabled');
                                    break;

                                case 'previous':
                                    btnDisplay = lang.sPrevious;
                                    btnClass = button + (page > 0 ?
                                        '' : ' disabled');
                                    break;

                                case 'next':
                                    btnDisplay = lang.sNext;
                                    btnClass = button + (page < pages-1 ?
                                        '' : ' disabled');
                                    break;

                                case 'last':
                                    btnDisplay = lang.sLast;
                                    btnClass = button + (page < pages-1 ?
                                        '' : ' disabled');
                                    break;

                                default:
                                    btnDisplay = button + 1;
                                    btnClass = page === button ?
                                        'active' : '';
                                    break;
                            }

                            if ( btnDisplay ) {
                                node = $('<li>', {
                                    'class': classes.sPageButton+' '+btnClass,
                                    'aria-controls': settings.sTableId,
                                    'tabindex': settings.iTabIndex,
                                    'id': idx === 0 && typeof button === 'string' ?
                                        settings.sTableId +'_'+ button :
                                        null
                                } )
                                    .append( $('<a>', {
                                        'href': '#'
                                    } )
                                        .html( btnDisplay )
                                    )
                                    .appendTo( container );

                                settings.oApi._fnBindAction(
                                    node, {action: button}, clickHandler
                                );
                            }
                        }
                    }
                };

                attach(
                    $(host).empty().html('<ul class="pagination pagination-sm"/>').children('ul'),
                    buttons
                );
            }
        }
        else {
            // Integration for 1.9-
            $.fn.dataTable.defaults.sPaginationType = 'bootstrap';

            /* API method to get paging information */
            $.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
            {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": oSettings._iDisplayLength === -1 ?
                        0 : Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
                    "iTotalPages": oSettings._iDisplayLength === -1 ?
                        0 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
                };
            };

            /* Bootstrap style pagination control */
            $.extend( $.fn.dataTableExt.oPagination, {
                "bootstrap": {
                    "fnInit": function( oSettings, nPaging, fnDraw ) {
                        var oLang = oSettings.oLanguage.oPaginate;
                        var fnClickHandler = function ( e ) {
                            e.preventDefault();
                            if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
                                fnDraw( oSettings );
                            }
                        };

                        $(nPaging).append(
                            '<ul class="pagination pagination-sm">'+
                                '<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
                                '<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
                                '</ul>'
                        );
                        var els = $('a', nPaging);
                        $(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
                        $(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
                    },

                    "fnUpdate": function ( oSettings, fnDraw ) {
                        var iListLength = 5;
                        var oPaging = oSettings.oInstance.fnPagingInfo();
                        var an = oSettings.aanFeatures.p;
                        var i, ien, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

                        if ( oPaging.iTotalPages < iListLength) {
                            iStart = 1;
                            iEnd = oPaging.iTotalPages;
                        }
                        else if ( oPaging.iPage <= iHalf ) {
                            iStart = 1;
                            iEnd = iListLength;
                        } else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
                            iStart = oPaging.iTotalPages - iListLength + 1;
                            iEnd = oPaging.iTotalPages;
                        } else {
                            iStart = oPaging.iPage - iHalf + 1;
                            iEnd = iStart + iListLength - 1;
                        }

                        for ( i=0, ien=an.length ; i<ien ; i++ ) {
                            // Remove the middle elements
                            $('li:gt(0)', an[i]).filter(':not(:last)').remove();

                            // Add the new list items and their event handlers
                            for ( j=iStart ; j<=iEnd ; j++ ) {
                                sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
                                $('<li '+sClass+'><a href="#">'+j+'</a></li>')
                                    .insertBefore( $('li:last', an[i])[0] )
                                    .bind('click', function (e) {
                                        e.preventDefault();
                                        oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                                        fnDraw( oSettings );
                                    } );
                            }

                            // Add / remove disabled classes from the static elements
                            if ( oPaging.iPage === 0 ) {
                                $('li:first', an[i]).addClass('disabled');
                            } else {
                                $('li:first', an[i]).removeClass('disabled');
                            }

                            if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
                                $('li:last', an[i]).addClass('disabled');
                            } else {
                                $('li:last', an[i]).removeClass('disabled');
                            }
                        }
                    }
                }
            } );
        }


        /*
         * TableTools Bootstrap compatibility
         * Required TableTools 2.1+
         */
        if ( $.fn.DataTable.TableTools ) {
            // Set the classes that TableTools uses to something suitable for Bootstrap
            $.extend( true, $.fn.DataTable.TableTools.classes, {
                "container": "DTTT btn-group",
                "buttons": {
                    "normal": "btn btn-default",
                    "disabled": "disabled"
                },
                "collection": {
                    "container": "DTTT_dropdown dropdown-menu",
                    "buttons": {
                        "normal": "",
                        "disabled": "disabled"
                    }
                },
                "print": {
                    "info": "DTTT_print_info modal"
                },
                "select": {
                    "row": "active"
                }
            } );

            // Have the collection use a bootstrap compatible dropdown
            $.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
                "collection": {
                    "container": "ul",
                    "button": "li",
                    "liner": "a"
                }
            } );
        }

    }

    /**
     * Init Google Maps
     */
    function initMaps(){
        if ($('.map-canvas').length){
            $('.map-canvas').each(function(){
                var $mapZoom = ($(this).attr("map-zoom")) ? parseInt($(this).attr("map-zoom")) : 11;
                var mapOptions = {
                    center: new google.maps.LatLng($(this).attr("map-latitude"), $(this).attr("map-longitude")),
                    zoom: $mapZoom
                };

                if ($(this).attr('styled-map') == 'true'){
                    // Create an array of styles.
                    var styles = [
                        {
                            "featureType": "landscape",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 65
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 51
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "road.arterial",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 30
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "road.local",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 40
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "transit",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "administrative.province",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "labels",
                            "stylers": [
                                {
                                    "visibility": "on"
                                },
                                {
                                    "lightness": -25
                                },
                                {
                                    "saturation": -100
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "hue": "#ffff00"
                                },
                                {
                                    "lightness": -25
                                },
                                {
                                    "saturation": -97
                                }
                            ]
                        }
                    ];
                    // Create a new StyledMapType object, passing it the array of styles,
                    // as well as the name to be displayed on the map type control.
                    var styledMap = new google.maps.StyledMapType(styles,
                        {name: "Styled Map"});

                    mapOptions.mapTypeControlOptions =  {
                        mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
                    };
                    var map = new google.maps.Map(this, mapOptions);
                    //Associate the styled map with the MapTypeId and set it to display.
                    map.mapTypes.set('map_style', styledMap);
                    map.setMapTypeId('map_style');
                } else {
                    mapOptions.mapTypeId = ($(this).attr('terrain-map') == 'true') ? google.maps.MapTypeId.TERRAIN : mapOptions.mapTypeId = google.maps.MapTypeId.ROADMAP;
                    new google.maps.Map(this, mapOptions);
                }
            });
        }
    }

    /**
     * Init CKEditor
     */
    function initCKEditor(){
        if($('.ckeditor').length){
            $('.ckeditor').each(function(index){
                //set config type (config all is implicit)
                var $config = ($(this).attr('basic-ckeditor') == 'true') ? 'basic' : 'all';
                // if there is no id, set it
                var $id = 'editor'+index;
                if ($(this).attr('id')){
                    $id = $(this).attr('id');
                } else {
                    $(this).attr('id', $id);
                }
                if ($(this).attr('contenteditable') == 'true'){
                    CKEDITOR.inline( $id, { customConfig: '../../js/ckeditor/' + $config + '-config.js' } )
                } else {
                    CKEDITOR.replace( $id, { customConfig: '../../js/ckeditor/' + $config + '-config.js' } ); //Create CKEditor
                }
            });
        }
    }
})(jQuery);

/**
 * Ark Init method
 */
jQuery(function () {
    "use strict";

    //Pie charts data
    var pieData = [];

    for (var i = 0; i < 5; i++) {
        pieData[i] = {
            label: "Series" + (i + 1),
            data: Math.floor(Math.random() * 20) + 15
        };
    }

    //Zoom chart data
    function sumf(f, t, m) {
        var res = 0;
        for (var i = 1; i < m; ++i) {
            res += f(i * i * t) / (i * i);
        }
        return res;
    }

    var d1 = [];
    for (var t = 0; t <= 2 * Math.PI; t += 0.01) {
        d1.push([sumf(Math.cos, t, 10), sumf(Math.sin, t, 10)]);
    }

    var zoomData = [ d1 ];


    var charts = {
        '#dashboardConversions': {
            data: [
                {
                    label: "Signups",
                    data: [[1, 46], [2, 53], [3, 42], [4, 45], [5, 59], [6, 35], [7, 39], [8, 45], [9, 48], [10, 57], [11, 39], [12, 68]]
                },
                {
                    label: "Visits",
                    data: [[1, 25], [2, 30], [3, 33], [4, 48], [5, 38], [6, 40], [7, 47], [8, 55], [9, 43], [10, 50], [11, 47], [12, 39]]
                }
            ]
        },
        '#chartZoom': {
            type: 'zoom',
            data: zoomData
        },
        '#dashboardRevenues': {
            type: 'bars',
            data: [
                {
                    label: "Sales",
                    data: [[1, 51231], [2, 44220], [3, 12455], [4, 24313], [5, 57523], [6, 98432], [7, 90934], [8, 78932], [9, 12367], [10, 67345], [11, 43672], [12, 74213]]
                }
            ]
        },
        '#horizontal': {
            type: 'horizontal',
            data: [
                {
                    label: "Precious Metal Price",
                    data: [
                        [1582.3, 0], //Gold
                        [28.95, 1],  //Silver
                        [1603, 2],   //Platinum
                        [774, 3],    //Palladium
                        [1245, 4],  //Rhodium
                        [85, 5],      //Ruthenium
                        [1025, 6]    //Iridium
                    ]
                }
            ]
        },
        '#realTime': {
            type: 'realTime',
            data: [],
            updateInterval: 30
        },
        '#chartPie': {
            type: 'pie',
            data: pieData
        },
        '#chartDonut': {
            type: 'donut',
            data: pieData
        }
    };

    //Init Ark Admin Theme
    ArkAdmin.init(charts);

    //@todo: Remove on production
    ArkAdmin.initExamples();
});

