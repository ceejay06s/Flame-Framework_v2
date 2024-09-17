self.addEventListener('push', function (event) {
    const data = event.data.json();
    console.log('New notification received:', data);
    event.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: data.icon,
            tag: data.tag,
            data: data.data,
        })
    );
});

self.addEventListener('notificationclick', function (event) {
    console.log('Notification clicked:', event.notification);
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});
