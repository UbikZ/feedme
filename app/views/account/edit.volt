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
                            <form method="post" class="form-horizontal" action="{{ url('account/edit')}}/{{user.getId()}}">
                            <div class="form-group"><label class="col-lg-2 control-label">E-mail</label>

                                <div class="col-lg-10"><p class="form-control-static">{{ user.getEmail() }}</p></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">Username</label>

                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon">@</span>
                                        {{ text_field("username", "class":"form-control", "value":user.getUsername()) }}
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">Firstname</label>

                                <div class="col-sm-10">
                                    {{ text_field("firstname", "class":"form-control", "value":user.getFirstname()) }}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">Lastname</label>

                                <div class="col-sm-10">
                                    {{ text_field("lastname", "class":"form-control", "value":user.getLastname()) }}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">Password</label>

                                <div class="col-sm-10">
                                    {{ password_field("password", "class":"form-control") }}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            {{ submit_button("Save", "class":"btn btn-primary block btn-block") }}

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
