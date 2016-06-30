Grapho.module('NavApp', function(NavApp, Grapho, Backbone, Marionette, $, _) {
    NavApp.NavElement = Marionette.ItemView.extend({
        tagName: "li",
        template: "#nav-element-template",
        events: {
            "click a": "navElect"
        },

        navElect: function(e) {
            e.preventDefault();
            this.trigger("page:elect", this.model);
            if (Grapho.Observer.Window.getStatus() === 'mobile') {
                this.trigger("menu:close");
            }
        }
    });

    NavApp.NavElements = Marionette.CompositeView.extend({
        template: "#nav-template",
        tagName: "nav",
        childView: NavApp.NavElement,
        childViewContainer: "ul",

        events: {
            'click .menu-top__button': 'clickMenuButton'
        },

        initialize: function(){
            this.listenTo(Grapho.Observer.Window, "window:desktop", this.setDesktopFunctions);
            this.listenTo(Grapho.Observer.Window, "window:mobile", this.setMobileFunctions);
            this.on("childview:menu:close", this.toggleMenu)
        },

        setDesktopFunctions: function() {
            this.clearMenu();
            console.log('Nav - DesktopFunctions');
        },

        toggleMenu: function() {
            this.$el.find('.menu-top__button').toggleClass("active");
            this.$el.find('.menu-top').slideToggle();
        },

        clickMenuButton: function(e) {
            e.preventDefault();
            this.toggleMenu();
        },

        clearMenu: function() {
            this.$el.find('.menu-top').removeAttr('style');
        },

        setMobileFunctions: function() {
            console.log('Nav - MobileFunctions');
        }
    })
});