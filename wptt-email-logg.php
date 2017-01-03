<?php
/*
Plugin Name: WPTT Email Logging
Plugin URI: http://sfndesign.ca
Description: Stops all emails going out from WordPress and logs them.
Version: 1.3
Author: WP Theme Tutorial, Curtis McHale
Author URI: http://sfndesign.ca
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( ! class_exists( 'WP_Logging' ) ){
	require_once( plugin_dir_path( __FILE__ ) . 'WP_Logging.php' );
}

class WPTT_Email_Logging{

	public function __construct(){

		if ( $this->is_local() || $this->is_staging() ){
			add_filter( 'wp_logging_post_type_args', array( $this, 'change_cpt_args' ) );
		}

		add_action( 'phpmailer_init', array( $this, 'mail_log' ), 9999 );

	} // __construct

	/**
	 * Allows the user to define local sites
	 *
	 * @since 1.3
	 * @author SFNdesign, Curtis McHale
	 * @access private
	 *
	 * @filter wptt_email_logging_is_local         Allows other plugins to override internal settings
	 */
	private function is_local(){
		return apply_filters( 'wptt_email_logging_is_local', false );
	}

	/**
	 * Allows the user to define staging sites
	 *
	 * @since 1.3
	 * @author SFNdesign, Curtis McHale
	 * @access private
	 *
	 * @filter wptt_email_logging_is_staging         Allows other plugins to override internal settings
	 */
	private function is_staging(){
		return apply_filters( 'wptt_email_logging_is_staging', false );
	}

	/**
	 * Allows the user to define live sites
	 *
	 * @since 1.3
	 * @author SFNdesign, Curtis McHale
	 * @access private
	 *
	 * @filter wptt_email_logging_is_live         Allows other plugins to override internal settings
	 */
	private function is_live(){
		return apply_filters( 'wptt_email_logging_is_live', false );
	}

	/**
	 * Logs emails coming out of wp_mail by hooking phpmailer_init
	 *
	 * @since 1.3
	 * @author SFNdesign, Curtis McHale
	 *
	 * @param array/obj     $phpmailer     required     The PHP mailer object
	 *
	 * @return array/obj    $phpmailer                  Our maybe modified PHPmailer object
	 *
	 * @uses $this->is_live()                           Returns true if we are on a defined live environment
	 */
	public function mail_log( $phpmailer ){

		if ( $this->is_live() ) {
			return $phpmailer;
		} else {
			$this->create_log( $phpmailer );
			$phpmailer->ClearAllRecipients();
			return $phpmailer;
		}

	} // mail_log

	/**
	 * Creates our log in WP_Logging
	 *
	 * @since 1.3
	 * @author SFNdesign, Curtis McHale
	 * @access private
	 *
	 * @param array/obj     $phpmailer     required     PHPmailer object
	 *
	 * @uses esc_attr()                                 Keeping our email titles safe
	 * @uses wp_kses_post()                             Sanitizing content just like a WordPress post allows
	 * @uses WP_Logging::insert_log                     Inserts a log in WP_Logging
	 */
	private function create_log( $phpmailer ){

		$subject = $phpmailer->Subject;
		$content = $phpmailer->Body;

		$log_data = array(
			'post_title'     => 'Logged WordPress email Subject: ' . esc_attr( $subject ) .' ',
			'post_content'   => wp_kses_post( $content ),
			'log_type'       => 'event',
		);

		$log_meta = array(
			'phpmailer'           => $phpmailer,
		);

		WP_Logging::insert_log( $log_data, $log_meta );

	} // create_log

	/**
	 * Changes the default WP_Logging CPT items so that the default is to show
	 * them in the WordPress admin.
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 */
	public function change_cpt_args( $args = array() ){

		$args['public'] = true;

		return $args;

	} // change_cpt_args

} // WPTT_Email_Logging

$GLOBALS['wptt_basic_email_logging'] = new WPTT_Email_Logging();
