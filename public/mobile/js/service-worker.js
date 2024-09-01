/////////////////////////////////////////////////////////////////////////////
// You can find dozens of practical, detailed, and working examples of 
// service worker usage on https://github.com/mozilla/serviceworker-cookbook
/////////////////////////////////////////////////////////////////////////////

// Cache name
var CACHE_NAME = 'cache-version-1';

// Files required to make this app work offline
var REQUIRED_FILES = [
  'index.html',
  '/',
  'https://cdn.jsdelivr.net/npm/sweetalert2@11',
  'https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js',
  'mobile/js/bootstrap.bundle.min.js',
  'mobile/js/slideToggle.min.js',
  'mobile/js/internet-status.js',
  'mobile/js/tiny-slider.js',
  'mobile/js/venobox.min.js',
  'mobile/js/countdown.js',
  'mobile/js/rangeslider.min.js',
  'mobile/js/index.js',
  'mobile/js/imagesloaded.pkgd.min.js',
  'mobile/js/isotope.pkgd.min.js',
  'mobile/js/dark-rtl.js',
  'mobile/js/active.js',
  'mobile/style.css'
];

self.addEventListener('install', function(event) {
  // Perform install step:  loading each required file into cache
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        // Add all offline dependencies to the cache
        return cache.addAll(REQUIRED_FILES);
      })
      .then(function() {
        return self.skipWaiting();
      })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        // Cache hit - return the response from the cached version
        if (response) {
          return response;
        }
        // Not in cache - return the result from the live server
        // `fetch` is essentially a "fallback"
        return fetch(event.request);
      }
    )
  );
});

self.addEventListener('activate', function(event) {
  // Calling claim() to force a "controllerchange" event on navigator.serviceWorker
  event.waitUntil(self.clients.claim());
});