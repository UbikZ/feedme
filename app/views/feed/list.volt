<!-- todo: improve this to add javascript on load with PHALCON TAG -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.criterias .crit-row').feed();
        $('.feed-list .feed').feed('handleAsynch', '{{url("feed/refresh")}}');
        $('body').feed('loadList');
    });
</script>
<div id="wrapper">
    {% include "partials/menu.volt" %}
    <div id="page-wrapper" class="gray-bg">
        {% include "partials/header.volt" %}
        {% include "partials/breadcrumb.volt" %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ibox-content criterias">
                        <h2><i class="fa fa-gears"></i> Search engine</h2>

                        <div class="crit-row search form-group m-t">
                            <div class="input-group">
                                {{ text_field("search", "class":"form-control", "placeholder":"Search a feed")}}
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="crit-row validation form-group m-t-md-m">
                            <strong class="pull-right">Validation criteria</strong>

                            <div>
                                <a href="#" class="checkspan enabled" data-validate="2"><i class="fa fa-check"></i></a>
                                <a href="#" class="checkspan enabled" data-validate="1"><i
                                        class="fa fa-warning"></i></a>
                                <a href="#" class="checkspan enabled" data-validate="0"><i
                                        class="fa fa-spinner"></i></a>
                            </div>
                        </div>
                        <div class="crit-row order-like checkspan-exclusive form-group m-t-md-m">
                            <div>
                                <strong class="pull-right">Order Subscriptions</strong>
                                <a href="#" class="checkspan" data-order="subscribe" data-direction="asc">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-sort-amount-asc"></i>
                                </a>
                                <a href="#" class="checkspan enabled" data-order="subscribe" data-direction="desc">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-sort-amount-desc"></i>
                                </a><br/>
                            </div>
                            <div class="m-t-md-m">
                                <strong class="pull-right">Order likes</strong>
                                <a href="#" class="checkspan" data-order="like" data-direction="asc">
                                    <i class="fa fa-heart"></i>
                                    <i class="fa fa-sort-amount-asc"></i>
                                </a>
                                <a href="#" class="checkspan" data-order="like" data-direction="desc">
                                    <i class="fa fa-heart"></i>
                                    <i class="fa fa-sort-amount-desc"></i>
                                </a>
                            </div>
                        </div>
                        <div class="crit-row limit checkspan-exclusive form-group m-t-md-m">
                            <strong class="pull-right">Limitation</strong>
                            <strong>
                                <div>
                                    <a href="#" class="checkspan" data-limit="10">10</a>
                                    <a href="#" class="checkspan enabled" data-limit="20">20</a>
                                    <a href="#" class="checkspan" data-limit="50">50</a>
                                </div>
                            </strong>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox-content feed-listing">
                        <h2><i class="fa fa-rss"></i> Feeds List</h2>
                        <small>This is an exhaustive list of all public feeds available.</small>
                        <ul class="feed-list m-t" data-url="{{url('feed/load')}}">
                            <script type="text/x-tmpl" id="tmpl-feeds">
                            [% for (var i=0; i<o.feeds.length; i++) { %]
                                [% var feed = o.feeds[i]; %]
                                <li class="feed">
                                    [% var valid=true; %]
                                    [% if (feed.validate == 2) { %]
                                        <span class="label label-info"><i class="fa fa-check"></i></span>
                                    [% } else if (feed.validate == 1) { %]
                                        <span class="label label-warning"><i class="fa fa-spin fa-spinner"></i></span>
                                    [% } else { %]
                                        <span class="label label-danger"><i class="fa fa-warning"></i></span>
                                    [% } %]
                                    <span class="m-l-xs count">
                                        <strong><a href="[%=feed.url%]">[%= feed.label %]</a></strong>
                                        <small class="text-muted">
                                            [&nbsp;<i class="fa fa-star"></i>&nbsp;
                                            <span class="subscribes">[%= feed.countSubscribes %]</span>&nbsp;
                                            <i class="fa fa-heart"></i>&nbsp;
                                            <span class="likes">[%= feed.countLikes %]</span>
                                            &nbsp;]&nbsp;
                                        </small>
                                    </span>
                                    [% if (feed.validate == 2) { %]
                                        <div class="pull-right">
                                            [% var bSubscribed = feed.userFeed.subscribe; %]
                                            [% var bLiked = feed.userFeed .like; %]
                                            <i class="[%= feed.feedType.class %]"></i>&nbsp;
                                            <a href="[%= o.baseUri %]feed/post/subscribe"
                                               class="action [% if (bSubscribed) { %]active text-info[% } else { %]inactive text-danger [% } %]">
                                                <i class="fa fa-star"></i>
                                            </a>
                                            <a href="[%= o.baseUri %]feed/post/like"
                                               class="action [% if (bLiked) { %]active text-info[% } else { %]inactive text-danger [% } %]">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                            |&nbsp;
                                            <small><a href="[%= o.baseUri %]wall/profile/[%= feed.creator.id %]">
                                                [%= feed.creator.username %]</a> .
                                            </small>
                                        </div>
                                    [% } else if (feed.validate == 1) { %]
                                        <div class="pull-right">
                                            <strong>
                                                <small class="text-warning">
                                                    Wait for approval.
                                                </small>
                                            </strong>
                                            |&nbsp;
                                            <small><a href="[%= o.baseUri %]wall/profile/[%= feed.creator.id %]">
                                                [%= feed.creator.username %]</a> .
                                            </small>
                                        </div>
                                    [% } else { %]
                                        <strong>
                                            <small class="pull-right text-danger">
                                                This feed has been moderated.
                                            </small>
                                        </strong>
                                    [% } %]
                                </li>
                            [% } %]

                            </script>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox-content statistics">
                        <h2><i class="fa fa-bar-chart-o"></i> Statistics</h2>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
