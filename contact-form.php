<?php
/*
Plugin Name: HugeThoughts's Contact Form
Plugin URI: http://www.hugethoughts.com
Description: Simple WordPress Contact Form which uses less resources when compared with others.
Version: 1.0
Author: Ashik Nesin
Author URI: http://www.AshikNesin.com
*/
 
function html_form_code() {
    echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<p>';
    echo 'Your Name (required) <br/>';
    echo '<input type="text" name="hts-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["hts-name"] ) ? esc_attr( $_POST["hts-name"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Email (required) <br/>';
    echo '<input type="email" name="hts-email" value="' . ( isset( $_POST["hts-email"] ) ? esc_attr( $_POST["hts-email"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Subject (required) <br/>';
    echo '<input type="text" name="hts-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["hts-subject"] ) ? esc_attr( $_POST["hts-subject"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Message (required) <br/>';
    echo '<textarea rows="10" cols="35" name="hts-message">' . ( isset( $_POST["hts-message"] ) ? esc_attr( $_POST["hts-message"] ) : '' ) . '</textarea>';
    echo '</p>';
    echo '<p><input type="submit" name="hts-submitted" value="Send"></p>';
    echo '</form>';
//Clear the TextBox in Contact Form --- Have to implement it..
	  
}
 
function deliver_mail() {
 
    // if the submit button is clicked, send the email
    if ( isset( $_POST['hts-submitted'] ) ) {
 
        // sanitize form values
        $name    = sanitize_text_field( $_POST["hts-name"] );
        $email   = sanitize_email( $_POST["hts-email"] );
        $subject = sanitize_text_field( $_POST["hts-subject"] );
        $message = esc_textarea( $_POST["hts-message"] );
 
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
 
function hts_shortcode() {
    ob_start();
    deliver_mail();
    html_form_code();
 
    return ob_get_clean();
}
 
add_shortcode( 'hugethoughts_contact_form', 'hts_shortcode' );
 
?>
