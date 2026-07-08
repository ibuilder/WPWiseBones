( function () {
	'use strict';

	function pad( n ) {
		return String( n ).padStart( 2, '0' );
	}

	function tick( el ) {
		var target = new Date( el.dataset.date ).getTime();
		var now    = Date.now();
		var diff   = target - now;

		if ( diff <= 0 ) {
			[ '_d', '_h', '_m', '_s' ].forEach( function ( s ) {
				var span = document.getElementById( el.id + s );
				if ( span ) { span.textContent = '00'; }
			} );
			return;
		}

		var days    = Math.floor( diff / 86400000 );
		var hours   = Math.floor( ( diff % 86400000 ) / 3600000 );
		var minutes = Math.floor( ( diff % 3600000  ) / 60000  );
		var seconds = Math.floor( ( diff % 60000    ) / 1000   );

		var d = document.getElementById( el.id + '_d' );
		var h = document.getElementById( el.id + '_h' );
		var m = document.getElementById( el.id + '_m' );
		var s = document.getElementById( el.id + '_s' );

		if ( d ) { d.textContent = pad( days    ); }
		if ( h ) { h.textContent = pad( hours   ); }
		if ( m ) { m.textContent = pad( minutes ); }
		if ( s ) { s.textContent = pad( seconds ); }
	}

	function init() {
		document.querySelectorAll( '.wpb-countdown[data-date]' ).forEach( function ( el ) {
			if ( ! el.id || ! el.dataset.date ) { return; }
			tick( el );
			setInterval( function () { tick( el ); }, 1000 );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );
