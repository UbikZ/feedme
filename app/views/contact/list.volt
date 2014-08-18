<!-- todo: improve this to add javascript on load with PHALCON TAG -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#search').contact('search');
    });
</script>
<div id="wrapper">
    {% include "partials/menu" with ['auth': auth] %}
    <div id="page-wrapper" class="gray-bg">
        {% include "partials/header" with ['auth': auth] %}
        {% include "partials/breadcrumb" with ['name': name] %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Search contact
                                <small>You can search one contact here by fistname, lastname or username.</small>
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {{ text_field("search", "class":"form-control", "placeholder":"Search you contact")
                                    }}
                                </div>
                            </div>
                            </br>
                        </div>
                    </div>
                </div>
                {% for user in users %}
                <div class="col-lg-4 box">
                    <div
                        class="contact-box"
                        data-keysearch=
                                "{{user.getUsername()|lower}} {{user.getFirstname()|lower}} {{user.getLastname()|lower}}"
                    >
                        <a href="{{url('wall/profile')}}/{{user.getId()}}">
                            <div class="col-sm-4">
                                <div class="text-center">
                                    {{ image('img', 'class': 'img-contact img-circle', 'src':
                                    user.getUserPicture().getPath())}}
                                    <div class="m-t-xs font-bold">{{user.getUsername()}}</div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h3><strong>{{user.getFirstname()}}&nbsp;{{user.getLastname()}}</strong></h3>

                                <p>
                                    <i class="fa fa-envelope"></i>&nbsp;<strong>{{user.getAllMessages().count()}}</strong>&nbsp;Posts
                                    <i class="fa fa-star"></i>&nbsp;<strong>0</strong>&nbsp;Favorites
                                    <i class="fa fa-heart"></i>&nbsp;<strong>0</strong>&nbsp;Likes
                                </p>
                                <address>
                                    <strong>{{user.getSociety()}}, Inc.</strong><br>
                                    {{user.getAddress()}}<br>
                                </address>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                </div>
                {% endfor %}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.contact-box').each(function () {
            animationHover(this, 'pulse');
        });
    });
</script>