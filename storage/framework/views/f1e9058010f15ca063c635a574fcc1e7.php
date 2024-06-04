<?php
    $languages = \App\Facades\UtilityFacades::languages();
    config([
        'captcha.sitekey' => Utility::getsettings('recaptcha_key'),
        'captcha.secret' => Utility::getsettings('recaptcha_secret'),
    ]);
?>

<?php $__env->startSection('title', __('Sign in')); ?>
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
<?php $__env->startSection('content'); ?>
    <div class="login-page-wrapper">
        <div class="login-container">
            <div class="login-row d-flex">
                <div class="login-col-6">
                    <div class="login-content-inner ">
                        <div class="login-title">
                            <h3><?php echo e(__('Sign In')); ?></h3>
                        </div>
                        <?php echo e(Form::open(['route' => ['login'], 'method' => 'POST', 'data-validate', 'class' => 'needs-validation'])); ?>

                        <div class="mb-3 form-group">
                            <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label mb-2'])); ?>

                            <?php echo Form::email('email', old('email'), [
                                'class' => 'form-control',
                                'id' => 'email',
                                'placeholder' => __('Enter email address'),
                                'onfocus',
                                'required',
                            ]); ?>

                        </div>
                        <div class="mb-3 form-group">
                            <div class="col-md-12">
                                <?php echo e(Form::label('password', __('Enter Password'), ['class' => 'form-label'])); ?>

                                <?php echo Html::link(route('password.request'), __('Forgot Password ?'), ['class' => 'float-end forget-password']); ?>

                                <?php echo Form::password('password', [
                                    'class' => 'form-control',
                                    'placeholder' => __('Enter password'),
                                    'required',
                                    'tabindex' => '2',
                                    'id' => 'password',
                                    'autocomplete' => 'current-password',
                                ]); ?>

                            </div>
                        </div>
                        <?php if(Utility::getsettings('login_recaptcha_status') == '1'): ?>
                            <div class="my-3 text-center">
                                <?php echo NoCaptcha::renderJs(); ?>

                                <?php echo NoCaptcha::display(); ?>

                            </div>
                        <?php endif; ?>
                        <div class="d-grid">
                            <?php echo Form::button(__('Sign In'), ['type' => 'submit', 'class' => 'btn btn-primary login-do-btn btn-block mt-3']); ?>

                        </div>
                        <?php echo e(Form::close()); ?>

                        <div class="register-option">
                            <?php if(Utility::getsettings('register') == 1): ?>
                                <div class="create_user text-center ">
                                    <?php echo e(__('Do not have an account?')); ?>

                                    <a href="<?php echo e(route('register')); ?>"><?php echo e(__('Create One')); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="social-media-icon">
                            <?php if(Utility::getsettings('GOOGLESETTING') == 'on' ||
                                    Utility::getsettings('FACEBOOKSETTING') == 'on' ||
                                    Utility::getsettings('GITHUBSETTING') == 'on'): ?>
                                <div class="mt-1 mb-4 row">
                                    <?php if(Utility::getsettings('GOOGLESETTING') == 'on' ||
                                            Utility::getsettings('FACEBOOKSETTING') == 'on' ||
                                            Utility::getsettings('GITHUBSETTING') == 'on'): ?>
                                        <p class="my-3 text-center register-link"><?php echo e(__('or register with')); ?></p>
                                    <?php endif; ?>
                                    <div class="register-btn-wrapper">
                                        <?php if(Utility::getsettings('GOOGLESETTING') == 'on'): ?>
                                            <div class="col-4">
                                                <div class="d-grid"><a href="<?php echo e(url('/redirect/google')); ?>"
                                                        class="btn btn-light">
                                                        <?php echo form::image(asset('assets/images/auth/img-google.svg'), null, ['class' => 'img-fluid wid-25']); ?>

                                                    </a></div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if(Utility::getsettings('FACEBOOKSETTING') == 'on'): ?>
                                            <div class="col-4">
                                                <div class="d-grid"><a href="<?php echo e(url('/redirect/facebook')); ?>"
                                                        class="btn btn-light">
                                                        <?php echo form::image(asset('assets/images/auth/img-facebook.svg'), null, ['class' => 'img-fluid wid-25']); ?>

                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if(Utility::getsettings('GITHUBSETTING') == 'on'): ?>
                                            <div class="col-4">
                                                <div class="d-grid"><a href="<?php echo e(url('/redirect/github')); ?>"
                                                        class="btn btn-light">
                                                        <?php echo form::image(asset('assets/images/auth/github.svg'), null, ['class' => 'img-fluid wid-25']); ?>

                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="login-media-col">
                    <div class="login-media-inner">
                        <img src="<?php echo e(Utility::getsettings('login_image')
                            ? Storage::url(Utility::getsettings('login_image'))
                            : asset('assets/images/auth/img-auth-3.svg')); ?>"
                            class="img-fluid" />
                        <h3>
                            <?php echo e(Utility::getsettings('login_title') ? Utility::getsettings('login_title') : 'Attention is the new currency'); ?>

                        </h3>
                        <p>
                            <?php echo e(Utility::getsettings('login_subtitle') ? Utility::getsettings('login_subtitle') : 'The more effortless the writing looks, the more effort the writer actually put into the process.'); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/main_file/resources/views/auth/login.blade.php ENDPATH**/ ?>