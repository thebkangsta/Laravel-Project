@extends('layout')

@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css" />

    <link href="../../assets/plugins/css/datepicker.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/less/datepicker.less" rel="stylesheet" type="text/css" />
    <link href="../../assets/main.css" rel="stylesheet" type="text/css" />
    <!-- JS -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="../../assets/plugins/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../../assets/plugins/js/datepicker.js"></script>
    <script src="../../assets/plugins/js/moment.js" type="text/javascript"></script>

@stop

@section('dashboard')
    <!-- NAVIGATION -->
    <div class="topNav">
        <img src="../../assets/images/BannerWhite.png" style="width:200px;"/>
        <ul class="navButtons">
            <li><a>Home <span class="fa fa-home"></span></a></li>
            <li><a href="communities">Communities <span class="fa fa-users"></span></a></li>
            <li class="active"><a>Analytics <span class="fa fa-line-chart"></span></a></li>
            <li><a>Earnings <span class="fa fa-dollar"></span></a></li>
            <li class="last"><a href="{!! url('logout') !!}">Logout <span class="fa fa-sign-out"></span></a></li>
        </ul>
    </div>
    <!-- END OF NAV -->
    <div class="dashboard">
        <!-- MAIN CHART DATA -->
        <div class="mainContent">
            @if (\Session::has('loggedin'))
                <div class="alert alert-success" id="login">{!! \Session::get('loggedin') !!}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
            <div class="alert alert-danger alert-dismissible" role="alert" id="messages" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <p id="message"></p>
                </button>
            </div>
                @if (!empty($errors))
                    @foreach($errors->all() as $error)
                        <script>
                            $('#messages')
                                    .show()
                                    .html("<strong>Whoops!</strong> {{ $error }}");
                            window.scrollTo(0, 0);
                        </script>
                    @endforeach
                @endif
            <div class="row">
                <div class="wrapper">
                    <section class="overallcontainer">
                            <span class="charttop">Overall Statistics</span>
                        <div class="col-xs-6 col-sm-3">Earnings
                            <p>@if(is_numeric($earnings)) ${{ number_format($earnings,2) }} @else N/A @endif</p>
                        </div>
                        <div class="col-xs-6 col-sm-3">Views
                            <p>@if(is_numeric($views)) {{ number_format($views) }} @else N/A @endif</p>
                        </div>
                        <div class="col-xs-6 col-sm-3">Subscribers
                            <p>@if(is_numeric($subscribers)) {{ number_format($subscribers) }} @else N/A @endif</p>
                        </div>
                        <div class="col-xs-6 col-sm-3">Videos
                            <p>@if(is_numeric($videos)) {{ number_format($videos) }} @else N/A @endif</p>
                        </div>
                    </section>
                </div>
            </div> <!-- END OF FIRST ROW -->
            <div class="row">
                <div class="wrapper">
                    <section class="mainchartcontainer">
                        <div class="charttop">Statistics
                            <div id="totaldata" style="float: right;padding-right:15px;"></div>
                        </div>
                        <div class="topofmainchart">
                            <form>
                                <select name="chartselector" id="chartselector">
                                    <option value="views" selected>Views</option>
                                    <option value="subscribers">Subscribers</option>
                                    <option value="videos">Videos</option>
                                    <option value="earnings">Earnings</option>
                                    <option value="total_views">Total Views</option>
                                    <option value="total_subscribers" >Total Subscribers</option>
                                    <option value="total_videos">Total Videos</option>
                                    <option value="total_earnings">Total Earnings</option>
                                </select>
                                <select name="dateselector" id="dateselector">
                                    <option id="customrange" value="customrange" disabled>Custom Range</option>
                                    <option value="last30" selected>Last 30 Days</option>
                                    <option value="lastmonth">Last Month</option>
                                    <option value="last90">Last 90 Days</option>
                                    <option value="lifetime">Lifetime</option>
                                </select>
                                <div name="datepicker" class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="date-from form-control" name="start" readonly/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="date-to form-control" name="end" readonly/>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                            </form>
                        </div>
                        <div id="mainchart"></div>
                    </section> <!-- END OF MAIN CHART DATA -->
                    <section class="piechartcontainer">
                        <span class="charttop">Total RPM</span>
                        <div id="piechart"></div>
                        <p class="pieinfo" id="conversion"></p>
                    </section>
                </div>
            </div>
        </div> <!-- END OF SECOND ROW -->
    </div>
@stop

@section('end')
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(getData);
        google.charts.setOnLoadCallback(drawPie);

        //global variables
        var bool = false;
        var messages = $('#messages');
        var plot_data;

        $(document).ready(function() {
            $('#datepicker, .input-daterange').datepicker({
                format: "yyyy-mm-dd",
                endDate: '0d',
                autoclose: true
            });

            var monthago = moment().subtract(29, 'days').format('YYYY-MM-DD');
            $('.date-from').datepicker('setDate', monthago);

            var currentdate = moment().format('YYYY-MM-DD');
            $('.date-to').datepicker('setDate', currentdate);

            $('#dateselector, #chartselector').on('change',function() {
                bool=true;
                changeDate();
            });
            $('.date-from, .date-to').on('change', function () {
                if(bool===false) {
                    getData();
                }
                $('#dateselector').val("customrange");
            });

            $(window).resize(function(){
                drawChart(plot_data);
            });

        });

        function getData() {
            var customrange = $('#customrange');
            customrange.removeAttr('disabled');
            $.ajax({
                type: 'POST',
                url: '/project/server.php/dashboard/data',
                data: $('form').serialize(),
                dataType: 'json',
                success: function(response) {
                    plot_data = response;
                    drawChart(plot_data);
                    getTotalData(plot_data);
                },
                error: function() {
                    messages
                            .show()
                            .html("<strong>Whoops!</strong> Unknown error");
                    window.scrollTo(0, 0);
                }
            });
            customrange.prop('disabled', true);
        }

        function changeDate() {
            var dateSelector = $('#dateselector');
            var currentval = dateSelector.val();
            var currentdate = moment().format('YYYY-MM-DD');
            var newdate;

            if(currentval == "last90") {
                newdate = moment().subtract(89, 'days').format('YYYY-MM-DD');
                setFromDate(newdate);
                setToDate(currentdate);
                dateSelector.val(currentval);
            }

            if(currentval == "last30") {
                newdate = moment().subtract(29, 'days').format('YYYY-MM-DD');
                setFromDate(newdate);
                setToDate(currentdate);
                dateSelector.val(currentval);
            }
            if(currentval == "lastmonth") {
                newdate = moment().subtract(1, 'months').date(1).format('YYYY-MM-DD');
                currentdate = moment().date(0).format('YYYY-MM-DD');
                setFromDate(newdate);
                setToDate(currentdate);
                dateSelector.val(currentval);
            }
            if(currentval == "lifetime") {
                newdate = moment().startOf('year').format('YYYY-MM-DD');
                currentdate = moment().format('YYYY-MM-DD');
                setFromDate(newdate);
                setToDate(currentdate);
                dateSelector.val(currentval);
            }
            if(bool===true) {
                getData();
            }
            //reset value
            bool = false;
        }

        function setFromDate(from) {
            $('.date-from').datepicker('setDate', from);
        }

        function setToDate(to) {
            $('.date-to').datepicker('setDate', to);
        }

        var options = {
            backgroundColor: 'none',
            chartArea: {
                left: 100,
                top: 120,
                right: 50,
                width: '90%'
            },
            legend: 'none',
            height: 500,
            pointSize: 5,
            pointShape: 'circle'
        };

        function drawChart(userData) {
            var chartname;
            var data = new google.visualization.DataTable(userData.data);
            if(userData.chart.indexOf("total_")===0) {
                chartname = userData.chart.split("total_").pop();
            } else {
                chartname = userData.chart;
            }
            chartname = chartname.charAt(0).toUpperCase() + chartname.slice(1);

            data.addColumn('string', 'Date');
            data.addColumn('number', chartname);

            var len = Object.keys(userData.data).length;

            for (var i = 0; i < len; i++) {
                data.addRow([
                    userData.data[i].date,
                    Number(userData.data[i][userData.chart])
                ]);
            }

            var chart = new google.visualization.LineChart(document.getElementById('mainchart'));
            var dataview = new google.visualization.DataView(data);
            dataview.setColumns([0,1]);
            chart.draw(dataview,options);
        }

        function getTotalData(userData) {
            var text = null;
            var len = Object.keys(userData.data).length;
            var sum = 0;
            var currentid = document.getElementById('dateselector');
            var currentval = currentid.options[currentid.selectedIndex].value;
            var date;
            var chartname;

            //Parse chart name
            if(userData.chart.indexOf("total_")===0) {
                sum = Number(userData.data[len-1][userData.chart]);
                chartname = userData.chart.split("total_").pop();
                chartname = chartname + " as of "+String(userData.data[len-1].date);
            } else {
                //Sum and get all data
                for (var i = 0; i < len; i++) {
                    sum += Number(userData.data[i][userData.chart]);
                }
                chartname = userData.chart;
            }

            //Set date text values
            if(currentval == "last90") {
                date = "last 90 days";
            }
            if(currentval == "last30") {
                date = "last 30 days";
            }
            if(currentval == "lastmonth") {
                date = "last month";
            }
            if(currentval == "lifetime") {
                date = "lifetime";
            }

            var parts = sum.toString().split(".");
            if(parts[1]!==undefined) {
                var decimal = parts[1];
                parts[1] = decimal.slice(0,2);
                parts[0] = "$"+parts[0];
            }
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            parts = (parts.join("."));

            if(currentval == "lifetime") {
                text = parts+" "+date+" "+chartname;
                document.getElementById('totaldata').innerHTML = text;
                return;
            }

            if(currentval == "customrange") {
                text =  parts+" total "+chartname;
                document.getElementById('totaldata').innerHTML = text;
                return;
            }

            if(userData.chart.indexOf("total_")===0) {
                text = parts+" "+chartname;
                document.getElementById('totaldata').innerHTML = text;
                return;
            }

            text = parts+" "+chartname+" "+date;
            document.getElementById('totaldata').innerHTML = text;
        }

        function drawPie() {
//             Creates new object that holds data
            var data = google.visualization.arrayToDataTable([
                        ['Type', 'Total'],
                        ['Views', {{ $views }}],
                        ['Earnings', {{ $earnings }}]
                    ],
                    false); // 'false' means that the first row contains labels, not data.

            var options = {
                chartArea: {
                    top: 50,
                    width: '90%'
                },
                backgroundColor: 'none',
                legend: {
                    position: 'right',
                    alignment: 'center'
                },
                slices: {1: {offset: 0.4}},
                pieSliceText: 'value',
                height: 500,
                pieHole: 0.5
            };
            //default view (Views, last 30 days)
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            var dataview = new google.visualization.DataView(data);
            chart.draw(dataview,options);

            function resizeChart() {
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                var dataview = new google.visualization.DataView(data);
                chart.draw(dataview,options);
            }

            var text = null;
            var earnings = {{ $earnings }};
            var views = {{ $views }};
            var calculated = earnings/(views/1000);
            var rpm = calculated.toFixed(2);

            if(rpm > 1) {
                text = "$"+rpm+" RPM, Nice!";
            }
            if(rpm < 1 && rpm > .5) {
                text = "$"+rpm+" RPM, Not Bad.";
            }
            if(rpm < .5) {
                text = "$"+rpm+" RPM, Keep Impmroving!";
            }
            $('#conversion').html(text);

            $(window).resize(function(){
                resizeChart();
            });
        }


    </script>
@stop
