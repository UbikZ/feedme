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
                        <li><a href="{{ url('account/edit') }}">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('session/logout') }}">Logout</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span class="nav-label">Account</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ url('account/edit') }}">Profile</a></li>
                    <li><a href="#">Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-rss-square"></i>
                    <span class="nav-label">Feeds</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li><a href="#">Manage</a></li>
                    <li><a href="#">Reader</a></li>
                    <li><a href="#">Viewer</a></li>
                    <li><a href="#">Statistics</a></li>
                </ul>
            </li>
            {% if auth['bAdmin']%}
            <li>
                <a href="#">
                    <i class="fa fa-gear"></i>
                    <span class="nav-label">Admin manager</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li><a href="#">Users</a></li>
                    <li><a href="#">Feeds</a></li>
                    <li><a href="#">Statistics</a></li>
                </ul>
            </li>
            {% endif %}
        </ul>
    </div>
</nav>
