<script>
    $(document).on('click', '.delete-row', function(e) {
        e.preventDefault()
        Swal.fire({
            title: "{{ __('admin.confirm_delete') }}",
            icon: "warning",
            buttons: true,
            showCloseButton: true,
            dangerMode: true,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "delete",
                    url: $(this).data('url'),
                    data: {},
                    dataType: "json",

                    success: (response) => {
                        Swal.fire({
                            position: 'top-start',
                            type: 'success',
                            title: '{{ __('admin.the_selected_has_been_successfully_deleted') }}',
                            showConfirmButton: false,
                            timer: 1500,
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        })
                        getData({
                            'searchArray': searchArray()
                        })
                        toastr.error()
                        $('.data-list-view').DataTable().row($(this).closest('td').parent('tr')).remove().draw();
                    }
                });
                $(document).ajaxStop(function() {
                    window.location.reload();
                });

            }
        })
    });
</script>
