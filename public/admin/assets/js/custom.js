/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */


$( document ).ready(function() {

    $(".timing").timingfield();

    var swalInit = swal.mixin({
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-light'
    });

    $('body').delegate('.delete', 'click', function (e){
        let url = $(this).attr('href');
        console.log(url);
        e.preventDefault();
        swalInit.fire({
            title: 'Əminsiniz?',
            text: "Məlumatı silmək istədiyinizə əminsiniz mi?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Bəli',
            cancelButtonText: 'Xeyr',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.success) {
                            swalInit.fire({
                                text: 'Silindi',
                                type: 'success',
                                icon: 'success',
                                toast: true,
                                showConfirmButton: false,
                                position: 'top-right'
                            });
                            $('.data-table').DataTable().ajax.reload();
                        } else {
                            swalInit.fire({
                                text: 'Silinmədi',
                                type: 'danger',
                                icon: 'danger',
                                toast: true,
                                showConfirmButton: false,
                                position: 'top-right'
                            });
                        }


                    }
                });
            } else {
                swalInit.fire({
                    text: 'Əməliyyatı ləğv etdiniz',
                    type: 'error',
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-right'
                });
            }
        });
    });
});