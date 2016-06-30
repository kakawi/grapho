Grapho.module('Observer.Window', function(Window, Grapho, Backbone, Marionette, $, _) {
    var mobile = 800;
    var width = $(window).width();
    var desktopTrigger = "window:desktop";
    var mobileTrigger = "window:mobile";

    Window.setTriggers = function() {
        if (width <= mobile) {
            setStatus('mobile');
            Window.trigger(mobileTrigger);
        } else {
            setStatus('desktop');
            Window.trigger(desktopTrigger);
        }

        $(window).on('resize', function(e) {
            width = $(window).width();
            if (width <= mobile && Window.getStatus() === 'desktop') {
                Window.trigger(mobileTrigger);
                setStatus('mobile');

            } else if (width > mobile && Window.getStatus() === 'mobile') {
                Window.trigger(desktopTrigger);
                setStatus('desktop');
            }
        });
    };

    var setStatus = function(status) {
        Window.status = status;
    };

    Window.getStatus = function() {
        return Window.status;
    };
});