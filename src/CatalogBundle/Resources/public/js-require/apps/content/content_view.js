define(["app",
    "tpl!apps/content/templates/content_template.tpl"], function(Grapho, contentTpl) {
    Grapho.module('ContentApp', function(ContentApp, Grapho, Backbone, Marionette, $, _) {
        ContentApp.Content = Marionette.ItemView.extend({
            template: contentTpl,
            className: "hlebon-content"
        })
    });
});