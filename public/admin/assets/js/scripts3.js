$(function () {
    const opts = { cursoropacitymin: 0, cursoropacitymax: .8, zindex: 892 };
    let sidebar_nicescroll, now_layout_class = null;

    const sidebar_sticky = () => {
        if ($("body").hasClass('layout-2')) {
            const sidebar = $("body.layout-2 #sidebar-wrapper");
            sidebar.stick_in_parent({ parent: $('body') }).stick_in_parent({ recalc_every: 1 });
        }
    };

    const update_sidebar_nicescroll = () => {
        let interval = setInterval(() => sidebar_nicescroll && sidebar_nicescroll.resize(), 10);
        setTimeout(() => clearInterval(interval), 600);
    };

    const sidebar_dropdown = () => {
        if ($(".main-sidebar").length) {
            $(".main-sidebar").niceScroll(opts);
            sidebar_nicescroll = $(".main-sidebar").getNiceScroll();

            $(".main-sidebar .sidebar-menu li a.has-dropdown").on('click', function () {
                const me = $(this), active = me.parent().hasClass("active");

                $('.main-sidebar .sidebar-menu li.active > .dropdown-menu').slideUp(500, update_sidebar_nicescroll);
                $('.main-sidebar .sidebar-menu li.active.dropdown').removeClass('active');

                if (active) {
                    me.parent().removeClass('active');
                    me.parent().find('> .dropdown-menu').slideUp(500, update_sidebar_nicescroll);
                } else {
                    me.parent().addClass('active');
                    me.parent().find('> .dropdown-menu').slideDown(500, update_sidebar_nicescroll);
                }
                return false;
            });

            $('.main-sidebar .sidebar-menu li.active > .dropdown-menu').slideDown(500, update_sidebar_nicescroll);
        }
    };

    const toggle_sidebar_mini = (mini) => {
        let body = $('body');
        if (!mini) {
            body.removeClass('sidebar-mini');
            $(".main-sidebar").css({ overflow: 'hidden' }).niceScroll(opts);
            sidebar_nicescroll = $(".main-sidebar").getNiceScroll();
            $(".main-sidebar .sidebar-menu > li > a").removeAttr('data-toggle title data-original-title');
        } else {
            body.addClass('sidebar-mini').removeClass('sidebar-show');
            sidebar_nicescroll && sidebar_nicescroll.remove();
            $(".main-sidebar .sidebar-menu > li").each(function () {
                let me = $(this);
                if (me.find('> .dropdown-menu').length) {
                    // me.find('> .dropdown-menu').hide().prepend('<li class="dropdown-title pt-3">' + me.find('> a').text() + '</li>');
                } else {
                    me.find('> a').attr({ 'data-toggle': 'tooltip', 'data-original-title': me.find('> a').text() });
                    $("[data-toggle='tooltip']").tooltip({ placement: 'right' });
                }
            });
        }
    };

    const toggleLayout = () => {
        const w = $(window);
        const layout_class = $('body').attr('class') || '';
        const layout_classes = layout_class.trim().length ? layout_class.split(' ') : [];

        layout_classes.forEach(item => item.indexOf('layout-') !== -1 && (now_layout_class = item));

        if (w.outerWidth() <= 1024) {
            if ($('body').hasClass('sidebar-mini')) toggle_sidebar_mini(false);
            $("body").addClass("sidebar-gone").removeClass("layout-2 layout-3 sidebar-mini sidebar-show")
                .off('click touchend').on('click touchend', function (e) {
                    if ($(e.target).hasClass('sidebar-show') || $(e.target).hasClass('search-show')) {
                        $("body").removeClass("sidebar-show").addClass("sidebar-gone").removeClass("search-show");
                        update_sidebar_nicescroll();
                    }
                });

            update_sidebar_nicescroll();

            if (now_layout_class === 'layout-3') {
                const nav_second = $(".navbar-secondary");
                nav_second.attr('data-nav-classes', nav_second.attr('class')).removeAttr('class').addClass('main-sidebar');

                const main_sidebar = $(".main-sidebar");
                main_sidebar.find('.container').addClass('sidebar-wrapper').removeClass('container');
                main_sidebar.find('.navbar-nav').addClass('sidebar-menu').removeClass('navbar-nav');
                main_sidebar.find('.sidebar-brand').remove();
                main_sidebar.find('.sidebar-menu').before($('<div>', { class: 'sidebar-brand' }).append(
                    $('<a>', { href: $('.navbar-brand').attr('href') }).html($('.navbar-brand').html())
                ));

                setTimeout(() => {
                    sidebar_nicescroll = main_sidebar.niceScroll(opts);
                    sidebar_nicescroll = main_sidebar.getNiceScroll();
                }, 700);

                sidebar_dropdown();
                $(".main-wrapper").removeClass("container");
            }
        } else {
            $("body").removeClass("sidebar-gone sidebar-show").addClass(now_layout_class);
            if (now_layout_class === 'layout-3') {
                const nav_second = $(".main-sidebar");
                nav_second.find(".sidebar-menu li a.has-dropdown").off('click');
                nav_second.find('.sidebar-brand').remove();
                nav_second.removeAttr('class').addClass(nav_second.attr('data-nav-classes'));
                const main_sidebar = $(".navbar-secondary");
                main_sidebar.find('.sidebar-wrapper').addClass('container').removeClass('sidebar-wrapper');
                main_sidebar.find('.sidebar-menu').addClass('navbar-nav').removeClass('sidebar-menu');
                main_sidebar.find('.dropdown-menu').hide();
                main_sidebar.removeAttr('style tabindex data-nav-classes');
                $(".main-wrapper").addClass("container");
            } else if (now_layout_class === 'layout-2') {
                $("body").addClass("layout-2");
            } else {
                update_sidebar_nicescroll();
            }
        }
    };

    sidebar_sticky();
    sidebar_dropdown();
    toggleLayout();
    $(window).resize(toggleLayout);

    $(".nav-collapse-toggle").click(function () {
        $(this).parent().find('.navbar-nav').toggleClass('show');
        return false;
    });

    $(document).on('click', () => $(".nav-collapse .navbar-nav").removeClass('show'));

    $("[data-toggle='sidebar']").click(function () {
        const body = $("body"), w = $(window);
        if (w.outerWidth() <= 1024) {
            body.removeClass('search-show search-gone');
            body.toggleClass('sidebar-gone sidebar-show');
            update_sidebar_nicescroll();
        } else {
            body.removeClass('search-show search-gone');
            toggle_sidebar_mini(!body.hasClass('sidebar-mini'));
        }
        return false;
    });

    $("[data-toggle='search']").click(function () {
        const body = $("body");
        body.toggleClass('search-gone search-show');
    });

    // Additional initializations
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover({ container: 'body' });
    $(".notification-toggle, .message-toggle").dropdown();
    $('.notification-toggle').parent().on('shown.bs.dropdown', () => $(".dropdown-list-icons").niceScroll({ cursoropacitymin: .3, cursoropacitymax: .8, cursorwidth: 7 }));
    $('.message-toggle').parent().on('shown.bs.dropdown', () => $(".dropdown-list-message").niceScroll({ cursoropacitymin: .3, cursoropacitymax: .8, cursorwidth: 7 }));
    if ($(".chat-content").length) {
        $(".chat-content").niceScroll({ cursoropacitymin: .3, cursoropacitymax: .8 });
        $('.chat-content').getNiceScroll(0).doScrollTop($('.chat-content').height());
    }

    // Other plugins initialization
    if ($.fn.select2) $(".select2").select2($(".select2").data('select2-opts') || {});
    if ($.fn.selectric) $(".selectric").selectric({ disableOnMobile: false, nativeOnMobile: false });
    if ($.fn.summernote) $(".summernote").summernote({ dialogsInBody: true, minHeight: 250 });
    if ($.fn.Chocolat) $(".gallery").Chocolat({ className: 'gallery', imageSelector: '.gallery-item' });
    if ($.fn.timepicker) $(".timepicker").timepicker({ icons: { up: 'fas fa-chevron-up', down: 'fas fa-chevron-down' } });
    if ($.fn.daterangepicker) {
        $(".datepicker").daterangepicker({ locale: { format: 'YYYY-MM-DD' }, singleDatePicker: true });
        $(".datetimepicker").daterangepicker({ locale: { format: 'YYYY-MM-DD HH:mm' }, singleDatePicker: true, timePicker: true, timePicker24Hour: true });
        $(".daterange").daterangepicker({ locale: { format: 'YYYY-MM-DD' }, drops: 'down', opens: 'right' });
    }
    if ($('.sortable-card').length && $.fn.sortable) {
        $('.sortable-card').sortable({ handle: '.card-header', opacity: .8, tolerance: 'pointer' });
    }

    $('[data-background]').each(function () { $(this).css({ backgroundImage: 'url(' + $(this).data('background') + ')' }); });
    setTimeout(() => $(".alert").fadeOut(), 5000);
});
