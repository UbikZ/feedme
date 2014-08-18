(function ($) {
    var methods = {
        init: function () {
            return this.each(function () {
                var $this = $(this);
            });
        },

        search: function (needle) {
            return this.each(function () {
                var $this = $(this);
                $.get($this.attr('href'), function (data) {
                    var o = JSON.parse(data);
                    if (!o.success) {
                        // todo : create notifs for this
                        console.error('Fail to load wall');
                    } else {

                    }
                });
            });
        }
    };

    $.fn.contact = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.contact');
        }
    };
})(jQuery);