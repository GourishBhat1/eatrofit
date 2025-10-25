const CACHE_NAME = 'eatrofit-cache-v1';
const urlsToCache = [
  '/',
  '/index.html',
  '/manifest.json',
  '/login.html',
  '/register.html',
  '/dashboard.html',
  '/analytics.html',
  '/settings.html',
  '/support.html',
  '/faq.html',
  '/reminders.html',
  // Add more assets as needed
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => response || fetch(event.request))
  );
});

// Push notification event
self.addEventListener('push', function(event) {
  const data = event.data ? event.data.text() : 'Stay healthy!';
  event.waitUntil(
    self.registration.showNotification('Eatrofit Reminder', {
      body: data,
      icon: '/icon-192.png'
    })
  );
});
