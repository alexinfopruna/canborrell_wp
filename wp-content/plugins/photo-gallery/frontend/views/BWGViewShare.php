<?php
class BWGViewShare {

  private $model;

  public function __construct($model) {
    $this->model = $model;
  }

  public function display() {
    $image_id = WDWLibrary::get('image_id', 0, 'intval');
    $curr_url = WDWLibrary::get('curr_url', '', 'esc_url');
    $current_url = !empty($curr_url) ? html_entity_decode(urldecode(urldecode($curr_url))) : '';
    if ( !empty($image_id) ) {
      require_once(BWG()->plugin_dir . '/framework/WDWLibrary.php');
	    $cur_image_row = $this->model->get_image_row_data($image_id);
      if (!$cur_image_row) {
        header("HTTP/1.1 410 Gone");
        die();
      }
      $gallery_id = $cur_image_row->gallery_id;
      $alt = ($cur_image_row->alt != '') ? $cur_image_row->alt: get_bloginfo('name');
      $description = $cur_image_row->description;	  
      $is_embed = preg_match('/EMBED/', $cur_image_row->filetype)==1 ? true : false;     
      $share_url = add_query_arg(array('curr_url' => $current_url, 'image_id' => $image_id), WDWLibrary::get_share_page()) . '#bwg' . $gallery_id . '/' . $image_id;
      if (!$is_embed) {
        $image_path_url = htmlspecialchars_decode(BWG()->upload_dir . $cur_image_row->image_url, ENT_COMPAT | ENT_QUOTES);
        $image_path_url = explode('?bwg', $image_path_url);
        list($image_thumb_width, $image_thumb_height) = getimagesize($image_path_url[0]);
      }
      else {
        $image_thumb_width = BWG()->options->thumb_width;
        if ($cur_image_row->resolution != '') {
          $resolution_arr = explode(" ", $cur_image_row->resolution);
          $resolution_w = intval($resolution_arr[0]);
          $resolution_h = intval($resolution_arr[2]);
          if ($resolution_w != 0 && $resolution_h != 0) {
            $scale = $scale = max(BWG()->options->thumb_width / $resolution_w, BWG()->options->thumb_height / $resolution_h);
            $image_thumb_width = $resolution_w * $scale;
            $image_thumb_height = $resolution_h * $scale;
          }
          else {
            $image_thumb_width = BWG()->options->thumb_width;
            $image_thumb_height = BWG()->options->thumb_height;
          }
        }
        else {
          $image_thumb_width = BWG()->options->thumb_width;
          $image_thumb_height = BWG()->options->thumb_height;
        }
      }
      ?>
      <!DOCTYPE html>
      <script>
        var bwg_hash = window.parent.location.hash;
        if (bwg_hash) {
          if (bwg_hash.indexOf("bwg") == "-1") {
            bwg_hash = bwg_hash.replace("#", "#bwg");
          }
          window.location.href = "<?php echo $current_url; ?>" + bwg_hash;
        }
      </script>
      <html>
        <head>
          <title><?php echo esc_html(get_bloginfo('name')); ?></title>
          <meta property="og:title" content="<?php echo esc_attr($alt); ?>" />
          <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>"/>
          <meta property="og:url" content="<?php echo esc_url($share_url); ?>" />
          <meta property="og:description" content="<?php echo esc_attr($description); ?>" />
          <meta property="og:image" content="<?php echo  esc_html($is_embed) ? esc_url($cur_image_row->thumb_url) : esc_url(BWG()->upload_url . str_replace(' ', '%20', $cur_image_row->image_url)); ?>" alt="<?php echo esc_html($cur_image_row->alt); ?>" />
          <meta property="og:image:width" name="bwg_width" content="<?php echo esc_attr($image_thumb_width); ?>" />
          <meta property="og:image:height" name="bwg_height" content="<?php echo esc_attr($image_thumb_height); ?>" />
          <meta name="twitter:card" content="summary_large_image" />
          <meta name="twitter:image" content="<?php echo  $is_embed ? esc_url($cur_image_row->thumb_url) : esc_url(BWG()->upload_url . str_replace(' ', '%20', $cur_image_row->image_url)); ?>" />
          <meta name="twitter:title" content="<?php echo esc_attr($alt); ?>" />
          <meta name="twitter:description" content="<?php echo esc_attr($description); ?>" />
          <meta content="summary" name="twitter:card" />
        </head>
        <body style="display:none">
          <img src="<?php echo  $is_embed ? esc_url($cur_image_row->thumb_url) : esc_url(BWG()->upload_url . str_replace(' ', '%20', $cur_image_row->image_url)); ?>" alt="<?php echo esc_attr($alt); ?>">
        </body>
      </html>	  
      <?php
    }
    die();
  }
}
