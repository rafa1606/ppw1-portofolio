// script-eksternal.js
// File JavaScript eksternal untuk Tugas 1 Pertemuan 10
// Rafa Irhamniyansyah Achmad - 25/557712/SV/26222

var pesanEksternal = "Pesan ini berasal dari file JavaScript eksternal (script-eksternal.js)";

function jalankanEksternal() {
  document.getElementById("output-eksternal").innerHTML =
    "<p style='color: green; font-weight: bold;'>" + pesanEksternal + "</p>";
  console.log("JavaScript Eksternal berhasil dijalankan!");
}
