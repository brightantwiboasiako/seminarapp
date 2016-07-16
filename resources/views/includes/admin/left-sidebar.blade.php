<div class="col-md-3 md-margin-bottom-40">
    {{--<img class="img-responsive profile-img margin-bottom-20" src="assets/img/team/img32-md.jpg" alt="">--}}

    <ul class="list-group sidebar-nav-v1 margin-bottom-40" id="sidebar-nav-1">
        <li class="list-group-item active">
            <a href="{{ url('admin/seminar/'.e($seminar->slug)) }}"><i class="fa fa-tv"></i> {{ e($seminar->title) }}</a>
        </li>
        <li class="list-group-item">
            <a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
        </li>
        <li class="list-group-item">
            <a href="{{ url('admin/seminar/'.e($seminar->slug).'/participants') }}"><i class="fa fa-users"></i> Participants</a>
        </li>
        <li class="list-group-item">
            <a href="{{ url('admin/seminar/'.e($seminar->slug).'/survey') }}"><i class="fa fa-bar-chart"></i> Survey</a>
        </li>
        <li class="list-group-item">
            <a href="{{ url('admin/seminar/'.e($seminar->slug).'/files') }}"><i class="fa fa-file-zip-o"></i> Files</a>
        </li>
    </ul>


    <div class="margin-bottom-50"></div>

    <!--Datepicker-->
    <form action="#" id="sky-form2" class="sky-form">
        <div id="inline-start"></div>
    </form>
    <!--End Datepicker-->
</div>
    <!--End Left Sidebar-->