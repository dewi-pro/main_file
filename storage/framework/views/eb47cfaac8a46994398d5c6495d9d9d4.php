<?php
    $footerMainMenus = App\Models\FooterSetting::where('parent_id', 0)->get();
    $users = \Auth::user();

    $user = App\Models\User::where('created_by', null)->first();
    $lang = App\Facades\UtilityFacades::getActiveLanguage();
    \App::setLocale($lang)

?>
<!DOCTYPE html>
    <html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
             dir="<?php echo e(\App\Facades\UtilityFacades::getsettings('rtl') == '1' || $lang == 'ar' ? 'rtl' : ''); ?>">
<head>
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(Utility::getsettings('app_name')); ?></title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="title"
    content="<?php echo e(!empty(Utility::getsettings('meta_title'))
        ? Utility::getsettings('meta_title') :  Utility::getsettings('app_name')); ?>">
<meta name="keywords"
    content="<?php echo e(!empty(Utility::getsettings('meta_keywords'))
        ? Utility::getsettings('meta_keywords')
        : 'Multi Users,Role & permission , Form & poll management , document Genrator , Booking system'); ?>">
<meta name="description"
    content="<?php echo e(!empty(Utility::getsettings('meta_description'))
        ? Utility::getsettings('meta_description')
        : 'Discover the efficiency of prime-laravel, a user-friendly web application by Quebix Apps.'); ?>">
<meta name="meta_image_logo" property="og:image"
    content="<?php echo e(!empty(Utility::getsettings('meta_image_logo'))
        ? Storage::url(Utility::getsettings('meta_image_logo'))
        : Storage::url('seeder-image/meta-image-logo.jpg')); ?>">
    <?php if(Utility::getsettings('seo_setting') == 'on'): ?>
        <?php echo app('seotools')->generate(); ?>

    <?php endif; ?>
    <!-- Favicon icon -->
    <link rel="manifest" href="<?php echo e(asset('/public/manifest.json')); ?>">

    <link rel="icon"
        href="<?php echo e(Utility::getsettings('favicon_logo') ? Storage::url('app-logo/app-favicon-logo.png') : ''); ?>"
        type="image/png">
    <!-- font css -->

    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/landing-page2/css/custom.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('vendor/css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/landing-page2/css/landingpage-2.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/landing-page2/css/landingpage2-responsive.css')); ?>">


</head>

<body>
    <!-- [ auth-signup ] start -->
    <div class="auth-wrapper auth-v3">
        <!--header start here-->
        <?php echo $__env->make('layouts.app-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--header end here-->
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <!-- [ auth-signup ] end -->
    </div>
    <!--footer start here-->
    <?php echo $__env->make('layouts.app-footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--footer end here-->
    <!--scripts start here-->
    <script src="<?php echo e(asset('vendor/landing-page2/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/landing-page2/js/slick.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap-notify.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bouncer.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/form-validation.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/landing-page2/js/custom.js')); ?>"></script>

    <!--scripts end here-->
    <script>
        var toster_pos = 'right';
        feather.replace();
    </script>
    <script src="<?php echo e(asset('vendor/js/custom.js')); ?>"></script>
    <script>
        <?php if(session('failed')): ?>
            show_toastr('Failed!', '<?php echo e(session('failed')); ?>', 'danger');
        <?php endif; ?>
        <?php if(session('errors')): ?>
            show_toastr('Error!', '<?php echo e(session('errors')); ?>', 'danger');
        <?php endif; ?>
        <?php if(session('successful')): ?>
            show_toastr('SuccessfulLY!', '<?php echo e(session('successful')); ?>', 'success');
        <?php endif; ?>
        <?php if(session('success')): ?>
            show_toastr('Done!', '<?php echo e(session('success')); ?>', 'success');
        <?php endif; ?>
        <?php if(session('warning')): ?>
            show_toastr('Warning!', '<?php echo e(session('warning')); ?>', 'warning');
        <?php endif; ?>

        <?php if(session('status')): ?>
            show_toastr('Great!', '<?php echo e(session('status')); ?>', 'info');
        <?php endif; ?>

        $(document).on('click', '.delete-action', function() {
            var form_id = $(this).attr('data-form-id')
            $.confirm({
                title: '<?php echo e(__('Alert !')); ?>',
                content: '<?php echo e(__('Are You sure ?')); ?>',
                buttons: {
                    confirm: function() {
                        $("#" + form_id).submit();
                    },
                    cancel: function() {}
                }
            });
        });
    </script>

    <script>
        function myFunction() {
            const element = document.body;
            element.classList.toggle("dark-mode");
            const isDarkMode = element.classList.contains("dark-mode");
            const expirationDate = new Date();
            expirationDate.setDate(expirationDate.getDate() + 30);
            document.cookie = `mode=${isDarkMode ? "dark" : "light"}; expires=${expirationDate.toUTCString()}; path=/`;
            if (isDarkMode) {
                $('.switch-toggle').find('.switch-moon').addClass('d-none');
                $('.switch-toggle').find('.switch-sun').removeClass('d-none');
            } else {
                $('.switch-toggle').find('.switch-sun').addClass('d-none');
                $('.switch-toggle').find('.switch-moon').removeClass('d-none');
            }
        }
        window.addEventListener("DOMContentLoaded", () => {
            const modeCookie = document.cookie.split(";").find(cookie => cookie.includes("mode="));
            if (modeCookie) {
                const mode = modeCookie.split("=")[1];
                if (mode === "dark") {
                    $('.switch-toggle').find('.switch-moon').addClass('d-none');
                    $('.switch-toggle').find('.switch-sun').removeClass('d-none');
                    document.body.classList.add("dark-mode");
                } else {
                    $('.switch-toggle').find('.switch-sun').addClass('d-none');
                    $('.switch-toggle').find('.switch-moon').removeClass('d-none');
                }
            }
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
                data.name        = "<?php echo e(Utility::getsettings('app_name')); ?>";
                data.short_name  = "<?php echo e(Utility::getsettings('app_name')); ?>";
                data.start_url   = appUrl;

                const updatedManifest = JSON.stringify(data);
                const blob = new Blob([updatedManifest], {
                    type: 'application/json'
                });
                const url = URL.createObjectURL(blob);
                document.querySelector('link[rel="manifest"]').href = url;
            })
            .catch(error => console.error('Error fetching manifest.json:', error));
    </script>

    <?php echo $__env->yieldPushContent('script'); ?>

    <?php if(Utility::getsettings('cookie_setting_enable') == 'on'): ?>
        <?php echo $__env->make('layouts.cookie-consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
</body>

</html>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/layouts/app.blade.php ENDPATH**/ ?>