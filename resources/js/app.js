require('./bootstrap');

window.Echo.private('my-channel')
  .listen('my-event', (e) => {
    alert(e)
  });

