<?php
/**
 * @todo Add documentation.
 */

namespace HenriqueSilverio\CommentsReactions;

/**
 * @todo Add documentation.
 */
class Reactions
{
    /**
     * @todo Add documentation.
     */
    protected $repository;

    /**
     * @todo Add documentation.
     */
    protected $renderer;

    /**
     * @todo Add documentation.
     */
    public function __construct(Repository $repository, Renderer $renderer)
    {
        $this->repository = $repository;
        $this->renderer   = $renderer;
    }

    /**
     * @todo Add documentation.
     */
    public function start()
    {
        add_filter('comment_reply_link_args', [$this, 'append'], 10, 3);
    }

    /**
     * @todo Add documentation.
     */
    public function append($args, $comment, $post)
    {
        $userId    = get_current_user_id();
        $reactions = $this->repository->findById($comment->comment_ID);

        foreach ($reactions as $reaction => $data) {
            $index = array_search($userId, $data);

            if (false !== $index) {
                $foundAt = [
                    'type'  => $reaction,
                    'index' => $index,
                ];
            }
        }

        $args['before'] .= $this->renderer->render([
            'user'      => $userId,
            'post'      => $post->ID,
            'comment'   => $comment->comment_ID,
            'reacted'   => $foundAt['type'] ?? '',
            'reactions' => $reactions,
            'trigger'   => $this->getTriggerData($foundAt['type'] ?? ''),
        ]);

        return $args;
    }

    /**
     * @todo Add documentation.
     */
    protected function getTriggerData($type)
    {
        switch ($type) {
            case 'LIKE':
                $data = [
                    'modifier' => 'hscr-btn-trigger--like',
                    'text'     => __('Like', 'comments-reactions'),
                ];

                break;

            case 'LOVE':
                $data = [
                    'modifier' => 'hscr-btn-trigger--love',
                    'text'     => __('Love', 'comments-reactions'),
                ];

                break;

            case 'HAHA':
                $data = [
                    'modifier' => 'hscr-btn-trigger--haha',
                    'text'     => __('Haha', 'comments-reactions'),
                ];

                break;

            case 'WOW':
                $data = [
                    'modifier' => 'hscr-btn-trigger--wow',
                    'text'     => __('Wow', 'comments-reactions'),
                ];

                break;

            case 'SAD':
                $data = [
                    'modifier' => 'hscr-btn-trigger--sad',
                    'text'     => __('Sad', 'comments-reactions'),
                ];

                break;

            case 'ANGRY':
                $data = [
                    'modifier' => 'hscr-btn-trigger--angry',
                    'text'     => __('Angry', 'comments-reactions'),
                ];

                break;

            default:
                $data = [
                    'modifier' => '',
                    'text'     => __('Add your reaction', 'comments-reactions')
                ];

                break;
        }

        return $data;
    }
}
