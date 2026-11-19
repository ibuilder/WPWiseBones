/*
 * Becoming - the only JavaScript this theme ships.
 *
 * It does one thing: remember a colour-scheme choice. No layout depends on it.
 * With JS blocked or broken, prefers-color-scheme still gives the visitor the
 * right theme and every page still works - which is the standard the tw-*
 * modules hold themselves to, so the theme holds it too.
 */
( function () {
	'use strict';

	var KEY = 'bc-theme';
	var root = document.documentElement;

	/* localStorage throws rather than returning null in a private window with
	   site data blocked, so every access is wrapped. A visitor who cannot
	   store a preference still gets a working toggle for the session. */
	function read() {
		try {
			return window.localStorage.getItem( KEY );
		} catch ( e ) {
			return null;
		}
	}

	function write( value ) {
		try {
			window.localStorage.setItem( KEY, value );
		} catch ( e ) {
			/* Nothing to do. The attribute below still applies for this page. */
		}
	}

	function systemPrefersDark() {
		return !! ( window.matchMedia && window.matchMedia( '(prefers-color-scheme: dark)' ).matches );
	}

	function current() {
		var stored = read();

		if ( 'dark' === stored || 'light' === stored ) {
			return stored;
		}

		return systemPrefersDark() ? 'dark' : 'light';
	}

	function announce( button, theme ) {
		button.setAttribute(
			'aria-label',
			'dark' === theme ? 'Switch to the light colour scheme' : 'Switch to the dark colour scheme'
		);
	}

	function init() {
		var buttons = document.querySelectorAll( '[data-bc-theme-toggle]' );

		if ( ! buttons.length ) {
			return;
		}

		Array.prototype.forEach.call( buttons, function ( button ) {
			announce( button, current() );

			button.addEventListener( 'click', function () {
				var next = 'dark' === current() ? 'light' : 'dark';

				root.setAttribute( 'data-theme', next );
				write( next );

				Array.prototype.forEach.call( buttons, function ( other ) {
					announce( other, next );
				} );
			} );
		} );

		/* Follow the system if the visitor has never chosen explicitly. */
		if ( window.matchMedia ) {
			var query = window.matchMedia( '(prefers-color-scheme: dark)' );
			var onChange = function () {
				if ( null === read() ) {
					root.removeAttribute( 'data-theme' );

					Array.prototype.forEach.call( buttons, function ( other ) {
						announce( other, current() );
					} );
				}
			};

			if ( query.addEventListener ) {
				query.addEventListener( 'change', onChange );
			} else if ( query.addListener ) {
				query.addListener( onChange );
			}
		}
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );
