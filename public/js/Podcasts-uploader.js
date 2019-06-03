var $ = jQuery.noConflict()

var PodcastsUploader = {

  mediaUploader: false,

  run: function () {

    var this_class = this

    this_class.trigger('[name="podcats[audio]"]')

  },

  trigger: function (selector) {

    var this_class = this

    $(selector).on('click', function (e) {
      e.preventDefault()

      this_class.uploader($(this))

    })
  },

  uploader: function (selector) {
    var state
    var this_class = this

    if (this_class.mediaUploader) {
      this_class.mediaUploader.open()
      return
    }

    state = wp.media

    this_class.mediaUploader = wp.media({

      title: PodcastsUploaderLocalize.title,
      library: {
        type: ['audio'],
      },
      multiple: false,
      button: {
        text: PodcastsUploaderLocalize.button,
      },

    })

    this_class.mediaUploader.on('select', function () {

      var json = this_class.mediaUploader.state().
        get('selection').
        first().
        toJSON()

      selector.val(json.id)

      wp.media = state

    })

    this_class.mediaUploader.open()
  },
}

$(document).ready(function () {
  PodcastsUploader.run()
})
