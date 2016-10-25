/**
 * modalEffects.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
var ModalEffects = (function() {

	function init() {

		var overlay = document.querySelector( '.ecp-overlay' );

		[].slice.call( document.querySelectorAll( '.ecp-trigger' ) ).forEach( function( el, i ) {

			var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
				close = modal.querySelector( '.ecp-close' );

			function removeModal( hasPerspective ) {
				classie.remove( modal, 'ecp-show' );

				if( hasPerspective ) {
					classie.remove( document.documentElement, 'ecp-perspective' );
				}
			}

			function removeModalHandler() {
				removeModal( classie.has( el, 'ecp-setperspective' ) ); 
			}

			el.addEventListener( 'click', function( ev ) {
				classie.add( modal, 'ecp-show' );
				overlay.removeEventListener( 'click', removeModalHandler );
				overlay.addEventListener( 'click', removeModalHandler );

				if( classie.has( el, 'ecp-setperspective' ) ) {
					setTimeout( function() {
						classie.add( document.documentElement, 'ecp-perspective' );
					}, 25 );
				}
			});

			close.addEventListener( 'click', function( ev ) {
				ev.stopPropagation();
				removeModalHandler();
			});

		} );

	}

	init();

})();