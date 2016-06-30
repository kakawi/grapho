requirejs.config({
    baseUrl: "/bundles/catalog/js-require/min",
    paths: {
        jquery: "vendor/jquery",
        backbone: "vendor/backbone",
        marionette: "vendor/backbone.marionette",
        underscore: "vendor/underscore",
        text: "vendor/text",
        tpl: "vendor/underscore-tpl",
    },

    shim: {
        underscore: {
            exports: "_"
        },
        backbone: {
            deps: ["jquery", "underscore"],
            exports: "Backbone"
        },
        marionette: {
            deps: ["backbone"],
            exports: "Marionette"
        },
        tpl: ["text"],
    }
});

require(["marionette"], function(bbm) {
    console.log("jQuery version: ", $.fn.jquery);
    console.log("underscore identity call: ", _.identity(5));
    console.log("Marionette: ", bbm);
});

require(["app"], function(Grapho) {
    Grapho.start();
});