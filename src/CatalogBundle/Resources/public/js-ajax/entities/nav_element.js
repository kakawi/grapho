Grapho.module('Entities', function(Entities, Grapho, Backbone, Marionette, $, _) {
    Entities.NavElement = Backbone.Model.extend({
        urlRoot: 'page',
        defaults: {
            'source': 'page'
        }
    });

    Entities.NavCollection = Backbone.Collection.extend({
        url: 'page',
        model: Entities.NavElement,
        parse: function(data) {
            data.forEach(function(item) {
                item['title'] = item['name'];
                item['href'] = item['id']
            });
            return data;
        }
    });

    var navElements;

    var initializeNav = function() {
        navElements = new Entities.NavCollection([
            {
                href: "#bla",
                title: "Ц"
            },
            {
                href: "#on",
                title:"Тр"
            },
            {
                href: "#th",
                title: "Оп "
            },
            {
                href: "#contacts",
                title: "Кон"
            }
        ]);
        return navElements;
    };

    var API = {
        getNavElements: function() {
            var navElements = new Entities.NavCollection();

            var promise = new Promise(function(resolve) {
                navElements.fetch({
                    success: function(data) {
                        resolve(data);
                    }
                });
            });
            
            return promise.then(function(navElements) {
                if(navElements.length === 0) {
                    return initializeNav();
                } else {
                    return navElements;
                }
            });
        }
    };

    Grapho.reqres.setHandler("nav:elements", function() {
        return API.getNavElements();
    })
});