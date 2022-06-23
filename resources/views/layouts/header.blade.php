<header class="header">
    <div class="navigation-trigger d-xl-none" data-sa-action="aside-open" data-sa-target=".sidebar">
        <i class="zwicon-hamburger-menu"></i>
    </div>
    <div class="logo d-none d-sm-inline-flex">        
        <img class="user__img" src="{{ asset('img/logo.png') }}" alt="">
        <a href="{{ route('step1')}}">{{ config('app.name', 'Laravel') }}</a>
    </div>
    <div class="user align-right">
        <div class="user__info" data-toggle="dropdown">            
            <img class="user__img" src="{{ asset('img/user.png') }}" alt="">
            <div>
                <div class="user__name"><p>{{ Auth::user()->username }}</p></div>
                <div class="user__email"><p>{{ Auth::user()->email }}</p></div>                            
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu--invert">
            <a class="dropdown-item" href="{{ route('myprofile')}}">My Profile</a>
            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
        </div>
    </div>
</header>