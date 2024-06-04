<?php $__env->startSection('title'); ?>
    <?php echo e(__('Home')); ?>

<?php $__env->stopSection(); ?>
<?php
    $users = \Auth::user();
    $languages = Utility::languages();
    $profile = asset(Storage::url('avatar/'));
?>
<?php $__env->startSection('auth-topbar'); ?>
    <li class="language-btn">
        <select class="btn btn-primary me-2 nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option class="" <?php if($lang == $language): ?> selected <?php endif; ?>
                    value="<?php echo e(route('change.lang', $language)); ?>"><?php echo e(Str::upper($language)); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </li>
<?php $__env->stopSection(); ?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(Utility::getsettings('app_name')); ?></title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="title"
        content="<?php echo e(!empty(Utility::getsettings('meta_title'))
            ? Utility::getsettings('meta_title')
            : Utility::getsettings('app_name')); ?>">
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

    <link rel="stylesheet" href="<?php echo e(asset('vendor/landing-page2/css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/landing-page2/css/landingpage-2.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/landing-page2/css/landingpage2-responsive.css')); ?>">
</head>

<body class="light">
    <?php echo $__env->make('layouts.front-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--header end here-->
    
    <?php if(Utility::getsettings('apps_setting_enable') == 'on'): ?>
        <section class="home-banner-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="banner-image">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/banner1.png')); ?>" alt="home-banner-image"
                                width="100% " height="100%">
                        </div>
                    </div>
                </div>
            </div>
            <img src="<?php echo e(asset('vendor/landing-page2/image/slider-image.png')); ?>" alt="background-image"
                class="home-bg-image">
            <img src="<?php echo e(asset('vendor/landing-page2/image/bacground-image.png')); ?>" alt="background-image"
                class="bg-fir-img">
            <img src="<?php echo e(asset('vendor/landing-page2/image/bacground-image-2.png')); ?>" alt="bacground-image"
                class="bg-sec-img">
            <img src="<?php echo e(asset('vendor/landing-page2/image/slider-sec-image.png')); ?>" alt="bacground-image"
                class="bg-the-img">
        </section>

        <section class="admin-saas-sec pt pb">
            <div class="container">
                <div class="section-title text-center">
                    <h2><?php echo e(Utility::getsettings('apps_name') ? Utility::getsettings('apps_name') : __('Prime Laravel')); ?><b><?php echo e(Utility::getsettings('apps_bold_name') ? Utility::getsettings('apps_bold_name') : __('Form Builder')); ?></b>
                    </h2>
                </div>
                <div class="section-content">
                    <p><?php echo e(Utility::getsettings('app_detail') ? Utility::getsettings('app_detail') : __('Prime Laravel Form Builder is software for creating automated systems, you can create your own forms without writing a line of code. you have only to use the Drag & Drop to build your form and start using it.')); ?>

                    </p>
                </div>
            </div>
        </section>

        <?php if(isset($appsMultipleImageSettings)): ?>
            <section class="client-logo-section ">
                <img src="<?php echo e(asset('vendor/landing-page2/image/client-logo-bg1.png')); ?>" alt="client-bg"
                    class="client-bg" loading="lazy">
                <img src="<?php echo e(asset('vendor/landing-page2/image/client-logo-bg2.png')); ?>" alt="client-bg"
                    class="client-bg2" loading="lazy">
                <div class="container">
                    <div class="client-logo-wrap">
                        <div class="client-logo-slider slick-slider">
                            <?php $__currentLoopData = $appsMultipleImageSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appsMultipleImageSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="client-logo-iteam">
                                    <a href="javascript:void(0);">
                                        <img src="<?php echo e(Storage::url($appsMultipleImageSetting->apps_multiple_image)); ?>"
                                            alt="client-logo" width="100% " height="100%">
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(Utility::getsettings('feature_setting_enable') == 'on'): ?>
        <section class="features-sec pt pb">
            <div class="container">
                <div class="section-title text-center">
                    <h2><?php echo e(Utility::getsettings('feature_name') ? Utility::getsettings('feature_name') : 'Stunning with'); ?>

                        <b><?php echo e(Utility::getsettings('feature_bold_name') ? Utility::getsettings('feature_bold_name') : 'lots of features'); ?></b>
                    </h2>
                </div>
                <div class="feature-sec-content text-center">
                    <p><?php echo e(Utility::getsettings('feature_detail')
                        ? Utility::getsettings('feature_detail')
                        : "Optimize your manufacturing business with Prime laravel, offering a seamless user interface for
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        streamlined operations, one convenient platform."); ?>

                    </p>
                </div>
                <?php if(isset($features)): ?>
                    <div class="features-card-slide">
                        <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="features-card">
                                <div class="features-card-inner">
                                    <div class="features-card-image">
                                        <a href="javascript:void(0);">
                                            <img src="<?php echo e(Storage::url($feature->feature_image)); ?>"
                                                alt="home-banner-image" width="60" height="60">
                                        </a>
                                    </div>
                                    <div class="features-card-content">
                                        <div class="features-top-content">
                                            <h3>
                                                <a href="javascript:void(0);"><?php echo e(isset($feature) ? $feature->feature_name : 'Warehouse Powerful'); ?><br><b>
                                                        <?php echo e(isset($feature) ? $feature->feature_bold_name : 'Reporting Tools'); ?></b></a>
                                            </h3>
                                        </div>
                                        <div class="features-bottom-content">
                                            <p><?php echo e(isset($feature) ? $feature->feature_detail : 'The capability to clean, transform, and manipulate data to make it suitable for reporting and analysis.'); ?>

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
                <img src="<?php echo e(asset('vendor/landing-page2/image/features-bg-image')); ?>.png" alt="background-image"
                    class="features-bg">
            </div>
        </section>
    <?php endif; ?>

    <?php if(Utility::getsettings('menu_setting_section1_enable') == 'on'): ?>
        <section class="apex-chart-sec">
            <img src="<?php echo e(asset('vendor/landing-page2/image/features-bg-2.png')); ?>" alt="background-image"
                class="features-sec-bg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-12">
                        <div class="chart-left-side">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/blue.png')); ?>" alt=""
                                class="blue-bg left-blue">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/purple.png')); ?>" alt=""
                                class="purple-bg left-purple">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/yellow-squre.png')); ?>" alt=""
                                class="yellow-bg left-yellow">
                            <img src="<?php echo e(Utility::getsettings('menu_image_section1')
                                ? Storage::url(Utility::getsettings('menu_image_section1'))
                                : asset('vendor/landing-page2/image/apex-chart-img.png')); ?>"
                                alt="chart-image" width="100% " height="100%">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="chart-right-side">
                            <h2>
                                <?php if(Utility::getsettings('menu_name_section1')): ?>
                                    <?php echo e(Utility::getsettings('menu_name_section1')); ?>

                                <?php else: ?>
                                    <?php echo e(__('All in one place')); ?> <b> <?php echo e(__('CRM system')); ?> </b>
                                    <?php echo e(__('with')); ?>

                                <?php endif; ?>
                                <b> <?php echo e(Utility::getsettings('menu_bold_name_section1')); ?> </b>
                            </h2>
                            <p>
                                <?php echo e(Utility::getsettings('menu_detail_section1')
                                    ? Utility::getsettings('menu_detail_section1')
                                    : __(
                                        'ApexCharts is a modern charting library that helps developers to create beautiful and  interactive visualizations for web pages with a simple API, while React-ApexCharts is ApexChart’s React integration that allows us to use ApexCharts in our applications.',
                                    )); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if(Utility::getsettings('menu_setting_section2_enable') == 'on'): ?>
        <section class="support-system-sec pt pb">
            <div class="container">
                <div class="row align-items-center ">
                    <div class="col-md-6 col-12">
                        <div class="chart-left-side">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/blue.png')); ?>" alt=""
                                class="blue-small-round blue-bg">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/purple.png')); ?>" alt=""
                                class="purple-bg left-purple">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/yellow-squre.png')); ?>" alt=""
                                class="yellow-bg section2-yellow">
                            <img src="<?php echo e(Utility::getsettings('menu_image_section2')
                                ? Storage::url(Utility::getsettings('menu_image_section2'))
                                : asset('vendor/landing-page2/image/apex-chart-img.png')); ?>"
                                alt="chart-image" width="100% " height="100%">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="chart-right-side">
                            <h2>
                                <?php if(Utility::getsettings('menu_name_section2')): ?>
                                    <?php echo e(Utility::getsettings('menu_name_section2')); ?>

                                <?php else: ?>
                                    <?php echo e(__('All in one place CRM system with')); ?> <b> <?php echo e(__('Support System')); ?>

                                    </b>
                                <?php endif; ?>
                                <b> <?php echo e(Utility::getsettings('menu_bold_name_section2')); ?> </b>
                            </h2>
                            <p>
                                <?php echo e(Utility::getsettings('menu_detail_section2')
                                    ? Utility::getsettings('menu_detail_section2')
                                    : __('A decision support system (DSS) is a computer program application used to improve a companys decision-making capabilities. It analyzes large amounts of data and presents an
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           organization with the best possible options available.')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if(Utility::getsettings('menu_setting_section3_enable') == 'on'): ?>
        <section class="apex-chart-sec">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-12">
                        <div class="chart-left-side">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/blue.png')); ?>" alt=""
                                class="blue-bg section3-blue">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/purple.png')); ?>" alt=""
                                class="purple-bg section3-purple">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/yellow-squre.png')); ?>" alt=""
                                class="yellow-bg section3-yellow">
                            <img src="<?php echo e(Utility::getsettings('menu_image_section3')
                                ? Storage::url(Utility::getsettings('menu_image_section3'))
                                : asset('vendor/landing-page2/image/apex-chart-img.png')); ?>"
                                alt="chart-image" width="100% " height="100%">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="chart-right-side">
                            <h2>
                                <?php if(Utility::getsettings('menu_name_section3')): ?>
                                    <?php echo e(Utility::getsettings('menu_name_section3')); ?>

                                <?php else: ?>
                                    <?php echo e(__('Empowering with Streamlined')); ?> <b> <?php echo e(__('Manufacturers')); ?> </b>
                                <?php endif; ?>
                                <b> <?php echo e(Utility::getsettings('menu_bold_name_section3')); ?> </b>
                            </h2>
                            <p>
                                <?php echo e(Utility::getsettings('menu_detail_section3')
                                    ? Utility::getsettings('menu_detail_section3')
                                    : __('Prime laravel SAAS software is a game-changing solution designed exclusively for manufacturers, revolutionizing their operations and driving digital transformation. With
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  its advanced features and cutting-edge technology,')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if(Utility::getsettings('business_growth_setting_enable') == 'on'): ?>
        <section class="video-play-sec pt pb">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="video-wrapper-div">
                            <div class="video-image">
                                <?php if(!empty(Utility::getsettings('business_growth_video'))): ?>
                                    <video id="videoPlayer" controls width="100%" height="100%"
                                        poster="<?php echo e(Storage::url(Utility::getsettings('business_growth_front_image'))); ?>"
                                        data-setup="{}">
                                        <source
                                            src="<?php echo e(Storage::url(Utility::getsettings('business_growth_video'))); ?>"
                                            type='video/mp4' />
                                        <source
                                            src="<?php echo e(Storage::url(Utility::getsettings('business_growth_video'))); ?>"
                                            type="video/ogg">
                                    </video>
                                <?php else: ?>
                                    <img src="<?php echo e(asset('assets/images/landing-page2/image/video-image.png')); ?>"
                                        alt="video" width="100%" height="100%">
                                <?php endif; ?>
                            </div>
                            <a href="javascript:void(0);" class="play-btn" id="playButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="123" height="123"
                                    viewBox="0 0 123 123" fill="none">
                                    <path
                                        d="M90.3519 110.096C81.8393 115.252 71.8538 118.221 61.1745 118.221C30.0286 118.221 4.7793 92.9717 4.7793 61.8255C4.7793 30.6791 30.0286 5.43027 61.1745 5.43027C92.3207 5.43027 117.57 30.6791 117.57 61.8255C117.57 73.4073 113.999 84.1735 108.011 93.1296"
                                        stroke="#645BE1" stroke-width="9.55851" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M53.5816 80.2225L77.4064 66.4197C80.9328 64.3768 80.9328 59.2738 77.4064 57.2309L53.5816 43.4282C50.0528 41.3841 45.6406 43.9369 45.6406 48.0225V75.6282C45.6406 79.7139 50.0528 82.2668 53.5816 80.2225Z"
                                        stroke="#645BE1" stroke-width="9.55851" stroke-miterlimit="10"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <img src="<?php echo e(asset('vendor/landing-page2/image/video-bg.png')); ?>" alt="background-image"
                class="video-bg">
            <img src="<?php echo e(asset('vendor/landing-page2/image/video-bg-2.png')); ?>" alt="background-image"
                class="video-bg-sec">
        </section>

        <section class="counter-sec pb">
            <div class="container">
                <div class="section-title">
                    <h2> <?php echo e(Utility::getsettings('business_growth_name')
                        ? Utility::getsettings('business_growth_name')
                        : __('Makes Quick')); ?>

                        <b>
                            <?php echo e(Utility::getsettings('business_growth_bold_name')
                                ? Utility::getsettings('business_growth_bold_name')
                                : __('Business Growth')); ?>

                        </b>
                    </h2>
                    <p>
                        <?php echo e(Utility::getsettings('business_growth_detail')
                            ? Utility::getsettings('business_growth_detail')
                            : __(
                                'Offer unique products, services, or solutions that stand out in the market. Innovation and differentiation can attract customers and give you a competitive edge.',
                            )); ?>

                    </p>
                </div>
                <div class="main-counter-div">
                    <div class="row">
                        <?php if(isset($businessGrowthsViewSettings)): ?>
                            <?php $__currentLoopData = $businessGrowthsViewSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessGrowthsViewSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-sm-4 col-12 ">
                                    <div class="counter-iteam counter text-center">
                                        <h3>
                                            <span class="count" data-target="2">
                                                <?php echo e($businessGrowthsViewSetting->business_growth_view_amount); ?>

                                            </span>
                                        </h3>

                                        <span class="counter-content">
                                            <?php echo e($businessGrowthsViewSetting->business_growth_view_name); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="col-sm-4 col-12">
                                <div class="counter-iteam counter text-center">
                                    <h3>
                                        <span class="count" data-target="2"> <?php echo e(__('0')); ?> </span>
                                        <?php echo e(__('M+')); ?>

                                    </h3>
                                    <span class="counter-content"> <?php echo e(__('Total Downloads')); ?> </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12 ">
                                <div class="counter-iteam counter text-center">
                                    <h3>
                                        <span class="count" data-target="43"> <?php echo e(__('0')); ?> </span>
                                        <?php echo e(__('k+')); ?>

                                    </h3>
                                    <span class="counter-content"> <?php echo e(__('Positive Reviews')); ?> </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12 ">
                                <div class="counter-iteam counter text-center">
                                    <h3>
                                        <span class="count" data-target="13"> <?php echo e(__('0')); ?> </span>
                                        <?php echo e(__('k+')); ?>

                                    </h3>
                                    <span class="counter-content"> <?php echo e(__('Happy Users')); ?> </span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="advance-feature">
                <div class="advance-feature-slider">
                    <?php if(isset($businessGrowthsSettings)): ?>
                        <?php $__currentLoopData = $businessGrowthsSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessGrowthsSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div>
                                <div class="advance-feature-card">
                                    <div class="advance-card-inner d-flex align-items-center">
                                        <div class="advance-card-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                viewBox="0 0 25 25" fill="none">
                                                <path
                                                    d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"
                                                    fill="#645BE1" />
                                            </svg>
                                        </div>
                                        <div class="advance-card-content">
                                            <p> <?php echo e($businessGrowthsSetting->business_growth_title); ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="testimonials-sec">
        <div class="container">
            <div class="testimonial-slider">
                <?php if(isset($testimonials)): ?>
                    <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="testimonial-card">
                            <div class="testimonial-card-inner">
                                <div class="testimonial-card-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="37"
                                        viewBox="0 0 42 37" fill="none">
                                        <path
                                            d="M2.10973 -2.722e-06L14.9411 -4.78488e-07C16.1061 -2.74801e-07 17.0515 0.945469 17.0515 2.11042L17.0515 14.9418C17.0515 16.1068 16.1061 17.0522 14.9411 17.0522L8.79977 17.0522C8.87997 20.412 9.66082 23.1007 11.1381 25.1225C12.3031 26.7179 14.0673 28.0391 16.4268 29.0816C17.5116 29.5586 17.9801 30.8417 17.4736 31.9139L15.9541 35.1217C15.4645 36.1515 14.2531 36.6032 13.2063 36.1515C10.4121 34.9444 8.05264 33.4164 6.12797 31.5593C3.78114 29.2927 2.17304 26.7348 1.30355 23.8815C0.434012 21.0282 -0.000693456 17.1366 -0.000692593 12.1982L-0.000690829 2.11042C-0.000690626 0.945508 0.944822 -2.92568e-06 2.10973 -2.722e-06Z"
                                            fill="black" />
                                        <path
                                            d="M36.6786 36.1431C33.9182 34.9402 31.5714 33.4123 29.634 31.5593C27.2661 29.2927 25.6496 26.7433 24.7801 23.9111C23.9106 21.0789 23.4759 17.1746 23.4759 12.1982L23.4759 2.11042C23.4759 0.945466 24.4213 -2.92569e-06 25.5863 -2.722e-06L38.4177 -4.78488e-07C39.5826 -2.74801e-07 40.5281 0.945469 40.5281 2.11042L40.5281 14.9418C40.5281 16.1068 39.5826 17.0522 38.4177 17.0522L32.2763 17.0522C32.3565 20.4121 33.1374 23.1007 34.6147 25.1225C35.7796 26.7179 37.5439 28.0391 39.9034 29.0816C40.9882 29.5586 41.4567 30.8417 40.9502 31.9139L39.4349 35.1133C38.9452 36.1431 37.7254 36.599 36.6786 36.1431Z"
                                            fill="black" />
                                    </svg>
                                    <p><?php echo e($testimonial->desc); ?></p>
                                    <div class="client-info">
                                        <div class="client-img">
                                            <img src="<?php echo e(Storage::url($testimonial->image)); ?>" alt="client-image"
                                                width="100%" height="100%">
                                        </div>
                                        <div class="client-name">
                                            <a href="javascript:void(0);"><?php echo e($testimonial->name); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            <img src="<?php echo e(asset('vendor/landing-page2/image/test-bg.png')); ?>" alt="testimonial-bg"
                class="testimonial-bg">
            <img src="<?php echo e(asset('vendor/landing-page2/image/test-bg-2')); ?>.png" alt="testimonial-bg"
                class="testimonial-bg-2">
            <img src="<?php echo e(asset('vendor/landing-page2/image/test-bg-3')); ?>.png" alt="testimonial-bg"
                class="testimonial-bg-3">
        </div>
    </section>

    <?php if(Utility::getsettings('form_setting_enable') == 'on'): ?>
        <section class="home-article-sec pt pb">
            <div class="container">
                <div class="section-title">
                    <h2><?php echo e(Utility::getsettings('form_name') ? Utility::getsettings('form_name') : 'What’s New?'); ?>

                    </h2>
                    <p><?php echo e(Utility::getsettings('form_details') ? Utility::getsettings('form_details') : 'Optimize your Form builder with Prime laravel, offering a seamless user interface for streamlined operations, one convenient platform.'); ?>

                    </p>
                </div>
                <div class="article-slider">
                    <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $user = App\Models\User::find($form->created_by);
                            $hashids = new Hashids('', 20);
                            $id = $hashids->encodeHex($form->id);
                        ?>
                        <div class="article-card">
                            <div class="article-card-inner">
                                <div class="article-card-image">
                                    <a href="<?php echo e(route('forms.survey', $id)); ?>">
                                        <img src="<?php echo e(isset($form->logo) ? Storage::url($form->logo) : __('vendor/landing-page2/image/blog-card-img.png')); ?>"
                                            alt="blog-card-image" style="object-fit: scale-down;">
                                    </a>
                                </div>
                                <div class="article-card-content">
                                    <div class="author-info d-flex align-items-center justify-content-between">
                                        <div class="author-name d-flex align-items-center">
                                            <div class="author-img">
                                                <?php if(Auth::check()): ?>
                                                    <img src="<?php echo e(Storage::exists(Auth::user()->avatar) ? Storage::url(Auth::user()->avatar) : Auth::user()->avatar_image); ?>"
                                                        alt="client-image">
                                                <?php else: ?>
                                                    <img src="<?php echo e(asset('vendor/avatar/avatar.png')); ?>"
                                                        alt="client-image">
                                                <?php endif; ?>
                                            </div>
                                            <?php if(\Auth::user()): ?>
                                                <span><?php echo e($user->name); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="date d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                viewBox="0 0 23 23" fill="none">
                                                <path
                                                    d="M18.0527 1.86077H16.6306V1.00753C16.6306 0.536546 16.2484 0.154297 15.7774 0.154297C15.3064 0.154297 14.9242 0.536546 14.9242 1.00753V1.86077H7.52946V1.00753C7.52946 0.536546 7.14721 0.154297 6.67623 0.154297C6.20524 0.154297 5.82299 0.536546 5.82299 1.00753V1.86077H4.40094C1.65011 1.86077 0.134766 3.37611 0.134766 6.12694V18.0722C0.134766 20.823 1.65011 22.3384 4.40094 22.3384H18.0527C20.8035 22.3384 22.3189 20.823 22.3189 18.0722V6.12694C22.3189 3.37611 20.8035 1.86077 18.0527 1.86077ZM4.40094 3.56723H5.82299V4.42047C5.82299 4.89145 6.20524 5.2737 6.67623 5.2737C7.14721 5.2737 7.52946 4.89145 7.52946 4.42047V3.56723H14.9242V4.42047C14.9242 4.89145 15.3064 5.2737 15.7774 5.2737C16.2484 5.2737 16.6306 4.89145 16.6306 4.42047V3.56723H18.0527C19.8468 3.56723 20.6124 4.33287 20.6124 6.12694V6.98017H1.84123V6.12694C1.84123 4.33287 2.60687 3.56723 4.40094 3.56723ZM18.0527 20.6319H4.40094C2.60687 20.6319 1.84123 19.8663 1.84123 18.0722V8.68664H20.6124V18.0722C20.6124 19.8663 19.8468 20.6319 18.0527 20.6319Z"
                                                    fill="black" />
                                            </svg>
                                            <span><?php echo e(App\Facades\UtilityFacades::date_time_format($form->created_at)); ?></span>
                                        </div>
                                    </div>
                                    <h3>
                                        <a href="<?php echo e(route('forms.survey', $id)); ?>"><?php echo e($form->title); ?></a>
                                    </h3>
                                    <p><?php echo e(isset($form->description) ? $form->description : __('Use these awesome forms to login or create public form in your project for free Frequently.')); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <img src="<?php echo e(asset('vendor/landing-page2/image/features-bg-image.png')); ?>" alt="bacground-image"
                    class="article-bg">
            </div>
        </section>
    <?php endif; ?>

    <?php if(Utility::getsettings('announcements_setting_enable') == 'on'): ?>
        <section class="home-article-sec pt pb" id="announcementLists">
            <div class="container">
                <div class="section-title">
                    <h2> <?php echo e(Utility::getsettings('announcements_title') ? Utility::getsettings('announcements_title') : 'Public Announcements'); ?>

                    </h2>
                    <p> <?php echo e(Utility::getsettings('announcement_short_description')
                        ? Utility::getsettings('announcement_short_description')
                        : 'Public Announcement of Voluntary Liquidation Process'); ?>

                    </p>
                </div>
                <div class="article-slider">
                    <?php $__currentLoopData = $announcementLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcementList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="article-card">
                            <div class="article-card-inner">
                                <div class="article-card-image">
                                    <a href="<?php echo e(route('show.public.announcement', $announcementList->slug)); ?>">
                                        <img src="<?php echo e(isset($announcementList->image) ? Storage::url($announcementList->image) : asset('vendor/landing-page2/image/blog-card-img.png')); ?>"
                                            alt="blog-card-image">
                                    </a>
                                </div>
                                <div class="article-card-content">
                                    <div class="author-info d-flex align-items-center justify-content-between">
                                        <div class="date d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                viewBox="0 0 23 23" fill="none">
                                                <path
                                                    d="M18.0527 1.86077H16.6306V1.00753C16.6306 0.536546 16.2484 0.154297 15.7774 0.154297C15.3064 0.154297 14.9242 0.536546 14.9242 1.00753V1.86077H7.52946V1.00753C7.52946 0.536546 7.14721 0.154297 6.67623 0.154297C6.20524 0.154297 5.82299 0.536546 5.82299 1.00753V1.86077H4.40094C1.65011 1.86077 0.134766 3.37611 0.134766 6.12694V18.0722C0.134766 20.823 1.65011 22.3384 4.40094 22.3384H18.0527C20.8035 22.3384 22.3189 20.823 22.3189 18.0722V6.12694C22.3189 3.37611 20.8035 1.86077 18.0527 1.86077ZM4.40094 3.56723H5.82299V4.42047C5.82299 4.89145 6.20524 5.2737 6.67623 5.2737C7.14721 5.2737 7.52946 4.89145 7.52946 4.42047V3.56723H14.9242V4.42047C14.9242 4.89145 15.3064 5.2737 15.7774 5.2737C16.2484 5.2737 16.6306 4.89145 16.6306 4.42047V3.56723H18.0527C19.8468 3.56723 20.6124 4.33287 20.6124 6.12694V6.98017H1.84123V6.12694C1.84123 4.33287 2.60687 3.56723 4.40094 3.56723ZM18.0527 20.6319H4.40094C2.60687 20.6319 1.84123 19.8663 1.84123 18.0722V8.68664H20.6124V18.0722C20.6124 19.8663 19.8468 20.6319 18.0527 20.6319Z"
                                                    fill="black" />
                                            </svg>
                                            <span><?php echo e(App\Facades\UtilityFacades::date_time_format($announcementList->created_at)); ?></span>
                                        </div>
                                    </div>
                                    <h3>
                                        <a
                                            href="<?php echo e(route('show.public.announcement', $announcementList->slug)); ?>"><?php echo e(isset($announcementList->title) ? $announcementList->title : __('Benefits of Multi-Tenancy in Laravel Dashboard')); ?></a>
                                    </h3>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <img src="<?php echo e(asset('vendor/landing-page2/image/features-bg-image.png')); ?>" alt="bacground-image"
                    class="article-bg">
            </div>
        </section>
    <?php endif; ?>

    <?php if(Utility::getsettings('faq_setting_enable') == 'on'): ?>
        <section class="home-faqs-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="faqs-left-div">
                            <h2>
                                <?php echo e(Utility::getsettings('faq_name') ? Utility::getsettings('faq_name') : 'Frequently asked questions'); ?>

                            </h2>
                            <a href="<?php echo e(route('faqs.pages')); ?>" class="btn"><?php echo e(__('View All FAQs')); ?>

                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="11"
                                    viewBox="0 0 17 11" fill="none">
                                    <path
                                        d="M15.8434 6.63069L12.4502 10.6141C12.2632 10.8337 12.0181 10.9434 11.773 10.9434C11.5279 10.9434 11.2828 10.8337 11.0958 10.6141C10.7218 10.175 10.7218 9.46319 11.0958 9.02412L12.8541 6.96L1.75847 6.96C1.22956 6.96 0.800781 6.45664 0.800781 5.83572C0.800781 5.21479 1.22956 4.71143 1.75847 4.71143L12.8541 4.71143L11.0958 2.64731C10.7218 2.20825 10.7218 1.4964 11.0958 1.05733C11.4698 0.61826 12.0762 0.61826 12.4502 1.05733L15.8434 5.04074C16.2174 5.47977 16.2174 6.19166 15.8434 6.63069Z"
                                        fill="white" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="faqs-right-div">
                            <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="set has-children">
                                    <a href="javascript:;" class="nav-label">
                                        <span><?php echo e($faq->questions); ?></span>
                                    </a>
                                    <div class="nav-list">
                                        <p><?php echo $faq->answer; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e(asset('vendor/landing-page2/image/test-bg.png')); ?>" alt="bacground-image"
                                class="faqs-bg">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if(Utility::getsettings('blog_setting_enable') == 'on'): ?>
        <section class="home-article-sec pt pb">
            <div class="container">
                <div class="section-title">
                    <h2> <?php echo e(Utility::getsettings('blog_name') ? Utility::getsettings('blog_name') : 'What’s New?'); ?>

                    </h2>
                    <p> <?php echo e(Utility::getsettings('blog_detail')
                        ? Utility::getsettings('blog_detail')
                        : 'Optimize your manufacturing business with Prime laravel, offering a seamless user interface for
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    streamlined operations, one convenient platform.'); ?>

                    </p>
                </div>
                <div class="article-slider">
                    <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="article-card">
                            <div class="article-card-inner">
                                <div class="article-card-image">
                                    <a href="<?php echo e(route('view.blog', $blog->slug)); ?>">
                                        <img src="<?php echo e(isset($blog->images) ? Storage::url($blog->images) : asset('vendor/landing-page2/image/blog-card-img.png')); ?>"
                                            alt="blog-card-image">
                                    </a>
                                </div>
                                <div class="article-card-content">
                                    <div class="author-info d-flex align-items-center justify-content-between">
                                        <div class="date d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                viewBox="0 0 23 23" fill="none">
                                                <path
                                                    d="M18.0527 1.86077H16.6306V1.00753C16.6306 0.536546 16.2484 0.154297 15.7774 0.154297C15.3064 0.154297 14.9242 0.536546 14.9242 1.00753V1.86077H7.52946V1.00753C7.52946 0.536546 7.14721 0.154297 6.67623 0.154297C6.20524 0.154297 5.82299 0.536546 5.82299 1.00753V1.86077H4.40094C1.65011 1.86077 0.134766 3.37611 0.134766 6.12694V18.0722C0.134766 20.823 1.65011 22.3384 4.40094 22.3384H18.0527C20.8035 22.3384 22.3189 20.823 22.3189 18.0722V6.12694C22.3189 3.37611 20.8035 1.86077 18.0527 1.86077ZM4.40094 3.56723H5.82299V4.42047C5.82299 4.89145 6.20524 5.2737 6.67623 5.2737C7.14721 5.2737 7.52946 4.89145 7.52946 4.42047V3.56723H14.9242V4.42047C14.9242 4.89145 15.3064 5.2737 15.7774 5.2737C16.2484 5.2737 16.6306 4.89145 16.6306 4.42047V3.56723H18.0527C19.8468 3.56723 20.6124 4.33287 20.6124 6.12694V6.98017H1.84123V6.12694C1.84123 4.33287 2.60687 3.56723 4.40094 3.56723ZM18.0527 20.6319H4.40094C2.60687 20.6319 1.84123 19.8663 1.84123 18.0722V8.68664H20.6124V18.0722C20.6124 19.8663 19.8468 20.6319 18.0527 20.6319Z"
                                                    fill="black" />
                                            </svg>
                                            <span><?php echo e(App\Facades\UtilityFacades::date_time_format($blog->created_at)); ?></span>
                                        </div>
                                    </div>
                                    <h3>
                                        <a
                                            href="<?php echo e(route('view.blog', $blog->slug)); ?>"><?php echo e(isset($blog->title) ? $blog->title : __('Benefits of Multi-Tenancy in Laravel Dashboard')); ?></a>
                                    </h3>
                                    <p><?php echo e(isset($blog->short_description)
                                        ? html_entity_decode($blog->short_description)
                                        : __(
                                            'Exploring the advantages of implementing multi-tenancy, such as cost savings,scalability, easier maintenance, and improved security.',
                                        )); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <img src="<?php echo e(asset('vendor/landing-page2/image/features-bg-image.png')); ?>" alt="bacground-image"
                    class="article-bg">
            </div>
        </section>
    <?php endif; ?>

    <?php if(Utility::getsettings('start_view_setting_enable') == 'on'): ?>
        <section class="contact-banner-sec pt pb">
            <div class="container">
                <div class="row contact-banner-row align-items-center">
                    <div class="col-md-6">
                        <div class="contact-banner-leftside">
                            <h2>
                                <?php echo e(Utility::getsettings('start_view_name')
                                    ? Utility::getsettings('start_view_name')
                                    : __('Start Using Prime Laravel Admin')); ?>

                            </h2>
                            <p>
                                <?php echo e(Utility::getsettings('start_view_detail')
                                    ? Utility::getsettings('start_view_detail')
                                    : __('Instead of forcing you to change how you write your code, the package by default
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                bootstraps tenancy automatically, in the background.')); ?>

                            </p>
                            <div class="contact-btn-wrapper d-flex align-items-center">
                                <a href="<?php echo e(route('login')); ?>" class="white-btn"> <?php echo e(__('Get Started')); ?>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="11"
                                        viewBox="0 0 17 11" fill="none">
                                        <path
                                            d="M15.728 6.42841L12.219 10.5478C12.0256 10.7749 11.7722 10.8884 11.5187 10.8884C11.2652 10.8884 11.0118 10.7749 10.8184 10.5478C10.4316 10.0938 10.4316 9.35761 10.8184 8.90355L12.6367 6.76896L1.16226 6.76896C0.615291 6.76896 0.171875 6.24841 0.171875 5.60629C0.171875 4.96417 0.615291 4.44362 1.16226 4.44362L12.6367 4.44362L10.8184 2.30903C10.4316 1.85497 10.4316 1.11882 10.8184 0.664763C11.2052 0.210704 11.8322 0.210704 12.219 0.664763L15.728 4.78417C16.1148 5.2382 16.1148 5.97438 15.728 6.42841Z"
                                            fill="#645BE1" />
                                    </svg>
                                </a>
                                <a href="<?php echo e(route('contactus')); ?>" class=" btn contact-btn">
                                    <?php echo e(Utility::getsettings('start_view_link_name')
                                        ? Utility::getsettings('start_view_link_name')
                                        : __('Contact us')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="demo-bannerimg">
                            <img src="<?php echo e(asset('vendor/landing-page2/image/bg-round.png')); ?>" alt=""
                                class="demo-bg-img">
                            <img src="<?php echo e(Utility::getsettings('start_view_image') ? Storage::url(Utility::getsettings('start_view_image')) : asset('vendor/landing-page2/image/contact-us-banner.png')); ?>"
                                alt="home-banner-image" width="100%" height="100%">
                        </div>
                    </div>
                </div>
                <img src="<?php echo e(asset('vendor/landing-page2/image/test-bg.png')); ?>" alt="bacground-image"
                    class="contact-bg">
            </div>
        </section>
    <?php endif; ?>

    
    <!--footer start here-->
    <?php echo $__env->make('layouts.front-footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(Utility::getsettings('cookie_setting_enable') == 'on'): ?>
        <?php echo $__env->make('layouts.cookie-consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <!--footer end here-->
    <!--footer end here-->

    <!--scripts start here-->
    <script src="<?php echo e(asset('vendor/landing-page2/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/landing-page2/js/slick.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/landing-page2/js/custom.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bouncer.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/form-validation.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap-notify.min.js')); ?>"></script>
    <!--scripts end here-->
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

        const playButton = document.getElementById('playButton');
        const videoPlayer = document.getElementById('videoPlayer');
        playButton.addEventListener('click', () => {
            videoPlayer.style.display = 'block';
            videoPlayer.play();
            playButton.style.display = 'none';
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
                    data.icons[0].src =
                        '<?php echo e(Utility::getpath('pwa_icon_128') ? Storage::url(Utility::getsettings('pwa_icon_128')) : ''); ?>';
                }
                if (data.icons[1].sizes === '144x144') {
                    data.icons[1].src =
                        '<?php echo e(Utility::getpath('pwa_icon_144') ? Storage::url(Utility::getsettings('pwa_icon_144')) : ''); ?>';
                }
                if (data.icons[2].sizes === '152x152') {
                    data.icons[2].src =
                        '<?php echo e(Utility::getpath('pwa_icon_152') ? Storage::url(Utility::getsettings('pwa_icon_152')) : ''); ?>';
                }
                if (data.icons[3].sizes === '192x192') {
                    data.icons[3].src =
                        '<?php echo e(Utility::getpath('pwa_icon_192') ? Storage::url(Utility::getsettings('pwa_icon_192')) : ''); ?>';
                }
                if (data.icons[4].sizes === '256x256') {
                    data.icons[4].src =
                        '<?php echo e(Utility::getpath('pwa_icon_256') ? Storage::url(Utility::getsettings('pwa_icon_256')) : ''); ?>';
                }
                if (data.icons[5].sizes === '512x512') {
                    data.icons[5].src =
                        '<?php echo e(Utility::getpath('pwa_icon_512') ? Storage::url(Utility::getsettings('pwa_icon_512')) : ''); ?>';
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
    <script>
        var headerHright = $('header').outerHeight();
        $('header').next('.home-banner-sec').css('padding-top', headerHright + 'px');
    </script>
</body>

</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/welcome.blade.php ENDPATH**/ ?>