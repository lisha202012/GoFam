const CACHE_NAME = "pwa-cache-v1";
const OFFLINE_URL = "/offline.html";
const START_URL = "/"; // Your welcome page

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll([
                START_URL, // Cache welcome page
                OFFLINE_URL, // Offline page
                "/css/app.css", // Include styles if needed
                "/js/app.js",  // Include scripts if needed
            ]);
        })
    );
    self.skipWaiting();
});

self.addEventListener("fetch", (event) => {
    if (event.request.mode === "navigate") {
        event.respondWith(
            fetch(event.request).catch(() => caches.match(START_URL) || caches.match(OFFLINE_URL))
        );
    } else {
        event.respondWith(
            caches.match(event.request).then((response) => response || fetch(event.request))
        );
    }
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
    self.clients.claim();
});
