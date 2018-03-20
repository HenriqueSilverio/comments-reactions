<?php
/**
 * @todo Add documentation.
 */

$reactions  = $attributes['reactions'];
$reacted    = $attributes['reacted'];
$trigger    = $attributes['trigger'];
$totalCount = 0;

if (false === empty($reactions['LIKE'])) {
  $totalCount = $totalCount + count($reactions['LIKE']);
}

if (false === empty($reactions['LOVE'])) {
  $totalCount = $totalCount + count($reactions['LOVE']);
}

if (false === empty($reactions['HAHA'])) {
  $totalCount = $totalCount + count($reactions['HAHA']);
}

if (false === empty($reactions['WOW'])) {
  $totalCount = $totalCount + count($reactions['WOW']);
}

if (false === empty($reactions['SAD'])) {
  $totalCount = $totalCount + count($reactions['SAD']);
}

if (false === empty($reactions['ANGRY'])) {
  $totalCount = $totalCount + count($reactions['ANGRY']);
}

?>

<div class="hscr-comments-reactions" data-reactions-root data-comment="<?php esc_attr_e($attributes['comment']); ?>" data-post="<?php esc_attr_e($attributes['post']); ?>">
  <div class="hscr-comments-reactions__results" data-reactions-results>
    <?php if (false === empty($reactions['LIKE'])) : ?>
      <div class="hscr-results-item hscr-results-item--like">
        <span class="hscr-sr-only">
          <?php esc_html_e('Like', 'comments-reactions'); ?>
        </span>
      </div>
    <?php endif; ?>

    <?php if (false === empty($reactions['LOVE'])) : ?>
      <div class="hscr-results-item hscr-results-item--love">
        <span class="hscr-sr-only">
          <?php esc_html_e('Love', 'comments-reactions'); ?>
        </span>
      </div>
    <?php endif; ?>

    <?php if (false === empty($reactions['HAHA'])) : ?>
      <div class="hscr-results-item hscr-results-item--haha">
        <span class="hscr-sr-only">
          <?php esc_html_e('Haha', 'comments-reactions'); ?>
        </span>
      </div>
    <?php endif; ?>

    <?php if (false === empty($reactions['WOW'])) : ?>
      <div class="hscr-results-item hscr-results-item--wow">
        <span class="hscr-sr-only">
          <?php esc_html_e('Wow', 'comments-reactions'); ?>
        </span>
      </div>
    <?php endif; ?>

    <?php if (false === empty($reactions['SAD'])) : ?>
      <div class="hscr-results-item hscr-results-item--sad">
        <span class="hscr-sr-only">
          <?php esc_html_e('Sad', 'comments-reactions'); ?>
        </span>
      </div>
    <?php endif; ?>

    <?php if (false === empty($reactions['ANGRY'])) : ?>
      <div class="hscr-results-item hscr-results-item--angry">
        <span class="hscr-sr-only">
          <?php esc_html_e('Angry', 'comments-reactions'); ?>
        </span>
      </div>
    <?php endif; ?>

    <?php if ($totalCount > 0) : ?>
      <div class="hscr-results-item hscr-results-item--summary">
        <span>
          <?php esc_html_e($totalCount); ?>
        </span>
      </div>
    <?php endif; ?>
  </div>

  <?php if (false === empty($attributes['user'])) : ?>
    <div class="hscr-comments-reactions__options hscr-sr-only animated" data-reactions-popover>
      <ul class="hscr-reactions-list">
        <li class="hscr-reactions-list__item">
          <button class="hscr-reaction hscr-reaction--like <?php echo 'LIKE' === $reacted ? 'hscr-reaction--is-active' : ''; ?>" type="button" data-trigger-like>
            <span class="hscr-sr-only">
              <?php _e('Like', 'comments-reactions'); ?>
            </span>
          </button>
        </li>
        <li class="hscr-reactions-list__item">
          <button class="hscr-reaction hscr-reaction--love <?php echo 'LOVE' === $reacted ? 'hscr-reaction--is-active' : ''; ?>" type="button" data-trigger-loved>
            <span class="hscr-sr-only">
              <?php _e('Love', 'comments-reactions'); ?>
            </span>
          </button>
        </li>
        <li class="hscr-reactions-list__item">
          <button class="hscr-reaction hscr-reaction--haha <?php echo 'HAHA' === $reacted ? 'hscr-reaction--is-active' : ''; ?>" type="button" data-trigger-haha>
            <span class="hscr-sr-only">
              <?php _e('Haha', 'comments-reactions'); ?>
            </span>
          </button>
        </li>
        <li class="hscr-reactions-list__item">
          <button class="hscr-reaction hscr-reaction--wow <?php echo 'WOW' === $reacted ? 'hscr-reaction--is-active' : ''; ?>" type="button" data-trigger-wow>
            <span class="hscr-sr-only">
              <?php _e('Wow', 'comments-reactions'); ?>
            </span>
          </button>
        </li>
        <li class="hscr-reactions-list__item">
          <button class="hscr-reaction hscr-reaction--sad <?php echo 'SAD' === $reacted ? 'hscr-reaction--is-active' : ''; ?>" type="button" data-trigger-sad>
            <span class="hscr-sr-only">
              <?php _e('Sad', 'comments-reactions'); ?>
            </span>
          </button>
        </li>
        <li class="hscr-reactions-list__item">
          <button class="hscr-reaction hscr-reaction--angry <?php echo 'ANGRY' === $reacted ? 'hscr-reaction--is-active' : ''; ?>" type="button" data-trigger-angry>
            <span class="hscr-sr-only">
              <?php _e('Angry', 'comments-reactions'); ?>
            </span>
          </button>
        </li>
      </ul>
    </div>

    <div class="hscr-comments-reactions__action">
      <button class="hscr-btn-trigger <?php esc_attr_e($trigger['modifier']); ?>" type="button" data-hscr-trigger>
        <span class="hscr-trigger-label">
          <?php esc_html_e($trigger['text']); ?>
        </span>
      </button>
    </div>
  <?php endif; ?>
</div>
