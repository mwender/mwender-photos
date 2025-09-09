<?php if(!defined('ABSPATH')) { die(); }  

                


	// Code Snippet Code
	
/**
 * Enqueues GLightbox assets and initializes it for WordPress galleries.
 *
 * This function:
 * - Enqueues GLightbox CSS and JS from a CDN.
 * - Adds inline JavaScript to enhance `.wp-block-gallery` figures:
 *   - Adds `data-gallery` and `glightbox` attributes to gallery image links.
 *   - Uses `figcaption` text as the GLightbox title when available.
 * - Initializes GLightbox for all elements with the `.glightbox` class.
 *
 * @since 1.0.0
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', function() {
  wp_enqueue_style(
    'glightbox',
    'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css'
  );

  wp_enqueue_script(
    'glightbox',
    'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js',
    [],
    null,
    true
  );

  wp_add_inline_script( 'glightbox', "
    document.addEventListener('DOMContentLoaded', function () {
      // Regex to match common image file extensions
      const imageRegex = /\.(jpe?g|png|gif|webp|avif|tiff?|bmp|svg)$/i;

      // Select all links on the page
      const allLinks = document.querySelectorAll('a[href]');

      allLinks.forEach(link => {
        if (imageRegex.test(link.href)) {
          // Add lightbox grouping and class
          link.setAttribute('data-gallery', 'all-images');
          link.classList.add('glightbox');

          // If there's a caption inside the figure, add it as the title
          const figure = link.closest('figure');
          if (figure) {
            const caption = figure.querySelector('figcaption');
            if (caption) {
              link.setAttribute('data-title', caption.textContent.trim());
            }
          }
        }
      });

      // Initialize GLightbox for all images
      GLightbox({ selector: '.glightbox' });
    });
  " );
});

	// End Code Snippet Code