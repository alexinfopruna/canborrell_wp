<?php
namespace MageeShortcodes\Classes;
use MageeShortcodes\Classes\Helper;
use MageeShortcodes\Classes\Utils;

class Config{
    
    public static function get_front_scripts() {

        $min_suffix = Utils::is_script_debug() ? '' : '.min';
        $return = [
                'styles'=>  ['font-awesome' => [MAGEE_SHORTCODES_URL.'assets/font-awesome/css/font-awesome'.$min_suffix.'.css', '', '4.4.0', false ],
                            'bootstrap' => [MAGEE_SHORTCODES_URL.'assets/bootstrap/css/bootstrap'.$min_suffix.'.css', '', '3.3.7', false ],
                            'prettyphoto' => [MAGEE_SHORTCODES_URL. 'assets/css/prettyPhoto'.$min_suffix.'.css', '', '', false ],
                            'owl-carousel' => [MAGEE_SHORTCODES_URL.'assets/owl-carousel/assets/owl.carousel.css', false, '', 'all' ],
                            'owl-theme' => [MAGEE_SHORTCODES_URL.'assets/owl-carousel/assets/owl.theme.css', false, '', false],
                            'twentytwenty' => [MAGEE_SHORTCODES_URL. 'assets/twentytwenty/css/twentytwenty.css', '', MAGEE_SHORTCODES_VER, false ],
                            'audioplayer' => [MAGEE_SHORTCODES_URL. 'assets/css/audioplayer'.$min_suffix.'.css', '', '', false ],
                            'weather-icons' => [MAGEE_SHORTCODES_URL. 'assets/weathericons/css/weather-icons.min.css', '', '', false ],
                            'jquery-classycountdown' => [MAGEE_SHORTCODES_URL. 'assets/jquery-countdown/jquery.classycountdown.css', '', '1.1.0', false ],
                            'chart' => [MAGEE_SHORTCODES_URL.  'assets/chart/chart'.$min_suffix.'.css', '', '2.9.4', false ],
                            'animate' => [MAGEE_SHORTCODES_URL. 'assets/css/animate'.$min_suffix.'.css', '', '', false ],
                            'magee-shortcodes' => [MAGEE_SHORTCODES_URL. 'assets/css/shortcodes'.$min_suffix.'.css', '', MAGEE_SHORTCODES_VER, 'all' ],
                            
                ],
                'scripts' => [
                            'bootstrap' => [MAGEE_SHORTCODES_URL.'assets/bootstrap/js/bootstrap'.$min_suffix.'.js', array( 'jquery'), '3.3.7', false],
                            'jquery-waypoints' => [MAGEE_SHORTCODES_URL. 'assets/js/jquery.waypoints.js', array( 'jquery'), '2.0.5', false],
                            'jquery-countdown' => [MAGEE_SHORTCODES_URL.  'assets/jquery-countdown/jquery.countdown.min.js', array( 'jquery'), '2.0.4', false],
                            'jquery-knob' => [MAGEE_SHORTCODES_URL.  'assets/jquery-countdown/jquery.knob.js', array( 'jquery'), '1.2.11', false],
                            'jquery-throttle' => [MAGEE_SHORTCODES_URL.  'assets/jquery-countdown/jquery.throttle.js', array( 'jquery'), '', false],
                            'jquery-classycountdown' => [MAGEE_SHORTCODES_URL.  'assets/jquery-countdown/jquery.classycountdown'.$min_suffix.'.js', array( 'jquery'), '1.1.0', false],
                            'jquery-countto' => [MAGEE_SHORTCODES_URL.  'assets/js/jquery.countTo.js', array( 'jquery'), '', false],
                            'jquery-easypiechart'=> [MAGEE_SHORTCODES_URL.  'assets/jquery-easy-pie-chart/jquery.easypiechart.min.js', array( 'jquery'), '2.1.7', false],
                            'jquery-prettyphoto'=> [MAGEE_SHORTCODES_URL.  'assets/js/jquery.prettyPhoto.js', array( 'jquery'), '3.1.6', false],
                            'owl-carousel'=> [MAGEE_SHORTCODES_URL.  'assets/owl-carousel/owl.carousel.min.js', array( 'jquery' ), null, true],
                            'jquery-event-move'=> [MAGEE_SHORTCODES_URL. 'assets/twentytwenty/js/jquery.event.move.js', array( 'jquery'), '1.3.6', false],
                            'jquery-twentytwenty'=> [MAGEE_SHORTCODES_URL.  'assets/twentytwenty/js/jquery.twentytwenty.js', array( 'jquery'), MAGEE_SHORTCODES_VER, false],
                            'jquery-audioplayer'=> [MAGEE_SHORTCODES_URL.  'assets/js/audioplayer.js', array( 'jquery'), '', false],
                            'chart'=> [MAGEE_SHORTCODES_URL.  'assets/chart/chart'.$min_suffix.'.js', array( 'jquery'), '2.9.4', false],
                            'magee-shortcodes'=> [MAGEE_SHORTCODES_URL.  'assets/js/shortcodes'.$min_suffix.'.js', array( 'jquery'), MAGEE_SHORTCODES_VER, true],
                ]
            
        ];

        return $return;

    }

    public static function get_icons(){
        $icons = array('fa-glass'=>'\f000', 'fa-music'=>'\f001', 'fa-search'=>'\f002', 'fa-envelope-o'=>'\f003', 'fa-heart'=>'\f004', 'fa-star'=>'\f005', 'fa-star-o'=>'\f006', 'fa-user'=>'\f007', 'fa-film'=>'\f008', 'fa-th-large'=>'\f009', 'fa-th'=>'\f00a', 'fa-th-list'=>'\f00b', 'fa-check'=>'\f00c', 'fa-times'=>'\f00d', 'fa-search-plus'=>'\f00e', 'fa-search-minus'=>'\f010', 'fa-power-off'=>'\f011', 'fa-signal'=>'\f012', 'fa-cog'=>'\f013', 'fa-trash-o'=>'\f014', 'fa-home'=>'\f015', 'fa-file-o'=>'\f016', 'fa-clock-o'=>'\f017', 'fa-road'=>'\f018', 'fa-download'=>'\f019', 'fa-arrow-circle-o-down'=>'\f01a', 'fa-arrow-circle-o-up'=>'\f01b', 'fa-inbox'=>'\f01c', 'fa-play-circle-o'=>'\f01d', 'fa-repeat'=>'\f01e', 'fa-refresh'=>'\f021', 'fa-list-alt'=>'\f022', 'fa-lock'=>'\f023', 'fa-flag'=>'\f024', 'fa-headphones'=>'\f025', 'fa-volume-off'=>'\f026', 'fa-volume-down'=>'\f027', 'fa-volume-up'=>'\f028', 'fa-qrcode'=>'\f029', 'fa-barcode'=>'\f02a', 'fa-tag'=>'\f02b', 'fa-tags'=>'\f02c', 'fa-book'=>'\f02d', 'fa-bookmark'=>'\f02e', 'fa-print'=>'\f02f', 'fa-camera'=>'\f030', 'fa-font'=>'\f031', 'fa-bold'=>'\f032', 'fa-italic'=>'\f033', 'fa-text-height'=>'\f034', 'fa-text-width'=>'\f035', 'fa-align-left'=>'\f036', 'fa-align-center'=>'\f037', 'fa-align-right'=>'\f038', 'fa-align-justify'=>'\f039', 'fa-list'=>'\f03a', 'fa-outdent'=>'\f03b', 'fa-indent'=>'\f03c', 'fa-video-camera'=>'\f03d', 'fa-picture-o'=>'\f03e', 'fa-pencil'=>'\f040', 'fa-map-marker'=>'\f041', 'fa-adjust'=>'\f042', 'fa-tint'=>'\f043', 'fa-pencil-square-o'=>'\f044', 'fa-share-square-o'=>'\f045', 'fa-check-square-o'=>'\f046', 'fa-arrows'=>'\f047', 'fa-step-backward'=>'\f048', 'fa-fast-backward'=>'\f049', 'fa-backward'=>'\f04a', 'fa-play'=>'\f04b', 'fa-pause'=>'\f04c', 'fa-stop'=>'\f04d', 'fa-forward'=>'\f04e', 'fa-fast-forward'=>'\f050', 'fa-step-forward'=>'\f051', 'fa-eject'=>'\f052', 'fa-chevron-left'=>'\f053', 'fa-chevron-right'=>'\f054', 'fa-plus-circle'=>'\f055', 'fa-minus-circle'=>'\f056', 'fa-times-circle'=>'\f057', 'fa-check-circle'=>'\f058', 'fa-question-circle'=>'\f059', 'fa-info-circle'=>'\f05a', 'fa-crosshairs'=>'\f05b', 'fa-times-circle-o'=>'\f05c', 'fa-check-circle-o'=>'\f05d', 'fa-ban'=>'\f05e', 'fa-arrow-left'=>'\f060', 'fa-arrow-right'=>'\f061', 'fa-arrow-up'=>'\f062', 'fa-arrow-down'=>'\f063', 'fa-share'=>'\f064', 'fa-expand'=>'\f065', 'fa-compress'=>'\f066', 'fa-plus'=>'\f067', 'fa-minus'=>'\f068', 'fa-asterisk'=>'\f069', 'fa-exclamation-circle'=>'\f06a', 'fa-gift'=>'\f06b', 'fa-leaf'=>'\f06c', 'fa-fire'=>'\f06d', 'fa-eye'=>'\f06e', 'fa-eye-slash'=>'\f070', 'fa-exclamation-triangle'=>'\f071', 'fa-plane'=>'\f072', 'fa-calendar'=>'\f073', 'fa-random'=>'\f074', 'fa-comment'=>'\f075', 'fa-magnet'=>'\f076', 'fa-chevron-up'=>'\f077', 'fa-chevron-down'=>'\f078', 'fa-retweet'=>'\f079', 'fa-shopping-cart'=>'\f07a', 'fa-folder'=>'\f07b', 'fa-folder-open'=>'\f07c', 'fa-arrows-v'=>'\f07d', 'fa-arrows-h'=>'\f07e', 'fa-bar-chart'=>'\f080', 'fa-twitter-square'=>'\f081', 'fa-facebook-square'=>'\f082', 'fa-camera-retro'=>'\f083', 'fa-key'=>'\f084', 'fa-cogs'=>'\f085', 'fa-comments'=>'\f086', 'fa-thumbs-o-up'=>'\f087', 'fa-thumbs-o-down'=>'\f088', 'fa-star-half'=>'\f089', 'fa-heart-o'=>'\f08a', 'fa-sign-out'=>'\f08b', 'fa-linkedin-square'=>'\f08c', 'fa-thumb-tack'=>'\f08d', 'fa-external-link'=>'\f08e', 'fa-sign-in'=>'\f090', 'fa-trophy'=>'\f091', 'fa-github-square'=>'\f092', 'fa-upload'=>'\f093', 'fa-lemon-o'=>'\f094', 'fa-phone'=>'\f095', 'fa-square-o'=>'\f096', 'fa-bookmark-o'=>'\f097', 'fa-phone-square'=>'\f098', 'fa-twitter'=>'\f099', 'fa-facebook'=>'\f09a', 'fa-github'=>'\f09b', 'fa-unlock'=>'\f09c', 'fa-credit-card'=>'\f09d', 'fa-rss'=>'\f09e', 'fa-hdd-o'=>'\f0a0', 'fa-bullhorn'=>'\f0a1', 'fa-bell'=>'\f0f3', 'fa-certificate'=>'\f0a3', 'fa-hand-o-right'=>'\f0a4', 'fa-hand-o-left'=>'\f0a5', 'fa-hand-o-up'=>'\f0a6', 'fa-hand-o-down'=>'\f0a7', 'fa-arrow-circle-left'=>'\f0a8', 'fa-arrow-circle-right'=>'\f0a9', 'fa-arrow-circle-up'=>'\f0aa', 'fa-arrow-circle-down'=>'\f0ab', 'fa-globe'=>'\f0ac', 'fa-wrench'=>'\f0ad', 'fa-tasks'=>'\f0ae', 'fa-filter'=>'\f0b0', 'fa-briefcase'=>'\f0b1', 'fa-arrows-alt'=>'\f0b2', 'fa-users'=>'\f0c0', 'fa-link'=>'\f0c1', 'fa-cloud'=>'\f0c2', 'fa-flask'=>'\f0c3', 'fa-scissors'=>'\f0c4', 'fa-files-o'=>'\f0c5', 'fa-paperclip'=>'\f0c6', 'fa-floppy-o'=>'\f0c7', 'fa-square'=>'\f0c8', 'fa-bars'=>'\f0c9', 'fa-list-ul'=>'\f0ca', 'fa-list-ol'=>'\f0cb', 'fa-strikethrough'=>'\f0cc', 'fa-underline'=>'\f0cd', 'fa-table'=>'\f0ce', 'fa-magic'=>'\f0d0', 'fa-truck'=>'\f0d1', 'fa-pinterest'=>'\f0d2', 'fa-pinterest-square'=>'\f0d3', 'fa-google-plus-square'=>'\f0d4', 'fa-google-plus'=>'\f0d5', 'fa-money'=>'\f0d6', 'fa-caret-down'=>'\f0d7', 'fa-caret-up'=>'\f0d8', 'fa-caret-left'=>'\f0d9', 'fa-caret-right'=>'\f0da', 'fa-columns'=>'\f0db', 'fa-sort'=>'\f0dc', 'fa-sort-desc'=>'\f0dd', 'fa-sort-asc'=>'\f0de', 'fa-envelope'=>'\f0e0', 'fa-linkedin'=>'\f0e1', 'fa-undo'=>'\f0e2', 'fa-gavel'=>'\f0e3', 'fa-tachometer'=>'\f0e4', 'fa-comment-o'=>'\f0e5', 'fa-comments-o'=>'\f0e6', 'fa-bolt'=>'\f0e7', 'fa-sitemap'=>'\f0e8', 'fa-umbrella'=>'\f0e9', 'fa-clipboard'=>'\f0ea', 'fa-lightbulb-o'=>'\f0eb', 'fa-exchange'=>'\f0ec', 'fa-cloud-download'=>'\f0ed', 'fa-cloud-upload'=>'\f0ee', 'fa-user-md'=>'\f0f0', 'fa-stethoscope'=>'\f0f1', 'fa-suitcase'=>'\f0f2', 'fa-bell-o'=>'\f0a2', 'fa-coffee'=>'\f0f4', 'fa-cutlery'=>'\f0f5', 'fa-file-text-o'=>'\f0f6', 'fa-building-o'=>'\f0f7', 'fa-hospital-o'=>'\f0f8', 'fa-ambulance'=>'\f0f9', 'fa-medkit'=>'\f0fa', 'fa-fighter-jet'=>'\f0fb', 'fa-beer'=>'\f0fc', 'fa-h-square'=>'\f0fd', 'fa-plus-square'=>'\f0fe', 'fa-angle-double-left'=>'\f100', 'fa-angle-double-right'=>'\f101', 'fa-angle-double-up'=>'\f102', 'fa-angle-double-down'=>'\f103', 'fa-angle-left'=>'\f104', 'fa-angle-right'=>'\f105', 'fa-angle-up'=>'\f106', 'fa-angle-down'=>'\f107', 'fa-desktop'=>'\f108', 'fa-laptop'=>'\f109', 'fa-tablet'=>'\f10a', 'fa-mobile'=>'\f10b', 'fa-circle-o'=>'\f10c', 'fa-quote-left'=>'\f10d', 'fa-quote-right'=>'\f10e', 'fa-spinner'=>'\f110', 'fa-circle'=>'\f111', 'fa-reply'=>'\f112', 'fa-github-alt'=>'\f113', 'fa-folder-o'=>'\f114', 'fa-folder-open-o'=>'\f115', 'fa-smile-o'=>'\f118', 'fa-frown-o'=>'\f119', 'fa-meh-o'=>'\f11a', 'fa-gamepad'=>'\f11b', 'fa-keyboard-o'=>'\f11c', 'fa-flag-o'=>'\f11d', 'fa-flag-checkered'=>'\f11e', 'fa-terminal'=>'\f120', 'fa-code'=>'\f121', 'fa-reply-all'=>'\f122', 'fa-star-half-o'=>'\f123', 'fa-location-arrow'=>'\f124', 'fa-crop'=>'\f125', 'fa-code-fork'=>'\f126', 'fa-chain-broken'=>'\f127', 'fa-question'=>'\f128', 'fa-info'=>'\f129', 'fa-exclamation'=>'\f12a', 'fa-superscript'=>'\f12b', 'fa-subscript'=>'\f12c', 'fa-eraser'=>'\f12d', 'fa-puzzle-piece'=>'\f12e', 'fa-microphone'=>'\f130', 'fa-microphone-slash'=>'\f131', 'fa-shield'=>'\f132', 'fa-calendar-o'=>'\f133', 'fa-fire-extinguisher'=>'\f134', 'fa-rocket'=>'\f135', 'fa-maxcdn'=>'\f136', 'fa-chevron-circle-left'=>'\f137', 'fa-chevron-circle-right'=>'\f138', 'fa-chevron-circle-up'=>'\f139', 'fa-chevron-circle-down'=>'\f13a', 'fa-html5'=>'\f13b', 'fa-css3'=>'\f13c', 'fa-anchor'=>'\f13d', 'fa-unlock-alt'=>'\f13e', 'fa-bullseye'=>'\f140', 'fa-ellipsis-h'=>'\f141', 'fa-ellipsis-v'=>'\f142', 'fa-rss-square'=>'\f143', 'fa-play-circle'=>'\f144', 'fa-ticket'=>'\f145', 'fa-minus-square'=>'\f146', 'fa-minus-square-o'=>'\f147', 'fa-level-up'=>'\f148', 'fa-level-down'=>'\f149', 'fa-check-square'=>'\f14a', 'fa-pencil-square'=>'\f14b', 'fa-external-link-square'=>'\f14c', 'fa-share-square'=>'\f14d', 'fa-compass'=>'\f14e', 'fa-caret-square-o-down'=>'\f150', 'fa-caret-square-o-up'=>'\f151', 'fa-caret-square-o-right'=>'\f152', 'fa-eur'=>'\f153', 'fa-gbp'=>'\f154', 'fa-usd'=>'\f155', 'fa-inr'=>'\f156', 'fa-jpy'=>'\f157', 'fa-rub'=>'\f158', 'fa-krw'=>'\f159', 'fa-btc'=>'\f15a', 'fa-file'=>'\f15b', 'fa-file-text'=>'\f15c', 'fa-sort-alpha-asc'=>'\f15d', 'fa-sort-alpha-desc'=>'\f15e', 'fa-sort-amount-asc'=>'\f160', 'fa-sort-amount-desc'=>'\f161', 'fa-sort-numeric-asc'=>'\f162', 'fa-sort-numeric-desc'=>'\f163', 'fa-thumbs-up'=>'\f164', 'fa-thumbs-down'=>'\f165', 'fa-youtube-square'=>'\f166', 'fa-youtube'=>'\f167', 'fa-xing'=>'\f168', 'fa-xing-square'=>'\f169', 'fa-youtube-play'=>'\f16a', 'fa-dropbox'=>'\f16b', 'fa-stack-overflow'=>'\f16c', 'fa-instagram'=>'\f16d', 'fa-flickr'=>'\f16e', 'fa-adn'=>'\f170', 'fa-bitbucket'=>'\f171', 'fa-bitbucket-square'=>'\f172', 'fa-tumblr'=>'\f173', 'fa-tumblr-square'=>'\f174', 'fa-long-arrow-down'=>'\f175', 'fa-long-arrow-up'=>'\f176', 'fa-long-arrow-left'=>'\f177', 'fa-long-arrow-right'=>'\f178', 'fa-apple'=>'\f179', 'fa-windows'=>'\f17a', 'fa-android'=>'\f17b', 'fa-linux'=>'\f17c', 'fa-dribbble'=>'\f17d', 'fa-skype'=>'\f17e', 'fa-foursquare'=>'\f180', 'fa-trello'=>'\f181', 'fa-female'=>'\f182', 'fa-male'=>'\f183', 'fa-gratipay'=>'\f184', 'fa-sun-o'=>'\f185', 'fa-moon-o'=>'\f186', 'fa-archive'=>'\f187', 'fa-bug'=>'\f188', 'fa-vk'=>'\f189', 'fa-weibo'=>'\f18a', 'fa-renren'=>'\f18b', 'fa-pagelines'=>'\f18c', 'fa-stack-exchange'=>'\f18d', 'fa-arrow-circle-o-right'=>'\f18e', 'fa-arrow-circle-o-left'=>'\f190', 'fa-caret-square-o-left'=>'\f191', 'fa-dot-circle-o'=>'\f192', 'fa-wheelchair'=>'\f193', 'fa-vimeo-square'=>'\f194', 'fa-try'=>'\f195', 'fa-plus-square-o'=>'\f196', 'fa-space-shuttle'=>'\f197', 'fa-slack'=>'\f198', 'fa-envelope-square'=>'\f199', 'fa-wordpress'=>'\f19a', 'fa-openid'=>'\f19b', 'fa-university'=>'\f19c', 'fa-graduation-cap'=>'\f19d', 'fa-yahoo'=>'\f19e', 'fa-google'=>'\f1a0', 'fa-reddit'=>'\f1a1', 'fa-reddit-square'=>'\f1a2', 'fa-stumbleupon-circle'=>'\f1a3', 'fa-stumbleupon'=>'\f1a4', 'fa-delicious'=>'\f1a5', 'fa-digg'=>'\f1a6', 'fa-pied-piper'=>'\f1a7', 'fa-pied-piper-alt'=>'\f1a8', 'fa-drupal'=>'\f1a9', 'fa-joomla'=>'\f1aa', 'fa-language'=>'\f1ab', 'fa-fax'=>'\f1ac', 'fa-building'=>'\f1ad', 'fa-child'=>'\f1ae', 'fa-paw'=>'\f1b0', 'fa-spoon'=>'\f1b1', 'fa-cube'=>'\f1b2', 'fa-cubes'=>'\f1b3', 'fa-behance'=>'\f1b4', 'fa-behance-square'=>'\f1b5', 'fa-steam'=>'\f1b6', 'fa-steam-square'=>'\f1b7', 'fa-recycle'=>'\f1b8', 'fa-car'=>'\f1b9', 'fa-taxi'=>'\f1ba', 'fa-tree'=>'\f1bb', 'fa-spotify'=>'\f1bc', 'fa-deviantart'=>'\f1bd', 'fa-soundcloud'=>'\f1be', 'fa-database'=>'\f1c0', 'fa-file-pdf-o'=>'\f1c1', 'fa-file-word-o'=>'\f1c2', 'fa-file-excel-o'=>'\f1c3', 'fa-file-powerpoint-o'=>'\f1c4', 'fa-file-image-o'=>'\f1c5', 'fa-file-archive-o'=>'\f1c6', 'fa-file-audio-o'=>'\f1c7', 'fa-file-video-o'=>'\f1c8', 'fa-file-code-o'=>'\f1c9', 'fa-vine'=>'\f1ca', 'fa-codepen'=>'\f1cb', 'fa-jsfiddle'=>'\f1cc', 'fa-life-ring'=>'\f1cd', 'fa-circle-o-notch'=>'\f1ce', 'fa-rebel'=>'\f1d0', 'fa-empire'=>'\f1d1', 'fa-git-square'=>'\f1d2', 'fa-git'=>'\f1d3', 'fa-hacker-news'=>'\f1d4', 'fa-tencent-weibo'=>'\f1d5', 'fa-qq'=>'\f1d6', 'fa-weixin'=>'\f1d7', 'fa-paper-plane'=>'\f1d8', 'fa-paper-plane-o'=>'\f1d9', 'fa-history'=>'\f1da', 'fa-circle-thin'=>'\f1db', 'fa-header'=>'\f1dc', 'fa-paragraph'=>'\f1dd', 'fa-sliders'=>'\f1de', 'fa-share-alt'=>'\f1e0', 'fa-share-alt-square'=>'\f1e1', 'fa-bomb'=>'\f1e2', 'fa-futbol-o'=>'\f1e3', 'fa-tty'=>'\f1e4', 'fa-binoculars'=>'\f1e5', 'fa-plug'=>'\f1e6', 'fa-slideshare'=>'\f1e7', 'fa-twitch'=>'\f1e8', 'fa-yelp'=>'\f1e9', 'fa-newspaper-o'=>'\f1ea', 'fa-wifi'=>'\f1eb', 'fa-calculator'=>'\f1ec', 'fa-paypal'=>'\f1ed', 'fa-google-wallet'=>'\f1ee', 'fa-cc-visa'=>'\f1f0', 'fa-cc-mastercard'=>'\f1f1', 'fa-cc-discover'=>'\f1f2', 'fa-cc-amex'=>'\f1f3', 'fa-cc-paypal'=>'\f1f4', 'fa-cc-stripe'=>'\f1f5', 'fa-bell-slash'=>'\f1f6', 'fa-bell-slash-o'=>'\f1f7', 'fa-trash'=>'\f1f8', 'fa-copyright'=>'\f1f9', 'fa-at'=>'\f1fa', 'fa-eyedropper'=>'\f1fb', 'fa-paint-brush'=>'\f1fc', 'fa-birthday-cake'=>'\f1fd', 'fa-area-chart'=>'\f1fe', 'fa-pie-chart'=>'\f200', 'fa-line-chart'=>'\f201', 'fa-lastfm'=>'\f202', 'fa-lastfm-square'=>'\f203', 'fa-toggle-off'=>'\f204', 'fa-toggle-on'=>'\f205', 'fa-bicycle'=>'\f206', 'fa-bus'=>'\f207', 'fa-ioxhost'=>'\f208', 'fa-angellist'=>'\f209', 'fa-cc'=>'\f20a', 'fa-ils'=>'\f20b', 'fa-meanpath'=>'\f20c', 'fa-buysellads'=>'\f20d', 'fa-connectdevelop'=>'\f20e', 'fa-dashcube'=>'\f210', 'fa-forumbee'=>'\f211', 'fa-leanpub'=>'\f212', 'fa-sellsy'=>'\f213', 'fa-shirtsinbulk'=>'\f214', 'fa-simplybuilt'=>'\f215', 'fa-skyatlas'=>'\f216', 'fa-cart-plus'=>'\f217', 'fa-cart-arrow-down'=>'\f218', 'fa-diamond'=>'\f219', 'fa-ship'=>'\f21a', 'fa-user-secret'=>'\f21b', 'fa-motorcycle'=>'\f21c', 'fa-street-view'=>'\f21d', 'fa-heartbeat'=>'\f21e', 'fa-venus'=>'\f221', 'fa-mars'=>'\f222', 'fa-mercury'=>'\f223', 'fa-transgender'=>'\f224', 'fa-transgender-alt'=>'\f225', 'fa-venus-double'=>'\f226', 'fa-mars-double'=>'\f227', 'fa-venus-mars'=>'\f228', 'fa-mars-stroke'=>'\f229', 'fa-mars-stroke-v'=>'\f22a', 'fa-mars-stroke-h'=>'\f22b', 'fa-neuter'=>'\f22c', 'fa-genderless'=>'\f22d', 'fa-facebook-official'=>'\f230', 'fa-pinterest-p'=>'\f231', 'fa-whatsapp'=>'\f232', 'fa-server'=>'\f233', 'fa-user-plus'=>'\f234', 'fa-user-times'=>'\f235', 'fa-bed'=>'\f236', 'fa-viacoin'=>'\f237', 'fa-train'=>'\f238', 'fa-subway'=>'\f239', 'fa-medium'=>'\f23a', 'fa-y-combinator'=>'\f23b', 'fa-optin-monster'=>'\f23c', 'fa-opencart'=>'\f23d', 'fa-expeditedssl'=>'\f23e', 'fa-battery-full'=>'\f240', 'fa-battery-three-quarters'=>'\f241', 'fa-battery-half'=>'\f242', 'fa-battery-quarter'=>'\f243', 'fa-battery-empty'=>'\f244', 'fa-mouse-pointer'=>'\f245', 'fa-i-cursor'=>'\f246', 'fa-object-group'=>'\f247', 'fa-object-ungroup'=>'\f248', 'fa-sticky-note'=>'\f249', 'fa-sticky-note-o'=>'\f24a', 'fa-cc-jcb'=>'\f24b', 'fa-cc-diners-club'=>'\f24c', 'fa-clone'=>'\f24d', 'fa-balance-scale'=>'\f24e', 'fa-hourglass-o'=>'\f250', 'fa-hourglass-start'=>'\f251', 'fa-hourglass-half'=>'\f252', 'fa-hourglass-end'=>'\f253', 'fa-hourglass'=>'\f254', 'fa-hand-rock-o'=>'\f255', 'fa-hand-paper-o'=>'\f256', 'fa-hand-scissors-o'=>'\f257', 'fa-hand-lizard-o'=>'\f258', 'fa-hand-spock-o'=>'\f259', 'fa-hand-pointer-o'=>'\f25a', 'fa-hand-peace-o'=>'\f25b', 'fa-trademark'=>'\f25c', 'fa-registered'=>'\f25d', 'fa-creative-commons'=>'\f25e', 'fa-gg'=>'\f260', 'fa-gg-circle'=>'\f261', 'fa-tripadvisor'=>'\f262', 'fa-odnoklassniki'=>'\f263', 'fa-odnoklassniki-square'=>'\f264', 'fa-get-pocket'=>'\f265', 'fa-wikipedia-w'=>'\f266', 'fa-safari'=>'\f267', 'fa-chrome'=>'\f268', 'fa-firefox'=>'\f269', 'fa-opera'=>'\f26a', 'fa-internet-explorer'=>'\f26b', 'fa-television'=>'\f26c', 'fa-contao'=>'\f26d', 'fa-500px'=>'\f26e', 'fa-amazon'=>'\f270', 'fa-calendar-plus-o'=>'\f271', 'fa-calendar-minus-o'=>'\f272', 'fa-calendar-times-o'=>'\f273', 'fa-calendar-check-o'=>'\f274', 'fa-industry'=>'\f275', 'fa-map-pin'=>'\f276', 'fa-map-signs'=>'\f277', 'fa-map-o'=>'\f278', 'fa-map'=>'\f279', 'fa-commenting'=>'\f27a', 'fa-commenting-o'=>'\f27b', 'fa-houzz'=>'\f27c', 'fa-vimeo'=>'\f27d', 'fa-black-tie'=>'\f27e', 'fa-fonticons'=>'\f280');
        return apply_filters('magee_shortcodes_icons', $icons);
    }

    public static function get_animation_type(){
        $animation_type = array('' => 'None',"bounce" => "bounce", "flash" => "flash", "pulse" => "pulse", "rubberBand" => "rubberBand", "shake" => "shake", "swing" => "swing", "tada" => "tada", "wobble" => "wobble", "bounceIn" => "bounceIn", "bounceInDown" => "bounceInDown", "bounceInLeft" => "bounceInLeft", "bounceInRight" => "bounceInRight", "bounceInUp" => "bounceInUp", "bounceOut" => "bounceOut", "bounceOutDown" => "bounceOutDown", "bounceOutLeft" => "bounceOutLeft", "bounceOutRight" => "bounceOutRight", "bounceOutUp" => "bounceOutUp", "fadeIn" => "fadeIn", "fadeInDown" => "fadeInDown", "fadeInDownBig" => "fadeInDownBig", "fadeInLeft" => "fadeInLeft", "fadeInLeftBig" => "fadeInLeftBig", "fadeInRight" => "fadeInRight", "fadeInRightBig" => "fadeInRightBig", "fadeInUp" => "fadeInUp", "fadeInUpBig" => "fadeInUpBig", "fadeOut" => "fadeOut", "fadeOutDown" => "fadeOutDown", "fadeOutDownBig" => "fadeOutDownBig", "fadeOutLeft" => "fadeOutLeft", "fadeOutLeftBig" => "fadeOutLeftBig", "fadeOutRight" => "fadeOutRight", "fadeOutRightBig" => "fadeOutRightBig", "fadeOutUp" => "fadeOutUp", "fadeOutUpBig" => "fadeOutUpBig", "flip" => "flip", "flipInX" => "flipInX", "flipInY" => "flipInY", "flipOutX" => "flipOutX", "flipOutY" => "flipOutY", "lightSpeedIn" => "lightSpeedIn", "lightSpeedOut" => "lightSpeedOut", "rotateIn" => "rotateIn", "rotateInDownLeft" => "rotateInDownLeft", "rotateInDownRight" => "rotateInDownRight", "rotateInUpLeft" => "rotateInUpLeft", "rotateInUpRight" => "rotateInUpRight", "rotateOut" => "rotateOut", "rotateOutDownLeft" => "rotateOutDownLeft", "rotateOutDownRight" => "rotateOutDownRight", "rotateOutUpLeft" => "rotateOutUpLeft", "rotateOutUpRight" => "rotateOutUpRight", "hinge" => "hinge", "rollIn" => "rollIn", "rollOut" => "rollOut", "zoomIn" => "zoomIn", "zoomInDown" => "zoomInDown", "zoomInLeft" => "zoomInLeft", "zoomInRight" => "zoomInRight", "zoomInUp" => "zoomInUp", "zoomOut" => "zoomOut", "zoomOutDown" => "zoomOutDown", "zoomOutLeft" => "zoomOutLeft", "zoomOutRight" => "zoomOutRight", "zoomOutUp" => "zoomOutUp", "slideInDown" => "slideInDown", "slideInLeft" => "slideInLeft", "slideInRight" => "slideInRight", "slideInUp" => "slideInUp", "slideOutDown" => "slideOutDown", "slideOutLeft" => "slideOutLeft", "slideOutRight" => "slideOutRight", "slideOutUp" => "slideOutUp");
        return apply_filters('magee_shortcodes_animation_type', $animation_type);
    }

    public static function dec_numbers(){
        $dec_numbers = array( '0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1', '2' => '2', '2.5' => '2.5', '3' => '3' );
        return apply_filters('magee_shortcodes_dec_numbers', $dec_numbers);
    }

    public static function opacity(){
        $opacity = array('0' => '0', '0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1');
        return apply_filters('magee_shortcodes_opacity', $opacity);
    }

    public static function textalign(){
        $textalign = array( 'left' => __( 'Left', 'magee-shortcodes' ), 'center' => __( 'Center', 'magee-shortcodes' ), 'right' => __( 'Right', 'magee-shortcodes' ) );
        return apply_filters('magee_shortcodes_opacity', $textalign);
    }

    public static function choices(){
        $choices = array( 'yes' => __('Yes', 'magee-shortcodes' ), 'no' => __('No', 'magee-shortcodes')  );
        $reverse_choices = array( 'no' => __('No', 'magee-shortcodes'), 'yes' => __('Yes', 'magee-shortcodes' ) );
        return apply_filters('magee_shortcodes_choices', ['choices'=>$choices, 'reverse_choices'=>$reverse_choices]);
    }
    
    public static function shortcodes() {
        $icons = self::get_icons();
        $animation_type = self::get_animation_type();
        $dec_numbers = self::dec_numbers();
        $opacity = self::opacity();
        $textalign = self::textalign();
        $confirm = self::choices();
        $choices = $confirm['choices'];
        $reverse_choices = $confirm['reverse_choices'];
        $google_fonts = Helper::google_fonts();
        $magee_sliders = Helper::sliders_meta();
        $magee_portfolios_cats = Helper::shortcodes_categories('portfolio-category', true);

        /*-----------------------------------------------------------------------------------*/
        /*	Shortcode Selection Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['shortcode-generator'] = array(
            'no_preview' => true,
            'params' => array(),
            'shortcode' => '',
            'popup_title' => ''
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Accordion Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['accordion'] = array(
            'no_preview' => false,
            'icon' => 'fa-list-ul',
            'params' => array(
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),	
                'style' => array(
                    'type' => 'select',
                    'std' => 'simple',
                    'label' => __( 'Style', 'magee-shortcodes' ),
                    'desc' => __( 'The "simple" doesn\'t have a border in the whole accordion, and the "boxed" has.','magee-shortcodes'),
                    'options' => array(
                        'simple' => __( 'Simple Style', 'magee-shortcodes' ),
                        'boxed' => __( 'Boxed Style', 'magee-shortcodes' ),
                        'spacing' => __( 'Spacing Style', 'magee-shortcodes' ),
                    )
                ),
                'open_multiple' => array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __( 'Open Multiple', 'magee-shortcodes' ),
                    'desc' => __( 'Click to expand multiple tabs.', 'magee-shortcodes' ),
                    'options' => $reverse_choices 
                ),
                'icon' => array(
                    'type' => 'select',
                    'label' => __( 'Status Icon', 'magee-shortcodes' ),
                    'desc' => __( 'The differance is in the right of accordion, "1" is a down arrow, and the "2" is a plus in a box','magee-shortcodes'),
                    'std' => '1',
                    'options' => array(
                        'arrow' => __( 'Arrow', 'magee-shortcodes' ),
                        'plus' => __( 'Plus', 'magee-shortcodes' ),
                        'none' => __( 'None', 'magee-shortcodes' ),
                    )
                ),
                'color' => array(
                    'std' => '#333333',
                    'type' => 'colorpicker',
                    'label' => __( 'Title Color', 'magee-shortcodes'),
                    'desc' => __( 'Insert the color for the title.', 'magee-shortcodes'),
                ),	
                'background_color' => array(
                    'std' => '#ffffff',
                    'type' => 'colorpicker',
                    'label' => __( 'Title Background Color', 'magee-shortcodes'),
                    'desc' => __( 'Insert the background color for the title.', 'magee-shortcodes'),
                ),
                
            ),
            'child_shortcode' => array(
                'params' => array(
                                
                    'title' => array(
                        'std' => 'Accordion Title',
                        'type' => 'text',
                        'label' => __( 'Title', 'magee-shortcodes'),
                        'desc' => __( 'Insert the title for the accordion item.', 'magee-shortcodes'),
                    ),	
                    
                    'content' => array(
                        'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                        'type' => 'textarea',
                        'label' => __( 'Text', 'magee-shortcodes'),
                        'desc' => __( 'Insert the content for the accordion item.', 'magee-shortcodes'),
                    ),	
                    'status' => array(
                        'std' => 'close',
                        'type' => 'select',
                        'label' => __( 'Status', 'magee-shortcodes'),
                        'desc' =>  __( 'Choose to have the accordion open or close when page loads.', 'magee-shortcodes'),
                        'options' => array("close"=>__('Close','magee-shortcodes'),"open"=>__('Open','magee-shortcodes') )
                    ),
                    
                )
                ,
            'shortcode' => "[ms_accordion_item title=\"{{title}}\" status=\"{{status}}\"]{{content}}[/ms_accordion_item]\r\n",	
                ),	
            'shortcode' => "[ms_accordion style=\"{{style}}\" open_multiple=\"{{open_multiple}}\" color=\"{{color}}\" background_color=\"{{background_color}}\" icon=\"{{icon}}\" class=\"{{class}}\" id=\"{{id}}\"]\r\n{{child_shortcode}}[/ms_accordion]",
            'popup_title' => __( 'Accordion Shortcode', 'magee-shortcodes' ),
            'name' => __('accordions-shortcode/','magee-shortcodes'),

        );


        /*-----------------------------------------------------------------------------------*/
        /*	Alert Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['alert'] = array(
            'no_preview' => false,
            'icon' => 'fa-exclamation-circle',
            'params' => array(
                'icon' => array(
                    'std' => 'fa-exclamation-circle',
                    'type' => 'iconpicker',
                    'label' => __( 'Icon', 'magee-shortcodes' ),
                    'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                    'options' => $icons
                    ),
                
                'content' => array(
                    'std' => __('Warning! Better check yourself, you\'re not looking too good.', 'magee-shortcodes'),
                    'type' => 'textarea',
                    'label' => __( 'Alert Content', 'magee-shortcodes' ),
                    'desc' => __( 'Insert the content for the alert.', 'magee-shortcodes' ),
                ),
                
                'background_color' => array(
                    'std' => '#ffcc00',
                    'type' => 'colorpicker',
                    'label' => __( 'Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background color for alert box.', 'magee-shortcodes' ),
                ),
                'text_color' => array(
                    'std' => '',
                    'type' => 'colorpicker',
                    'label' => __( 'Text Color', 'magee-shortcodes' ),
                    'desc' =>__( 'Set content color & border color for alert box.', 'magee-shortcodes' ),
                ),
            
                
                'border_width' => array(
                    'std' => '0',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Border Width', 'magee-shortcodes' ),
                    'desc' => __('In pixels (px), eg: 1px.', 'magee-shortcodes')
                ),
                
                'border_radius' => array(
                    'std' => '0',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Border Radius', 'magee-shortcodes' ),
                    'desc' => __('In pixels (px), eg: 1px.', 'magee-shortcodes')
                ),
                
                'box_shadow' => array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __( 'Box Shadow', 'magee-shortcodes' ),
                    'desc' => __( 'Display a box shadow for alert.', 'magee-shortcodes' ),
                    'options' => $reverse_choices
                ),	
                'dismissable' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __( 'Dismissable', 'magee-shortcodes' ),
                    'desc' => __( 'The alert box is dismissable.', 'magee-shortcodes' ),
                    'options' =>  $reverse_choices
                ),	
                
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),		
            ),
            'shortcode' => '[ms_alert icon="{{icon}}" background_color="{{background_color}}"  text_color="{{text_color}}"  border_width="{{border_width}}"  border_radius="{{border_radius}}" box_shadow="{{box_shadow}}" dismissable="{{dismissable}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_alert]',
            'popup_title' => __( 'Alert Shortcode', 'magee-shortcodes' ),
            'name' => __('alert-shortcode/','magee-shortcodes'),
        );
        /*-----------------------------------------------------------------------------------*/
        /*	Animation Config
        /*-----------------------------------------------------------------------------------*/
        $magee_shortcodes['animation'] = array(
            'no_preview' => false,
            'icon' => 'fa-bolt', 
            'params' => array(
                'animation_speed' => array(
                    'type' => 'select',
                    'label' => __( 'Animation Speed', 'magee-shortcodes'),
                    'desc' => __( 'Type in speed of animation in seconds.', 'magee-shortcodes'),
                    'std'=>'0.9',
                    'options' => $dec_numbers
                ),
                'animation_type' => array(
                    'type' => 'select',
                    'label' => __( 'Animation Type', 'magee-shortcodes'),
                    'desc' =>  __( 'Select the type of animation.', 'magee-shortcodes'),
                    'options' => $animation_type
                ),
                'image_animation' => array(
                    'type' => 'choose',
                    'label' => __( 'Image Animation', 'magee-shortcodes'),
                    'desc' => __('Only images from content to be animated.','magee-shortcodes'),
                    'options' => $reverse_choices
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),	
                'content' => array(
                    'std' => __('Your Content Goes Here', 'magee-shortcodes'),
                    'type' => 'textarea',
                    'label' => __( 'Animation Content', 'magee-shortcodes'),
                    'desc' => __( 'Insert the content to be animated.', 'magee-shortcodes'),
                ),
                
            ),
            'shortcode' => '[ms_animation animation_speed="{{animation_speed}}" animation_type="{{animation_type}}"  image_animation="{{image_animation}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_animation]',
            'popup_title' => __( 'Animation Shortcode', 'magee-shortcodes')
        );	

        /*-----------------------------------------------------------------------------------*/
        /*	Audio Config
        /*-----------------------------------------------------------------------------------*/
        $magee_shortcodes['audio'] = array(
            'no_preview' => false,
            'icon' => 'fa-play-circle-o',
            'params' => array(
                'style' => array(
                    'std' => '',
                    'type' => 'select',
                    'label' => __( 'Audio Style', 'magee-shortcodes'),
                    'desc' => __( 'Choose style for audio to show', 'magee-shortcodes'),
                    'options' => array('dark'=>__('Dark Style', 'magee-shortcodes'),'light'=>__('Light Style', 'magee-shortcodes'))
                ),
                'mp3' => array(
                    'std' => '',
                    'type' => 'link',
                    'label' => __( 'Mp3 URL', 'magee-shortcodes'),
                    'desc' => __( 'Add the URL of audio in MP3 format.', 'magee-shortcodes')
                ),
                'ogg' => array(
                    'std' => '',
                    'type' => 'link',
                    'label' => __( 'Ogg URL', 'magee-shortcodes'),
                    'desc' => __( 'Add the URL of audio in OGG format.', 'magee-shortcodes')
                ),
                'wav' => array(
                    'std' => '',
                    'type' => 'link',
                    'label' => __( 'Wav URL', 'magee-shortcodes'),
                    'desc' => __( 'Add the URL of audio in WAV format.', 'magee-shortcodes')
                ),
                'mute' => array(
                    'type' => 'choose',
                    'label' => __( 'Mute Audio','magee-shortcodes'),
                    'desc' => __('Choose to mute the audio.','magee-shortcodes'), 
                    'options' =>  $reverse_choices,
                ),
                'loop' => array(
                    'type' => 'choose',
                    'label' => __( 'Loop Audio','magee-shortcodes'),
                    'desc' => __('Choose to loop the audio.','magee-shortcodes'), 
                    'options' =>  $choices,
                ),
                'controls' => array(
                    'type' => 'choose',
                    'label' => __( 'Controls Audio','magee-shortcodes'),
                    'desc' => __('Choose to display controls of the audio.','magee-shortcodes'), 
                    'options' =>  $choices,
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),   
            'shortcode' => '[ms_audio style="{{style}}" mp3="{{mp3}}" ogg="{{ogg}}" wav="{{wav}}" mute="{{mute}}" loop="{{loop}}" controls="{{controls}}" class="{{class}}" id="{{id}}"]' ,
            'popup_title' => __( 'Audio Shortcode','magee-shortcodes'),
            'name' => __('audio-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Blog Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['blog'] = array(
            'no_preview' => false,
            'icon' => 'fa-pencil-square-o',
            'params' => array(
                            
            'style' => array(
                    'type' => 'select',
                    'label' => __( 'List Style', 'magee-shortcodes'),
                    'desc' => __( 'Style1: Image above content. Style2: Image beside content.', 'magee-shortcodes'),
                    'options' => array( '1' => __( 'Style 1', 'magee-shortcodes' ), '2' => __( 'Style 2', 'magee-shortcodes' ), '3' => __( 'Style 3', 'magee-shortcodes' ), '4' => __( 'Style 4 ( Timeline )', 'magee-shortcodes' ) )
                ),

            'num' => array(
                    'type' => 'number',
                    'label' => __( 'List Num', 'magee-shortcodes'),
                    'desc' => __( 'Number of posts displayed.', 'magee-shortcodes'),
                    "std"=>'10',
                    'max' => '100',
                    'min' => '0',
                ),
            'column' => array(
                    'type' => 'select',
                    'label' => __( 'Column', 'magee-shortcodes'),
                    'desc' => __( 'Choose column number for blog list.', 'magee-shortcodes'),
                    'std' => '3',
                    'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' )
                ),
            
            'category' => array(
                    'type' => 'select',
                    'label' => __( 'Category', 'magee-shortcodes'),
                    'desc' => __( 'Choose a category of blog posts to display.', 'magee-shortcodes'),
                    'options' => Helper::shortcodes_categories('category',true),
                ),
            'page_nav' => array(
                    'type' => 'choose',
                    'label' => __( 'Display Page Navigation', 'magee-shortcodes'),
                    'desc' => __( 'Choose to show page navigation for blog list.', 'magee-shortcodes'),
                    'std' => 'no',
                    'options' => $choices
                ),
                'offset' => array(
                    'std' => '0',
                    'min' => '0',
                    'max' => '50',
                    'type' => 'number',
                    'label' => __( 'Post Offset','magee-shortcodes'),
                    'desc' => __( 'The number of posts to skip. ex: 1.','magee-shortcodes')
                ),
                'exclude_category' => array(
                    'std' => '',
                    'type' => 'select',
                    'label' => __( 'Exclude Categories','magee-shortcodes'),
                    'desc' => __( 'Select a category to exclude.','magee-shortcodes'),
                    'options' => Helper::shortcodes_categories('category',true),
                ),
                'display_title' => array(
                    'type' => 'choose',
                    'label' => __( 'Display Title','magee-shortcodes'),
                    'desc' => __( 'Choose to display the post title.','magee-shortcodes'),
                    'options' => $choices
                ),
                'display_image' => array(
                    'type' => 'choose',
                    'label' => __( 'Display Feature Image','magee-shortcodes'),
                    'desc' => __( 'Choose to show feature image.','magee-shortcodes'),
                    'options' => $choices
                ),
                'display_meta' => array(
                    'type' => 'choose',
                    'label' => __( 'Display Meta','magee-shortcodes'),
                    'desc' => __( 'Choose to show all meta data.','magee-shortcodes'),
                    'options' => $choices
                ),
                'display_excerpt' => array(
                    'type' => 'choose',
                    'label' => __( 'Display Excerpt','magee-shortcodes'),
                    'desc' => __( 'Choose to display the post excerpt.','magee-shortcodes'),
                    'options' => $choices
                ),
                'excerpt_length' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Excerpt Length','magee-shortcodes'),
                    'desc' => __( 'Insert the number of words/characters you want to show in the excerpt.','magee-shortcodes')
                ),
                'strip' => array(
                    'type' => 'choose',
                    'label' => __( 'Strip HTML','magee-shortcodes'),
                    'desc' => __( 'Strip HTML from the post excerpt.','magee-shortcodes'),
                    'options' => $choices
                ),
                
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_blog num="{{num}}"  style="{{style}}" column="{{column}}" category="{{category}}" page_nav="{{page_nav}}"  class="{{class}}" id="{{id}}" offset="{{offset}}" exclude_category="{{exclude_category}}" display_title="{{display_title}}" display_meta="{{display_meta}}" display_excerpt="{{display_excerpt}}" excerpt_length="{{excerpt_length}}" strip="{{strip}}"]',
            'popup_title' => __( 'Blog Shortcode', 'magee-shortcodes')
        );

        /*******************************************************
         *	Button Config
        ********************************************************/

        $magee_shortcodes['button'] = array(
            'no_preview' => false,
            'icon' => 'fa-hand-o-up',
            'params' => array(
                'style' => array(
                    'type' => 'select',
                    'label' => __( 'Button Style', 'magee-shortcodes' ),
                    'desc' => __( 'Select the button\'s default style.', 'magee-shortcodes' ),
                    'options' => array(
                        'normal' => __('Normal', 'magee-shortcodes'),
                        'dark' => __('Dark', 'magee-shortcodes'),
                        'light' => __('Light', 'magee-shortcodes'),
                        '2d' => __('2d', 'magee-shortcodes'),
                        '3d' => __('3d', 'magee-shortcodes'),
                        'line' => __('Line', 'magee-shortcodes'),
                        'line_dark' => __('Line Dark', 'magee-shortcodes'),
                        'line_light' => __('Line Light', 'magee-shortcodes'),
                        
                    )
                ),
                'link' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Button URL', 'magee-shortcodes' ),
                    'desc' => __( 'Add the button\'s url eg: http://example.com.', 'magee-shortcodes' )
                ),
                'size' => array(
                    'type' => 'select',
                    'std' =>'medium',
                    'label' => __( 'Button Size', 'magee-shortcodes' ),
                    'desc' => __( 'Select the button\'s size.', 'magee-shortcodes' ),
                    'options' => array(
                        'small' => __('Small', 'magee-shortcodes'),
                        'medium' => __('Medium', 'magee-shortcodes'),
                        'large' => __('Large', 'magee-shortcodes'),
                        'xlarge' => __('XLarge', 'magee-shortcodes'),
                    )
                ),
                
                'border_width' => array(
                    'std' => '0',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __('Border Width', 'magee-shortcodes'),
                    'desc' => __('In pixels (px), default: 2px.', 'magee-shortcodes'),
                ),
            
                'shape' => array(
                    'type' => 'select',
                    'label' => __( 'Button Shape', 'magee-shortcodes' ),
                    'desc' => __( 'Select the button\'s shape. Choose default for theme option selection.', 'magee-shortcodes' ),
                    'options' => array(
                        '' => __('Default', 'magee-shortcodes'),
                        'square' => __('Square', 'magee-shortcodes'),
                        'rounded' => __('Rounded', 'magee-shortcodes'),
                        'full-rounded' => __('Full Rounded', 'magee-shortcodes'),
                    )
                ),
                'shadow' => array(
                    'type' => 'choose',
                    'label' => __( 'Text Shadow', 'magee-shortcodes' ),
                    'desc' => __( 'Display shadow for button text.', 'magee-shortcodes' ),
                    'options' => $reverse_choices
                ),
                'gradient' => array(
                    'type' => 'choose',
                    'label' => __( 'Gradient', 'magee-shortcodes' ),
                    'desc' => __( 'Display gradient for button.', 'magee-shortcodes' ),
                    'options' => $reverse_choices
                ),
                'block' => array(
                    'type' => 'choose',
                    'label' => __( 'Block Button', 'magee-shortcodes' ),
                    'desc' => __( 'Display in full width.', 'magee-shortcodes' ),
                    'options' => $reverse_choices
                ),
                
                'target' => array(
                    'std' => '_blank',
                    'type' => 'choose',
                    'label' => __( 'Button Target', 'magee-shortcodes' ),
                    'desc' => __( '_self = open in same window <br />_blank = open in new window.', 'magee-shortcodes' ),
                    'options' => array(
                        '_self' => '_self',
                        '_blank' => '_blank'
                    )
                ),
            
                'content' => array(
                    'std' => __('Button Text', 'magee-shortcodes'),
                    'type' => 'text',
                    'label' => __( 'Button\'s Text', 'magee-shortcodes' ),
                    'desc' => __( 'Add the text that will display in the button.', 'magee-shortcodes' ),
                ),
                
                'color' => array(
                    'type' => 'colorpicker',
                    'desc' => __( 'Set background color for button.', 'magee-shortcodes' ),
                    'label' => __( 'Button Color', 'magee-shortcodes' ),
                    'std' => ''
                ),
                
                'textcolor' => array(
                    'type' => 'colorpicker',
                    'std' => '#ffffff',
                    'label' => __( 'Text Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set content color & border color for button.', 'magee-shortcodes' )
                ),
                
                'icon' => array(
                    'type' => 'iconpicker',
                    'label' => __( 'Button Icon', 'magee-shortcodes' ),
                    'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                    'options' => $icons
                ),
                
                'iconanimationtype' => array(
                    'type' => 'select',
                    'label' => __( 'Icon Animation Type', 'magee-shortcodes' ),
                    'desc' => __( 'Select the type of animation to use on the button icon.', 'magee-shortcodes' ),
                    'options' => $animation_type
                ),
                
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),			
            ),
            'shortcode' => '[ms_button style="{{style}}" link="{{link}}" size="{{size}}" shape="{{shape}}" shadow="{{shadow}}" block="{{block}}" target="{{target}}" gradient="{{gradient}}" color="{{color}}"  text_color="{{textcolor}}" icon="{{icon}}" icon_animation_type="{{iconanimationtype}}" border_width="{{border_width}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_button]',
            'popup_title' => __( 'Button Shortcode', 'magee-shortcodes'),
            'name' => __('buttons-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Carousel Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['carousel'] = array(
            'no_preview' => false,
            'icon' => 'fa-picture-o',
            'params' => array(
                'style' => array(
                        'type' => 'select',
                        'std' => '1',
                        'label' => __( 'Style', 'magee-shortcodes'),
                        'desc' => __( 'Select the display style of carousel navigation.', 'magee-shortcodes'),
                        'options' =>array(		
                            '1' => __( 'Style 1', 'magee-shortcodes'),
                            '2' => __( 'Style 2', 'magee-shortcodes'),
                            '3' => __( 'Style 3', 'magee-shortcodes'),
                        ),
                    ),
                'columns' => array(
                        'type' => 'select',
                        'std' => '4',
                        'label' => __( 'Columns', 'magee-shortcodes'),
                        'desc' => __( 'Choose column number for carousel.', 'magee-shortcodes'),
                        'options' =>array(		
                            '1' => __( '1 Column', 'magee-shortcodes'),
                            '2' => __( '2 Columns', 'magee-shortcodes'),
                            '3' => __( '3 Columns', 'magee-shortcodes'),
                            '4' => __( '4 Columns', 'magee-shortcodes'),
                            '5' => __( '5 Columns', 'magee-shortcodes'),
                            '6' => __( '6 Columns', 'magee-shortcodes'),
                            '7' => __( '7 Columns', 'magee-shortcodes'),
                            '8' => __( '8 Columns', 'magee-shortcodes'),
                        ),
                    ),
                'autoplay' => array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __( 'Autoplay', 'magee-shortcodes'),
                    'desc' => __( 'Choose to autoplay the carousel.', 'magee-shortcodes'),
                    'options' => $reverse_choices 
                ),	
                
                'autoplaytimeout' => array(
                    'std' => '5000',
                    'type' => 'text',
                    'label' => __( 'Autoplay Timeout', 'magee-shortcodes'),
                    'desc' => __( 'Set timeout for autoplay.', 'magee-shortcodes'),
                ),
                'display_nav' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __( 'Display Navigation', 'magee-shortcodes'),
                    'desc' =>  __( 'Choose to display navigation for carousel', 'magee-shortcodes'),
                    'options' => $choices 
                ),	
                'pag_style' => array(
                    'std' => 'style1',
                    'type' => 'select',
                    'label' => __( 'Pagination Style', 'magee-shortcodes'),
                    'desc' =>  __( 'Choose pagination style for carousel', 'magee-shortcodes'),
                    'options' => array(
                        '' =>  __( 'None', 'magee-shortcodes'),
                        'style1' =>  __( 'Style 1', 'magee-shortcodes'),
                        'style2' =>  __( 'Style 2', 'magee-shortcodes'),
                        'style3' =>  __( 'Style 3', 'magee-shortcodes'),
                        'style4' =>  __( 'Style 4', 'magee-shortcodes'),
                    ),
                ),	
                'nav_color' => array(
                    'std' => '',
                    'type' => 'colorpicker',
                    'label' => __( 'Nav Color', 'magee-shortcodes'),
                    'desc' => __( 'Set color for carousel navigation.', 'magee-shortcodes'),
                ),
                'nav_shape' => array(
                        'type' => 'select',
                        'std' => 'square',
                        'label' => __( 'Navigation Shape', 'magee-shortcodes'),
                        'desc' => __( 'Set shape for carousel navigation.', 'magee-shortcodes'),
                        'options' =>array(		
                            'square' => __( 'Square', 'magee-shortcodes'),
                            'rounded' => __( 'Rounded', 'magee-shortcodes'),
                            'circle' => __( 'Circle', 'magee-shortcodes'),
                        ),
                    ),
                'nav_size' => array(
                        'type' => 'select',
                        'std' => 'small',
                        'label' => __( 'Navigation Size', 'magee-shortcodes'),
                        'desc' => __( 'Set size for carousel navigation.', 'magee-shortcodes'),
                        'options' =>array(		
                            'small' => __( 'Small', 'magee-shortcodes'),
                            'middle' => __( 'Middle', 'magee-shortcodes'),
                            'large' => __( 'Large', 'magee-shortcodes'),
                        ),
                    ),
                
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
                        
            ),
            'shortcode' => "[ms_carousel style=\"{{style}}\" columns=\"{{columns}}\" display_nav=\"{{display_nav}}\" pag_style=\"{{pag_style}}\" autoplay=\"{{autoplay}}\" autoplaytimeout=\"{{autoplaytimeout}}\"  nav_color=\"{{nav_color}}\" nav_shape=\"{{nav_shape}}\" nav_size=\"{{nav_size}}\" class=\"{{class}}\" id=\"{{id}}\"]\r\n{{child_shortcode}}[/ms_carousel]",
            'popup_title' => __( 'Carousel Shortcode', 'magee-shortcodes'),
            'child_shortcode' => array(
                'params' => array(
                    'content' => array(
                        'std' => __('Carousel Item Content', 'magee-shortcodes'),
                        'type' => 'textarea',
                        'label' => __( 'Carousel Item Content', 'magee-shortcodes'),
                        'desc' => '',
                    )
                ),	
                
            'shortcode' => "[ms_carousel_item]{{content}}[/ms_carousel_item]\r\n",
                ),
            'name' => __('carousel-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Chart Bar Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['chart_bar'] = array(
            'no_preview' => false,
            'icon' => 'fa-bar-chart',
            'params' => array(
                'width' => array(
                    'std' => '600',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0', 
                    'label' => __( 'Canvas Width','magee-shortcodes'),
                    'desc' => '',
                ),
                'height' => array(
                    'std' => '400',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0', 
                    'label' => __( 'Canvas Height','magee-shortcodes'),
                    'desc' => '',
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'label' => array(
                    'std' => "'January','February','March','April','May','June'",
                    'type' => 'text',
                    'label' => __('Label For Line','magee-shortcodes') ,
                    'desc' => __( 'separate multiple tags added to chart line with commas','magee-shortcodes')
                ),  
            ),
            'shortcode' => "[ms_chart_bar width=\"{{width}}\" height=\"{{height}}\" class=\"{{class}}\" id=\"{{id}}\" label=\"{{label}}\"]\r\n{{child_shortcode}}[/ms_chart_bar]",	
            'popup_title' => __( 'Chart Bar Shortcode', 'magee-shortcodes'),
            'child_shortcode' => array(
                'params' => array(		

                    'title' => array(
                        'std' => '#Data 1',
                        'type' => 'text',
                        'label' => __( 'Title','magee-shortcodes'),
                        'desc' => __( 'Title of chart bar','magee-shortcodes')
                    ),
                    'data' => array(
                        'std' => '456,479,324,569,702,600',
                        'type' => 'text',
                        'label' => __( 'Data','magee-shortcodes'),
                        'desc' => __( 'separate values for each set of data with commas','magee-shortcodes')
                    ),
                    'fillcolor' => array(
                        'std' => '#ACC284',  
                        'type' => 'colorpicker',
                        'label' => __( 'Fill Color','magee-shortcodes'), 
                        'desc' => '', 
                    ),
                    'fillopacity' => array(
                        'std' => '0.4',
                        'type' => 'select',
                        'label' => __( 'Fill Opacity','magee-shortcodes') ,
                        'desc' => '',
                        'options' => $opacity 
                    ),
                    'strokecolor' => array(
                        'std' => '#ACC26D',  
                        'type' => 'colorpicker',
                        'label' => __( 'Border Color','magee-shortcodes'), 
                        'desc' => '', 
                    ),
                    'strokeopacity' => array(
                        'std' => '0.4',
                        'type' => 'select',
                        'label' => __( 'Border Opacity','magee-shortcodes') ,
                        'desc' => '',
                        'options' => $opacity 
                    ),
                ),
                'shortcode' => "[ms_bar data=\"{{data}}\" title=\"{{title}}\" fillcolor=\"{{fillcolor}}\" fillopacity=\"{{fillopacity}}\" strokecolor=\"{{strokecolor}}\" strokeopacity=\"{{strokeopacity}}\"][/ms_bar]\r\n",	
            )
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Chart Doughnut Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['chart_doughnut'] = array(
            'no_preview' => false,
            'icon' => 'fa-circle-o-notch',
            'params' => array(
                'width' => array(
                    'std' => '600',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0', 
                    'label' => __( 'Canvas Width','magee-shortcodes'),
                    'desc' => '',
                ),
                'height' => array(
                    'std' => '400',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0', 
                    'label' => __( 'Canvas Height','magee-shortcodes'),
                    'desc' => '',
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'content' => array(  
                    'std' => "[ms_doughnut label=\"#Label 1\" value=\"20\" color=\"#878BB6\"]\r\n[ms_doughnut label=\"#Label 2\" value=\"40\" color=\"#4ACAB4\"]\r\n[ms_doughnut label=\"#Label 3\" value=\"10\" color=\"#FF8153\"]\r\n[ms_doughnut label=\"#Label 4\" value=\"30\" color=\"#FFEA88\"]\r\n",
                    'type' => 'textarea',
                    'label' => __( 'Content', 'magee-shortcodes'),
                    'desc' => '', 
                ),
            ),
            'shortcode' => "[ms_chart_doughnut width=\"{{width}}\" height=\"{{height}}\" class=\"{{class}}\" id=\"{{id}}\"]\r\n{{content}}[/ms_chart_doughnut]",	
            'popup_title' => __( 'Chart Doughnut Shortcode', 'magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Chart Line Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['chart_line'] = array(
            'no_preview' => false,
            'icon' => 'fa-line-chart',
            'params' => array(
                'width' => array(
                    'std' => '600',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0', 
                    'label' => __( 'Canvas Width','magee-shortcodes'),
                    'desc' => '',
                ),
                'height' => array(
                    'std' => '400',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0', 
                    'label' => __( 'Canvas Height','magee-shortcodes'),
                    'desc' => '',
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'label' => array(
                    'std' => "'January','February','March','April','May','June'",
                    'type' => 'text',
                    'label' => __('Label For Line','magee-shortcodes') ,
                    'desc' => ''
                ),  
            ),
            'shortcode' => "[ms_chart_line width=\"{{width}}\" height=\"{{height}}\" class=\"{{class}}\" id=\"{{id}}\" label=\"{{label}}\"]\r\n{{child_shortcode}}[/ms_chart_line]",	
            'popup_title' => __( 'Chart Line Shortcode', 'magee-shortcodes'),
            'child_shortcode' => array(
                'params' => array(		
                    'title' => array(
                        'std' => '#Data 1',
                        'type' => 'text',
                        'label' => __( 'Title','magee-shortcodes'),
                        'desc' => __( 'Title of chart bar','magee-shortcodes')
                    ),
                    'data' => array(
                        'std' => '203,156,99,251,305,247',
                        'type' => 'text',
                        'label' => __( 'Data','magee-shortcodes'),
                        'desc' => __( 'separate values for each set of data with commas','magee-shortcodes')
                    ),
                    'fillcolor' => array(
                        'std' => '#ACC284',  
                        'type' => 'colorpicker',
                        'label' => __( 'Fill Color','magee-shortcodes'), 
                        'desc' => '', 
                    ),
                    'fillopacity' => array(
                        'std' => '0.4',
                        'type' => 'select',
                        'label' => __( 'Fill Opacity','magee-shortcodes') ,
                        'desc' => '',
                        'options' => $opacity 
                    ),
                    'strokecolor' => array(
                        'std' => '#ACC26D',  
                        'type' => 'colorpicker',
                        'label' => __( 'Line Color','magee-shortcodes'), 
                        'desc' => '', 
                    ),
                    'pointcolor' => array(
                        'std' => '#ffffff',  
                        'type' => 'colorpicker',
                        'label' => __( 'Point Background Color','magee-shortcodes'), 
                        'desc' => '', 
                    ),
                    'pointstrokecolor' => array(
                        'std' => '#9DB86D',  
                        'type' => 'colorpicker',
                        'label' => __( 'Point Border Color','magee-shortcodes'), 
                        'desc' => '', 
                    ),
                    'pointhoverbackgroundcolor' => array(
                        'std' => '#1e73be',  
                        'type' => 'colorpicker',
                        'label' => __( 'Point Hover Background Color','magee-shortcodes'), 
                        'desc' => '', 
                    ),
                    'pointborderwidth' => array(
                        'std' => '1',
                        'type' => 'number',
                        'max' => '10',
                        'min' => '1', 
                        'label' => __( 'Point Border Width','magee-shortcodes'),
                        'desc' => '',
                    ),
                ),
                'shortcode' => "[ms_line title=\"{{title}}\" data=\"{{data}}\" fillcolor=\"{{fillcolor}}\" fillopacity=\"{{fillopacity}}\" strokecolor=\"{{strokecolor}}\" pointcolor=\"{{pointcolor}}\" pointstrokecolor=\"{{pointstrokecolor}}\" pointhoverbackgroundcolor=\"{{pointhoverbackgroundcolor}}\" pointborderwidth=\"{{pointborderwidth}}\"][/ms_line]\r\n",	
            )
        );
            
        /*-----------------------------------------------------------------------------------*/
        /*	Chart Pie Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['chart_pie'] = array(
            'no_preview' => false,
            'icon' => 'fa-pie-chart',
            'params' => array(
                'width' => array(
                    'std' => '600',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0', 
                    'label' => __( 'Canvas Width','magee-shortcodes'),
                    'desc' => ''
                ),
                'height' => array(
                    'std' => '400',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0', 
                    'label' => __( 'Canvas Height','magee-shortcodes'),
                    'desc' => ''
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'content' => array(  
                    'std' => "[ms_pie label=\"#Label 1\" value=\"20\" color=\"#878BB6\"]\r\n[ms_pie label=\"#Label 2\" value=\"40\" color=\"#4ACAB4\"]\r\n[ms_pie label=\"#Label 3\" value=\"10\" color=\"#FF8153\"]\r\n[ms_pie label=\"#Label 4\" value=\"30\" color=\"#FFEA88\"]\r\n",
                    'type' => 'textarea',
                    'label' => __( 'Content', 'magee-shortcodes'),
                    'desc' => '', 
                ),
            ),
            'shortcode' => "[ms_chart_pie width=\"{{width}}\" height=\"{{height}}\" class=\"{{class}}\" id=\"{{id}}\"]\r\n{{content}}[/ms_chart_pie]",	
            'popup_title' => __( 'Chart Pie Shortcode', 'magee-shortcodes')
        );
            
        /*******************************************************
         *	Columns Config
        ********************************************************/

        $magee_shortcodes['column'] = array(
            'no_preview' => false,
            'icon' => 'fa-columns',
            'params' => array(
            
            ),
            'shortcode' => "[ms_row]\r\n{{child_shortcode}}[/ms_row]",	
            'popup_title' => __( 'Column Shortcode', 'magee-shortcodes'),	
            'name' => __('columns-shortcode/','magee-shortcodes'),
            'child_shortcode' => array(
            'params' => array(				  
                'style' => array(
                    'type' => 'select',
                    'label' => __( 'Column Style', 'magee-shortcodes'),
                    'desc' => __( 'Select the size of column.', 'magee-shortcodes'),
                    'options' => array(
                        '1/1' => __('1/1', 'magee-shortcodes'),
                        '1/2' => __('1/2', 'magee-shortcodes'),
                        '1/3' => __('1/3', 'magee-shortcodes'),
                        '1/4' => __('1/4', 'magee-shortcodes'),
                        '1/5' => __('1/5', 'magee-shortcodes'),
                        '1/6' => __('1/6', 'magee-shortcodes'),
                        '2/3' => __('2/3', 'magee-shortcodes'),
                        '2/5' => __('2/5', 'magee-shortcodes'),
                        '3/4' => __('3/4', 'magee-shortcodes'),
                        '3/5' => __('3/5', 'magee-shortcodes'),
                        '4/5' => __('4/5', 'magee-shortcodes'),
                        '5/6' => __('5/6', 'magee-shortcodes'),
                    )
                ),
            
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    'type' => 'textarea',
                    'label' => __( ' Column Content', 'magee-shortcodes'),
                    'desc' => __( 'Insert the column\'s content', 'magee-shortcodes'),
                ),	
                'align' => array(
                    'std' => __('left', 'magee-shortcodes'),
                    'type' => 'select',
                    'label' => __( 'Content Align', 'magee-shortcodes'),
                    'desc' => '',
                    'options' => array(
                        'left' => __( 'Left', 'magee-shortcodes'),
                        'center' => __( 'Center', 'magee-shortcodes'),
                        'right' => __( 'Right', 'magee-shortcodes'),
                    ),
                ),		
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),	
            'shortcode' =>"[ms_column style=\"{{style}}\" align=\"{{align}}\" class=\"{{class}}\" id=\"{{id}}\"]{{content}}[/ms_column]\r\n",
            )
            
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Contact Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['contact'] = array(
            'no_preview' => false,
            'icon' => 'fa-envelope',
            'params' => array(
                
                
            'receiver' => array(
                    'type' => 'text',
                    'label' => __( 'Receiver Email', 'magee-shortcodes'),
                    'desc' =>  __( 'Set receiver email address for contact form.', 'magee-shortcodes'),
                    "std"=> get_option( 'admin_email' )
                    
                ),
            
            'style' => array(
                    'type' => 'select',
                    'label' => __( 'Style', 'magee-shortcodes'),
                    'desc' => __( 'Choose style for contact form.', 'magee-shortcodes'),
                    'options' => array( 
                                    'normal' => __( 'Normal Style', 'magee-shortcodes'),
                                    'classic' =>  __( 'Classic Style', 'magee-shortcodes'),
                                    'outline' => __( 'Outline Style', 'magee-shortcodes'),
                                    'background' => __( 'Background Style', 'magee-shortcodes')
                                    )
                ),

            'color' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Button / Border Color', 'magee-shortcodes'),
                    'desc' => __( 'Set main color for contact form.', 'magee-shortcodes'),
                    'std' => '#37cadd'
                ),
            'terms' =>array(
                    'type' => 'choose',
                    'label' => __( 'Display Terms Check Box', 'magee-shortcodes'),
                    'desc' => __( 'Choose to display terms check box.', 'magee-shortcodes'),
                    'std' => 'yes',
                    'options' => array( 'yes' => __('Yes','magee-shortcodes'), 'no' => __('No' ,'magee-shortcodes') )
                ),
            'content' => array(
                    'std' => 'I have read and understood your reasonable terms <span class="required">*</span>',
                    'type' => 'textarea',
                    'label' => __( 'Terms Text', 'magee-shortcodes'),
                    'desc' => __( 'Insert content for terms of contact form.', 'magee-shortcodes'),
                ),	
                'display_fields' => array(
                    'sid' => 'display_fields',
                    'type' => 'checkbox',
                    'label' => __( 'Display More Fields' ,'magee-shortcodes'),
                    'desc'  => __( 'Choose more fields to be displayed','magee-shortcodes'),
                    'options' => array(
                        'country'   => array('checked'=>'','checkbox_text'=>__('Country','magee-shortcodes')),
                        'city'      => array('checked'=>'','checkbox_text'=>__('City','magee-shortcodes')),
                        'telephone' => array('checked'=>'','checkbox_text'=>__('Telephone','magee-shortcodes')),
                        'company'   => array('checked'=>'','checkbox_text'=>__('Company','magee-shortcodes')),
                        'website'   => array('checked'=>'','checkbox_text'=>__('Website','magee-shortcodes')),
                    )
                ),
                'required_fields' => array(
                    'sid' => 'required_fields',
                    'type' => 'checkbox',
                    'label' => __( 'Required Fields' ,'magee-shortcodes'),
                    'desc'  => __( 'Choose fields to be required','magee-shortcodes'),
                    'options' => array(
                        'name'      => array('checked'=>__('checked','magee-shortcodes'),'checkbox_text'=>__('Name','magee-shortcodes')),
                        'email'     => array('checked'=>__('checked','magee-shortcodes'),'checkbox_text'=>__('Email','magee-shortcodes')),
                        'country'   => array('checked'=>'','checkbox_text'=>__('Country','magee-shortcodes')),
                        'city'      => array('checked'=>'','checkbox_text'=>__('City','magee-shortcodes')),
                        'telephone' => array('checked'=>'','checkbox_text'=>__('Telephone','magee-shortcodes')),
                        'company'   => array('checked'=>'','checkbox_text'=>__('Company','magee-shortcodes')),
                        'website'   => array('checked'=>'','checkbox_text'=>__('Website','magee-shortcodes')),
                        'subject'   => array('checked'=>'','checkbox_text'=>__('Subject','magee-shortcodes')),
                        'message'   => array('checked'=>__('checked','magee-shortcodes'),'checkbox_text'=>__('Message','magee-shortcodes')),
                    )
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                )
                
                
            ),
            'shortcode' => '[ms_contact receiver="{{receiver}}"  style="{{style}}" color="{{color}}"  terms="{{terms}}" display_fields="{{display_fields}}" required_fields="{{required_fields}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_contact]',
            'popup_title' => __( 'Contact Form Shortcode', 'magee-shortcodes')
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Countdowns Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['countdowns'] = array(
            'no_preview' => false,
            'icon' => 'fa-calendar',
            'params' => array(
                
            'type' => array(
                'std' => '',
                'type' => 'select',
                'label' => __( 'Type', 'magee-shortcodes' ),
                'desc' => __('Select type for countdown to show.', 'magee-shortcodes'),
                'options' => array(
                    'normal' => __('Normal','magee-shortcodes'),
                    'circle' => __('Circle','magee-shortcodes')
                )
            ),
            'endtime' => array(
                    'std' => date('Y/m/d H:i:s',strtotime(' 1 month')),
                    'type' => 'datepicker',
                    'label' => __( 'Set end time for countdown.', 'magee-shortcodes' ),
                    'desc' => '',

                ),
                'day_field_text' => array(
                    'std' => 'Days',
                    'type' => 'text',
                    'label' => __( 'Day Field Text','magee-shortcodes' ),
                    'desc' => '',   
                ),
                'hours_field_text' => array(
                    'std' => 'Hours',
                    'type' => 'text',
                    'label' => __( 'Hours Field Text','magee-shortcodes' ),
                    'desc' => '',   
                ),
                'minutes_field_text' => array(
                    'std' => 'Minutes',
                    'type' => 'text',
                    'label' => __( 'Minutes Field Text','magee-shortcodes' ),
                    'desc' => '',   
                ),
                'seconds_field_text' => array(
                    'std' => 'Seconds',
                    'type' => 'text',
                    'label' => __( 'Seconds Field Text','magee-shortcodes' ),
                    'desc' => '',   
                ),
                'fontcolor' => array(
                    'std' => '',
                    'type' => 'colorpicker',
                    'label' => __( 'Font Color','magee-shortcodes' ),
                    'desc' => __( 'Set font color for countdown.', 'magee-shortcodes')
                
                ), 	
                'backgroundcolor' => array(
                    'std' => '',
                    'type' => 'colorpicker',
                    'label' => __( 'Background Color','magee-shortcodes'),
                    'desc' => __( 'Set background color for countdown.','magee-shortcodes')
                
                ),
                'google_fonts' => array(
                    'std' => '',
                    'type' => 'more_select',
                    'label' => __( 'Google Fonts','magee-shortcodes'),
                    'desc' => __( 'Choose google fonts for countdown.','magee-shortcodes'),
                    'options' => $google_fonts,
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'circle_type_day_color' => array(
                    'std' => '#1abc9c',
                    'type' => 'colorpicker',
                    'label' => __( 'Circle Type Day Color', 'magee-shortcodes' ),
                    'desc' => __( 'If type is circle,the color to be countdowns day nav.', 'magee-shortcodes' ) 
                ),
                'circle_type_hours_color' => array(
                    'std' => '#2980b9',
                    'type' => 'colorpicker',
                    'label' => __( 'Circle Type Hours Color', 'magee-shortcodes' ),
                    'desc' => __( 'If type is circle,the color to be countdowns hours nav.', 'magee-shortcodes' ) 
                ),
                'circle_type_minutes_color' => array(
                    'std' => '#8e44ad',
                    'type' => 'colorpicker',
                    'label' => __( 'Circle Type Minutes Color', 'magee-shortcodes' ),
                    'desc' => __( 'If type is circle,the color to be countdowns minutes nav.', 'magee-shortcodes' ) 
                ),
                'circle_type_seconds_color' => array(
                    'std' => '#f39c12',
                    'type' => 'colorpicker',
                    'label' => __( 'Circle Type Seconds Color', 'magee-shortcodes' ),
                    'desc' => __( 'If type is circle,the color to be countdowns seconds nav.', 'magee-shortcodes' ) 
                ),
                
            ),
            'shortcode' => '[ms_countdowns type="{{type}}" nowtime="'.date('Y/m/d H:i:s').'" endtime="{{endtime}}" day_field_text="{{day_field_text}}" hours_field_text="{{hours_field_text}}" minutes_field_text="{{minutes_field_text}}" seconds_field_text="{{seconds_field_text}}" fontcolor="{{fontcolor}}" backgroundcolor="{{backgroundcolor}}" google_fonts="{{google_fonts}}" class="{{class}}" id="{{id}}" circle_type_day_color="{{circle_type_day_color}}" circle_type_hours_color="{{circle_type_hours_color}}" circle_type_minutes_color="{{circle_type_minutes_color}}" circle_type_seconds_color="{{circle_type_seconds_color}}"]',
            'popup_title' => __( 'Countdowns Shortcode', 'magee-shortcodes' ),
            'name' => __('countdowns-shortcode/','magee-shortcodes'),
        );


        /*-----------------------------------------------------------------------------------*/
        /*	Counter Box Config
        /*-----------------------------------------------------------------------------------*/


        $magee_shortcodes['counter'] = array(
            'no_preview' => false,
            'icon' => 'fa-calculator',
            'params' => array(
                
            ),
            'shortcode' => "[ms_row]\r\n{{child_shortcode}}[/ms_row]",
            'child_shortcode' => array(
                'params' => array(	
                    'box_width' => array(
                        'std' => '1/4',
                        'type' => 'select',
                        'label' => __( 'Box Width', 'magee-shortcodes' ),
                        'desc' => __( 'Select size of counter box', 'magee-shortcodes' ),
                        'options' => array(
                                '1/1' => __('1/1', 'magee-shortcodes'),
                                '1/2' => __('1/2', 'magee-shortcodes'),
                                '1/3' => __('1/3', 'magee-shortcodes'),
                                '1/4' => __('1/4', 'magee-shortcodes'),
                                '1/5' => __('1/5', 'magee-shortcodes'),
                                '1/6' => __('1/6', 'magee-shortcodes'),
                                '2/3' => __('2/3', 'magee-shortcodes'),
                                '2/5' => __('2/5', 'magee-shortcodes'),
                                '3/4' => __('3/4', 'magee-shortcodes'),
                                '3/5' => __('3/5', 'magee-shortcodes'),
                                '4/5' => __('4/5', 'magee-shortcodes'),
                                '5/6' => __('5/6', 'magee-shortcodes'),
                            )
                    ),	
                    'top_icon' => array(
                            'type' => 'iconpicker',
                            'label' => __( 'Top Icon', 'magee-shortcodes' ),
                            'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                            'options' => $icons
                        ),
                    'top_icon_color' => array(
                            'std' => '',
                            'type' => 'colorpicker',
                            'label' => __( 'Top Icon Color', 'magee-shortcodes'),  
                            'desc' => __( 'Set color for top icon.','magee-shortcodes') 
                    
                        ),
                    'middle_left_icon' => array(
                            'type' => 'iconpicker',
                            'label' => __( 'Middle Left Icon', 'magee-shortcodes' ),
                            'desc' =>  __( 'Insert text before the number.', 'magee-shortcodes' ),
                            'options' => $icons
                        ),
                        
                        'middle_left_text' => array(
                            'std' => '',
                            'type' => 'text',
                            'label' => __( 'Middle Left Text', 'magee-shortcodes' ),
                            'desc' => __( 'Left text of counter num', 'magee-shortcodes' ),
                        ),
                        
                        'counter_num' => array(
                            'std' => '100',
                            'type' => 'number',
                            'max' => '200',
                            'min' => '0',
                            'label' => __( 'Counter Num', 'magee-shortcodes' ),
                            'desc' => __( 'The animated counter number.', 'magee-shortcodes' ),
                        ),
                        'middle_right_text' => array(
                            'std' => '',
                            'type' => 'text',
                            'label' => __( 'Middle Right Text', 'magee-shortcodes' ),
                            'desc' =>  __( 'Insert text after the number.', 'magee-shortcodes' ),
                        ),
                        
                        'bottom_title' => array(
                            'std' => '',
                            'type' => 'text',
                            'label' => __( 'Bottom Title', 'magee-shortcodes' ),
                            'desc' => __( 'Insert Title for counter.', 'magee-shortcodes' ),
                        ),
                        
                        'border' => array(
                            'type' => 'choose',
                            'label' => __( 'Display Border', 'magee-shortcodes' ),
                            'desc' =>  __( 'Choose to display border for counter.', 'magee-shortcodes' ),
                            'options' => array( 
                                            'no' => __('No', 'magee-shortcodes' ),  
                                            'yes' => __('Yes', 'magee-shortcodes' ),  
                                            )
                                            
                        ),
                    'class' => array(
                        'std' => '',
                        'type' => 'text',
                        'label' => __( 'CSS Class', 'magee-shortcodes' ),
                        'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                    ),
                    'id' => array(
                        'std' => '',
                        'type' => 'text',
                        'label' => __( 'CSS ID', 'magee-shortcodes' ),
                        'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                    )
                ),
                'shortcode' => "[ms_counter box_width=\"{{box_width}}\" top_icon=\"{{top_icon}}\" top_icon_color=\"{{top_icon_color}}\" middle_left_icon=\"{{middle_left_icon}}\" counter_num=\"{{counter_num}}\"  middle_left_text=\"{{middle_left_text}}\" middle_right_text=\"{{middle_right_text}}\" bottom_title=\"{{bottom_title}}\" border=\"{{border}}\" class=\"{{class}}\" id=\"{{id}}\"]\r\n",
            ),	
            'popup_title' => __( 'Counter Shortcode', 'magee-shortcodes' ),
            'name' => __('counter-box-shortcode/','magee-shortcodes'),
        );

        /*******************************************************
        *	Custom Box Config
        ********************************************************/
        $magee_shortcodes['custom_box'] = array(
            'no_preview' => false,
            'icon' => 'fa-list-alt',
            'params' => array(
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    'type' => 'textarea',
                    'label' => __( 'Content', 'magee-shortcodes' ),
                    'desc' => __( 'Insert content for custom box.', 'magee-shortcodes' ),
                ),
                'font_size' => array(
                    'std' => '14',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Font Size', 'magee-shortcodes' ),
                    'desc' => __( 'Set font size for content.', 'magee-shortcodes' ),
                ),
                'font_color' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Font Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for content.', 'magee-shortcodes' ),
                ),
                'backgroundimage' => array(
                        'type' => 'uploader',
                        'label' => __( 'Background Image', 'magee-shortcodes' ),
                        'desc' => __( 'Upload an image to display in background of custom box.', 'magee-shortcodes' ),
                    ), 
                'fixed_background' => array(
                        'type' => 'choose',
                        'std' => 'yes',
                        'label' => __( 'Fixed Background', 'magee-shortcodes' ),
                        'desc' => __( 'Choose to fixed Background Image', 'magee-shortcodes' ),
                        'options' => $choices,
                ),	
                'background_position' => array(
                    'type' => 'select',    
                    'std' => 'top left',
                    'label' => __( 'Background Position' , 'magee-shortcodes'), 
                    'desc' => __( 'Choose the postion of the background image' , 'magee-shortcodes'),
                    'options' => array(
                                    'top left' => __( 'Top Left', 'magee-shortcodes' ),
                                    'top center' => __( 'Top Center', 'magee-shortcodes' ),
                                    'top right' => __( 'Top Right', 'magee-shortcodes' ),
                                    'center left' => __( 'Center Left', 'magee-shortcodes' ),
                                    'center center' => __( 'Center Center', 'magee-shortcodes' ),
                                    'center right' => __( 'Center Right', 'magee-shortcodes' ),
                                    'bottom left' => __( 'Bottom Left', 'magee-shortcodes' ),
                                    'bottom center' => __( 'Bottom Center', 'magee-shortcodes' ),
                                    'bottom right' => __( 'Bottom Right', 'magee-shortcodes' )
                                    )
                ),
                'padding' => array(
                    'std' => '30',
                    'type' => 'number',
                    'min' => '0',
                    'max' => '100',
                    'label' => __( 'Padding', 'magee-shortcodes' ),
                    'desc' => __( 'Content Padding. eg:30px', 'magee-shortcodes')
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),			
            ),
            'shortcode' => '[ms_custom_box backgroundimage="{{backgroundimage}}" font_size="{{font_size}}" font_color="{{font_color}}" fixed_background="{{fixed_background}}" background_position="{{background_position}}" padding="{{padding}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_custom_box]',
            'popup_title' => __( ' Custom Box Shortcode', 'magee-shortcodes'),
            'name' => __('custom-box-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Dailymotion Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['dailymotion'] = array(
            'no_preview' => false,
            'icon' => 'fa-video-camera',
            'params' => array(
            
                'link' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Dailymotion URL', 'magee-shortcodes' ),
                    'desc' => __( 'Add the URL the video will link to, ex: https://www.dailymotion.com/xxx', 'magee-shortcodes' ),
                ),
                'width' => array(
                    'std' => '100%',
                    'type' => 'text',
                    'label' => __('Width','magee-shortcodes'),
                    'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'),
                ),
                'height' => array(
                    'std' => '550px',
                    'type' => 'text',
                    'label' => __('Height','magee-shortcodes'),
                    'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'), 
                ),
                'mute' => array( 
                    'std' => '',  
                    'type' => 'choose',
                    'label' => __('Mute Video' ,'magee-shortcodes'),
                    'desc' => __('Choose to mute the video.','magee-shortcodes'), 
                    'options' => $reverse_choices	 
                ),
                'autoplay' =>array(
                    'std' => '',
                    'type' => 'choose',
                    'label' => __('Autoplay Video','magee-shortcodes'),
                    'desc' => __('Choose to autoplay the video.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes'),
                    )
                ),
                'loop' =>array(
                    'std' => '',
                    'type' => 'choose',
                    'label' => __('Loop Video','magee-shortcodes'),
                    'desc' => __('Choose to loop the video.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes')
                    )
                ),
                'controls' =>array(
                    'std' => '',
                    'type' => 'choose',
                    'label' => __('Show Controls','magee-shortcodes'),
                    'desc' => __('Choose to display controls for the video player.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes')
                    )
                ),
                'highlight' => array(
                    'std' => '#3377dd',
                    'type' => 'colorpicker',
                    'label' => __( 'Highlight Color','magee-shortcodes'),
                    'desc' => __('Set color for highlights','magee-shortcodes') ,  
                ),
                'logo' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __( 'Show Logo','magee-shortcodes'),
                    'desc' => __('Choose to display logo ','magee-shortcodes') ,  
                    'options' => $choices
                ),
                'info' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __( 'Show Info','magee-shortcodes'),
                    'desc' => __('Choose to display video info','magee-shortcodes') ,  
                    'options' => $choices
                ),
                'related' => array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __( 'Show Related Videos','magee-shortcodes'),
                    'desc' => __('Choose to display related videos','magee-shortcodes') ,  
                    'options' => $choices
                ),
                'quality' => array(
                    'std' => '1080',
                    'type' => 'select',
                    'label' => __( 'Quality','magee-shortcodes'),
                    'desc' => __('Select the default video playback quality','magee-shortcodes') ,  
                    'options' => array(
                        '240' => __( '240','magee-shortcodes'),
                        '380' => __( '380','magee-shortcodes'),
                        '480' => __( '480','magee-shortcodes'),
                        '720' => __( '720','magee-shortcodes'),  
                        '1080' => __( '1080','magee-shortcodes'),
                        )
                ),
                'class' =>array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __('CSS Class','magee-shortcodes'),
                    'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
                ),   
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_dailymotion link="{{link}}"  width="{{width}}" height="{{height}}" mute="{{mute}}" autoplay="{{autoplay}}" loop="{{loop}}" controls="{{controls}}" highlight="{{highlight}}" logo="{{logo}}" info="{{info}}" related="{{related}}" quality="{{quality}}" class="{{class}}" id="{{id}}"][/ms_dailymotion]',   
            'popup_title' => __( 'Dailymotion Shortcode', 'magee-shortcodes' ),
            'name' => __('dailymotion-shortcode/','magee-shortcodes'),
        );       


        /*******************************************************
        *	Divider Config
        ********************************************************/

        $magee_shortcodes['divider'] = array(
            'no_preview' => false,
            'icon' => 'fa-ellipsis-h',
            'params' => array(
                'style' => array(
                    'type' => 'select',
                    'label' => __( 'Divider Style', 'magee-shortcodes' ),
                    'desc' => __( 'Select the Divider\'s Style.', 'magee-shortcodes' ),
                    'options' => array(
                        'normal' => __('Normal', 'magee-shortcodes'),
                        'shadow' => __('Shadow', 'magee-shortcodes'),
                        'dashed' => __('Dashed', 'magee-shortcodes'),
                        'dotted' => __('Dotted', 'magee-shortcodes'),
                        'double_line' => __('Double Line', 'magee-shortcodes'),
                        'double_dashed' => __('Double Dashed', 'magee-shortcodes'),
                        'double_dotted' => __('Double Dotted', 'magee-shortcodes'),
                        'image' => __('Image', 'magee-shortcodes'),
                        'icon' => __('Icon', 'magee-shortcodes'),
                        'back_to_top' => __('Back to Top', 'magee-shortcodes'),
                    )
                ),
                'width' => array(
                    'std' => '100%',
                    'type' => 'text',
                    'label' => __( 'Width', 'magee-shortcodes' ),
                    'desc' => __( 'In pixels. Default: 100%', 'magee-shortcodes' ),
                ),
                'align' => array(
                    'type' => 'select',
                    'label' => __( 'Align', 'magee-shortcodes' ),
                    'desc' => __( 'When the width is not 100%.', 'magee-shortcodes' ),
                    'options' => array(
                        'left' => __('Left', 'magee-shortcodes'),
                        'center' => __('Center', 'magee-shortcodes'),
                    )
                ),
                'margin_top' => array(
                    'std' => '30',
                    'type' => 'number',
                    'min' => '0',
                    'max' => '100',
                    'label' => __( 'Margin Top', 'magee-shortcodes' ),
                    'desc' => __( 'Spacing above the separator. In pixels.', 'magee-shortcodes' ),
                ),
                'margin_bottom' => array(
                    'std' => '30',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Margin Bottom', 'magee-shortcodes' ),
                    'desc' => __( 'Spacing under the separator. In pixels.', 'magee-shortcodes' ),
                ),
                
                'border_size' => array(
                        'std' => '2',
                        'type' => 'number',
                        'max' => '50',
                        'min' => '0',
                        'label' => __( 'Border Size', 'magee-shortcodes' ),
                        'desc' => __( 'In pixels (px), eg: 1px. ', 'magee-shortcodes' ),
                ),
                'border_color' => array(
                        'std' => '#f2f2f2',
                        'type' => 'colorpicker',
                        'label' => __( 'Border Color', 'magee-shortcodes' ),
                        'desc' => __( 'Set the border color.', 'magee-shortcodes' )
                    ),
                
                'icon' => array(
                        'type' => 'iconpicker',
                        'label' => __( 'Icon', 'magee-shortcodes' ),
                        'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                        'options' => $icons
                    ),	
            
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),			
            ),
            'shortcode' => '[ms_divider style="{{style}}" align="{{align}}"  width="{{width}}"  margin_top="{{margin_top}}" margin_bottom="{{margin_bottom}}" border_size="{{border_size}}" border_color="{{border_color}}" icon="{{icon}}" class="{{class}}" id="{{id}}"][/ms_divider]',
            'popup_title' => __( 'Divider Shortcode', 'magee-shortcodes'),
            'name' => __('divider-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Document Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['document'] = array(
            'no_preview' => false,
            'icon' => 'fa-file-text-o',
            'params' => array(
                'url' => array(
                    'std' => '', 
                    'type' => 'link',
                    'label' => __( 'Doc URL','magee-shortcodes'), 
                    'desc' => __( 'Upload document to display. Supported formats: doc, xls, pdf etc.','magee-shortcodes')
                ),
                'width' => array(
                    'std' => '300',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0',
                    'label' => __( 'Width', 'magee-shortcodes'),
                    'desc' => __( 'Set width for doc.', 'magee-shortcodes')
                ),
                'height' => array(
                    'std' => '600',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0',
                    'label' => __( 'Height', 'magee-shortcodes'),
                    'desc' => __( 'Set height for doc.', 'magee-shortcodes')
                ),
                'responsive' => array(
                    'type' => 'choose',
                    'label' => __( 'Responsive','magee-shortcodes'),
                    'desc' => __( 'Choose to responsive or not', 'magee-shortcodes'),
                    'options' => $choices
                ),
                'viewer' => array(
                    'type' => 'select',
                    'label' => __('Viewer','magee-shortcodes'),
                    'desc' => __( 'Choose viewer for document.','magee-shortcodes'),
                    'options' => array(
                        'google' => __( 'Google','magee-shortcodes'),
                        'microsoft' => __( 'Microsoft','magee-shortcodes'),
                    )  
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_document url="{{url}}" width="{{width}}" height="{{height}}" responsive="{{responsive}}" viewer="{{viewer}}" class="{{class}}" id="{{id}}"][/ms_document]',
            'popup_title' => __( 'Doc Viewer Shortcode','magee-shortcodes'),
            'name' => __('document-shortcode/','magee-shortcodes'),
        );	

        /*-----------------------------------------------------------------------------------*/
        /*	Dropcap Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['dropcap'] = array(
            'no_preview' => false,
            'icon' => 'fa-square',
            'params' => array(
                'content' => array(
                    'std' => 'A',
                    'type' => 'textarea',
                    'label' => __( 'Dropcap Letter', 'magee-shortcodes' ),
                    'desc' => __( 'Add the letter to be used as dropcap', 'magee-shortcodes' ),
                ),
                'color' => array(
                    'std' => '#eeee22',
                    'type' => 'colorpicker',
                    'label' => __( 'Color', 'magee-shortcodes' ),
                    'desc' => __( 'Controls the color of the dropcap letter. Leave blank for theme option selection.', 'magee-shortcodes')
                ),		
                'boxed' => array(
                    'type' => 'choose',
                    'label' => __( 'Boxed Dropcap', 'magee-shortcodes' ),
                    'desc' => __( 'Choose to get a boxed dropcap.', 'magee-shortcodes' ),
                    'options' => $reverse_choices
                ),
                'boxedradius' => array(
                    'std' => '8',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Box Radius', 'magee-shortcodes' ),
                    'desc' => __('Choose the radius of the boxed dropcap. In pixels (px), eg: 1px', 'magee-shortcodes')
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_dropcap color="{{color}}" boxed="{{boxed}}" boxed_radius="{{boxedradius}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_dropcap]',
            'popup_title' => __( 'Dropcap Shortcode', 'magee-shortcodes' ),
            'name' => __('dropcap-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Dummy image Config
        /*-----------------------------------------------------------------------------------*/
        
        $magee_shortcodes['dummy_image'] = array(
            'no_preview' => false,
            'icon' => 'fa-picture-o',
            'params' => array(
                'style' =>array(
                    'type' => 'select',
                    'label' => __( 'Style','magee-shortcodes'),
                    'desc' => __( 'Select style for dummy image','magee-shortcodes'),
                    'options' => array(
                        'any'       => __( 'Any', 'magee-shortcodes' ),
                        'transport' => __( 'Transport', 'magee-shortcodes' ),
                        'technics'  => __( 'Technics', 'magee-shortcodes' ),
                        'people'    => __( 'People', 'magee-shortcodes' ),
                        'sports'    => __( 'Sports', 'magee-shortcodes' ),
                        'cats'      => __( 'Cats', 'magee-shortcodes' ),
                        'city'      => __( 'City', 'magee-shortcodes' ),
                        'food'      => __( 'Food', 'magee-shortcodes' ),
                        'nightlife' => __( 'Night life', 'magee-shortcodes' ),
                        'fashion'   => __( 'Fashion', 'magee-shortcodes' ),
                        'animals'   => __( 'Animals', 'magee-shortcodes' ),
                        'business'  => __( 'Business', 'magee-shortcodes' ),
                        'nature'    => __( 'Nature', 'magee-shortcodes' ),
                        'abstract'  => __( 'Abstract', 'magee-shortcodes' ),
                    )
                ), 
                'width' => array(
                    'std' => '500',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0' ,
                    'label' => __( 'Width', 'magee-shortcodes'),
                    'desc' => __( 'Set width for image.', 'magee-shortcodes')
                ),
                'height' => array(
                    'std' => '300',
                    'type' => 'number',
                    'max' => '1000',
                    'min' => '0',
                    'label' => __( 'Height', 'magee-shortcodes'),
                    'desc' => __( 'Set height for image.', 'magee-shortcodes')
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            
            ),
            'shortcode' => '[ms_dummy_image style="{{style}}" width="{{width}}" height="{{height}}" class="{{class}}" id="{{id}}"][/ms_dummy_image]' ,
            'popup_title' => __( 'Dummy Image Shortcode','magee-shortcodes'),
            'name' => __('dummy-image-shortcode/','magee-shortcodes'),
        );
            

        /*-----------------------------------------------------------------------------------*/
        /*	Dummy_text Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['dummy_text'] = array(
            'no_preview' => false,
            'icon' => 'fa-text-height',
            'params' => array(
                'style' =>array(
                    'type' => 'select',
                    'label' => __( 'Style','magee-shortcodes'),
                    'desc' => __( 'Select text type.','magee-shortcodes'),
                    'options' => array(
                        'paras' => __( 'Paragraphs', 'magee-shortcodes' ),
                        'words' => __( 'Words', 'magee-shortcodes' ),
                        'bytes' => __( 'Bytes', 'magee-shortcodes' ),
                    )
                ), 
                'amount' => array(
                    'std' => '3',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Amount','magee-shortcodes'),
                    'desc' => __( 'Choose how many paragraphs or words to show','magee-shortcodes')
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_dummy_text style="{{style}}" amount="{{amount}}" class="{{class}}" id="{{id}}"][/ms_dummy_text]' ,
            'popup_title' => __( 'Dummy Text Shortcode','magee-shortcodes'),
            'name' => __('dummy-text-shortcode/','magee-shortcodes'),
        );
            

        /*-----------------------------------------------------------------------------------*/
        /*	Expand Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['expand'] = array(
            'no_preview' => false,
            'icon' => 'fa-sort-amount-asc',
            'params' => array(
                'more_icon' => array(
                    'type' => 'iconpicker',
                    'label' => __('More Icon' ,'magee-shortcodes'),
                    'desc' => __('Set icon for expand title. Click an icon to select, click again to deselect.','magee-shortcodes'),
                    'options' => $icons
                ),
                'more_icon_color' => array(
                    'std' => '', 
                    'type' => 'colorpicker',
                    'label' => __('More Icon Color' ,'magee-shortcodes'),
                    'desc' => __('Set color for more icon.','magee-shortcodes'),			
                ),
                'more_text' => array(
                    'std' => __( 'Click Me', 'magee-shortcodes'),
                    'type' => 'text',
                    'label' => __( 'More Text', 'magee-shortcodes'),
                    'desc' => __( 'Set text for expand title.', 'magee-shortcodes'),
                ),
                'less_icon' => array(
                    'type' => 'iconpicker',
                    'label' => __('Less Icon' ,'magee-shortcodes'),
                    'desc' => __('Set icon for fold title. Click an icon to select, click again to deselect.','magee-shortcodes'),
                    'options' => $icons
                ),
                'less_icon_color' => array(
                    'std' => '', 
                    'type' => 'colorpicker',
                    'label' => __('Less Icon Color' ,'magee-shortcodes'),
                    'desc' => __('Set color for less icon.','magee-shortcodes'),			
                ),
                'less_text' => array(
                    'std' => __( 'read less', 'magee-shortcodes'),
                    'type' => 'text',
                    'label' => __( 'Less Text', 'magee-shortcodes'),
                    'desc' => __( 'Set text for fold title. ', 'magee-shortcodes'),
                ), 
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
                    'type' => 'textarea',
                    'label' => __( 'Content', 'magee-shortcodes'),
                    'desc' => __( 'This text block can be expanded.', 'magee-shortcodes')
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_expand class="{{class}}" id="{{id}}" more_icon="{{more_icon}}" more_icon_color="{{more_icon_color}}" more_text="{{more_text}}" less_icon="{{less_icon}}" less_icon_color="{{less_icon_color}}" less_text="{{less_text}}"]{{content}}[/ms_expand]',
            'popup_title' => __( 'Expand Text Shortcode', 'magee-shortcodes'),
            'name' => __('expand-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Feature Boxes Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['featurebox'] = array(
            'no_preview' => false,
            'icon' => 'fa-list-alt',
            'params' => array(
                'style' => array(
                    'type' => 'select',
                    'label' => __( 'Feature Box Style', 'magee-shortcodes' ),
                    'desc' => __( 'Select the Feature Box\'s Style.', 'magee-shortcodes' ),
                    'options' => array(
                        '1' => __('Icon on Top of Title', 'magee-shortcodes'),
                        '2' => __('Icon Beside Title and Content', 'magee-shortcodes'),
                        '3' => __('Icon Beside Title', 'magee-shortcodes'),
                        '4' => __('Boxed', 'magee-shortcodes'),
                    )
                ),
                
                'title' => array(
                        'std' => __( 'Feature Box', 'magee-shortcodes' ),
                        'type' => 'text',
                        'label' => __( 'Title', 'magee-shortcodes' ),
                        'desc' => __( 'Insert title for feature box.', 'magee-shortcodes' ),
                ),
                
                'title_font_size' => array(
                        'std' => '18',
                        'type' => 'number',
                        'max' => '50',
                        'min' => '0',
                        'label' => __( 'Title Font Size', 'magee-shortcodes' ),
                        'desc' => __( 'Set font size for title of feature box.', 'magee-shortcodes' ),
                ),
                'title_color' => array(
                    'std' => '#54595F',
                    'type' => 'colorpicker',
                    'label' => __( 'Title Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for title of feature box.', 'magee-shortcodes' ),
                    ),
                'icon_animation_type' => array(
                    'type' => 'select',
                    'label' => __( 'Icon Hover Animation', 'magee-shortcodes' ),
                    'desc' => __( 'Select the Icon\'s Animation.', 'magee-shortcodes' ),
                    'options' => $animation_type
                ),
                'icon' => array(
                    'std' => 'fa-line-chart',
                    'type' => 'icon',
                    'label' => __( 'Icon', 'magee-shortcodes' ),
                    'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                    'options' => $icons
                    ),
                'icon_size' => array(
                        'std' => '46',
                        'type' => 'number',
                        'max' => '100',
                        'min' => '0',
                        'label' => __( 'Icon Size', 'magee-shortcodes' ),
                        'desc' =>  __( 'Set size for icon of feature box.', 'magee-shortcodes' ),
                ),
                'icon_color' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Icon Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for icon of feature box.', 'magee-shortcodes' ),
                    ),
                'icon_border_color' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Icon Border Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set border color for icon of feature box.', 'magee-shortcodes' ),
                    ),
                'icon_border_width' => array(
                        'std' => '0',
                        'type' => 'number',
                        'max' => '50',
                        'min' => '0',
                        'label' => __( 'Icon Border Width', 'magee-shortcodes' ),
                        'desc' =>  __( 'Set border width for icon of feature box.', 'magee-shortcodes' ),
                ),
                
                'flip_icon' => array(
                    'std' => 'none',
                    'type' => 'select',
                    'label' => __( 'Flip Icon', 'magee-shortcodes' ),
                    'desc' => __( 'Choose to flip the icon of feature box.', 'magee-shortcodes' ),
                    'options' => array(
                        'none' => __('None', 'magee-shortcodes'),
                        'horizontal' => __('Horizontal', 'magee-shortcodes'),
                        'vertical' => __('Vertical', 'magee-shortcodes'),
                    )
                ),
                    
                'spinning_icon' => array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __( 'Spinning Icon', 'magee-shortcodes' ),
                    'desc' => __( 'Choose to spin the icon of feature box.', 'magee-shortcodes' ),
                    'options' => $reverse_choices 
                ),	
                
                'icon_background_color' => array(
                    'std' => '#ffc733',
                    'type' => 'colorpicker',
                    'label' => __( 'Icon Circle Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background for icon circle of feature box.', 'magee-shortcodes' ),
                ),
                
                'alignment' => array(
                    'std' => '',
                    'type' => 'choose',
                    'label' => __( 'Icon Alignment', 'magee-shortcodes' ),
                    'desc' => __( 'Set alignment for style2/style3 of feature box.', 'magee-shortcodes' ),
                    'options' => array(
                        'left' => __('Left', 'magee-shortcodes'),
                        'right' => __('Right', 'magee-shortcodes'),
                
                    )
                ),	
                'icon_circle' => array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __( 'Icon Circle', 'magee-shortcodes' ),
                    'desc' => __( 'Choose to display icon of feature box in circle.', 'magee-shortcodes' ),
                    'options' => $reverse_choices 
                ),	
                
                'icon_image' => array(
                        'std' => '',
                        'type' => 'uploader',
                        'label' => __( 'Icon Image', 'magee-shortcodes' ),
                        'desc' => __( 'To upload your own icon image, remember to deselect icon above.', 'magee-shortcodes' ),
                ),
                'icon_image_width' => array(
                        'std' => '100',
                        'type' => 'number',
                        'max' => '1000',
                        'min' => '0',
                        'label' => __( 'Icon Image Width', 'magee-shortcodes' ),
                        'desc' => __( 'If using custom icon image, set icon image width. In percentage of pixels (px), eg: 1px.', 'magee-shortcodes' ),
                ),
                'icon_image_height' => array(
                        'std' => '100',
                        'type' => 'number',
                        'max' => '1000',
                        'min' => '0',
                        'label' => __( 'Icon Image Height', 'magee-shortcodes' ),
                        'desc' => __( 'If using custom icon image, set icon image height. In percentage of pixels (px), eg: 1px.', 'magee-shortcodes' ),
                ),
                'link_url' => array(
                    'std' => '#',
                    'type' => 'text',
                    'label' => __( 'Link URL', 'magee-shortcodes' ),
                    'desc' => __( 'Set link for feature box, eg: http://example.com.', 'magee-shortcodes' ),
                ),	
                'link_target' => array(
                    'std' => '_self',
                    'type' => 'choose',
                    'label' => __( 'Link Target', 'magee-shortcodes' ),
                    'desc' => __( '_self = open in same window _blank = open in new window.', 'magee-shortcodes' ),
                    'options' => array(
                        '_blank' => __('_blank', 'magee-shortcodes'),
                        '_self' => __('_self', 'magee-shortcodes'),
                
                    )
                ),	
                'link_text' => array(
                        'std' => __( 'Read More', 'magee-shortcodes' ),
                        'type' => 'text',
                        'label' => __( 'Link Text', 'magee-shortcodes' ),
                        'desc' => __( 'Insert link text for feature box. It would not display if you leave it as blank.', 'magee-shortcodes' ),
                ),
                'link_color' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Link Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for link of feature box.', 'magee-shortcodes' ),
                ),
                'content_color' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Content Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for content of feature box.', 'magee-shortcodes' ),
                ),
                'content_box_background_color' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Set box background color for Boxed Style.', 'magee-shortcodes' ),
                    'desc' => __( 'For Boxed Style', 'magee-shortcodes' ),
                ),

                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),	
                'content' => array(
                    'std' => __('Your Content Goes Here', 'magee-shortcodes'),
                    'type' => 'textarea',
                    'label' => __( 'Feature Box Content', 'magee-shortcodes' ),
                    'desc' => '',
                ),
            ),
            'shortcode' => '[ms_featurebox style="{{style}}" title_font_size="{{title_font_size}}" title_color="{{title_color}}" icon_circle="{{icon_circle}}" icon_size="{{icon_size}}" title="{{title}}" icon="{{icon}}" alignment="{{alignment}}" icon_animation_type="{{icon_animation_type}}" icon_color="{{icon_color}}" icon_background_color="{{icon_background_color}}" icon_border_color="{{icon_border_color}}" icon_border_width="{{icon_border_width}}"  flip_icon="{{flip_icon}}" spinning_icon="{{spinning_icon}}" icon_image="{{icon_image}}" icon_image_width="{{icon_image_width}}" icon_image_height="{{icon_image_height}}" link_url="{{link_url}}" link_target="{{link_target}}" link_text="{{link_text}}" link_color="{{link_color}}" content_color="{{content_color}}" content_box_background_color="{{content_box_background_color}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_featurebox]',
            'popup_title' => __( 'Feature Box Shortcode', 'magee-shortcodes'),
            'name' => __('feature-box-shortcode/','magee-shortcodes'),
        );


        /*******************************************************
        *	Flip Box Config
        ********************************************************/

        $magee_shortcodes['flip_box'] = array(
            'no_preview' => false,
            'icon' => 'fa-list-alt',
            'params' => array(
                'direction' => array(
                    'type' => 'select',
                    'label' => __( 'Direction', 'magee-shortcodes' ),
                    'desc' => __( 'Select flip directioon.', 'magee-shortcodes' ),
                    'options' => array(
                        'horizontal' => __('Horizontal', 'magee-shortcodes'),
                        'vertical' => __('Vertical', 'magee-shortcodes'),
                        'flip-left' => __('Flip Left', 'magee-shortcodes'),
                        'flip-right' => __('Flip Right', 'magee-shortcodes'),
                        'flip-top' => __('Flip Top', 'magee-shortcodes'),
                        'flip-bottom' => __('Flip Bottom', 'magee-shortcodes'),
                        'slide-left' => __('Slide Left', 'magee-shortcodes'),
                        'slide-right' => __('Slide Right', 'magee-shortcodes'),
                        'slide-top' => __('Slide Top', 'magee-shortcodes'),
                        'slide-bottom' => __('Slide Bottom', 'magee-shortcodes'),
                    )			
                ),
                'front_paddings' => array(
                    'std' => '15',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Front Container Paddings', 'magee-shortcodes' ),
                    'desc' => __( 'Set paddings for front container of flip box.', 'magee-shortcodes' ),
                ),
                'front_background' => array(
                    'type' => 'colorpicker',
                    'std'=>'#6ab1c9',
                    'label' => __( 'Front Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background color for front container of flip box.', 'magee-shortcodes')
                ),
                'front_color' => array(
                    'type' => 'colorpicker',
                    'std' => '#ffffff',
                    'label' => __( 'Front Font Color', 'magee-shortcodes' ),
                    'desc' => __( 'Custom setting only. Set the background color for custom alert boxes.', 'magee-shortcodes')
                ),
                'front_content' => array(
                    'std' => __('Front Content', 'magee-shortcodes'),
                    'type' => 'textarea',
                    'label' => __( 'Front content.', 'magee-shortcodes' ),
                    'desc' => __( 'Insert content for front container of flip box.', 'magee-shortcodes' ),
                ),
                'back_paddings' => array(
                    'std' => '15',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Back Container Paddings', 'magee-shortcodes' ),
                    'desc' => __( 'Set paddings for back container of flip box.', 'magee-shortcodes' ),
                ),
                'back_background' => array(
                    'std'=>'#538b9d',
                    'type' => 'colorpicker',
                    'label' => __( 'Back Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background color for back container of flip box.', 'magee-shortcodes')
                ),
                'back_color' => array(
                    'std' =>'#ffffff',
                    'type' => 'colorpicker',
                    'label' => __( 'Back Font Color', 'magee-shortcodes' ),
                    'desc' => __( 'Custom setting only. Set the background color for custom alert boxes.', 'magee-shortcodes')
                ),
                'back_content' => array(
                    'std' => __('Back Content', 'magee-shortcodes'),
                    'type' => 'textarea',
                    'label' => __( 'Back Content.', 'magee-shortcodes' ),
                    'desc' => __('Insert content for back container of flip box.', 'magee-shortcodes'),
                ),
                
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),			
            ),
            'shortcode' => '[ms_flip_box direction="{{direction}}" front_paddings="{{front_paddings}}"  front_background="{{front_background}}" front_color="{{front_color}}" back_paddings="{{back_paddings}}" back_background="{{back_background}}" back_color="{{back_color}}" class="{{class}}" id="{{id}}"]{{front_content}}|||{{back_content}}[/ms_flip_box]',
            'popup_title' => __( 'Flip Box Shortcode', 'magee-shortcodes'),
            'name' => __('flip-box-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Google Map Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['google_map'] = array(
            'no_preview' => true,
            'icon' => 'fa-globe',
            'params' => array(
                'type' => array(
                    'type' => 'select',
                    'label' => __( 'Map Type', 'magee-shortcodes'),
                    'desc' => __( 'Select the type of google map to display.', 'magee-shortcodes'),
                    'options' => array(
                        'roadmap' => __('Roadmap', 'magee-shortcodes'),
                        'satellite' => __('Satellite', 'magee-shortcodes'),
                        'hybrid' => __('Hybrid', 'magee-shortcodes'),
                        'terrain' => __('Terrain', 'magee-shortcodes')
                    )
                ),
                'width' => array(
                    'std' => '100%',
                    'type' => 'text',
                    'label' => __( 'Map Width', 'magee-shortcodes'),
                    'desc' => __( 'Map width in percentage or pixels. ex: 100%, or 940px.', 'magee-shortcodes')
                ),
                'height' => array(
                    'std' => '300px',
                    'type' => 'text',
                    'label' => __( 'Map Height', 'magee-shortcodes'),
                    'desc' => __( 'Map height in pixels. ex: 300px', 'magee-shortcodes')
                ),
                'zoom' => array(
                    'std' => 14,
                    'type' => 'select',
                    'label' => __( 'Zoom Level', 'magee-shortcodes'),
                    'desc' => __( 'Higher number will be more zoomed in.', 'magee-shortcodes'),
                    'options' => Helper::shortcodes_range( 25, false )
                ),
                'scrollwheel' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __( 'Scrollwheel on Map', 'magee-shortcodes'),
                    'desc' => __( 'Enable zooming using a mouse\'s scroll wheel.', 'magee-shortcodes'),
                    'options' => $choices
                ),
                'scale' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __( 'Show Scale Control on Map', 'magee-shortcodes'),
                    'desc' => __( 'Display the map scale.', 'magee-shortcodes'),
                    'options' => $choices
                ),
                'zoom_pancontrol' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __( 'Show Pan Control on Map', 'magee-shortcodes'),
                    'desc' => __( 'Displays pan control button.', 'magee-shortcodes'),
                    'options' => $choices
                ),
                'animation' => array(
                    'type' => 'choose',
                    'label' => __( 'Address Pin Animation', 'magee-shortcodes'),
                    'desc' => __( 'Choose to animate the address pins when the map first loads.', 'magee-shortcodes'),
                    'options' => $choices
                ),		
                'popup' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __( 'Show tooltip by default', 'magee-shortcodes'),
                    'desc' => __( 'Display or hide the tooltip when the map first loads.', 'magee-shortcodes'),
                    'options' => $choices
                ),

                'overlaycolor' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Map Overlay Color', 'magee-shortcodes'),
                    'desc' => __( 'Custom styling setting only. Pick an overlaying color for the map. Works best with "roadmap" type.', 'magee-shortcodes')
                ),
                
                'infoboxcontent' => array(
                    'std' => 'London City',
                    'type' => 'textarea',
                    'label' => __( 'Infobox Content', 'magee-shortcodes'),
                    'desc' => __( 'Custom styling setting only. Type in custom info box content to replace address string. For multiple addresses, separate info box contents by using the | symbol. ex: InfoBox 1|InfoBox 2|InfoBox 3', 'magee-shortcodes'),
                ),		
                'infoboxtextcolor' => array(
                    'std' => '#ffffff',
                    'type' => 'colorpicker',
                    'label' => __( 'Info Box Text Color', 'magee-shortcodes'),
                    'desc' => __( 'Custom styling setting only. Pick a color for the info box text.', 'magee-shortcodes')
                ),
                'infoboxbackgroundcolor' => array(
                    'std' =>'#cd2f23',
                    'type' => 'colorpicker',
                    'label' => __( 'Info Box Background Color', 'magee-shortcodes'),
                    'desc' => __( 'Custom styling setting only. Pick a color for the info box background.', 'magee-shortcodes')
                ),
                'icon' => array(
                    'std' => '',
                    'type' => 'textarea',
                    'label' => __( 'Custom Marker Icon', 'magee-shortcodes'),
                    'desc' => __( 'Custom styling setting only. Use full image urls for custom marker icons or input "theme" for our custom marker. For multiple addresses, separate icons by using the | symbol or use one for all. ex: Icon 1|Icon 2|Icon 3', 'magee-shortcodes'),
                ),
                'content' => array(
                    'std' => 'London',
                    'type' => 'textarea',
                    'label' => __( 'Address', 'magee-shortcodes'),
                    'desc' => __( 'Add address to the location which will show up on map. For multiple addresses, separate addresses by using the | symbol. <br />ex: Address 1|Address 2|Address 3', 'magee-shortcodes'),
                ),
                'api_key' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Google Map API Key', 'magee-shortcodes'),
                    'desc' => '',
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes'),
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes'),
                )
            ),
            'shortcode' => '[ms_google_map address="{{content}}" type="{{type}}" overlay_color="{{overlaycolor}}" infobox_background_color="{{infoboxbackgroundcolor}}" infobox_text_color="{{infoboxtextcolor}}" infobox_content="{{infoboxcontent}}" icon="{{icon}}" width="{{width}}" height="{{height}}" zoom="{{zoom}}" scrollwheel="{{scrollwheel}}" scale="{{scale}}" zoom_pancontrol="{{zoom_pancontrol}}" popup="{{popup}}" animation="{{animation}}" api_key="{{api_key}}" class="{{class}}" id="{{id}}"][/ms_google_map]',
            'popup_title' => __( 'Google Map Shortcode', 'magee-shortcodes')
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Heading Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['heading'] = array(
            'icon' => 'fa-header',
            'no_preview' => false,
            'params' => array(
                            
                'title' => array(
                    'std' => __( 'Heading Text', 'magee-shortcodes'),
                    'type' => 'text',
                    'label' => __( 'Title', 'magee-shortcodes'),
                    'desc' => __( 'Insert heading text', 'magee-shortcodes')
                ),
                            
                'style' => array(
                    'type' => 'select',
                    'label' => __( 'Style', 'magee-shortcodes'),
                    'std' => 'border',
                    'desc' => __( 'Choose a heading style. Leave blank as default.', 'magee-shortcodes'),
                    'options' => array(
                        'none' => __('None','magee-shortcodes'),
                        'border' => __('Border','magee-shortcodes'),
                        'boxed' => __('Boxed','magee-shortcodes'),
                        'boxed-reverse' => __('Boxed-reverse','magee-shortcodes'),
                        'doubleline' => __('Doubleline','magee-shortcodes')
                    )
                ),
                
                'color' => array(
                    'std' => '#000000',
                    'type' => 'colorpicker',
                    'label' => __( 'Font Color', 'magee-shortcodes'),
                    'desc' => __( 'Set color for heading text.', 'magee-shortcodes'),
                    ),	
                'border_color' => array(
                    'std' => '#000000',
                    'type' => 'colorpicker',
                    'label' => __( 'Border Color', 'magee-shortcodes'),
                    'desc' => __( 'Set border color for heading.', 'magee-shortcodes'),
                    ),
                
                'text_align' => array(
                    'type' => 'select',
                    'label' => __( 'Text Align', 'magee-shortcodes'),
                    'desc' => __( 'Set text align for this heading.', 'magee-shortcodes'),
                    'options' => $textalign
                ),
                'font_weight' => array(
                    'type' => 'select',
                    'std' => '400',
                    'label' => __( 'Font Weight', 'magee-shortcodes'),
                    'desc' => __( 'Set font weight for heading text.', 'magee-shortcodes'),
                    'options' => array(
                                    '100' => '100',
                                    '200' => '200',
                                    '300' => '300',
                                    '400' => '400',
                                    '500' => '500',
                                    '600' => '600',
                                    '700' => '700',
                                    '800' => '800',
                                    '900' => '900',
                                    )
                ),
                
                'font_size' => array(
                    'std' => '36',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Font Size', 'magee-shortcodes'),
                    'desc' => __( 'Set font size for heading text. In pixels (px), eg: 1px.', 'magee-shortcodes'),
                ),
                'margin_top' => array(
                    'std' => '0',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Margin Top', 'magee-shortcodes'),
                    'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes'),
                ),
                'margin_bottom' => array(
                    'std' => '0',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Margin Bottom', 'magee-shortcodes'),
                    'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes'),
                ),
                'border_width' => array(
                    'std' => '5',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Border Width', 'magee-shortcodes'),
                    'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes'),
                ),
                'responsive_text' => array(
                    'std' => '',
                    'type' => 'choose',
                    'label' => __( 'Responsive Text','magee-shortcodes'),
                    'desc' => __( 'Choose to display responsive text.', 'magee-shortcodes'),
                    'options' => $reverse_choices		
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),	
                
                
                ),
            'shortcode' => '[ms_heading style="{{style}}" color="{{color}}" border_color="{{border_color}}" text_align="{{text_align}}" font_weight="{{font_weight}}" font_size="{{font_size}}" margin_top="{{margin_top}}" margin_bottom="{{margin_bottom}}" border_width="{{border_width}}" responsive_text="{{responsive_text}}"  class="{{class}}" id="{{id}}"]{{title}}[/ms_heading]',
            'popup_title' => __( 'Heading Shortcode', 'magee-shortcodes'),
            'name' => __('heading-shortcode/','magee-shortcodes'),  
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Highlight Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['highlight'] = array(
            'no_preview' => false,
            'icon' => 'fa-magic',
            'params' => array(

                'background_color' => array(
                    'std' => '#007005',
                    'type' => 'colorpicker',
                    'label' => __( 'Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background color for highlight item.', 'magee-shortcodes')
                ),
                'border_radius' => array(
                    'type' => 'number',
                    'std' =>'5',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Border Radius', 'magee-shortcodes' ),
                    'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
                ),
                'color' => array(
                    'std' => '#ffffff',
                    'type' => 'colorpicker',
                    'label' => __( 'Font Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set font color for highlight item.', 'magee-shortcodes')
                ),
                'content' => array(
                    'std' => __('Your Content Goes Here', 'magee-shortcodes'),
                    'type' => 'textarea',
                    'label' => __( 'Content to Higlight', 'magee-shortcodes' ),
                    'desc' => __( 'Insert content to highlight.', 'magee-shortcodes' ),
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),			

            ),
            'shortcode' => '[ms_highlight background_color="{{background_color}}" border_radius="{{border_radius}}" color="{{color}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_highlight]',
            'popup_title' => __( 'Highlight Shortcode', 'magee-shortcodes' ),
            'name' => __('highlight-shortcode/','magee-shortcodes'),
        );


        /*-----------------------------------------------------------------------------------*/
        /*	Icon Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['icon'] = array(
            'icon' => 'fa-flag',
            'no_preview' => false,
            'params' => array(

            'icon' => array(
                    'std' => 'fa-heart',
                    'type' => 'icon',
                    'label' => __( 'Icon', 'magee-shortcodes'),
                    'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes'),
                    'options' => $icons
                    ),
            'size' => array(
                    'type' => 'number',
                    'std' => '14',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Icon Size', 'magee-shortcodes'),
                    'desc' => __( 'Set text size for item.', 'magee-shortcodes'),
                    ),
            'color' => array(
                    'type' => 'colorpicker',
                    'std' => '#fdd200',
                    'label' => __( 'Icon Color', 'magee-shortcodes'),
                    'desc' =>  __( 'Set color for icon.', 'magee-shortcodes'),
                ),
            'icon_box' => array(
                    'std' => 'no',  
                    'type' => 'choose',
                    'label' => __( 'Icon Box', 'magee-shortcodes'),
                    'desc' => __( 'Choose to display boxed icon.', 'magee-shortcodes'),
                    'options' => $reverse_choices
                ),		
            'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
            'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),			

            ),
            'shortcode' => '[ms_icon icon="{{icon}}" size="{{size}}" color="{{color}}" icon_box="{{icon_box}}" class="{{class}}" id="{{id}}"]',
            'popup_title' => __( 'Icon Shortcode', 'magee-shortcodes'),
            'name' => __('icon-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Image Banner Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['image_banner'] = array(
            'no_preview' => true,
            'icon' => 'fa-file-image-o',
            'params' => array(
                
                'image' => array(
                        'type' => 'uploader',
                        'label' => __( 'Image', 'magee-shortcodes'),
                        
                    ), 
                    'link' => array(
                        'std' => '#',
                        'type' => 'text',
                        'label' => __( 'Image Link', 'magee-shortcodes'),
                    
                ),		
                    
                'target' => array(
                    'std' => '_blank',
                    'type' => 'choose',
                    'label' => __( 'Link Target', 'magee-shortcodes'),
                    'options' => array(
                        '_blank' => __('_blank', 'magee-shortcodes'),
                        '_self' => __('_self', 'magee-shortcodes'),
                    )
                ),
                
                'horizontal_align' => array(
                    'type' => 'select',
                    'label' => __( 'Horizontal Align', 'magee-shortcodes'),
                    'desc' => __( 'Content horizontal align.', 'magee-shortcodes'),
                    'options' => array(
                        'center' => __('Center', 'magee-shortcodes'),
                        'left' => __('Left', 'magee-shortcodes'),
                        'right' => __('Right', 'magee-shortcodes'),
                    )
                ),
                'vertical_align' => array(
                    'type' => 'select',
                    'label' => __( 'Vertical Align', 'magee-shortcodes'),
                    'desc' => __( 'Content vertical align.', 'magee-shortcodes'),
                    'options' => array(
                        'middle' => __('Middle', 'magee-shortcodes'),
                        'top' => __('Top', 'magee-shortcodes'),
                        'bottom' => __('Bottom', 'magee-shortcodes'),
                    )
                ),
                
                'zoom_effect' => array(
                    'type' => 'select',
                    'label' => __( 'Zoom Effect', 'magee-shortcodes'),
                    'desc' => __( 'Image zoom effect.', 'magee-shortcodes'),
                    'options' => array(
                        'in' => __('In', 'magee-shortcodes'),
                        'out' => __('Out', 'magee-shortcodes'),
                    )
                ),
                
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
                
                'content' => array(
                        'std' => '',
                        'type' => 'textarea',
                        'label' => __( 'Content', 'magee-shortcodes'),
                    )
            ),

            'shortcode' => '[ms_image_banner image="{{image}}" link="{{link}}" target="{{target}}" horizontal_align="{{horizontal_align}}" vertical_align="{{vertical_align}}" zoom_effect="{{zoom_effect}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_image_banner]',
            'popup_title' => __( 'Image Banner Shortcode', 'magee-shortcodes'),

        );

        /*-----------------------------------------------------------------------------------*/
        /*	Image Compare Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['image_compare'] = array(
            'no_preview' => false,
            'icon' => 'fa-file-image-o',
            'params' => array(
                'style' => array(
                    'type' => 'select',
                    'std' => 'horizontal',
                    'label' => __( 'Style', 'magee-shortcodes'),
                    'desc' => __( 'Select how the image compare display.', 'magee-shortcodes'),
                    'options' => array(
                        'horizontal' => __('Horizontal','magee-shortcodes'),
                        'vertical' => __('Vertical','magee-shortcodes')
                    )
                ),
                'percent' => array(
                    'type' => 'select',
                    'std' => '0.5',
                    'label' => __( 'Percent', 'magee-shortcodes'),
                    'desc' => __( 'Choose default offset pct', 'magee-shortcodes'),
                    'options' => $opacity
                ),
                'image_left' => array(
                    'std' => '',
                    'type' => 'uploader',
                    'label' => __( 'Image Left', 'magee-shortcodes' ),
                    'desc' => __( 'Insert the image displayed in the left.', 'magee-shortcodes')
                ),
                'image_right' => array(
                    'std' => '',
                    'type' => 'uploader',
                    'label' => __( 'Image Right', 'magee-shortcodes' ),
                    'desc' => __( 'Insert the image displayed in the right.', 'magee-shortcodes')
                ),
                'before_label' => array(
                    'std' => __( 'Before', 'magee-shortcodes' ),
                    'type' => 'text',
                    'label' => __( 'Before Label', 'magee-shortcodes' ),
                    'desc' => __( 'Set a custom before label.', 'magee-shortcodes')
                ),
                'after_label' => array(
                    'std' => __( 'After', 'magee-shortcodes' ),
                    'type' => 'text',
                    'label' => __( 'After Label', 'magee-shortcodes' ),
                    'desc' => __( 'Set a custom after label.', 'magee-shortcodes')
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                        'std' => '',
                        'type' => 'text',
                        'label' => __( 'CSS ID', 'magee-shortcodes' ),
                        'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),    
            ),
            'shortcode' => '[ms_image_compare style="{{style}}" percent="{{percent}}" image_left="{{image_left}}" image_right="{{image_right}}" before_label="{{before_label}}" after_label="{{after_label}}" class="{{class}}" id="{{id}}"]',
            'popup_title' => __( 'Image Compare Shortcode', 'magee-shortcodes' ),
            'name' => __('image-compare-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Image Frame Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['image_frame'] = array(
            'icon' => 'fa-file-image-o',
            'no_preview' => true,
            'params' => array(

            'src' => array(
                    'type' => 'uploader',
                    'label' => __( 'Image', 'magee-shortcodes' ),
                    'desc' => __( 'Upload an image to display.', 'magee-shortcodes' ),
                ),
                'link' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Image Link URL', 'magee-shortcodes' ),
                    'desc' => __( 'Add the URL the picture will link to, ex: http://example.com.', 'magee-shortcodes' ),
                ),
            'link_target' => array(
                    'std' => '_self',
                    'type' => 'choose',
                    'label' => __( 'Link Target', 'magee-shortcodes' ),
                    'desc' => __( '_self = open in same window _blank = open in new window.', 'magee-shortcodes' ),
                    'options' => array(
                        '_blank' => __('_blank', 'magee-shortcodes'),
                        '_self' => __('_self', 'magee-shortcodes'),
                
                    ),
                    ),
            'border_radius' => array(
                    'std' => '0',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0' ,
                    'label' => __( 'Border Radius', 'magee-shortcodes' ),
                    'desc' => __( 'Choose the border radius of the image frame. In pixels (px), ex: 1px, or "round".  Leave blank for theme option selection.', 'magee-shortcodes' ), 	         
                ),	
            'light_box' => array(
                    'std' => '',
                    'type' => 'choose' ,
                    'label' => __( 'Light Box','magee-shortcodes'),
                    'desc' => __( 'Choose to display light box once click.', 'magee-shortcodes'),
                    'options' => $reverse_choices	
                ),	
            'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
            'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),			

            ),
            'shortcode' => '[ms_image_frame src="{{src}}" border_radius="{{border_radius}}" link="{{link}}" link_target="{{link_target}}" light_box="{{light_box}}" class="{{class}}" id="{{id}}"]',
            'popup_title' => __( 'Image Frame Shortcode', 'magee-shortcodes' ),
            'name' => __('image-frame-shortcode/','magee-shortcodes'),
        );


        /*-----------------------------------------------------------------------------------*/
        /*	Label Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['label'] = array(
            'no_preview' => false,
            'icon' => 'fa-bookmark',    
            'params' => array(
                
                'content' => array(
                    'std' => __( 'Label Text', 'magee-shortcodes' ),
                    'type' => 'text',
                    'label' => __( 'Text', 'magee-shortcodes' ),
                    'desc' => __( 'Insert text to be displayed in label.','magee-shortcodes')
                ),  
                'background_color' => array(
                    'std' => '#fdd200',
                    'type' => 'colorpicker',
                    'label' => __( 'Background Color' , 'magee-shortcodes'),
                    'desc' => __( 'Set background color for label.','magee-shortcodes')
                ),
                'text_color' => array(
                    'std' => '#ffffff',
                    'type' => 'colorpicker',
                    'label' => __( 'Text Color' , 'magee-shortcodes'),
                    'desc' => __( 'Set text color for label.','magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_label background_color="{{background_color}}" text_color="{{text_color}}"]{{content}}[/ms_label]',
            'popup_title' => __( 'Label Shortcode', 'magee-shortcodes' ),
            'name' => __('label-shortcode/','magee-shortcodes'), 
        );

        /*******************************************************
        *	List Config
        ********************************************************/
        $magee_shortcodes['list'] = array(
            'no_preview' => false,
            'icon' => 'fa-list',
            'params' => array(
                'item_border' => array(
                    'type' => 'choose',
                    'label' => __( 'Item Border', 'magee-shortcodes' ),
                    'desc' => __( 'Choose to display item border for list.', 'magee-shortcodes'),
                    'options' =>array(
                        'no' => __('No','magee-shortcodes'),
                        'yes' => __('Yes','magee-shortcodes'),)
                    ),
                'item_size' => array(
                    'type' => 'number',
                    'std'  => '12',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Item Size', 'magee-shortcodes' ),
                    'desc' => __( 'Set text font size for item.', 'magee-shortcodes'),
                    ),
                'icon_a' => array(
                        'std' => 'fa-hand-o-right',
                        'type' => 'iconpicker',
                        'label' => __( 'Global Icon', 'magee-shortcodes' ),
                        'desc' => __( 'Click an icon to select, click again to deselect. Set this icon to replace all single li icon settings.', 'magee-shortcodes' ),
                        'options' => $icons
                ),
                'icon_color_a' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Icon Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color fo list icon.', 'magee-shortcodes')
                    ),
                'icon_boxed_a' => array(
                    'type' => 'choose',
                    'label' => __( 'Icon Boxed', 'magee-shortcodes' ),
                    'desc' => __( 'Choose to set icon boxed.', 'magee-shortcodes'),
                    'options' =>array(
                        'no' => __('No','magee-shortcodes'),
                        'yes' => __('Yes','magee-shortcodes'),)
                    ),
                'background_color_a' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Icon Circle Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background color for list icon.', 'magee-shortcodes')
                ),
                'boxed_shape_a' => array(
                    'type' => 'select',
                    'label' => __( 'Boxed Shape', 'magee-shortcodes' ),
                    'desc' => __( 'Choose boxed shape for list icon.', 'magee-shortcodes'),
                    'options' =>array(
                        'square' => __('Square','magee-shortcodes'),
                        'circle' => __('Circle','magee-shortcodes'),)
                    ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),	
            ),
            'shortcode' => "[ms_list item_border=\"{{item_border}}\" item_size=\"{{item_size}}\" icon_a=\"{{icon_a}}\" icon_color_a=\"{{icon_color_a}}\" icon_boxed_a=\"{{icon_boxed_a}}\" background_color_a=\"{{background_color_a}}\" boxed_shape_a=\"{{boxed_shape_a}}\" class=\"{{class}}\" id=\"{{id}}\"]\r\n{{child_shortcode}}[/ms_list]",
            'child_shortcode' => array(
                'params' => array(
                    'icon' => array(
                    'type' => 'iconpicker',
                    'label' => __( 'Icon', 'magee-shortcodes' ),
                    'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                    'options' => $icons
                    ),
                    'icon_color' => array(
                        'type' => 'colorpicker',
                        'label' => __( 'Icon Color', 'magee-shortcodes' ),
                        'desc' => __( 'Set color fo list icon.', 'magee-shortcodes')
                        ),
                    'icon_boxed' => array(
                        'type' => 'choose',
                        'label' => __( 'Icon Boxed', 'magee-shortcodes' ),
                        'desc' => __( 'Choose to set icon boxed.', 'magee-shortcodes'),
                        'options' =>array(
                            'no' => __('No','magee-shortcodes'),
                            'yes' => __('Yes','magee-shortcodes'),)
                        ),
                    'background_color' => array(
                        'type' => 'colorpicker',
                        'label' => __( 'Icon Circle Background Color', 'magee-shortcodes' ),
                        'desc' => __( 'Set background color for list icon.', 'magee-shortcodes')
                    ),
                    'boxed_shape' => array(
                        'type' => 'select',
                        'label' => __( 'Boxed Shape', 'magee-shortcodes' ),
                        'desc' => __( 'Choose boxed shape for list icon.', 'magee-shortcodes'),
                        'options' =>array(
                            'square' => __('Square','magee-shortcodes'),
                            'circle' => __('Circle','magee-shortcodes'),)
                        ),
                    'content' => array(
                        'std' => 'list item',
                        'type' => 'text',
                        'label' => __( 'Title', 'magee-shortcodes'),
                        'desc' =>  __( 'Insert title for list item.', 'magee-shortcodes')
                        ),
            ),		
            'shortcode' => "[ms_list_item icon=\"{{icon}}\" icon_color=\"{{icon_color}}\" icon_boxed=\"{{icon_boxed}}\" background_color=\"{{background_color}}\" boxed_shape=\"{{boxed_shape}}\"]{{content}}[/ms_list_item]\r\n",
            ),	
            'popup_title' => __( 'List Shortcode', 'magee-shortcodes' ),
            'name' => __('list-shortcode/','magee-shortcodes'),
        );

        /*******************************************************
        *	Modal Config
        ********************************************************/

        $magee_shortcodes['modal'] = array(
            'no_preview' => false,
            'icon' => 'fa-comment-o',
            'params' => array(
                'modal_anchor_text' => array(
                    'std' => 'Modal Anchor Text',
                    'type' => 'textarea',
                    'label' => __( 'Modal Anchor Text', 'magee-shortcodes' ),
                    'desc' => __( 'Insert anchor text for the modal.', 'magee-shortcodes' ),
                ),
                'effect' => array(
                    'std' => 'effect-1',
                    'type' => 'select',
                    'label' => __( 'Modal Show Effect', 'magee-shortcodes' ),
                    'desc' => __( 'Choose one effect to show the modal.', 'magee-shortcodes' ),
                    'options' => array(	    
                        'effect-1' => __('Effect 1 ( Slide Right )','magee-shortcodes'),
                        'effect-2' => __('Effect 2 ( Slide Bottom )','magee-shortcodes'),
                        'effect-3' => __('Effect 3 ( Slide Left )','magee-shortcodes'),
                        'effect-4' => __('Effect 4 ( Slide Top )','magee-shortcodes'),
                        'effect-5' => __('Effect 5 ( Scale Up )','magee-shortcodes'),
                        'effect-6' => __('Effect 6 ( 3D Flip Horizontal )','magee-shortcodes'),
                        'effect-7' => __('Effect 7 ( 3D Flip Vertical )','magee-shortcodes'),
                        'effect-8' => __('Effect 8 ( 3D Sign )','magee-shortcodes'),
                        'effect-9' => __('Effect 9 ( 3D Rotate In Left )','magee-shortcodes'),
                        'effect-10' => __('Effect 10 ( 3D Rotate In Bottom )','magee-shortcodes'),
                        'effect-11' => __('Effect 11 ( 3D Slit )','magee-shortcodes'),
                        'effect-12' => __('Effect 12 ( Newspaper )','magee-shortcodes'),
                        'effect-13' => __('Effect 13 ( Fall )','magee-shortcodes'),
                        'effect-14' => __('Effect 14 ( Side Fall )','magee-shortcodes'),
                        'effect-15' => __('Effect 15 ( Super Scaled )','magee-shortcodes'),
                    ),
                ),
                'title' => array(
                    'std' => __( 'Modal Title', 'magee-shortcodes' ),
                    'type' => 'text',
                    'label' => __( 'Modal Heading Title', 'magee-shortcodes' ),
                    'desc' => __( 'Insert heading title for the modal.', 'magee-shortcodes' ),
                ),	
                'title_color' => array(
                    'std' => '#ffffff',
                    'type' => 'colorpicker',
                    'label' => __( 'Modal Heading Title Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for the modal heading title.', 'magee-shortcodes' ),
                ),	
                'heading_background' => array(
                    'std' => 'rgba(0,0,0,.05)',
                    'type' => 'colorpicker',
                    'label' => __( 'Modal Heading Background', 'magee-shortcodes' ),
                    'desc' => __( 'Set background for the modal heading.', 'magee-shortcodes' ),
                ),
                'close_icon' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __( 'Close Icon', 'magee-shortcodes' ),
                    'desc' => __( 'Choose close icon to show in modal heading.', 'magee-shortcodes' ), 
                    'options' => $choices
                ),	
                'content' => array(
                    'std' => __('Your Content Goes Here', 'magee-shortcodes'),
                    'type' => 'textarea',
                    'label' => __( 'Contents of Modal', 'magee-shortcodes' ),
                    'desc' => __( 'Add your content to be displayed in modal.', 'magee-shortcodes' ),
                ),
                'background' => array(
                    'std' => '#e74c3c',
                    'type' => 'colorpicker',
                    'label' => __( 'Modal Background', 'magee-shortcodes' ),
                    'desc' => __( 'Set background for the modal.', 'magee-shortcodes' ),
                ),
                'color' => array(
                    'std' => '#ffffff',
                    'type' => 'colorpicker',
                    'label' => __( 'Modal Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for the modal.', 'magee-shortcodes' ),
                ),
                'width' => 	array(
                    'std' => '',
                    'type' => 'number',
                    'label' => __( 'Modal Width', 'magee-shortcodes' ),
                    'desc' => '', 
                    'min'  => '0',
                    'max'  => '1000'
                ),	
                'height' => 	array(
                    'std' => '',
                    'type' => 'number',
                    'label' => __( 'Modal Height', 'magee-shortcodes' ),
                    'desc' => '', 
                    'min'  => '0',
                    'max'  => '500'
                ),	
                'overlay_color' => array(
                    'std' => '#999999',
                    'type' => 'colorpicker',
                    'label' => __( 'Overlay Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background color for the modal overlay.', 'magee-shortcodes' ),
                ),
                'overlay_opacity' => array(
                    'std' => '0.5',
                    'type' => 'select',
                    'label' => __( 'Overlay Color Opacity', 'magee-shortcodes' ),
                    'desc' => __( 'Choose background color opacity for the modal overlay.', 'magee-shortcodes' ),
                    'options' => $opacity
                ),	
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),			
            ),
            'shortcode' => "[ms_modal effect=\"{{effect}}\" title=\"{{title}}\" title_color=\"{{title_color}}\" heading_background=\"{{heading_background}}\" close_icon =\"{{close_icon}}\" background=\"{{background}}\" color=\"{{color}}\" width=\"{{width}}\" height=\"{{height}}\" overlay_color=\"{{overlay_color}}\" overlay_opacity=\"{{overlay_opacity}}\" class=\"{{class}}\" id=\"{{id}}\"]\r\n[ms_modal_anchor_text]{{modal_anchor_text}}[/ms_modal_anchor_text]\r\n[ms_modal_content]{{content}}[/ms_modal_content]\r\n[/ms_modal]",
            'popup_title' => __( 'Modal Shortcode', 'magee-shortcodes' ),
            'name' => __('modal-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Menu Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['menu'] = array(
            'no_preview' => false,
            'icon' => 'fa-bars',
            'params' => array(
                'menu' => array(
                    'std' => '',
                    'type' => 'select',
                    'label' => __( 'Select a menu','magee-shortcodes'),
                    'options' =>  Helper::shortcode_menus('name') 
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_menu menu="{{menu}}" class="{{class}}" id="{{id}}"]' ,
            'popup_title' => __( 'Menu Shortcode', 'magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /* Magee Separator Config
        /*-----------------------------------------------------------------------------------*/
        /*
        $magee_shortcodes['separator'] = array(
            'no_preview' => true,
            'params' => array(
                'style' => array(
                    'std' => '',
                    'type' => 'select',
                    'label' => __( 'Style', 'magee-shortcodes'),
                    'desc' => '',
                    'options' => array(
                        'bigTriangleColor' => __('bigTriangleColor', 'magee-shortcodes'),
                        'curveUpColor' => __('curveUpColor', 'magee-shortcodes'),
                        'curveDownColor' => __('curveDownColor', 'magee-shortcodes'),
                        'bigHalfCircle' => __('bigHalfCircle', 'magee-shortcodes'),
                        'bigTriangleShadow' => __('bigTriangleShadow', 'magee-shortcodes'),
                        'slit' => __('Slit', 'magee-shortcodes'),
                        'stamp' => __('Stamp', 'magee-shortcodes'),
                        'clouds' => __('Clouds', 'magee-shortcodes'),
                    )
                ),		
                'height' => array(
                    'std' => '100',
                    'type' => 'text',
                    'label' => __( 'Height', 'magee-shortcodes'),
                    'desc' =>'',
                ),	
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                
            ),),
            'shortcode' => '[ms_separator style="{{style}}" height="{{height}}" class="{{class}}"]',
            'popup_title' => __( 'Separator', 'magee-shortcodes')
            
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Panel Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['panel'] = array(
            'no_preview' => false,
            'icon' => 'fa-list-alt',
            'params' => array(
                
                'title' => array(
                    'std' =>  __( 'Panel Title', 'magee-shortcodes' ),
                    'type' => 'text',
                    'label' => __( 'Title', 'magee-shortcodes' ),
                    'desc' => __( 'Insert title for panel.', 'magee-shortcodes' ),
                ),
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    'type' => 'textarea',
                    'label' => __( 'Panel Content', 'magee-shortcodes' ),
                    'desc' => __( 'Insert content for panel.', 'magee-shortcodes' ),
                ),
                
                
                'title_color' => array(
                    'std' => '#000000',
                    'type' => 'colorpicker',
                    'label' => __( 'Title Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for panel title.', 'magee-shortcodes' ),
                ),
                'border_color' => array(
                    'std' => '#dddddd',
                    'type' => 'colorpicker',
                    'label' => __( 'Border Color', 'magee-shortcodes' ),
                    'desc' =>  __( 'Set color for panel border.', 'magee-shortcodes' ),
                ),
                'border_width' => array(
                    'std' => '1',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Border Width', 'magee-shortcodes' ),
                    'desc' => __('In pixels (px), eg: 1px.', 'magee-shortcodes')
                ),	
                'title_background_color' => array(
                    'std' => '#f5f5f5',
                    'type' => 'colorpicker',
                    'label' => __( 'Title Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background color for panel title.', 'magee-shortcodes' ),
                ),		
                'border_radius' => array(
                    'std' => '0',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Border Radius', 'magee-shortcodes' ),
                    'desc' => __('In pixels (px), eg: 1px.', 'magee-shortcodes')
                ),				
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),		
            ),
            'shortcode' => '[ms_panel title="{{title}}" title_color="{{title_color}}" border_color="{{border_color}}"  title_background_color="{{title_background_color}}" border_radius="{{border_radius}}"  class="{{class}}" id="{{id}}"]{{content}}[/ms_panel]',
            'popup_title' => __( 'Panel Shortcode', 'magee-shortcodes' ),
            'name' => __('panel-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Person Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['person'] = array(
            'no_preview' => false,
            'icon' => 'fa-user',
            'params' => array(
                'style' => array(
                    'std' => '',
                    'type' => 'select',
                    'label' => __( 'Style', 'magee-shortcodes'),
                    'desc' => __( 'Choose to display info below or beside the image.','magee-shortcodes'),
                    'options' => array(
                        'below' => __('Below', 'magee-shortcodes')  ,
                        'beside' => __('Beside', 'magee-shortcodes'),
                    ),
                ),
                'name' => array(
                    'std' => 'John K.',
                    'type' => 'text',
                    'label' => __( 'Name', 'magee-shortcodes' ),
                    'desc' => __( 'Insert the name of the person.', 'magee-shortcodes' ),
                ),
                'title' => array(
                    'std' => __( 'Software Engineer', 'magee-shortcodes' ),
                    'type' => 'text',
                    'label' => __( 'Title', 'magee-shortcodes' ),
                    'desc' => __( 'Insert the title of the person', 'magee-shortcodes' ),
                ),
                'link_target' => array(
                    'std' => '_blank',
                    'type' => 'choose',
                    'label' => __( 'Link Target', 'magee-shortcodes' ),
                    'desc' => __( '_self = open in same window _blank = open in new window.', 'magee-shortcodes' ),
                    'options' => array(
                        '_blank' => __('_blank', 'magee-shortcodes'),
                        '_self' => __('_self', 'magee-shortcodes'),
                
                    ),
                    ),
                'overlay_color' => array(
                    'std' => '',
                    'type' => 'colorpicker',
                    'label' => __('Image Overlay Color','magee-shortcodes'),
                    'desc' => __('Select a hover color to show over the image as an overlay.','magee-shortcodes')
                ),	
                'overlay_opacity' => array(
                    'std' => '0.5',
                    'type' => 'select',
                    'label' => __('Image Overlay Opacity', 'magee-shortcodes'),
                    'desc' => __('Opacity ranges between 0 (transparent) and 1 (opaque). ex: .5','magee-shortcodes'),
                    'options' => $opacity
                ),
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
                    'type' => 'textarea',
                    'label' => __( 'Profile Description', 'magee-shortcodes' ),
                    'desc' => __( 'Insert profile description.', 'magee-shortcodes' )
                ),
                'picture' => array(
                    'std' => MAGEE_SHORTCODES_URL.'/assets/images/avatar.jpg',
                    'type' => 'uploader',
                    'label' => __( 'Picture', 'magee-shortcodes' ),
                    'desc' => __( 'Upload an image to display.', 'magee-shortcodes' ),
                ),
                'piclink' => array(
                    'std' => '#',
                    'type' => 'text',
                    'label' => __( 'Picture Link URL', 'magee-shortcodes' ),
                    'desc' => __( 'Add the URL the picture will link to, ex: http://example.com.', 'magee-shortcodes' ),
                ),
                'picborder' => array(
                    'std' => '0',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Picture Border Size', 'magee-shortcodes' ),
                    'desc' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 'magee-shortcodes' ),
                ),
                'picbordercolor' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Picture Border Color', 'magee-shortcodes' ),
                    'desc' => __( 'Controls the picture\'s border color. Leave blank for theme option selection.', 'magee-shortcodes' ),
                ),
                'picborderradius' => array(
                    'std' => '0',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Picture Border Radius', 'magee-shortcodes' ),
                    'desc' => __( 'Choose the border radius of the person image. In pixels (px), ex: 1px, or "round".  Leave blank for theme option selection.', 'magee-shortcodes' ),
                ),				
                'iconboxedradius' => array(
                    'std' => '4',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Social Icon Box Radius', 'magee-shortcodes' ),
                    'desc' => __( 'Choose the border radius of the boxed icons. In pixels (px), ex: 1px, or "round". Leave blank for theme option selection.', 'magee-shortcodes' ),
                ),		
                'iconcolor' => array(
                    'std' => '',
                    'type' => 'colorpicker',
                    'label' => __( 'Social Icon Custom Colors', 'magee-shortcodes' ),
                    'desc' => __( 'Controls the Icon\'s border color. Leave blank for theme option selection.', 'magee-shortcodes' ),
                ),
                'icon1' => array(
                        'std' => 'fa-facebook',
                        'type' => 'icon',
                        'label' => __( 'Icon1', 'magee-shortcodes' ),
                        'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                        'options' => $icons
                    ),
                'link1' => array(
                    'std' => '#',
                    'type' => 'text',
                    'label' => __( 'Link1 ', 'magee-shortcodes' ),
                    'desc' => __( 'The Icon1 Link ', 'magee-shortcodes' ),
                ),
                'icon2' => array(
                        'std' => 'fa-twitter',
                        'type' => 'icon',
                        'label' => __( 'Icon2', 'magee-shortcodes' ),
                        'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                        'options' => $icons
                    ),
                'link2' => array(
                    'std' => '#',
                    'type' => 'text',
                    'label' => __( 'Link2 ', 'magee-shortcodes' ),
                    'desc' => __( 'The Icon2 Link ', 'magee-shortcodes' ),
                ),
                'icon3' => array(
                        'std' => 'fa-linkedin',
                        'type' => 'icon',
                        'label' => __( 'Icon3', 'magee-shortcodes' ),
                        'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                        'options' => $icons
                    ),
                'link3' => array(
                    'std' => '#',
                    'type' => 'text',
                    'label' => __( 'Link3 ', 'magee-shortcodes' ),
                    'desc' => __( 'The Icon3 Link ', 'magee-shortcodes' ),
                ),
                'icon4' => array(
                        'type' => 'icon',
                        'label' => __( 'Icon4', 'magee-shortcodes' ),
                        'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                        'options' => $icons
                    ),
                'link4' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Link4', 'magee-shortcodes' ),
                    'desc' => __( 'The Icon4 Link ', 'magee-shortcodes' ),
                ),
                'icon5' => array(
                        'type' => 'icon',
                        'label' => __( 'Icon5', 'magee-shortcodes' ),
                        'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                        'options' => $icons
                    ),
                'link5' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Link5', 'magee-shortcodes' ),
                    'desc' => __( 'The Icon5 Link ', 'magee-shortcodes' ),
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),
            ),
            'shortcode' => '[ms_person name="{{name}}" style="{{style}}" title="{{title}}" link_target="{{link_target}}" overlay_color="{{overlay_color}}" overlay_opacity="{{overlay_opacity}}" picture="{{picture}}" piclink="{{piclink}}" picborder="{{picborder}}" picbordercolor="{{picbordercolor}}" picborderradius="{{picborderradius}}" iconboxedradius="{{iconboxedradius}}" iconcolor="{{iconcolor}}" icon1="{{icon1}}" icon2="{{icon2}}" icon3="{{icon3}}" icon4="{{icon4}}" icon5="{{icon5}}" link1="{{link1}}" link2="{{link2}}" link3="{{link3}}" link4="{{link4}}" link5="{{link5}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_person]',
            'popup_title' => __( 'Person Shortcode', 'magee-shortcodes' ),
            'name' => __('person-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Piechart Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['piechart'] = array(
            'no_preview' => false,
            'icon' => 'fa-circle-o-notch',
            'params' => array(
            'line_cap' => array(
                    'std' => 'round',
                    'type' => 'select',
                    'label' => __( 'Line Cap', 'magee-shortcodes' ),
                    'desc' => __( 'Select how the ending of the bar line looks like.', 'magee-shortcodes' ),
                    'options' => array(
                        'round' => __( 'Round','magee-shortcodes') ,
                        'butt' => __( 'Butt','magee-shortcodes') ,
                        'square' => __( 'Square','magee-shortcodes') ,
                    ),  
                ),
            'percent' => array(
                    'std' => '80',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Percent', 'magee-shortcodes' ),
                    'desc' => __( 'From 1 to 100.', 'magee-shortcodes' ),

                ),
            
            
            'content' => array(
                    'std' => '80%',
                    'type' => 'textarea',
                    'label' => __( 'Title', 'magee-shortcodes' ),
                    'desc' => __( 'Insert title for piechart. It need to be short.', 'magee-shortcodes' ),

                ),
            'size' => array(
                    'std' => '200',
                    'type' => 'number',
                    'max' => '500',
                    'min' => '0',
                    'label' => __( 'Size', 'magee-shortcodes' ),
                    'desc' => __( 'Set size for piechart.', 'magee-shortcodes' ),

                ),
            'font_size' => array(
                    'std' => '40',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Font Size', 'magee-shortcodes' ),
                    'desc' => __( 'Set font size for piechart title.', 'magee-shortcodes' ),

                ),
            'filledcolor' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Filled Color', 'magee-shortcodes' ),
                    'desc' =>  __( 'Set color for filled area in piechart.', 'magee-shortcodes' ),
                    'std' => '#fdd200'
                ),
            'unfilledcolor' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Unfilled Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for unfilled area in piechart.', 'magee-shortcodes' ),
                    'std' => '#f5f5f5'
                ),
            
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
            
            ), 
            'shortcode' => '[ms_piechart line_cap="{{line_cap}}" percent="{{percent}}"  filledcolor="{{filledcolor}}" size="{{size}}" font_size="{{font_size}}" unfilledcolor="{{unfilledcolor}}" class="{{class}}" ]{{content}}[/ms_piechart]',
            'popup_title' => __( 'Piechart Shortcode', 'magee-shortcodes' ),
            'name' => __('piechart-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Popover Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['popover'] = array(
            'no_preview' => false,
            'icon' => 'fa-comment-o',
            'params' => array(
                'title' => array(
                    'std' => 'Popover Heading',
                    'type' => 'text',
                    'label' => __( 'Popover Heading', 'magee-shortcodes' ),
                    'desc' => __( 'Insert heading text of the popover.', 'magee-shortcodes' ),
                ),
                'triggering_text' => array(
                    'std' => 'Triggering Text',
                    'type' => 'textarea',
                    'label' => __( 'Triggering Text', 'magee-shortcodes' ),
                    'desc' => __( 'Content that will trigger the popover.', 'magee-shortcodes' ),
                ),
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
                    'type' => 'textarea',
                    'label' => __( 'Contents Inside Popover', 'magee-shortcodes' ),
                    'desc' => __( 'Text to be displayed inside the popover.', 'magee-shortcodes' ),
                ),

                'trigger' => array(
                    'type' => 'select',
                    'label' => __( 'Popover Trigger Method', 'magee-shortcodes' ),
                    'desc' => __( 'Choose mouse action to trigger popover.', 'magee-shortcodes' ),
                    'options' => array(
                        'click' => __('Click', 'magee-shortcodes'),
                        'hover' => __('Hover', 'magee-shortcodes'),
                    )
                ),
                'placement' => array(
                    'type' => 'select',
                    'std' => 'bottom',
                    'label' => __( 'Popover Position', 'magee-shortcodes' ),
                    'desc' => __( 'Choose the display position of the popover.', 'magee-shortcodes' ),
                    'options' => array(
                        'top' => __('Top', 'magee-shortcodes'),
                        'bottom' => __('Bottom', 'magee-shortcodes'),
                        'left' => __('Left', 'magee-shortcodes'),
                        'right' => __('Right', 'magee-shortcodes'),
                    )
                ),
            
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),			
            ),
            'shortcode' => '[ms_popover title="{{title}}" triggering_text="{{triggering_text}}" trigger="{{trigger}}" placement="{{placement}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_popover]', // as there is no wrapper shortcode
            'popup_title' => __( 'Popover Shortcode', 'magee-shortcodes' ),
            'name' => __('popover-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Portfolio Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['portfolio'] = array(
            'no_preview' => false,
            'icon' => 'fa-th',
            'params' => array(
            
            'num' => array(
                    'std' => '10',
                    'min' => '0',
                    'max' => '100',
                    'type' => 'number',
                    'label' => __( 'List Num', 'magee-shortcodes'),
                    'desc' => __( 'Set list number for portfolios.', 'magee-shortcodes'),
                ),
            'category' => array(
                    'type' => 'select',
                    'label' => __( 'Category', 'magee-shortcodes'),
                    'desc' => __( 'Choose a category to display.', 'magee-shortcodes'),
                    'options' => $magee_portfolios_cats
                ),
            'layout' => array(
                    'type' => 'select',
                    'label' => __( 'Layout','magee-shortcodes'),
                    'desc' => __( 'Choose to display portfolios in grid or carousel layout.', 'magee-shortcodes'),
                    'options' => array(
                        'grid' => __( 'Grid','magee-shortcodes'),
                        'carousel' => __( 'Carousel','magee-shortcodes'),
                    )
            ),
            'style' => array(
                    'std' => 1,
                    'type' => 'select',
                    'label' => __( 'Style', 'magee-shortcodes'),
                    'desc' => __( 'Choose to display portfolios in normal/full style.', 'magee-shortcodes'),
                    'options' => array( 
                        '1' => __( 'Normal Style', 'magee-shortcodes'),
                        '2' => __( 'Full Width', 'magee-shortcodes'),
                    )
                ),
            'columns' => array(
                    'type' => 'select',
                    'label' => __( 'Columns', 'magee-shortcodes'),
                    'desc' => __( 'Choose column number for portfolio list.', 'magee-shortcodes'),
                    'std' => '3',
                    'options' => array( 
                        '2' => __( '2 Columns', 'magee-shortcodes'),
                        '3' => __( '3 Columns', 'magee-shortcodes'),
                        '4' => __( '4 Columns', 'magee-shortcodes'),
                        '5' => __( '5 Columns', 'magee-shortcodes'),
                        '6' => __( '6 Columns', 'magee-shortcodes')
                    )
                ),
                    
            
            'overlay_content' => array(
                    'type' => 'select',
                    'label' => __( 'Overlay Content', 'magee-shortcodes'),
                    'desc' =>  __( 'Select overlay content for portfolios.', 'magee-shortcodes'),
                    'options' => array( 
                        '1' => __( 'Button', 'magee-shortcodes'), 
                        '2' => __( 'Title', 'magee-shortcodes'),
                        '3' => __( 'Title & Tags', 'magee-shortcodes'),
                        '4' => __( 'Link Light', 'magee-shortcodes'),
                        '5' => __( 'Image Zoom In', 'magee-shortcodes'),
                    )
                                    
                ),
            
            'overlay_color' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Overlay Color', 'magee-shortcodes'),
                    'desc' => __( 'Set overlay background color.', 'magee-shortcodes')
                    ),	
            'overlay_opacity' => array(
                    'type' => 'select',
                    'std' => '0.5',
                    'label' => __( 'Overlay Opacity', 'magee-shortcodes'),
                    'desc' => '',
                    'options' => $opacity
                ),
                    
            'orientation' => array(
                    'std' => 'top',
                    'type' => 'select',
                    'label' => __( 'Orientation', 'magee-shortcodes'),
                    'desc' =>  __( 'Select orientation for overlay animation.', 'magee-shortcodes'),
                    'options' => array( 
                        'top' => __('Top','magee-shortcodes'), 
                        'left' => __('Left','magee-shortcodes'),
                        'right' => __('Right','magee-shortcodes'),
                        'bottom' => __('Bottom','magee-shortcodes')
                    )
                                    
                ),
            'page_nav' => array(
                    'type' => 'choose',
                    'label' => __( 'Display Page Nav', 'magee-shortcodes'),
                    'desc' => __( 'Choose to display page navigation for portolio list.', 'magee-shortcodes'),
                    'options' => $reverse_choices
                ),
            'filter' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __( 'Filter', 'magee-shortcodes'),
                    'desc' => __( 'Choose to display filter for portolio list.', 'magee-shortcodes'),
                    'options' => $reverse_choices
                ),
            'offset' => array(
                    'std' => '',
                    'type' => 'text', 
                    'label' => __( 'Post Offset','magee-shortcodes'),
                    'desc' => __( 'Choose to display filter for portolio list.eg:1.','magee-shortcodes')
                ),
            'exclude_category' => array(
                    'type' => 'select',
                    'label' => __( 'Exclude Categories','magee-shortcodes'),
                    'desc' => __( 'Select a category to exclude.','magee-shortcodes'),
                    'options' => $magee_portfolios_cats
                ),		
            'align' => array(
                    'std' => 'left',
                    'type' => 'select',
                    'label' => __( 'Info Align','magee-shortcodes'),
                    'desc' => __( 'Set align of portoflio info.','magee-shortcodes'),
                    'options' => array(
                        'left' => __( 'Left','magee-shortcodes'),
                        'center' => __( 'Center','magee-shortcodes'),
                        'right' => __( 'Right','magee-shortcodes'),
                    )
                ),	
            'display_title' => array(
                    'std'=> 'yes',
                    'type' => 'choose',
                    'label' => __( 'Display Title','magee-shortcodes'),
                    'desc' => __( 'Choose to display the portfolio title below the featured image','magee-shortcodes'),
                    'options' => $choices	
                ),		
            'display_tags' => array(
                    'std'=> 'no',
                    'type' => 'choose',
                    'label' => __( 'Display Tags','magee-shortcodes'),
                    'desc' => __( 'Choose to show portfolio tags.','magee-shortcodes'),
                    'options' => $choices
                ),	
            'display_excerpt' => array(
                    'std'=> 'no',
                    'type' => 'choose',
                    'label' => __( 'Display Excerpt','magee-shortcodes'),
                    'desc' => __( 'Choose to display the portfolio excerpt.','magee-shortcodes'),
                    'options' => $choices
                ),	
            'excerpt_length' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Excerpt Length','magee-shortcodes'),
                    'desc' => __( 'Insert the number of words/characters you want to show in the excerpt.','magee-shortcodes')
                ),	
            'strip' => array(
                    'std'=> 'yes',
                    'type' => 'choose',
                    'label' => __( 'Strip HTML','magee-shortcodes'),
                    'desc' => __( 'Strip HTML from the post excerpt','magee-shortcodes'),
                    'options' => $choices
                ),				
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                )
                
                
            ),
            'shortcode' => '[ms_portfolio num="{{num}}" category="{{category}}" layout="{{layout}}" style="{{style}}" columns="{{columns}}" overlay_content="{{overlay_content}}" overlay_color="{{overlay_color}}" overlay_opacity="{{overlay_opacity}}" orientation="{{orientation}}" page_nav="{{page_nav}}" filter="{{filter}}" offset="{{offset}}" exclude_category="{{exclude_category}}" align="{{align}}" display_title="{{display_title}}" display_tags="{{display_tags}}" display_excerpt="{{display_excerpt}}" excerpt_length="{{excerpt_length}}" strip ="{{strip}}" class="{{class}}" id="{{id}}"]',
            'popup_title' => __( 'Portfolio Shortcode', 'magee-shortcodes')
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Pricing Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['pricing'] = array(
            'icon' => 'fa-money' ,
            'no_preview' => false,
            'params' => array(
                            
                'style' => array(
                    'type' => 'select',
                    'label' => __( 'Style', 'magee-shortcodes'),
                    'desc' => __( 'Select display style for pricing table.', 'magee-shortcodes'),
                    'std' => 'flat',
                    'options' => array(
                        'flat' => 'Flat',
                        'box' => 'Box',
                        'table' => 'Table',
                    )
                ),
                
                'columns' => array(
                    'type' => 'select',
                    'label' => __( 'Columns', 'magee-shortcodes'),
                    'desc' => __( 'Set number of pricing boxes.', 'magee-shortcodes'),
                    'std' => '3',
                    'options' => array(
                        '1' => __('1 Columns','magee-shortcodes'),
                        '2' => __('2 Columns','magee-shortcodes'),
                        '3' => __('3 Columns','magee-shortcodes'),
                        '4' => __('4 Columns','magee-shortcodes'),
                        '5' => __('5 Columns','magee-shortcodes'),
                        '6' => __('6 Columns','magee-shortcodes')
                    )
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),	
                ),
            'shortcode' => "[ms_pricing style=\"{{style}}\" columns=\"{{columns}}\" class=\"{{class}}\" id=\"{{id}}\"]\r\n{{child_shortcode}}[/ms_pricing]",
            'popup_title' => __( 'Pricing Shortcode', 'magee-shortcodes'),
            'child_shortcode' => array(
                'params' => array(
                

            'icon' => array(
                    'type' => 'iconpicker',
                    'label' => __( 'Icon', 'magee-shortcodes'),
                    'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes'),
                    'std' => 'fa-database',
                    'options' => $icons
                ),
            
            'title' => array(
                    'std' =>  'Standard',
                    'type' => 'text',
                    'label' => __( 'Title', 'magee-shortcodes'),
                    'desc' => __( 'Insert title for pricing box.', 'magee-shortcodes'),
                ),
            'price' => array(
                    'std' => '39.99',
                    'type' => 'text',
                    'label' => __( 'Price', 'magee-shortcodes'),
                    'desc' => __( 'Inser number for pricing box.', 'magee-shortcodes'),
                ),
            'currency' => array(
                    'std' => '$',
                    'type' => 'text',
                    'label' => __( 'Currency', 'magee-shortcodes'),
                    'desc' => __( 'Inser currency for pricing box.', 'magee-shortcodes'),
                ),
            'unit' => array(
                    'std' =>'year',
                    'type' => 'text',
                    'label' => __( 'Unit', 'magee-shortcodes'),
                    'desc' => __( 'Inser unit for pricing box.', 'magee-shortcodes'),
                ),
            'buttontext' => array(
                    'std' => 'Buy Now',
                    'type' => 'text',
                    'label' => __( 'Button Text', 'magee-shortcodes'),
                    'desc' => __( 'Inser text for button of pricing box.', 'magee-shortcodes'),
                ),
            'buttonlink' => array(
                    'std' => '#',
                    'type' => 'text',
                    'label' => __( 'Button Link', 'magee-shortcodes'),
                    'desc' => __( 'Inser link for button of pricing box, eg: http://example.com.', 'magee-shortcodes'),
                ),
            
            'linktarget' => array(
                    'std' => '_blank',
                    'type' => 'choose',
                    'label' => __( 'Link Target', 'magee-shortcodes'),
                    'desc' => __( '_self = open in same window, _blank = open in new window.', 'magee-shortcodes'),
                    'std' => '_blank',
                    'options' => array(
                        '_blank' => __('_blank','magee-shortcodes'),
                        '_self' => __('_self','magee-shortcodes')
                        
                    )
                ),
            
            'featured' => array(
                    'type' => 'choose',
                    'label' => __( 'Featured', 'magee-shortcodes'),
                    'desc' => __( 'Choose to set pricing box as featured.', 'magee-shortcodes'),
                    'std' => 'no',
                    'options' => $reverse_choices
                ),
            
            'standout' => array(
                    'type' => 'choose',
                    'label' => __( 'Standout', 'magee-shortcodes'),
                    'desc' => __( 'Choose to set pricing box as standout.', 'magee-shortcodes'),
                    'std' => 'no',
                    'options' => $reverse_choices
                ),
            
            'color' => array(
                    'std' => '#fdd200', 
                    'type' => 'colorpicker',
                    'label' => __( 'Color', 'magee-shortcodes'),
                    'desc' => __( 'Set primary color for pricing box.', 'magee-shortcodes'),
                ),

                
                'is_label' => array(
                    'type' => 'choose',
                    'label' => __( 'Is Label? (For table style)', 'magee-shortcodes'),
                    'desc' =>  __( 'Choose to set pricing box as label for table style.', 'magee-shortcodes'),
                    'std' => 'no',
                    'options' => $reverse_choices
                ),
                'content' => array(
                    'std' => "[ms_pricing_item_features]8 GB Bandwidth[/ms_pricing_item_features]\n[ms_pricing_item_features]2 GB[/ms_pricing_item_features]\n[ms_pricing_item_features]16 GB Storage[/ms_pricing_item_features]\n[ms_pricing_item_features]Limited[/ms_pricing_item_features]\n[ms_pricing_item_features]2 Projects[/ms_pricing_item_features]\n",
                    'type' => 'textarea',
                    'label' => __( 'Features', 'magee-shortcodes'),
                    'desc' => __( 'Insert features for pricing box. Each feature between [ms_pricing_item_features][/ms_pricing_item_features].', 'magee-shortcodes'),
                ),	
                
                
                )
                ,
            'shortcode' => "[ms_pricing_item icon=\"{{icon}}\"  title=\"{{title}}\" price=\"{{price}}\" currency=\"{{currency}}\" unit=\"{{unit}}\" buttontext=\"{{buttontext}}\" buttonlink=\"{{buttonlink}}\" linktarget=\"{{linktarget}}\" featured=\"{{featured}}\" standout=\"{{standout}}\" color=\"{{color}}\" is_label=\"{{is_label}}\"  ]\n{{content}}[/ms_pricing_item]\n",
                
                )

        );

        /*-----------------------------------------------------------------------------------*/
        /*	Process Steps Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['process_steps'] = array(
            'icon' => 'fa-repeat', 
            'no_preview' => false,
            'params' => array(
                            
                'style' => array(
                    'type' => 'select',
                    'std' => 'horizontal',
                    'label' => __( 'Style', 'magee-shortcodes'),
                    'desc' => __( 'Select how the process steps display.', 'magee-shortcodes'),
                    'options' => array(
                        'horizontal' => __('Horizontal','magee-shortcodes'),
                        'vertical' => __('Vertical','magee-shortcodes')
                    )
                ),
                'columns' => array(
                    'type' => 'select',
                    'label' => __( 'Columns', 'magee-shortcodes'),
                    'desc' => __( 'Set columns for horizontal style.', 'magee-shortcodes'),
                    'std' => '4',
                    'options' => array(
                        '3' => __('3 Columns', 'magee-shortcodes'),
                        '4' => __('4 Columns', 'magee-shortcodes')
                    )
                ),

                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),	
                
                
                ),
            'shortcode' => "[ms_process_steps style=\"{{style}}\" columns=\"{{columns}}\"  class=\"{{class}}\" id=\"{{id}}\"]\r\n{{child_shortcode}}[/ms_process_steps]",
            'popup_title' => __( 'Process Steps Shortcode', 'magee-shortcodes'),
                // child shortcode is clonable & sortable
            'child_shortcode' => array(
                'params' => array(
                
                'icon' => array(
                    'std' => 'fa-pencil',
                    'type' => 'iconpicker',
                    'label' => __( 'Select Icon', 'magee-shortcodes'),
                    'desc' => __( 'Click an icon to select, click again to deselect', 'magee-shortcodes'),
                    'options' => $icons
                ),
                
                'title' => array(
                    'std' => __( 'Step #1', 'magee-shortcodes'),
                    'type' => 'text',
                    'label' => __( 'Title', 'magee-shortcodes'),
                    'desc' => __( 'Insert title for process steps item.', 'magee-shortcodes'),
                ),	
                
                'content' => array(
                    'std' => 'Your Content Goes Here',
                    'type' => 'textarea',
                    'label' => __( 'Text', 'magee-shortcodes'),
                    'desc' => __( 'Insert description for process steps item.', 'magee-shortcodes'),
                ),	
                
                
                )
                ,
            'shortcode' => "[ms_process_steps_item title=\"{{title}}\" icon=\"{{icon}}\"]{{content}}[/ms_process_steps_item]\r\n",
                )

        );

        /*-----------------------------------------------------------------------------------*/
        /*	Progress Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['progress'] = array(
            'no_preview' => false,
            'icon' => 'fa-tasks',
            'params' => array(
        'style'   => array(
                    'type' => 'select',
                    'label' => __( 'Style', 'magee-shortcodes' ),
                    'desc' => __( 'Choose the show of progress bar.', 'magee-shortcodes' ),
                    'options' => array( 
                                    'normal' => __( 'Normal Style', 'magee-shortcodes' ),
                                    'circle' => __( 'Circle Style', 'magee-shortcodes' ),
                                    )
                                    
                ), 
        'striped' => array(
                    'type' => 'select',
                    'label' => __( 'Striped', 'magee-shortcodes' ),
                    'desc' => __( 'Choose to get the filled area striped.', 'magee-shortcodes' ),
                    'options' => array( 
                                    'none' => __( 'None Striped', 'magee-shortcodes' ),
                                    'striped' => __( 'Striped', 'magee-shortcodes' ),
                                    'striped animated' => __( 'Striped Animated', 'magee-shortcodes' ),
                                    )
                                    
                ),
        'rounded' => array(
                    'std' => 'on',
                    'type' => 'select',
                    'label' => __( 'Rounded', 'magee-shortcodes' ),
                    'desc' => __( 'Choose to set the progress bar as rounded.', 'magee-shortcodes' ),
                    'options' => array( 
                                    'on' => __( 'On', 'magee-shortcodes' ),
                                    'off' => __( 'Off', 'magee-shortcodes' ),
                                    )
                                    
                ),
            'number' => array(
                'std'=> 'yes',
                    'type' => 'choose',
                    'label' => __( 'Display  Number', 'magee-shortcodes' ),
                    'desc' => __( 'Choose to diplay number for progress bar.', 'magee-shortcodes' ),
                    'options' =>$choices 
                                    
                ),
            
            'percent' => array(
                    'std' => '50',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Percent', 'magee-shortcodes' ),
                    'desc' => __( 'Set percentage for progress bar. 0~100.', 'magee-shortcodes' )
                ),
            
            'text' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Text', 'magee-shortcodes' ),
                    'desc' => __( 'Insert text for progress bar.', 'magee-shortcodes' ),
                ),
            
            'height' => array(
                    'std' => '30',
                    'type' => 'number',
                    'max' => '200',
                    'min' => '0',
                    'label' => __( 'Height', 'magee-shortcodes' ),
                    'desc' =>__( 'Set height for progress bar.', 'magee-shortcodes' ),
                ),
            
            

            'color' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background color for filled area in progress bar.', 'magee-shortcodes' ),
                    'std' => ''
                ),
            'textposition' => array(
                    'std' => 1,
                    'type' => 'select',
                    'label' => __( 'Text Position', 'magee-shortcodes' ),
                    'desc' => __( 'Choose text position for progress bar.', 'magee-shortcodes' ),
                    'options' => array( 
                                    '1' => __('Text on Progress bars', 'magee-shortcodes' ),  
                                    '2' => __('Text above progress bars', 'magee-shortcodes' ),  
                                    )
                                    
                ),
                        
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                )
                
                
            ),
            'shortcode' => '[ms_progress style="{{style}}" striped="{{striped}}" rounded="{{rounded}}" number="{{number}}"  percent="{{percent}}" text="{{text}}"  height="{{height}}" color="{{color}}"  textposition="{{textposition}}" class="{{class}}" id="{{id}}"]',
            'popup_title' => __( 'Progress Shortcode', 'magee-shortcodes' ),
            'name' => __('progress-bar-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /* Promo_box Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['promo_box'] = array(
            'no_preview' => false,
            'icon' => 'fa-tag',
            'params' => array(

                'style' => array(
                    'type' => 'select',
                    'label' => __( 'Style', 'magee-shortcodes' ),
                    'desc' => __( 'Select style for promo box.', 'magee-shortcodes' ),
                    'options' => array(
                        'normal' => __('Normal', 'magee-shortcodes'),
                        'boxed' => __('Boxed', 'magee-shortcodes'),
                    )
                ),		
                'border_color' => array(
                    'type' => 'colorpicker',
                    'std' => '#fdd200',
                    'label' => __( 'Border Color', 'magee-shortcodes' ),
                    'desc' =>  __( 'Set color for highlight border of promo box.', 'magee-shortcodes' ),
                ),
                'border_width' => array(
                    'std' => '1',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Border Width', 'magee-shortcodes' ),
                    'desc' => __( 'Set width for highlight border of promo box.', 'magee-shortcodes' ),
                ),
            
                'border_position' => array(
                    'type' => 'select',
                    'label' => __( 'Border Position', 'magee-shortcodes' ),
                    'desc' => __( 'Choose position for highlight border of promo box.', 'magee-shortcodes' ),
                    'options' => array(
                        'left' => __('Left', 'magee-shortcodes'),
                        'right' => __('Right', 'magee-shortcodes'),
                        'top' => __('Top', 'magee-shortcodes'),
                        'bottom' => __('Bottom', 'magee-shortcodes'),
                        
                    )
                ),
                'background_color' => array(
                    'type' => 'colorpicker',
                    'std' =>'#f5f5f5',
                    'label' => __( 'Icon Circle Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background color for promo box.', 'magee-shortcodes' ),
                ),
                'button_color' => array(
                    'type' => 'colorpicker',
                    'std' =>'',
                    'label' => __( 'Button Color', 'magee-shortcodes' ),
                    'desc' => '',
                ),
                
                'button_text' => array(
                    'std' => __( 'Button', 'magee-shortcodes' ),
                    'type' => 'text',
                    'label' => __( 'Button Text', 'magee-shortcodes' ),
                    'desc' => __( 'Inser text for button of promo box.', 'magee-shortcodes' ),
                ),	
                'button_text_color' => array(
                    'std' => '#ffffff',
                    'type' => 'colorpicker',
                    'label' => __( 'Button Text Color', 'magee-shortcodes' ),
                ),	
                'button_link' => array(
                    'std' => '#',
                    'type' => 'text',
                    'label' => __( 'Button Link URL', 'magee-shortcodes' ),
                    'desc' => __( 'Inser link for button of promo box, eg: http://example.com.', 'magee-shortcodes' ),
                ),	
                'button_icon' => array(
                        'type' => 'iconpicker',
                        'label' => __( 'Button Icon', 'magee-shortcodes' ),
                        'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                        'options' => $icons
                    ),
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
                    'type' => 'textarea',
                    'label' => __( 'Content', 'magee-shortcodes' ),
                    'desc' => __( 'Insert content for promo box.', 'magee-shortcodes' ),
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),
            ),
            'shortcode' => '[ms_promo_box style="{{style}}" border_color="{{border_color}}" border_width="{{border_width}}" border_position="{{border_position}}" background_color="{{background_color}}" button_color="{{button_color}}" button_link="{{button_link}}" button_icon="{{button_icon}}" button_text="{{button_text}}" button_text_color="{{button_text_color}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_promo_box]',
            'popup_title' => __( 'Promo Box Shortcode', 'magee-shortcodes' ),
            'name' => __('promo-box-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Pullquote Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['pullquote'] = array(
            'no_preview' => false,
            'icon' => 'fa-quote-left',
            'params' => array(
                'align' => array(
                    'type' => 'select',
                    'label' => __('Align', 'magee-shortcodes'),
                    'desc' => __('Set alignment for pullquote.','magee-shortcodes'),
                    'options' => array(
                        'left' => __('Left', 'magee-shortcodes') ,
                        'right' => __('Right', 'magee-shortcodes'),
                    )
                ),
                'border_color' => array(
                    'type' => 'colorpicker',
                    'std' =>'#eeee22',
                    'label' => __( 'Border Color', 'magee-shortcodes' ),
                    'desc' => '',
                ),
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    'type' => 'textarea',
                    'label' => __( 'Content', 'magee-shortcodes'),
                    'desc' => __( 'Insert content for pullquote.', 'magee-shortcodes')
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ), 
                
            ),
            'shortcode' => '[ms_pullquote align="{{align}}" border_color="{{border_color}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_pullquote]',
            'popup_title' =>__('Pullquote Shortcode','magee-shortcodes'),
            'name' => __('pullquote-shortcode/','magee-shortcodes'),
        );	

        /*-----------------------------------------------------------------------------------*/
        /*	QR Code Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['QRCode'] = array(
            'no_preview' => false,
            'icon' => 'fa-qrcode',    
            'params' => array(
            
                'content' =>array(
                    'std' => get_site_url(),
                    'type' => 'text',
                    'label' => __( 'Content', 'magee-shortcodes' ),
                    'desc' => __( 'The text to store within the QR code. Any text or URL is available.', 'magee-shortcodes' ),
                ),
                'alt' => array(
                    'std' => __( 'Scan QR code', 'magee-shortcodes' ),
                    'type' => 'text',
                    'label' => __( 'Alternative text', 'magee-shortcodes' ),
                    'desc' => __( 'Set image alt for QR code.', 'magee-shortcodes' ),
                ),
                'size' => array(
                    'std' => '200',
                    'type' => 'number',
                    'max' => '500',
                    'min' => '0',
                    'label' => __('Size in pixel','magee-shortcodes'),
                    'desc' => __('Image width and height.','magee-shortcodes'),
                ),
                'click' => array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __('QRCode clickable?','magee-shortcodes'),
                    'desc' => __('Choose to make this QR code clickable.','magee-shortcodes'), 
                    'options' => array(
                        'no' => __( 'No', 'magee-shortcodes' ),
                        'yes' => __( 'Yes', 'magee-shortcodes' ),
                    )
                ),
                'fgcolor' => array( 
                    'std' => '#000000',  
                    'type' => 'colorpicker',
                    'label' => __('Foreground Color' ,'magee-shortcodes'),
                    'desc' => __('Set foreground Color for QR code.' ,'magee-shortcodes'),
                ),
                'bgcolor' =>array(
                    'std' => '#FFFFFF',
                    'type' => 'colorpicker',
                    'label' => __('Background Color','magee-shortcodes'),
                    'desc' => __('Set background Color for QR code.' ,'magee-shortcodes'),
                ),
            ),
            'shortcode' => '[ms_qrcode alt="{{alt}}" size="{{size}}" click="{{click}}" fgcolor="{{fgcolor}}" bgcolor="{{bgcolor}}"]{{content}}[/ms_qrcode]',
            'popup_title' => __( 'QR Code Shortcode', 'magee-shortcodes' ),
            'name' => __('qr-code-shortcode/','magee-shortcodes'),
        ); 

        /*-----------------------------------------------------------------------------------*/
        /*	Quote Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['quote'] = array(
            'no_preview' => false,
            'icon' => 'fa-quote-right',    
            'params' => array(
                'cite' => array(
                    'std' => __( 'Jimmy Q.', 'magee-shortcodes'),
                    'type' => 'text',
                    'label' => __( 'Name', 'magee-shortcodes'),
                    'desc' => __( 'Author name for quote.', 'magee-shortcodes')
                ),
                'url' => array(
                    'std' => '#',
                    'type' => 'text',
                    'label' => __( 'Name Link', 'magee-shortcodes'),
                    'desc' => __( 'Insert Url for the quote author. Leave empty to disable hyperlink.', 'magee-shortcodes')
                ),
                'content' => array(
                    'std' => __( 'I\'m a full-time front end developer with 10 years experience.', 'magee-shortcodes'),
                    'type' => 'textarea',
                    'label' => __( 'Description', 'magee-shortcodes'),
                    'desc' => __( 'Insert content for the quote.', 'magee-shortcodes')
                ),
                'quotecolor' => array( 
                    'std' => '#78C0A8',  
                    'type' => 'colorpicker',
                    'label' => __('Quote Color' ,'magee-shortcodes'),
                    'desc' => __('Set Color for quote.' ,'magee-shortcodes'),
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ), 
            ),
            'shortcode' =>  '[ms_quote cite="{{cite}}" quotecolor="{{quotecolor}}" url="{{url}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_quote]',
            'popup_title' =>__('Quote Shortcode','magee-shortcodes'),
            'name' => __('quote-shortcode/','magee-shortcodes'),
        );	

        /*-----------------------------------------------------------------------------------*/
        /*	RSS Feed Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['rss_feed'] = array(
            'no_preview' => false,
            'icon' => 'fa-rss' ,
            'params' => array(
                
                'url' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Feed URL', 'magee-shortcodes'),
                    'desc' => __( 'Url of RSS Feed.', 'magee-shortcodes')
                ),  
                'number' => array(
                    'std' => '3',
                    'type' => 'number',
                    'max' => '20',
                    'min' => '0',
                    'label' => __( 'Number to Display', 'magee-shortcodes'),
                    'desc' => __( 'Number of items to show.', 'magee-shortcodes')
                ),  
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),   
            ),
            'shortcode' => '[ms_rss_feed url="{{url}}" number="{{number}}" class="{{class}}" id="{{id}}"][/ms_rss_feed]',
            'popup_title' =>__('RSS Feed Shortcode','magee-shortcodes'),
            'name' => __('rss-feed-shortcode/','magee-shortcodes'),
        );	


        /*-----------------------------------------------------------------------------------*/
        /*	Scheduled_content Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['scheduled_content'] = array(
            'no_preview' => false,
            'icon' => 'fa-clock-o',
            'params' => array(
                'time' => array(
                    'std' => '6-12,13-16',
                    'type' => 'text',
                    'label' => __( 'Time', 'magee-shortcodes'),
                    'desc' => __( 'Select an random time in one day to show content.</br>Example: 6-12,13-16  show content from  6:00 to 12:00 and from 13:00 to 16:00', 'magee-shortcodes')
                ),
                'day_week' => array(
                    'std' => '1-5,7',
                    'type' => 'text',
                    'label' => __( 'Days of Week', 'magee-shortcodes'),
                    'desc' => __( 'Select days from one week to show content.</br>1 => Monday </br>2 => Tuesday  </br> 3 => Wednesday</br> 4 => Thursday  </br> 5 => Friday  </br> 6 => Saturday </br>  7 => Sunday </br>Examples:1-5,7 =>show content at Sunday and from Monday to Friday', 'magee-shortcodes')
                ),
                'day_month' =>array(
                    'std' => '10-15,20-25',
                    'type' => 'text',
                    'label' => __( 'Days of Month', 'magee-shortcodes'), 
                    'desc' => __('Select days from one month to show content.</br>Examples:</br>1 => show content only at first day of  month </br> 10-25 => show content from 10th to 25th </br> 10-15,20-25 => show content from 10th to 15th and from 20th to 25th','magee-shortcodes')
                ),
                'months' => array(
                    'std' => '1,5,8-9',
                    'type' => 'text',
                    'label' => __('Months','magee-shortcodes'),
                    'desc' => __('Select months from a year to show content.</br>Examples:</br>1 => show content in January </br> 3-6 => show content from March to June </br> 1,5,8-9 => show content in January,May and from August to September','magee-shortcodes') 
                ),
                'years' => array(
                    'std' => date('Y').','.date('Y', strtotime('+1 year')).',2045-2066',
                    'type' => 'text',
                    'label' => __('Years','magee-shortcodes'),  
                    'desc' => __( 'Select years to show content.</br>Examples:</br> 2016 => show content in 2016 </br>2014-2016 => show content from 2014 to 2016 </br> '.date('Y').','.date('Y', strtotime('+1 year')).',2045-2066 => show content in 2016,2017 and from 2045 to 2066','magee-shortcodes')
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ), 
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'type' => 'textarea',
                    'label' => __( 'Content', 'magee-shortcodes'),
                    'desc' => __( 'Insert scheduled content.', 'magee-shortcodes') 
                )   
            ),
            'shortcode' => '[ms_scheduled_content time="{{time}}" day_week="{{day_week}}" day_month="{{day_month}}" months="{{months}}" years="{{years}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_scheduled_content]',
            'popup_title' => __( 'Scheduled Shortcode','magee-shortcodes'),
            'name' => __('scheduled-shortcode/','magee-shortcodes'),
        );	

        /*-----------------------------------------------------------------------------------*/
        /*	Section Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['section'] = array(
            'no_preview' => false,
            'icon' => 'fa-list-alt',
            'params' => array(

                'background_color' => array(
                    'std' => '#ffffff',
                    'type' => 'colorpicker',
                    'label' => __( 'Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background for section. Leave blank for transparent.', 'magee-shortcodes' ),
                ),
                
                'background_image' => array(
                    'std' => '',
                    'type' => 'uploader',
                    'label' => __( 'Background Image', 'magee-shortcodes' ),
                    'desc' => __( 'Upload an image to display in the background.', 'magee-shortcodes' ),
                ),
                'background_repeat' => array(
                    'type' => 'select',
                    'label' => __( 'Background Repeat', 'magee-shortcodes' ),
                    'desc' =>__( 'Choose repeat style for the background image.', 'magee-shortcodes' ),
                    'std' => '',
                    'options' => array(
                                    'repeat' => __( 'Repeat', 'magee-shortcodes' ),
                                    'repeat-x' => __( 'Repeat-x', 'magee-shortcodes' ),
                                    'repeat-y' => __( 'Repeat-y', 'magee-shortcodes' ),
                                    'no-repeat' => __( 'No-repeat', 'magee-shortcodes' ),
                                    'inherit' => __( 'Inherit', 'magee-shortcodes' )
                                    )
                ),
                
                'background_position' => array(
                    'type' => 'select',
                    'label' => __( 'Background Position', 'magee-shortcodes' ),
                    'desc' => __( 'Choose the postion of the background image.', 'magee-shortcodes' ),
                    'std' => '',
                    'options' => array(
                                    'top left' => __( 'Top Left', 'magee-shortcodes' ),
                                    'top center' => __( 'Top Center', 'magee-shortcodes' ),
                                    'top right' => __( 'Top Right', 'magee-shortcodes' ),
                                    'center left' => __( 'Center Left', 'magee-shortcodes' ),
                                    'center center' => __( 'Center Center', 'magee-shortcodes' ),
                                    'center right' => __( 'Center Right', 'magee-shortcodes' ),
                                    'bottom left' => __( 'Bottom Left', 'magee-shortcodes' ),
                                    'bottom center' => __( 'Bottom Center', 'magee-shortcodes' ),
                                    'bottom right' => __( 'Bottom Right', 'magee-shortcodes' )
                                    )
                ),
                'background_parallax' => array(
                    'type' => 'choose',
                    'label' => __( 'Background Parallax', 'magee-shortcodes' ),
                    'desc' => __( 'Choose how the background image scrolls and responds.', 'magee-shortcodes' ),
                    'std' => 'no',
                    'options' => $reverse_choices
                ),
                'border_size' => array(
                    'std' => '0',
                    'type' => 'number',
                    'max' => '50',
                    'min' => '0',
                    'label' => __( 'Border Size', 'magee-shortcodes' ),
                    'desc' =>__( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
                ),
                
                'border_color' => array(
                    'std' => '',
                    'type' => 'colorpicker',
                    'label' => __( 'Border Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set border color for section.', 'magee-shortcodes' ),
                ),
                'border_style' => array(
                    'type' => 'select',
                    'label' => __( 'Border Style', 'magee-shortcodes' ),
                    'desc' => __( 'Select border style for section', 'magee-shortcodes' ),
                    'std' => '',
                    'options' => array(
                                    'none' => __( 'None', 'magee-shortcodes' ),
                                    'hidden' => __( 'Hidden', 'magee-shortcodes' ),
                                    'dotted' => __( 'Dotted', 'magee-shortcodes' ),
                                    'dashed' => __( 'Dashed', 'magee-shortcodes' ),
                                    'solid' => __( 'Solid', 'magee-shortcodes' ),
                                    'double' => __( 'Double', 'magee-shortcodes' ),
                                    'groove' => __( 'Groove', 'magee-shortcodes' ),
                                    'ridge' => __( 'Ridge', 'magee-shortcodes' ),
                                    'inset' => __( 'Inset', 'magee-shortcodes' ),
                                    'outset' => __( 'Outset', 'magee-shortcodes' ),
                                    'initial' => __( 'Initial', 'magee-shortcodes' ),
                                    'inherit' => __( 'Inherit', 'magee-shortcodes' ),
                                    
                                    )
                ),
                
                'padding_top' => array(
                    'std' => '10',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Padding Top', 'magee-shortcodes' ),
                    'desc' =>  __( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
                ),
                'padding_bottom' => array(
                    'std' => '50',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Padding Bottom', 'magee-shortcodes' ),
                    'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
                ),
                'padding_left' => array(
                    'std' => '10',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Padding Left', 'magee-shortcodes' ),
                    'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
                ),
                'padding_right' => array(
                    'std' => '10',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Padding Right', 'magee-shortcodes' ),
                    'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
                ),
                'contents_in_container' => array(
                    'type' => 'choose',
                    'label' => __( 'Contents in Container ?', 'magee-shortcodes' ),
                    'desc' =>  __( 'Put the content in container.', 'magee-shortcodes' ),
                    'std' => 'no',
                    'options' => $reverse_choices
                ),
                
                'content' => array(
                    'std' => __('Section content.', 'magee-shortcodes'),
                    'type' => 'textarea',
                    'label' => __( 'Section Content', 'magee-shortcodes' ),
                    'desc' => __( 'Insert content for section.', 'magee-shortcodes' ),
                ),
                
                'top_separator' => array(
                    'std' => 'yes',
                    'type' => 'select',
                    'label' => __( 'Top Separator', 'magee-shortcodes' ),
                    'desc' => '',
                    'options' => array(
                        '' => __('None', 'magee-shortcodes'),
                        'triangle' => __('Triangle', 'magee-shortcodes'),
                        'doublediagonal' => __('Doublediagonal', 'magee-shortcodes'),
                        'halfcircle' => __('Halfcircle', 'magee-shortcodes'),
                        'bigtriangle' => __('Bigtriangle', 'magee-shortcodes'),
                        'bighalfcircle' => __('Bighalfcircle', 'magee-shortcodes'),
                        'curl' => __('Curl', 'magee-shortcodes'),
                        'multitriangles' => __('Multitriangles', 'magee-shortcodes'),
                        'roundedsplit' => __('Roundedsplit', 'magee-shortcodes'),
                        'boxes' => __('Boxes', 'magee-shortcodes'),
                        'zigzag' => __('Zigzag', 'magee-shortcodes'),
                        'clouds' => __('Clouds', 'magee-shortcodes'),
                    )
                ),
                'bottom_separator' => array(
                    'std' => 'yes',
                    'type' => 'select',
                    'label' => __( 'Bottom Separator', 'magee-shortcodes' ),
                    'desc' => '',
                    'options' => array(
                        '' => __('None', 'magee-shortcodes'),
                        'triangle' => __('Triangle', 'magee-shortcodes'),
                        'halfcircle' => __('Halfcircle', 'magee-shortcodes'),
                        'bigtriangle' => __('Bigtriangle', 'magee-shortcodes'),
                        'bighalfcircle' => __('Bighalfcircle', 'magee-shortcodes'),
                        'curl' => __('Curl', 'magee-shortcodes'),
                        'multitriangles' => __('Multitriangles', 'magee-shortcodes'),
                        'roundedcorners' => __('Roundedcorners', 'magee-shortcodes'),
                        'foldedcorner' => __('Foldedcorner', 'magee-shortcodes'),
                        'boxes' => __('Boxes', 'magee-shortcodes'),
                        'zigzag' => __('Zigzag', 'magee-shortcodes'),
                        'stamp' => __('Stamp', 'magee-shortcodes'),
                    )
                ),
                'full_height' => array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __('Full Height' , 'magee-shortcodes'),
                    'desc' => __('Choose to set the section height same as browser window.' , 'magee-shortcodes'),
                    'options' => $reverse_choices
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),		
            ),
            'shortcode' => '[ms_section background_color="{{background_color}}" background_image="{{background_image}}" background_repeat="{{background_repeat}}" background_position="{{background_position}}" background_parallax="{{background_parallax}}" border_size="{{border_size}}" border_color="{{border_color}}" border_style="{{border_style}}" padding_top="{{padding_top}}" padding_bottom="{{padding_bottom}}" padding_left="{{padding_left}}" padding_right="{{padding_right}}" contents_in_container="{{contents_in_container}}" top_separator="{{top_separator}}" bottom_separator="{{bottom_separator}}" full_height="{{full_height}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_section]',
            'popup_title' => __( 'Section Shortcode', 'magee-shortcodes' ),
            'name' => __('section-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /* Magee Slider Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['ms_slider'] = array(
            'no_preview' => false,
            'icon' => 'fa-sliders',
            'params' => array(
        
                'id' => array(
                    'std' => '',
                    'type' => 'select',
                    'label' => __( 'Slider', 'magee-shortcodes' ),
                    'desc' => __( 'Create simple slider from <a target="_blank" href="'.esc_url(admin_url('edit.php?post_type=magee_slider')).'">Magee Slider</a>.', 'magee-shortcodes' ),
                    'options' => $magee_sliders
                ),		
                
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                
            ),),
            'shortcode' => '[ms_slider id="{{id}}" class="{{class}}"]',
            'popup_title' => __( 'Slider', 'magee-shortcodes' ),
            'name' => __('slider-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /* Social Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['social'] = array(
            'no_preview' => false,
            'icon' => 'fa-twitter',
            'params' => array(

                'title' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Title ', 'magee-shortcodes' ),
                    'desc' => __( 'Insert the title for the social icon.', 'magee-shortcodes' ),
                    ),
                'icon' => array(
                    'std' => 'fa-twitter',
                    'type' => 'iconpicker',
                    'label' => __( 'Icon', 'magee-shortcodes' ),
                    'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
                    'options' => $icons
                ),
                'icon_size' => array(
                    'std' => '30',
                    'type' => 'number',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Icon Size', 'magee-shortcodes' ),
                    'desc' => __( 'In pixels (px), eg: 13px.', 'magee-shortcodes')
                ),	
                'iconcolor' => array(
                    'std' => '#6EC1E4',
                    'type' => 'colorpicker',
                    'label' => __( 'Icon Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for icon.', 'magee-shortcodes')
                    ),
                'backgroundcolor' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Icon Circle Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set background color for icon.', 'magee-shortcodes')
                ),
                'effect_3d' => array(
                    'std'=>'no',
                    'type' => 'choose',
                    'label' => __( 'Icon 3D effect', 'magee-shortcodes'),
                    'desc' => __( 'Display box shadow for icon.', 'magee-shortcodes'),
                    'options' => array(
                        'yes' => __('Yes', 'magee-shortcodes'),
                        'no' => __('No', 'magee-shortcodes'),
                    )	
                ),		
                'iconboxedradius' => array(
                    'std' => 'normal',
                    'type' => 'select',
                    'label' => __( 'Icon Box Radius Style', 'magee-shortcodes' ),
                    //'desc' => __( '', 'magee-shortcodes' ),
                    'options' => array(
                        'normal' => __('Normal', 'magee-shortcodes'),
                        'boxed' => __('Boxed', 'magee-shortcodes'),
                        'rounded' => __('Rounded', 'magee-shortcodes'),
                        'circle' => __('Circle ', 'magee-shortcodes'),				
                    )
                ),
                'iconlink' => array(
                    'std' => '#',
                    'type' => 'text',
                    'label' => __( 'Icon Link URL', 'magee-shortcodes' ),
                    'desc' => __( 'Add the icon\'s url eg: http://example.com.', 'magee-shortcodes' ),
                ),	
                'icontarget' => array(
                    'std' => '_blank',
                    'type' => 'choose',
                    'label' => __( 'Icon Target', 'magee-shortcodes' ),
                    'desc' => __( '_self = open in same window <br />_blank = open in new window.', 'magee-shortcodes' ),
                    'options' => array(
                        '_self' => __('_self','magee-shortcodes'),
                        '_blank' => __('_blank','magee-shortcodes')
                    )
                ),	
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),
            ),
            'shortcode' => '[ms_social icon_size="{{icon_size}}" title="{{title}}" icon="{{icon}}" iconcolor="{{iconcolor}}" effect_3d="{{effect_3d}}" backgroundcolor="{{backgroundcolor}}" iconboxedradius="{{iconboxedradius}}" iconlink="{{iconlink}}" icontarget="{{icontarget}}" class="{{class}}" id="{{id}}"][/ms_social]',
            'popup_title' => __( 'Social Icon Shortcode', 'magee-shortcodes' ),
            'name' => __('social-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Table Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['table'] = array(
            'no_preview' => false,
            'icon' => 'fa-table',
            'params' => array(
                'style' => array(
                    'type' => 'select',
                    'label' => __( 'Style', 'magee-shortcodes'),
                    'desc' => __( 'Select table style.', 'magee-shortcodes'),
                    'options' => array(
                        'simple' => __('Simple Style', 'magee-shortcodes'),
                        'normal' => __('Normal Style', 'magee-shortcodes'),
                    )
                ),
                'striped' => array(
                    'type' => 'select',
                    'label' => __( 'Striped', 'magee-shortcodes'),
                    'options' => array(
                        'yes' => __('Yes', 'magee-shortcodes'),
                        'no' => __('No', 'magee-shortcodes'),
                    )
                ),	
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes'),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes'),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
                
                'content' => array(
                        'std' => '<table>
                                        <thead>
                                            <tr>
                                                <th>Column 1</th>
                                                <th>Column 2</th>
                                                <th>Column 3</th>
                                                <th>Column 4</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Item #1</td>
                                                <td>Description</td>
                                                <td>Subtotal:</td>
                                                <td>$1.00</td>
                                            </tr>
                                            <tr>
                                                <td>Item #2</td>
                                                <td>Description</td>
                                                <td>Discount:</td>
                                                <td>$2.00</td>
                                            </tr>
                                            <tr>
                                                <td><strong>All Items</strong></td>
                                                <td><strong>Description</strong></td>
                                                <td><strong>Your Total:</strong></td>
                                                <td><strong>$3.00</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>',
                        'type' => 'textarea',
                        'label' => __( 'Table HTML Content', 'magee-shortcodes'),
                    //	'desc' => __( 'Insert content for Table.', 'magee-shortcodes')
                    )
            ),

            'shortcode' => '[ms_table style="{{style}}" striped="{{striped}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_table]',
            'popup_title' => __( 'Table Shortcode', 'magee-shortcodes'),

        );

        /*-----------------------------------------------------------------------------------*/
        /*	Tabs Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['tabs'] = array(
            'no_preview' => false,
            'icon' => 'fa-list-alt',
            'params' => array(
                'style' => array(
                    'type' => 'select',
                    'label' => __( 'Style', 'magee-shortcodes' ),
                    'desc' => __( 'Select tabs\' style.', 'magee-shortcodes' ),
                    'options' => array(
                        'simple' => __('Simple Style', 'magee-shortcodes'),
                        'simple justified' => __('Simple Style Justified', 'magee-shortcodes'),
                        'button' => __('Button Style', 'magee-shortcodes'),
                        'button justified' => __('Button Style Justified', 'magee-shortcodes'),
                        'normal' => __('Normal Style', 'magee-shortcodes'),
                        'normal justified' => __('Normal Style Justified', 'magee-shortcodes'),
                        'vertical' => __('Vertical Style', 'magee-shortcodes'),
                        'vertical right' => __('Vertical Style Right', 'magee-shortcodes'),
                    )
                ),
                'title_color' => array(
                    'type' => 'colorpicker',
                    'label' => __( 'Title Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set color for tab item\'s title.', 'magee-shortcodes')
                    ),		
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),
            ),
            'popup_title' => __( 'Tab Shortcode', 'magee-shortcodes' ),
            'name' => __('tabs-shortcode/','magee-shortcodes'),
            'shortcode' => "[ms_tabs style=\"{{style}}\" title_color=\"{{title_color}}\" class=\"{{class}}\" id=\"{{id}}\"]\r\n{{child_shortcode}}[/ms_tabs]",

            'child_shortcode' => array(
                'params' => array(
                    'title' => array(
                        'std' => __('Tab Title #1', 'magee-shortcodes'),
                        'type' => 'text',
                        'label' => __( 'Tab Title', 'magee-shortcodes'),
                        'desc' => __( 'Insert title for tab item.', 'magee-shortcodes'),
                    ),
                    'icon' => array(
                        'type' => 'icon',
                        'label' => __( 'Tab Title Icon', 'magee-shortcodes'),
                        'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes'),
                        'options' => $icons
                    ),			
                    'content' => array(
                        'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                        'type' => 'textarea',
                        'label' => __( 'Tab Content', 'magee-shortcodes'),
                        'desc' => __( 'Insert content for tab item.', 'magee-shortcodes')
                    )
                ),
                'shortcode' => "[ms_tab title=\"{{title}}\" icon=\"{{icon}}\"]{{content}}[/ms_tab]\r\n",
            )

        );

        /*-----------------------------------------------------------------------------------*/
        /*	Targeted_content Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['targeted_content'] = array(
            'no_preview' => false,
            'icon' => 'fa-eye' ,
            'params' => array(
                'type' => array(
                    'type' => 'select',
                    'label' => __( 'Type', 'magee-shortcodes'),
                    'desc' => __( 'Select visible permissions.Private for author only. Members for logged-in users. Guests for users not logged in.', 'magee-shortcodes'),
                    'options' => array(
                        'private' => __( 'Private','magee-shortcodes'),
                        'members' => __( 'Members','magee-shortcodes'),
                        'guests' => __('Guests','magee-shortcodes'),
                    )
                ),
                'content' => array(
                    'std' => 'note text',
                    'type' => 'textarea',
                    'label' => __( 'Content', 'magee-shortcodes'),
                    'desc' => __( 'Set content for targeted users.', 'magee-shortcodes')
                ),
                'alternative' => array(
                    'std' => 'alternative text',
                    'type' => 'textarea',
                    'label' => __( 'Alternative Content', 'magee-shortcodes'),
                    'desc' => __( 'Set content for other users.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_targeted_content type="{{type}}" alternative="{{alternative}}"]{{content}}[/ms_targeted_content]',
            'popup_title' => __( 'Targeted Shortcode','magee-shortcodes'),
            'name' => __('targeted-shortcode/','magee-shortcodes'),
        );

        /*-----------------------------------------------------------------------------------*/
        /* Testimonial Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['testimonial'] = array(
            'no_preview' => false,
            'icon' => 'fa-commenting',
            'params' => array(
                'style' => array(
                    'std' => '',
                    'type' => 'select',
                    'label' => __( 'Style ', 'magee-shortcodes' ),
                    'desc' => __( 'Select testimonial\'s style', 'magee-shortcodes' ),
                    'options' => array(
                        'normal' => __('Normal', 'magee-shortcodes') ,
                        'box' => __('Box', 'magee-shortcodes') ,
                        ),
                    ),
                'name' => array(
                    'std' => 'Jimmy Q.',
                    'type' => 'text',
                    'label' => __( 'Name', 'magee-shortcodes' ),
                    'desc' => __( 'Name of testimonial\'s author.', 'magee-shortcodes' ),
                    ),
                'byline' => array(
                    'std' => 'Fullstack Engineer',
                    'type' => 'text',
                    'label' => __( 'Byline', 'magee-shortcodes' ),
                    'desc' => __( 'Byline of testimonial\'s author.', 'magee-shortcodes' ),
                    ),
                'avatar' => array(
                    'std' => MAGEE_SHORTCODES_URL.'/assets/images/avatar.jpg',
                    'type' => 'link',
                    'label' => __( 'Avatar', 'magee-shortcodes' ),
                    'desc' => __( 'Avatar of testimonial\'s author.', 'magee-shortcodes' ),
                ),

                'alignment' => array(
                    'std' => 'none',
                    'type' => 'select',
                    'label' => __( 'Alignment', 'magee-shortcodes' ),
                    'desc' => __( 'Select the content\'s alignment.', 'magee-shortcodes' ),
                    'options' => array(
                        'none' => __('None', 'magee-shortcodes') ,
                        'center' => __('Center', 'magee-shortcodes') ,
                        ),
                    ),
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
                    'type' => 'textarea',
                    'label' => __( 'Testimonial Content', 'magee-shortcodes' ),
                    'desc' => __( 'Insert content for testimonial.', 'magee-shortcodes' )
                    ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),
            ),
            'shortcode' => '[ms_testimonial style="{{style}}" name="{{name}}" avatar="{{avatar}}" byline="{{byline}}" alignment="{{alignment}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_testimonial]',
            'popup_title' => __( 'Testimonial Shortcode', 'magee-shortcodes' ),
            'name' => __('testimonial-shortcode/','magee-shortcodes'),
        );


        /*-----------------------------------------------------------------------------------*/
        /*	Timeline Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['timeline'] = array(
            'no_preview' => false,
            'icon' => 'fa-history',
            'params' => array(
                'columns' => array(
                    'type' => 'select',
                    'label' => __( 'Columns', 'magee-shortcodes' ),
                    'desc' =>__( 'Number of items.', 'magee-shortcodes' ),
                    'std' => '4',
                    'options' => array(
                        '2' => __( '2 columns', 'magee-shortcodes' ),
                        '3' => __( '3 columns', 'magee-shortcodes' ),
                        '4' => __( '4 columns', 'magee-shortcodes' ),
                        '5' => __( '5 columns', 'magee-shortcodes' )
                    )
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),	
                ),
            'shortcode' => "[ms_timeline columns=\"{{columns}}\"  class=\"{{class}}\" id=\"{{id}}\"]\r\n{{child_shortcode}}[/ms_timeline]",
            'popup_title' => __( 'Timeline Shortcode', 'magee-shortcodes' ),
            'name' => __('timeline-shortcode/','magee-shortcodes'),
            // child shortcode is clonable & sortable
            'child_shortcode' => array(
                'params' => array(
                                
                'title' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Title', 'magee-shortcodes'),
                    'desc' => __( 'Insert title for timeline item.', 'magee-shortcodes'),
                ),
                'time' => array(
                    'std' => date('Y'),
                    'type' => 'text',
                    'label' => __( 'Time', 'magee-shortcodes'),
                    'desc' => __( 'Insert time for timeline item.', 'magee-shortcodes'),
                ),
                'content' => array(
                    'std' => 'Your Content Goes Here',
                    'type' => 'textarea',
                    'label' => __( 'Text', 'magee-shortcodes'),
                    'desc' => __( 'Insert description for timeline item.', 'magee-shortcodes'),
                ),	
                
                
                )
                ,
            'shortcode' => "[ms_timeline_item title=\"{{title}}\" time=\"{{time}}\"]{{content}}[/ms_timeline_item]\r\n",	
                )
        );

        /*-----------------------------------------------------------------------------------*/
        /*	Tooltip Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['tooltip'] = array(
            'no_preview' => false,
            'icon' => 'fa-comment-o',
            'params' => array(

                'title' => array(
                    'std' =>  __( 'Tooltip #1', 'magee-shortcodes' ),
                    'type' => 'text',
                    'label' => __( 'Tooltip Text', 'magee-shortcodes' ),
                    'desc' => __( 'Insert the text that displays in the tooltip', 'magee-shortcodes' )
                ),
                'background_color' => array(
                    'type' => 'colorpicker',
                    'std' => '',
                    'label' => __( 'Tooltip Background Color', 'magee-shortcodes' ),
                    'desc' => __( 'Set Background Color for the text.', 'magee-shortcodes' ),
                ),
                'border_radius' => array(
                    'type' => 'number',
                    'std' => '0',
                    'max' => '100',
                    'min' => '0',
                    'label' => __( 'Tooltip Border Radius', 'magee-shortcodes' ),
                    'desc' => __( 'Set Border Radius for the text.', 'magee-shortcodes' ),
                ),		
                'placement' => array(
                    'std' => 'bottom',
                    'type' => 'select',
                    'label' => __( 'Tooltip Position', 'magee-shortcodes' ),
                    'desc' => __( 'Choose the display position.', 'magee-shortcodes' ),
                    'options' => array(
                        'top' => __('Top', 'magee-shortcodes'),
                        'bottom' => __('Bottom', 'magee-shortcodes'),
                        'left' => __('Left', 'magee-shortcodes'),
                        'right' => __('Right', 'magee-shortcodes'),
                    )
                ),
                'trigger' => array(
                    'type' => 'select',
                    'label' => __( 'Tooltip Trigger', 'magee-shortcodes' ),
                    'desc' => __( 'Choose action to trigger the tooltip.', 'magee-shortcodes' ),
                    'options' => array(
                        'hover' => __('Hover', 'magee-shortcodes'),
                        'click' => __('Click', 'magee-shortcodes'),
                    )
                ),	
                
                'content' => array(
                    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
                    'type' => 'textarea',
                    'label' => __( 'Content', 'magee-shortcodes' ),
                    'desc' => __( 'Insert the text that will activate the tooltip hover', 'magee-shortcodes' )
                ),
                'class' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS Class', 'magee-shortcodes' ),
                    'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
                ),
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
                ),			
            ),
            'shortcode' => '[ms_tooltip title="{{title}}" background_color="{{background_color}}" border_radius="{{border_radius}}" placement="{{placement}}" trigger="{{trigger}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_tooltip]',
            'popup_title' => __( 'Tooltip Shortcode', 'magee-shortcodes' ),
            'name' => __('tooltip-shortcode/','magee-shortcodes'),
        );


        /*-----------------------------------------------------------------------------------*/
        /*	Video Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['video'] = array(
            'no_preview' => false,
            'icon' => 'fa-play-circle-o',    
            'params' => array(
            
                'mp4_url' => array(
                    'std' => '',
                    'type' => 'link',
                    'label' => __( 'Mp4 Video Url','magee-shortcodes'),
                    'desc' => __( 'Add the URL of video in MPEG4 format. WebM and MP4 format must be included to render your video with cross browser compatibility. OGV is optional.', 'magee-shortcodes' ),  
                
                ),  
                'ogv_url' => array(
                    'std' => '',
                    'type' => 'link',
                    'label' => __( 'Ogv Video Url','magee-shortcodes'),
                    'desc' => __( 'Add the URL of video in OGV format. WebM and MP4 format must be included to render your video with cross browser compatibility. OGV is optional.', 'magee-shortcodes' ),  
                
                ),
                'webm_url' => array(
                    'std' => '',
                    'type' => 'link',
                    'label' => __( 'Webm Video Url','magee-shortcodes'),
                    'desc' => __( 'Add the URL of video in webm format. WebM and MP4 format must be included to render your video with cross browser compatibility. OGV is optional.', 'magee-shortcodes' ),  
                
                ),  
                'poster' => array(
                    'std' => '',
                    'type' => 'uploader',
                    'label' => __( 'Poster','magee-shortcodes'),
                    'desc' => __( 'Display a image when browser does not support HTML5 format.','magee-shortcodes'),
                
                ),		
                'width' => array(
                    'std' => '100%',
                    'type' => 'text',
                    'label' => __('Width','magee-shortcodes'),
                    'desc' => __('In pixels (px), eg: 1px.','magee-shortcodes'),
                ),
                'height' => array(
                    'std' => '100%',
                    'type' => 'text',
                    'label' => __('Height','magee-shortcodes'),
                    'desc' => __('In pixels (px), eg: 1px.','magee-shortcodes'), 
                ),
                'mute' => array( 
                    'std' => 'no',  
                    'type' => 'choose',
                    'label' => __('Mute Video' ,'magee-shortcodes'),
                    'desc' => __('Choose to mute the video.','magee-shortcodes'), 
                    'options' => $reverse_choices	 
                ),
                'autoplay' =>array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __('Autoplay Video','magee-shortcodes'),
                    'desc' => __('Choose to autoplay the video (Sometimes you need to set mute to Yes).','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes'),
                    )
                ),
                'loop' =>array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __('Loop Video','magee-shortcodes'),
                    'desc' => __('Choose to loop the video.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes')
                    )
                ),
                'controls' =>array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __('Show Controls','magee-shortcodes'),
                    'desc' => __('Choose to display controls for the video player.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes')
                    )
                ),
                'class' =>array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __('CSS Class','magee-shortcodes'),
                    'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
                ),   
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_video mp4_url="{{mp4_url}}" ogv_url="{{ogv_url}}" webm_url="{{webm_url}}" poster="{{poster}}"  width="{{width}}" height="{{height}}" mute="{{mute}}" autoplay="{{autoplay}}" loop="{{loop}}" controls="{{controls}}" class="{{class}}" id="{{id}}"][/ms_video]',   
            'popup_title' => __( 'Video Shortcode', 'magee-shortcodes' ),
            'name' => __('video-shortcode/','magee-shortcodes'),
        );       
            

        /*-----------------------------------------------------------------------------------*/
        /*	Vimeo Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['vimeo'] = array(
            'no_preview' => false,
            'icon' => 'fa-vimeo-square',    
            'params' => array(
                'link' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Vimeo URL', 'magee-shortcodes' ),
                    'desc' => __( 'Add the URL the video will link to, ex: http://example.com.', 'magee-shortcodes' ),
                ),
                'width' => array(
                    'std' => '100%',
                    'type' => 'text',
                    'label' => __('Width','magee-shortcodes'),
                    'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'),
                ),
                'height' => array(
                    'std' => '500',
                    'type' => 'text',
                    'label' => __('Height','magee-shortcodes'),
                    'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'), 
                ),
                'mute' => array( 
                    'std' => 'no',  
                    'type' => 'choose',
                    'label' => __('Mute Video' ,'magee-shortcodes'),
                    'desc' => __('Choose to mute the video.','magee-shortcodes'), 
                    'options' => $reverse_choices	 
                ),
                'autoplay' =>array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __('Autoplay Video','magee-shortcodes'),
                    'desc' => __('Choose to autoplay the video.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes'),
                    )
                ),
                'loop' =>array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __('Loop Video','magee-shortcodes'),
                    'desc' => __('Choose to loop the video.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes')
                    )
                ),
                'controls' =>array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __('Show Controls','magee-shortcodes'),
                    'desc' => __('Choose to display controls for the video player.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes')
                    )
                ),
                'class' =>array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __('CSS Class','magee-shortcodes'),
                    'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
                ),   
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_vimeo link="{{link}}"  width="{{width}}" height="{{height}}" mute="{{mute}}" autoplay="{{autoplay}}" loop="{{loop}}" controls="{{controls}}" class="{{class}}" id="{{id}}"][/ms_vimeo]',   
            'popup_title' => __( 'Vimeo Shortcode', 'magee-shortcodes' ),
            'name' => __('vimeo-shortcode/','magee-shortcodes'),
        );       
        /*-----------------------------------------------------------------------------------*/
        /*	Youtube Config
        /*-----------------------------------------------------------------------------------*/

        $magee_shortcodes['youtube'] = array(
            'no_preview' => false,
            'icon' => 'fa-youtube-square',    
            'params' => array(
            
                'link' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'Youtube URL', 'magee-shortcodes' ),
                    'desc' => __( 'Add the URL the video will link to, ex: http://example.com.', 'magee-shortcodes' ),
                ),
                'width' => array(
                    'std' => '100%',
                    'type' => 'text',
                    'label' => __('Width','magee-shortcodes'),
                    'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'),
                ),
                'height' => array(
                    'std' => '100%',
                    'type' => 'text',
                    'label' => __('Height','magee-shortcodes'),
                    'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'), 
                ),
                'mute' => array( 
                    'std' => 'no',  
                    'type' => 'choose',
                    'label' => __('Mute Video' ,'magee-shortcodes'),
                    'desc' => __('Choose to mute the video.','magee-shortcodes'), 
                    'options' => $reverse_choices	 
                ),
                'autoplay' =>array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __('Autoplay Video','magee-shortcodes'),
                    'desc' => __('Choose to autoplay the video.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes'),
                    )
                ),
                'loop' =>array(
                    'std' => 'no',
                    'type' => 'choose',
                    'label' => __('Loop Video','magee-shortcodes'),
                    'desc' => __('Choose to loop the video.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes')
                    )
                ),
                'controls' =>array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' => __('Show Controls','magee-shortcodes'),
                    'desc' => __('Choose to display controls for the video player.','magee-shortcodes'), 
                    'options' => array(
                        'yes' => __('Yes','magee-shortcodes'), 
                        'no' => __('No','magee-shortcodes')
                    )
                ),
                'class' =>array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __('CSS Class','magee-shortcodes'),
                    'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
                ),   
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_youtube link="{{link}}"  width="{{width}}" height="{{height}}" mute="{{mute}}" autoplay="{{autoplay}}" loop="{{loop}}" controls="{{controls}}" class="{{class}}" id="{{id}}"][/ms_youtube]',   
            'popup_title' => __( 'Youtube Shortcode', 'magee-shortcodes' ),
            'name' => __('youtube-shortcode/','magee-shortcodes'),
        );  

        /*-----------------------------------------------------------------------------------*/
        /*	Weather Config
        /*-----------------------------------------------------------------------------------*/   

        $magee_shortcodes['weather'] = array(
            'no_preview' => false,
            'icon' => 'fa-skyatlas',    
            'params' => array(
                'api_key' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __('API Key','magee-shortcodes'),
                    'desc' => __('As of October 2015, OpenWeatherMap requires an APP ID key to access their weather data. <a href="http://openweathermap.org/appid" target="_blank">Get your APPID</a>','magee-shortcodes'),
                ),
                'location' => array(
                    'std' => 'London',
                    'type' => 'text',
                    'label' => __('Location','magee-shortcodes'),
                    'desc' => __('Set city name or ID which will show weather.eg: London or 2643743','magee-shortcodes'),
                ),
                'units' => array(
                    'std' => '',
                    'type' => 'select',
                    'label' =>  __('Temperature Units','magee-shortcodes'),
                    'desc' => __( 'Metric: Celsius, Imperial: Fahrenheit.', 'magee-shortcodes'),
                    'options' => array(
                        'metric' => __( 'Metric','magee-shortcodes'),
                        'imperial' => __( 'Imperial','magee-shortcodes')
                    )
                ),
                'weather_detail' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' =>  __('Disable Weather Detail','magee-shortcodes'),
                    'desc' => __( 'Choose to show current weather detail.', 'magee-shortcodes'),
                    'options' => $choices
                ),
                'forecast' => array(
                    'std' => 'yes',
                    'type' => 'choose',
                    'label' =>  __('Forecast','magee-shortcodes'),
                    'desc' => __( 'Choose to show forecast weather.', 'magee-shortcodes'),
                    'options' => $choices
                ),
                'forecast_cnt' => array(
                    'std' => '4',
                    'type' => 'number',
                    'max' => '16',
                    'min' => '1',
                    'label' =>  __('Forecast Cnt','magee-shortcodes'),
                    'desc' => __( 'Choose number of days for forecast weather.', 'magee-shortcodes'),	
                ),
                'background_color' => array(
                    'std' => '#fdd200',
                    'type' => 'colorpicker',
                    'label' =>  __('Background Color','magee-shortcodes'),
                    'desc' => __( 'Set background color for weather', 'magee-shortcodes'),
                ),
                'background_img' => array(
                    'std' => '',
                    'type' => 'uploader',
                    'label' =>  __('Background Image','magee-shortcodes'),
                    'desc' => __( 'Set background image for weather', 'magee-shortcodes'),
                ),
                'width' => array(
                    'std' => '300',
                    'type' => 'number',
                    'max' => '500',
                    'min' => '0',
                    'label' =>  __('Weather Width','magee-shortcodes'),
                ),
                'height' => array(
                    'std' => '',
                    'type' => 'number',
                    'max' => '500',
                    'min' => '0',
                    'label' =>  __('Weather Height','magee-shortcodes'),
                ),
                'class' =>array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __('CSS Class','magee-shortcodes'),
                    'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
                ),   
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_weather api_key="{{api_key}}" location="{{location}}" units="{{units}}" background_color="{{background_color}}" background_img="{{background_img}}" weather_detail="{{weather_detail}}" forecast="{{forecast}}" forecast_cnt="{{forecast_cnt}}" width="{{width}}" height="{{height}}" class="{{class}}" id="{{id}}"]',
            'popup_title' => __( 'Weather Shortcode', 'magee-shortcodes' ),

        );  

        /*-----------------------------------------------------------------------------------*/
        /*	Widget Area
        /*-----------------------------------------------------------------------------------*/   

        $magee_shortcodes['widget_area'] = array(
            'no_preview' => false,
            'icon' => 'fa-cog',    
            'params' => array(
                'name' => array(
                    'std' => '',
                    'type' => 'select',
                    'label' => __('Name','magee-shortcodes'),
                    'desc' => __('Choose widget name to show','magee-shortcodes'),
                    'options' => Helper::get_sidebars(),
                ),
                'background_color' => array(
                    'std' => '',
                    'type' => 'colorpicker',
                    'label' => __('Background Color','magee-shortcodes'),
                    'desc' => __('Set background color for widget area','magee-shortcodes'),
                ),
                'padding' => array(
                    'std' => '0',
                    'max' => '200',
                    'min' => '0',
                    'type' => 'number',
                    'label' =>  __('Padding','magee-shortcodes'),
                ),
                'class' =>array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __('CSS Class','magee-shortcodes'),
                    'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
                ),   
                'id' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __( 'CSS ID', 'magee-shortcodes' ),
                    'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
                ),
            ),
            'shortcode' => '[ms_widget_area name="{{name}}"  background_color="{{background_color}}" padding="{{padding}}" class="{{class}}" id="{{id}}"][/ms_widget_area]',
            'popup_title' => __( 'Widget Area Shortcode', 'magee-shortcodes' ),

        );
        $magee_shortcodes = array_merge($magee_shortcodes, apply_filters('magee_shortcodes_options', []));
        return $magee_shortcodes;
    }

    public static function supported_blocks() {
        $return = [
            'core/paragraph',
			'core/shortcode',
			'core/freeform',
        ];
        return apply_filters('magee_shortcodes_supported_blocks', $return);
    }
    
}