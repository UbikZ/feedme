<div id="wrapper">
    {% include "partials/menu.volt" %}
    <div id="page-wrapper" class="gray-bg">
        {% include "partials/header.volt" %}
        {% include "partials/breadcrumb.volt" %}
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
                            {% include "partials/errors" with ['errors': errors] %}
                            <form method="post" class="form-horizontal"
                                  id="feed-new"
                                  action="{{ url('feed/new')}}">
                                <div class="form-group"><label class="col-sm-2 control-label">Url</label>

                                    <div class="col-sm-10">
                                        {{ text_field("url", "class":"form-control")}}
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Type</label>

                                    <div class="col-sm-10">
                                        <select class="form-control" name="type">
                                            {% for type in feedTypes %}
                                            <option value="{{type.getId()}}">
                                                <i class="{{type.getClass()}}"></i>
                                                {{type.getLabel()|capitalize}}
                                            </option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Visibility</label>

                                    <div class="col-sm-10">
                                        <select class="form-control" name="public">
                                            <option value="0">Private</option>
                                            <option value="1">Public</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Description</label>

                                    <div class="col-sm-10">
                                        {{ text_area("description", "class":"form-control") }}
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