<!-- todo: improve this to add javascript on load with PHALCON TAG -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.feed-list .feed').feed('handleAsynch', '{{"feed/refresh"}}');
    });
</script>
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
                                data-id="{{feed.getId()}}"
                                data-keysearch="{{feed.getLabel()}} {{feed.getCreator().getUsername()}}"
                                data-owner="{{feed.getCreator().getId()}}"
                                data-validate="{{feed.getValidate()}}"
                                data-type="{{feed.getType()}}">
                                {% set valid = true %}
                                {% if feed.getValidate() == 2 %}
                                <span class="label label-info"><i class="fa fa-check"></i></span>
                                {% elseif feed.getValidate() == 1 %}
                                <span class="label label-warning"><i class="fa fa-spin fa-spinner"></i></span>
                                {% else %}
                                <span class="label label-danger"><i class="fa fa-warning"></i></span>
                                {% endif %}
                                <span class="m-l-xs count">
                                    <strong>{{feed.getLabel()}}</strong>
                                    <small class="text-muted">
                                        [&nbsp;<i class="fa fa-star"></i>&nbsp;
                                        <span class="subscripes">{{feed.countSubscribes()}}</span>&nbsp;
                                        <i class="fa fa-heart"></i>&nbsp;
                                        <span class="likes">{{feed.countLikes()}}</span>
                                        &nbsp;]
                                    </small>
                                </span>
                                {% if feed.getValidate() == 2 %}
                                <div class="pull-right">
                                    {% set bSubscribed = feed.getUserFeed(feed.getCreator().getId()).getSubscribe() %}
                                    {% set bLiked = feed.getUserFeed(feed.getCreator().getId()).getLike() %}
                                    <i class="{{feed.getFeedType().getClass()}}"></i>&nbsp;
                                    <a href="{{url('feed/subscribe')}}"
                                       class="action {% if bSubscribed %}active text-info{% else %}inactive text-danger{% endif %}">
                                        <i class="fa fa-star"></i>
                                    </a>
                                    <a href="{{url('feed/like')}}"
                                       class="action {% if bLiked %}active text-info{% else %}inactive text-danger{% endif %}">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                    |&nbsp;
                                    <small><a href="{{url('wall/profile')}}/{{feed.getCreator().getId()}}">
                                        {{feed.getCreator().getUsername()}}</a> .
                                    </small>
                                </div>
                                {% elseif feed.getValidate() == 1 %}
                                    <div class="pull-right">
                                        <strong><small class="text-warning">
                                            Wait for approval.
                                        </small></strong>
                                        |&nbsp;
                                        <small><a href="{{url('wall/profile')}}/{{feed.getCreator().getId()}}">
                                            {{feed.getCreator().getUsername()}}</a> .
                                        </small>
                                    </div>
                                {% else %}
                                    <strong><small class="pull-right text-danger">
                                        This feed has been moderated.
                                    </small></strong>
                                {% endif %}
                            </li>
                            {% endfor %}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
