const Headroom = require('headroom.js');
const dateFns = require('date-fns/formatDistanceToNow');
const dateFnsLocale = require('date-fns/locale/fr');
const dateFnsParseISO = require('date-fns/parseISO');
const fontObserver = require('fontfaceobserver');

{
    new Headroom(document.getElementById('masthead'), {
        'offset': 100,
        'tolerance': 10
    }).init();

    {
        const fontSansSerifNormal = new fontObserver('Raleway', {weight: 400});
        const fontSansSerifBold = new fontObserver('Raleway', {weight: 700});
        const fontSerifNormal = new fontObserver('Roboto Slab', {weight: 400});
        const fontSerifBold = new fontObserver('Roboto Slab', {weight: 700});
        const fontIcons = new fontObserver('FontAwesome');

        Promise.all([
            fontSerifNormal.load(),
            fontSerifBold.load(),
            fontSansSerifNormal.load(),
            fontSansSerifBold.load(),
            fontIcons.load()
        ]).then(() => {
            document.querySelector('.loader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
            document.getElementById('footer').style.display = 'block';
            requestAnimationFrame(() => {
                document.getElementById('content').style.opacity = 1;
                document.getElementById('footer').style.opacity = 1;
            });
        }).catch(() => {
            document.querySelector('.loader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
            document.getElementById('footer').style.display = 'block';
            requestAnimationFrame(() => {
                document.getElementById('content').style.opacity = 1;
                document.getElementById('footer').style.opacity = 1;
            });
        });
    }

    const addEventListener = (el, eventName, handler) => {
        if (!el) {
            return;
        }

        if (el.addEventListener) {
            el.addEventListener(eventName, handler);
        } else {
            el.attachEvent('on' + eventName, () => {
                handler.call(el);
            });
        }
    };

    const removeEventListener = (el, eventName, handler) => {
        if (!el) {
            return;
        }

        if (el.removeEventListener) {
            el.removeEventListener(eventName, handler);
        } else {
            el.detachEvent('on' + eventName, handler);
        }
    };

    {
        const eventEsc = e => {
            if (e.keyCode === 27) {
                closeSearch();
            }
        };

        const closeSearch = () => {
            requestAnimationFrame(() => {
                document.querySelector('.search-screen').style.opacity = 0;
                new Promise((resolve) => setTimeout(resolve, 200)).then(() => {
                    document.querySelector('.search-screen').style.display = 'none';
                });
            });

            removeEventListener(document, 'keyup', eventEsc);
        };

        const openSearch = () => {
            document.querySelector('.search-screen').style.display = 'block';
            requestAnimationFrame(() => {
                document.querySelector('.search-screen').style.opacity = 1;
            });
            document.getElementById('search-input').focus();
            addEventListener(document, 'keyup', eventEsc);
        };

        document.querySelectorAll('.search-open').forEach(el => {
            addEventListener(el, 'click', e => {
                e.preventDefault();
                openSearch();
            });
        });

        document.querySelectorAll('.search-close').forEach(el => {
            addEventListener(el, 'click', e => {
                e.preventDefault();
                closeSearch();
            });
        });
    }

    {
        const convertTime = (selector) => {
            let elts = document.querySelectorAll(selector);

            for (let i = 0; i < elts.length; i++) {
                elts[i].innerHTML = dateFns(
                    dateFnsParseISO(elts[i].getAttribute('datetime')),
                    {
                        addSuffix: true,
                        locale: dateFnsLocale
                    }
                );
            }
        };

        convertTime('.article-time time');
        convertTime('.comment-metadata time');
    }
}
