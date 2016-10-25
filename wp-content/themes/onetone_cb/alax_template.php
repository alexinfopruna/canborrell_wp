<?php
/*
  Template Name: Ajax Template
 */
  ?>
  <div id="gallery-close"><i class="fa  fa-times-circle"></i></div>
  
  <?php
  
  if (have_posts()) : while (have_posts()) : the_post();
      the_content();
      
    endwhile;
  endif;
  ?>