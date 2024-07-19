let Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 2000,
  // timerProgressBar: true,
  didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
  }
});

const ErrorResponse = (data) => {
  if (data) {
      if (typeof data.message === 'string') {
          // Jika ada properti 'message' dengan tipe string
          return data.message;
      } else {
          // Jika tidak ada properti 'message' atau bukan string, cek properti lainnya
          for (const key in data) {
              if (data.hasOwnProperty(key)) {
                  const value = data[key];
                  if (Array.isArray(value) && value.length > 0 && typeof value[0] === 'string') {
                      // Jika properti ini adalah array yang berisi string
                      return value[0]; // Ambil pesan pertama dari array
                  }
              }
          }
      }
  }
}
class Formatting {
  static capitalize(input) {
      if (!input || input.trim().length === 0)
          return input;

      // Memecah string menjadi kata-kata berdasarkan spasi
      let words = input.trim().split(' ');
      // Memproses setiap kata untuk membuat huruf pertama menjadi besar
      for (let i = 0; i < words.length; i++) {
          if (words[i].length > 0) {
              words[i] = words[i][0].toUpperCase() + words[i].slice(1).toLowerCase();
          }
      }
      // Menggabungkan kata-kata kembali dengan spasi
      return words.join(' ');
  }

  static formatRupiah(amount) {
      // Memformat jumlah menjadi format Rupiah
      return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
  }

  static formatDateLong(date) {
      // Memformat tanggal menjadi format dd MMM yyyy
      const options = { day: '2-digit', month: 'short', year: 'numeric' };
      return new Date(date).toLocaleDateString('en-US', options);
  }

  static formatDateShort(date) {
      // Memformat tanggal menjadi format dd/MM/yyyy
      const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
      return new Date(date).toLocaleDateString('en-US', options).replace(/\//g, '-');
  }
}
