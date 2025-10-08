import './bootstrap';
import Alpine from 'alpinejs';
import axios from 'axios';

window.Alpine = Alpine;
Alpine.start();

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Laravel AI Trading System loaded');
});
