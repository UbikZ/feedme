<div id="wrapper">
    {% include "partials/menu" with ['auth': auth] %}
    <div id="page-wrapper" class="gray-bg">
        {% include "partials/header" with ['auth': auth] %}
        {% include "partials/breadcrumb" with ['name': name] %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                {% for user in users %}
                <div class="col-lg-4">
                    <div class="contact-box">
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
                                    <i class="fa fa-envelope"></i>&nbsp;<strong>5</strong>&nbsp;Posts
                                    <i class="fa fa-star"></i>&nbsp;<strong>28</strong>&nbsp;Favorites
                                    <i class="fa fa-heart"></i>&nbsp;<strong>240</strong>&nbsp;Likes
                                </p>
                                <address>
                                    <strong>Galilée, Inc.</strong><br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
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