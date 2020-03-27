(function ($) {

    'use strict';

    function initMainNavigation(container) {
        // Add dropdown toggle that displays child menu items.
        var dropdownToggle = $('<button />', {
            'class': 'dropdown-toggle',
            'aria-expanded': false,
            'append': '<i class="fas fa-chevron-down"></i>'
        });

        container.find('.menu-item-has-children > a').after(dropdownToggle);

        // Toggle buttons and submenu items with active children menu items.
        container.find('.current-menu-ancestor > button').addClass('toggled-on');
        container.find('.current-menu-ancestor > .sub-menu').addClass('toggled-on');

        // Add menu items with submenus to aria-haspopup="true".
        container.find('.menu-item-has-children').attr('aria-haspopup', 'true');

        container.find('.dropdown-toggle').click(function (e) {
            var _this = $(this);

            e.preventDefault();
            _this.toggleClass('toggled-on');
            _this.next('.children, .sub-menu').toggleClass('toggled-on');

            _this.attr('aria-expanded', _this.attr('aria-expanded') === 'false' ? 'true' : 'false');

        });
    }

    initMainNavigation($('.mobile-navigation'));


    function subMenuPosition() {
        $('.main-navigation').find('.sub-menu').each(function () {
            $(this).removeClass('toleft');
            if (($(this).parent().offset().left + $(this).parent().width() - $(window).width() + 180) > 0) {
                $(this).addClass('toleft');
            }
        });
    }

    subMenuPosition();

    $(window).resize(function () {
        subMenuPosition();
    });


    (function (){

        var sidebar = $('#secondary'),
            body = $('body'),
            html = $('html');

        $('#sidebar-open').on('click', openSidebar);

        $('#sidebar-close').on('click', closeSidebar);

        $(document).on('click', function (e) {
           if(body.hasClass('sidebar-opened') && !$('#sidebar-open').is(e.target) && !sidebar.is(e.target) && !sidebar.has(e.target).length){
               closeSidebar();
           }
        });

        function openSidebar(e) {
            e.stopPropagation();
            e.preventDefault();
            sidebar.addClass('visible');
            body.addClass('sidebar-opened');
            html.css('overflow-y', 'hidden');
        }

        function closeSidebar(){
            sidebar.removeClass('visible');
            body.removeClass('sidebar-opened');
            html.css('overflow-y', 'auto');
        }

        sidebar.on('click', 'a', function (e) {
           closeSidebar();
        });

    })();

})(jQuery);