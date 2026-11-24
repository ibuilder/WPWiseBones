/**
 * WPWiseBones — industry hero calculator.
 *
 * Monthly principal-and-interest estimate for the mortgage hero panel. Runs
 * entirely in the browser; nothing is stored or sent.
 */
( function () {
	'use strict';

	function update( form ) {
		var price = parseFloat( form.elements.price.value ) || 0;
		var down = Math.min( Math.max( parseFloat( form.elements.down.value ) || 0, 0 ), 100 );
		var rate = ( parseFloat( form.elements.rate.value ) || 0 ) / 100 / 12;
		var months = ( parseInt( form.elements.term.value, 10 ) || 30 ) * 12;
		var principal = price * ( 1 - down / 100 );
		var payment = rate > 0
			? principal * rate / ( 1 - Math.pow( 1 + rate, -months ) )
			: principal / months;
		var currency = form.getAttribute( 'data-currency' ) || '$';

		form.elements.payment.value = isFinite( payment ) && payment > 0
			? currency + Math.round( payment ).toLocaleString()
			: '—';
	}

	document.querySelectorAll( '[data-wpb-calc]' ).forEach( function ( form ) {
		form.addEventListener( 'input', function () {
			update( form );
		} );
		update( form );
	} );
}() );
