define(["app", "apps/content/content_view", "entities/content_element"], function(Grapho) {
    Grapho.module('ContentApp', function(ContentApp, Grapho, Backbone, Marionette, $, _) {
        ContentApp.Controller = {
            showContent: function(model) {
                var promise = Grapho.request("content:get", model);
                promise.then(function(data) {
                    var contentView = new ContentApp.Content({
                        model: data
                    });
                    Grapho.navigate(data.get("source") + (data.get("id") ? "/" + data.get("id") : ""));

                    Grapho.contentRegion.show(contentView);
                });
            },
            showHomepage: function() {
                var model = new Backbone.Model({
                    id: 0,
                    source: 'homepage'
                });
                this.showContent(model);
            },
            showProductById: function(id) {
                var model = new Backbone.Model({
                    id: id,
                    source: 'product'
                });
                this.showContent(model);
            },
            showPageById: function(id) {
                var model = new Backbone.Model({
                    id: id,
                    source: 'page'
                });
                this.showContent(model);
            },
            showCategoryById: function(id) {
                var model = new Backbone.Model({
                    id: id,
                    source: 'category'
                });
                this.showContent(model);
            }
        }
    });
});