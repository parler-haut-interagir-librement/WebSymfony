/*
 * The JavaScript of the site, loaded by importmap() in base.html.twig. The stylesheets, Pico CSS then the site's own
 * styles/app.css, are linked from the layout, never imported here: AssetMapper turns an imported stylesheet into a
 * data: module of the import map, which the Content Security Policy (script-src 'self' and a nonce) refuses, and the
 * whole module, Stimulus and Turbo with it, would never run.
 */
import './bootstrap.js';

// "optin" - No turbo forms unless you insist. Use data-turbo="true" to enable turbo on individual forms.
// @see https://stackoverflow.com/a/76286583/633864
Turbo.config.forms.mode = 'optin'; // "on" | "off" | "optin"

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
