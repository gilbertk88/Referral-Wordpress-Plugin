<?php

/**
 * Plugin Name: Referral (Premium)
 * Description: Add referrals that are then sent an email and added onto hubspot.
 * Version: 1.1.1
 * Update URI:
 * Author: James Powell
 * Author URI: 
 * Text Domain: jp-referral
 * Domain Path: /languages/
 * License: GPLv2 or any later version
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or later, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package WPBDP
*/

add_action( 'admin_enqueue_scripts', 'gil_r_load_admin_resources' );
function gil_r_load_admin_resources( $options = array() )
{
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'gil-r-main-lib-uploader-js', plugins_url( basename( dirname( __FILE__ ) ) . '/assets/script-admin.js', 'jquery' ) );
    wp_localize_script( 'gil-r-main-lib-uploader-js', 'ajax_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ) ) ;
}

add_action( 'wp_enqueue_scripts', 'gil_r_load_public_resources' );
function gil_r_load_public_resources( $options = array() )
{
    wp_enqueue_script( 'jquery' );
    // wp_enqueue_script( 'jquery-ui-core', false, array('jquery') );
    wp_enqueue_script('jquery-ui-datepicker');

    wp_enqueue_script( 'gil-r-public-main-lib-uploader-js', plugins_url( basename( dirname( __FILE__ ) ) . '/assets/script-public.js', 'jquery' ) );

    wp_localize_script( 'gil-r-public-main-lib-uploader-js', 'ajax_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ) );

}

function gil_r_admin_menu()
{

    add_menu_page(
        __( 'Contact Referral', 'gil-r-plugin' ),
        __( 'Contact Referral', 'gil-r-plugin' ),
        'manage_options',
        'gil-r-child',
        'gil_r_admin_page_contents',
        'dashicons-format-quote',
        3
    );

    add_submenu_page(
        'gil-r-child',
        'Email Template',
        'Email Template',
        'edit_pages',
        'gil-r-email-template',
        'gil_r_email_template',
        2
    ) ;

    // hubspot API
    add_submenu_page(
        'gil-r-child',
        'Hubspot API',
        'Hubspot API',
        'edit_pages',
        'gil-r-hubspot-api',
        'gil_r_hubspot_api',
        2
    ) ;

    // Thank you page
    add_submenu_page(
        'gil-r-child',
        'Thank You Page',
        'Thank You Page',
        'edit_pages',
        'gil-r-typ',
        'gil_r_typ',
        2
    ) ;

}

add_action( 'admin_menu', 'gil_r_admin_menu' );

function gil_r_typ(){

    // setup guidlines
    include dirname( __FILE__ ) . '/templates/thank_you_page_settings.php';

}

function gil_r_admin_page_contents(){

    // setup guidlines
    include dirname( __FILE__ ) . '/templates/contact_list.php';

}

function gil_r_email_template(){

    // setup guidlines
    include dirname( __FILE__ ) . '/templates/email_template.php';
    
}

function gil_r_hubspot_api(){
    
    // setup guidlines
    include dirname( __FILE__ ) . '/templates/hubspot_api.php';
    
}

function gil_r_referral_form()
{
    ob_start();
        include dirname( __FILE__ ) . '/templates/gil_r_contact_form.php';
    return ob_get_clean();
}

add_shortcode( 'referral_form', 'gil_r_referral_form' ) ;
function gil_f_new_contact_post( $entry = [] ){

    $current_user_id = 1 ;
    $name_l = $entry['fname'] .'-'. $entry['lname'] .'-'. $entry['email'] .'-'. $entry['phone' ] .'-'. $entry['field_id'];
    $content_slug = $entry['fname'] .'-'. $entry['lname'];

    // Create post
    $post_data = [
        "post_author"           => $current_user_id,
        "post_date"             => date( 'Y-m-d H:i:s' ),
        "post_date_gmt"         => date( 'Y-m-d H:i:s' ),
        "post_content"          => $name_l,
        "post_title"            => $name_l,
        "post_excerpt"          => $name_l,
        "post_status"           => "entered",
        "comment_status"        => "open",
        "ping_status"           => "closed",
        "post_password"         => "",
        "post_name"             => $content_slug,
        "to_ping"               => "",
        "pinged"                => "",
        "post_modified"         => date( 'Y-m-d H:i:s' ),
        "post_modified_gmt"     => date( 'Y-m-d H:i:s' ),
        "post_content_filtered" => "",
        "guid"                  => "",
        "menu_order"            => 0,
        "post_type"             => "gil_f_cl",
        "post_mime_type"        => "",
        "comment_count"         => "0",
        "filter"                => "raw",
    ] ;

    global  $wp_error ;
    $post_id = wp_insert_post( $post_data, $wp_error );

    return $post_id;

}

function gil_f_save_list_of_contacts( $entries = [] ){

    foreach( $entries  as $key => $entry ){

        // create post
        $post_id = gil_f_new_contact_post( $entry );

        // create post meta
        foreach( $entry as $meta_key => $meta_value){
            update_post_meta( $post_id, $meta_key, $meta_value );
        }

    }

    return $post_id;

}

add_action( "wp_ajax_nopriv_gil_send_email", "gil_send_email" );
add_action( "wp_ajax_gil_send_email", "gil_send_email" );
function gil_send_email(){

    $email_sent = gil_r_process_single_email( [
        'contact_id' => $_POST['gil_send_email_id'] ,
    ] ) ;

    $message = '';

    if( $email_sent ){
        $message = 'Email has been successfully sent' ;
    }
    else{
        $message = 'Email was not sent, please make sure that the email is entered correctly' ;
    }

    echo json_encode( [
        'post_id' => $_POST[ 'gil_send_email_id' ] ,
        'message' => $message,
    ] ) ;

    wp_die();
    
}

// Send hubspot
add_action( "wp_ajax_nopriv_gil_send_hubspot", "gil_send_hubspot" ) ;
add_action( "wp_ajax_gil_send_hubspot", "gil_send_hubspot" ) ;
function gil_send_hubspot() {

    $contact_id = $_POST[ "gil_send_hubspot_id" ] ;

    $fname = get_post_meta( $contact_id , 'fname', true ) ;
    $lname = get_post_meta( $contact_id , 'lname', true ) ;
    $email = get_post_meta( $contact_id , 'email', true ) ;
    $phone = get_post_meta( $contact_id , 'phone', true ) ;
    $field_id = get_post_meta( $contact_id , 'field_id', true ) ;
    $gil_f_referer = get_post_meta( $contact_id , 'gil_f_referer', true ) ;

    $hubspot_api_sent = get_post_meta( $contact_id , 'hubspot_api_sent', true ) ;

    $gil_api_is_sent = gil_r_send_single_contact_to_hubspot( [
            'contact_id'=> $contact_id,
            'email'     => $email,
            'firstname' => $fname,
            'lastname'  => $lname,
            'phone'     => $phone,
            'field_id'  => $field_id,
            'referer'   => $gil_f_referer
    ] ) ;

    if( $gil_api_is_sent ) {
        $message = 'Hubspot API has been successfully updated' ;
    }
    else {
        $message = 'An error happened, Hubspot API was not successfully updated' ;
    }

    echo json_encode( [
        'post_id' => $contact_id ,
        'message' => $message ,
        'api_is_sent' => $gil_api_is_sent
    ] ) ;

    wp_die() ;

}

// gil_delete_contact
add_action( "wp_ajax_nopriv_gil_delete_contact", "gil_delete_contact" );
add_action( "wp_ajax_gil_delete_contact", "gil_delete_contact" );
function gil_delete_contact() {

    $_POST_data = get_post( $_POST['gil_contact_id'] );

    $_message = '' ;

    if( is_null( $_POST_data ) ){
        $_message = 'Contact had already been deleted.' ;
    }
    else{
        $gil_delete_status = wp_delete_post( $_POST['gil_contact_id'] ) ;
        $_message = 'Contact has been successfully deleted.';
    }

    echo json_encode( [
        'post_id' => $_POST['gil_contact_id'] ,
        'message' => $_message ,
    ] ) ;

    wp_die();

}

add_action( "wp_ajax_nopriv_gil_f_save_form_feilds", "gil_f_save_form_feilds" );
add_action( "wp_ajax_gil_f_save_form_feilds", "gil_f_save_form_feilds" );
function gil_f_save_form_feilds() {

    $entries = [];
    $gil_f_referer = json_decode( stripslashes_from_strings_only( $_POST['gil_f_referer'] ), 'ARRAY' );

    foreach( $_POST as $key => $val ) {

        if( $key == 'action' || $key == 'gil_f_referer' ){}
        else{

            $server_details_l = json_decode( stripslashes_from_strings_only( $val ), 'ARRAY' );
            $server_details_l['gil_f_referer'] = $gil_f_referer['name'] ;
            $server_details_l['email_sent'] = 'not_sent' ;
            $server_details_l['hubspot_api_sent'] = 'not_sent' ;

            $entries[ $server_details_l['field_id'] ] = $server_details_l ;

        }
        
    }

    $post_id = gil_f_save_list_of_contacts( $entries );

    echo json_encode( [
        'post_id' => $post_id
    ] ) ;

    wp_die();

}

// email admin management
function gil_create_email_post(){

    $current_user_id    = 1 ;
    $name_l             = 'gil email post';
    $content_slug       = 'gil-email-post';

    $post_data = [
        "post_author"           => $current_user_id,
        "post_date"             => date( 'Y-m-d H:i:s' ),
        "post_date_gmt"         => date( 'Y-m-d H:i:s' ),
        "post_content"          => $name_l,
        "post_title"            => $name_l,
        "post_excerpt"          => $name_l,
        "post_status"           => "entered",
        "comment_status"        => "open",
        "ping_status"           => "closed",
        "post_password"         => "",
        "post_name"             => $content_slug,
        "to_ping"               => "",
        "pinged"                => "",
        "post_modified"         => date( 'Y-m-d H:i:s' ),
        "post_modified_gmt"     => date( 'Y-m-d H:i:s' ),
        "post_content_filtered" => "",
        "guid"                  => "",
        "menu_order"            => 0,
        "post_type"             => "gil_email_d",
        "post_mime_type"        => "",
        "comment_count"         => "0",
        "filter"                => "raw",
    ] ;

    global  $wp_error ;
    $post_id = wp_insert_post( $post_data, $wp_error );

    add_option( 'gil_get_email_post_id', $post_id ) ;

    return $post_id;
    
}

function gil_update_email_post_data( $post_data = [] ){

    $_data_p1 = update_post_meta( $post_data['gil_get_email_post_id'], 'gil_email_from' , $_POST['gil_email_from'] ) ;
    $_data_p2 = update_post_meta( $post_data['gil_get_email_post_id'], 'gil_email_subject' , $_POST['gil_email_subject'] ) ;

    $current_user_id    = 1 ;
    $name_l             = 'gil email post' ;
    $content_slug       = 'gil-email-post' ;

    $_data_p = [
        "ID"                    => $post_data['gil_get_email_post_id'],
        "post_author"           => $current_user_id,
        "post_date"             => date( 'Y-m-d H:i:s' ),
        "post_date_gmt"         => date( 'Y-m-d H:i:s' ),
        "post_content"          => $_POST['gil_email_body'],
        "post_title"            => $name_l,
        "post_excerpt"          => $name_l,
        "post_status"           => "entered",
        "comment_status"        => "open",
        "ping_status"           => "closed",
        "post_password"         => "",
        "post_name"             => $content_slug,
        "to_ping"               => "",
        "pinged"                => "",
        "post_modified"         => date( 'Y-m-d H:i:s' ),
        "post_modified_gmt"     => date( 'Y-m-d H:i:s' ),
        "post_content_filtered" => "",
        "guid"                  => "",
        "menu_order"            => 0,
        "post_type"             => "gil_email_d",
        "post_mime_type"        => "",
        "comment_count"         => "0",
        "filter"                => "raw",
    ] ;

    $_data_p3 = wp_update_post( $_data_p );

    return true;

}

function gil_get_email_post_id() {

    // Check if exists
    $gil_get_email_post_id = get_option( 'gil_get_email_post_id' );

    // If id does not exists create it and return
    if( $gil_get_email_post_id == FALSE ){
        $gil_get_email_post_id = gil_create_email_post() ;
    }

    return $gil_get_email_post_id;

}

function gil_r_process_single_email( $single_contact = [] ){

    $gil_get_email_post_id = get_option( 'gil_get_email_post_id' ) ;
    $gil_email_post_data = get_post( $gil_get_email_post_id ) ;
    $original_text = $gil_email_post_data->post_content;

    $single_contact_email = get_post_meta( $single_contact['contact_id'] , 'email' ) ;


    $new_value = get_post_meta( $single_contact['contact_id'] , 'gil_f_referer', true ) ;

    if( !$new_value ){
        $new_value = 'a friend';
    }

    var_dump( $single_contact['contact_id'] );

    // schedule id
    $mail_subject   = get_post_meta( $gil_get_email_post_id, 'gil_email_subject', true ) ;
    $mail_content = str_replace( '[referrer]', $new_value, $original_text ) ;

    $recipient_list = $single_contact_email ;

    $email_from     = get_post_meta( $gil_get_email_post_id, 'gil_email_from', TRUE ) ;

    $headers  = 'MIME-Version: 1.0' . "\r\n" ;
    $headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n" ;
    $headers .= 'From: '. $email_from . "\r\n" ;

    $email_sent  = false;

    if( $single_contact_email !== false ) {
        $email_sent = wp_mail( $recipient_list, $mail_subject, $mail_content, $headers ) ;
        $email_update = update_post_meta( $single_contact['contact_id'] , 'email_sent', 'sent' ) ;
        $email_sent = true ;
    }

	return $email_sent;
    
}

// todo trigger ->
function gil_r_schedule_emails(){

    require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php');

    $gil_r_contact_emails_list = get_posts( [
        "post_status"   => "entered",
        "post_type"     => "gil_f_cl",
        'posts_per_page' => -1,
        'meta_key'    => 'email_sent',
        'meta_value'  => 'not_sent',
        'fields' => 'ids'
    ] ) ; // var_dump($gil_r_contact_emails_list );

    foreach( $gil_r_contact_emails_list as $email_k => $email_id ){

        gil_r_process_single_email( [
            'contact_id' => $email_id,
        ] ) ;

    }

}

add_action( "wp_ajax_nopriv_gil_f_save_email_d", "gil_f_save_email_d" );
add_action( "wp_ajax_gil_f_save_email_d", "gil_f_save_email_d" );
function gil_f_save_email_d(){

    $gil_get_email_post_id = gil_get_email_post_id();

    gil_update_email_post_data( [
        'gil_get_email_post_id' => $gil_get_email_post_id
    ] );

    echo json_encode( [
        'email_save' => true
    ] );

    wp_die();

}

// Thank you page id
add_action( "wp_ajax_nopriv_gil_r_save_thankyou_page_id", "gil_r_save_thankyou_page_id" );
add_action( "wp_ajax_gil_r_save_thankyou_page_id", "gil_r_save_thankyou_page_id" );
function gil_r_save_thankyou_page_id(){
    
    update_option( 'gil_thankyou_id', $_POST['gil_thankyou_id'] );

    echo json_encode( [
        'api_save' => true
    ] );

    wp_die();

}

// hubspot api
add_action( "wp_ajax_nopriv_gil_send_hubspot_api_details", "gil_send_hubspot_api_details" );
add_action( "wp_ajax_gil_send_hubspot_api_details", "gil_send_hubspot_api_details" );
function gil_send_hubspot_api_details(){
    
    update_option( 'gil_hubspot_key_f', $_POST['gil_hubspot_key_f'] );

    echo json_encode( [
        'api_save' => true
    ] );

    wp_die();

}

/*
    [
        'contact_id'=> $contact_id,
        'email'     => $email,
        'firstname' => $fname,
        'lastname'  => $lname,
        'phone'     => $phone,
        'field_id'  => $field_id,
        'referer'   => $gil_f_referer
    ]
*/
function gil_r_send_single_contact_to_hubspot( $args = [] ) {

    $api_key = get_option('gil_hubspot_key_f');

    if( $api_key == false ) {
        return false;
    }

    // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.hubapi.com/crm/v3/objects/contacts/batch/create');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"inputs\": [\n    {\n      \"properties\": {\n        \"email\": \"".$args['email']."\",\n        \"phone\": \"".$args['phone']."\",\n        \"company\": \"Refferel\",\n        \"website\": \"refferal.net\",\n        \"lastname\": \"".$args['lastname']."\",\n        \"firstname\": \"".$args['firstname']."\"\n      }\n    }\n  ]\n}" );

    $headers = array();
    $headers[] = 'Authorization: Bearer '.$api_key ;
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        return false;
    }
    curl_close($ch);
    
    $email_update = update_post_meta( $args['contact_id'] , 'hubspot_api_sent', 'sent' ) ;

    return true;

}

// TODO trigger gil_r_loop_though_unsent_api
function gil_r_loop_though_unsent_api(){

    $api_key = get_option('gil_hubspot_key_f');

    $gil_r_contact_emails_list = get_posts( [
        "post_status"   => "entered",
        "post_type"     => "gil_f_cl",
        'posts_per_page' => -1,
        'meta_key'    => 'hubspot_api_sent',
        'meta_value'  => 'not_sent',
        'fields' => 'ids'
    ] ) ;

    foreach( $gil_r_contact_emails_list as $email_k => $contact_id ){

        $fname = get_post_meta( $contact_id , 'fname', true );
        $lname = get_post_meta( $contact_id , 'lname', true );
        $email = get_post_meta( $contact_id , 'email', true );
        $phone = get_post_meta( $contact_id , 'phone', true );
        $field_id = get_post_meta( $contact_id , 'field_id', true );
        $gil_f_referer = get_post_meta( $contact_id , 'gil_f_referer', true );

        $hubspot_api_sent = get_post_meta( $contact_id , 'hubspot_api_sent', true );

        $gil_api_is_sent = gil_r_send_single_contact_to_hubspot( [
            'contact_id'=> $contact_id,
            'email'     => $email,
            'firstname' => $fname,
            'lastname'  => $lname,
            'phone'     => $phone,
            'field_id'  => $field_id,
            'referer'   => $gil_f_referer
        ] ) ;

    }
    
}

// add_shortcode( 'gil_r_loop_email_and_api', 'gil_r_loop_email_and_api' );
add_action( 'wp_footer', 'gil_r_loop_email_and_api' );

function gil_r_loop_email_and_api(){

    gil_r_schedule_emails();
    gil_r_loop_though_unsent_api();

}

?>