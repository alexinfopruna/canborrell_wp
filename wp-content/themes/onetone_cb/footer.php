<?php
$enable_footer_widget_area = esc_attr(onetone_option('enable_footer_widget_area', ''));
?>
<!--Footer-->
<footer>
    <?php if ($enable_footer_widget_area == '1'): ?>
      <div class="footer-widget-area">
          <div class="container">
              <div class="row">

                  <div class="col-md-5" style="">
                      <img src="/wp-content/uploads/2016/05/lg_sup_invert.gif" style="opacity:0.9;" />
                      
                     <!-- <a href="/" class="site-name" stylezzz="font-size:40px;COLOR:WHITE;text-decoration: none;">Restaurant Can Borrell</a> 
                      
                     -->
                     <p style="font-size:15px;COLOR:#ccc;line-height: 1.3;margin-top:12px;">
                          <a href="<?php echo WP_CB_GOOGLEMAPS;?>" class="gmaps" style="font-size:15px;COLOR:#ccc;" target="_blank" title="Mapa">
                              Carretera d'Horta a Cerdanyola (BV-1415), km 3 <br> 08171 Sant Cugat del Vallès
                          </a>
                      </p>


                  </div>

                  <div class="col-md-2 col-md-6 border-left">
                       <nav class="site-nav-footer footer-menu-1">
                           <?php echo __('Direct access','canborrell')?>
                          <?php
                          $onepage_menu = '';
                          wp_nav_menu(array('menu' => 19, 'theme_location' => 'home_menu', 'depth' => 0, 'fallback_cb' => false, 'container' => '', 'container_class' => 'main-menu', 'menu_id' => 'menu-main', 'menu_class' => 'main-nav', 'link_before' => '<span>', 'link_after' => '</span>', 'items_wrap' => '<ul id="%1$s" class="%2$s">' . $onepage_menu . '%3$s</ul>'));
                          ?>
                      </nav>                     
                  </div>
                  <div class="col-md-2 col-md-6 border-left">
                       <nav class="site-nav-footer footer-menu-2">
                           <?php echo __('Reservation management','canborrell')?>
                          <?php
                          $onepage_menu = '';
                          wp_nav_menu(array('menu' => 20, 'theme_location' => 'home_menu', 'depth' => 0, 'fallback_cb' => false, 'container' => '', 'container_class' => 'main-menu', 'menu_id' => 'menu-main', 'menu_class' => 'main-nav', 'link_before' => '<span>', 'link_after' => '</span>', 'items_wrap' => '<ul id="%1$s" class="%2$s">' . $onepage_menu . '%3$s</ul>'));
                          ?>
<br/>
                      </nav>                     
                  </div>

                  
                  
                  <div class="col-md-3 col-md-6 border-left">
  <?php
  if (is_active_sidebar("footer_widget_1")) {
    dynamic_sidebar("footer_widget_1");
  }
  ?>
                  </div>
  
              </div>
          </div>
      </div>
<?php endif; ?>
    <div class="footer-info-area">
        <div class="container">	
            <div class="site-info">
<?php
if (is_home() || is_front_page()) {
  //printf(__('Designed by <a href="%s">MageeWP Themes</a>.', 'onetone'), esc_url('http://www.mageewp.com/'));
}
else {
 // printf(__('Designed by MageeWP Themes.', 'onetone'));
}
?>
            </div>
        </div>
    </div>			
</footer>
</div>
<?php wp_footer(); ?>
<?php if (isset($_GET['database'])) echo DB_NAME; ?>
</body>
</html>

