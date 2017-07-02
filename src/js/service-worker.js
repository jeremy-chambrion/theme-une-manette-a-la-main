var version = 'v1::';
var cacheName = version + 'umalm';
var cacheHostnames = ['fonts.googleapis.com', 'fonts.gstatic.com', 'gravatar.com'];
var cacheExtensions = ['css', 'js', 'otf', 'eot', 'svg', 'ttf', 'woff', 'woff2', 'ico'];
var installFiles = [
    '/wp-content/themes/unemanettealamain/assets/logo/40x40.png',
    '/wp-content/themes/unemanettealamain/assets/logo/150x150.png',
    '/wp-content/themes/unemanettealamain/assets/logo/384x384.png',
    '/wp-content/themes/unemanettealamain/assets/logo/600x600.png'
];

/**
 * This gives you the "Cache only" behaviour for things in the cache
 * and the "Network only" behaviour for anything not-cached
 * (which includes all non-GET requests, as they cannot be cached).
 * @see https://jakearchibald.com/2014/offline-cookbook/#cache-falling-back-to-network
 */
var fetchCacheOrNetwork = function(event) {
    'use strict';

    return caches.match(event.request).then(function(response) {
        console.log('Service Worker - fetchCacheOrNetwork ' + (response ? '(cache)' : '(network)'), event.request.url);
        return response || fetch(event.request);
    });
};

/**
 * If a request doesn't match anything in the cache,
 * get it from the network, send it to the page
 * & add it to the cache at the same time.
 * @see https://jakearchibald.com/2014/offline-cookbook/#on-network-response
 */
var fetchCacheOrNetworkSave = function(event) {
    'use strict';

    return caches.open(cacheName).then(function(cache) {
        return cache.match(event.request).then(function(response) {
            console.log('Service Worker - fetchCacheOrNetworkSave ' + (response ? '(cache)' : '(network)'), event.request.url);
            return response || fetch(event.request).then(function(response) {
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
 */
var fetchStaleWhileRevalidate = function(event) {
    'use strict';

    return caches.open(cacheName).then(function(cache) {
        return cache.match(event.request).then(function(response) {
            var fetchPromise = fetch(event.request).then(function(networkResponse) {
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
 */
var fetchNetworkSaveOrCache = function(event) {
    'use strict';

    return caches.open(cacheName).then(function(cache) {
        return fetch(event.request).then(function(response) {
            cache.put(event.request, response.clone());
            console.log('Service Worker - fetchNetworkSaveOrCache (network)', event.request.url);
            console.log('Service Worker - put into cache', event.request.url);
            return response;
        }).catch(function() {
            console.log('Service Worker - fetchNetworkSaveOrCache (cache)', event.request.url);
            return cache.match(event.request);
        });
    });
};


self.addEventListener('install', function(event) {
    'use strict';

    console.log('Service Worker - Install');
    event.waitUntil(
        caches.open(cacheName).then(function(cache) {
            console.log('Service Worker - Install files');
            return cache.addAll(installFiles);
        })
    );

    return self.skipWaiting();
});

/**
 * The activate event fires after a service worker has been successfully installed.
 * It is most useful when phasing out an older version of a service worker,
 * as at this point you know that the new worker was installed correctly.
 */
self.addEventListener('activate', function(event) {
    'use strict';

    console.log('Service Worker - Activate');
    event.waitUntil(
        caches.keys().then(function(keyList) {
            return Promise.all(keyList.filter(function(key) {
                return !key.startsWith(cacheName);
            }).map(function(key) {
                console.log('Service Worker - Delete key', key);
                return caches.delete(key);
            }));
        }).then(function() {
            console.log('Service Worker - Activate OK');
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
self.addEventListener('fetch', function(event) {
    'use strict';

    /**
     * We should only cache GET requests, and deal with the rest of method in the
     * client-side, by handling failed POST,PUT,PATCH,etc. requests.
     */
    if (event.request.method !== 'GET') {
        // If we don't block the event as shown below, then the request will go to the network as usual
        console.log('Service Worker - Fetch event ignored.', event.request.method, event.request.url);
        return;
    }

    // This service worker won't touch the admin area and preview pages
    if (event.request.url.match(/wp-admin/) || event.request.url.match(/preview=true/)) {
        console.log('Service worker - Fetch event ignored.', event.request.url);
        return;
    }

    // parse the URL
    var requestURL = new URL(event.request.url);
    var requestExtension = requestURL.pathname.split('.').pop();

    // If this is a local URL
    if (requestURL.origin === location.origin) {
        // serve js/css from cache and refresh cache if no version found
        if (cacheExtensions.indexOf(requestExtension) > -1) {
            var versionFound = false;
            requestURL.searchParams.forEach(function(value, key) {
                if (value !== '' && ['ver', 'v'].indexOf(key) > -1) {
                    versionFound = true;
                }
            });

            if (versionFound) {
                console.log('Service Worker - Found local versioned CSS/JS', event.request.url);
                event.respondWith(fetchCacheOrNetworkSave(event));
                return;
            }
        }

        // serve articles
        /*
        if (requestURL.pathname.startsWith('/article/')) {
            console.log('Service Worker - Found article page', event.request.url);
            event.respondWith(fetchStaleWhileRevalidate(event));
            return;
        }
        */

        // serve other static pages
        if (/\/$/.test(requestURL.pathname)) {
            console.log('Service Worker - Found local static page', event.request.url);
            event.respondWith(fetchNetworkSaveOrCache(event));
            return;
        }
    }

    // Serve cache data for specific hosts, fallback to network and save
    for (var i = 0; i < cacheHostnames.length; i++) {
        if (requestURL.hostname.indexOf(cacheHostnames[i]) > -1) {
            console.log('Service Worker - Found external static URL', event.request.url);
            event.respondWith(fetchCacheOrNetworkSave(event));
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
