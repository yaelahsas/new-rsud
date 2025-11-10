import 'flowbite';
import './bootstrap';

// Import Alpine.js
import Alpine from 'alpinejs';

// Import Alpine components
import './alpine/app-shell.js';
import './alpine/smart-search.js';
import './alpine/hero-search.js';
import './alpine/layanan-page.js';
import './alpine/doctor-finder.js';
import './alpine/article-manager.js';
import './alpine/berita-manager.js';
import './alpine/kategori-manager.js';
import './alpine/user-manager.js';
import './alpine/poli-manager.js';
import './alpine/dokter-manager.js';
import './alpine/jadwal-poli-manager.js';
import './alpine/carousel-manager.js';
import './alpine/dashboard-manager.js';

// Make Alpine available globally
window.Alpine = Alpine;

// Initialize Alpine.js
Alpine.start();