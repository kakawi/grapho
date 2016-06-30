define(["app"], function(Grapho) {
    Grapho.module('Entities', function(Entities, Grapho, Backbone, Marionette, $, _) {
        Entities.Content = Backbone.Model.extend({
            urlRoot: '/ajax/content'
        });

        var API = {
            getContent: function(id, source) {
                var content = new Entities.Content({
                    id: id
                });

                return new Promise(function(resolve) {
                    content.fetch({
                        data: {source: source},
                        success: function(data) {
                            resolve(data);
                        }
                    })
                });
            }
        };

        Grapho.reqres.setHandler("content:get", function(model) {
            var source = model.get("source");
            var id = model.get("id");

            return API.getContent(id, source);
        });
    });
});