Grapho.module('SidebarApp', function(SidebarApp, Grapho, Backbone, Marionette, $, _) {
    SidebarApp.Controller = {
        listSidebarElements: function() {
            var promise = Grapho.request("sidebar:elements");

            return promise.then(function(sidebarElements) {
                var sidebarListView = new SidebarApp.SidebarElements({
                    collection: sidebarElements
                });

                sidebarListView.on("childview:sidebar:elect", function(childView, model) {
                    Grapho.ContentApp.Controller.showContent(model);
                });

                sidebarListView.on("childview:childview:sidebar:elect", function(childView1, childView2, model) {
                    Grapho.ContentApp.Controller.showContent(model);
                });

                Grapho.sidebarRegion.show(sidebarListView);
            });
        }
    };
});