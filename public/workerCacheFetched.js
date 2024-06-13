const CACHE_VERSION = '1'
const CACHE_FILES = []

self.addEventListener('install', (event) => {
    self.skipWaiting()
    const preCache = async () => {
        const cache = await caches.open(CACHE_VERSION)
        return cache.addAll(CACHE_FILES)
    }
    event.waitUntil(preCache())
})

self.addEventListener('fetch', (event) => {
    const fetchNetworkFirst = async () => {
        if (event.request.method !== 'GET') {
            return fetch(event.request)
        }
        let response = await fetch(event.request)
        if (response) {
            const cache = await caches.open(CACHE_VERSION)
            if (event.request.url.startsWith('http')) {
                cache.put(event.request, response.clone())
            }
        }
        return response
    }
    event.respondWith(fetchNetworkFirst())
})

self.addEventListener('activate', (event) => {
    const clearOldCache = async () => {
        let keys = await caches.keys()
        keys = keys.filter((key) => key !== CACHE_VERSION)
        return Promise.all(keys.map((key) => caches.delete(key)))
    }
    event.waitUntil(clearOldCache())
})
