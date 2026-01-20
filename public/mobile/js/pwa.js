// Service Worker Register 

if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/mobile/js/service-worker.js')
            .then(registration => {
            })
            .catch(err => {
            });
    });
}