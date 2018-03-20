<?php
/**
 * @todo Add documentation.
 */

namespace HenriqueSilverio\CommentsReactions;

/**
 * @todo Add documentation.
 */
class Renderer
{
    /**
     * @todo Add documentation.
     */
    public function render(array $attributes = [])
    {
        ob_start();

        require HSCR_TEMPLATES_PATH . '/reactions.php';

        return ob_get_clean();
    }
}
