window._ = require('lodash');

// window.uniqid = require('uniqid');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// broadcast events with laravel-echo-server (depreciated, require socket.io-client:^2.4.0)
// window.io = require('socket.io-client');
// window.Echo = new Echo({
//     host: `${window.location.hostname}:${process.env.MIX_LARAVEL_ECHO_SERVER_PORT}`,
//     client: window.io,
//     broadcaster: 'socket.io',
//     auth: {
//         headers: {
//             'Authorization': 'Bearer ...',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//         }
//     },
// });

// broadcast events with laravel-websockets (recommended)
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     wsHost: window.location.hostname,
//     wsPort: process.env.MIX_WEBSOCKETS_PORT,
//     wssPort: process.env.MIX_WEBSOCKETS_PORT,
//     enabledTransports: ['ws', 'wss'],
//     forceTLS: true,
//     disableStats: true,
// });
