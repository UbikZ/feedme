(function ($) {
    var methods = {
        init:function () {
            return this.each(function () {
                var $this = $(this);
            });
        },

        loadWall:function (url) {
            var urlLoad = url;
            return this.each(function () {
                var $this = $(this);
                $.get(url, function(data) {
                    if (!data.success) {
                        console.info('not good');
                    } else {
                        console.info('good');
                    }
                });
            });
        }
    };

    $.fn.wall = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.wall');
        }
    };
})(jQuery);