Grapho.module('Entities', function(Entities, Grapho, Backbone, Marionette, $, _) {
    Entities.SidebarElement = Backbone.Model.extend({
        urlRoot: 'sidebar'
    });

    Entities.Products = Backbone.Collection.extend({


    });

    Entities.SidebarCollection = Backbone.Collection.extend({
        url: 'sidebar',
        model: Entities.SidebarElement,
        parse: function(data) {
            _.each(data, function(category) {
                category.source = 'category';
                if (category.products.length !== 0) {
                    _.each(category.products, function(product) {
                        product.source = 'product';
                    })
                }
            });
            return data;
        }
    });

    var sidebarElements;

    var initializeSidebar = function() {
        sidebarElements = new Entities.SidebarCollection([
            {
                href: "#bla",
                title: "one"
            },
            {
                href: "#on",
                title:"second"
            },
            {
                href: "#th",
                title: "third"
            }
        ]);
    };

    var API = {
        getSidebarElements: function() {
            var sidebarElements = new Entities.SidebarCollection();
            return new Promise(function(resolve) {
                sidebarElements.fetch({
                    success: function(data) {
                        resolve(data);
                    }
                });

            });

            //if(sidebarElements.length === 0) {
            //    initializeSidebar();
            //}
            //return sidebarElements;
        }
    };

    Grapho.reqres.setHandler("sidebar:elements", function() {
        return API.getSidebarElements();
    })
});