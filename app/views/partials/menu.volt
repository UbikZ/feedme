<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown">
                    <p>{{ image('img', 'class': 'img-profile img-circle', 'src':'assets/dashboard/img/user-profile.png') }}</p>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                {{auth['firstname']}}&nbsp;<strong class="font-bold">{{auth['lastname']}}</strong>
                            </span>
                            <p class="text-muted text-xs block">
                                {% if auth['bAdmin']%}Administrator{% else %}User{% endif %}
                                <b class="caret"></b>
                            </p>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        {{dashboard.getUserMenu()}}
                    </ul>
                </div>
            </li>
            {{dashboard.getNavMenu()}}
        </ul>
    </div>
</nav>
