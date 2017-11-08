<?php

 $video_background_section  = onetone_option( 'video_background_section' );
 $i                         = $video_background_section-1 ;
 $video_controls            = onetone_option( 'video_controls' );
 $section_background_video  = onetone_option( 'section_background_video_0' );
 $youtube_bg_type           = onetone_option("youtube_bg_type");
 $youtube_bg_type           = is_numeric($youtube_bg_type)?$youtube_bg_type:"1";
 $display_video_mobile      = onetone_option("display_video_mobile","no");
 $start_play                = onetone_option("section_youtube_start",3);

 $youtube_autoplay          = onetone_option("youtube_autoplay");
 $youtube_loop              = onetone_option("youtube_loop");
 $youtube_mute              = onetone_option("youtube_mute");
 
 if( $youtube_autoplay == '1' )
   $youtube_autoplay = 'true';
 else
   $youtube_autoplay = 'false';
 
 if( $youtube_loop == '1' )
   $youtube_loop = 'true';
 else
   $youtube_loop = 'false';
 
 if( $youtube_mute == '1' )
   $youtube_mute = 'true';
 else
   $youtube_mute = 'false';
  
  $containment = '.onetone-youtube-section';
  
  if( $youtube_bg_type == '1')
    $containment = 'body';
	
?>
<section class="section home-section-<?php echo $video_background_section;?>  onetone-youtube-section video-section">
<div id="onetone-youtube-video" class="onetone-player" data-property="{videoURL:'<?php echo $section_background_video;?>',containment:'<?php echo $containment;?>', showControls:false, autoPlay:<?php echo $youtube_autoplay;?>, loop:<?php echo $youtube_loop;?>, mute:<?php echo $youtube_mute;?>, startAt:<?php echo $start_play;?>, opacity:1, addRaster:true, quality:'default'}"></div>

<?php get_template_part('home-sections/section',$video_background_section);?>
    
  <div class="clear"></div>
   <?php 
		  
		  $detect = new Mobile_Detect;
		  
		//  if( true || !$detect->isMobile() && !$detect->isTablet() ){
                                                           if( true ){
			  
			  if( $youtube_autoplay == 'true' )
			    $play_btn_icon = 'pause';
			  else
			    $play_btn_icon = 'play';
			  
			  if( $youtube_mute == 'true' )
			    $mute_btn_icon = 'volume-off';
			  else
			    $mute_btn_icon = 'volume-up';
			  
	  echo '<script>
	  function changeLabel(state){
		    if( state == 1 )
			 jQuery("#togglePlay i").removeClass("fa-play").addClass("fa-pause");
			else
			jQuery("#togglePlay i").removeClass("fa-pause").addClass("fa-play");
            
        }
		
		function toggleVolume(){
			var volume =jQuery(\'#onetone-youtube-video\').YTPToggleVolume();
			if( volume == true )
			jQuery(".youtube-volume i").removeClass("fa-volume-off").addClass("fa-volume-up");
			else
			jQuery(".youtube-volume i").removeClass("fa-volume-up").addClass("fa-volume-off");
			
		}
		
		</script>';
		
	if(  $video_controls == 1  ){
		echo '<p class="black-65" id="video-controls">
		  <a class="youtube-pause command" id="togglePlay" href="javascript:;" onclick="jQuery(\'#onetone-youtube-video\').YTPTogglePlay(changeLabel)"><i class="fa fa-'.$play_btn_icon.'"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <a class="youtube-volume" href="javascript:;" onclick="toggleVolume();"><i class="fa fa-'.$mute_btn_icon.' "></i></a>
	  </p>';
	 }
 }	  
	 ?>
</section>

    <section>
        <style>
          
          html,body{margin: 0}
        .videoWrapper {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 */
    padding-top: 25px;
    height: 0;
}
.videoWrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
          
      </style>
      
      <div class="videoWrapper">
    <!-- Copy & Pasted from YouTube -->
  
      
      
      
      
      
      
    <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
    <div id="player"></div>
</div>
    <script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '390',
          width: '640',
          videoId: 'M7lc1UVf-VE',
          controls: 0,
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }
    </script>
    
</section>