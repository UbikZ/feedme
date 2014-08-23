(function ($) {
    var methods = {
        init: function () {
            return this.each(function () {
                var $this = $(this),
                    pbExclusive = $this.hasClass('checkspan-exclusive'),
                    $checkspans = $this.find('.checkspan');
                $checkspans.click(function() {
                    if (pbExclusive) {
                        $checkspans.removeClass('enabled');
                    }
                    $(this).toggleClass('enabled');
                    methods.loadList();
                });
            });
        },

        loadList: function () {
            var $checkspansEnabled = $('.checkspan.enabled'),
                validations = $checkspansEnabled.data('validid'),
                orderSubscribe = $checkspansEnabled.data('ordersub'),
                orderLike = $checkspansEnabled.data('orderlike'),
                limit = $checkspansEnabled.data('limit');
            $('.feed-list li.feed').each(function() {

            });
        },

        handleAsynch: function (urlRefresh) {
            return this.each(function () {
                var $this = $(this);
                $this.find('a').click(function (event) {
                    var $that = $(this);
                    event.preventDefault();
                    $.post(
                        $(this).attr('href'),
                        {value: $(this).hasClass('inactive'), idfeed: $this.data('id')}
                    ).done(
                        function (data) {
                            var o = JSON.parse(data);
                            if (o.success) {
                                if (o.active) {
                                    $that.removeClass('inactive text-danger').addClass('active text-info');
                                } else {
                                    $that.addClass('inactive text-danger').removeClass('active text-info');
                                }
                                $this.feed('handleRefresh', urlRefresh);
                                $.notify(o.message.content, o.message.success, {style: 'feedme'});
                            } else {
                                // todo : create notifs for this
                                console.error("Fail when post");
                            }
                        }
                    );
                });
            });
        },

        handleRefresh: function (url) {
            return this.each(function () {
                var $this = $(this),
                    urlRefresh = url + '/' + $this.data('id');
                $.get(urlRefresh, function (data) {
                    var o = JSON.parse(data);
                    if (!o.success) {
                        // todo : create notifs for this
                        console.error('Fail to load wall');
                    } else {
                        $this.find('span.subscribes').text(o.countSubscribes);
                        $this.find('span.likes').text(o.countLikes);
                    }
                });
            });
        }
    };

    $.fn.feed = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.feed');
        }
    };
})(jQuery);