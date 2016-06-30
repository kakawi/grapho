Grapho.module('ContentApp', function(ContentApp, Grapho, Backbone, Marionette, $, _) {
    ContentApp.Content = Marionette.ItemView.extend({
        template: "#content-template",
        className: "hlebon-content"
    })
});