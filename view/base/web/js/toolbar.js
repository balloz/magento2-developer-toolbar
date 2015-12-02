define(['jquery'], function($) {
    var Toolbar = function(config, element) {
        var $el = this.$el = $(element);
        this.config = config;
        this.bindEvents();
    };

    Toolbar.prototype = {
        bindEvents: function() {
            var self = this,
                $el = this.$el;

            this.$el.on('click', '.balloz-toolbar-panels-container a', function(e) {
                e.preventDefault();

                var $this = $(this),
                    active = $this.hasClass('active');

                $('.balloz-toolbar-panel-label a').removeClass('active');
                $('.balloz-toolbar-panel-content').hide();

                if (!active) {
                    $(this).addClass('active');
                    $($this.attr('href')).toggle();
                }
            });

            this.$el.on('click', '.balloz-toolbar-min', function(e) {
                e.preventDefault();

                var $this = $(this);

                if ($el.hasClass('balloz-toolbar-hidden-left')) {
                    $el.removeClass('balloz-toolbar-hidden-left');
                } else if ($el.hasClass('balloz-toolbar-hidden-right')) {
                    $el.removeClass('balloz-toolbar-hidden-right');
                } else {
                    if ($this.hasClass('balloz-toolbar-min-left')) {
                        $el.addClass('balloz-toolbar-hidden-left');
                    } else if ($this.hasClass('balloz-toolbar-min-right')) {
                        $el.addClass('balloz-toolbar-hidden-right');
                    }
                }
            });
        }
    };

    return function(config, element) {
        return new Toolbar(config, element);
    };
});
