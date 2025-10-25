// Push notification registration
if ('serviceWorker' in navigator && 'PushManager' in window) {
  navigator.serviceWorker.ready.then(function(reg) {
    // Request permission
    Notification.requestPermission().then(function(permission) {
      if (permission === 'granted') {
        // Subscribe to push (demo, replace with real VAPID/public key)
        reg.pushManager.subscribe({userVisibleOnly: true}).then(function(sub) {
          console.log('Push subscription:', sub);
        });
      }
    });
  });
}
