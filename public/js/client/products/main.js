document.addEventListener('DOMContentLoaded', (event) => {

  const error = document.querySelector('#error');

  if (!error) {
    return
  }

  const modal = document.querySelector('#newProductModal')

  if (!modal) {
    return
  }

  const modalObject = new bootstrap.Modal(modal, {})

  modalObject.toggle();

});
