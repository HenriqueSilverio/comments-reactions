<?php
/**
 * @todo Add documentation.
 */

namespace HenriqueSilverio\CommentsReactions;

/**
 * @todo Add documentation.
 */
final class Plugin
{
    /**
     * @todo Add documentation.
     */
    const VERSION = '0.0.1';

    /**
     * @todo Add documentation.
     */
    protected static $instance;

    /**
     * @todo Add documentation.
     */
    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @todo Add documentation.
     */
    public function start()
    {
        $this->defineConstants();

        $textdomain = new Textdomain();
        $textdomain->start();

        $assets = new Assets();
        $assets->start();

        $repository = new Repository('hscr');

        $ajax = new Ajax($repository);
        $ajax->start();

        $renderer  = new Renderer();
        $reactions = new Reactions($repository, $renderer);
        $reactions->start();
    }

    /**
     * @todo Add documentation.
     */
    public function defineConstants()
    {
        if (false === defined('HSCR_PLUGIN_PATH')) {
            define('HSCR_PLUGIN_PATH', dirname(__FILE__, 2));
        }

        if (false === defined('HSCR_TEMPLATES_PATH')) {
            define('HSCR_TEMPLATES_PATH', HSCR_PLUGIN_PATH . '/templates');
        }

        if (false === defined('HSCR_ASSETS_URL')) {
            define('HSCR_ASSETS_URL', plugins_url('assets/dist', HSCR_PLUGIN_PATH . '/comments-reactions.php'));
        }
    }
}
