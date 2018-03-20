<?php
/**
 * CommentsReactions uninstall
 *
 * @package HenriqueSilverio\CommentsReactions
 * @since 1.0.0
 */

/**
 * Prevents direct file access.
 */
if (false === defined('WP_UNINSTALL_PLUGIN')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    die();
}


/**
 * @var object WordPress Database object.
 * @since 1.0.0
 * @see https://developer.wordpress.org/reference/classes/wpdb
 */
global $wpdb;

/**
 * Remove Reactions metadata.
 *
 * @since 1.0.0
 */
$wpdb->delete($wpdb->commentmeta, ['meta_key' => 'hscr_reactions']);
