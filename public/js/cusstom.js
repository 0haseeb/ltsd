function success() {
  // is post has only spaces or its empty
    if (/^ *$/.test(document.getElementById("post").value)) {
        document.getElementById('btnSubmit').disabled = true;
    } else {
        document.getElementById('btnSubmit').disabled = false;
    }

}
$(function () {
  $('[data-toggle="popover"]').popover()
})
$('#editModal').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget) // Button that triggered the modal
  var content = button.data('postbody') // Extract info from data-* attributes
  var postsid = button.data('postid') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  //modal.find('.modal-title').text('New message to ' + content)
  modal.find('.modal-body #content').val(content)
  modal.find('.modal-body #post_id').val(postsid)
})

$('#deleteModal').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget) // Button that triggered the modal
  var postsid = button.data('postid') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  //modal.find('.modal-title').text('New message to ' + content)
  modal.find('.modal-body #post_id').val(postsid)
})

$('#editprofileModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var name = button.data('name') // Extract info from data-* attributes
  var bio = button.data('bio') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  //modal.find('.modal-title').text('New message to ' + content)
  modal.find('.modal-body #name').val(name)
  modal.find('.modal-body #bio').val(bio)
})
