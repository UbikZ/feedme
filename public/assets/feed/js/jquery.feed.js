(function ($) {
    var methods = {
        init: function (urlRefresh) {
            return this.each(function () {
                var $this = $(this),
                    pbExclusive = $this.hasClass('checkspan-exclusive'),
                    $checkspans = $this.find('.checkspan'),
                    $inputSearch = $this.find('input[name=search]');
                // Bind click event
                $checkspans.click(function (event) {
                    event.preventDefault();
                    if (pbExclusive) {
                        $checkspans.removeClass('enabled');
                    }
                    $(this).toggleClass('enabled');
                    methods.loadList();
                });
                // Bind search event on enter key
                $inputSearch.keyup(function (event) {
                    event.preventDefault();
                    methods.loadList();
                });
                // Bin search event on "search button"
                $this.find('button.search').click(function (event) {
                    event.preventDefault();
                    if ($this.find('input[name=search]').val() != '') {
                        methods.loadList();
                    }
                });
            });
        },

        loadList: function (urlRefresh) {
            var $sections = $('.criterias .crit-row'),
                obj = {};

            $sections.each(function () {
                var $checkspans = $(this).find('.checkspan.enabled');
                if ($checkspans.length > 1) {
                    var tab = [],
                        propName;
                    $checkspans.each(function () {
                        $.each($(this).data(), function (name, value) {
                            propName = name;
                            tab.push(value);
                        });
                    });
                    var objTemp = {};
                    objTemp[propName] = tab;
                    obj = $.extend({}, obj, objTemp);
                } else {
                    obj = $.extend({}, obj, $checkspans.data());
                }
            });
            obj = $.extend({}, obj, {needle: $('.criterias .search input').val()});
            $list = $('ul.feed-list');
            $.post($list.data('url'), obj).done(
                function (data) {
                    var o = JSON.parse(data);
                    // Render with blueimp (add new syntax to not interfer with volt syntax)
                    tmpl.regexp = /([\s'\\])(?!(?:[^[]|\[(?!%))*%\])|(?:\[%(=|#)([\s\S]+?)%\])|(\[%)|(%\])/g;
                    $render = tmpl("tmpl-feeds", o);
                    $list.html($render);
                    $list.find('.feed').feed('handleAsynch', urlRefresh);
                }
            );
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