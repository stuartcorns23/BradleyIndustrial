( function () {
	'use strict';

	var nav = document.getElementById( 'site-navigation' );
	if ( ! nav ) {
		return;
	}
	var toggle = nav.querySelector( '.menu-toggle' );
	if ( ! toggle ) {
		return;
	}

	function setOpen( open ) {
		nav.classList.toggle( 'is-open', open );
		toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
	}

	toggle.addEventListener( 'click', function () {
		setOpen( ! nav.classList.contains( 'is-open' ) );
	} );

	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key && nav.classList.contains( 'is-open' ) ) {
			setOpen( false );
			toggle.focus();
		}
	} );

	document.addEventListener( 'click', function ( e ) {
		if ( nav.classList.contains( 'is-open' ) && ! nav.contains( e.target ) ) {
			setOpen( false );
		}
	} );
} )();
