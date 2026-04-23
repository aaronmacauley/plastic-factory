// SUCCESS
function showSuccess(message = 'Success') {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        timer: 2000,
        showConfirmButton: false
    });
}

// ERROR
function showError(message = 'Something went wrong') {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message
    });
}

// CONFIRM ACTION
function confirmAction(callback, text = 'Are you sure?') {
    Swal.fire({
        title: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

// DELETE CONFIRM (lebih spesifik)
function confirmDelete(callback) {
    Swal.fire({
        title: 'Delete this data?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

// LOADING
function showLoading(message = 'Processing...') {
    Swal.fire({
        title: message,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

// CLOSE LOADING
function closeSwal() {
    Swal.close();
}
