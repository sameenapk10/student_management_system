<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    {{--  <button class="btn btn-link position-absolute" type="button" style="right: 60px; outline: 0; padding: 15px 20px;">
            <i class="material-icons" style="font-size: 1.5rem">notifications</i>
            <span class="notification">5</span>
        </button> --}}

    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-minimize">
                <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                    <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                    <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                </button>
            </div>
            <a class="navbar-brand d-none d-sm-block">@yield('title')</a>
        </div>

    <div class="actionbar-nav justify-content-end">

{{--        Search form--}}
{{--        <form class="navbar-form">--}}
{{--            <div class="input-group no-border">--}}
{{--                <input type="text" value="" class="form-control" placeholder="Search...">--}}
{{--                <button type="submit" class="btn btn-white btn-round btn-just-icon">--}}
{{--                    <i class="material-icons">search</i>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--        End of search form--}}

        <ul class="navbar-nav" style="flex-direction: inherit;">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">person</i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                    <a class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item">Log out</a>
                </div>
            </li>
        </ul>
    </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
    </div>
</nav>
<!-- End Navbar -->

    <style>
        .actionbar-nav {
            display: flex!important;
            flex-basis: auto;
            flex-grow: 1;
        }
        @media (max-width: 991px){
            .navbar .dropdown .dropdown-menu, .navbar .dropdown.show .dropdown-menu {
                position: fixed;
                top: 58px;
                left: 5px;
                width: calc(100% - 10px);
                box-shadow: 0 2px 5px 0 rgba(0,0,0,.26);
                background-color: #fff;
                padding: .3125rem 0;
                height: auto;
                overflow-y: visible;
            }
            .navbar .dropdown-menu .dropdown-item {
                margin: 0 .3125rem;
            }
        }

    </style>
