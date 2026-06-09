/**
 * WPWiseBones — customizer.js
 * Handles live postMessage preview updates in the Customizer.
 * Loaded only inside the Customizer preview frame.
 *
 * https://wprealwise.com
 */

( function( $ ) {
    'use strict';

    var api = wp.customize;

    /* ── Hero section ──────────────────────────────────────────── */

    api( 'wpb_hero_heading', function( value ) {
        value.bind( function( newval ) {
            $( '.wpb-hero h1, .wpb-hero .display-4' ).text( newval );
        } );
    } );

    api( 'wpb_hero_subheading', function( value ) {
        value.bind( function( newval ) {
            $( '.wpb-hero .lead, .wpb-hero p.lead' ).text( newval );
        } );
    } );

    api( 'wpb_hero_btn_text', function( value ) {
        value.bind( function( newval ) {
            $( '.wpb-hero a.btn' ).text( newval );
        } );
    } );

    api( 'wpb_hero_btn_url', function( value ) {
        value.bind( function( newval ) {
            $( '.wpb-hero a.btn' ).attr( 'href', newval );
        } );
    } );

    /* ── Brand colours ─────────────────────────────────────────── */

    function setCSS( prop, val ) {
        document.documentElement.style.setProperty( prop, val );
    }

    api( 'wpb_color_primary', function( value ) {
        value.bind( function( newval ) {
            setCSS( '--bs-primary', newval );
            // Update all btn-primary and widget-title border
            var style = document.getElementById( 'wpb-customizer-live-css' );
            if ( ! style ) {
                style = document.createElement( 'style' );
                style.id = 'wpb-customizer-live-css';
                document.head.appendChild( style );
            }
            style.textContent = [
                ':root { --bs-primary: ' + newval + '; }',
                '.btn-primary { background-color: ' + newval + '; border-color: ' + newval + '; }',
                '.widget-title { border-color: ' + newval + '; }',
                '.wpb-hero { background: linear-gradient(135deg, ' + newval + ', var(--wpb-accent, #6610f2)); }',
                'a { color: ' + newval + '; }',
                '.pagination .page-item.active .page-link { background-color: ' + newval + '; border-color: ' + newval + '; }',
            ].join( '\n' );
        } );
    } );

    api( 'wpb_color_secondary', function( value ) {
        value.bind( function( newval ) {
            setCSS( '--bs-secondary', newval );
        } );
    } );

    api( 'wpb_color_accent', function( value ) {
        value.bind( function( newval ) {
            setCSS( '--wpb-accent', newval );
        } );
    } );

    api( 'wpb_color_header_bg', function( value ) {
        value.bind( function( newval ) {
            $( '.site-header' ).css( 'background-color', newval );
        } );
    } );

    api( 'wpb_color_footer_bg', function( value ) {
        value.bind( function( newval ) {
            $( '.site-footer' ).css( 'background-color', newval );
        } );
    } );

    /* ── Typography ────────────────────────────────────────────── */

    api( 'wpb_base_font_size', function( value ) {
        value.bind( function( newval ) {
            $( 'body' ).css( 'font-size', newval + 'px' );
        } );
    } );

} )( jQuery );
