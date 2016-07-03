requirejs.config({
    baseUrl: "/bundles/catalog/js-require/min/",
    paths: {
        jquery: "vendor/jquery",
        backbone: "vendor/backbone",
        marionette: "vendor/backbone.marionette",
        underscore: "vendor/underscore",
        text: "vendor/text",
        tpl: "vendor/underscore-tpl"
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
        tpl: ["text"]
    }
});

require(["app"], function(Grapho) {
    Grapho.start();
});