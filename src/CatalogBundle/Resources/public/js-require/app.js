define(["marionette"], function(Marionette) {
    var Grapho = new Marionette.Application();

    Grapho.addRegions({
        navRegion: "#nav-region",
        sidebarRegion: "#sidebar-region",
        contentRegion: "#content-region"
    });

    Grapho.navigate = function(route, options) {
        options || (options = {});
        Backbone.history.navigate(route, options);
    };

    Grapho.getCurrentRoute = function() {
        return Backbone.history.fragment;
    };

    Grapho.on('start', function() {
        if(Backbone.history) {
            require(["apps/routing_app"], function() {
                Backbone.history.start();

                if(Grapho.getCurrentRoute() === "") {
                    Grapho.trigger("homepage:trigger");
                }
            });
        }
    });

    return Grapho;
});