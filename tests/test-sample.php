<?php

class WPTT_Email_Tests extends WP_UnitTestCase {

	private $plugin;
	private $class_name;

	function setUp(){
		parent::setUp();
		$this->plugin = $GLOBALS['wptt_basic_email_logging'];
		$this->class_name = 'WPTT_Email_Logging';
	} // setUp

	/**
	 * Makes sure that our plugin global is around so the plugin is active
	 */
	function testPluginActive(){
		$this->assertFalse( null == $this->plugin, 'testPluginActive says the plugin is not active' );
	}

	/**
	 * Verifies that we change the CPT args properly to be visible.
	 */
	function testChangeCPTArgs(){
		$cpt_args = $this->plugin->change_cpt_args();
		$this->assertFalse( $cpt_args['public'] === false, 'The CPT args should be true so you can see the logs silly' );
	} // testChangeCPTArgs

	/**
	 * Making sure the mail log main function exists
	 */
	function test_mail_log_function_exists(){
		$this->assertTrue( method_exists( $this->class_name, 'mail_log' ), 'WPTT_Email_Logging->mail_log does not exist' );
	}

} // WPTT_Email_Tests

