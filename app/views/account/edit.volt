<!-- todo: improve this to add javascript on load with PHALCON TAG -->
<script type="text/javascript">
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
        $('#wallpicture').bootstrapFileInput();
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
                            <h5>Account management
                                <small>You can change you personal information.</small>
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <form method="post" class="form-horizontal"
                                  enctype="multipart/form-data"
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
                                <div class="form-group"><label class="col-sm-2 control-label">Avatar</label>

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
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Profile picture</label>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="ibox float-e-margins">
                                                <div>
                                                    <div class="file-manager">
                                                        <br/>
                                                        <span class="file-control">You can upload your wall picture here.</span>

                                                        <div class="hr-line-dashed"></div>
                                                        <input type="file"
                                                               name="wallpicture"
                                                               id="wallpicture"
                                                               data-filename-placement="outside"
                                                               title="Upload File"/>

                                                        <div class="hr-line-dashed"></div>
                                                        <h5>Information</h5>
                                                        <ul class="folder-list">
                                                            <li>
                                                                <i class="fa fa-caret-right"></i>&nbsp;Name:
                                                                <span class="pull-right"><strong>{{user.getWallPicture().getName()}}</strong></span>
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-caret-right"></i>&nbsp;Extension:
                                                                <span class="pull-right"><strong>{{user.getWallPicture().getExtension()}}</strong></span>
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-caret-right"></i>&nbsp;Mime:
                                                                <span class="pull-right"><strong>{{user.getWallPicture().getMime()}}</strong></span>
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-caret-right"></i>&nbsp;Size:
                                                                <span class="pull-right"><strong>{{user.getWallPicture().getSize()}}&nbsp;ko</strong></span>
                                                            </li>
                                                        </ul>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 animated fadeInRight">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="file-box">
                                                        <div class="file">
                                                            <span class="corner"></span>

                                                            {{ image('img', 'class':'wallpicture col-md-12', 'src': user.getWallPicture().getPublicPath())}}
                                                            <div class="file-name">
                                                                {{user.getWallPicture().getName()}}.{{user.getWallPicture().getExtension()}}
                                                                <br>
                                                                <small>Added: {{user.getWallPicture().getAddDate()}}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
