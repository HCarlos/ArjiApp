import Echo from "laravel-echo";
import io from "socket.io-client";

import axios from 'axios';
window.axios = axios;
window.io = io;

import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// import 'jquery';
import 'select2/dist/js/select2.min.js';
import 'select2/dist/css/select2.min.css';

// import select2 from 'select2';
// select2(window.jQuery);

// Comentar para enviar a producción


window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    transports: ['websocket', 'polling'],     // Recomendado para Socket.io
    withCredentials: true                     // Si tu servidor lo requiere
});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
