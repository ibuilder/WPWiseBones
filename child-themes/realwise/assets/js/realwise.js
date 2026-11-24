/* RealWise — header shadow on scroll + scroll-reveal animations */
( function () {
    'use strict';

    function onScroll() {
        document.body.classList.toggle( 'rw-scrolled', window.scrollY > 10 );
    }

    function init() {
        window.addEventListener( 'scroll', onScroll, { passive: true } );
        onScroll();

        var els = document.querySelectorAll( '.rw-reveal' );
        if ( ! els.length ) {
            return;
        }
        if ( ! ( 'IntersectionObserver' in window ) ) {
            els.forEach( function ( el ) { el.classList.add( 'is-visible' ); } );
            return;
        }
        var io = new IntersectionObserver( function ( entries ) {
            entries.forEach( function ( e ) {
                if ( e.isIntersecting ) {
                    e.target.classList.add( 'is-visible' );
                    io.unobserve( e.target );
                }
            } );
        }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' } );
        els.forEach( function ( el ) { io.observe( el ); } );
    }

    if ( document.readyState !== 'loading' ) {
        init();
    } else {
        document.addEventListener( 'DOMContentLoaded', init );
    }
}() );
