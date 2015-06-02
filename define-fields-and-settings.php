<?php
/**
 * define-fields-and-settings.php
 *
 * This file contains admin fields and settings
 *
 */

/** Add PDF "Upload"-field */
function add_custom_meta_boxes() {  
    add_meta_box('wp_custom_attachment', 'Upload PDF file', 'wp_custom_attachment', 'pdfbar', 'normal', 'high');  
}
add_action('add_meta_boxes', 'add_custom_meta_boxes');  

function wp_custom_attachment() {

	$filearray = get_post_meta( get_the_ID(), 'wp_custom_attachment', true );

	if(empty($filearray)){
		$html = '<p class="description">';
	    $html .= 'Upload a new PDF here.';
	} else {
		$attached_pdf = $filearray['url'];
		echo "<div style='color: green;'>Attached PDF file: ". $attached_pdf . "</div>";
		$html = '<hr><p class="description">';
        $html .= 'Replace with another PDF here.';
	}

    wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');
    $html .= '</p>';
    $html .= '<input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="25">';
    $html .= '<div style="margin-top: 10px;"><input name="save" type="submit" class="button button-primary button-large" id="uploadbtn" value="Upload"></div>';
    echo $html;

}

/** Upload attached pdf (if valid) */
add_action('save_post', 'save_custom_meta_data');
function save_custom_meta_data($id) {
    if(!empty($_FILES['wp_custom_attachment']['name'])) {
        $supported_types = array('application/pdf');
        $arr_file_type = wp_check_filetype(basename($_FILES['wp_custom_attachment']['name']));
        $uploaded_type = $arr_file_type['type'];

        if(in_array($uploaded_type, $supported_types)) {
            $upload = wp_upload_bits($_FILES['wp_custom_attachment']['name'], null, file_get_contents($_FILES['wp_custom_attachment']['tmp_name']));
            if(isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {
            		add_post_meta($id, 'wp_custom_attachment', $upload);
                update_post_meta($id, 'wp_custom_attachment', $upload);
            }
        }
        else {
            wp_die("The file type that you've uploaded is not a PDF.");
        }
    }
}

function update_edit_form() {
    echo ' enctype="multipart/form-data"';
}
add_action('post_edit_form_tag', 'update_edit_form');


/** Adds a meta box to the post editing screen */
function pdfb_settings_meta() {
    add_meta_box( 'prfx_meta', __( 'PDF-bar Settings', 'pdfb-textdomain' ), 'pdfb_settings_callback', 'pdfbar' );
}
add_action( 'add_meta_boxes', 'pdfb_settings_meta' );

/** Outputs the content of the pdfbar meta box */
function pdfb_settings_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>
    <div>
        <label for="meta-checkbox-enablebar">
            <input type="checkbox" name="meta-checkbox-enablebar" id="meta-checkbox-enablebar" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-checkbox-enablebar'] ) ){checked( $prfx_stored_meta['meta-checkbox-enablebar'][0], 'yes' );}?> />
            <?php _e( 'Enable PDF-bar', 'pdfb-textdomain' )?>
        </label>
    </div>
    <div class="pdf-bar-settings">
        <p>
            <label for="meta-text" class="prfx-row-title"><strong><?php _e( 'Text to show in bar', 'pdfb-textdomain' )?></strong></label><br/>
            <input type="text" size="65" name="meta-text" id="meta-text" value="<?php if ( isset ( $prfx_stored_meta['meta-text'] ) ){echo $prfx_stored_meta['meta-text'][0];} else { echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";} ?>" />
        </p>

        <p>
            <label for="meta-bg-color" class="prfx-row-title"><strong><?php _e( 'Bar background color', 'pdfb-textdomain' )?></strong></label><br/>
            <input class="color-field" name="meta-bg-color" id="meta-bg-color" value="<?php if ( isset ( $prfx_stored_meta['meta-bg-color'] ) ){echo $prfx_stored_meta['meta-bg-color'][0];} else { echo "#3183b9";} ?>">
        </p>

        <p>
            <label for="meta-text-color" class="prfx-row-title"><strong><?php _e( 'Bar text color', 'pdfb-textdomain' )?></strong></label><br/>
            <input class="color-field" name="meta-text-color" id="meta-text-color" value="<?php if ( isset ( $prfx_stored_meta['meta-text-color'] ) ){echo $prfx_stored_meta['meta-text-color'][0];} else { echo "#fff";} ?>">
        </p>

        <p>
            <span class="prfx-row-title"><?php _e( '', 'pdfb-textdomain' )?></span>
            <div class="prfx-row-content">
                <label for="meta-include-close">
                    <input type="checkbox" name="meta-include-close" id="meta-include-close" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-include-close'] ) ){checked( $prfx_stored_meta['meta-include-close'][0], 'yes' );} ?> />
                    <?php _e( 'Include Close-button', 'pdfb-textdomain' )?>
                </label>
            </div>
        </p>
        <span class="prfx-row-title"><strong><?php _e( 'Location of bar', 'prfx-textdomain' )?></strong></span>
        <div class="prfx-row-content">
            <label for="meta-location-bottom">
                <input type="radio" name="meta-radio" id="meta-location-bottom" value="location-bottom" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'location-bottom' ); else echo "checked"; ?>>
                <?php _e( 'Bottom', 'prfx-textdomain' )?>
            </label>
            <label for="meta-location-top">
                <input type="radio" name="meta-radio" id="meta-location-top" value="location-top" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'location-top' ); ?>>
                <?php _e( 'Top', 'prfx-textdomain' )?>
            </label>
        </div>
        <hr>
            <h3 style="padding-left: 0px; padding-bottom: 0px;"><?php _e( 'Button', 'pdfb-textdomain' )?></h3>
        <p style="margin-bottom: 0px;">
            <label for="meta-include-btn">
                <input type="checkbox" name="meta-include-btn" id="meta-include-btn" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-include-btn'] ) ){checked( $prfx_stored_meta['meta-include-btn'][0], 'yes' );} ?> />
                <?php _e( 'Include button', 'pdfb-textdomain' )?>
            </label>
        </p>
        <div class="btn-settings first">
            <p>
                <label for="meta-button-text" class="prfx-row-title"><strong><?php _e( 'Button text', 'pdfb-textdomain' )?></strong></label><br/>
                <input type="text" size="65" name="meta-button-text" id="meta-button-text" value="<?php if ( isset ( $prfx_stored_meta['meta-button-text'] ) ){echo $prfx_stored_meta['meta-button-text'][0];} else { echo "My button";} ?>" />
            </p>
            <p>
                <label for="meta-button-link" class="prfx-row-title"><strong><?php _e( 'Button link', 'pdfb-textdomain' )?></strong></label><br/>
                <input type="text" size="65" name="meta-button-link" id="meta-button-link" value="<?php if ( isset ( $prfx_stored_meta['meta-button-link'] ) ){echo $prfx_stored_meta['meta-button-link'][0];} else { echo "http://www.some-url.com";} ?>" />
            </p>
            <p>
                <label for="meta-btn-color" class="prfx-row-title"><strong><?php _e( 'Button background color', 'pdfb-textdomain' )?></strong></label><br/>
                <input class="color-field" name="meta-btn-color" id="meta-btn-color" value="<?php if ( isset ( $prfx_stored_meta['meta-btn-color'] ) ){echo $prfx_stored_meta['meta-btn-color'][0];} else { echo "#5fb760";} ?>">
            </p>
            <p>
                <label for="meta-btn-text-color" class="prfx-row-title"><strong><?php _e( 'Button text color', 'pdfb-textdomain' )?></strong></label><br/>
                <input class="color-field" name="meta-btn-text-color" id="meta-btn-text-color" value="<?php if ( isset ( $prfx_stored_meta['meta-btn-text-color'] ) ){echo $prfx_stored_meta['meta-btn-text-color'][0];} else { echo "#fff";} ?>">
            </p>
        </div>

        <hr>
        <h3 style="padding-left: 0px; padding-bottom: 0px;"><?php _e( 'Button (second)', 'pdfb-textdomain' )?></h3>
        <p style="margin-bottom: 0px;">
            <label for="meta-include-btn-second">
                <input type="checkbox" name="meta-include-btn-second" id="meta-include-btn-second" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-include-btn-second'] ) ){checked( $prfx_stored_meta['meta-include-btn-second'][0], 'yes' );} ?> />
                <?php _e( 'Include button', 'pdfb-textdomain' )?>
            </label>
        </p>
        <div class="btn-settings second">
            <p>
                <label for="meta-button-text-second" class="prfx-row-title"><strong><?php _e( 'Button text', 'pdfb-textdomain' )?></strong></label><br/>
                <input type="text" size="65" name="meta-button-text-second" id="meta-button-text-second" value="<?php if ( isset ( $prfx_stored_meta['meta-button-text-second'] ) ){echo $prfx_stored_meta['meta-button-text-second'][0];} else { echo "Another button";} ?>" />
            </p>
            <p>
                <label for="meta-button-link-second" class="prfx-row-title"><strong><?php _e( 'Button link', 'pdfb-textdomain' )?></strong></label><br/>
                <input type="text" size="65" name="meta-button-link-second" id="meta-button-link-second" value="<?php if ( isset ( $prfx_stored_meta['meta-button-link-second'] ) ){echo $prfx_stored_meta['meta-button-link-second'][0];} else { echo "http://www.some-url.com";} ?>" />
            </p>
            <p>
                <label for="meta-btn-color-second" class="prfx-row-title"><strong><?php _e( 'Button background color', 'pdfb-textdomain' )?></strong></label><br/>
                <input class="color-field" name="meta-btn-color-second" id="meta-btn-color-second" value="<?php if ( isset ( $prfx_stored_meta['meta-btn-color-second'] ) ){echo $prfx_stored_meta['meta-btn-color-second'][0];} else { echo "#236691";} ?>">
            </p>
            <p>
                <label for="meta-btn-text-color-second" class="prfx-row-title"><strong><?php _e( 'Button text color', 'pdfb-textdomain' )?></strong></label><br/>
                <input class="color-field" name="meta-btn-text-color-second" id="meta-btn-text-color-second" value="<?php if ( isset ( $prfx_stored_meta['meta-btn-text-color-second'] ) ){echo $prfx_stored_meta['meta-btn-text-color-second'][0];} else { echo "#76acce";} ?>">
            </p>
        </div>
    </div>
 
    <?php
}


/** Includes: Validate and save input */
include( plugin_dir_path( __FILE__ ) . 'validate-fields-and-input.php');


/** Function used to output pdfbar based on user's configuration */
function output_pdfbar($content) {
    global $post;
    if(get_post_type() == 'pdfbar'){
        /** Retrieves the stored values from the database */
        /** Basic pdfbar */
        $bar_text = get_post_meta( get_the_ID(), 'meta-text', true );
        $bar_color = get_post_meta( get_the_ID(), 'meta-bg-color', true );
        $bar_text_color = get_post_meta( get_the_ID(), 'meta-text-color', true );
        $pdf_bar_enabled = get_post_meta( get_the_ID(), 'meta-checkbox-enablebar', true );
        $include_close_btn = get_post_meta( get_the_ID(), 'meta-include-close', true );
        /** First button */
        $pdf_btn_enabled = get_post_meta( get_the_ID(), 'meta-include-btn', true );
        $btn_text = get_post_meta( get_the_ID(), 'meta-button-text', true );
        $btn_link = get_post_meta( get_the_ID(), 'meta-button-link', true );
        $bar_btn_bg_color = get_post_meta( get_the_ID(), 'meta-btn-color', true );
        $bar_btn_text_color = get_post_meta( get_the_ID(), 'meta-btn-text-color', true );
        /** Second button */
        $pdf_btn_enabled_second = get_post_meta( get_the_ID(), 'meta-include-btn-second', true );
        $btn_text_second = get_post_meta( get_the_ID(), 'meta-button-text-second', true );
        $btn_link_second = get_post_meta( get_the_ID(), 'meta-button-link-second', true );
        $bar_btn_bg_color_second = get_post_meta( get_the_ID(), 'meta-btn-color-second', true );
        $bar_btn_text_color_second = get_post_meta( get_the_ID(), 'meta-btn-text-color-second', true );
        if($pdf_bar_enabled == 'yes'){
            $html = '<div style="background:' . $bar_color . '" id="pdf-bar">';
            $html .= '<div style="color:' . $bar_text_color . '" class="inner">';
            $html .= $bar_text;
            if($pdf_btn_enabled == 'yes'){
                $html .= '<a href="' . $btn_link . '" style="background:' . $bar_btn_bg_color . '; color: ' . $bar_btn_text_color . ';" class="btn">' . $btn_text . '</a>';
            }
            if($pdf_btn_enabled_second == 'yes'){
                $html .= '<a href="' . $btn_link_second . '" style="background:' . $bar_btn_bg_color_second . '; color: ' . $bar_btn_text_color_second . ';" class="btn">' . $btn_text_second . '</a>';
            }
            if($include_close_btn == 'yes'){
                $html .= '<span class="close-btn"></span>';
            }
            $html .= '</div></div>';
            echo $html;
        }
    }
    return $content;
}
add_action( 'the_content', 'output_pdfbar' );

?>