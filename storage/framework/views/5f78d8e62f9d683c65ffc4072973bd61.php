      <!--footer start here-->
      <footer class="site-footer">
          <div class="container">
              <div class="footer-row">
                  <div class="footer-col footer-link">
                      <div class="footer-widget">
                          <div class="footer-logo">
                              <div class="footer-logo">
                                  <img src="<?php echo e(Storage::url(setting('app_logo')) ? Storage::url('app-logo/app-logo.png') : asset('assets/images/app-logo.png')); ?>"
                                      alt="footer-logo" class="footer-light-logo">
                                  <img src="<?php echo e(Utility::getsettings('app_dark_logo') ? Storage::url('app-logo/app-dark-logo.png') : asset('assets/images/app-dark-logo.png')); ?>"
                                      alt="footer-logo" class="footer-dark-logo">
                              </div>
                          </div>
                          <p><?php echo e(Utility::getsettings('footer_description')
                              ? Utility::getsettings('footer_description')
                              : 'A feature is a unique quality or characteristic that something has. Real-life examples: Elaborately colored tail feathers are peacocks most well-known feature.'); ?>

                          </p>
                      </div>
                  </div>
                  <?php if(!empty($footerMainMenus)): ?>
                      <?php $__currentLoopData = $footerMainMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $footerMainMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <div class="footer-col">
                              <div class="footer-widget">
                                  <h3><?php echo e($footerMainMenu->menu); ?></h3>
                                  <?php
                                      $subMenus = App\Models\FooterSetting::where('parent_id', $footerMainMenu->id)->get();
                                  ?>
                                  <ul>
                                      <?php $__currentLoopData = $subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php
                                              $page = App\Models\PageSetting::find($subMenu->page_id);
                                          ?>
                                          <?php if(isset($page)): ?>
                                              <li>
                                                  <a <?php if($page->type == 'link'): ?> ?  href="<?php echo e($page->page_url); ?>"  <?php else: ?>  href="<?php echo e(route('description.page', $subMenu->slug)); ?>" <?php endif; ?>
                                                      tabindex="0"><?php echo e($page->title); ?>

                                                  </a>
                                              </li>
                                          <?php endif; ?>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  </ul>
                              </div>
                          </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  <?php endif; ?>
              </div>
              <div class="footer-bottom">
                  <div class="row align-items-center">
                      <div class="col-12">
                          <p>© <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>.</p>
                      </div>
                  </div>
              </div>
          </div>
      </footer>
      <!--footer end here-->

      <!--scripts start here-->
      <script src="<?php echo e(asset('vendor/landing-page2/js/jquery.min.js')); ?>"></script>
      <script src="<?php echo e(asset('vendor/landing-page2/js/slick.min.js')); ?>"></script>
      <script src="<?php echo e(asset('vendor/landing-page2/js/custom.js')); ?>"></script>
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
      </script>
      <?php echo $__env->yieldPushContent('script'); ?>

      <?php if(Utility::getsettings('cookie_setting_enable') == 'on'): ?>
          <?php echo $__env->make('layouts.cookie-consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      </body>

      </html>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/layouts/app-footer.blade.php ENDPATH**/ ?>