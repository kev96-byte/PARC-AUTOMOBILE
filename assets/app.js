import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
const $ = require('jquery');

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

// cela "modifie" le module jquery : ajout de comportement à celui-ci
// le module bootstrap n'exporte/retourne rien
require('bootstrap');
require('startbootstrap-sb-admin-2-bs5/js/sb-admin-2.js');