/**
 * Megjeleníti a modal-t, benne a képpel.
 *
 * @param {string} imagePath
 */
function onClickOpenModal(imagePath) {
  const modal = document.querySelector('#imageModal')

  if (!modal) {
    return
  }

  const imageElement = document.querySelector('#displayImage')

  if (!imageElement) {
    return
  }

  imageElement.src = `/images/uploads/${imagePath}`

  new bootstrap.Modal(modal, {}).toggle()
}

/**
 * Fájlfeltöltés input state-jeit kezelő függvény.
 */
inputChanged = () => {
  var filename = document.querySelector("#image").value;

  if (/^\s*$/.test(filename)) {
    document.querySelector(".file-upload").classList.remove('active');
    document.querySelector("#noFile").innerHTML = "Nincs fájl kiválasztva...";
  }
  else {

    document.querySelector(".file-upload").classList.add('active');
    document.querySelector("#noFile").innerHTML = filename.replace("C:\\fakepath\\", "");
  }
}

