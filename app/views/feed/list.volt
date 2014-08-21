<div id="wrapper">
    {% include "partials/menu.volt" %}
    <div id="page-wrapper" class="gray-bg">
        {% include "partials/header.volt" %}
        {% include "partials/breadcrumb.volt" %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox-content">
                        <h2><i class="fa fa-gears"></i> Search engine</h2>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox-content">
                        <h2><i class="fa fa-rss"></i> Feed List</h2>
                        <small>This is an exhaustive list of all public feeds available.</small>
                        <ul class="feed-list m-t">
                            {% for feed in listFeeds %}
                            <li class="feed"
                                data-keysearch="{{feed.getLabel()}} {{feed.getCreator().getUsername()}}"
                                data-owner="{{feed.getCreator().getId()}}"
                                data-validate="{{feed.getValidate()}}"
                                data-type="{{feed.getType()}}">
                                {% if feed.getValidate() == 2 %}
                                <span class="label label-info"><i class="fa fa-check"></i></span>
                                {% elseif feed.getValidate() == 1 %}
                                <span class="label label-warning"><i class="fa fa-spin fa-spinner"></i></span>
                                {% else %}
                                <span class="label label-danger"><i class="fa fa-warning"></i></span>
                                {% endif %}
                                <span class="m-l-xs"><strong>{{feed.getLabel()}}</strong></span>

                                <div class="pull-right">
                                    <small><a href="{{url('wall/profile')}}/{{feed.getCreator().getId()}}">
                                        {{feed.getCreator().getUsername()}}</a> .
                                    </small>
                                    <i class="{{feed.getFeedType().getClass()}}"></i>
                                </div>
                            </li>
                            {% endfor %}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
