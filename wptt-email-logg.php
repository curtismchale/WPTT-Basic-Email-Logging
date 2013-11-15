<?php
/*
Plugin Name: WPTT Email Logging
Plugin URI: http://wpthemetutorial.com
Description: Stops all emails going out from WordPress and logs them.
Version: 1.0
Author: WP Theme Tutorial, Curtis McHale
Author URI: http://wpthemetutorial.com
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

require_once( plugin_dir_path( __FILE__ ) . 'WP_Logging.php' );

/**
 * Setting up our changes to the WP_Logging class
 *
 * @since 1.1
 * @author SFNdesign, Curtis McHale
 */
function wptt_email_logg_cpt_mods(){

	if ( defined( 'LOCAL_ENV' ) && LOCAL_ENV || defined( 'STAGING_ENV' ) && STAGING_ENV ){
		add_filter( 'wp_logging_post_type_args', 'wptt_change_cpt_args' );
	}

} // wptt_email_logg_cpt_mods
add_action( 'setup_theme', 'wptt_email_logg_cpt_mods' );

/**
 * Changes the default WP_Logging CPT items so that the default is to show
 * them in the WordPress admin.
 *
 * @since 1.0
 * @author SFNdesign, Curtis McHale
 */
function wptt_change_cpt_args( $args ){

	$args['public'] = true;

	return $args;

} // wptt_change_cpt_args

if ( ! function_exists( 'wp_mail' ) ){

	if ( defined( 'LOCAL_ENV' ) && LOCAL_ENV || defined( 'staging_env' ) && STAGING_ENV ){

		function wp_mail( $to, $subject, $message, $headers = '', $attachments = array() ){
			global $post;

			if ( ! is_object( $post ) ) $post_id = null;

			$log_data = array(
				'post_title'     => 'Logged WordPress email to ' . $to . '',
				'post_content'   => $message,
				'post_parent'    => $post_id,
				'log_type'       => 'event',
			);

			$log_meta = array(
				'to'           => $to,
				'subject'      => $subject,
				'message'      => $message,
				'headers'      => $headers,
				'attachments'  => $attachments,
				'current_user' => wp_get_current_user(),
				'post_object'  => $post,
			);

			WP_Logging::insert_log( $log_data, $log_meta );
		} // wp_mail

	}

} // if
