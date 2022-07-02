<?php
/*
Plugin Name: Tiny Contact Form
Plugin URI: https://github.com/AshikNesin/wp-tiny-contact-form
Description: Simple no-configuration contact form for your WordPress
Version: 0.1
Author: Ashik Nesin
Author URI: https://nesin.io
*/
 
function html_form_code() {
    echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<p>';
    echo 'Your Name (required) <br/>';
    echo '<input type="text" name="tiny-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["tiny-name"] ) ? esc_attr( $_POST["tiny-name"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Email (required) <br/>';
    echo '<input type="email" name="tiny-email" value="' . ( isset( $_POST["tiny-email"] ) ? esc_attr( $_POST["tiny-email"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Subject (required) <br/>';
    echo '<input type="text" name="tiny-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["tiny-subject"] ) ? esc_attr( $_POST["tiny-subject"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Message (required) <br/>';
    echo '<textarea rows="10" cols="35" name="tiny-message">' . ( isset( $_POST["tiny-message"] ) ? esc_attr( $_POST["tiny-message"] ) : '' ) . '</textarea>';
    echo '</p>';
    echo '<p><input type="submit" name="tiny-submitted" value="Send"></p>';
    echo '</form>';
//Clear the TextBox in Contact Form --- Have to implement it..
	  
}
 
function deliver_mail() {
 
    // if the submit button is clicked, send the email
    if ( isset( $_POST['tiny-submitted'] ) ) {
 
        // sanitize form values
        $name    = sanitize_text_field( $_POST["tiny-name"] );
        $email   = sanitize_email( $_POST["tiny-email"] );
        $subject = sanitize_text_field( $_POST["tiny-subject"] );
        $message = esc_textarea( $_POST["tiny-message"] );
 
        // get the blog administrator's email address
        $to = get_option( 'admin_email' );
 
        $headers = "From: $name <$email>" . "\r\n";
 
        // If email has been process for sending, display a success message
        if ( wp_mail( $to, $subject, $message, $headers ) ) {
            echo '<div>';
            echo '<p><font face="verdana" color="green">Thanks for contacting me, expect a response soon.</font></p>';
            echo '</div>';
	   

        } else {
            echo 'An unexpected error occurred';
        }
    }
}
 
function tiny_shortcode() {
    ob_start();
    deliver_mail();
    html_form_code();
 
    return ob_get_clean();
}
 
add_shortcode( 'tiny_contact_form', 'tiny_shortcode' );
 
?>
