jQuery(function ($) {
  $('[name="podcats[audio]"]').on('click', function () {
    var elem = $(this)

    wp.media.editor.send.attachment = function (info, file) {
      console.log(info)
      console.log(file)
    }

    wp.media.editor.open(this)

    return false

  })

})

// items_frame = wp.media.frames.items = wp.media({
//   title: 'Add to Gallery',
//   button: {
//     text: 'Select'
//   },
//   library: {
//     type: [ 'video', 'image' ]
//   },
// });
