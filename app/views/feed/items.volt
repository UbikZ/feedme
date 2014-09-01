<script type="text/javascript">
    $(function () {
        Galleria.loadTheme('galleria.classic.js');
        Galleria.configure({
            lightbox: true,
            debug: false,
            thumbnails: 'numbers',
            transition: 'fade',
            dataSort: 'random'
        });
        Galleria.ready(function(options) {
            this.attachKeyboard({
                left: this.prev,
                right: this.next
            });
        });
        Galleria.run('#pictures');
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
                    <div class="ibox-content others">
                        <h2><i class="fa fa-gears"></i> Non viewable items</h2>
                        <div class="divider"></div>
                        <ul>
                        {% for item in feedItems %}
                            {% if item.getExtract().imgNotViewable is defined %}
                            <li>
                                <a href="{{item.getExtract().imgNotViewable}}" target="_blank">
                                    {{ item.getTitle() }}
                                </a>
                            </li>
                            {% endif %}
                        {% endfor %}
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="ibox-content feed-listing">
                        <h2><i class="fa fa-rss"></i> Viewable items</h2>
                        <small>This is a random list of your subscribe feeds list</small>
                        <div id="pictures" class="m-t-md-m">
                            {% for item in feedItems %}
                                {% if item.getExtract().imgViewable is defined %}
                                    <a href="{{item.getExtract().imgViewable}}">
                                        <img src="{{item.getExtract().imgViewable}}"
                                             data-id="{{item.getId()}}"
                                             data-big="{{item.getExtract().imgViewable}}"
                                             data-title="{{item.getTitle()}}"
                                             data-description="">
                                    </a>
                                {% endif %}
                            {% endfor %}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
