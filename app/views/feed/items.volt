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
                        <div id="blueimp-gallery-carousel" class="blueimp-gallery blueimp-gallery-controls blueimp-gallery-carousel">
                            <div class="slides"></div>
                            <h3 class="title"></h3>
                            <a class="prev">‹</a>
                            <a class="next">›</a>
                            <a class="play-pause"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
