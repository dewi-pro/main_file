<?php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($form->id);
?>
<div class="row">
    <div class="text-center">
        <?php echo QrCode::size(200)->generate(route('forms.survey', $id)); ?>

    </div>
</div>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/public-fill-qr.blade.php ENDPATH**/ ?>