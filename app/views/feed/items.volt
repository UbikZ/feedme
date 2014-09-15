<script type="text/javascript">
    $(function () {
        $(".items").feed('loadSlideshow', '{{url("feed/itemsload")}}', '{{url("feed/view")}}');
    });
</script>
<div id="wrapper" class="items">
    {% include "partials/menu.volt" %}
    <div id="page-wrapper" class="gray-bg">
        {% include "partials/header.volt" %}
        {% include "partials/breadcrumb.volt" %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ibox-content others">
                        <h2><i class="fa fa-gears"></i> Non viewable items</h2>

                        <div class="divider"></div>
                        <ul>
                            Not available for now
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="ibox-content feed-listing">
                        <h2><i class="fa fa-rss"></i> Viewable items</h2>
                        <small>This is a random list of your subscribe feeds list</small>
                        <div id="pictures" class="m-t-md-m">
                            <script type="text/x-tmpl" id="tmpl-slideshow">
                            [% for (var i=0; i<o.items.length; i++) { %]
                                [% if (o.items[i].extract.imgViewable != "undefined") { %]
                                    <a href="[%= o.items[i].extract.imgViewable %]">
                                        <img src="[%= o.items[i].extract.imgViewable %]"
                                             data-id="[%= o.items[i].id %]"
                                             data-big="[%= o.items[i].extract.imgViewable %]"
                                             data-title="[%= o.items[i].title %]"
                                             data-description="">
                                    </a>
                                [% } %]
                            [% } %]
                        </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
