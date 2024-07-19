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
