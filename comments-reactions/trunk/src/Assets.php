<?php
/**
 * @todo Add documentation.
 */

namespace HenriqueSilverio\CommentsReactions;

/**
 * @todo Add documentation.
 */
class Assets
{
    /**
     * @todo Add documentation.
     */
    public function start()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    }

    /**
     * @todo Add documentation.
     */
    public function enqueue()
    {
        wp_enqueue_style(
            'hscr-comments-reactions',
            HSCR_ASSETS_URL . '/styles/reactions.min.css',
            [],
            '1.0.0',
            'all'
        );

        wp_enqueue_script(
            'hscr-comments-reactions',
            HSCR_ASSETS_URL . '/scripts/reactions.min.js',
            ['jquery'],
            '1.0.0',
            true
        );

        $params = [
            'url'    => admin_url('admin-ajax.php'),
            'nonce'  => wp_create_nonce('hscr-save-reaction'),
            'labels' => [
                'DEFAULT' => __('Add your reaction', 'comments-reactions'),
                'LIKE'    => __('Like', 'comments-reactions'),
                'LOVE'    => __('Love', 'comments-reactions'),
                'HAHA'    => __('Haha', 'comments-reactions'),
                'WOW'     => __('Wow', 'comments-reactions'),
                'SAD'     => __('Sad', 'comments-reactions'),
                'ANGRY'   => __('Angry', 'comments-reactions'),
            ],
        ];

        wp_localize_script('hscr-comments-reactions', 'CommentsReactions', $params);
    }
}
