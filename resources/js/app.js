import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap'

import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router';


// Import Gsap
import { gsap } from "gsap";

import { TextPlugin } from 'gsap/TextPlugin';

import { ScrollTrigger } from "gsap/ScrollTrigger"; 

import { ScrollToPlugin } from "gsap/ScrollToPlugin";

import $ from "jquery";


gsap.registerPlugin(ScrollTrigger,ScrollToPlugin);


const pinia = createPinia();
const app = createApp(App);
app.use(router);
app.use(pinia);

// CUSTOM DIRECTIVE
// app.directive('html-append', (el, binding) => {
//   el.insertAdjacentHTML('beforeend', binding.value);
// });

app.mount('#slider');





 document.addEventListener('facetwp-loaded', function() {

  const scrollButton = document.querySelector('.searchbar');
  const main_cats = document.querySelector('.main_cats');
  const buttons = document.querySelectorAll('.facetwp-radio');
  const control = document.querySelector('.product-tags');
  const facets = document.querySelectorAll('.facetwp-facet');
  const view_1_button = document.querySelector('.view_1_button');
    const view_2_button = document.querySelector('.view_2_button');
  const view_1 = document.querySelectorAll('.view_1');
  const view_2 = document.querySelectorAll('.view_2');
  const product = document.querySelectorAll('.product');

        $('.facetwp-facet').each(function() {
          var facet = $(this);
          var facet_name = facet.attr('data-name');
          var facet_type = facet.attr('data-type');
          var facet_label = FWP.settings.labels[facet_name];
          if ( ! ['pager','sort','reset', 'radio', 'search'].includes( facet_type ) ) { // Add or remove excluded facet types to/from the array
            if (facet.closest('.facet-wrap').length < 1 && facet.closest('.facetwp-flyout').length < 1) {
              facet.wrap('<div class="facet-wrap"></div>');
              facet.before('<h3 class="facet-label">' + facet_label + '</h3>');
            }
          }
        });



  scrollButton.addEventListener('click', () => {
 gsap.to(window, .5, {scrollTo:{y:main_cats, offsetY:70}});
 });

  buttons.forEach((button) => {
    button.addEventListener('click', () => {
       gsap.to(window, .5, {scrollTo:{y:main_cats, offsetY:70}});
      bootstrap.Collapse.getOrCreateInstance(control, { toggle: true });
      });
  });

  facets.forEach((facet) => {

  });



    view_1_button.addEventListener('click', () => { 

     product.forEach(function (elem1) {
       elem1.classList.remove('view_1');
      elem1.classList.add('view_2');
    });
    });

    

  
  });


  

const t1 = gsap.timeline({
  paused: "true",
  scrollTrigger: {
    trigger: ".top",
  //  endTrigger: ".main_cats",
    start: "top",
    end: "bottom",
    scrub: .5,
    // preventOverlaps: true,
    markers: false,
  }
})


t1.to(".head_mobile", {y: 130 });

const tlfour = gsap.timeline({
    scrollTrigger: { 
        trigger: ".shop", 
        start: "top",
         end: "bottom",
        markers: true,
        pin: false,
    }
})

tlfour.to(".main_cats", {
    position: 'sticky',
    top: -10,  
})
