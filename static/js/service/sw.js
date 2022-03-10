'use strict';

const CACHE = 'cache-update-and-refresh-v1';

const CACHE_URL = [
    '/static/js/ajax.js',
    '/static/js/core.js',
    '/static/js/browser.js',
    '/static/js/vendor/jQuery/plugin.js',
    '/static/js/vue/header.js',
    '/static/js/vue/footer.js'
];

// При установке воркера мы должны закешировать часть данных (статику).
self.addEventListener('install', event => {
    event.waitUntil(
        caches
            .open(CACHE)
            .then((cache) => cache.addAll(CACHE_URL))
    );
});

// При запросе на сервер мы используем данные из кэша и только после идем на сервер.
self.addEventListener('fetch', (event) => {
    event.respondWith(fromCache(event.request));
    event.waitUntil(
      update(event.request)
      // В конце, после получения "свежих" данных от сервера уведомляем всех клиентов.
      .then(refresh)
    );
});

function fromCache(request) {
    return caches.open(CACHE).then(cache =>
        cache.match(request).then(matching =>
            matching || Promise.reject('no-match')
        ));
}

function update(request) {
    return caches.open(CACHE).then(cache =>
        fetch(request).then(response =>
            cache.put(request, response.clone()).then(() => response)
        )
    );
}

// Шлём сообщения об обновлении данных всем клиентам.
function refresh(response) {
    return self.clients.matchAll().then(clients => {
        clients.forEach(client => {
            const message = {
                type: 'refresh',
                url: response.url,
                eTag: response.headers.get('ETag')
            };
            // Уведомляем клиент об обновлении данных.
            client.postMessage(JSON.stringify(message));
        });
    });
}