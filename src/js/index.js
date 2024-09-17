navigator.serviceWorker.register('/assets/js/service-worker.js');
Notification.requestPermission().then(function (permission) {
    if (permission === 'granted') {
        console.log('Notification permission granted.');
        fetch('/api/notifications')
            .then(response => response.json())
            .then(notifications => {
                notifications.forEach(notification => {
                    new Notification(notification.title, {
                        body: notification.body,
                        icon: notification.icon,
                        tag: notification.tag,
                        data: notification.data,
                    });
                });
            });


        /*  const n = new Notification("My Great Song");
         n.onclick = () => {
             // Handle notification click
             // window.open('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
         }; */
    }
});
