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
                            <h5>Account management
                                <small>You can change you personal information.</small>
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <form method="post" class="form-horizontal"
                                  id="edit-account"
                                  action="{{ url('account/edit')}}/{{user.getId()}}">
                                <div class="form-group"><label class="col-lg-2 control-label">E-mail</label>
                                    <div class="col-lg-10"><p class="form-control-static">{{ user.getEmail() }}</p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Username</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon">@</span>
                                            {{ text_field("username", "class":"form-control",
                                            "value":user.getUsername()) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Firstname</label>
                                    <div class="col-sm-10">
                                        {{ text_field("firstname", "class":"form-control", "value":user.getFirstname())
                                        }}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Lastname</label>
                                    <div class="col-sm-10">
                                        {{ text_field("lastname", "class":"form-control", "value":user.getLastname()) }}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Society</label>
                                    <div class="col-sm-10">
                                        {{ text_field("society", "class":"form-control", "value":user.getSociety()) }}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Address</label>
                                    <div class="col-sm-10">
                                        {{ text_field("address", "class":"form-control", "value":user.getAddress()) }}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-10">
                                        {{ password_field("password", "class":"form-control") }}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">About me</label>
                                    <div class="col-sm-10">
                                        {{ text_area("about", "class":"form-control", "value":user.getAbout()) }}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                {{ hidden_field('picture', 'value': user.getUserPicture().getId()) }}
                                <div class="form-group"><label class="col-sm-2 control-label">Image Profile</label>
                                    <div class="row">
                                        {% for img in images %}
                                        <div class="picturebox col-md-1" data-id="{{img.getId()}}">
                                            <a class="thumbnail {% if img.getId() == user.getUserPicture().getId()%}active{% endif %}">
                                                {{ image(
                                                    'img',
                                                    'data-source': 'holder.js/100x100',
                                                    'class': 'img-circle m-t-xs',
                                                    'src': img.getPath())
                                                }}
                                            </a>
                                        </div>
                                        {% endfor %}
                                    </div>
                                </div>
                                {{ submit_button("Save", "class":"btn btn-primary block btn-block") }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.picturebox').each(function () {
            animationHover(this, 'pulse');
        });
        $('.picturebox').click(function () {
            var $thumb = $(this).find('.thumbnail'),
                $thumbs = $('.picturebox .thumbnail');
            if (!$thumb.hasClass('active')) {
                $thumbs.removeClass('active');
                $thumb.addClass('active');
            }
            $('form#edit-account input[type=hidden]').val($(this).data('id'));
        });
    });
</script>
