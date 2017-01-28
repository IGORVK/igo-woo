<?php

/*
 * Plugin Name: iGo Custom Registration
 * Plugin URI: http://github.com/IGORVK
 * Description: Add custom field Skype to registration form WP, Woocommers and user's contact info WP dashboard.
 *              Redirect after Login/Registration.
 * Version: 1.0
 * Author: Igor Khaletskyy
 * Author URI: http://wp.medi-com.info
 */


/*
* Add more user contact fields
*/
if ( !function_exists ( 'igo_add_contact_fields' ) ) {
    function igo_add_contact_fields ( $profile_fields )
    {
        $profile_fields[ 'skype' ] = 'Skype';
        return $profile_fields;
    }
}
add_filter ( 'user_contactmethods', 'igo_add_contact_fields' );




//1. Add a new form element...
add_action( 'register_form', 'igo_skype_register_form' );
function igo_skype_register_form() {

    $skype = ( ! empty( $_POST['skype'] ) ) ? trim( $_POST['skype'] ) : '';

    ?>
    <p>
        <label for="skype"><?php _e( 'Skype', 'mydomain' ) ?><br />
            <input type="text" name="skype" id="skype" class="input" value="<?php echo esc_attr( wp_unslash( $skype ) ); ?>" size="25" /></label>
    </p>
    <?php
}

//2. Add validation. In this case, we make sure skype is required.
add_filter( 'registration_errors', 'igo_skype_registration_errors', 10, 3 );
function igo_skype_registration_errors( $errors, $sanitized_user_login, $user_email ) {

    if ( empty( $_POST['skype'] ) || ! empty( $_POST['skype'] ) && trim( $_POST['skype'] ) == '' ) {
        $errors->add( 'skype_error', __( '<strong>ERROR</strong>: Skype is a required field.', 'mydomain' ) );
    }

    return $errors;
}

//3. Finally, save our extra registration user meta.
add_action( 'user_register', 'igo_skype_user_register' );
function igo_skype_user_register( $user_id ) {
    if ( ! empty( $_POST['skype'] ) ) {
        update_user_meta( $user_id, 'skype', trim( $_POST['skype'] ) );
    }
}

/*
========================================================================================================================
*/

/*
 * Add custom fields to user / checkout woocommers
 */
add_action( 'woocommerce_after_order_notes', 'igo_woo_custom_checkout_field' );

function igo_woo_custom_checkout_field( $checkout ) {

    echo '<div id="bv_custom_checkout_field"><h2>Skype</h2>';

    /* Weight */
    woocommerce_form_field( 'skype', array(
        'type'          => 'text',
        'class'         => array('igo_woo-class form-row-wide'),
        'label'         => __('Your Skype<abbr class="required" title="required"> *</abbr>'),
        'placeholder'   => __('Your Skype'),
    ), get_user_meta(  get_current_user_id(),'skype' , true  ) );

    echo '</div>';
}

/* Verification*/
add_action('woocommerce_checkout_process', 'igo_woo_custom_checkout_field_process');

function igo_woo_custom_checkout_field_process() {
    // Check
    if ( ! $_POST['skype'] )
        wc_add_notice( __( '<strong>Your Skype </strong> is a required field' ), 'error' );
}

/*Update field*/
add_action( 'woocommerce_checkout_update_order_meta', 'igo_woo_custom_checkout_field_update_order_meta' );

function igo_woo_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['skype'] ) ) {
        update_user_meta( get_current_user_id(), 'skype', sanitize_text_field( $_POST['skype'], '' ));
    }
}

/* Redirect after registration/login
 =======================================================================================================================
 */

/*Registration Redirect*/
add_filter( 'registration_redirect', 'igo_registration_redirect' );
function igo_registration_redirect() {
    return home_url( '/cart/' );
}

/*Login Redirect*/
add_filter( 'login_redirect', 'igo_login_redirect' );
function igo_login_redirect() {
    // Change this to the url to Updates page.
    return home_url( '/cart/' );
}