define(["app"], function(Grapho) {
    Grapho.module('RoutingApp', function(RoutingApp, Grapho, Backbone, Marionette, $, _) {


        RoutingApp.Router = Marionette.AppRouter.extend({
            appRoutes: {
                "category/:id": "showCategory",
                "homepage": "showHomepage",
                "page/:id": "showPage",
                "product/:id": "showProduct"
            }
        });

            var API = {
                showDefault: function () {
                    require(["apps/sidebar/sidebar_controller", "apps/nav/nav_controller", "apps/observer/window_observer"], function() {
                        if (Grapho.Observer.Window.started) return false; // Если страница уже загружена (hack для обхода проблемы со ссылками внутри контента)

                        var promiseSidebar = Grapho.SidebarApp.Controller.listSidebarElements();
                        var promiseNav = Grapho.NavApp.Controller.listNavElements();

                        Promise.all([promiseSidebar, promiseNav]).then(function () {
                            Grapho.Observer.Window.setTriggers();
                            Grapho.Observer.Window.started = true; // якорь по которому мы определяем что сайт уже загружен и необходимо менять только Content
                        });
                    });
                },
                showHomepage: function () {
                    API.showDefault();

                    require(["apps/content/content_controller"], function() {
                        Grapho.ContentApp.Controller.showHomepage();
                    });
                },
                showPage: function (id) {
                    this.showDefault();

                    require(["apps/content/content_controller"], function() {
                        Grapho.ContentApp.Controller.showPageById(id);
                    });
                },
                showProduct: function (id) {
                    this.showDefault();

                    require(["apps/content/content_controller"], function() {
                        Grapho.ContentApp.Controller.showProductById(id);
                    });
                },
                showCategory: function (id) {
                    this.showDefault();

                    require(["apps/content/content_controller"], function() {
                        Grapho.ContentApp.Controller.showCategoryById(id);
                    });
                },
            };

            Grapho.on("homepage:trigger", function() {
                Grapho.navigate("homepage");
                API.showHomepage();
            });

            Grapho.addInitializer(function() {
                new RoutingApp.Router({
                    controller: API
                })
            });

        });



});