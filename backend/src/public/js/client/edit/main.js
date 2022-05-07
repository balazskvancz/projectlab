let apikey = ''
let userId = 0
let productId =  0
let csrf = ''
/**
 * Megnyit egy modal-t benne egy adott path-en élő képpel.
 *
 * @param {string} path
 */
function onClickOpenImageModal(path) {

  const modal = document.querySelector('#imageModal')

  if (!modal) {
    return
  }

  const image = document.querySelector('#image')

  if (!image) {
    return
  }
  image.src = `/images/uploads/${path}`

  new bootstrap.Modal(modal, {}).toggle()

}

/**
 * Felszól a szervernek, hogy töröljön egy adott képet.
 * @param {number} imageId
 */
function onClickDeleteImage(imageId) {
  const postBody = { apikey, userId, imageId}

  fetch('/api/images/delete', {
    method: 'POST',
    body: JSON.stringify(postBody),
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf
    }
  }).then((response) => {
    if (response.status === 200) {
      getAllPictures()
    }
  })
}

/**
 * Feltölti adatokkal a képeket megjelenítő táblát.
 *
 * @param {Images[]} data
 */
function populateImagesTable(data) {
  const tbody = document.querySelector('tbody');

  // Ha nincs tábla, akkor ne csináljunk semmit.
  if (!tbody) {
    return
  }

  tbody.innerHTML = ''

  data.forEach((image) => {
    const tr = document.createElement('tr');

    const leftTd = document.createElement('td');
    leftTd.classList.add('text-center')

    // Megnyitás gomb.
    const openBtn = document.createElement('button');
    openBtn.classList.add('btn', 'btn-primary', 'shadow-none');
    openBtn.addEventListener('click', () => {
      onClickOpenImageModal(image.path)
    })
    openBtn.type = 'button'
    openBtn.innerText = 'MEGNYITÁS'
    leftTd.appendChild(openBtn)

    const rightTd = document.createElement('td')
    rightTd.classList.add('text-center')

    const delBtn = document.createElement('button')
    delBtn.classList.add('btn', 'btn-danger', 'shadow-none')
    delBtn.type = 'button'
    delBtn.addEventListener('click', () => {
      onClickDeleteImage(image.id)
    })
    delBtn.innerText = 'TÖRLÉS'
    rightTd.appendChild(delBtn)


    tr.appendChild(leftTd)
    tr.appendChild(rightTd)

    tbody.appendChild(tr)
  });
}

/**
 * Api végponttól lekéri az összes képet az adott termékhez.
 */
function getAllPictures() {
  const postBody = { apikey, userId, productId }

  fetch('/api/images/getall', {
    method: 'POST',
    body: JSON.stringify(postBody),
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf
    }
  }).then(response => response.json())
  .then((data) => {
    populateImagesTable(data);
  })

}

/**
 * Amikor betöltődik a DOM.
 */
document.addEventListener('DOMContentLoaded', () => {
  apikey = document.head.querySelector('[name="apikey"][content]').content
  userId = document.head.querySelector('[name="userid"][content]').content
  productId = document.head.querySelector('[name="productid"][content]').content

  csrf   = document.head.querySelector('[name="csrf-token"][content]').content


  getAllPictures();

})
