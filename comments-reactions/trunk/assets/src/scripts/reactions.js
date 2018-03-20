/**
 * @todo Add documentation.
 */
(function($) {
  /**
   * @todo Add documentation.
   */
  const Reactions = {
    selectors: {
      root    : '[data-reactions-root]',
      trigger : '[data-hscr-trigger]',
      popover : '[data-reactions-popover]',
      btnLike : '[data-trigger-like]',
      btnLove : '[data-trigger-loved]',
      btnHaha : '[data-trigger-haha]',
      btnWow  : '[data-trigger-wow]',
      btnSad  : '[data-trigger-sad]',
      btnAngry: '[data-trigger-angry]',
    },

    /**
     * @todo Add documentation.
     */
    $root: null,

    /**
     * @todo Add documentation.
     */
    $document: null,

    /**
     * @todo Add documentation.
     */
    animationEnd: null,

    /**
     * @todo Add documentation.
     */
    start() {
      this.$root        = $(this.selectors.root)
      this.$document    = $(document)
      this.animationEnd = this.checkAnimationEnd()
      this.bind()
    },

    /**
     * @todo Add documentation.
     */
    checkAnimationEnd() {
      const div = document.createElement('div')

      const animations = {
        animation      : 'animationend',
        OAnimation     : 'oAnimationEnd',
        MozAnimation   : 'mozAnimationEnd',
        WebkitAnimation: 'webkitAnimationEnd',
      }

      for (let t in animations) {
        if (div.style[t] !== undefined) {
          return animations[t];
        }
      }
    },

    /**
     * @todo Add documentation.
     */
    bind() {
      this.$root.on('click', this.selectors.trigger,  $.proxy(this.onTriggerClick, this))
      this.$root.on('click', this.selectors.btnLike,  $.proxy(this.onLikeClick,    this))
      this.$root.on('click', this.selectors.btnLove,  $.proxy(this.onLoveClick,    this))
      this.$root.on('click', this.selectors.btnHaha,  $.proxy(this.onHahaClick,    this))
      this.$root.on('click', this.selectors.btnWow,   $.proxy(this.onWowClick,     this))
      this.$root.on('click', this.selectors.btnSad,   $.proxy(this.onSadClick,     this))
      this.$root.on('click', this.selectors.btnAngry, $.proxy(this.onAngryClick,   this))
      this.$document.on('click', $.proxy(this.onClickOff, this))
      this.$document.on('keydown', $.proxy(this.onEscPress, this))
    },

    /**
     * @todo Add documentation.
     */
    onTriggerClick(event) {
      event.preventDefault()

      const $target   = $(event.target)
      const $root     = $target.closest(this.selectors.root)
      const $popover  = $root.find(this.selectors.popover)
      const isVisible = false === $popover.hasClass('hscr-sr-only')

      if (isVisible) {
        $(this.selectors.popover)
          .addClass('bounceOut')
          .one(this.animationEnd, (event) => {
            $(event.target)
              .addClass('hscr-sr-only')
              .removeClass('bounceOut')
          })
      } else {
        $(this.selectors.popover)
          .not($popover)
            .addClass('bounceOut')
            .one(this.animationEnd, (event) => {
              $(event.target)
                .addClass('hscr-sr-only')
                .removeClass('bounceOut')
            })

        $popover
          .removeClass('hscr-sr-only')
          .addClass('jackInTheBox')
          .one(this.animationEnd, (event) => {
            $(event.target)
              .removeClass('jackInTheBox')
          })
      }
    },

    /**
     * @todo Add documentation.
     */
    onLikeClick(event) {
      event.preventDefault()

      const info = this.getClosestRootInfo(event.target)

      this.doReaction('LIKE', info)
    },

    /**
     * @todo Add documentation.
     */
    onLoveClick(event) {
      event.preventDefault()

      const info = this.getClosestRootInfo(event.target)

      this.doReaction('LOVE', info)
    },

    /**
     * @todo Add documentation.
     */
    onHahaClick(event) {
      event.preventDefault()

      const info = this.getClosestRootInfo(event.target)

      this.doReaction('HAHA', info)
    },

    /**
     * @todo Add documentation.
     */
    onWowClick(event) {
      event.preventDefault()

      const info = this.getClosestRootInfo(event.target)

      this.doReaction('WOW', info)
    },

    /**
     * @todo Add documentation.
     */
    onSadClick(event) {
      event.preventDefault()

      const info = this.getClosestRootInfo(event.target)

      this.doReaction('SAD', info)
    },

    /**
     * @todo Add documentation.
     */
    onAngryClick(event) {
      event.preventDefault()

      const info = this.getClosestRootInfo(event.target)

      this.doReaction('ANGRY', info)
    },

    /**
     * @todo Add documentation.
     */
    doReaction(type, info) {
      $.ajax({
        url: CommentsReactions.url,
        type: 'POST',
        dataType: 'json',
        data: {
          action  : 'hscr_save_reaction',
          guard   : CommentsReactions.nonce,
          post    : info.post,
          comment : info.comment,
          reaction: type,
        },
      })
        .done($.proxy(this.onSaveSuccess, this))
        .fail($.proxy(this.onSaveFail, this))
    },

    /**
     * @todo Add documentation.
     */
    onSaveSuccess(response) {
      if (false === response.success) {
        console.log('Error...')
        return
      }

      const $root   = $(`[data-reactions-root][data-comment="${response.data.commentId}"]`)
      const results = this.getResultsTemplate(response.data.reactions)

      $root.find('[data-reactions-results]')
        .html(results)

      $root.find('.hscr-reaction')
        .removeClass('hscr-reaction--is-active')

      switch (response.data.type) {
        case 'LIKE':
          if ('REMOVED' === response.data.reactions.status) {
            $root.find('.hscr-reaction--like')
              .removeClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger')
              .text(CommentsReactions.labels.DEFAULT)
          } else {
            $root.find('.hscr-reaction--like')
              .addClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger hscr-btn-trigger--like')
              .text(CommentsReactions.labels.LIKE)
          }

          break;

        case 'LOVE':
          if ('REMOVED' === response.data.reactions.status) {
            $root.find('.hscr-reaction--love')
              .removeClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger')
              .text(CommentsReactions.labels.DEFAULT)
          } else {
            $root.find('.hscr-reaction--love')
              .addClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger hscr-btn-trigger--love')
              .text(CommentsReactions.labels.LOVE)
          }

          break;

        case 'HAHA':
          if ('REMOVED' === response.data.reactions.status) {
            $root.find('.hscr-reaction--haha')
              .removeClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger')
              .text(CommentsReactions.labels.DEFAULT)
          } else {
            $root.find('.hscr-reaction--haha')
              .addClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger hscr-btn-trigger--haha')
              .text(CommentsReactions.labels.HAHA)
          }

          break;

        case 'WOW':
          if ('REMOVED' === response.data.reactions.status) {
            $root.find('.hscr-reaction--wow')
              .removeClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger')
              .text(CommentsReactions.labels.DEFAULT)
          } else {
            $root.find('.hscr-reaction--wow')
              .addClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger hscr-btn-trigger--wow')
              .text(CommentsReactions.labels.WOW)
          }

          break;

        case 'SAD':
          if ('REMOVED' === response.data.reactions.status) {
            $root.find('.hscr-reaction--sad')
              .removeClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger')
              .text(CommentsReactions.labels.DEFAULT)
          } else {
            $root.find('.hscr-reaction--sad')
              .addClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger hscr-btn-trigger--sad')
              .text(CommentsReactions.labels.SAD)
          }

          break;

        case 'ANGRY':
          if ('REMOVED' === response.data.reactions.status) {
            $root.find('.hscr-reaction--angry')
              .removeClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger')
              .text(CommentsReactions.labels.DEFAULT)
          } else {
            $root.find('.hscr-reaction--angry')
              .addClass('hscr-reaction--is-active')

            $root.find('.hscr-btn-trigger')
              .removeClass()
              .addClass('hscr-btn-trigger hscr-btn-trigger--angry')
              .text(CommentsReactions.labels.ANGRY)
          }

          break;

        default:
          break;
      }

      $(this.selectors.popover)
        .addClass('bounceOut')
        .one(this.animationEnd, (event) => {
          $(event.target)
            .addClass('hscr-sr-only')
            .removeClass('bounceOut')
        })
    },

    /**
     * @todo Add documentation.
     */
    getResultsTemplate(reactions) {
      const items = []
      let total   = 0

      if (reactions.LIKE.length) {
        total = total + reactions.LIKE.length

        items.push(`
          <div class="hscr-results-item hscr-results-item--like">
            <span class="hscr-sr-only">${CommentsReactions.labels.LIKE}</span>
          </div>`
        )
      }

      if (reactions.LOVE.length) {
        total = total + reactions.LOVE.length

        items.push(`
          <div class="hscr-results-item hscr-results-item--love">
            <span class="hscr-sr-only">${CommentsReactions.labels.LOVE}</span>
          </div>`
        )
      }

      if (reactions.HAHA.length) {
        total = total + reactions.HAHA.length

        items.push(`
          <div class="hscr-results-item hscr-results-item--haha">
            <span class="hscr-sr-only">${CommentsReactions.labels.HAHA}</span>
          </div>`
        )
      }

      if (reactions.WOW.length) {
        total = total + reactions.WOW.length

        items.push(`
          <div class="hscr-results-item hscr-results-item--wow">
            <span class="hscr-sr-only">${CommentsReactions.labels.WOW}</span>
          </div>`
        )
      }

      if (reactions.SAD.length) {
        total = total + reactions.SAD.length

        items.push(`
          <div class="hscr-results-item hscr-results-item--sad">
            <span class="hscr-sr-only">${CommentsReactions.labels.SAD}</span>
          </div>`
        )
      }

      if (reactions.ANGRY.length) {
        total = total + reactions.ANGRY.length

        items.push(`
          <div class="hscr-results-item hscr-results-item--angry">
            <span class="hscr-sr-only">${CommentsReactions.labels.ANGRY}</span>
          </div>`
        )
      }

      if (total > 0) {
        items.push(`
          <div class="hscr-results-item hscr-results-item--summary">
            <span>${total}</span>
          </div>`
        )
      }

      return items.join('')
    },

    /**
     * @todo Add documentation.
     */
    onSaveFail(xhr, status, error) {
      console.log(error)
    },

    /**
     * @todo Add documentation.
     */
    onClickOff(event) {
      const clickedOff = $(event.target).closest(this.$root).length === 0

      if (clickedOff) {
        this.closePopovers()
      }
    },

    /**
     * @todo Add documentation.
     */
    onEscPress(event) {
      if (event.keyCode && event.keyCode === 27) {
        this.closePopovers()
      }
    },

    /**
     * @todo Add documentation.
     */
    getClosestRootInfo(element) {
      const $root = $(element).closest(this.selectors.root)

      return {
        post   : $root.data('post'),
        comment: $root.data('comment'),
      }
    },

    /**
     * @todo Add documentation.
     */
    closePopovers() {
      $(this.selectors.popover)
        .addClass('bounceOut')
        .one(this.animationEnd, (event) => {
          $(event.target)
            .addClass('hscr-sr-only')
            .removeClass('bounceOut')
        })
    },
  }

  /**
   * @todo Add documentation.
   */
  $(() => {
    Reactions.start()
  })
})(jQuery)
