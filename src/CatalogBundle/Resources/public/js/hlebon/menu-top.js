$(function() {
    var ControllerTopMenu = {
        windowWidth: undefined,
        menu: undefined,
        linkParent: undefined,
        liHover: undefined,
        clearMenu: function () { // TODO разобраться
            this.linkParent.off();
            this.liHover.off();
            $(this.menu).add('ul', this.menu).removeAttr('style');
        },
        setBigFunctions: function () {
            this.liHover.hover(
                function (e) {
                    clearTimeout($.data(this, 'timer'));
                    $('ul', this).stop(true, true).slideDown(100);
                },
                function (e) {
                    $.data(this, 'timer', setTimeout(
                            $.proxy(
                                function () {
                                    $('ul', this).stop(true, true).slideUp(100);
                                },
                                this),
                            200)
                    );
                });
        },
        setSmallFunctions: function () {
            this.linkParent.click(function (e) {
                e.preventDefault();
                $(this).siblings('ul').slideToggle();
            });
        },
        addClassParent: function () {
            $("li a", this.menu).each(function () {
                if ($(this).next().length > 0) {
                    $(this).addClass("parent");
                }
            });
        },
        init: function () {
            this.addClassParent();

            this.menu = $('.menu-top');
            this.linkParent = $('a.parent', this.menu);
            this.liHover = $(this.linkParent).parents('li');

            var touch = $('.menu-top__button');
            $(touch).on('click', $.proxy(function (e) {
                e.preventDefault();
                $(e.currentTarget).toggleClass("active");
                this.menu.slideToggle();
            }, this));

            $(window).on('mobile', $.proxy(function() {
                this.clearMenu();
                this.setSmallFunctions();
            }, this));
            $(window).on('desktop', $.proxy(function() {
                this.clearMenu();
                this.setBigFunctions();
            }, this));
        }
    };

    ControllerTopMenu.init();
});