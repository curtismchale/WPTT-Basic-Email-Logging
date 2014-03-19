=== WPTT Basic Email Logging ===

Contributors: Curtis McHale
Tags: wp_mail, email logging
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 1.0

Logs WordPress email.

== Description ==

If you have the `DEVELOPMENT` constant defined all outgoing email from WordPress will be logged instead of sent.

== Installation ==

1. Extract to your wp-content/plugins/ folder.

2. Activate the plugin.

== Usage ==

Define a constant in `wp-config.php` like:

```php
define( 'DEVELOPMENT', true );
```

Any environment that you want to log emails in (instead of sending them out) should have the constant defined.

== Changelog ==

= 1.0 =

- intial commit with basic email logging