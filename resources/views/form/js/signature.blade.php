@push('script')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        var signaturePad = $('.signaturePad').map((_, el) => el.id).get();
        signaturePad.forEach(function(val) {
            var signaturePad = new SignaturePad(document.getElementById(val), {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: 'rgb(0, 0, 0)',
                velocityFilterWeight: .7,
                minWidth: 0.5,
                maxWidth: 2.5,
                throttle: 16,
                minPointDistance: 3,
            });
            var saveButton = document.getElementById('save' + val),
                clearButton = document.getElementById('clear' + val);
            $('#save' + val).attr('disabled', true);
            saveButton.addEventListener('click', function(event) {
                var data = signaturePad.toDataURL('image/png');
                $('#save' + val).attr('disabled', true);
                $('#' + val).parent().find('.sign-error').html(
                    '<small class="text-success">Signaturepad saved.</small>');
                $(this).parents('.signature-pad-body').find('.' + val).val(data);
            });
            clearButton.addEventListener('click', function(event) {
                $(this).parents('.signature-pad-body').find('.' + val).val('');
                $('#clear' + val).attr('disabled', false);
                $('#save' + val).attr('disabled', true);
                $('#' + val).parent().find('.sign-error').html(
                    '<small class="text-danger">Signaturepad cleared.</small>');
                signaturePad.clear();
            });
            $(document).on('touchmove click', '#' + val, function() {
                $('#clear' + val).attr('disabled', false);
                $('#save' + val).attr('disabled', false);
                $('#' + val).parent().find('.sign-error').html(
                    '<small class="text-danger">Note: Please save signaturepad.</small>');
            });
        });
    </script>
@endpush
