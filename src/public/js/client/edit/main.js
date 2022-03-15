
function onClickOpenImageModal(path) {

  const image = document.querySelector('#image');
  image.src = `/images/uploads/${path}`

  var myImageModal = new bootstrap.Modal(document.querySelector('#imageModal'), {})

  myImageModal.toggle();

}
