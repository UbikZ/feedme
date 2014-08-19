<!-- todo: improve this to add javascript on load with PHALCON TAG -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.feed-activity-list').wall(
                'load',
                "{{url('wall/information')}}/{{user.getId()}}",
                "{{url('wall/post')}}//{{user.getId()}}"
        );
    });
</script>
<div id="wrapper">
    {% include "partials/menu" with ['auth': auth] %}
    <div id="page-wrapper" class="gray-bg">
        {% include "partials/header" with ['auth': auth] %}
        {% include "partials/breadcrumb" with ['name': name] %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Profile Detail</h5>
                        </div>
                        <div>
                            <div class="ibox-content wallfile no-padding border-left-right">
                                {% if user.getWallPicture().getPublicPath() %}
                                    {{ image('img', 'class':'wallpicture col-md-12', 'src': user.getWallPicture().getPublicPath())}}
                                {% endif %}
                            </div>
                            <div class="ibox-content profile-content">
                                <h4>
                                    <strong>
                                        {{user.getFirstname()}}&nbsp;
                                        `{{user.getUsername()}}`
                                        {{user.getLastname()}}&nbsp;
                                    </strong>
                                </h4>

                                <p>
                                    <i class="fa fa-institution"></i>&nbsp;{{user.getSociety()}}&nbsp;
                                    <i class="fa fa-map-marker"></i>&nbsp;{{user.getAddress()}}
                                </p>
                                <h5>About me</h5>
                                <p>{{user.getAbout()}}</p>

                                <div class="row m-t-lg">
                                    <div class="col-md-4">
                                        <h5>
                                            <i class="fa fa-envelope"></i>&nbsp;
                                            <strong id="count_post"></strong>&nbsp;Posts
                                        </h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5><i class="fa fa-star"></i>&nbsp;<strong>0</strong>&nbsp;Favorites</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5><i class="fa fa-heart"></i>&nbsp;<strong>0</strong>&nbsp;Likes</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Wall messages</h5>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <div class="feed-activity-list">
                                    <div>
                                        <form class="form-message" method="post">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                                <input name="message" type="text" class="form-control message" placeholder="Write a message"/>
                                            </div>
                                            <div class="divider"></div>
                                        </form>
                                    </div>
                                    <div class="messages">
                                        {% include "wall/partials/wall_messages.volt" %}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>