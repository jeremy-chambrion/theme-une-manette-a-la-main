const Headroom = require('headroom.js');
const dateFns = require('date-fns/distance_in_words_to_now');
const dateFnsLocale = require('date-fns/locale/fr');
const fontObserver = require('fontfaceobserver');

{
    new Headroom(document.getElementById('masthead'), {
        'offset': 100,
        'tolerance': 10
    }).init();

    {
        let fontSansSerifNormal = new fontObserver('Raleway', {weight: 400});
        let fontSansSerifBold = new fontObserver('Raleway', {weight: 700});
        let fontSerifNormal = new fontObserver('Roboto Slab', {weight: 400});
        let fontSerifBold = new fontObserver('Roboto Slab', {weight: 700});
        let fontIcons = new fontObserver('FontAwesome');

        Promise.all([
            fontSerifNormal.load(),
            fontSerifBold.load(),
            fontSansSerifNormal.load(),
            fontSansSerifBold.load(),
            fontIcons.load()
        ]).then(() => {
            'use strict';

            document.querySelector('.loader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
            document.getElementById('footer').style.display = 'block';
            requestAnimationFrame(() => {
                document.getElementById('content').style.opacity = 1;
                document.getElementById('footer').style.opacity = 1;
            });
        }).catch(() => {
            'use strict';

            document.querySelector('.loader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
            document.getElementById('footer').style.display = 'block';
            requestAnimationFrame(() => {
                document.getElementById('content').style.opacity = 1;
                document.getElementById('footer').style.opacity = 1;
            });
        });
    }

    let addEventListener = (el, eventName, handler) => {
        'use strict';

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

    let removeEventListener = (el, eventName, handler) => {
        'use strict';

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
        let eventEsc = e => {
            'use strict';

            if (e.keyCode === 27) {
                closeSearch();
            }
        };

        let closeSearch = () => {
            'use strict';

            requestAnimationFrame(() => {
                document.querySelector('.search-screen').style.opacity = 0;
                new Promise((resolve) => setTimeout(resolve, 200)).then(() => {
                    document.querySelector('.search-screen').style.display = 'none';
                });
            });

            removeEventListener(document, 'keyup', eventEsc);
        };

        let openSearch = () => {
            'use strict';

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
        let convertTime = (selector) => {
            'use strict';

            let elts = document.querySelectorAll(selector);

            for (let i = 0; i < elts.length; i++) {
                elts[i].innerHTML = dateFns(
                    elts[i].getAttribute('datetime'),
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
