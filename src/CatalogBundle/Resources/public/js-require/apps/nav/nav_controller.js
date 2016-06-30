define(["app", "apps/nav/nav_view", "entities/nav_element"], function(Grapho) {
    Grapho.module('NavApp', function(NavApp, Grapho, Backbone, Marionette, $, _) {
        NavApp.Controller = {
            listNavElements: function() {
                var promise = Grapho.request("nav:elements");

                return promise.then(function(navElements) {
                    var navListView = new NavApp.NavElements({
                        collection: navElements
                    });

                    navListView.on("childview:page:elect", function(childView, model) {
                        if (model.get("name") === "Цены") {
                            window.location.href = model.get("url");
                        } else {
                            Grapho.ContentApp.Controller.showContent(model);
                        }
                    });

                    Grapho.navRegion.show(navListView);
                });
            }
        }
    });
});