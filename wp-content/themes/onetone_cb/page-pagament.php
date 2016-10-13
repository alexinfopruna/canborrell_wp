<?php
/*
  Template Name: Input pagament
 */

$result="";
$rid="";
$mobil="";

if (isset($_POST['rid']) && isset($_POST['mobil'])){
  if (!defined('ROOT'))
  define('ROOT', "cb-reserves/taules/");

define('USR_FORM_WEB', 3); //ES LA ID D'USUARI (admin) ANONIM QUE CREA RESERVA ONLINE

require_once(ROOT . '../reservar/' . "Gestor_form.php");
$gestorf = new Gestor_form();

/**/

if (intval($_POST['rid'])< SEPARADOR_ID_RESERVES) {
  $r = $gestorf->load_reserva($_POST['rid'],'reserves');
  $mob=$r['tel'];
}
else {
  $r = $gestorf->load_reserva($_POST['rid']);
  $mob=$r['client_mobil'];
}

//print_r($r);die();

if ($mob!=$_POST['mobil']){
  $rid=$_POST['rid'];
  $mobil=$_POST['mobil'];
  $notfound=__('Reservation not found', 'canborrell');
  $result= '<div class="alert alert-danger" style="color:#bb8888;font-size:26px;" ><i class="fa fa-exclamation-triangle" style="color:#bb8888;font-size:26px;"></i> '.$notfound.'</div>';
}
else{
  
  
  if (intval($_POST['rid'])< SEPARADOR_ID_RESERVES) $_POST['accio']='pay';
  else  $_POST['accio']='edit';
  
 // echo $_POST['accio'];echo SEPARADOR_ID_RESERVES;die();
  $b64=base64_encode($_POST['rid']."&".$_POST['mobil']."&".ICL_LANGUAGE_CODE);
  switch ($_POST['accio']) {
    case 'pay':
      header('Location: /cb-reserves/editar/pagament256.php?id='.$_POST['rid'].'&lang='.ICL_LANGUAGE_CODE);
exit();
      break;

    case 'cancel':
      header('Location: /reservar/realitzar-reserva/?rid='.$b64.'&lang='.ICL_LANGUAGE_CODE);
exit();
      break;
    case 'edit':
      header('Location: /reservar/realitzar-reserva/?rid='.$b64.'&lang='.ICL_LANGUAGE_CODE);
exit();
      break;
    
    default:
        break;
  }
  
}
  
  
}


/*
 * 
 * 
 * 
 */

global $sitepress;
$lang = $sitepress->get_current_language();
if (!isset($_GET['a'])) {
  header("Location: /reservar/realizar-reserva/?lang=" . $lang);
  $_GET['a'] = "edit";
}

get_header();

//the_post();
//global $post;
//print_r($post);die();

$sidebar = isset($page_meta['page_layout']) ? $page_meta['page_layout'] : 'none';
$left_sidebar = isset($page_meta['left_sidebar']) ? $page_meta['left_sidebar'] : '';
$right_sidebar = isset($page_meta['right_sidebar']) ? $page_meta['right_sidebar'] : '';
$full_width = isset($page_meta['full_width']) ? $page_meta['full_width'] : 'no';
$display_breadcrumb = isset($page_meta['display_breadcrumb']) ? $page_meta['display_breadcrumb'] : 'yes';
$display_title = isset($page_meta['display_title']) ? $page_meta['display_title'] : 'yes';
$padding_top = isset($page_meta['padding_top']) ? $page_meta['padding_top'] : '';
$padding_bottom = isset($page_meta['padding_bottom']) ? $page_meta['padding_bottom'] : '';

if ($full_width == 'no')
  $container = 'container';
else
  $container = 'container-fullwidth';

$aside = 'no-aside';
if ($sidebar == 'left')
  $aside = 'left-aside';
if ($sidebar == 'right')
  $aside = 'right-aside';
if ($sidebar == 'both')
  $aside = 'both-aside';

$container_css = '';
if ($padding_top)
  $container_css .= 'padding-top:' . $padding_top . ';';
if ($padding_bottom)
  $container_css .= 'padding-bottom:' . $padding_bottom . ';';



$action_title['edit'] = 'Edit reservation';
$action_title['cancel'] = 'Cancel reservation';
$action_title['pay'] = 'Reservation payment';
$title = __($action_title[$_GET['a']], 'canborrell');
?>

<script  type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js'></script>
<script  type='text/javascript' src='http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/additional-methods.js'></script>


<style>
    label.error {
        color: red;
        font-style: italic;
        display:inline;
    }

    input{display:block;}

    input.error {
        border: 1px dotted red;
    }

    form#input-reserva{
        padding:20px;
        background-color: #eee;
        border-radius:8px;
    }
</style>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ($display_breadcrumb == 'yes'): ?>

      <section class="page-title-bar title-left no-subtitle" style="">
          <div class="container">
              <?php onetone_get_breadcrumb(array("before" => "<div class=''>", "after" => "</div>", "show_browse" => false, "separator" => '', 'container' => 'div')); ?>
              <hgroup class="page-title">
                  <h1>
                      <?php
                      echo $title;
                      //
                      //
          //the_title();
                      ?>
                  </h1>
              </hgroup>
              <div class="clearfix"></div>
          </div>
      </section>
    <?php endif; ?>
    <div class="post-wrap">
        <div class="<?php echo $container; ?>">
            <div class="post-inner row <?php echo $aside; ?>" style=" <?php echo $container_css; ?>">
                <div class="col-main">
                    <section class="post-main" role="main" id="content">
                        <?php while (have_posts()) : the_post(); ?>
                          <article class="post type-post" id="">
                              <?php if (has_post_thumbnail()): ?>
                                <div class="feature-img-box">
                                    <div class="img-box">
                                        <?php the_post_thumbnail(); ?>
                                    </div>
                                </div>
                              <?php endif; ?>
                              <div class="entry-main">

                                  <div class="entry-content ">
                                      <?php the_content(); ?>

                                      <?php
                                      echo $result;
                                      
                                      $required = __('This field is required', 'canborrell');
                                      $number = __('Enter a valid number', 'canborrell');
                                      $memail = __('Enter a valid phone  number', 'canborrell');
                                      $submit = __('Continue', 'canborrell');
                                      $id = __('Reservation ID', 'canborrell');
                                      $phone = __('Phone number', 'canborrell');
                                      ?>

                                      <form id="input-reserva" method="post" >
                                          <label for="rid"><?php echo $id ?></label>
                                          <input name="lang" type="hidden" id="lang" value="<?php echo $lang ?>">
                                          <input name="accio" type="hidden" id="accio" value="<?php echo $_GET['a'] ?>">
                                          <input name="rid" type="number" value="<?php echo $rid ?>" id="rid" required data-msg-required="<?php echo $required ?>" data-msg-email="<?php echo $number ?>">
                                          <br>
                                          <label for="mobil"><?php echo $phone ?></label>
                                          <input name="mobil" type="number" <?php echo empty($mobil)?'':' value="'.$mobil.'"' ?>  id="mob" required data-msg-required="<?php echo $required ?>" data-msg-email="<?php echo $memail ?>">
                                          <br>
                                          <button name="Continue" type="submit" id="submit"><?php echo $submit ?></button>

                                      </form>

                                      <?php
                                      wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'onetone') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>'));
                                      ?>
                                  </div>

                              </div>
                          </article>
                          <div class="post-attributes">
                              <!--Comments Area-->
                              <div class="comments-area text-left">
                                  <?php
                                  // If comments are open or we have at least one comment, load up the comment template
                                  if (comments_open()) :
                                    comments_template();
                                  endif;
                                  ?>
                              </div>
                              <!--Comments End-->
                          </div>
                        <?php endwhile; // end of the loop. ?>
                    </section>
                </div>
                <?php if ($sidebar == 'left' || $sidebar == 'both'): ?>
                  <div class="col-aside-left">
                      <aside class="blog-side left text-left">
                          <div class="widget-area">
                              <?php get_sidebar('pageleft'); ?>
                          </div>
                      </aside>
                  </div>
                <?php endif; ?>
                <?php if ($sidebar == 'right' || $sidebar == 'both'): ?>
                  <div class="col-aside-right">
                      <?php get_sidebar('pageright'); ?>
                  </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>
<?php get_footer(); ?>
