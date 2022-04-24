<!doctype html>
	<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Parent Dashboard</title>

		<!-- Fonts -->
		<link rel="dns-prefetch" href="//fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<link href="css/style.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

		<!-- Highcharts -->
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>

		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

	</head>
	<body>
		<div id="app">
			<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
				<div class="container">
					<a class="navbar-brand" href="{{ url('/') }}" style="color:dodgerblue;">
					@if (Route::has('login'))
					@auth
						{{ Auth::user()->name }} dashboard
					@else
						Parent portal demo
					@endauth
					@endif
					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<!-- Left Side Of Navbar -->
						<ul class="navbar-nav me-auto">

						</ul>

						<!-- Right Side Of Navbar -->
						<ul class="d-flex p-0 m-0" style="align-items:center;">
							<!-- Authentication Links -->
							@guest
							@if (Route::has('login'))
							<li class="nav-item">
								<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
							</li>
							@endif

							@if (Route::has('register'))
							<li class="nav-item">
								<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
							</li>
							@endif
							@else
							
							<a class="dropdown-item" href="{{ route('logout') }}"
							onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
							<i class="fa fa-power-off" style="color:dodgerblue;" aria-hidden="true"></i>
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
						@endguest
					</ul>
				</div>
			</div>
		</nav>

		<main class="py-4 mt-5">
			@yield('content')
		</main>
	</div>
</body>
<script>
	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		var expires = "expires=" + d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/";
	}
	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}
	setCookie('cur_subj','Math');
	setCookie('datefilter','7daydata');
	$(document).ready(function(){
		$(document).on('click','.nav-link1', function(e){
			$("#ajax-loader-gif1").removeClass("d-none").addClass("d-block");
			$(".tab-pane-content").css("opacity",0.5);
			setCookie('cur_subj', $(this).children('a').attr("data-courseid"));
			loadcoursedata();
		});
		$('#dateSelect').change(function(e){
			console.log("inside date change");
			setCookie('datefilter',$("#dateSelect").val());
			loadcoursedata();
		});
	});
	loadcoursedata();
	function loadcoursedata(){
		$.ajax({
			url: '/demostudent_data/dummy_data.json',
			success: function(result){
				let dummydata = result[getCookie('datefilter')];
				var coursehtml = '<ul class="nav nav-stacked">';
				let img_src = '';
				$.each(dummydata,function(i,data){
					if(getCookie('cur_subj') == data.Subject){
						img_src = "/img/math.png";
						coursehtml += '<li class="nav-link1 active nav-item"><img src='+img_src+' style="width:60px;"><a class="courselink p-3" data-toggle="tab" data-courseid='+i+' data-grade='+data.id_grade+'> '+data.ShortName+'</a></li>';
					}else{
						img_src = "/img/ela.png";
						coursehtml += '<li class="nav-link1 nav-item"><img src='+img_src+' style="width:60px;"><a class="courselink p-3" data-toggle="tab" data-courseid='+i+' data-grade='+data.id_grade+'> '+data.ShortName+'</a></li>';
					}

					if(getCookie('cur_subj') == data.Subject){
						$(".toBeGradedContainer").html('<div class="tobegrade"><a href="#">'+data.tobegraded+'</a></div>');
						$("#logintime").html(data.lastlogin);

					//mastery chart data
					Highcharts.setOptions({
						colors: ['green', 'orange', 'red', 'grey']
					});
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'lessonmasterychart',
							type: 'pie',
							height: 300
						},
						title: {
							useHTML: true,
							text: ''
						},
						yAxis: {
							title: {
								text: ''
							}
						},
						plotOptions: {
							pie: {
								shadow: false
							}
						},
						tooltip: {
							formatter: function() {
								return '<b>' + this.point.name + '</b>: ' + this.y + ' lesson(s).';
							}
						},
						legend: {
							layout: 'vertical'
						},
						series: [{
							name: 'Lessons',
							data: [
							{name:"Advanced Proficient", y:data.advancedProficient, url:''},
							{name:"Proficient", y:data.proficient,url:''},
							{name:"Partial Proficient",y: data.partialProficient,url:''},
							{name:"Unattempted", y:data.untouchedLessons,url:''},
							],
							size: '70%',
							innerSize: '50%',
							showInLegend: true,
							dataLabels: {
								enabled: false
							},
							point: {
								events: {
									click: function() {
										setCookie("CurCourseID",courseid,20);
										location.href = this.url;
									}
								}
							}
						}]
					});
					//assignment chart
					let assignmentdata = [];
					assignmentdata.push({name:"Completed assignments",y: parseInt(data.assignment_status.CompleteCount),color: "#1565c0"},{name: "Incomplete assignments",y: parseInt(data.assignment_status.IncompleteCount),color: "#2196f3"});
					Highcharts.chart('assignmentchart', {
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false,
							type: 'pie',
							height: 300
						},
						title: {
							text: ''
						},
						tooltip: {
							pointFormat: '{point.name}: <b> {point.y}</b>'
						},
						plotOptions: {
							pie: {
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
									enabled: true
								},
								showInLegend: false,
								events: {
									click: function (event) {
									}
								},
							}
						},
						series: [{
							colorByPoint: true,
							data: assignmentdata
						}]
					});
				}
			});
				coursehtml += "</ul>";
				$(".courselist").html(coursehtml);
				let bookinfo = result['book-details'];
				let carouselhtml = '<div id="carouselExampleControls" class="carousel slide" data-ride="carousel"><div class="carousel-inner">';
				$.each(bookinfo,function(i,list){
					if(i==0){
						carouselhtml += '<div class="carousel-item active"><img src="'+list.Book_Image+'" style="width:50%;display:inline;" class="image d-block center"><div class="hoverbox"><a href="'+list.Amazon_Link+'" style="text-decoration: none;" target="_blank" class="btn btn-md"><div class="text">Get it Now</div></a></div></div>';
					}else{
						carouselhtml += '<div class="carousel-item"><img src="'+list.Book_Image+'" style="width:50%;display:inline;" class="image d-block center"><div class="hoverbox"><a href="'+list.Amazon_Link+'" style="text-decoration: none;" target="_blank" class="btn btn-md"><div class="text">Get it Now</div></a></div></div>';
					}
					
				});
				carouselhtml += '</div> <a class="carousel-control-prev" href="#carouselExampleControls" data-slide="prev"><span class="carousel-control-prev-icon"></span></a><a class="carousel-control-next" href="#carouselExampleControls" data-slide="next"><span class="carousel-control-next-icon"></span></a></div>';
      			$("#tedbook-carousel").html(carouselhtml);
			}
		});
		$("#ajax-loader-gif1").removeClass("d-block").addClass("d-none");
		$(".tab-pane-content").css("opacity",1);
	}
	
</script>
</html>