# WPTT Basic Email Logging

Contributors: Curtis McHale
Tags: wp_mail, email logging
Requires at least: 3.0
Tested up to: 3.8
Stable tag: 1.1

Logs WordPress email.

## Description

If you have the proper constants defined this will log all emails in staging and local environments.

## Installation

1. Extract to your wp-content/plugins/ folder.

2. Activate the plugin.

3. Make sure you have [WPTT Developer Constants](https://github.com/curtismchale/WPTT-Developer-Constants) installed and configured.

## Usage

Set up the [WPTT Developer Constants](https://github.com/curtismchale/WPTT-Developer-Constants) plugin in your mu-plugins folder (create that folder if it doesn't exist).

Any environment that you want to log emails in (instead of sending them out) should have the constant defined.

## Changelog

### 1.1

- changed the constants so we assume you're using the [WPTT Developer Constants plugin](https://github.com/curtismchale/WPTT-Developer-Constants)

### 1.0

- intial commit with basic email logging
