<?php
    use App\Models\Form;
    use App\Models\Booking;
    $user = \Auth::user();
    $currantLang = $user->currentLanguage();
    $languages = Utility::languages();
    $role_id = $user->roles->first()->id;
    $user_id = $user->id;
    if (Auth::user()->type == 'Admin') {
        $forms = Form::orderBy('created_at', 'asc')->get();
        $bookings = Booking::all();
    } else {
        if (\Auth::user()->can('access-all-submitted-form')) {
            $forms = Form::where('created_by', Auth::user()->id)->orWhere('created_by', Auth::user()->created_by)->orderBy('created_at', 'asc')->get();
            $bookings = Booking::all();
        } else {
            $forms = Form::select(['forms.*'])
            ->where(function ($query) use ($role_id, $user_id) {
                $query
                    ->whereIn('forms.id', function ($query1) use ($role_id) {
                        $query1
                            ->select('form_id')
                            ->from('assign_forms_roles')
                            ->where('role_id', $role_id);
                    })
                    ->OrWhereIn('forms.id', function ($query1) use ($user_id) {
                        $query1
                            ->select('form_id')
                            ->from('assign_forms_users')
                            ->where('user_id', $user_id);
                    })
                    ->OrWhere('assign_type', 'public');
            })->orderBy('created_at', 'asc')->get();

        $bookings = Booking::all();
        }
    }
    $bookings = $bookings->all();
?>
<nav class="dash-sidebar light-sidebar <?php echo e($user->transprent_layout == 1 ? 'transprent-bg' : ''); ?>">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="<?php echo e(route('home')); ?>" class="text-center b-brand">
                <!-- ========   change your logo hear   ============ -->
                <?php if($user->dark_layout == 1): ?>
                    <img src="<?php echo e(Utility::getsettings('app_logo') ? url('vendor/app-logo/app-dark-logo.png') : url('vendor/app-logo/78x78.png')); ?>"
                        class="app-logo" />
                        <!-- <img src="<?php echo e(asset('vendor/app-logo/app-dark-logo.png')); ?>"
                                    class="app-logo" /> -->
                <?php else: ?> 
                <img src="<?php echo e(Utility::getsettings('app_logo') ? url('vendor/app-logo/app-dark-logo.png') : url('vendor/app-logo/78x78.png')); ?>"
                        class="app-logo" />
                <?php endif; ?>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar d-block">
                <li class="dash-item dash-hasmenu <?php echo e(request()->is('/') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('home')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight"><?php echo e(__('Dashboard')); ?></span></a>
                </li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-dashboardwidget')): ?>
                    <li class="dash-item dash-hasmenu <?php echo e(request()->is('index-dashboard*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('index.dashboard')); ?>" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-square"></i></span>
                            <span class="dash-mtext custom-weight"><?php echo e(__('Dashboard Widgets')); ?></span></a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-user', 'manage-role'])): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(request()->is('users*') || request()->is('roles*') ? 'active dash-trigger' : 'collapsed'); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-layout-2"></i></span><span
                                class="dash-mtext"><?php echo e(__('User Management')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-user')): ?>
                                <li class="dash-item <?php echo e(request()->is('users*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('users.index')); ?>"><?php echo e(__('Users')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-role')): ?>
                                <li class="dash-item <?php echo e(request()->is('roles*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('roles.index')); ?>"><?php echo e(__('Roles')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-form', 'manage-form-template', 'manage-submitted-form','manage-form-category'  , 'manage-form-status'])): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(request()->is('forms*', 'design*') || request()->is('form-values*') || request()->is('form-category*') || request()->is('form-template*') || request()->is('form-template/design*')  || request()->is('form-status*') ? 'active dash-trigger' : 'collapsed'); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-table"></i></span><span
                                class="dash-mtext"><?php echo e(__('Form')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-form-category'])): ?>
                                <li class="dash-item <?php echo e(request()->is('form-category*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('form-category.index')); ?>"><?php echo e(__('Category')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-form-status'])): ?>
                                <li class="dash-item <?php echo e(request()->is('form-status*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('form-status.index')); ?>"><?php echo e(__('Statuses')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-form-template'])): ?>
                                <li
                                    class="dash-item <?php echo e(request()->is('form-template*') || request()->is('form-template/design*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('form-template.index')); ?>"><?php echo e(__('Template')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-form'])): ?>
                                <li class="dash-item <?php echo e(request()->is('forms*', 'design*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('forms.index')); ?>"><?php echo e(__('Forms')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-submitted-form'])): ?>
                                <li class="dash-item">
                                    <a href="#!" class="dash-link"><span
                                            class="dash-mtext custom-weight"><?php echo e(__('Submitted Forms')); ?></span><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul
                                        class="dash-submenu <?php echo e(Request::route()->getName() == 'view.form.values' ? 'd-block' : ''); ?>">
                                        <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $formValueIds = App\Models\FormValue::where('form_id', $form->id)
                                                    ->pluck('id')
                                                    ->toArray();
                                                    $formValueParam = Request::route()->parameters('form_value');
                                                    $formValueId = isset($formValueParam['form_value'])
                                                    ? $formValueParam['form_value']
                                                    : null;
                                            ?>
                                            <li class="dash-item <?php echo e(in_array($formValueId, $formValueIds) ? 'active' : ''); ?>">
                                                <a class="dash-link <?php echo e(Request::route()->getName() == 'view.form.values'  || in_array($formValueId, $formValueIds) ? 'show' : ''); ?>"
                                                    href="<?php echo e(route('view.form.values', $form->id)); ?>"><?php echo e($form->title); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-booking', 'manage-submitted-booking', 'manage-booking-calendar'])): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(request()->is('bookings*') || request()->is('booking-values*') ? 'active dash-trigger' : 'collapsed'); ?>">
                        <a class="dash-link"><span class="dash-micon"><i class="ti ti-box-model-2"></i></span><span
                                class="dash-mtext"><?php echo e(__('Booking')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-booking')): ?>
                                <li class="dash-item <?php echo e(request()->is('bookings*', 'bookings/design*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('bookings.index')); ?>"><?php echo e(__('Booking')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-booking-calendar')): ?>
                                <li class="dash-item selection:<?php echo e(request()->is('calendar/booking*') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('booking.calendar')); ?>" class="dash-link">
                                        <?php echo e(__('Booking Calendar')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-submitted-booking')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"><span
                                            class="dash-mtext custom-weight"><?php echo e(__('Submitted Booking')); ?></span><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul
                                        class="dash-submenu <?php echo e(Request::route()->getName() == 'view.booking.values' ? 'd-block' : ''); ?>">
                                        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="dash-item <?php echo e(request()->is('form-values*') ? 'active' : ''); ?>">
                                                <a class="dash-link <?php echo e(Request::route()->getName() == 'view.booking.values' ? 'show' : ''); ?>"
                                                    href="<?php echo e(route('view.booking.values', $book->id)); ?>"><?php echo e($book->business_name); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?> -->
                <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-poll'])): ?>
                    <li class="dash-item dash-hasmenu <?php echo e(request()->is('poll*') ? 'active' : ''); ?>">
                        <a class="dash-link" href="<?php echo e(route('poll.index')); ?>"><span class="dash-micon">
                                <i class="ti ti-accessible"></i></span>
                            <span class="dash-mtext"><?php echo e(__('Polls')); ?></span>
                        </a>
                    </li>
                <?php endif; ?> -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(['manage-document'])): ?>
                    <li class="dash-item dash-hasmenu <?php echo e(request()->is('document*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('document.index')); ?>" class="dash-link">
                            <span class="dash-micon">
                                <i class="ti ti-file-text"></i>
                            </span>
                            <span class="dash-mtext"><?php echo e(__('Documents')); ?>

                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-blog', 'manage-category'])): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(request()->is('blogs*') || request()->is('blog-category*') ? 'active dash-trigger' : 'collapsed'); ?>">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon">
                                <i class="ti ti-forms"></i>
                            </span>
                            <span class="dash-mtext"><?php echo e('Blog'); ?></span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i>
                            </span>
                        </a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-blog')): ?>
                                <li class="dash-item <?php echo e(request()->is('blogs*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('blogs.index')); ?>"><?php echo e(__('Blogs')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-category')): ?>
                                <li class="dash-item <?php echo e(request()->is('blog-category*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('blog-category.index')); ?>"><?php echo e(__('Categories')); ?></a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?> -->

                <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-event'])): ?>
                    <li class="dash-item dash-hasmenu <?php echo e(request()->is('event*') ? 'active' : ''); ?>">
                        <a class="dash-link" href="<?php echo e(route('event.index')); ?>"><span class="dash-micon">
                                <i class="ti ti-calendar"></i></span>
                            <span class="dash-mtext"><?php echo e(__('Event Calender')); ?></span>
                        </a>
                    </li>
                <?php endif; ?> -->
                <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-announcement')): ?>
                    <?php if(Auth::user()->type == 'Admin'): ?>
                        <li class="dash-item dash-hasmenu <?php echo e(request()->is('announcement*') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('announcement.index')); ?>" class="dash-link">
                                <span class="dash-micon">
                                    <i class="ti ti-confetti">
                                    </i>
                                </span>
                                <span class="dash-mtext"><?php echo e(__('Announcement')); ?>

                                </span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li
                            class="dash-item <?php echo e(request()->is('show-announcement-list*') || request()->is('show-announcement*') ? 'active' : ''); ?>">
                            <a class="dash-link d-flex align-items-center" href="<?php echo e(route('show.announcement.list')); ?>">
                                <span class="dash-micon">
                                    <i class="ti ti-confetti">
                                    </i>
                                </span>
                                <span><?php echo e(__('Show Announcement List')); ?></span></a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?> -->
                <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-chat'])): ?>
                    <?php if(setting('pusher_status') == '1'): ?>
                        <li
                            class="dash-item dash-hasmenu <?php echo e(request()->is('chat*') ? 'active dash-trigger' : 'collapsed'); ?>">
                            <a href="#!" class="dash-link"><span class="dash-micon"><i
                                        class="ti ti-table"></i></span><span
                                    class="dash-mtext"><?php echo e(__('Support')); ?></span><span class="dash-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-chat')): ?>
                                    <li class="dash-item">
                                        <a class="dash-link" href="<?php echo e(route('chats')); ?>"><?php echo e(__('Chats')); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?> -->
                <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-mailtemplate', 'manage-sms-template', 'manage-language', 'manage-setting'])): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(request()->is('mailtemplate*') || request()->is('sms-template*') || request()->is('manage-language*') || request()->is('create-language*') || request()->is('settings*') ? 'active dash-trigger' : 'collapsed'); ?> || <?php echo e(request()->is('create-language*') || request()->is('settings*') ? 'active' : ''); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-apps"></i></span><span
                                class="dash-mtext"><?php echo e(__('Account Setting')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-mailtemplate')): ?>
                                <li class="dash-item <?php echo e(request()->is('mailtemplate*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('mailtemplate.index')); ?>"><?php echo e(__('Email Templates')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-sms-template')): ?>
                                <li class="dash-item <?php echo e(request()->is('sms-template*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('sms-template.index')); ?>"><?php echo e(__('Sms Templates')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-language')): ?>
                                <li
                                    class="dash-item <?php echo e(request()->is('manage-language*') || request()->is('create-language*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('manage.language', [$currantLang])); ?>"><?php echo e(__('Manage Languages')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-setting')): ?>
                                <li class="dash-item <?php echo e(request()->is('settings*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('settings')); ?>"><?php echo e(__('Settings')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-landing-page', 'manage-faqs', 'manage-testimonial', 'manage-page-setting'])): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(request()->is('landingpage-setting*') || request()->is('faqs*') || request()->is('page-setting*') || request()->is('testimonials*') ? 'active dash-trigger' : 'collapsed'); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-table"></i></span><span
                                class="dash-mtext"><?php echo e(__('Frontend Setting')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-landing-page')): ?>
                                <li class="dash-item <?php echo e(request()->is('landingpage-setting*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('landing-page.setting')); ?>"><?php echo e(__('Landing Page')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-testimonial')): ?>
                                <li class="dash-item <?php echo e(request()->is('testimonials*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('testimonial.index')); ?>"><?php echo e(__('Testimonials')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-faqs')): ?>
                                <li class="dash-item <?php echo e(request()->is('faqs*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('faqs.index')); ?>"><?php echo e(__('FAQs')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-page-setting')): ?>
                                <li class="dash-item <?php echo e(request()->is('page-setting*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('page-setting.index')); ?>"><?php echo e(__('Page Settings')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(Auth::user()->type == 'Admin'): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(request()->is('telescope*') ? 'active dash-trigger' : 'collapsed'); ?>">
                        <a class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-device-desktop-analytics"></i></span><span
                                class="dash-mtext"><?php echo e(__('System Analytics')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item <?php echo e(request()->is('telescope*') ? 'active' : ''); ?>">
                                <a class="dash-link"
                                    href="<?php echo e(route('telescope')); ?>"><?php echo e(__('Telescope Dashboard')); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?> -->
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/main_file/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>