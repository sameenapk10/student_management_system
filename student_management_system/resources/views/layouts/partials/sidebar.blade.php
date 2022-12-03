<div class="sidebar-wrapper">
    <div class="user">
        <div class="photo">
{{--            <img class="avatar" @auth src="{{ Auth::user()->avatar_thumb }}" @else src="{{ asset('uploads/avatar/default.jpg') }}" @endauth/>--}}
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
                <a class="nav-link" data-toggle="collapse" href="#sidebar-collapse-admin-dashboard">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard<b class="caret"></b></p>
                </a>
                <div class="collapse" id="sidebar-collapse-admin-dashboard">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('dashboard?admin_dashboard&operation_dashboard') }}">
                                <span class="sidebar-mini">OD</span>
                                <span class="sidebar-normal">Operation Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('dashboard?admin_dashboard&translation_dashboard') }}">
                                <span class="sidebar-mini">TD</span>
                                <span class="sidebar-normal">Translation Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('dashboard?admin_dashboard&attestation_dashboard') }}">
                                <span class="sidebar-mini">AD</span>
                                <span class="sidebar-normal">Attestation Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('company_documents') }}">
                    <i class="material-icons">library_books</i>
                    <p>Company Documents</p>
                </a>
            </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tablesExamples">
                <i class="material-icons">people</i>
                <p> Users<b class="caret"></b></p>
            </a>
            <div class="collapse" id="tablesExamples">
                <ul class="nav">
                    @permits('manage-all-users')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('users') }}">
                            <span class="sidebar-mini">AU</span>
                            <span class="sidebar-normal">All Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('staffs') }}">
                            <span class="sidebar-mini">ST</span>
                            <span class="sidebar-normal">Staffs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('translators') }}">
                            <span class="sidebar-mini">TR</span>
                            <span class="sidebar-normal">Translators</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        @endpermits
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
