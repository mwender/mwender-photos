<?php if(!defined('ABSPATH')) { die(); }  

                


	// Code Snippet Code
	
add_action( 'wp_enqueue_scripts', function() {
  wp_enqueue_style( 'glightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css' );
  wp_enqueue_script( 'glightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js', [], null, true );

  wp_add_inline_script( 'glightbox', "
    document.addEventListener('DOMContentLoaded', function () {
      const galleryFigures = document.querySelectorAll('.wp-block-gallery figure.wp-block-image');

      galleryFigures.forEach(figure => {
        const link = figure.querySelector('a[href$=\".jpg\"], a[href$=\".jpeg\"], a[href$=\".png\"]');
        const caption = figure.querySelector('figcaption');

        if (link) {
          link.setAttribute('data-gallery', 'wp-gallery');
          link.classList.add('glightbox');

          if (caption) {
            link.setAttribute('data-title', caption.textContent.trim());
          }
        }
      });

      const lightbox = GLightbox({ selector: '.glightbox' });
    });
  " );
});

	// End Code Snippet Code