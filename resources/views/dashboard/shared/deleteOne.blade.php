<script>
    $(document).on('click' , '.delete-row', function (e) {
        e.preventDefault()
        Swal.fire({
            title: "{{__('admin.are_you_want_to_continue')}}",
            text: "{{__('admin.confirm_delete')}}",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{__('admin.confirm')}}',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonText: '{{__('admin.cancel')}}',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
            }).then( (result) => {
            if (result.value) {
                $.ajax({
                    
                    type: "delete",
                    url: $(this).data('url'),
                    data: {},
                    dataType: "json",
                    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
                    success:  (response) => {
                        Swal.fire(
                        {
                            position: 'top-start',
                            type: 'success',
                            title: '{{__('admin.the_selected_has_been_successfully_deleted')}}',
                            showConfirmButton: false,
                            timer: 1500,
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        })
                        getData({'searchArray' : searchArray()} )

                        
                        // toastr.error()
                        // $('.data-list-view').DataTable().row($(this).closest('td').parent('tr')).remove().draw();
                    }
                });
                $(document).ajaxStop(function() {
                    window.location.reload();
                });

            }
        })
    });
</script>