<?php if(!defined('ABSPATH')) { die(); }  

add_action('wp_head', function() {

        
        ?>
        <style wpcb-ids='8' class='wpcb2-inline-style'>

        @charset "UTF-8";
.elementor-button.disabled {
  background-color: #eee;
  color: #999;
}
/* Photo Viewer */
.post #photo-viewer .post-title {
  font-weight: bold;
  text-align: center;
  margin-bottom: 1em;
}
@media (max-width: 840px) {
  .post #photo-viewer .post-title {
    margin-bottom: 0.25em;
  }
}
.post #photo-viewer #photo-viewer-content {
  max-width: 800px;
  margin: 50px auto;
}
@media (max-width: 840px) {
  .post #photo-viewer #photo-viewer-content {
    padding: 10px;
    margin: 0 auto;
  }
}
.post #photo-viewer .attachment-photos-featured {
  margin-bottom: 1em;
  max-height: none;
}
.post #photo-viewer .photo-viewer-featured-image {
  display: block;
  /* puts it on its own line */
  max-width: 100%;
  /* never overflow the parent */
  width: 100%;
  /* stretch to the parent’s width */
  height: auto;
  /* keep the aspect ratio */
  margin: 1em 0;
  /* optional spacing */
  max-height: none;
}
.post #photo-viewer figure {
  margin: 2em 0;
}
.post #photo-viewer figure img.disabled {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
.post #photo-viewer #photo-nav {
  position: fixed;
  bottom: 0;
  background: #fff;
  border-top: 1px solid #7a7a7a;
  width: 100%;
  padding: 20px;
  z-index: 99;
  display: flex;
  gap: 1rem;
}
@media (max-width: 840px) {
  .post #photo-viewer #photo-nav {
    padding: 5px;
    gap: 0.25rem;
  }
}
.post #photo-viewer #photo-nav .col {
  flex: 1;
  display: flex;
}
.post #photo-viewer #photo-nav .col .elementor-button {
  flex: 1;
  text-align: center;
}
.post #photo-viewer .wp-block-separator {
  margin: 1em 0 1.5em 0;
}
/* Misc */
.elementor-element blockquote {
  padding: 1em 1.5em;
  background-color: #f0f0f0;
  font-style: italic;
  margin: 0 0 1.5em;
  border-left: 4px solid #d63031;
}

        </style>

    <?php
    }, 10);

