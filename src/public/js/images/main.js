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

