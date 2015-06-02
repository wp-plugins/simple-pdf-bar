<?php
/**
 * validate-fields-and-input.php
 *
 * This file validates and saves input
 *
 */

/** Validate hex-color */
function sanitize_hex_color( $color ) {
    if ( '' === $color )
        return '';
 
    /** 3 or 6 hex digits, or the empty string */
    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
        return $color;
 
    return null;
}

/** Start session - if any, error messages are added to session */
if (!session_id()){
    session_start();
}

/** Saves the pdfbar meta input */
function prfx_meta_save( $post_id ) {
 
    /** Checks save status */
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    $bar_hex_color = "";
    $bar_text_color = "";
    $bar_btn_color = "";
    $bar_btn_text_color = "";
    $bar_btn_color_second = "";
    $bar_btn_text_color_second = "";
    if(isset($_POST[ 'meta-bg-color' ])){
        $bar_hex_color = sanitize_hex_color($_POST[ 'meta-bg-color' ]);
    }
    if(isset($_POST[ 'meta-text-color' ])){
        $bar_text_color = sanitize_hex_color($_POST[ 'meta-text-color' ]);
    }
    if(isset($_POST[ 'meta-btn-color' ])){
        $bar_btn_color = sanitize_hex_color($_POST[ 'meta-btn-color' ]);
    }
    if(isset($_POST[ 'meta-btn-text-color' ])){
        $bar_btn_text_color = sanitize_hex_color($_POST[ 'meta-btn-text-color' ]);
    }
    if(isset($_POST[ 'meta-btn-color-second' ])){
        $bar_btn_color_second = sanitize_hex_color($_POST[ 'meta-btn-color-second' ]);
    }
    if(isset($_POST[ 'meta-btn-text-color-second' ])){
        $bar_btn_text_color_second = sanitize_hex_color($_POST[ 'meta-btn-text-color-second' ]);
    }
 
    /** Exits script depending on save status */
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    /** Checks for input and sanitizes/saves if needed */
    if( isset( $_POST[ 'meta-text' ] ) ) {
        update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
    }

    /** Checks for input and sanitizes/saves if needed */
    if( isset( $_POST[ 'meta-button-text' ] ) ) {
        update_post_meta( $post_id, 'meta-button-text', sanitize_text_field( $_POST[ 'meta-button-text' ] ) );
    }

    /** Checks for input and sanitizes/saves if needed */
    if( isset( $_POST[ 'meta-button-text-second' ] ) ) {
        update_post_meta( $post_id, 'meta-button-text-second', sanitize_text_field( $_POST[ 'meta-button-text-second' ] ) );
    }

    /** Checks for input and sanitizes/saves if needed */
    if( isset( $_POST[ 'meta-button-link' ] ) ) {
        update_post_meta( $post_id, 'meta-button-link', esc_url( $_POST[ 'meta-button-link' ] ) );
    }

    /** Checks for input and sanitizes/saves if needed */
    if( isset( $_POST[ 'meta-button-link-second' ] ) ) {
        update_post_meta( $post_id, 'meta-button-link-second', esc_url( $_POST[ 'meta-button-link-second' ] ) );
    }

    /** Checks for input and sanitizes/saves if needed */
    if( $bar_hex_color != "" ) {
         update_post_meta( $post_id, 'meta-bg-color', sanitize_hex_color( $_POST[ 'meta-bg-color' ] ) );
    } else if(isset( $_POST[ 'meta-bg-color' ])) {
        /** Set error message */
        $_SESSION['my_admin_notices'] .= '<div class="error"><p>Please specify a valid HEX value</p></div>';    
    }

    /** Checks for input and sanitizes/saves if needed */
    if( $bar_text_color != "" ) {
         update_post_meta( $post_id, 'meta-text-color', sanitize_hex_color( $_POST[ 'meta-text-color' ] ) );
    } else if(isset( $_POST[ 'meta-text-color' ])) {
        /** Set error message */
        $_SESSION['my_admin_notices'] .= '<div class="error"><p>Please specify a valid HEX value</p></div>';    
    }

    /** Checks for input and sanitizes/saves if needed */
    if( $bar_btn_color != "" ) {
         update_post_meta( $post_id, 'meta-btn-color', sanitize_hex_color( $_POST[ 'meta-btn-color' ] ) );
    } else if(isset( $_POST[ 'meta-btn-color' ])) {
        /** Set error message */
        $_SESSION['my_admin_notices'] .= '<div class="error"><p>Please specify a valid HEX value</p></div>';    
    }

    /** Checks for input and sanitizes/saves if needed */
    if( $bar_btn_text_color != "" ) {
         update_post_meta( $post_id, 'meta-btn-text-color', sanitize_hex_color( $_POST[ 'meta-btn-text-color' ] ) );
    } else if(isset( $_POST[ 'meta-btn-text-color' ])) {
        /** Set error message */
        $_SESSION['my_admin_notices'] .= '<div class="error"><p>Please specify a valid HEX value</p></div>';    
    }

    /** Checks for input and sanitizes/saves if needed */
    if( $bar_btn_color_second != "" ) {
         update_post_meta( $post_id, 'meta-btn-color-second', sanitize_hex_color( $_POST[ 'meta-btn-color-second' ] ) );
    } else if(isset( $_POST[ 'meta-btn-color-second' ])) {
        /** Set error message */
        $_SESSION['my_admin_notices'] .= '<div class="error"><p>Please specify a valid HEX value</p></div>';    
    }

    /** Checks for input and sanitizes/saves if needed */
    if( $bar_btn_text_color_second != "" ) {
         update_post_meta( $post_id, 'meta-btn-text-color-second', sanitize_hex_color( $_POST[ 'meta-btn-text-color-second' ] ) );
    } else if(isset( $_POST[ 'meta-btn-text-color-second' ])) {
        /** Set error message */
        $_SESSION['my_admin_notices'] .= '<div class="error"><p>Please specify a valid HEX value</p></div>';    
    }

    /** Checks for input and saves */
    if( isset( $_POST[ 'meta-checkbox-enablebar' ] ) ) {
        update_post_meta( $post_id, 'meta-checkbox-enablebar', 'yes' );
    } else {
        update_post_meta( $post_id, 'meta-checkbox-enablebar', '' );
    }
     
    /** Checks for input and saves */
    if( isset( $_POST[ 'meta-include-close' ] ) ) {
        update_post_meta( $post_id, 'meta-include-close', 'yes' );
    }

    /** Checks for input and saves */
    if( isset( $_POST[ 'meta-include-btn' ] ) ) {
        update_post_meta( $post_id, 'meta-include-btn', 'yes' );
    } else {
        update_post_meta( $post_id, 'meta-include-btn', '' );
    }

    /** Checks for input and saves */
    if( isset( $_POST[ 'meta-include-btn-second' ] ) ) {
        update_post_meta( $post_id, 'meta-include-btn-second', 'yes' );
    } else {
        update_post_meta( $post_id, 'meta-include-btn-second', '' );
    }

    /** Checks for input and saves */
    if( isset( $_POST[ 'meta-radio' ] ) ) {
        update_post_meta( $post_id, 'meta-radio', $_POST[ 'meta-radio' ] );
    }
 
}
add_action( 'save_post', 'prfx_meta_save' );

/** Function used to display error messages to user */
function my_admin_notices(){
  if(!empty($_SESSION['my_admin_notices'])) print  $_SESSION['my_admin_notices'];
  unset ($_SESSION['my_admin_notices']);
}
add_action( 'admin_notices', 'my_admin_notices' );


?>