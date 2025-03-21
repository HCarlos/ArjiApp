import Echo from "laravel-echo";
import io from "socket.io-client";

import axios from 'axios';
window.axios = axios;

window.io = io;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    transports: ['websocket', 'polling'],     // Recomendado para Socket.io
    withCredentials: true                     // Si tu servidor lo requiere
});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
