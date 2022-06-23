<aside class="sidebar">
    <div class="scrollbar">
        <ul class="navigation">
            @if ( Auth::user() !== null && Auth()->user()->level == "user")
            <li class="{{ (Session::get('active_menu') == 'step1') ? 'navigation__active' : '' }}"><a href="{{ route('step1')}}"><i class="zwicon-note"></i> Step 1 <i class="zwicon-checkmark step1_check active_step {{ (parse_url(url()->current())['path'] == '/step2' || parse_url(url()->current())['path'] == '/step3') ? 'show' : '' }}"></i></a></li>
            <!-- <li class="{{ (Session::get('active_menu') == 'step2') ? 'navigation__active' : '' }}"><a href="{{ route('step2')}}"><i class="zwicon-mail"></i> Step 2</a></li> -->
            <li class="navigation__sub csv {{ (parse_url(url()->current())['path'] == '/step2') ? 'navigation__active' : '' }}">
                <a ><i class="zwicon-cog"></i> Step2 <i class="zwicon-checkmark step2_check active_step {{ (parse_url(url()->current())['path'] == '/step3') ? 'show' : '' }}"></i></a>
                <ul style="{{ (Session::get('active_menu') == 'step2') ? 'display: block;' : '' }}">
                    <li class="csv_1 {{ (parse_url(url()->current())['path'] == '/step2#step-1') ? 'navigation__active' : '' }}">
                        <a href="/step2#step-1">
                            1. Prepare Audience Data <i class="zwicon-checkmark step2_1_check active_step "></i>
                        </a>
                    </li>
                    <li class="csv_2 {{ (parse_url(url()->current())['path'] == '/step2#step-2') ? 'navigation__active' : '' }}">
                        <a href="/step2#step-2">
                            2. Add Audience Data <i class="zwicon-checkmark step2_2_check active_step"></i>
                        </a>
                    </li>
                    <li class="csv_3 {{ (parse_url(url()->current())['path'] == '/step2#step-3') ? 'navigation__active' : '' }}">
                        <a href="/step2#step-3">
                            3. Preview Data <i class="zwicon-checkmark step2_3_check active_step"></i>
                        </a>
                    </li>
                    <!-- <li class="csv_4 {{ (parse_url(url()->current())['path'] == '/step2#step-4') ? 'navigation__active' : '' }}">
                        <a href="/step2#step-4">
                            4. Upload Data
                        </a>
                    </li> -->
                    <li class="csv_5 {{ (parse_url(url()->current())['path'] == '/step2#step-4') ? 'navigation__active' : '' }}">
                        <a href="/step2#step-4">
                            4. Finish <i class="zwicon-checkmark step2_4_check active_step "></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ (Session::get('active_menu') == 'step3') ? 'navigation__active' : '' }}"><a href="{{ route('step3')}}"><i class="zwicon-deploy"></i>Step 3<i class="zwicon-checkmark step3_check active_step"></i></a></li>
            <li class="{{ (Session::get('active_menu') == 'myprofile') ? 'navigation__active' : '' }} "><a href="{{ route('myprofile')}}"><i class="zwicon-user-circle"></i> Account Settings</a></li>
            @endif
            @if ( Auth::user() !== null && Auth()->user()->level == "admin")
            <li class="{{ (Session::get('active_menu') == 'admin.survey') ? 'navigation__active' : '' }} "><a href="{{ route('admin.survey')}}"><i class="zwicon-note"></i>Survey</a></li>
            <li class="{{ (Session::get('active_menu') == 'admin.reports') ? 'navigation__active' : '' }} "><a href="{{ route('admin.reports')}}"><i class="zwicon-file-table"></i>Reports</a></li>
            <li class="{{ (Session::get('active_menu') == 'admin.users') ? 'navigation__active' : '' }} "><a href="{{ route('admin.users.index')}}"><i class="zwicon-user-circle"></i>Users</a></li>

                <!-- <li class="navigation__sub {{ (Session::get('active_menu') == 'admin') ? 'navigation__active' : '' }} ">
                    <a href="#"><i class="zwicon-cog"></i> Admin Area</a>
                    <ul style="{{ (Session::get('active_sub_menu') == 'admin.users' && Session::get('active_menu') == 'admin') ? 'display: block;' : '' }}">
                        <li class="{{ (Session::get('active_sub_menu') == 'admin.users') ? 'navigation__active' : '' }}">
                            <a href="{{ route('admin.users.index')}}">
                                <i class="zwicon-users"></i>
                                Users
                            </a>
                        </li>
                    </ul>
                </li> -->
            @endif                                                
        </ul>
    </div>
</aside>