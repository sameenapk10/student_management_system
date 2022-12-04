<div class="sidebar-wrapper">
    <div class="user">
        <div class="photo">
            <img class="avatar" src="{{ asset('uploads/avatar/default.jpg') }}"/>
        </div>
        <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
                <span> Hi, User<b class="caret"></b></span>
            </a>
            <div class="collapse" id="collapseExample">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" >
                            <span class="sidebar-mini"> MP </span>
                            <span class="sidebar-normal"> My Profile </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            <span class="sidebar-mini"> LO </span>
                            <span class="sidebar-normal"> Log Out </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('dashboard') }}">
                <i class="material-icons">dashboard</i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-collapse-students">
                <i class="material-icons">supervised_user_circle</i>
                <p>Students<b class="caret"></b></p>
            </a>
            <div class="collapse" id="sidebar-collapse-students">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('students?all_students') }}">
                            <span class="sidebar-mini">AS</span>
                            <span class="sidebar-normal">All Students</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('students?active_students') }}">
                            <span class="sidebar-mini">AS</span>
                            <span class="sidebar-normal">Active Students</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('students?inactive_students') }}">
                            <span class="sidebar-mini">IS</span>
                            <span class="sidebar-normal">Inactive Students</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('student_marks') }}">
                <i class="material-icons">checklist</i>
                <p>Student Marks</p>
            </a>
        </li>
    </ul>
</div>

{{--@push('js')--}}
{{--    <script>--}}
        /*------------ Highlight appropriate sidebar menu -------------*/
        // use the following instead of href for highlight all path matchs
        // "{{ url('') }}"+window.location.pathname
        // $('.nav > .nav-item > .nav-link').each(function () {
        //     if ($(this).attr('href') == window.location.href){
        //         $(this).parents('.nav-item').addClass('active');
        //         $(this).closest('div').addClass('show');
        //         $(this).closest('div').siblings('a').attr('aria-expanded', 'true');
        //     }
        // });
        /*------------ End of Highlight appropriate sidebar menu -------------*/
{{--    </script>--}}
{{--@endpush--}}
