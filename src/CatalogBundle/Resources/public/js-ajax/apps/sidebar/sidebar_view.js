Grapho.module('SidebarApp', function(SidebarApp, Grapho, Backbone, Marionette, $, _) {

    SidebarApp.NoSubMenuView = Marionette.ItemView.extend({
        tagName: "li",
        template: "#sidebar-no-sub-menu-template",

        events: {
            "click a": "electProduct"
        },

        electProduct: function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.trigger("sidebar:elect", this.model); // show content
            if (Grapho.Observer.Window.getStatus() === 'mobile') {
                this.trigger("menu:close");
            } else {
                this.$el.parents('li').mouseout(); // hide menu after click on product
            }
        },

    });

    SidebarApp.SidebarSubMenu = Marionette.CompositeView.extend({
        tagName: "li",
        template: "#sidebar-sub-menu-template",
        childViewContainer: "ul",
        childView: SidebarApp.NoSubMenuView,

        initialize: function(){
            this.listenTo(Grapho.Observer.Window, "window:desktop", this.setDesktopFunctions);
            this.listenTo(Grapho.Observer.Window, "window:mobile", this.setMobileFunctions);

            var products = this.model.get('products');
            var productsCollection = new Grapho.Entities.Products(products);
            this.model.set('products', productsCollection);
            this.collection = this.model.get('products');
        },

        setDesktopFunctions: function() {
            console.log('Desktop');
            this.clearMobileFunctions();

            // Выбор категории в Desktop режиме
            var self = this;
            this.$el.find('a.parent').click(function(e) {
                e.preventDefault();
                self.trigger("sidebar:elect", self.model); // show content
                self.$el.mouseout(); // hide menu after click on category
            });

            // Наведение на category в Desktop
            this.$el.hover(
                /* Функция исполняется, когда мышь входит в область меню */
                function mouseOver() {
                    clearTimeout($.data(this, 'timer')); /* если мы успели вернуться мышкой на меню, до того как прошла задержка на закрытие, то таймер обнуляется и сворачивание меню не произойдет*/
                    /* если использовать stop(true, FALSE), то скачка на конец анимации не будет (false стоит по умолчанию) */
                    $(this).find('> ul').stop(true).slideDown(300); /* анимация разворачивания меню */
                },

                /* Функция исполняется, когда мышь покидает область меню */
                function mouseOut() {
                    var $this = $(this); /* запоминаем окружение, т.к. в Таймере мы до него не достучимся*/
                    $.data(this, 'timer', setTimeout( /* Устанавливаем таймер, чтобы закрытие меню не начиналось сразу после того как мышь покинет li */
                            function () {
                                $this.find('> ul').stop(true).slideUp(300); /* анимация сворачивания меню */
                            },
                            200) /* задержка закрытия меню */
                    );
                });
        },

        clearDesktopFunctions: function() {
            console.log('Clear Desktop');

            this.$el.find('a.parent').off(); // Убираем обработку клина по category для Mobile
            this.$el.off(); // Убираем обработку hover для Mobile
        },


        setMobileFunctions: function() {
            console.log('setMobileFunctions');

            this.clearDesktopFunctions();
            // Обработка клина на category в Mobile
            this.$el.find('a.parent').click(function (e) {
                e.preventDefault();
                $(this).siblings('ul').slideToggle().toggleClass('is-opened');
            });
        },

        clearMobileFunctions: function() {
            console.log('Clear Mobile');
            this.$el.find('a.parent').off(); // Убираем обработку клина по category для Desktop
        },
    });

    SidebarApp.SidebarElements = Marionette.CompositeView.extend({

        template: "#sidebar-template",
        initialize: function() {
            this.currentSidebar = false;
            this.on("childview:menu:close childview:childview:menu:close", function() { // hide menu after click [Mobile]
                this.closeSidebar();
            });
        },
        tagName: "div",
        childViewContainer: "ul",
        getChildView: function(item) {
            if(item.get("products").length === 0) {
                return SidebarApp.NoSubMenuView;
            } else {
                return SidebarApp.SidebarSubMenu;
            }
        },
        events: {
            "click [data-toggle]": "toggleSidebar"
        },
        toggleSidebar: function() {
            if(this.currentSidebar == 0) {
                this.openSidebar();
            } else {
                this.closeSidebar();
            }
        },
        openSidebar: function() {
            this.currentSidebar = true;
            this.$el.find('.left-sidebar').addClass('active');
            this.$el.find('.left-sidebar > ul > li').addClass('is-expanded');
        },
        closeSidebar: function() {
            this.currentSidebar = false;
            var sidebar = this.$el.find('.left-sidebar');
            var allLi = sidebar.find(' > ul > li');
            allLi.removeClass('is-expanded');

            // We can't remove class before ended animation
            // We don't know the time when it will end, so we compute it
            var lastLi = allLi.first();
            var delay = lastLi.css('transition-delay');
            var duration = lastLi.css('transition-duration');

            var timer = (parseFloat(delay) + parseFloat(duration)) * 1000;

            setTimeout(function() {
                sidebar.removeClass('active');
            }, timer);

            this.closeOpenedSubMenuMobile();
        },
        closeOpenedSubMenuMobile: function() {
            this.$el.find('a.parent').each(function(index, value) {
                $(value).siblings('ul.is-opened').toggleClass("is-opened").slideToggle();
            });
        },
    });
});