const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 2000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  },
});
function sweetAddSucc() {
  Toast.fire({
    icon: "success",
    title: "Data Berhasil Ditambahkan",
  }).then(() => {
    window.location.href = "?page=master_kendaraan";
  });
}
function sweetError(a) {
  Swal.fire({
    icon: "error",
    title: "Maaf...",
    text: "Terjadi Kesalahan. Silakan Coba Lagi!",
  });
  console.log(a);
}
