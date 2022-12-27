/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/navbar.css';
import './styles/index.css';
import './styles/carrousel.scss';
import './styles/login.css'

// start the Stimulus application
import './bootstrap';

// loads the jquery package from node_modules
 import $ from 'jquery';

 // import the function from greet.js (the .js extension is optional)
 // ./ (or ../) means to look for a local file
 import * as carrousel from './scripts/carrousel';

 $(document).ready(function() {
    carrousel;
 });