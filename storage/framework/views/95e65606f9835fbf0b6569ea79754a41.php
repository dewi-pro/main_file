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
                                          <li>
                                              <a <?php if($page->type == 'link'): ?> ?  href="<?php echo e($page->page_url); ?>"  <?php else: ?>  href="<?php echo e(route('description.page', $subMenu->slug)); ?>" <?php endif; ?>
                                                  tabindex="0"><?php echo e($page->title); ?>

                                              </a>
                                          </li>
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

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/main_file/resources/views/layouts/front-footer.blade.php ENDPATH**/ ?>