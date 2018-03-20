<?php
/**
 * @todo Add documentation.
 */

namespace HenriqueSilverio\CommentsReactions;

/**
 * @todo Add documentation.
 */
class Repository
{
    /**
     * @todo Add documentation.
     */
    protected $prefix = '';

    /**
     * @todo Add documentation.
     */
    const DEFAULTS = [
        'LIKE'  => [],
        'LOVE'  => [],
        'HAHA'  => [],
        'WOW'   => [],
        'SAD'   => [],
        'ANGRY' => [],
    ];

    /**
     * @todo Add documentation.
     */
    public function __construct(string $prefix = '')
    {
        $this->prefix = $prefix;
    }

    /**
     * @todo Add documentation.
     */
    public function findById($id)
    {
        if (false === is_numeric($id)) {
            return null;
        }

        $reactions = get_comment_meta($id, $this->prefix . '_reactions', true);

        if (empty($reactions)) {
            return self::DEFAULTS;
        }

        return $reactions;
    }

    /**
     * @todo Add documentation.
     */
    public function commit($type, $commentId, $userId)
    {
        $metaKey   = $this->prefix . '_reactions';
        $reactions = $this->findById($commentId);
        $foundAt   = false;
        $status    = '';

        foreach ($reactions as $reaction => $data) {
            $index = array_search($userId, $data);

            if (false !== $index) {
                $foundAt = [
                    'type'  => $reaction,
                    'index' => $index,
                ];
            }
        }

        if (is_array($foundAt)) {
            $founType   = $foundAt['type'];
            $foundIndex = $foundAt['index'];

            array_splice($reactions[$founType], $foundIndex, 1);

            $status = 'REMOVED';
        }

        if ($type !== $foundAt['type']) {
            $reactions[$type][] = $userId;

            $status = 'UPDATED';
        }

        update_comment_meta($commentId, $metaKey, $reactions);

        $reactions['status'] = $status;

        return $reactions;
    }
}
