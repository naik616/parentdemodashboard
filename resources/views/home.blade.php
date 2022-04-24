@extends('layouts.app')

@section('content')
<div class="container">
<div class="row customtab">
	<div class="col-8">
		<ul class="nav nav-tabs nav-tabs-dropdown">
			<li class="nav-link active" role="presentation"><a data-toggle="tab" class="student-nav"><img src="img/new_icon.png" style="width:30px !important; height:30px !important;" class="rounded-circle"> {{ Auth::user()->studentname }}</a></li>
		</ul>
	</div>
<div class="col-4">
	<div class="form-group" style="margin-bottom: 0px;">
	<label for="dateSelect">Report of: </label>
		<select class="form-control dateSelect" id="dateSelect">
			<option value="7daydata">Last 7 Days</option>
			<option value="30daydata">Last 30 days</option>
		</select>
	</div>
</div>

	<div class="tab-content">
        <div id="main-content" class="">
          <div id="ajax-loader-gif1" class="d-block"><img src="img/loader.gif" alt="Loading" style="width:30%;">
          </div>
          <div class="row">
            <div class="row tab-pane-content">
              <div class="col-md-4 col-sm-6 col-xs-12 card CourseList">
                <h4 class="card-title">Course List<i class="ionicons ion-ios-information-outline" title="Course" data-toggle="tooltip" data-placement="right" data-original-title="Course list" style="vertical-align: super;font-size: initial;"></i><span id="upgrade"></span></h4>
                <hr>
                <div class="scrollable">
                  <div class="courselist"></div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 card ActivityReport">
                <h4 class="card-title">Activity Report<i class="ionicons ion-ios-information-outline" title="Student's latest activity." data-toggle="tooltip" data-placement="right" style="vertical-align: super;font-size: initial;"></i></h4>
                <hr>
                <div class="scrollable">
                  <div class="lastlogintime p-3">
                    <ul class="nav nav-stacked">
                      <li class="nav-link2 active" style="float: left;">
                        <a data-toggle="tab" href="#home" style="cursor: auto;color: black;">
                          <img src="img/new_icon.png" style="width:30px !important; height:30px !important;border-radius: 30px;"/> Last Login: <span id="logintime"></span>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <h4 class="card-title mt-5">To Be Graded<i class="ionicons ion-ios-information-outline" title="Grading questions that need your attention." data-toggle="tooltip" data-placement="right" style="vertical-align: super;font-size: initial;"></i></h4>
                  <hr>
                  <div class="toBeGradedContainer"></div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 card LessonsMastery" id="chart">
                <h4 class="card-title">Mastery By Lessons<i class="ionicons ion-ios-information-outline" title="Mastery by lessons." data-toggle="tooltip" data-placement="right" style="vertical-align: super;font-size: initial;"></i></h4>
                <hr style="margin-bottom: 0;">
                <div class="scrollable">
                  <div id="lessonmasterychart"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="row tab-pane-content">
              <div class="col-md-8 col-sm-6 col-xs-12 card">
                <h4 class="card-title">Assignment Status Report<i class="ionicons ion-ios-information-outline" title="Report of the assignments assigned by Lumos coach and you." data-toggle="tooltip" data-placement="right" style="vertical-align: super;font-size: initial;"></i>

                </h4>
                <hr>
                <div class="scrollable">
                  <div id="assignmentchart"></div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 card">
                <h4 class="card-title">Recommended Books<i class="ionicons ion-ios-information-outline" title="Lumos Test prep book recommendations for your student" data-toggle="tooltip" data-placement="top" style="vertical-align: super;font-size: initial;"></i></h4>
                <hr>
                <div class="scrollable">
                  <div id="tedbook-carousel"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
</div>
@endsection
