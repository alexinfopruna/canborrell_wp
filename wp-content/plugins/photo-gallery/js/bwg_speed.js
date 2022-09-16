jQuery(function () {
  jQuery(".bwg-install-booster").on("click", function () {
    install_booster_plugin( this );
  });

  jQuery(".bwg-sign-up-dashboard-button").on("click", function () {
    sign_up_dashboard( this );
  });

  jQuery(".bwg-connect-to-dashboard-button").on("click", function () {
    connect_to_dashboard( this );
  });

  jQuery(".bwg-analyze-input-button").on("click", function () {
    if ( !jQuery(this).hasClass("bwg-disable-analyze") ) {
      bwg_get_google_score(this, '', '');
    }
  });

  /* Case when redirected from frontend and need to count score 1-public, 0-private, ''-not from frontend */
  if( jQuery(".bwg-analyze-input").data('page-public') !== '' ) {
    analize_input_change();
    if (jQuery(".bwg-analyze-input").data('page-public') === 1) {
      jQuery(".bwg-analyze-input-button").trigger("click");
    }
  }

  jQuery(document).on('change', '.bwg-analyze-input', function () {
    analize_input_change();
  });

  /* If there is no score of home page run google score and get homepage score */
  if( bwg_speed.home_speed_status === '0' ) {
      bwg_get_google_score('', bwg_speed.home_url, '');
  } else {
      /* Draw score circle if it is Speed Optimization page */
      if( jQuery(".bwg-analyze-desktop-score .speed_circle").length > 0 ) {
        draw_score_circle(bwg_speed.home_speed_status.desktop_score, bwg_speed.home_speed_status.mobile_score);
      }
  }

  /* Show/hide tooltip in Speed Optimization page bottom Image optimizer container */
  jQuery(".bwg-optimize-now-button").hover(function(){
    jQuery(".bwg-optimize-now-tooltip").removeClass("bwg-hidden");
  }, function(){
    jQuery(".bwg-optimize-now-tooltip").addClass("bwg-hidden");
  });

});

function analize_input_change() {
  var bwg_analyze_input = jQuery(".bwg-analyze-input");
  bwg_analyze_input.removeClass("bwg-analyze-input-error");
  jQuery(".bwg-analyze-input-button").removeClass("bwg-disable-analyze");
  jQuery(".bwg-analyze-input-container .bwg-error-msg").remove();
  var domain = bwg_speed.home_url.replace(/^https?:\/\/|www./g, '');
  var url = bwg_analyze_input.val();
  var page_public = bwg_analyze_input.data('page-public');

  var error = false;
  var error_msg = '';
  if( url == '' ) {
    error = true;
    error_msg = bwg_speed.enter_page_url;
  }
  else if ( !isUrlValid(url) ) {
    error = true;
    error_msg = bwg_speed.wrong_url;
  }
  else if ( !url.includes(domain) ) {
    error = true;
    error_msg = bwg_speed.wrong_domain_url;
  }
  else if ( page_public === 0 ) {
    error = true;
    error_msg = bwg_speed.page_is_not_public;
  }


  if ( error === true ) {
    jQuery(".bwg-analyze-input-button").addClass("bwg-disable-analyze");
    jQuery(".bwg-analyze-input").addClass("bwg-analyze-input-error");
    jQuery(".bwg-analyze-input").after('<p class="bwg-error-msg">' + error_msg + '</p>');
  }

}

/**
 * Run ajax action and install/activate booster plugin
 *
 * @param that object
*/
function install_booster_plugin( that ) {
  if ( jQuery(that).hasClass("bwg-disable-link") ) {
    return false;
  }
  jQuery(that).addClass('bwg-disable-link');
  jQuery(that).html('<div class="speed-loader-blue"></div>');
  jQuery.ajax( {
    url: ajaxurl,
    type: "POST",
    data: {
      action: "speed_bwg",
      task: "install_booster",
      speed_ajax_nonce: bwg_speed.speed_ajax_nonce
    },
    success: function ( result ) {
      /* Cut json from returned html data */
      var json = result.substring( result.indexOf('{"booster_plugin_status') );
      var data = JSON.parse(json);
      if( typeof data !== 'object' ) {
        jQuery('.bwg-install-booster').text(bwg_speed.install_button_text);
        jQuery(".bwg-install-booster").text(bwg_speed.install_button_text);
        return;
      }
      if ( parseInt(data.booster_plugin_status) === 2 ) {
        jQuery(".bwg-install-booster-container").addClass("bwg-hidden");
        if ( !data.booster_is_connected ) {
          if ( data.subscription_id ) {
            jQuery(".bwg-connect-to-dashboard-container").removeClass("bwg-hidden");
          }
          else {
            jQuery(".bwg-sign_up-booster-container").removeClass("bwg-hidden");
          }
        } else {
          jQuery(".bwg-connected-booster-container").removeClass("bwg-hidden");
        }
      } else if ( parseInt(data.booster_plugin_status) === 1 ) {
        jQuery('.bwg-install-booster').text(bwg_speed.activate_button_text);
      }
    },
    error: function ( xhr ) {
      jQuery(".bwg-install-booster").text(bwg_speed.install_button_text);
    },
    complete: function () {
      jQuery('.bwg-install-booster.bwg-disable-link').removeClass('bwg-disable-link');
    }
  });
}

/**
 * Run ajax action and Sign Up to dashboard
 *
 * @param that object
 */
function sign_up_dashboard( that ) {
  if ( jQuery(that).hasClass("bwg-disable-link") ) {
    return false;
  }

  var email_input = jQuery(".bwg-sign-up-input");

  jQuery(".bwg-error-msg").remove();
  email_input.removeClass("bwg-input-error");
  jQuery(that).addClass('bwg-disable-link');
  jQuery(that).html('<div class="speed-loader-blue"></div>');


  var email = email_input.val();
  if( email === '' ) {
    email_input.after('<p class="bwg-error-msg">'+bwg_speed.empty_email+'</p>');
    email_input.addClass("bwg-input-error");
    jQuery(that).text(bwg_speed.sign_up);
    jQuery(that).removeClass('bwg-disable-link');

    return;
  }
  if( !isEmail(email) ) {
    email_input.after('<p class="bwg-error-msg">'+bwg_speed.wrong_email+'</p>');
    email_input.addClass("bwg-input-error");
    jQuery(that).text(bwg_speed.sign_up);
    jQuery(that).removeClass('bwg-disable-link');

    return;
  }

  jQuery.ajax( {
    url: ajaxurl,
    type: "POST",
    data: {
      action: "speed_bwg",
      task: "sign_up_dashboard",
      bwg_email: email,
      speed_ajax_nonce: bwg_speed.speed_ajax_nonce
    },
    success: function ( result ) {
      if( !isValidJSONString(result) ) {
        jQuery(that).text(bwg_speed.sign_up);
        jQuery(that).removeClass('bwg-disable-link');
        email_input.after('<p class="bwg-error-msg">' + bwg_speed.something_wrong + '</p>');
        return;
      }
      var data = JSON.parse(result);
      if ( data['status'] === 'success' ) {
          window.location.href = data['booster_connect_url'];
      } else {
          jQuery(that).text(bwg_speed.sign_up);
          jQuery(that).removeClass('bwg-disable-link');
          email_input.after('<p class="bwg-error-msg">' + bwg_speed.something_wrong + '</p>');
          return;
      }
    },
    error: function ( xhr ) {
      jQuery(that).text(bwg_speed.sign_up);
      jQuery(that).removeClass('bwg-disable-link');
      email_input.after('<p class="bwg-error-msg">' + bwg_speed.something_wrong + '</p>');
    }
  });
}

function connect_to_dashboard( that ) {
  if ( jQuery(that).hasClass("bwg-disable-link") ) {
    return false;
  }

  jQuery.ajax( {
    url: ajaxurl,
    type: "POST",
    data: {
      action: "speed_bwg",
      task: "connect_to_dashboard",
      speed_ajax_nonce: bwg_speed.speed_ajax_nonce
    },
    success: function ( result ) {
      if ( !isValidJSONString(result) ) {
        jQuery(that).text(bwg_speed.connect);
        jQuery(that).removeClass('bwg-disable-link');
        return;
      }
      var data = JSON.parse(result);
      if ( data['status'] === 'success' ) {
        window.location.href = data['booster_connect_url'];
      } else {
        jQuery(that).text(bwg_speed.connect);
        jQuery(that).removeClass('bwg-disable-link');
        return;
      }
    },
    error: function ( xhr ) {
      jQuery(that).text(bwg_speed.connect);
      jQuery(that).removeClass('bwg-disable-link');
    }
  });
}

/**
 * Drawing score circle in different colors
 *
 * @param desktop_score int score value of desktop
 * @param mobile_score int score value of desktop
*/
function draw_score_circle( desktop_score, mobile_score ) {
  var d = desktop_score;
  var m = mobile_score;
  var color_desktop = d <= 49 ? "rgb(253, 60, 49)" : (d >= 90 ? "rgb(12, 206, 107)" : "rgb(255, 164, 0)");
  var color_mobile = m <= 49 ? "rgb(253, 60, 49)" : (m >= 90 ? "rgb(12, 206, 107)" : "rgb(255, 164, 0)");
  var bg_color_desktop = d <= 49 ? "rgb(253, 60, 49, 0.1)" : (d >= 90 ? "rgb(12, 206, 107, 0.1)" : "rgb(255, 164, 0, 0.1)");
  var bg_color_mobile = m <= 49 ? "rgb(253, 60, 49, 0.1)" : (m >= 90 ? "rgb(12, 206, 107, 0.1)" : "rgb(255, 164, 0, 0.1)");

  jQuery('.speed_circle').each(function () {
    var _this = this;
    var val = desktop_score / 100;
    var num = d;
    var color = color_desktop;
    var bg_color = bg_color_desktop;
    if ( jQuery(this).data("id") === "mobile" ) {
      val = mobile_score / 100;
      num = m;
      color = color_mobile;
      bg_color = bg_color_mobile;
    }
    jQuery(_this).circleProgress({
      value: val,
      size: 78,
      startAngle: -Math.PI / 4 * 2,
      lineCap: 'round',
      emptyFill: "rgba(255, 255, 255, 0)",
      fill: {
        color: color
      }
    }).on('circle-animation-progress', function ( event, progress ) {
      jQuery(this).find('.circle_animated').html(Math.round(parseFloat(num) * progress)).css({"color": color});
      jQuery(this).find('canvas').html(Math.round(parseFloat(num) * progress)).css({ "background": bg_color });
    });
  });
}

/**
 * Run ajax action and icount google score
 *
 * @param that object
 * @param home_url string
 * @param bwg_from_retry int values 0 or 1 check if function called from retry or first time
 * @param last_api_key_index int/empty last index of array where keeped google api keys
*/
function bwg_get_google_score( that, home_url, last_api_key_index ) {
  var url;
  jQuery(".bwg-error-msg").remove();
  if (home_url === '') {
    if (jQuery(that).hasClass("bwg-disable-link")) {
      return false;
    }
    jQuery(that).addClass('bwg-disable-analyze');
    jQuery(that).html('<div class="speed-loader-grey"></div>');
    url = jQuery(".bwg-analyze-input").val();
  }
  else {
    url = home_url;
  }
  if (!isUrlValid(url)) {
    jQuery(".bwg-analyze-input").after('<p class="bwg-error-msg">' + bwg_speed.wrong_url + '</p>');
    jQuery('.bwg-analyze-input-button.bwg-disable-analyze').removeClass('bwg-disable-analyze');
    jQuery('.bwg-analyze-input-button').text(bwg_speed.analyze_button_text);
    return;
  }
  if ( jQuery(".speed_circle_loader").length === 0 ) {
    jQuery(".speed_circle").after("<div class='speed_circle_loader'></div>");
  }
  jQuery(".speed_circle").addClass("bwg-hidden");
  jQuery(".bwg-load-time-mobile span").text("-");
  jQuery(".bwg-load-time-desktop span").text("-");
  jQuery.ajax({
    url: ajaxurl,
    type: "POST",
    data: {
      action: "speed_bwg",
      task: "get_google_page_speed",
      last_api_key_index: last_api_key_index,
      bwg_url: url,
      speed_ajax_nonce: bwg_speed.speed_ajax_nonce
    },
    success: function (result) {
      if( !isValidJSONString(result) ) {
        google_speed_error_result('');
        return;
      } else {
          var data = JSON.parse(result);
          if ( data['error'] === 1 ) {
            if ( typeof data['last_api_key_index'] !== 'undefined' ) {
              bwg_get_google_score(that, home_url, data['last_api_key_index'] );
              return;
            }
            var msg = '';
            if( typeof data['msg'] !== 'undefined') {
              msg = data['msg'];
            }
            google_speed_error_result(msg);
            return;
          }
      }

      jQuery(".speed_circle_loader").remove();
      jQuery(".speed_circle").removeClass("bwg-hidden");
      draw_score_circle(data['desktop_score'], data['mobile_score']);
      jQuery(".bwg-last-analyzed-page").text(url);
      jQuery(".bwg-last-analyzed-date").text(data['last_analyzed_time']);
      jQuery(".bwg-load-time-mobile span").text(data['mobile_loading_time']);
      jQuery(".bwg-load-time-desktop span").text(data['desktop_loading_time']);
    },
    error: function (xhr) {
      google_speed_error_result('');
    },
    complete: function () {
      jQuery('.bwg-analyze-input-button.bwg-disable-analyze').removeClass('bwg-disable-analyze');
      jQuery('.bwg-analyze-input-button').text(bwg_speed.analyze_button_text);
    }
  });
}

/* Case when counting of scor return error */
function google_speed_error_result( msg ) {
  if( msg !== '' ) {
    bwg_speed.something_wrong = msg;
  }
  jQuery(".bwg-analyze-input").after('<p class="bwg-error-msg">' + bwg_speed.something_wrong + '</p>');
  jQuery('.bwg-analyze-input-button.bwg-disable-analyze').removeClass('bwg-disable-analyze');
  jQuery('.bwg-analyze-input-button').text(bwg_speed.analyze_button_text);
  jQuery(".speed_circle_loader").remove();
  jQuery(".speed_circle").removeClass("bwg-hidden");
}

/**
 * Check if value is email
 *
 * @param email string
 *
 * @return bool
*/
function isEmail( email ) {
  var EmailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return EmailRegex.test(email);
}

/**
 * Check if value is URL
 *
 * @param url string
 *
 * @return bool
*/
function isUrlValid(url) {
  if (typeof url == 'undefined' || url == '') {
    return false;
  }
  if ( url.indexOf("http") !== 0 && url.indexOf("www.") !== 0) {
    return false;
  }
  regexp =  /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;
  if (regexp.test(url)) {
    return true;
  } else {
    return false;
  }
}

/**
 * Check if data is valid json
 *
 * @param str string
 *
 * @return bool
 */
function isValidJSONString(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}
