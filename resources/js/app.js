// Bootstrap bawaan Laravel
import './bootstrap';

// Load SCSS
// import '../scss/app.scss';

// Bootstrap core JS
import 'bootstrap';

/* Sneat Core */
import '../sneat/js/helpers.js';
import '../sneat/js/config.js';
import '../sneat/js/menu.js';
import '../sneat/js/main.js';

/* Log untuk debug */
console.log("Sneat Loaded:", {
    helpers: typeof window.Helpers !== "undefined",
});


