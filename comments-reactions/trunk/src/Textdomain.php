<?php
/**
 * @todo Add documentation.
 */

namespace HenriqueSilverio\CommentsReactions;

/**
 * @todo Add documentation.
 */
class Textdomain
{
    /**
     * @todo Add documentation.
     */
    public function start()
    {
        add_action('init', [$this, 'load']);
    }

    /**
     * @todo Add documentation.
     */
    public function load()
    {
        load_plugin_textdomain('comments-reactions', false, HSCR_PLUGIN_PATH . '/languages');
    }
}
