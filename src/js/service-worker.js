const version = 'v1::';
const cacheName = version + 'umalm';
const cacheHostnames = ['fonts.googleapis.com', 'fonts.gstatic.com'];
const staleHostnames = ['gravatar.com'];
const cacheExtensions = ['css', 'js', 'otf', 'eot', 'svg', 'ttf', 'woff', 'woff2', 'ico'];
const installDelayed = [
    '/wp-content/themes/unemanettealamain/assets/logo/40x40.png',
    '/wp-content/themes/unemanettealamain/assets/logo/150x150.png',
    '/wp-content/themes/unemanettealamain/assets/logo/384x384.png'
];
const installCritical = [];

/**
 * This gives you the "Cache only" behaviour for things in the cache
 * and the "Network only" behaviour for anything not-cached
 * (which includes all non-GET requests, as they cannot be cached).
 * @see https://jakearchibald.com/2014/offline-cookbook/#cache-falling-back-to-network
 * @param event
 */
const fetchCacheOrNetwork = event => {
    'use strict';

    return caches.open(cacheName).then(cache => {
        return cache.match(event.request).then(response => {
            console.log('Service Worker - fetchCacheOrNetwork ' + (response ? '(cache)' : '(network)'), event.request.url);
            return response || fetch(event.request);
        });
    });
};

/**
 * If a request doesn't match anything in the cache,
 * get it from the network, send it to the page
 * & add it to the cache at the same time.
 * @see https://jakearchibald.com/2014/offline-cookbook/#on-network-response
 * @param event
 */
const fetchCacheOrNetworkSave = event => {
    'use strict';

    return caches.open(cacheName).then(cache => {
        return cache.match(event.request).then(response => {
            console.log('Service Worker - fetchCacheOrNetworkSave ' + (response ? '(cache)' : '(network)'), event.request.url);
            return response || fetch(event.request).then(response => {
                cache.put(event.request, response.clone());
                console.log('Service Worker - put into cache', event.request.url);
                return response;
            });
        });
    });
};

/**
 * If there's a cached version available, use it,
 * but fetch an update for next time.
 * @see https://jakearchibald.com/2014/offline-cookbook/#stale-while-revalidate
 * @param event
 */
const fetchStaleWhileRevalidate = event => {
    'use strict';

    return caches.open(cacheName).then(cache => {
        return cache.match(event.request).then(response => {
            let fetchPromise = fetch(event.request).then(networkResponse => {
                cache.put(event.request, networkResponse.clone());
                console.log('Service Worker - put into cache', event.request.url);
                return networkResponse;
            });
            console.log('Service Worker - fetchStaleWhileRevalidate ' + (response ? '(cache)' : '(network)'), event.request.url);
            return response || fetchPromise;
        });
    });
};

/**
 * Try to get a networked version, if successful
 * keep it in cache and return it. If not successful,
 * try to return a cached version if available.
 * @param event
 */
const fetchNetworkSaveOrCache = event => {
    'use strict';

    return caches.open(cacheName).then(cache => {
        return fetch(event.request).then(response => {
            cache.put(event.request, response.clone());
            console.log('Service Worker - fetchNetworkSaveOrCache (network)', event.request.url);
            console.log('Service Worker - put into cache', event.request.url);
            return response;
        }).catch(() => {
            console.log('Service Worker - fetchNetworkSaveOrCache (cache)', event.request.url);
            return cache.match(event.request);
        });
    });
};

/**
 * If a cache do not exists or is too older,
 * force a refresh with a newly network version
 * and fallback to cache.
 *
 * If a cache exists and is not too old,
 * try to get a networked version before timeout.
 * If successful keep it in cache and return it,
 * otherwise return provided fallback
 * @see https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Objets_globaux/Promise/race
 * @param event
 */
const fetchTimeoutNetworkSaveOrCache = event => {
    'use strict';

    return caches.open(cacheName).then(cache => {
        return cache.match(event.request).then(responseCache => {
            if (!responseCache) {
                console.log('Service Worker - fetchTimeoutNetworkSaveOrCache --> no cache found', event.request.url);
                return fetchNetworkSaveOrCache(event);
            }

            console.log('Service Worker - fetchTimeoutNetworkSaveOrCache --> cache found', event.request.url);
            let headerDate = responseCache.headers.get('date');
            if (!headerDate) {
                console.log('Service Worker - fetchTimeoutNetworkSaveOrCache --> no header date found', event.request.url);
                return fetchNetworkSaveOrCache(event);
            }

            let diffDate = ((new Date()).getTime() - (new Date(headerDate)).getTime());
            if (!diffDate) {
                console.log('Service Worker - fetchTimeoutNetworkSaveOrCache --> header date with empty time', headerDate, diffDate, event.request.url);
                return fetchNetworkSaveOrCache(event);
            }

            if (diffDate > (3600 * 24 * 2 * 1000)) {
                console.log('Service Worker - fetchTimeoutNetworkSaveOrCache --> header date > 2 days', headerDate, diffDate, event.request.url);
                return fetchNetworkSaveOrCache(event);
            }

            console.log('Service Worker - fetchTimeoutNetworkSaveOrCache --> header date < 2 days', headerDate, diffDate, event.request.url);
            return Promise.race([
                new Promise((resolve, reject) => {
                    setTimeout(reject, 5000);
                }),
                fetch(event.request)
            ]).then(responseNetwork => {
                console.log('Service Worker - fetchTimeoutNetworkSaveOrFallback (network)', event.request.url);
                console.log('Service Worker - put into cache', event.request.url);
                cache.put(event.request, responseNetwork.clone());
                return responseNetwork;
            }).catch(() => {
                console.log('Service Worker - fetchTimeoutNetworkSaveOrFallback (cache)', event.request.url);
                return responseCache;
            });
        });
    });
};

self.addEventListener('install', event => {
    'use strict';

    console.log('Service Worker - Install');
    event.waitUntil(
        caches.open(cacheName).then(cache => {
            console.log('Service Worker - Install files');
            cache.addAll(installDelayed);
            return cache.addAll(installCritical);
        }).then(() => {
            console.log('Service Worker - Install OK, skip waiting');
            return self.skipWaiting();
        })
    );
});

/**
 * The activate event fires after a service worker has been successfully installed.
 * It is most useful when phasing out an older version of a service worker,
 * as at this point you know that the new worker was installed correctly.
 */
self.addEventListener('activate', event => {
    'use strict';

    console.log('Service Worker - Activate');
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(cacheNames.filter(cacheKey => {
                console.log('Activate - key -->', cacheKey);
                return !cacheKey.startsWith(cacheName);
            }).map(cacheKey => {
                console.log('Service Worker - Delete key', cacheKey);
                return caches.delete(cacheKey);
            }));
        })
    );

    return self.clients.claim();
});

/**
 * The fetch event fires whenever a page controlled by this service worker
 * requests a resource. This isn’t limited to fetch or even XMLHttpRequest.
 * Instead, it comprehends even the request for the HTML page on first load,
 * as well as JS and CSS resources, fonts, any images, etc.
 *
 * Note also that requests made against other origins will also be caught
 * by the fetch handler of the ServiceWorker.
 */
self.addEventListener('fetch', event => {
    'use strict';

    /**
     * We should only cache GET requests, and deal with the rest of method in the
     * client-side, by handling failed POST,PUT,PATCH,etc. requests.
     */
    if (event.request.method !== 'GET') {
        // If we don't block the event as shown below, then the request will go to the network as usual
        console.log('Service Worker - Method is not GET, fetch event ignored.', event.request.method, event.request.url);
        return;
    }

    // This service worker won't touch the admin area and preview pages
    if (event.request.url.match(/wp-admin/) || event.request.url.match(/preview=true/)) {
        console.log('Service worker - Admin page detected, fetch event ignored.', event.request.url);
        return;
    }

    // parse the URL
    let requestURL = new URL(event.request.url);
    let requestExtension = requestURL.pathname.split('.').pop();

    // If this is a local URL
    if (requestURL.origin === location.origin) {
        // search results must not be cached
        if (requestURL.pathname === '/' && requestURL.search.startsWith('?s=')) {
            console.log('Service Worker - Search results page detected, fetch event ignored.', event.request.url);
            return;
        }

        if (cacheExtensions.indexOf(requestExtension) > -1) {
            // serve local static files with version from cache
            // fallback to network and save
            if (/\/unemanettealamain\/assets\/.*\-[a-z0-9]+\.[a-z0-9]+$/.test(requestURL.pathname)) {
                console.log('Service Worker - Found local asset with version in pathname', event.request.url);
                event.respondWith(fetchCacheOrNetworkSave(event));
                return;
            }

            let versionFound = false;
            requestURL.searchParams.forEach((value, key) => {
                if (value !== '' && ['ver', 'v'].indexOf(key) > -1) {
                    versionFound = true;
                }
            });

            if (versionFound) {
                console.log('Service Worker - Found local asset with version in query string', event.request.url);
                event.respondWith(fetchCacheOrNetworkSave(event));
                return;
            }
        }

        // serve local page
        if (/\/$/.test(requestURL.pathname)) {
            console.log('Service Worker - Found local static page', event.request.url);
            event.respondWith(fetchTimeoutNetworkSaveOrCache(event));
            return;
        }
    }

    // Serve cache data for specific hosts
    // fallback to network and save
    let i;
    for (i = 0; i < cacheHostnames.length; i++) {
        if (requestURL.hostname.indexOf(cacheHostnames[i]) > -1) {
            console.log('Service Worker - Found external static URL', event.request.url);
            event.respondWith(fetchCacheOrNetworkSave(event));
            return;
        }
    }

    // Serve stale cache for specific hosts
    for (i = 0; i < staleHostnames.length; i++) {
        if (requestURL.hostname.indexOf(staleHostnames[i]) > -1) {
            console.log('Service Worker - Found external static URL', event.request.url);
            event.respondWith(fetchStaleWhileRevalidate(event));
            return;
        }
    }

    // Serve cache for specific extension and refresh cache
    if (cacheExtensions.indexOf(requestURL.pathname.split('.').pop()) > -1) {
        console.log('Service Worker - Found generic media extension', event.request.url);
        event.respondWith(fetchStaleWhileRevalidate(event));
        return;
    }

    // Generic fallback.
    // Search into cache, fallback to network if not found.
    // No data saved in cache when using network.
    console.log('Service Worker - Generic fallback', event.request.url);
    event.respondWith(fetchCacheOrNetwork(event));
});
