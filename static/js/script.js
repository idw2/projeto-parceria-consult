/*
 Author : Joao Ahmad
 Date   : 14/09/2014 11h
 */

// GLOBAL VARIABLES

'use strict';

var App = null;
var Mobile = null;
var Plugins = null;
var Actions = null;
var User = null;
var ajax = null;

$.expr[":"].contains = $.expr.createPseudo(function (arg) {
    return function (elem) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

(function () {

// MOBILE

    Mobile = {
        init: function () {
            this.menu();
            return this;
        },
        menu: function () {
            // MOBILE 

            var menu_items = $('.navbar .navbar-collapse .navbar-nav').html();
            var menu_list = $('<div class="mobile-menu-list" />').html($('<ul class="list-unstyled" />').html(menu_items));
            var menu_header = $('<div class="mobile-menu-header" />').html();

            var menu = $('<div class="mobile-menu" />').html(menu_header).append(menu_list);

            // FIXED TOPS

            var menu_fixed_list = '';
            $('.header .navbar-collapse .navbar-nav a').each(function () {
                var href = $(this).attr('href');
                menu_fixed_list += "<li><a href='" + href + "'>" + $(this).html() + "</a></li>";
            });

            var menu_fixed_top = $('<div class="menu-fixed-top" />').html('<div class="container"><ul class="list-unstyled nav">' + menu_fixed_list + '</ul></div>');

            // SET

//            $('body').append(menu).append(menu_fixed_top);
//            $('.mobile-menu-header').find('#item_carrinho').remove();

            $('.hamburger').click(function () {
                $('body').toggleClass('menu-open');
                $('.body-overlay').fadeToggle();
            });
        }
    }

// PLUGINS

    Plugins = {
        init: function () {
            this.slider();
            this.hero_slider();
            this.slider_carousel();
            this.lightbox();
            this.mask();
            return this;
        },
        slider: function () {
            $('.flexslider').flexslider({
                animation: "slide"
            });
        },
        slider_carousel: function () {
            $('.slider-carousel').flexslider({
                animation: "slide",
                animationLoop: true,
                itemWidth: 480,
                itemMargin: 5,
                minItems: 1,
                maxItems: 5,
                controlNav: false
            });
        },
        hero_slider: function () {
            $("#layerslider").layerSlider({
                responsive: true,
                responsiveUnder: 1280,
                layersContainer: 1280,
                hoverPrevNext: true,
                thumbnailNavigation: 'disabled',
                skinsPath: 'static/plugins/layerslider/skins/'
            });
        },
        lightbox: function () {
            $('a').nivoLightbox({
                effect: 'slide'
            });
        },
        mask: function () {

            var maskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
                    options = {onKeyPress: function (val, e, field, options) {
                            field.mask(maskBehavior.apply({}, arguments), options);
                        }
                    };

            $('.mask_phone').mask(maskBehavior, options);
            $('.mask-dinheiro').mask('000.000.000.000.000,00', {reverse: true});

        }
    }

// ACTIONS

    Actions = {
        init: function () {
            this.navbar();
            this.ajax_form();
            this.dropdown_hover();
            function tick() {
                $('#ticker li:first').slideUp(function () {
                    $(this).appendTo($('#ticker')).slideDown();
                });
            }
            setInterval(function () {
                tick()
            }, 7000);

            $('[data-before]').click(function (e) {
                e.preventDefault();

                var item = $(this).attr('data-before');
                var html = $($(item)[0]).clone();
                html.find('label').remove();
                html.find('input, textarea').val('').removeAttr('required').removeClass('invalid');
                html.removeClass(item);

                $(this).before(html);
            });

            return this;
        },
        navbar: function () {
            var $el = $('body');
            var $header = $('#header');
            var $navbar = $('<div class="navbar navbar-fixed-top navbar-default" />').html($header.html());
            $navbar.find('.navbar-row-top').remove();
            $header.after($navbar);
            $(window).scroll(function () {
                var pos = $(this).scrollTop();
                (pos > 20) ? $el.addClass('navbar-scrolling') : $el.removeClass('navbar-scrolling');
            });
        },
        ajax_form: function () {
            $('.ajax-form').submit(function (e) {
                e.preventDefault();

                var valid = true;
                $("[required]").each(function () {
                    if (!this.checkValidity()) {
                        $(this).addClass('invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('invalid');
                    }
                });

                $('select').each(function () {
                    if (this.value == '-') {
                        $(this).addClass('invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('invalid');
                    }
                });

                if (!valid) {
                    alert('Por favor, preencha os campos corretamente.');
                    return;
                }

                var action = this.action;
                var data = new FormData();
                $('input, textarea, select, radio, checkbox').each(function () {
                    data.append(this.name, this.value);
                });

                $.ajax({
                    type: 'post',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: action,
                    success: function (res) {
                        console.log(res);
                        var msg = JSON.parse(res);
                        var response = $('#tpt-form-response').html();

                        var html = Handlebars.compile(response);
                        $('#form').before(html(msg));
                        $('#form').remove();
                        $(window).scrollTo(0);
                    }
                });
                return false;
            });

            $('.filter_list').each(function () {
                var self = this,
                        list = $('[data-id="' + this.getAttribute('data-list') + '"]'),
                        input = $('.filter_list input[type=search]'),
                        btn = $(this).find('button');

                input.bind('keyup', _.debounce(function () {

                    var $t = $(this);
                    var regx = new RegExp($t.val().trim().replace(/\s/igm, ''), "i");
                    list.find('.filter-item').each(function () {

                        var text = $(this).text().trim().replace(/\s/igm, '');
                        if (!regx.test(text)) {
                            $(this).hide();
                        } else {
                            $(this).fadeIn(200);
                        }

                    });

//                    var search = this.value;
//                    list.find('.filter-item').not('.filter-item:contains("' + search + '")').fadeOut(200);
//                    list.find('.filter-item:contains("' + search + '")').fadeIn(200);

                }, 250));
                input.blur(function () {
                    setTimeout(function () {
//                        $('.sugestao').empty();
                    }, 250);
                });
                
                btn.click(function(){
                   input.trigger('keyup');
                });
            });

            $('.filter_force').click(function (e) {
                e.preventDefault();
                
                var self = this,
                        search = $(this).attr('data-text'),
                        input = $('.filter_list input[type=search]');
                input.val(search).trigger('keyup');
                
                return false;
            });
        },
        dropdown_hover: function () {
            $(function () {

                $('.dropdown-hover > a').click(function (e) {
                    e.stopPropagation();
                    if ($('html').hasClass('touch')) {
                        e.preventDefault();
                        var parent = $(this).parent();
                        $('.dropdown-hover').not(parent).removeClass('hover');
                        parent.toggleClass('hover');
                    }
                });

                $('.mobile-menu .dropdown-hover > a').click(function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    $(this).parent().toggleClass('hover');
                });

                $(document).click(function () {
                    $('.dropdown-hover').removeClass('hover');
                });
            });
        }
    }


// GENERAL APP

    App = {
        init: function () {
            Mobile.init();
            Plugins.init();
            Actions.init();
        }
    }
})();


$(function () {
    App.init();
});