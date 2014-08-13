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
                            <div class="ibox-content no-padding border-left-right">
                                <!-- image profile (not user picture)-->
                            </div>
                            <div class="ibox-content profile-content">
                                <h4>
                                    <strong>
                                        {{currentUser.getFirstname()}}&nbsp;
                                        `{{currentUser.getUsername()}}`
                                        {{currentUser.getLastname()}}&nbsp;
                                    </strong>
                                </h4>

                                <p><i class="fa fa-map-marker"></i>&nbsp;My address</p>
                                <h5>About me</h5>

                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt
                                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitat.
                                </p>

                                <div class="row m-t-lg">
                                    <div class="col-md-4">
                                        <h5><i class="fa fa-envelope"></i>&nbsp;<strong>169</strong> Posts</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5><i class="fa fa-star"></i>&nbsp;<strong>28</strong> Favorites</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5><i class="fa fa-heart"></i>&nbsp;<strong>240</strong> Likes</h5>
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
                                    <div class="feed-element">
                                        <a href="#" class="pull-left">
                                            {{image('img', 'class':'image-circle',
                                            'src':'assets/dashboard/img/profiles/face-1.png')}}
                                        </a>

                                        <div class="media-body ">
                                            <strong>Gabriel Malet</strong>.
                                            <br>
                                            <small class="text-muted">4:21 pm - 12.06.2014</small>
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry.
                                                Lorem
                                                Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                Over the years, sometimes by accident, sometimes on purpose (injected
                                                humour
                                                and
                                                the like)
                                            </p>

                                            <div class="answer">
                                                <div class="messages">
                                                    <a href="#" class="pull-left">
                                                        {{image('img', 'class':'image-circle',
                                                        'src':'assets/dashboard/img/profiles/face-1.png')}}
                                                    </a>
                                                    <strong>Gabriel Malet</strong>
                                                    <small class="text-muted">4:21 pm - 12.06.2014</small>
                                                    <div>
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting
                                                        industry.
                                                        Lorem
                                                        Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                        Over the years, sometimes by accident, sometimes on purpose (injected
                                                        humour
                                                        and
                                                        the like)
                                                    </div>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="reply">
                                                    <input type="text" class="form-control" placeholder="Write a messsage"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="feed-element">
                                        <a href="#" class="pull-left">
                                            {{image('img', 'class':'image-circle',
                                            'src':'assets/dashboard/img/profiles/face-2.jpg')}}
                                        </a>

                                        <div class="media-body ">
                                            <strong>Fistname Lastname</strong>.
                                            <br>
                                            <small class="text-muted">2:21 pm - 12.06.2014</small>
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry.
                                                Lorem
                                                Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                Over the years, sometimes by accident, sometimes on purpose (injected
                                                humour
                                                and
                                                the like)
                                            </p>

                                            <p class="answer">

                                            </p>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary btn-block m"><i class="fa fa-arrow-down"></i> Show
                                        More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>