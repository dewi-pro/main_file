<?php
    use App\Facades\UtilityFacades;
    $lang = \App\Facades\UtilityFacades::getValByName('default_language');
    $primaryColor = \App\Facades\UtilityFacades::getsettings('color');

    if (isset($primaryColor)) {
        $color = $primaryColor;
    } else {
        $color = 'theme-2';
    }
    $roles = App\Models\Role::whereNotIn('name', ['Super Admin', 'Admin'])
        ->pluck('name', 'name')
        ->all();
?>


<?php $__env->startSection('title', __('Settings')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Settings')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), []); ?></li>
            <li class="breadcrumb-item active"> <?php echo e(__('Settings')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="mt-3 card sticky-top">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#app-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('App Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#general-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('General Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#storage-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Storage Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#pusher-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Pusher Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#social-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Social Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#email-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Email Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#captcha-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Captcha Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#seo-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('SEO Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#cache-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Cache Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#cookie-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Cookie Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#payment-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Payment Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#sms-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Sms Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#google-calender-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Google Calender Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#google-map-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Google Map Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#notification-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('Notification Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#pwa-setting"
                                class="border-0 list-group-item list-group-item-action"><?php echo e(__('PWA Setting')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">

                    <div id="app-setting" class="pt-0 card">
                        <?php echo Form::open([
                            'route' => ['settings.app-name.update'],
                            'enctype' => 'multipart/form-data',
                        ]); ?>

                        <div class="card-header">
                            <h5> <?php echo e(__('App Setting')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="pt-0 row">
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php echo e(__('App Dark Logo')); ?></h5>
                                        </div>
                                        <div class="pt-0 card-body">
                                            <div class="inner-content">
                                                <div class="py-2 mt-4 text-center logo-content dark-logo-content">
                                                    <a href="<?php echo e(Utility::getpath('app_dark_logo') ? Storage::url('app-logo/app-dark-logo.png') : ''); ?>"
                                                        target="_blank">
                                                        <img src="<?php echo e(Utility::getpath('app_dark_logo') ? Storage::url('app-logo/app-dark-logo.png') : ''); ?>"
                                                            id="app_dark">
                                                    </a>
                                                </div>
                                                <div class="mt-3 text-center choose-files">
                                                    <label for="app_dark_logo">
                                                        <div class="bg-primary company_logo_update"> <i
                                                                class="px-1 ti ti-upload"></i><?php echo e(__('Choose file here')); ?>

                                                        </div>
                                                        <?php echo e(Form::file('app_dark_logo', ['class' => 'form-control file', 'id' => 'app_dark_logo', 'onchange' => "document.getElementById('app_dark').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'app_dark_logo'])); ?>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php echo e(__('App Light Logo')); ?></h5>
                                        </div>
                                        <div class="pt-0 card-body bg-primary">
                                            <div class="inner-content">
                                                <div class="py-2 mt-4 text-center logo-content light-logo-content">
                                                    <a href="<?php echo e(Utility::getpath('app_logo') ? Storage::url('app-logo/app-logo.png') : Storage::url('app-logo/78x78.png')); ?>"
                                                        target="_blank">
                                                        <img src="<?php echo e(Utility::getpath('app_logo') ? Storage::url('app-logo/app-logo.png') : Storage::url('app-logo/78x78.png')); ?>"
                                                            id="app_light">
                                                    </a>
                                                </div>
                                                <div class="mt-3 text-center choose-files">
                                                    <label for="app_logo">
                                                        <div class="company_logo_update w-logo"> <i
                                                                class="px-1 ti ti-upload"></i><?php echo e(__('Choose file here')); ?>

                                                        </div>
                                                        <?php echo e(Form::file('app_logo', ['class' => 'form-control file', 'id' => 'app_logo', 'onchange' => "document.getElementById('app_light').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'app_logo'])); ?>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php echo e(__('App Favicon Logo')); ?></h5>
                                        </div>
                                        <div class="pt-0 card-body">
                                            <div class="inner-content">
                                                <div class="py-2 mt-4 text-center logo-content">
                                                    <a href="<?php echo e(Utility::getpath('favicon_logo') ? Storage::url('app-logo/app-favicon-logo.png') : ''); ?>"
                                                        target="_blank">
                                                        <img height="35px"
                                                            src="<?php echo e(Utility::getpath('favicon_logo') ? Storage::url('app-logo/app-favicon-logo.png') : ''); ?>"
                                                            id="app_favicon">
                                                    </a>
                                                </div>
                                                <div class="mt-3 text-center choose-files">
                                                    <label for="favicon_logo">
                                                        <div class="bg-primary company_logo_update"> <i
                                                                class="px-1 ti ti-upload"></i><?php echo e(__('Choose file here')); ?>

                                                        </div>
                                                        <?php echo e(Form::file('favicon_logo', ['class' => 'form-control file', 'id' => 'favicon_logo', 'onchange' => "document.getElementById('app_favicon').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'favicon_logo'])); ?>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?php echo e(Form::label('app_name', __('Application Name'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::text('app_name', Utility::getsettings('app_name'), [
                                        'class' => 'form-control',
                                        'placeholder' => __('Enter application name'),
                                    ]); ?>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                    <div id="general-setting" class="">
                        <?php echo Form::open([
                            'route' => ['settings.auth-settings.update'],
                            'method' => 'POST',
                            'novalidate',
                            'data-validate',
                        ]); ?>

                        <div class="card" id="settings-card">
                            <div class="card-header">
                                <h5><?php echo e(__('General Settings')); ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-sm-8">
                                                <strong class="d-block"><?php echo e(__('Two Factor Authentication')); ?></strong>
                                                <?php echo e(!Utility::getsettings('2fa') ? __('Activate') : __('Deactivate')); ?>

                                                <?php echo e(__('Two Factor Authentication For Application')); ?>

                                            </div>
                                            <div class="col-sm-4 form-check form-switch custom-switch-v1">
                                                <label class="mt-2 custom-switch float-end">
                                                    <?php echo Form::checkbox('two_factor_auth', null, Utility::getsettings('2fa') ? true : false, [
                                                        'data-onstyle' => 'primary',
                                                        'class' => 'custom-control custom-switch form-check-input input-primary',
                                                        'data-toggle' => 'switchbutton',
                                                    ]); ?>

                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-8">
                                                <strong class="d-block"><?php echo e(__('Email Verification')); ?></strong>
                                                <?php echo e(Utility::getsettings('email_verification') == '1' ? __('Activate') : __('Deactivate')); ?>

                                                <?php echo e(__('Email Verification For Application')); ?>

                                            </div>
                                            <div class="col-sm-4 form-check form-switch custom-switch-v1">
                                                <label class="mt-2 custom-switch float-end">
                                                    <?php echo Form::checkbox(
                                                        'email_verification',
                                                        null,
                                                        Utility::getsettings('email_verification') == '1' ? true : false,
                                                        [
                                                            'data-onstyle' => 'primary',
                                                            'class' => 'custom-control custom-switch form-check-input input-primary',
                                                            'data-toggle' => 'switchbutton',
                                                        ],
                                                    ); ?>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-sm-8">
                                                <strong class="d-block"><?php echo e(__('Sms Verification')); ?></strong>
                                                <?php echo e(Utility::getsettings('sms_verification') == 0 ? __('Activate') : __('Deactivate')); ?>

                                                <?php echo e(__('Sms Verification For Application')); ?>

                                            </div>
                                            <div class="col-sm-4 form-check form-switch custom-switch-v1">
                                                <label class="mt-2 custom-switch float-end">
                                                    <?php echo Form::checkbox('sms_verification', null, Utility::getsettings('sms_verification') == '1' ? true : false, [
                                                        'data-onstyle' => 'primary',
                                                        'class' => 'form-check-input input-primary custom-control custom-switch',
                                                        'data-toggle' => 'switchbutton',
                                                    ]); ?>

                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-8">
                                                <strong class="d-block"><?php echo e(__('RTL Setting')); ?></strong>
                                                <?php echo e(Utility::getsettings('rtl') == '0' ? __('Deactivate') : __('Activate')); ?>

                                                <?php echo e(__('RTL Setting For Application')); ?>

                                            </div>
                                            <div class="col-sm-4 form-check form-switch custom-switch-v1">
                                                <label class="mt-2 custom-switch float-end">
                                                    <?php echo Form::checkbox('rtl_setting', null, Utility::getsettings('rtl') == '1' ? true : false, [
                                                        'data-onstyle' => 'primary',
                                                        'id' => 'site_rtl',
                                                        'data-toggle' => 'switchbutton',
                                                        'class' => 'custom-control custom-switch form-check-input input-primary',
                                                    ]); ?>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-sm-8">
                                                <strong class="d-block"><?php echo e(__('Register')); ?></strong>
                                                <?php echo e(Utility::getsettings('register') == '1' ? __('Activate') : __('Deactivate')); ?>

                                                <?php echo e(__('Register For Application')); ?>

                                            </div>
                                            <div class="col-sm-4 form-check form-switch custom-switch-v1">
                                                <label class="mt-2 custom-switch float-end">
                                                    <?php echo Form::checkbox('register', null, Utility::getsettings('register') == '1' ? true : false, [
                                                        'data-onstyle' => 'primary',
                                                        'data-toggle' => 'switchbutton',
                                                        'class' => 'custom-control custom-switch form-check-input input-primary',
                                                    ]); ?>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-sm-8">
                                                <strong class="d-block"><?php echo e(__('Landing Page')); ?></strong>
                                                <?php echo e(Utility::getsettings('landing_page') == '1' ? __('Activate') : __('Deactivate')); ?>

                                                <?php echo e(__('LandingPage For Application')); ?>

                                            </div>
                                            <div class="col-sm-4 form-check form-switch custom-switch-v1">
                                                <label class="mt-2 custom-switch float-end">
                                                    <?php echo Form::checkbox('landing_page', null, Utility::getsettings('landing_page') == '1' ? true : false, [
                                                        'data-onstyle' => 'primary',
                                                        'data-toggle' => 'switchbutton',
                                                        'class' => 'custom-control custom-switch form-check-input input-primary',
                                                    ]); ?>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 col-sm-12">
                                        <div class="form-group d-flex align-items-center row">
                                            <h4 class="small-title"><?php echo e(__('Theme Customizer')); ?></h4>
                                            <div class="setting-card setting-logo-box">
                                                <div class="row">
                                                    <div class="col-lg-4 col-xl-4 col-md-4">
                                                        <h6 class="mt-2">
                                                            <i data-feather="credit-card"
                                                                class="me-2"></i><?php echo e(__('Primary color settings')); ?>

                                                        </h6>
                                                        <hr class="my-2" />
                                                        <div class="theme-color themes-color">
                                                            <a href="#!"
                                                                class="<?php echo e($color == 'theme-1' ? 'active_color' : ''); ?>"
                                                                data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                            <input type="radio" class="theme_color d-none"
                                                                name="color" value="theme-1">
                                                            <a href="#!"
                                                                class="<?php echo e($color == 'theme-2' ? 'active_color' : ''); ?>"
                                                                data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                            <input type="radio" class="theme_color d-none"
                                                                name="color" value="theme-2">
                                                            <a href="#!"
                                                                class="<?php echo e($color == 'theme-3' ? 'active_color' : ''); ?>"
                                                                data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                            <input type="radio" class="theme_color d-none"
                                                                name="color" value="theme-3">
                                                            <a href="#!"
                                                                class="<?php echo e($color == 'theme-4' ? 'active_color' : ''); ?>"
                                                                data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                            <input type="radio" class="theme_color d-none"
                                                                name="color" value="theme-4">
                                                            <a href="#!"
                                                                class="<?php echo e($color == 'theme-5' ? 'active_color' : ''); ?>"
                                                                data-value="theme-5" onclick="check_theme('theme-5')"></a>
                                                            <input type="radio" class="theme_color d-none"
                                                                name="color" value="theme-5">
                                                            <br>
                                                            <a href="#!"
                                                                class="<?php echo e($color == 'theme-6' ? 'active_color' : ''); ?>"
                                                                data-value="theme-6" onclick="check_theme('theme-6')"></a>
                                                            <input type="radio" class="theme_color d-none"
                                                                name="color" value="theme-6">
                                                            <a href="#!"
                                                                class="<?php echo e($color == 'theme-7' ? 'active_color' : ''); ?>"
                                                                data-value="theme-7" onclick="check_theme('theme-7')"></a>
                                                            <input type="radio" class="theme_color d-none"
                                                                name="color" value="theme-7">
                                                            <a href="#!"
                                                                class="<?php echo e($color == 'theme-8' ? 'active_color' : ''); ?>"
                                                                data-value="theme-8" onclick="check_theme('theme-8')"></a>
                                                            <input type="radio" class="theme_color d-none"
                                                                name="color" value="theme-8">
                                                            <a href="#!"
                                                                class="<?php echo e($color == 'theme-9' ? 'active_color' : ''); ?>"
                                                                data-value="theme-9" onclick="check_theme('theme-9')"></a>
                                                            <input type="radio" class="theme_color d-none"
                                                                name="color" value="theme-9">
                                                            <a href="#!"
                                                                class="<?php echo e($color == 'theme-10' ? 'active_color' : ''); ?>"
                                                                data-value="theme-10"
                                                                onclick="check_theme('theme-10')"></a>
                                                            <input type="radio" class="theme_color d-none"
                                                                name="color" value="theme-10">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4 col-md-4">
                                                        <h6 class="mt-2">
                                                            <i data-feather="layout"
                                                                class="me-2"></i><?php echo e(__('Sidebar settings')); ?>

                                                        </h6>
                                                        <hr class="my-2" />
                                                        <div class="form-check form-switch">
                                                            <?php echo Form::checkbox(
                                                                'transparent_layout',
                                                                null,
                                                                Utility::getsettings('transparent_layout') == 'on' ? 'checked' : '',
                                                                [
                                                                    'data-onstyle' => 'primary',
                                                                    'id' => 'cust-theme-bg',
                                                                    'class' => 'form-check-input',
                                                                ],
                                                            ); ?>

                                                            <?php echo Form::label('cust-theme-bg', __('Transparent layout'), ['class' => 'form-check-label f-w-600 pl-1']); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4 col-md-4">
                                                        <h6 class="mt-2">
                                                            <i data-feather="sun"
                                                                class="me-2"></i><?php echo e(__('Layout settings')); ?>

                                                        </h6>
                                                        <hr class="my-2" />
                                                        <div class="mt-2 form-check form-switch">
                                                            <?php echo Form::checkbox('dark_mode', null, Utility::getsettings('dark_mode') == 'on' ? true : false, [
                                                                'id' => 'cust-darklayout',
                                                                'class' => 'form-check-input',
                                                            ]); ?>

                                                            <?php echo Form::label('cust-darklayout', __('Dark Layout'), ['class' => 'form-check-label f-w-600 pl-1']); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php if(!extension_loaded('imagick')): ?>
                                        <small>
                                            <?php echo e(__('Note: for 2FA your server must have Imagick.')); ?>

                                            <?php echo Html::link('https://www.php.net/manual/en/book.imagick.php', __('Imagick Document'), ['target' => '_blank']); ?>

                                        </small>
                                    <?php endif; ?>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <?php echo e(Form::label('default_language', __('Default Language'), ['class' => 'form-label'])); ?>

                                                    <?php echo Form::select('default_language', $languages, $lang, [
                                                        'data-trigger',
                                                        'id' => 'choices-single-default',
                                                        'placeholder' => __('This is a search placeholder'),
                                                        'class' => 'form-control form-control-inline-block',
                                                    ]); ?>

                                                </div>
                                                <div class="form-group">
                                                    <?php echo e(Form::label('date_format', __('Date Format'), ['class' => 'form-label'])); ?>

                                                    <select name="date_format" class="form-select" data-trigger>
                                                        <option value="M j, Y"
                                                            <?php echo e(Utility::getsettings('date_format') == 'M j, Y' ? 'selected' : ''); ?>>
                                                            <?php echo e(__('Jan 1, 2020')); ?></option>
                                                        <option value="d-M-y"
                                                            <?php echo e(Utility::getsettings('date_format') == 'd-M-y' ? 'selected' : ''); ?>>
                                                            <?php echo e(__('01-Jan-20')); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <?php echo e(Form::label('time_format', __('Time Format'), ['class' => 'form-label'])); ?>

                                                    <select name="time_format" class="form-select" data-trigger>
                                                        <option value="g:i A"
                                                            <?php echo e(Utility::getsettings('time_format') == 'g:i A' ? 'selected' : ''); ?>>
                                                            <?php echo e(__('hh:mm AM/PM')); ?></option>
                                                        <option value="H:i:s"
                                                            <?php echo e(Utility::getsettings('time_format') == 'H:i:s' ? 'selected' : ''); ?>>
                                                            <?php echo e(__('HH:mm:ss')); ?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label"><?php echo e(__('Social Login Role')); ?></label>
                                                    <?php echo Form::select('roles', $roles, Utility::getsettings('roles'), ['class' => 'form-control', 'data-trigger']); ?>

                                                    <div class="invalid-feedback">
                                                        <?php echo e(__('Role is required')); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <?php echo e(Form::label('gtag', __('Gtag Tracking ID'), ['class' => 'form-label'])); ?>

                                                    <?php echo Html::link(
                                                        'https://support.google.com/analytics/answer/1008080?hl=en#zippy=%2Cin-this-article',
                                                        __('Document'),
                                                        ['target' => '_blank', 'class' => 'm-2'],
                                                    ); ?>

                                                    </label>
                                                    <?php echo Form::text('gtag', Utility::getsettings('gtag'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Enter gtag tracking id'),
                                                    ]); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                    <div id="storage-setting" class="">
                        <?php echo Form::open([
                            'route' => ['settings.wasabi-setting.update'],
                            'method' => 'POST',
                            'data-validate',
                            'novalidate',
                        ]); ?>

                        <div class="card" id="settings-card">
                            <div class="card-header">
                                <h5> <?php echo e(__('Storage Settings')); ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="pb-3">
                                    <p class="text-danger">
                                        <?php echo e(__('Note :- If you Add S3 & wasabi Storage settings then you have to store all images First.')); ?>

                                    </p>
                                </div>
                                <div class="form-group">
                                    <?php echo Form::radio('storage_type', 'local', Utility::getsettings('storage_type') == 'local' ? true : false, [
                                        'class' => 'btn-check',
                                        'id' => 'localsetting',
                                    ]); ?>

                                    <?php echo e(Form::label('localsetting', __('Local'), ['class' => 'btn btn-outline-primary'])); ?>


                                    <?php echo Form::radio('storage_type', 's3', Utility::getsettings('storage_type') == 's3' ? true : false, [
                                        'class' => 'btn-check',
                                        'id' => 's3setting',
                                    ]); ?>

                                    <?php echo e(Form::label('s3setting', __('S3 setting'), ['class' => 'btn btn-outline-primary'])); ?>


                                    <?php echo Form::radio('storage_type', 'wasabi', Utility::getsettings('storage_type') == 'wasabi' ? true : false, [
                                        'class' => 'btn-check',
                                        'id' => 'wasabisetting',
                                    ]); ?>

                                    <?php echo e(Form::label('wasabisetting', __('Wasabi'), ['class' => 'btn btn-outline-primary'])); ?>


                                </div>
                                <div id="s3"
                                    class="desc <?php echo e(Utility::getsettings('storage_type') == 's3' ? 'block' : 'd-none'); ?>">
                                    <div class="">
                                        <div class="row">
                                            <div class="form-group">
                                                <?php echo e(Form::label('s3_key', __('S3 Key'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('s3_key', Utility::getsettings('s3_key'), [
                                                    'placeholder' => __('Enter s3 key'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('s3_secret', __('S3 Secret'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('s3_secret', Utility::getsettings('s3_secret'), [
                                                    'placeholder' => __('Enter s3 secret'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('s3_region', __('S3 Region'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('s3_region', Utility::getsettings('s3_region'), [
                                                    'placeholder' => __('Enter s3 region'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('s3_bucket', __('S3 Bucket'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('s3_bucket', Utility::getsettings('s3_bucket'), [
                                                    'placeholder' => __('Enter s3 bucket'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('s3_url', __('S3 URL'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('s3_url', Utility::getsettings('s3_url'), [
                                                    'placeholder' => __('Enter s3 URl'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('s3_endpoint', __('S3 Endpoint'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('s3_endpoint', Utility::getsettings('s3_endpoint'), [
                                                    'placeholder' => __('Enter s3 bucket'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="wasabi"
                                    class="desc <?php echo e(Utility::getsettings('storage_type') == 'wasabi' ? 'block' : 'd-none'); ?>">
                                    <div class="">
                                        <div class="row">
                                            <div class="form-group">
                                                <?php echo e(Form::label('wasabi_key', __('Wasabi Key'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('wasabi_key', Utility::getsettings('wasabi_key'), [
                                                    'placeholder' => __('Enter Wasabi key'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('wasabi_secret', __('Wasabi Secret'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('wasabi_secret', Utility::getsettings('wasabi_secret'), [
                                                    'placeholder' => __('Enter Wasabi Secret'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('wasabi_region', __('Wasabi Region'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('wasabi_region', Utility::getsettings('wasabi_region'), [
                                                    'placeholder' => __('Enter Wasabi region'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('wasabi_bucket', __('Enter Wasabi bucket'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('wasabi_bucket', Utility::getsettings('wasabi_bucket'), [
                                                    'placeholder' => __('wasabi Bucket'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('wasabi_url', __('Wasabi URL'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('wasabi_url', Utility::getsettings('wasabi_url'), [
                                                    'placeholder' => __('Enter wasabi URL'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('wasabi_root', __('Wasabi Endpoint'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('wasabi_root', Utility::getsettings('wasabi_root'), [
                                                    'placeholder' => __('Enter Wasabi endpoint'),
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                    <div id="pusher-setting" class="">
                        <?php echo Form::open([
                            'route' => ['settings.pusher-setting.update'],
                            'method' => 'POST',
                            'data-validate',
                            'novalidate',
                        ]); ?>

                        <div class="card" id="settings-card">
                            <div class="card-header">
                                <h5> <?php echo e(__('Pusher Setting')); ?></h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted"> <?php echo e(__('Pusher Setting')); ?>

                                    <?php echo Html::link('https://pusher.com/', __('Document'), ['target' => '_blank', 'class' => 'm-2']); ?>

                                </p>
                                <div class="">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('pusher_id', __('Pusher App ID'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('pusher_id', Utility::getsettings('pusher_id'), [
                                                    'placeholder' => __('Enter pusher app id'),
                                                    'required',
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('pusher_key', __('Pusher Key'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('pusher_key', Utility::getsettings('pusher_key'), [
                                                    'placeholder' => __('Enter pusher key'),
                                                    'required',
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('pusher_secret', __('Pusher Secret'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('pusher_secret', Utility::getsettings('pusher_secret'), [
                                                    'placeholder' => __('Enter pusher secret'),
                                                    'required',
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('pusher_cluster', __('Pusher Cluster'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('pusher_cluster', Utility::getsettings('pusher_cluster'), [
                                                    'placeholder' => __('Enter pusher cluster'),
                                                    'required',
                                                    'class' => 'form-control',
                                                ]); ?>

                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <div class="col-md-8">
                                                    <?php echo e(Form::label('pusher_status', __('Status'), ['class' => 'form-label'])); ?>

                                                </div>
                                                <div class="col-md-4 form-check form-switch">
                                                    <?php echo Form::checkbox('pusher_status', null, Utility::getsettings('pusher_status') ? true : false, [
                                                        'class' => 'form-check-input float-end',
                                                        'id' => 'pusher_status',
                                                    ]); ?>

                                                    <span class="custom-switch-indicator"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                    <div id="social-setting" class="faq">
                        <?php echo Form::open([
                            'route' => ['settings/social-setting/update'],
                            'method' => 'POST',
                            'data-validate',
                            'novalidate',
                        ]); ?>

                        <div class="card" id="settings-card">
                            <div class="card-header">
                                <h5> <?php echo e(__('Social Settings')); ?></h5>
                            </div>
                            <div class="p-4 card-body">
                                <div class="mt-3 row">
                                    <div class="col-md-12">
                                        <div class="accordion accordion-flush" id="accordionExamples">
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="google">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone"
                                                        aria-expanded="true" aria-controls="collapseone">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-brand-google text-primary"></i>
                                                            <?php echo e(__('Google')); ?>

                                                        </span>
                                                        <?php if(Utility::getsettings('googlesetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapseone" class="accordion-collapse collapse"
                                                    aria-labelledby="google" data-bs-parent="#accordionExamples">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-between">
                                                            <small
                                                                class=""><?php echo e(__('How To Enable Login With Google')); ?><?php echo Html::link(Storage::url('pdf/login with google.pdf'), __('Document'), [
                                                                    'target' => '_blank',
                                                                    'class' => 'm-2',
                                                                ]); ?></small>
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox('socialsetting[]', 'google', Utility::getsettings('googlesetting') == 'on' ? true : false, [
                                                                    'class' => 'form-check-input',
                                                                    'id' => 'googlesetting',
                                                                ]); ?>

                                                                <?php echo e(Form::label('googlesetting', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="mt-2 row">
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('google_client_id', __('Google Client Id'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::text(
                                                                    'google_client_id',
                                                                    Utility::getsettings('google_client_id') ? Utility::getsettings('google_client_id') : '',
                                                                    [
                                                                        'placeholder' => __('Enter google client id'),
                                                                        'class' => 'form-control',
                                                                    ],
                                                                ); ?>

                                                            </div>
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('google_client_secret', __('Google Client Secret'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::text(
                                                                    'google_client_secret',
                                                                    Utility::getsettings('google_client_secret') ? Utility::getsettings('google_client_secret') : '',
                                                                    [
                                                                        'placeholder' => __('Enter google client secret'),
                                                                        'class' => 'form-control',
                                                                    ],
                                                                ); ?>

                                                            </div>
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('google_redirect', __('Google Redirect Url'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::text(
                                                                    'google_redirect',
                                                                    Utility::getsettings('google_redirect') ? Utility::getsettings('google_redirect') : '',
                                                                    [
                                                                        'placeholder' => __('https://demo.test.com/callback/google'),
                                                                        'class' => 'form-control',
                                                                    ],
                                                                ); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="facebook">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsetwo"
                                                        aria-expanded="true" aria-controls="collapsetwo">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-brand-facebook text-primary"></i>
                                                            <?php echo e(__('Facebook')); ?>

                                                        </span>
                                                        <?php if(Utility::getsettings('facebooksetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapsetwo" class="accordion-collapse collapse"
                                                    aria-labelledby="facebook" data-bs-parent="#accordionExamples">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-between">
                                                            <small
                                                                class=""><?php echo e(__('How To Enable Login With Facebook')); ?>

                                                                <?php echo Html::link(Storage::url('pdf/login with facebook.pdf'), __('Document'), [
                                                                    'target' => '_blank',
                                                                    'class' => 'm-2',
                                                                ]); ?></small>
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox(
                                                                    'socialsetting[]',
                                                                    'facebook',
                                                                    Utility::getsettings('facebooksetting') == 'on' ? true : false,
                                                                    [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'facebooksetting',
                                                                    ],
                                                                ); ?>

                                                                <?php echo e(Form::label('facebooksetting', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="mt-2 row">
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('facebook_client_id', __('Facebook Client Id'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::text(
                                                                    'facebook_client_id',
                                                                    Utility::getsettings('facebook_client_id') ? Utility::getsettings('facebook_client_id') : '',
                                                                    [
                                                                        'placeholder' => __('Enter facebook client id'),
                                                                        'class' => 'form-control',
                                                                    ],
                                                                ); ?>

                                                            </div>
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('facebook_client_secret', __('Facebook Client Secret'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::text(
                                                                    'facebook_client_secret',
                                                                    Utility::getsettings('facebook_client_secret') ? Utility::getsettings('facebook_client_secret') : '',
                                                                    [
                                                                        'placeholder' => __('Enter facebook client secret'),
                                                                        'class' => 'form-control',
                                                                    ],
                                                                ); ?>

                                                            </div>
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('facebook_redirect', __('Facebook Redirect Url'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::text(
                                                                    'facebook_redirect',
                                                                    Utility::getsettings('FACEBOOK_REDIRECT') ? Utility::getsettings('FACEBOOK_REDIRECT') : '',
                                                                    [
                                                                        'placeholder' => __('https://demo.test.com/callback/facebook'),
                                                                        'class' => 'form-control',
                                                                    ],
                                                                ); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="github">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsethree"
                                                        aria-expanded="true" aria-controls="collapsethree">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-brand-github text-primary"></i>
                                                            <?php echo e(__('Github')); ?>

                                                        </span>
                                                        <?php if(Utility::getsettings('githubsetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapsethree" class="accordion-collapse collapse"
                                                    aria-labelledby="github" data-bs-parent="#accordionExamples">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-between">
                                                            <small
                                                                class=""><?php echo e(__('How To Enable Login With Github')); ?>

                                                                <?php echo Html::link(Storage::url('pdf/login with github.pdf'), __('Document'), [
                                                                    'target' => '_blank',
                                                                    'class' => 'm-2',
                                                                ]); ?></small>
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox('socialsetting[]', 'github', Utility::getsettings('githubsetting') == 'on' ? true : false, [
                                                                    'class' => 'form-check-input',
                                                                    'id' => 'githubsetting',
                                                                ]); ?>

                                                                <?php echo e(Form::label('githubsetting', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="mt-2 row">
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('github_client_id', __('Github Client Id'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::text(
                                                                    'github_client_id',
                                                                    Utility::getsettings('github_client_id') ? Utility::getsettings('github_client_id') : '',
                                                                    [
                                                                        'placeholder' => __('Enter github client id'),
                                                                        'class' => 'form-control',
                                                                    ],
                                                                ); ?>

                                                            </div>
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('github_client_secret', __('Github Client Secret'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::text(
                                                                    'github_client_secret',
                                                                    Utility::getsettings('github_client_secret') ? Utility::getsettings('github_client_secret') : '',
                                                                    [
                                                                        'placeholder' => __('Enter github client secret'),
                                                                        'class' => 'form-control',
                                                                    ],
                                                                ); ?>

                                                            </div>
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('github_redirect', __('Github Redirect Url'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::text(
                                                                    'github_redirect',
                                                                    Utility::getsettings('github_redirect') ? Utility::getsettings('github_redirect') : '',
                                                                    [
                                                                        'placeholder' => __('https://demo.test.com/callback/github'),
                                                                        'class' => 'form-control',
                                                                    ],
                                                                ); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                    <div id="email-setting" class="">
                        <?php echo Form::open([
                            'route' => ['settings.email-setting.update'],
                            'method' => 'POST',
                            'data-validate',
                            'novalidate',
                        ]); ?>

                        <div class="card" id="settings-card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-lg-8 d-flex align-items-center">
                                        <h5> <?php echo e(__('Email Settings')); ?></h5>
                                    </div>
                                    <div class="col-lg-4 text-end">
                                        <div class="form-switch custom-switch-v1 d-inline-block">
                                            <?php echo Form::checkbox(
                                                'email_setting_enable',
                                                null,
                                                UtilityFacades::getsettings('email_setting_enable') == 'on' ? true : false,
                                                [
                                                    'class' => 'custom-control custom-switch form-check-input input-primary',
                                                    'id' => 'emailSettingEnableBtn',
                                                    'data-onstyle' => 'primary',
                                                    'data-toggle' => 'switchbutton',
                                                ],
                                            ); ?>

                                            <small
                                                class="text-end d-flex mt-2"><?php echo e(__('Please turn on this Email enable button.')); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body emailSettingEnableBtn">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_mailer', __('Mail Mailer'), ['class' => 'form-label'])); ?>

                                            <?php echo Form::text('mail_mailer', UtilityFacades::getsettings('mail_mailer'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail mailer'),
                                            ]); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_host', __('Mail Host'), ['class' => 'form-label'])); ?>

                                            <?php echo Form::text('mail_host', UtilityFacades::getsettings('mail_host'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail host'),
                                            ]); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_username', __('Mail Username'), ['class' => 'form-label'])); ?>

                                            <?php echo Form::text('mail_username', UtilityFacades::getsettings('mail_username'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail username'),
                                            ]); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_encryption', __('Mail Encryption'), ['class' => 'form-label'])); ?>

                                            <?php echo Form::text('mail_encryption', UtilityFacades::getsettings('mail_encryption'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail encryption'),
                                            ]); ?>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_from_name', __('Mail From Name'), ['class' => 'form-label'])); ?>

                                            <?php echo Form::text('mail_from_name', UtilityFacades::getsettings('mail_from_name'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail from name'),
                                            ]); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_port', __('Mail Port'), ['class' => 'form-label'])); ?>

                                            <?php echo Form::text('mail_port', UtilityFacades::getsettings('mail_port'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail port'),
                                            ]); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_password', __('Mail Password'), ['class' => 'form-label'])); ?>

                                            <input class="form-control"
                                                value="<?php echo e(UtilityFacades::getsettings('mail_password')); ?>"
                                                placeholder="<?php echo e(__('Enter mail password')); ?>" name="mail_password"
                                                type="password" id="mail_password">
                                        </div>

                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_from_address', __('Mail From Address'), ['class' => 'form-label'])); ?>

                                            <?php echo Form::text('mail_from_address', UtilityFacades::getsettings('mail_from_address'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter mail from address'),
                                            ]); ?>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="">
                                    <?php echo Form::button(__('Send Test Mail'), [
                                        'class' => 'btn btn-info send_mail d-inline float-start',
                                        'data-action' => route('test.mail'),
                                        'id' => 'test-mail',
                                    ]); ?>

                                    <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'mt-2 btn btn-primary float-end']); ?>

                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                    <div id="captcha-setting" class="">
                        <?php echo Form::open([
                            'route' => ['settings.captcha-setting.update'],
                            'method' => 'POST',
                            'data-validate',
                            'novalidate',
                        ]); ?>

                        <div class="card" id="settings-card">
                            <div class="card-header">
                                <div class="row d-flex align-items-center">
                                    <div class="col-6 d-flex justify-content-start">
                                        <h5><?php echo e(__('Capcha Settings')); ?></h5>
                                    </div>

                                    <div class="col-6 text-end">
                                        <div class="form-switch custom-switch-v1 d-inline-block">
                                            <?php echo Form::checkbox(
                                                'captcha_enable',
                                                null,
                                                UtilityFacades::getsettings('captcha_enable') == 'on' ? true : false,
                                                [
                                                    'class' => 'custom-control custom-switch form-check-input input-primary',
                                                    'id' => 'captchaEnableButton',
                                                    'data-onstyle' => 'primary',
                                                    'data-toggle' => 'switchbutton',
                                                ],
                                            ); ?>

                                            <small
                                                class="text-end d-flex mt-2"><?php echo e(__('Please turn on this Captcha Enable button.')); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="card-body captchaSetting <?php echo e(UtilityFacades::getsettings('captcha_enable') == 'on' ? '' : 'd-none'); ?>">
                                <div class="row" id="captchaSetting">
                                    <div class="form-group">
                                        <?php echo Form::radio('captcha', 'recaptcha', Utility::getsettings('captcha') == 'recaptcha' ? true : false, [
                                            'class' => 'btn-check',
                                            'id' => 'recahptchasetting',
                                        ]); ?>

                                        <?php echo Form::label('recahptchasetting', __('Recaptcha setting'), ['class' => 'btn btn-outline-primary']); ?>

                                        <?php echo Form::radio('captcha', 'hcaptcha', Utility::getsettings('captcha') == 'hcaptcha' ? true : false, [
                                            'class' => 'btn-check',
                                            'id' => 'hcaptchasetting',
                                        ]); ?>

                                        <?php echo Form::label('hcaptchasetting', __('hcaptcha setting'), ['class' => 'btn btn-outline-primary']); ?>

                                    </div>
                                    <div id="recaptcha"
                                        class="desc <?php echo e(Utility::getsettings('captcha') != 'hcaptcha' ? 'd-block' : 'd-none'); ?>">
                                        <p class="text-muted"> <?php echo e(__('Recaptcha Setting')); ?>

                                            <?php echo Html::link('https://www.google.com/recaptcha/admin', __('Document'), [
                                                'class' => 'm-2',
                                                'target' => '_blank',
                                            ]); ?>

                                        </p>
                                        <div class="row">
                                            <div class="form-group">
                                                <?php echo e(Form::label('recaptcha_key', __('Recaptcha Key'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('recaptcha_key', Utility::getsettings('captcha_sitekey'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter recaptcha key'),
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('recaptcha_secret', __('Recaptcha Secret'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('recaptcha_secret', Utility::getsettings('captcha_secret'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter recaptcha secret'),
                                                ]); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="hcaptcha"
                                        class="desc <?php echo e(Utility::getsettings('captcha') == 'hcaptcha' ? 'd-block' : 'd-none'); ?>">
                                        <p class="text-muted"> <?php echo e(__('Hcaptcha Setting')); ?>

                                            <?php echo Html::link('https://docs.hcaptcha.com/switch', __('Document'), ['class' => 'm-2', 'target' => '_blank']); ?>

                                        </p>
                                        <div class="row">
                                            <div class="form-group">
                                                <?php echo e(Form::label('hcaptcha_key', __('Hcaptcha Key'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('hcaptcha_key', Utility::getsettings('hcaptcha_key'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter hcaptcha key'),
                                                ]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('hcaptcha_secret', __('Hcaptcha Secret'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('hcaptcha_secret', Utility::getsettings('hcaptcha_secret'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter hcaptcha secret'),
                                                ]); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                    <div id="seo-setting" class="pt-0 card">
                        <?php echo Form::open([
                            'route' => ['settings.seo-setting.update'],
                            'enctype' => 'multipart/form-data',
                        ]); ?>

                        <div class="justify-content-between card-header d-flex align-items-center">
                            <h5> <?php echo e(__('SEO Setting')); ?></h5>
                            <div class="d-flex align-items-center text-end">
                                <div class="custom-control custom-switch" onclick="enableseo()">
                                    <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                        name="seo_setting" class="form-check-input input-primary " id="seo_setting"
                                        <?php echo e(Utility::getsettings('seo_setting') == 'on' ? ' checked ' : ''); ?>>
                                    <label class="mb-1 custom-control-label" for="seo_setting"></label>
                                    <small
                                        class="text-end d-flex mt-2"><?php echo e(__('Please turn on this SEO Enable button.')); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row seoDiv">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('meta_title', __('Meta Title'), ['class' => 'col-form-label'])); ?>

                                        <?php echo e(Form::text('meta_title', Utility::getsettings('meta_title') ? Utility::getsettings('meta_title') : '', [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter meta title'),
                                        ])); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo e(Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'col-form-label'])); ?>

                                        <?php echo e(Form::text(
                                            'meta_keywords',
                                            Utility::getsettings('meta_keywords') ? Utility::getsettings('meta_keywords') : '',
                                            [
                                                'id' => 'choices-text-remove-button',
                                                'class' => 'form-control ',
                                                'data-placeholder' => __('Enter meta keywords'),
                                            ],
                                        )); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo e(Form::label('meta_description', __('Meta Description'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::textarea(
                                            'meta_description',
                                            Utility::getsettings('meta_description') ? Utility::getsettings('meta_description') : '',
                                            ['class' => 'form-control ', 'rows' => 5, 'placeholder' => __('Enter meta description')],
                                        )); ?>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('Meta Image', __('Meta Image'), ['class' => 'col-form-label ms-4'])); ?>

                                        <div class="pt-0 card-body">
                                            <div class="setting-card">
                                                <div class="seo-image-content">
                                                    <a href="<?php echo e(Utility::getsettings('meta_image') ? Storage::url(Utility::getsettings('meta_image')) : Storage::url('seo-image/meta-image.jpg')); ?>"
                                                        target="_blank">
                                                        <img id="meta"
                                                            src="<?php echo e(Utility::getsettings('meta_image') ? Storage::url(Utility::getsettings('meta_image')) : Storage::url('seo-image/meta-image.jpg')); ?>"
                                                            width="250px">
                                                    </a>
                                                </div>
                                                <div class="mt-4 choose-files">
                                                    <label for="meta_image">
                                                        <div class="bg-primary logo"> <i
                                                                class="px-1 ti ti-upload"></i><?php echo e(__('Choose file here')); ?>

                                                        </div>
                                                        <input style="margin-top: -40px;" type="file"
                                                            class="form-control file" name="meta_image" id="meta_image"
                                                            data-filename="meta_image"
                                                            onchange="document.getElementById('meta').src = window.URL.createObjectURL(this.files[0])">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                    <div id="cache-setting" class="">
                        <div class="card" id="settings-card">
                            <div class="card-header">
                                <h5><?php echo e(__('Cache Setting')); ?></h5>
                                <small>
                                    <?php echo e(__('This is a page meant for more advanced users, simply ignore it if you don\'tunderstand what cache is.')); ?>

                                </small>
                            </div>
                            <?php echo Form::open([
                                'route' => 'config.cache',
                                'method' => 'Post',
                                'data-validate',
                            ]); ?>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?php echo e(Form::label('cache_size', __('Current cache size'), ['class' => 'form-label'])); ?>

                                            <div class="input-group">
                                                <?php echo Form::text('cache_size', Utility::GetCacheSize(), [
                                                    'class' => 'form-control',
                                                    'readonly',
                                                    'placeholder' => __('Enter cache size'),
                                                    'id' => 'cache_size',
                                                ]); ?>

                                                <span class="input-group-text"><?php echo e(__('MB')); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

                                </div>
                            </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>

                    <div id="cookie-setting" class="">
                        <?php echo Form::open([
                            'route' => ['settings.cookie-setting.update'],
                            'method' => 'POST',
                            'data-validate',
                            'novalidate',
                        ]); ?>

                        <div class="card">
                            <div class="justify-content-between card-header d-flex align-items-center">
                                <h5> <?php echo e(__('Cookie Setting')); ?></h5>
                                <div class="d-flex align-items-center text-end">
                                    <div class="custom-control custom-switch" onclick="enablecookie()">
                                        <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                            name="enable_cookie" class="form-check-input input-primary "
                                            id="enable_cookie"
                                            <?php echo e(Utility::getsettings('enable_cookie') == 'on' ? ' checked ' : ''); ?>>
                                        <label class="mb-1 custom-control-label" for="enable_cookie"></label>
                                        <small
                                            class="text-end d-flex mt-2"><?php echo e(__('Please turn on this Cookie Enable button.')); ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row cookieDiv">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                                            <input type="checkbox" name="cookie_logging"
                                                class="form-check-input input-primary" id="cookie_logging"
                                                onclick="enableButton()"
                                                <?php echo e(Utility::getsettings('cookie_logging') == 'on' ? ' checked ' : ''); ?>>
                                            <label class="form-check-label"
                                                for="cookie_logging"><?php echo e(__('Enable logging')); ?></label>
                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('cookie_title', __('Cookie Title'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('cookie_title', Utility::getsettings('cookie_title'), ['class' => 'form-control', 'placeholder' => __('Enter cookie title')])); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('cookie_description', __('Cookie Description'), ['class' => 'form-label'])); ?>

                                            <?php echo Form::textarea('cookie_description', Utility::getsettings('cookie_description'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter cookie description'),
                                                'rows' => '3',
                                            ]); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch custom-switch-v1 ">
                                            <input type="checkbox" name="necessary_cookies"
                                                class="form-check-input input-primary" id="necessary_cookies" checked
                                                onclick="return false">
                                            <label class="form-check-label"
                                                for="necessary_cookies"><?php echo e(__('Strictly necessary cookies')); ?></label>
                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('strictly_cookie_title', Utility::getsettings('strictly_cookie_title'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter strictly cookie description'),
                                            ])); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label'])); ?>

                                            <?php echo Form::textarea('strictly_cookie_description', Utility::getsettings('strictly_cookie_description'), [
                                                'class' => 'form-control ',
                                                'placeholder' => __('Enter strictly cookie description'),
                                                'rows' => '3',
                                            ]); ?>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <h5><?php echo e(__('More Information')); ?></h5>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <?php echo e(Form::label('more_information_description', __('Contact Us Description'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('more_information_description', Utility::getsettings('more_information_description'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter more information description'),
                                            ])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php echo e(Form::label('contactus_url', __('Contact Us URL'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('contactus_url', Utility::getsettings('contactus_url'), ['class' => 'form-control', 'placeholder' => __('Enter contact url')])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"><?php echo e(__('Download cookie accepted data')); ?></label>
                                            <a href="<?php echo e(Storage::url('seo-image/cookie-data.csv')); ?>"
                                                class="mr-2 btn btn-primary">
                                                <i class="ti ti-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                    <div id="payment-setting" class="faq">
                        <?php echo Form::open([
                            'route' => ['settings/stripe-setting/update'],
                            'method' => 'POST',
                            'data-validate',
                            'novalidate',
                        ]); ?>

                        <div class="card" id="settings-card">
                            <div class="card-header">
                                <h5> <?php echo e(__('Payment Settings')); ?></h5>
                            </div>
                            <div class="p-4 card-body">
                                <div class="mt-3 row">
                                    <div class="col-md-12">
                                        <div class="accordion accordion-flush" id="accordionExample">
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="stripe">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse1"
                                                        aria-expanded="true" aria-controls="collapse1">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('Stripe')); ?>

                                                        </span>
                                                        <?php if(UtilityFacades::getsettings('stripesetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapse1" class="accordion-collapse collapse"
                                                    aria-labelledby="stripe" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox(
                                                                    'paymentsetting[]',
                                                                    'stripe',
                                                                    UtilityFacades::getsettings('stripesetting') == 'on' ? true : false,
                                                                    [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_stripe_enable',
                                                                    ],
                                                                ); ?>

                                                                <?php echo e(Form::label('is_stripe_enable', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="mt-2 row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('stripe_key', __('Stripe Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('stripe_key', UtilityFacades::getsettings('stripe_key'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter stripe key'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('stripe_secret', __('Stripe Secret'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('stripe_secret', UtilityFacades::getsettings('stripe_secret'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter stripe secret'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="razorpay">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse2"
                                                        aria-expanded="true" aria-controls="collapse2">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('Razorpay')); ?>

                                                        </span>
                                                        <?php if(UtilityFacades::getsettings('razorpaysetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapse2" class="accordion-collapse collapse"
                                                    aria-labelledby="razorpay" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox(
                                                                    'paymentsetting[]',
                                                                    'razorpay',
                                                                    UtilityFacades::getsettings('razorpaysetting') == 'on' ? true : false,
                                                                    [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_razorpay_enable',
                                                                    ],
                                                                ); ?>

                                                                <?php echo e(Form::label('is_razorpay_enable', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="mt-2 row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('razorpay_key', __('Razorpay Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('razorpay_key', UtilityFacades::getsettings('razorpay_key'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter razorpay key'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('razorpay_secret', __('Razorpay Secret'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('razorpay_secret', UtilityFacades::getsettings('razorpay_secret'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter razorpay secret'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="paypal">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsepaypal"
                                                        aria-expanded="true" aria-controls="collapsepaypal">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('Paypal')); ?>

                                                        </span>
                                                        <?php if(UtilityFacades::getsettings('paypalsetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapsepaypal" class="accordion-collapse collapse"
                                                    aria-labelledby="paypal" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox(
                                                                    'paymentsetting[]',
                                                                    'paypal',
                                                                    UtilityFacades::getsettings('paypalsetting') == 'on' ? true : false,
                                                                    [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_paypal_enable',
                                                                    ],
                                                                ); ?>

                                                                <?php echo e(Form::label('is_paypal_enable', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <?php echo e(Form::label('paypal_mode', __('Paytm Environment'), ['class' => 'paypal-label col-form-label'])); ?>

                                                            <br>
                                                            <div class="d-flex">
                                                                <div class="mr-2">
                                                                    <div class="p-3 border card">
                                                                        <div class="form-check">
                                                                            <label class="form-check-labe text-dark">
                                                                                <?php echo Form::radio(
                                                                                    'paypal_mode_unique',
                                                                                    'sandbox',
                                                                                    UtilityFacades::getsettings('paypal_mode') == 'sandbox' ? true : false,
                                                                                    ['class' => 'form-check-input'],
                                                                                ); ?><?php echo e(__('Sandbox')); ?>

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mr-2">
                                                                    <div class="p-3 border card">
                                                                        <div class="form-check">
                                                                            <label class="form-check-labe text-dark">
                                                                                <?php echo Form::radio('paypal_mode', 'live', UtilityFacades::getsettings('paypal_mode') == 'live' ? true : false, [
                                                                                    'class' => 'form-check-input',
                                                                                ]); ?><?php echo e(__('Live')); ?>

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2 row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('client_id', __('Paypal Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('client_id', UtilityFacades::getsettings('paypal_sandbox_client_id'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter paypal key'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('client_secret', __('Paypal Secret'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('client_secret', UtilityFacades::getsettings('paypal_sandbox_client_secret'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter paypal secret'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="paytm">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsepaytm"
                                                        aria-expanded="true" aria-controls="collapsepaytm">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('Paytm')); ?>

                                                        </span>
                                                        <?php if(Utility::getsettings('paytmsetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapsepaytm" class="accordion-collapse collapse"
                                                    aria-labelledby="paytm" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox(
                                                                    'paymentsetting[]',
                                                                    'paytm',
                                                                    UtilityFacades::getsettings('paytmsetting') == 'on' ? true : false,
                                                                    [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_paytm_enable',
                                                                    ],
                                                                ); ?>

                                                                <?php echo e(Form::label('is_paytm_enable', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="mt-2 row">
                                                            <div class=" col-md-12">
                                                                <?php echo e(Form::label('paypal_mode', __('Paytm Environment'), ['class' => 'paypal-label col-form-label'])); ?>

                                                                <br>
                                                                <div class="d-flex">
                                                                    <div class="mr-2">
                                                                        <div class="p-3 border card">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <?php echo Form::radio(
                                                                                        'paytm_environment',
                                                                                        'local',
                                                                                        UtilityFacades::getsettings('paytm_environment') == 'local' ? true : false,
                                                                                        ['class' => 'form-check-input'],
                                                                                    ); ?><?php echo e(__('Local')); ?>

                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mr-2">
                                                                        <div class="p-3 border card">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <?php echo Form::radio(
                                                                                        'paytm_environment',
                                                                                        'production',
                                                                                        UtilityFacades::getsettings('paytm_environment') == 'production' ? true : false,
                                                                                        ['class' => 'form-check-input'],
                                                                                    ); ?><?php echo e(__('Production')); ?>

                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('merchant_id', __('Paytm Merchant Id'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('merchant_id', UtilityFacades::getsettings('paytm_merchant_id'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter paytm merchant id'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('merchant_key', __('Paytm Merchant Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('merchant_key', UtilityFacades::getsettings('paytm_merchant_key'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter paytm merchant key'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="flutterwave">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseflutterwave"
                                                        aria-expanded="true" aria-controls="collapseflutterwave">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('Flutterwave')); ?>

                                                        </span>
                                                        <?php if(UtilityFacades::getsettings('flutterwavesetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapseflutterwave" class="accordion-collapse collapse"
                                                    aria-labelledby="flutterwave" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox(
                                                                    'paymentsetting[]',
                                                                    'flutterwave',
                                                                    UtilityFacades::getsettings('flutterwavesetting') == 'on' ? true : false,
                                                                    [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_flutterwave_enable',
                                                                    ],
                                                                ); ?>

                                                                <?php echo e(Form::label('is_flutterwave_enable', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="mt-2 row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('flw_public_key', __('Flutterwave Public Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('flw_public_key', UtilityFacades::getsettings('flw_public_key'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter flutterwave public key'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('flw_secret_key', __('Flutterwave Secret Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('flw_secret_key', UtilityFacades::getsettings('flw_secret_key'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter flutterwave secret key'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="paystack">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsepaystack"
                                                        aria-expanded="true" aria-controls="collapsepaystack">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('Paystack')); ?>

                                                        </span>
                                                        <?php if(UtilityFacades::getsettings('paystacksetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapsepaystack" class="accordion-collapse collapse"
                                                    aria-labelledby="paystack" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox(
                                                                    'paymentsetting[]',
                                                                    'paystack',
                                                                    UtilityFacades::getsettings('paystacksetting') == 'on' ? true : false,
                                                                    [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_paystack_enable',
                                                                    ],
                                                                ); ?>

                                                                <?php echo e(Form::label('is_paystack_enable', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="mt-2 row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('paystack_public_key', __('Paystack Public Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('paystack_public_key', UtilityFacades::getsettings('paystack_public_key'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter paystack public key'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('paystack_secret_key', __('Paystack Secret Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('paystack_secret_key', UtilityFacades::getsettings('paystack_secret_key'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter paystack secret key'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading-2-11">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse10"
                                                        aria-expanded="true" aria-controls="collapse10">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('CoinGate')); ?>

                                                        </span>
                                                        <?php if(UtilityFacades::getsettings('coingatesetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapse10" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-2-11" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox(
                                                                    'paymentsetting[]',
                                                                    'coingate',
                                                                    UtilityFacades::getsettings('coingatesetting') == 'on' ? true : false,
                                                                    [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_coingate_enable',
                                                                    ],
                                                                ); ?>

                                                                <?php echo e(Form::label('is_coingate_enable', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class=" col-md-12">
                                                            <?php echo e(Form::label('coingate_mode', __('CoinGate Mode'), ['class' => 'col-form-label'])); ?>

                                                            <br>
                                                            <div class="d-flex">
                                                                <div class="mr-2">
                                                                    <div class="p-3 border card">
                                                                        <div class="form-check">
                                                                            <label class="form-check-labe text-dark">
                                                                                <?php echo Form::radio(
                                                                                    'coingate_mode',
                                                                                    'sandbox',
                                                                                    UtilityFacades::getsettings('coingate_environment') == 'sandbox' ? true : false,
                                                                                    ['class' => 'form-check-input', 'id' => 'coingate_mode_sandbox'],
                                                                                ); ?><?php echo e(__('Sandbox')); ?>

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mr-2">
                                                                    <div class="p-3 border card">
                                                                        <div class="form-check">
                                                                            <label class="form-check-labe text-dark">
                                                                                <?php echo Form::radio(
                                                                                    'coingate_mode',
                                                                                    'live',
                                                                                    UtilityFacades::getsettings('coingate_environment') == 'live' ? true : false,
                                                                                    ['class' => 'form-check-input', 'id' => 'coingate_mode_live'],
                                                                                ); ?><?php echo e(__('Live')); ?>

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <?php echo e(Form::label('coingate_auth_token', __('CoinGate Auth Token'), ['class' => 'form-label'])); ?>

                                                            <?php echo Form::text('coingate_auth_token', UtilityFacades::getsettings('coingate_auth_token'), [
                                                                'class' => 'form-control',
                                                                'placeholder' => __('Enter coingate auth token'),
                                                                'id' => 'coingate_auth_token',
                                                            ]); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- PayUMoney -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading-2-payumoney">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse-payumoney"
                                                        aria-expanded="true" aria-controls="collapse-payumoney">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('PayUMoney')); ?>

                                                        </span>
                                                        <?php if(UtilityFacades::getsettings('payumoneysetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapse-payumoney" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-2-payumoney"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="py-1 col-12 text-end">
                                                                <div class="form-check form-switch d-inline-block">
                                                                    <?php echo Form::checkbox(
                                                                        'paymentsetting[]',
                                                                        'payumoney',
                                                                        UtilityFacades::getsettings('payumoneysetting') == 'on' ? true : false,
                                                                        [
                                                                            'class' => 'form-check-input mx-2',
                                                                            'id' => 'payment_payumoney',
                                                                        ],
                                                                    ); ?>

                                                                    <?php echo e(Form::label('payment_payumoney', __('Enable'), ['class' => 'form-check-label'])); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <?php echo e(Form::label('payumoney_mode', __('PayUMoney Mode'), ['class' => 'paypal-label form-label'])); ?>

                                                                <br>
                                                                <div class="d-flex">
                                                                    <div class="mr-2">
                                                                        <div class="p-3 border card">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <?php echo Form::radio(
                                                                                        'payumoney_mode',
                                                                                        'sandbox',
                                                                                        Utility::getsettings('payumoney_mode') == 'sandbox' ? true : false,
                                                                                        [
                                                                                            'class' => 'form-check-input',
                                                                                            'id' => 'payumoney_sandbox',
                                                                                        ],
                                                                                    ); ?><?php echo e(__('Sandbox')); ?>

                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mr-2">
                                                                        <div class="p-3 border card">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <?php echo Form::radio(
                                                                                        'payumoney_mode',
                                                                                        'production',
                                                                                        Utility::getsettings('payumoney_mode') == 'production' ? true : false,
                                                                                        [
                                                                                            'class' => 'form-check-input',
                                                                                            'id' => 'payumoney_production',
                                                                                        ],
                                                                                    ); ?><?php echo e(__('Production')); ?>

                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('payumoney_merchant_key', __('PayUMoney Merchant Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('payumoney_merchant_key', UtilityFacades::getsettings('payumoney_merchant_key'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter payumoney merchant key'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('payumoney_salt_key', __('PayUMoney Salt Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('payumoney_salt_key', UtilityFacades::getsettings('payumoney_salt_key'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter payumoney salt key'),
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Mollie -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading18">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse18"
                                                        aria-expanded="true" aria-controls="collapse18">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('Mollie')); ?>

                                                        </span>
                                                        <?php if(Utility::getsettings('molliesetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapse18" class="accordion-collapse collapse"
                                                    aria-labelledby="heading18" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="py-2 col-12 text-end">
                                                                <div class="form-check form-switch d-inline-block">
                                                                    <?php echo Form::checkbox('paymentsetting[]', 'mollie', Utility::getsettings('molliesetting') == 'on' ? true : false, [
                                                                        'class' => 'form-check-input mx-2',
                                                                        'id' => 'payment_mollie',
                                                                    ]); ?>

                                                                    <?php echo e(Form::label('payment_mollie', __('Enable'), ['class' => 'form-check-label'])); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('mollie_api_key', __('Mollie Api Key'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('mollie_api_key', Utility::getsettings('mollie_api_key'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter Mollie Api Key'),
                                                                        'id' => 'mollie_api_key',
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('mollie_profile_id', __('Mollie Profile Id'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('mollie_profile_id', Utility::getsettings('mollie_profile_id'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter Mollie Profile Id'),
                                                                        'id' => 'mollie_profile_id',
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label('mollie_partner_id', __('Mollie Partner Id'), ['class' => 'form-label'])); ?>

                                                                    <?php echo Form::text('mollie_partner_id', Utility::getsettings('mollie_partner_id'), [
                                                                        'class' => 'form-control',
                                                                        'placeholder' => __('Enter Mollie Partner Id'),
                                                                        'id' => 'mollie_partner_id',
                                                                    ]); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--- Mercado pago --->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="mercado">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsemercado"
                                                        aria-expanded="true" aria-controls="collapsemercado">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('Mercado')); ?>

                                                        </span>
                                                        <?php if(Utility::getsettings('mercadosetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapsemercado" class="accordion-collapse collapse"
                                                    aria-labelledby="mercado" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox(
                                                                    'paymentsetting[]',
                                                                    'mercado',
                                                                    Utility::getsettings('mercadosetting') == 'on' ? true : false,
                                                                    [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_mercado_enable',
                                                                    ],
                                                                ); ?>

                                                                <?php echo e(Form::label('is_mercado_enable', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <?php echo e(Form::label('mercado_mode', __('Mercado Environment'), ['class' => 'mercado-label col-form-label'])); ?>

                                                            <br>
                                                            <div class="d-flex">
                                                                <div class="mr-2">
                                                                    <div class="p-3 border card">
                                                                        <div class="form-check">
                                                                            <label class="form-check-labe text-dark">
                                                                                <?php echo Form::radio(
                                                                                    'mercado_mode_unique',
                                                                                    'sandbox',
                                                                                    UtilityFacades::getsettings('mercado_mode') == 'sandbox' ? true : false,
                                                                                    ['class' => 'form-check-input'],
                                                                                ); ?><?php echo e(__('Sandbox')); ?>

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mr-2">
                                                                    <div class="p-3 border card">
                                                                        <div class="form-check">
                                                                            <label class="form-check-labe text-dark">
                                                                                <?php echo Form::radio('mercado_mode', 'live', UtilityFacades::getsettings('mercado_mode') == 'live' ? true : false, [
                                                                                    'class' => 'form-check-input',
                                                                                ]); ?><?php echo e(__('Live')); ?>

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2 row">
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('mercado_access_token', __('Mercado Access Token'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::text('mercado_access_token', UtilityFacades::getsettings('mercado_access_token'), [
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('Enter mercado access token'),
                                                                    'id' => 'mercado_access_token',
                                                                ]); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="mercado">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsofflinepayment"
                                                        aria-expanded="true" aria-controls="collapsofflinepayment">
                                                        <span class="flex-1 d-flex align-items-center">
                                                            <i class="ti ti-credit-card text-primary"></i>
                                                            <?php echo e(__('Offline Payment')); ?>

                                                        </span>
                                                        <?php if(Utility::getsettings('offlinepaymentsetting') == 'on'): ?>
                                                            <a
                                                                class="text-white btn btn-sm btn-primary float-end me-3"><?php echo e(__('Active')); ?></a>
                                                        <?php endif; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapsofflinepayment" class="accordion-collapse collapse"
                                                    aria-labelledby="offline_payment" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <div class="form-check form-switch d-inline-block">
                                                                <?php echo Form::checkbox(
                                                                    'paymentsetting[]',
                                                                    'offlinepayment',
                                                                    Utility::getsettings('offlinepaymentsetting') == 'on' ? true : false,
                                                                    [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_offline_payment',
                                                                    ],
                                                                ); ?>

                                                                <?php echo e(Form::label('is_offline_payment', __('Enable'), ['class' => 'custom-control-label form-control-label'])); ?>

                                                            </div>
                                                        </div>

                                                        <div class="mt-2 row">
                                                            <div class="form-group">
                                                                <?php echo e(Form::label('offline_payment_details', __('Payment Details'), ['class' => 'form-label'])); ?>

                                                                <?php echo Form::textarea('offline_payment_details', UtilityFacades::getsettings('offline_payment_details'), [
                                                                    'class' => 'form-control',
                                                                    'placeholder' => __('Enter Payment Details'),
                                                                    'id' => 'offline_payment_details',
                                                                    'rows' => '3',
                                                                ]); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                    <div id="sms-setting" class="card">
                        <?php echo Form::open([
                            'route' => 'settings.sms-setting.update',
                            'method' => 'POST',
                            'data-validate',
                            'novalidate',
                        ]); ?>

                        <div class="card-header">
                            <div class="row d-flex align-items-center">
                                <div class="col-6 d-flex justify-content-start">
                                    <h5> <?php echo e(__('Sms Setting')); ?></h5>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="form-switch custom-switch-v1 d-inline-block">
                                        <?php echo Form::checkbox(
                                            'multisms_setting',
                                            null,
                                            UtilityFacades::getsettings('multisms_setting') == 'on' ? true : false,
                                            [
                                                'class' => 'custom-control custom-switch form-check-input input-primary',
                                                'id' => 'multi_sms',
                                                'data-onstyle' => 'primary',
                                                'data-toggle' => 'switchbutton',
                                            ],
                                        ); ?>

                                        <small
                                            class="text-end d-flex mt-2"><?php echo e(__('Please turn on this SMS enable button.')); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div
                                    class="col-sm-12 multi_sms <?php echo e(UtilityFacades::getsettings('multisms_setting') == 'on' ? '' : 'd-none'); ?>">
                                    <div class="form-group">
                                        <?php echo Form::radio('smssetting', 'twilio', Utility::getsettings('smssetting') == 'twilio' ? true : false, [
                                            'class' => 'btn-check',
                                            'id' => 'smssetting_twilio',
                                        ]); ?>

                                        <?php echo e(Form::label('smssetting_twilio', __('Twilio'), ['class' => 'btn btn-outline-primary'])); ?>


                                        <?php echo Form::radio('smssetting', 'nexmo', Utility::getsettings('smssetting') == 'nexmo' ? true : false, [
                                            'class' => 'btn-check',
                                            'id' => 'smssetting_nexmo',
                                        ]); ?>

                                        <?php echo e(Form::label('smssetting_nexmo', __('Nexmo'), ['class' => 'btn btn-outline-primary'])); ?>

                                    </div>
                                    <div id="twilio"
                                        class="desc <?php echo e(Utility::getsettings('smssetting') == 'twilio' ? 'block' : 'd-none'); ?>">
                                        <div class="">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="name"><?php echo e(__('Twilio SID')); ?></label>
                                                    <input type="text" name="twilio_sid" class="form-control"
                                                        value="<?php echo e(Utility::getsettings('twilio_sid')); ?>"
                                                        placeholder="<?php echo e(__('Enter twilio sid')); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="name"><?php echo e(__('Twilio Auth Token')); ?></label>
                                                    <input type="text" name="twilio_auth_token" class="form-control"
                                                        value="<?php echo e(Utility::getsettings('twilio_auth_token')); ?>"
                                                        placeholder="<?php echo e(__('Enter twilio auth token')); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="name"><?php echo e(__('Twilio Verify SID')); ?></label>
                                                    <input type="text" name="twilio_verify_sid" class="form-control"
                                                        value="<?php echo e(Utility::getsettings('twilio_verify_sid')); ?>"
                                                        placeholder="<?php echo e(__('Enter verify sid')); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="name"><?php echo e(__('Twilio Number')); ?></label>
                                                    <input type="text" name="twilio_number" class="form-control"
                                                        value="<?php echo e(Utility::getsettings('twilio_number')); ?>"
                                                        placeholder="<?php echo e(__('Enter number')); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="nexmo"
                                        class="desc <?php echo e(Utility::getsettings('smssetting') == 'nexmo' ? 'block' : 'd-none'); ?>">
                                        <div class="">
                                            <div class="row">
                                                <div class="form-group">
                                                    <?php echo e(Form::label('nexmo_key', __('Nexmo Key'), ['class' => 'form-label'])); ?>

                                                    <?php echo Form::text('nexmo_key', Utility::getsettings('nexmo_key'), [
                                                        'placeholder' => __('Enter nexmo key'),
                                                        'class' => 'form-control',
                                                    ]); ?>

                                                </div>
                                                <div class="form-group">
                                                    <?php echo e(Form::label('nexmo_secret', __('Nexmo Secret'), ['class' => 'form-label'])); ?>

                                                    <?php echo Form::text('nexmo_secret', Utility::getsettings('nexmo_secret'), [
                                                        'placeholder' => __('Enter nexmo secret'),
                                                        'class' => 'form-control',
                                                    ]); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary float-end mb-3'])); ?>

                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                    <div id="google-calender-setting" class="card">
                        <div class="col-md-12">
                            <?php echo e(Form::open(['route' => 'settings.google-calender.update', 'method' => 'POST', 'data-validate', 'novalidate', 'enctype' => 'multipart/form-data'])); ?>

                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5><?php echo e(__('Google Calendar Settings')); ?></h5>
                                    </div>
                                    <div class="col-6 text-end">
                                        <div class="">
                                            <div class="form-switch custom-switch-v1 d-inline-block">
                                                <?php echo Form::checkbox(
                                                    'google_calendar_enable',
                                                    null,
                                                    UtilityFacades::getsettings('google_calendar_enable') == 'on' ? 'checked' : '',
                                                    [
                                                        'class' => 'custom-control custom-switch form-check-input input-primary',
                                                        'data-onstyle' => 'primary',
                                                        'data-toggle' => 'switchbutton',
                                                        'id' => 'google_calender',
                                                    ],
                                                ); ?>

                                                <small
                                                    class="text-end d-flex mt-2"><?php echo e(__('Please turn on this Google calendar enable button.')); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body google_calender">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <?php echo e(Form::label('google_calendar_id', __('Google Calendar Id'), ['class' => 'col-form-label'])); ?>

                                        <?php echo e(Form::text('google_calendar_id', UtilityFacades::getsettings('google_calendar_id'), ['class' => 'form-control ', 'placeholder' => 'Google Calendar Id', 'required' => true])); ?>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <?php echo e(Form::label('Google_calendar_json_file', __('Google Calendar json File'), ['class' => 'col-form-label'])); ?>

                                        <?php echo e(Form::file('google_calendar_json_file', ['class' => 'form-control', 'id' => 'file'])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn-submit btn btn-primary" type="submit">
                                    <?php echo e(__('Save')); ?>

                                </button>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>

                    <div id="google-map-setting" class="card">
                        <div class="col-md-12">
                            <?php echo e(Form::open(['route' => 'settings.googlemap.update', 'method' => 'POST', 'data-validate', 'novalidate'])); ?>

                            <div class="card-header">
                                <div class="row d-flex align-items-center">
                                    <div class="col-6">
                                        <h5 class="mb-2"><?php echo e(__('Google Map Setting')); ?></h5>
                                    </div>
                                    <div class="col-6 text-end">
                                        <div class="form-switch custom-switch-v1 d-inline-block">
                                            <?php echo Form::checkbox(
                                                'google_map_enable',
                                                null,
                                                UtilityFacades::getsettings('google_map_enable') == 'on' ? true : false,
                                                [
                                                    'class' => 'custom-switch custom-control form-check-input input-primary',
                                                    'data-toggle' => 'switchbutton',
                                                    'id' => 'google_map',
                                                ],
                                            ); ?>

                                            <small
                                                class="text-end d-flex mt-2"><?php echo e(__('Please turn on this Google Map enable button.')); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body google_map">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <?php echo e(Form::label('google_map_api', __('Google Map Api Kay'), ['class' => 'col-form-label'])); ?>

                                        <?php echo e(Form::text('google_map_api', UtilityFacades::getsettings('google_map_api'), ['class' => 'form-control ', 'placeholder' => 'Enter MAp API key', 'required' => 'required'])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn-submit btn btn-primary" type="submit">
                                    <?php echo e(__('Save')); ?>

                                </button>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>
                    <div id="notification-setting" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Notifications')); ?></h5>
                        </div>
                        <div class="pt-0 card-body">
                            <div class="mt-0 table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Title')); ?></th>
                                            <th class="w-auto text-end"><?php echo e(__('Email')); ?></th>
                                            <th class="w-auto text-end"><?php echo e(__('Notification')); ?></th>
                                        </tr>
                                    </thead>
                                    <?php $__currentLoopData = $notificationsSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificationsSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <span name="title" class="form-control"
                                                            placeholder="Enter title"
                                                            value="<?php echo e($notificationsSetting->id); ?>">
                                                            <?php echo e($notificationsSetting->title); ?></span>
                                                    </div>
                                                </td>
                                                <?php if($notificationsSetting->email_notification != 2): ?>
                                                    <td class="text-end">
                                                        <div class="form-check form-switch d-inline-block">
                                                            <?php echo Form::checkbox('email_notification', null, $notificationsSetting->email_notification == 1 ? true : false, [
                                                                'class' => 'form-check-input chnageEmailNotifyStatus',
                                                                'data-url' => route('notification.status.change', $notificationsSetting->id),
                                                            ]); ?>

                                                        </div>
                                                    </td>
                                                <?php else: ?>
                                                    <td></td>
                                                <?php endif; ?>

                                                <?php if(
                                                    $notificationsSetting->status == 2 &&
                                                        $notificationsSetting->title != 'testing purpose' &&
                                                        $notificationsSetting->title != 'new Enquire details' &&
                                                        $notificationsSetting->title != 'new survey details'): ?>
                                                <?php else: ?>
                                                    <td class="text-end">
                                                        <div class="form-check form-switch d-inline-block">
                                                            <?php echo Form::checkbox('notify', null, $notificationsSetting->notify == 1 ? true : false, [
                                                                'class' => 'form-check-input chnageNotifyStatus',
                                                                'data-url' => route('notification.status.change', $notificationsSetting->id),
                                                            ]); ?>

                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        </tbody>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="pwa-setting" class="card">
                        <div class="col-md-12">
                            <?php echo e(Form::open(['route' => 'settings.pwa-setting.update', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                            <div class="card-header">
                                <div class="row d-flex align-items-center">
                                    <div class="col-6">
                                        <h5 class="mb-2"><?php echo e(__('PWA Setting')); ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body google_map">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-md-6 form-group">
                                        <div class="card">
                                            <div class="card-header d-flex">
                                                <h5 class="me-1"><?php echo e(__('PWA Icon')); ?></h5>
                                                <span>(128x128)</span>
                                            </div>
                                            <div class="pt-0 card-body">
                                                <div class="inner-content">
                                                    <div class="py-2 mt-4 text-center logo-content dark-logo-content">
                                                        <a href="<?php echo e(Utility::getpath('pwa_icon_128') ? Storage::url(Utility::getsettings('pwa_icon_128')) : ''); ?>"
                                                            target="_blank">
                                                            <img src="<?php echo e(Utility::getpath('pwa_icon_128') ? Storage::url(Utility::getsettings('pwa_icon_128')) : ''); ?>"
                                                                id="pwa_128">
                                                        </a>
                                                    </div>
                                                    <div class="mt-3 text-center choose-files">
                                                        <label for="pwa_icon_128">
                                                            <div class="bg-primary company_logo_update"> <i
                                                                    class="px-1 ti ti-upload"></i><?php echo e(__('Choose file here')); ?>

                                                            </div>
                                                            <?php echo e(Form::file('pwa_icon_128', ['class' => 'form-control file', 'id' => 'pwa_icon_128', 'onchange' => "document.getElementById('pwa_128').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'pwa_icon_128'])); ?>

                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header d-flex">
                                                <h5 class="me-1"><?php echo e(__('PWA Icon')); ?></h5>
                                                <span>(144x144)</span>
                                            </div>
                                            <div class="pt-0 card-body">
                                                <div class="inner-content">
                                                    <div class="py-2 mt-4 text-center logo-content dark-logo-content">
                                                        <a href="<?php echo e(Utility::getpath('pwa_icon_144') ? Storage::url(Utility::getsettings('pwa_icon_144')) : ''); ?>"
                                                            target="_blank">
                                                            <img src="<?php echo e(Utility::getpath('pwa_icon_144') ? Storage::url(Utility::getsettings('pwa_icon_144')) : ''); ?>"
                                                                id="pwa_144">
                                                        </a>
                                                    </div>
                                                    <div class="mt-3 text-center choose-files">
                                                        <label for="pwa_icon_144">
                                                            <div class="bg-primary company_logo_update"> <i
                                                                    class="px-1 ti ti-upload"></i><?php echo e(__('Choose file here')); ?>

                                                            </div>
                                                            <?php echo e(Form::file('pwa_icon_144', ['class' => 'form-control file', 'id' => 'pwa_icon_144', 'onchange' => "document.getElementById('pwa_144').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'pwa_icon_144'])); ?>

                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header d-flex">
                                                <h5 class="me-1"><?php echo e(__('PWA Icon')); ?></h5>
                                                <span>(152x152)</span>
                                            </div>
                                            <div class="pt-0 card-body">
                                                <div class="inner-content">
                                                    <div class="py-2 mt-4 text-center logo-content dark-logo-content">
                                                        <a href="<?php echo e(Utility::getpath('pwa_icon_152') ? Storage::url(Utility::getsettings('pwa_icon_152')) : ''); ?>"
                                                            target="_blank">
                                                            <img src="<?php echo e(Utility::getpath('pwa_icon_152') ? Storage::url(Utility::getsettings('pwa_icon_152')) : ''); ?>"
                                                                id="pwa_152">
                                                        </a>
                                                    </div>
                                                    <div class="mt-3 text-center choose-files">
                                                        <label for="pwa_icon_152">
                                                            <div class="bg-primary company_logo_update"> <i
                                                                    class="px-1 ti ti-upload"></i><?php echo e(__('Choose file here')); ?>

                                                            </div>
                                                            <?php echo e(Form::file('pwa_icon_152', ['class' => 'form-control file', 'id' => 'pwa_icon_152', 'onchange' => "document.getElementById('pwa_152').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'pwa_icon_152'])); ?>

                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header d-flex">
                                                <h5 class="me-1"><?php echo e(__('PWA Icon')); ?></h5>
                                                <span>(192x192)</span>
                                            </div>
                                            <div class="pt-0 card-body">
                                                <div class="inner-content">
                                                    <div class="py-2 mt-4 text-center logo-content dark-logo-content">
                                                        <a href="<?php echo e(Utility::getpath('pwa_icon_192') ? Storage::url(Utility::getsettings('pwa_icon_192')) : ''); ?>"
                                                            target="_blank">
                                                            <img src="<?php echo e(Utility::getpath('pwa_icon_192') ? Storage::url(Utility::getsettings('pwa_icon_192')) : ''); ?>"
                                                                id="pwa_192">
                                                        </a>
                                                    </div>
                                                    <div class="mt-3 text-center choose-files">
                                                        <label for="pwa_icon_192">
                                                            <div class="bg-primary company_logo_update"> <i
                                                                    class="px-1 ti ti-upload"></i><?php echo e(__('Choose file here')); ?>

                                                            </div>
                                                            <?php echo e(Form::file('pwa_icon_192', ['class' => 'form-control file', 'id' => 'pwa_icon_192', 'onchange' => "document.getElementById('pwa_192').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'pwa_icon_192'])); ?>

                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header d-flex">
                                                <h5 class="me-1"><?php echo e(__('PWA Icon')); ?></h5>
                                                <span>(256x256)</span>
                                            </div>
                                            <div class="pt-0 card-body">
                                                <div class="inner-content">
                                                    <div class="py-2 mt-4 text-center logo-content dark-logo-content">
                                                        <a href="<?php echo e(Utility::getpath('pwa_icon_256') ? Storage::url(Utility::getsettings('pwa_icon_256')) : ''); ?>"
                                                            target="_blank">
                                                            <img src="<?php echo e(Utility::getpath('pwa_icon_256') ? Storage::url(Utility::getsettings('pwa_icon_256')) : ''); ?>"
                                                                id="pwa_256">
                                                        </a>
                                                    </div>
                                                    <div class="mt-3 text-center choose-files">
                                                        <label for="pwa_icon_256">
                                                            <div class="bg-primary company_logo_update"> <i
                                                                    class="px-1 ti ti-upload"></i><?php echo e(__('Choose file here')); ?>

                                                            </div>
                                                            <?php echo e(Form::file('pwa_icon_256', ['class' => 'form-control file', 'id' => 'pwa_icon_256', 'onchange' => "document.getElementById('pwa_256').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'pwa_icon_256'])); ?>

                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header d-flex">
                                                <h5 class="me-1"><?php echo e(__('PWA Icon')); ?></h5>
                                                <span>(512x512)</span>
                                            </div>
                                            <div class="pt-0 card-body">
                                                <div class="inner-content">
                                                    <div class="py-2 mt-4 text-center logo-content dark-logo-content">
                                                        <a href="<?php echo e(Utility::getpath('pwa_icon_512') ? Storage::url(Utility::getsettings('pwa_icon_512')) : ''); ?>"
                                                            target="_blank">
                                                            <img src="<?php echo e(Utility::getpath('pwa_icon_512') ? Storage::url(Utility::getsettings('pwa_icon_512')) : ''); ?>"
                                                                id="pwa_512">
                                                        </a>
                                                    </div>
                                                    <div class="mt-3 text-center choose-files">
                                                        <label for="pwa_icon_512">
                                                            <div class="bg-primary company_logo_update"> <i
                                                                    class="px-1 ti ti-upload"></i><?php echo e(__('Choose file here')); ?>

                                                            </div>
                                                            <?php echo e(Form::file('pwa_icon_512', ['class' => 'form-control file', 'id' => 'pwa_icon_512', 'onchange' => "document.getElementById('pwa_512').src = window.URL.createObjectURL(this.files[0])", 'data-filename' => 'pwa_icon_512'])); ?>

                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn-submit btn btn-primary" type="submit">
                                    <?php echo e(__('Save')); ?>

                                </button>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/bootstrap-switch-button.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script>
        var textRemove = new Choices(
            document.getElementById('choices-text-remove-button'), {
                delimiter: ',',
                editItems: true,
                removeItemButton: true,
            }
        );
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }
        var custthemebg = document.querySelector("#cust-theme-bg");
        custthemebg.addEventListener("click", function() {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });

        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];
            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }
        var custdarklayout = document.querySelector("#cust-darklayout");
        custdarklayout.addEventListener("click", function() {
            if (custdarklayout.checked) {
                document.querySelector(".m-header > .b-brand > img").setAttribute("src",
                    "<?php echo e(Storage::url(Utility::getsettings('app_logo'))); ?>");
                document.querySelector("#main-style-link").setAttribute("href",
                    "<?php echo e(asset('assets/css/style-dark.css')); ?>");
            } else {
                document.querySelector(".m-header > .b-brand > img").setAttribute("src",
                    "<?php echo e(Storage::url(Utility::getsettings('app_dark_logo'))); ?>");
                document.querySelector("#main-style-link").setAttribute("href",
                    "<?php echo e(asset('assets/css/style.css')); ?>");
            }
        });

        function check_theme(color_val) {
            $('.theme-color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }

        function enablecookie() {
            const element = $('#enable_cookie').is(':checked');
            $('.cookieDiv').addClass('d-none');
            if (element == true) {
                $('.cookieDiv').removeClass('d-none');
                $("#cookie_logging").attr('checked', true);
            } else {
                $('.cookieDiv').addClass('d-none');
                $("#cookie_logging").attr('checked', false);
            }
        }

        function enableseo() {
            const element = $('#seo_setting').is(':checked');
            $('.seoDiv').addClass('d-none');
            if (element == true) {
                $('.seoDiv').removeClass('d-none');
            } else {
                $('.seoDiv').addClass('d-none');
            }
        }

        $('body').on('click', '.send_mail', function() {
            var action = $(this).data('action');
            var modal = $('#common_modal');
            $.get(action, function(response) {
                modal.find('.modal-title').html('<?php echo e(__('Test Mail')); ?>');
                modal.find('.body').html(response);
                modal.modal('show');
            })
        });
        $(document).ready(function() {
            $(".socialsetting").trigger("select");
        });
        $(document).on('change', ".socialsetting", function() {
            var test = $(this).val();
            if ($(this).is(':checked')) {
                if (test == 'google') {
                    $("#google").fadeIn(500);
                    $("#google").removeClass('d-none');
                } else if (test == 'facebook') {
                    $("#facebook").fadeIn(500);
                    $("#facebook").removeClass('d-none');
                } else if (test == 'github') {
                    $("#github").fadeIn(500);
                    $("#github").removeClass('d-none');
                } else if (test == 'linkedin') {
                    $("#linkedin").fadeIn(500);
                    $("#linkedin").removeClass('d-none');
                }
            } else {
                if (test == 'google') {
                    $("#google").fadeOut(500);
                    $("#google").addClass('d-none');
                } else if (test == 'facebook') {
                    $("#facebook").fadeOut(500);
                    $("#facebook").addClass('d-none');
                } else if (test == 'github') {
                    $("#github").fadeOut(500);
                    $("#github").addClass('d-none');
                } else if (test == 'linkedin') {
                    $("#linkedin").fadeOut(500);
                    $("#linkedin").addClass('d-none');
                }
            }
        });
        $(document).ready(function() {
            if ($("input[name$='captcha']").is(':checked')) {
                $("#recaptcha").fadeIn(500);
                $("#recaptcha").removeClass('d-none');
            } else {
                $("#recaptcha").fadeOut(500);
                $("#recaptcha").addClass('d-none');
            }
            $(".paymenttsetting").trigger("select");
        });

        $(document).on('change', ".paymenttsetting", function() {
            var test = $(this).val();
            if ($(this).is(':checked')) {
                if (test == 'razorpay') {
                    $("#razorpay").fadeIn(500);
                    $("#razorpay").removeClass('d-none');
                } else if (test == 'stripe') {
                    $("#stripe").fadeIn(500);
                    $("#stripe").removeClass('d-none');
                } else if (test == 'paytm') {
                    $("#paytm").fadeIn(500);
                    $("#paytm").removeClass('d-none');
                } else if (test == 'paypal') {
                    $("#paypal").fadeIn(500);
                    $("#paypal").removeClass('d-none');
                } else if (test == 'flutterwave') {
                    $("#flutterwave").fadeIn(500);
                    $("#flutterwave").removeClass('d-none');
                } else if (test == 'paystack') {
                    $("#paystack").fadeIn(500);
                    $("#paystack").removeClass('d-none');
                } else if (test == 'mercado') {
                    $("#mercado").fadeIn(500);
                    $("#mercado").removeClass('d-none');
                } else if (test == 'offline') {
                    $("#offline").fadeIn(500);
                    $("#offline").removeClass('d-none');
                }
            } else {
                if (test == 'razorpay') {
                    $("#razorpay").fadeOut(500);
                    $("#razorpay").addClass('d-none');
                } else if (test == 'paytm') {
                    $("#paytm").fadeOut(500);
                    $("#paytm").removeClass('d-none');
                } else if (test == 'stripe') {
                    $("#stripe").fadeOut(500);
                    $("#stripe").addClass('d-none');
                } else if (test == 'flutterwave') {
                    $("#flutterwave").fadeIn(500);
                    $("#flutterwave").removeClass('d-none');
                } else if (test == 'paypal') {
                    $("#paypal").fadeOut(500);
                    $("#paypal").addClass('d-none');
                } else if (test == 'paystack') {
                    $("#paystack").fadeOut(500);
                    $("#paystack").addClass('d-none');
                } else if (test == 'mercado') {
                    $("#mercado").fadeIn(500);
                    $("#mercado").removeClass('d-none');
                } else if (test == 'offline') {
                    $("#offline").fadeOut(500);
                    $("#offline").addClass('d-none');
                }
            }
        });
        $(document).on('click', "input[name$='captcha']", function() {
            var test = $(this).val();
            if (test == 'hcaptcha') {
                $("#hcaptcha").fadeIn(500);
                $("#hcaptcha").removeClass('d-none');
                $("#recaptcha").addClass('d-none');
            } else {
                $("#recaptcha").fadeIn(500);
                $("#recaptcha").removeClass('d-none');
                $("#hcaptcha").addClass('d-none');
            }
        });
        $(document).on('click', "input[name$='storage_type']", function() {
            var test = $(this).val();
            if (test == 's3') {
                $("#s3").fadeIn(500);
                $("#s3").removeClass('d-none');
            } else {
                $("#s3").fadeOut(500);
            }
        });
        $(document).on('click', "input[name$='storage_type']", function() {
            var test = $(this).val();
            if (test == 'wasabi') {
                $("#wasabi").fadeIn(500);
                $("#wasabi").removeClass('d-none');
            } else {
                $("#wasabi").fadeOut(500);
            }
        });
        $(document).on('change', "#multi_sms", function() {
            if ($(this).is(':checked')) {
                $(".multi_sms").fadeIn(500);
                $('.multi_sms').removeClass('d-none');
                $('#twilio').removeClass('d-none');
            } else {
                $(".multi_sms").fadeOut(500);
                $(".multi_sms").addClass('d-none');
            }
        });


        $(document).on('click', "input[name$='smssetting']", function() {
            var test = $(this).val();
            $("#twilio").fadeOut(500);
            if (test == 'twilio') {
                $("#twilio").fadeIn(500);
                $("#twilio").removeClass('d-none');
                $("#nexmo").fadeOut(500);
            } else {
                $("#nexmo").fadeIn(500);
                $("#nexmo").removeClass('d-none');
                $("#twilio").fadeOut(500);
            }
        });

        $(document).on('change', "#captchaEnableButton", function() {
            if (this.checked) {
                $('.captchaSetting').fadeIn(500);
                $(".captchaSetting").removeClass('d-none');
            } else {
                $('.captchaSetting').fadeOut(500);
                $(".captchaSetting").addClass('d-none');
            }

        })
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        });
        $(document).on("change", ".chnageEmailNotifyStatus", function(e) {
            var csrf = $("meta[name=csrf-token]").attr("content");
            var email = $(this).parent().find("input[name=email_notification]").is(":checked");
            var action = $(this).attr("data-url");
            $.ajax({
                type: "POST",
                url: action,
                data: {
                    _token: csrf,
                    type: 'email',
                    email_notification: email,
                },
                success: function(response) {
                    if (response.warning) {
                        show_toastr("Warning!", response.warning, "warning");
                    }
                    if (response.is_success) {
                        show_toastr("Success!", response.message, "success");
                    }
                },
            });
        });

        $(document).on("change", ".chnagesmsNotifyStatus", function(e) {
            var csrf = $("meta[name=csrf-token]").attr("content");
            var sms = $(this).parent().find("input[name=sms_notification]").is(":checked");
            var action = $(this).attr("data-url");
            $.ajax({
                type: "POST",
                url: action,
                data: {
                    _token: csrf,
                    type: 'sms',
                    sms_notification: sms,
                },
                success: function(response) {
                    if (response.warning) {
                        show_toastr("Warning!", response.warning, "warning");
                    }
                    if (response.is_success) {
                        show_toastr("Success!", response.message, "success");
                    }
                },
            });
        });

        $(document).on("change", ".chnageNotifyStatus", function(e) {
            var csrf = $("meta[name=csrf-token]").attr("content");
            var notify = $(this).parent().find("input[name=notify]").is(":checked");
            var action = $(this).attr("data-url");
            $.ajax({
                type: "POST",
                url: action,
                data: {
                    _token: csrf,
                    type: 'notify',
                    notify: notify,
                },
                success: function(response) {
                    if (response.warning) {
                        show_toastr("Warning!", response.warning, "warning");
                    }
                    if (response.is_success) {
                        show_toastr("Success!", response.message, "success");
                    }
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/settings/index.blade.php ENDPATH**/ ?>