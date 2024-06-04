<header class="site-header header-style-one">
    <?php if(isset($announcementBars) && $announcementBars->count() > 0): ?>
        <div class="announcebar">
            <?php $__currentLoopData = $announcementBars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcementBar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($announcementBar->cont < 1): ?>
                    <p class="text-center text-capitalize">
                        <b><?php echo e(__('Announcement :')); ?></b>
                        <a href="<?php echo e(route('show.public.announcement', ['slug' => $announcementBar->slug])); ?>"
                            class="announcement-title">
                            <?php echo e($announcementBar->title); ?>

                        </a>
                    </p>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
    <div class="main-navigationbar">
        <div class="container">
            <div class="navigation-row d-flex align-items-center ">
                <nav class="menu-items-col d-flex align-items-center justify-content-between ">
                    <div class="logo-col">
                        <h1>
                            <a href="<?php echo e(route('landingpage')); ?>" tabindex="0">
                                <img src="<?php echo e(Storage::url(setting('app_dark_logo')) ? Storage::url('app-logo/app-dark-logo.png') : asset('assets/images/app-dark-logo.png')); ?>"
                                    class="" />
                            </a>
                        </h1>
                    </div>
                    <div class="menu-item-right-col d-flex align-items-center justify-content-between">
                        <div class="menu-left-col">
                            <ul class="main-nav d-flex align-items-center">
                                <li><a href="<?php echo e(route('landingpage')); ?>" tabindex="0"><?php echo e(__('Home')); ?></a></li>
                                <?php
                                    $headerMainMenus = App\Models\HeaderSetting::get();
                                ?>
                                <?php if(!empty($headerMainMenus)): ?>
                                    <?php $__currentLoopData = $headerMainMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $headerMainMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="menu-has-items">
                                            <?php
                                                $page = App\Models\PageSetting::find($headerMainMenu->page_id);
                                            ?>
                                            <a <?php if($page->type == 'link'): ?> ?  href="<?php echo e($page->page_url); ?>"  <?php else: ?>  href="<?php echo e(route('description.page', $headerMainMenu->slug)); ?>" <?php endif; ?>
                                                tabindex="0">
                                                <?php echo e($page->title); ?>

                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="menu-right-col">
                            <ul class=" d-flex align-items-center">
                                <li class="switch-toggle" onclick="myFunction()">
                                    <a class="switch-sun d-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                            viewBox="0 0 26 26" fill="none">
                                            <path
                                                d="M13 18C15.7614 18 18 15.7614 18 13C18 10.2386 15.7614 8 13 8C10.2386 8 8 10.2386 8 13C8 15.7614 10.2386 18 13 18Z"
                                                stroke="black" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M13 3V1" stroke="black" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M13 25V23" stroke="black" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M3 13H1" stroke="black" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M25 13H23" stroke="black" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M5.92977 20.07L4.50977 21.49" stroke="black" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M21.4903 4.51001L20.0703 5.93001" stroke="black" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M20.0703 20.07L21.4903 21.49" stroke="black" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M4.50977 4.51001L5.92977 5.93001" stroke="black" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    <a class="switch-moon">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="512" viewBox="0 0 512 512"
                                            width="512">
                                            <title />
                                            <path
                                                d="M152.62,126.77c0-33,4.85-66.35,17.23-94.77C87.54,67.83,32,151.89,32,247.38,32,375.85,136.15,480,264.62,480c95.49,0,179.55-55.54,215.38-137.85-28.42,12.38-61.8,17.23-94.77,17.23C256.76,359.38,152.62,255.24,152.62,126.77Z" />
                                        </svg>
                                    </a>
                                </li>

                                <?php echo $__env->yieldContent('auth-topbar'); ?>

                                <li class="login-btn">
                                    <?php if(\Auth::user()): ?>
                                        <a href="<?php echo e(route('home')); ?>"> <?php echo e(__('Dashboard')); ?></a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('login')); ?>"> <?php echo e(__('Login')); ?></a>
                                    <?php endif; ?>
                                </li>
                                <li class="mobile-menu">
                                    <button class="mobile-menu-button" id="menu">
                                        <div class="one"></div>
                                        <div class="two"></div>
                                        <div class="three"></div>
                                    </button>
                                </li>
                            </ul>
                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Mobile menu start here -->
    <div class="container">
        <div class="mobile-menu-wrapper">
            <div class="mobile-menu-bar">
                <ul>
                    <li><a href="<?php echo e(route('landingpage')); ?>" tabindex="0"><?php echo e(__('Home')); ?></a></li>
                    <?php
                        $headerMainMenus = App\Models\HeaderSetting::get();
                    ?>
                    <?php if(!empty($headerMainMenus)): ?>
                        <?php $__currentLoopData = $headerMainMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $headerMainMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="menu-has-items">
                                <?php
                                    $page = App\Models\PageSetting::find($headerMainMenu->page_id);
                                ?>
                                <a <?php if($page->type == 'link'): ?> ?  href="<?php echo e($page->page_url); ?>"  <?php else: ?>  href="<?php echo e(route('description.page', $headerMainMenu->slug)); ?>" <?php endif; ?>
                                    tabindex="0">
                                    <?php echo e($page->title); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <li>
                        <div class="mobile-login-btn">
                            <a href="<?php echo e(route('login')); ?>"> <?php echo e(__('Login')); ?></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Mobile menu end here -->
</header>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/layouts/front-header.blade.php ENDPATH**/ ?>