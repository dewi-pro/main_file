<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(\App\Facades\UtilityFacades::getsettings('rtl') == '1' ? 'rtl' : ''); ?>">

<head>
    <?php
        $primaryColor = \App\Facades\UtilityFacades::getsettings('color');
        if (isset($primaryColor)) {
            $color = $primaryColor;
        } else {
            $color = 'theme-2';
        }
    ?>
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(Utility::getsettings('app_name')); ?></title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Favicon icon -->
    <link rel="manifest" href="<?php echo e(asset('/public/manifest.json')); ?>">
    <link rel="icon"
        href="<?php echo e(Utility::getsettings('favicon_logo') ? Storage::url('app-logo/app-favicon-logo.png') : ''); ?>"
        type="image/png">

    <?php if(Utility::getsettings('rtl') == '1'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <?php if(Utility::getsettings('dark_mode') == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>" id="main-style-link">
    <?php elseif(Utility::getsettings('rtl') != '1'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">

    <?php echo $__env->yieldPushContent('style'); ?>
</head>

<body class="<?php echo e($color); ?>">
    <div class="loading">Loading…</div>
    <div class="dash-content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <div class="modal fade" role="dialog" id="common_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" id="common_modal1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="top-0 p-3 position-fixed end-0" style="z-index: 99999">
        <div id="liveToast" class="toast fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"> </div>
                <button type="button" class="m-auto btn-close btn-close-white me-2" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
</body>

<script src="<?php echo e(asset('vendor/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/modules/tooltip.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/ckeditor/ckeditor.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/sweetalert2.all.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bouncer.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/pages/form-validation.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap-notify.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>

<script>
    var toster_pos = 'right';
    window.addEventListener("load", function() {
        var loader = document.querySelector(".loading");
        $(loader).addClass('d-none');
    });
</script>

<script>
    // Fetch the manifest.json file
    url = '<?php echo e(config('app.url')); ?>';
    var appUrl = url.replace(/\/$/, '');
    file = appUrl + '/public/manifest.json';

    fetch(file)
        .then(response => response.json())
        .then(data => {
            if (data.icons[0].sizes === '128x128') {
                data.icons[0].src = '<?php echo e(Utility::getpath("pwa_icon_128") ? Storage::url(Utility::getsettings("pwa_icon_128")) : ""); ?>';
            }
            if (data.icons[1].sizes === '144x144') {
                data.icons[1].src = '<?php echo e(Utility::getpath("pwa_icon_144") ? Storage::url(Utility::getsettings("pwa_icon_144")) : ""); ?>';
            }
            if (data.icons[2].sizes === '152x152') {
                data.icons[2].src = '<?php echo e(Utility::getpath("pwa_icon_152") ? Storage::url(Utility::getsettings("pwa_icon_152")) : ""); ?>';
            }
            if (data.icons[3].sizes === '192x192') {
                data.icons[3].src = '<?php echo e(Utility::getpath("pwa_icon_192") ? Storage::url(Utility::getsettings("pwa_icon_192")) : ""); ?>';
            }
            if (data.icons[4].sizes === '256x256') {
                data.icons[4].src = '<?php echo e(Utility::getpath("pwa_icon_256") ? Storage::url(Utility::getsettings("pwa_icon_256")) : ""); ?>';
            }
            if (data.icons[5].sizes === '512x512') {
                data.icons[5].src = '<?php echo e(Utility::getpath("pwa_icon_512") ? Storage::url(Utility::getsettings("pwa_icon_512")) : ""); ?>';
            }
            data.name = "<?php echo e(Utility::getsettings('app_name')); ?>";
            data.short_name = "<?php echo e(Utility::getsettings('app_name')); ?>";
            data.start_url = appUrl;

            const updatedManifest = JSON.stringify(data);
            const blob = new Blob([updatedManifest], {
                type: 'application/json'
            });
            const url = URL.createObjectURL(blob);
            document.querySelector('link[rel="manifest"]').href = url;
        })
        .catch(error => console.error('Error fetching manifest.json:', error));
</script>

<script src="<?php echo e(asset('vendor/js/custom.js')); ?>"></script>
<script>
    feather.replace();
</script>

<script>
    feather.replace();
    var multipleCancelButton = new Choices('#sschoices-multiple-remove-button', {
        removeItemButton: true,
    });
</script>

<?php echo $__env->make('layouts.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldPushContent('script'); ?>
</body>

</html>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/layouts/form.blade.php ENDPATH**/ ?>