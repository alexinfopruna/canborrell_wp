<?php
/*
  Template Name: Resultat TPV
 */
?><!DOCTYPE html>
<html lang="ca" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="http://cbwp-localhost/xmlrpc.php">
        <link rel='stylesheet' id='dashicons-css'  href='http://cbwp-localhost/wp-includes/css/dashicons.min.css?ver=4.6.1' type='text/css' media='all' />
        <link rel='stylesheet' id='admin-bar-css'  href='http://cbwp-localhost/wp-includes/css/admin-bar.min.css?ver=4.6.1' type='text/css' media='all' />
        <link rel='stylesheet' id='jqueryui-css'  href='http://cbwp-localhost/cb-reserves/css/jquery-ui.css?ver=4.6.1' type='text/css' media='all' />
        <link rel='stylesheet' id='iwmp-styles-css'  href='http://cbwp-localhost/wp-content/plugins/iw-magnific-popup/includes/assets/magnific-popup.css?ver=4.6.1' type='text/css' media='all' />
        <link rel='stylesheet' id='font-awesome-css'  href='http://cbwp-localhost/wp-content/plugins/magee-shortcodes/assets/font-awesome/css/font-awesome.css?ver=4.4.0' type='text/css' media='' />
        <link rel='stylesheet' id='bootstrap-css'  href='http://cbwp-localhost/wp-content/plugins/magee-shortcodes/assets/bootstrap/css/bootstrap.min.css?ver=3.3.4' type='text/css' media='' />

        <link rel='stylesheet' id='parent-style-css'  href='http://cbwp-localhost/wp-content/themes/onetone/style.css?ver=4.6.1' type='text/css' media='all' />
        <link rel='stylesheet' id='onetone-Yanone-Kaffeesatz-css'  href='//fonts.googleapis.com/css?family=Open+Sans%3A300%2C400%2C700%7CYanone+Kaffeesatz%7CLustria&#038;ver=4.6.1' type='text/css' media='' />
        <link rel='stylesheet' id='owl.carousel-css'  href='http://cbwp-localhost/wp-content/themes/onetone/plugins/owl-carousel/assets/owl.carousel.css?ver=4.6.1' type='text/css' media='' />
        <link rel='stylesheet' id='onetone-main-css'  href='http://cbwp-localhost/wp-content/themes/onetone_cb/style.css?ver=1.1.0' type='text/css' media='all' />


        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
        <style>

#calendari-header {
     position: initial; 
    top: 3px;
    //right: 110px;
    z-index: 99;
}
        </style>
        <!--[if lt IE 9]>
        <script src="http://cbwp-localhost/wp-content/themes/onetone/js/html5.js"></script>
        <![endif]-->
        <title>Resultat TPV &#8211; Restaurant Can Borrell</title
    </head>
    <body class="page page-id-1199 page-child parent-pageid-665 page-template page-template-page-resultat-tpv page-template-page-resultat-tpv-php logged-in admin-bar no-customize-support blog page-resultat-tpv">
        <div class="wrapper">
            <div class="top-wrap">
                <!--Header-->
                <header class="header-wrap logo-left ">

                    <div id="calendari-header">





                        <div class="top-bar">
                            <div class="container">
                                <div class="top-bar-left">
                                    <div class="top-bar-info"></div>                      
                                </div>
                                <div class="top-bar-right">
                                    <div class="top-bar-info"></div>                              </div>
                            </div>
                        </div>

                        <div class="main-header ">
                            <div class="container">
                                <div id="calendari-header">
                                    <div class="header_widget_1"></div> <input type = "text" name = "rdata" placeholder = "Make a resevation" id = "top-datepicker" class = "form-control top-datepicker ">
                                </div>


                                    <div class="name-box" style=" display:block;">
                                        <h1 class="site-name">Restaurant Can Borrell</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </header>

                        <?php
//get_header();

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

                        /*                         * ************************************************************************************* */
                        /*                         * ************************************************************************************* */
                        /*                         * ************************************************************************************* */
                        /*                         * ************************************************************************************* */
                        /*                         * ************************************************************************************* */
                        /*                         * ************************************************************************************* */
                        /*                         * ************************************************************************************* */
                        /*                         * ************************************************************************************* */
                        /*                         * ************************************************************************************* */
                        /*                         * ************************************************************************************* */
                        /*                         * ************************************************************************************* */
                        $r = null;
                        $surt = false;
                        $lang = $_GET['lang'];


                        if (!defined('ROOT'))
                          define('ROOT', "cb-reserves/taules/");
                        require_once(ROOT . "Gestor.php");
                        require_once(ROOT . "gestor_reserves.php");

                        require(ROOT . DB_CONNECTION_FILE);
                        require_once(ROOT . INC_FILE_PATH . 'valors.php');
                        require_once(ROOT . INC_FILE_PATH . 'alex.inc'); //valida_admin('editar.php') ;
                        $titol['cat'] = "PAGAMENT DE RESERVA";
                        $titol['esp'] = "PAGO DE RESERVA";
                        $titol['en'] = "PAYMENT OF RESERVATION";
                        $subtitol['cat'] = "Dades de la reserva";
                        $subtitol['esp'] = "Datos de la reserva";
                        $subtitol['esp'] = "Reservation Information";

                        /*                         * *************************************************************************** */
                        $gestor = new gestor_reserves();
                        /*                         * *************************************************************************** */
                        if (!isset($_GET['rid']))
                          die("ERRROR: Falta RID");


                        $rid = base64_decode($_GET['rid']);
                        $st = explode('&', $rid);
                        $id = $_GET["id"] = intval(substr($st[0], -5));
                        $_GET["mob"] = $st[1];
                        $r = $gestor->load_reserva($_GET["id"], 'reserves');
                        if ($_GET["mob"] == 'ko' || $_GET["mob"] == 'ok') {

                          $resultat_ok = FALSE;
                          if ($r['estat'] == 7)
                            $resultat_ok = TRUE;
                        }

                        $mob = $r['tel'];

                        $result = "";
                        $rid = "";
                        $mobil = "";



                        if (!isset($lang))
                          $lang = $lang_cli = "es";


                        $old_lang_code['cat'] = 'cat';
                        $old_lang_code['ca'] = 'cat';
                        $old_lang_code['es'] = 'esp';
                        $old_lang_code['esp'] = 'esp';
                        $old_lang_code['en'] = 'en';


                        $lang = $old_lang_code[$lang];
                        ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <?php if ($display_breadcrumb == 'yes'): ?>

                              <section class="page-title-bar title-left no-subtitle" style="">
                                  <div class="container">
                                      <hgroup class="page-title">
                                          <h1>
                                              <?php
                                              // echo $title;
                                              //
                      //
          the_title();
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
                                                              <?php
                                                              the_content();


                                                              require_once(ROOT . INC_FILE_PATH . 'valors.php');
                                                              $titol['cat'] = "EL PAGAMENT S'HA REALITZAT AMB ÈXIT.<br><br>Gràcies per utilitzar aquest servei.";
                                                              $titol['esp'] = "EL PAGO SE HA REALIZADO CON ÉXITO.<br><br>Gracias por utilizar este servicio";
                                                              $titol['en'] = "THE PAYMENT IS COMPLETE.<br><br>Thank you for using this service";

                                                              $titol2['cat'] = "S'HA PRODUÏT UN ERROR EN EL PAGAMENT<br><br>Gràcies per utilitzar aquest servei";
                                                              $titol2['esp'] = "SE HA PRODUCIDO UN ERROR EN EL PAGO.<br><br>Gracias por utilizar este servicio";
                                                              $titol2['en'] = "THERE HAS BEEN A PAYMENT ERROR.<br><br>Thank you for using this Service";
                                                              if ($resultat_ok):
                                                                ?>
                                                                <div class="alert alert-success">
                                                                <?php echo $titol[$lang] ?>
                                                                </div>
                                                                  <?php else: ?>
                                                                <div class="alert alert-danger">
                                                                <?php echo $titol2[$lang] ?>
                                                                </div>
                                                              <?php
                                                              endif;

                                                              echo '<div class="alert alert-info">' . $txt[9][$lang] . '</div>';

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
                                        <?php endwhile; // end of the loop.    ?>
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
<?php // get_footer();  ?>
