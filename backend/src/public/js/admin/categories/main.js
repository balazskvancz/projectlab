document.addEventListener('DOMContentLoaded', (event) => {
  const error = document.querySelector('#error');

  if (!error) {
    return
  }

  const modal = document.querySelector('#newCategoryModal');

  if (!modal) {
    return
  }

  var modalObject = new bootstrap.Modal(modal, {})

  modalObject.toggle();
});
