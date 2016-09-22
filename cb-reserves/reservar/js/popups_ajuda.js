var TIMER_HELP_INTERVAL=15000;
var LAST_INPUT = 5;
var LAST_AJUDA = 0;
var timer_h;//timer d'ajuda
var tt = "";


	var OSX = {
		container: null,
		init: function () {
			
				

				$("#osx-modal-content").modal({
					overlayId: 'osx-overlay',
					containerId: 'osx-container',
					closeHTML: null,
					minHeight: 80,
                                        autoResize: true,
                                        //persist: true,
					oopacity: 65, 
					position: ['0',],
					overlayClose: true,
					onOpen: OSX.open,
					onClose: OSX.close
				});
			
		},
		open: function (d) {
			var self = this;
			self.container = d.container[0];
			d.overlay.fadeIn('slow', function () {
				$("#osx-modal-content", self.container).show();
				var title = $("#osx-modal-title", self.container);
				title.show();
				//d.container.slideDown('slow');
				d.container.slideDown('slow', function () {
                                    
					setTimeout(function () {
						var h = $("#osx-modal-data", self.container).height()
							+ title.height()
							+ 50; // padding
                                                
                                                    if (h>$( window ).height()) h='95%';
                                                //h='95%';
						d.container.animate(
							{height: h}, 
							200,
							function () {
								$("div.close", self.container).show();
								$("#osx-modal-data", self.container).show();
							}
						);
					}, 300);
                                        
				});
			})
		},
		close: function (d) {
			var self = this; // this = SimpleModal object
			d.container.animate(
				{top:"-" + (d.container.height() + 20)},
				500,
				function () {
					self.close(); // or $.modal.close();
				}
			);
		}
	};





$(function () {
    $('*').bind('blur change click dblclick error focus focusin focusout keydown keypress keyup load mousedown  ZZmouseleaveZZ    mouseup resize scroll select submit', function (e) {
        //console.log(e.keyCode);
        if (e.keyCode == 54)  help(l(SECCIO));
        var d = new Date();
        LAST_INPUT = d.getTime();
    });
    timer_h = setInterval(timer_help, TIMER_HELP_INTERVAL);
});

function timer_help()
{
    txt = l(SECCIO);
    var d = new Date();
    var tim = d.getTime();
    temps = tim - LAST_INPUT;

    if (SECCIO == LAST_AJUDA) return;
    if (temps < TIMER_HELP_INTERVAL) return;
    if (dialog_opened())    return;
    if (typeof window.orientation !== 'undefined')      return;

    LAST_AJUDA = SECCIO;
    help(txt);
}

function help(txt) {
    if ($.browser.name == "opera")
        $("#td_contingut").addClass("fals-overlay");
    if (dialog_opened())    return;
    if (txt) {
        txt = txt+ '<p><button class="simplemodal-close ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">'+l("Tanca")+'</span></button></p>';
        $("#osx-modal-data").html(txt);
    }
  OSX.init();
}

function dialog_opened() {
    if ($("#popup").dialog("isOpen"))       return true;
    if ($("#caixa_reserva_consulta_online").is(":visible")) return true;
    if ($("#osx-modal-content").is(":visible")) return true;
    
    //if ($("#popupGrups").hasClass('ui-dialog-content')) {alert("SIII");}
    if ($("#popupGrups").dialog("isOpen"))  return true;

    return false;
}