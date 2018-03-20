<?php
/**
 * @todo Add documentation.
 */

namespace HenriqueSilverio\CommentsReactions;

/**
 * @todo Add documentation.
 */
class Ajax
{
    /**
     * @todo Add documentation.
     */
    protected $repository;

    /**
     * @todo Add documentation.
     */
    protected $whitelist = ['LIKE', 'LOVE', 'HAHA', 'WOW', 'SAD', 'ANGRY'];

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @todo Add documentation.
     */
    public function start()
    {
        add_action('wp_ajax_hscr_save_reaction', [$this, 'handle']);
    }

    /**
     * @todo Add documentation.
     */
    public function handle()
    {
        if (false === $this->canStore()) {
            wp_send_json_error([], 403);
        }

        // 1. Get post reactions.
        // 2. Test against user ID.
        // 3. If already reacted:
        //   3.1. If is the same reaction
        //     3.1.1. Remove user ID from list.
        //   3.2 Else:
        //     3.2.1. Move user ID from X reaction to Y.
        // 4. Else:
        //   4.1. Add user ID to list.
        // 5. Return data.

        $userId       = get_current_user_id();
        $postId       = (int) sanitize_text_field($_POST['post']);
        $commentId    = (int) sanitize_text_field($_POST['comment']);
        $reactionType = strtoupper(sanitize_text_field($_POST['reaction']));

        $reactions = $this->repository->commit(
            $reactionType,
            $commentId,
            $userId
        );

        $data = [
            'commentId' => $commentId,
            'type'      => $reactionType,
            'reactions' => $reactions,
        ];

        wp_send_json_success($data, 200);
    }

    /**
     * @todo Add documentation.
     */
    protected function canStore()
    {
        $reaction = isset($_POST['reaction']) ? strtoupper(sanitize_text_field($_POST['reaction'])) : false;

        $doingAjax     = wp_doing_ajax();
        $validNonce    = check_ajax_referer('hscr-save-reaction', 'guard');
        $validReaction = in_array($reaction, $this->whitelist);

        return $doingAjax && $validNonce && $validReaction;
    }
}
