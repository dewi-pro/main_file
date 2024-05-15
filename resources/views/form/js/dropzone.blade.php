@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dropzone.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('assets/js/plugins/dropzone-amd-module.min.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var totaldropzone = $('.dropzone').map((_, el) => el.id).get();
            totaldropzone.forEach(function(val) {
                var myDropzone = new Dropzone("#" + val, {
                    url: "{{ route('dropzone.upload', $form->id) }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    params: {
                        file_extention: $("#" + val).data('extention'),
                    },
                    removedfile: function(file) {
                        console.log(file.xhr.response);
                    },
                    acceptedFiles: ".pdf, .pdfa, .fdf, .xdp, .xfa, .pdx, .pdp, .pdfxml, .pdxox, .jpeg, .jpg, .png, .xlsx, .csv, .xlsm, .xltx, .xlsb, .xltm, .xlw",
                    maxFiles: '{{ isset($maxupload) ? $maxupload : 1 }}',
                    parallelUploads: '{{ isset($maxupload) ? $maxupload : 1 }}',
                    addRemoveLinks: true,
                    uploadMultiple: false,
                    autoProcessQueue: true,
                    init: function() {
                        this.on('success', function(files, response) {
                            if ($('.' + val).val()) {
                                var oldDropzone = $('.' + val).val();
                                $('.' + val).val(oldDropzone + ',' + response.filename);
                            } else {
                                $('.' + val).val(response.filename);
                            }
                            if (response.success) {
                                show_toastr('Done!', response.success, 'success',
                                    '{{ asset('assets/images/notification/ok-48.png') }}',
                                    4000);
                            } else {
                                show_toastr('Error!', response.errors, 'danger',
                                    '{{ asset('assets/images/notification/high_priority-48.png') }}',
                                    4000);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
