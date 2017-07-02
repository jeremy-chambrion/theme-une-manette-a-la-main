var Headroom = require('headroom.js');
var dateFns = require('date-fns/distance_in_words_to_now');
var dateFnsLocale = require('date-fns/locale/fr');
var fontObserver = require('fontfaceobserver');

(function ($, d) {
    'use strict';

    new Headroom(d.getElementById('masthead'), {
        'offset': 100,
        'tolerance': 10
    }).init();

    if(!$) {
        return;
    }

    $(d).ready(function() {
        var fontSansSerifNormal = new fontObserver('Raleway', {weight: 400});
        var fontSansSerifBold = new fontObserver('Raleway', {weight: 700});
        var fontSerifNormal = new fontObserver('Roboto Slab', {weight: 400});
        var fontSerifBold = new fontObserver('Roboto Slab', {weight: 700});
        var fontIcons = new fontObserver('FontAwesome');

        Promise.all([
            fontSerifNormal.load(),
            fontSerifBold.load(),
            fontSansSerifNormal.load(),
            fontSansSerifBold.load(),
            fontIcons.load()
        ]).then(function() {
            d.querySelector('.loader').style.display = 'none';
            d.getElementById('content').style.display = 'block';
            d.getElementById('content').style.animation = '.2s ease-out forwards fadeIn';
            d.getElementById('footer').style.display = 'block';
            d.getElementById('footer').style.animation = '.2s ease-out forwards fadeIn';
        }).catch(function() {
            d.querySelector('.loader').style.display = 'none';
            d.getElementById('content').style.display = 'block';
            d.getElementById('content').style.animation = '.2s ease-out forwards fadeIn';
            d.getElementById('footer').style.display = 'block';
            d.getElementById('footer').style.animation = '.2s ease-out forwards fadeIn';
        });
    });

    $(d).ready(function() {
        var closeSearch = function() {
            $('.search-screen').fadeOut(200);
            $(d).off('keyup', eventEsc);
        };

        var openSearch = function() {
            $('.search-screen').fadeIn(200);
            $('#search-input').focus();
            $(d).keyup(eventEsc);
        };

        var eventEsc = function(e) {
            if (e.keyCode === 27) {
                closeSearch();
            }
        };

        $(d).on('click', '.search-open', function(e) {
            e.preventDefault();
            openSearch();
        });
        $(d).on('click', '.search-close', function(e) {
            e.preventDefault();
            closeSearch();
        });

        $(d).on('click', '.article-hero .btn-action', function(e) {
            e.preventDefault();
           $('html, body').animate({
               scrollTop: $('#under-hero-content').offset().top
           }, 300);
        });
    });

    $(d).ready(function() {
        $('.article-tldr button').on('click', function () {
            $(this).toggleClass('tldr-closed tldr-opened');
            $(this).next('.tldr-content').slideToggle();
        });
    });

    $(d).ready(function() {
        $('.article-time time, .comment-metadata time').each(function() {
            $(this).html(dateFns(
                $(this).attr('datetime'),
                {
                    addSuffix: true,
                    locale: dateFnsLocale
                }
            ));
        })
    });
})(jQuery, document);
