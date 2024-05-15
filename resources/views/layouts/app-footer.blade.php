      <!--footer start here-->
      <footer class="site-footer">
          <div class="container">
              <div class="footer-row">
                  <div class="footer-col footer-link">
                      <div class="footer-widget">
                          <div class="footer-logo">
                              <div class="footer-logo">
                                  <img src="{{ Storage::url(setting('app_logo')) ? Storage::url('app-logo/app-logo.png') : asset('assets/images/app-logo.png') }}"
                                      alt="footer-logo" class="footer-light-logo">
                                  <img src="{{ Utility::getsettings('app_dark_logo') ? Storage::url('app-logo/app-dark-logo.png') : asset('assets/images/app-dark-logo.png') }}"
                                      alt="footer-logo" class="footer-dark-logo">
                              </div>
                          </div>
                          <p>{{ Utility::getsettings('footer_description')
                              ? Utility::getsettings('footer_description')
                              : 'A feature is a unique quality or characteristic that something has. Real-life examples: Elaborately colored tail feathers are peacocks most well-known feature.' }}
                          </p>
                      </div>
                  </div>
                  @if (!empty($footerMainMenus))
                      @foreach ($footerMainMenus as $footerMainMenu)
                          <div class="footer-col">
                              <div class="footer-widget">
                                  <h3>{{ $footerMainMenu->menu }}</h3>
                                  @php
                                      $subMenus = App\Models\FooterSetting::where('parent_id', $footerMainMenu->id)->get();
                                  @endphp
                                  <ul>
                                      @foreach ($subMenus as $subMenu)
                                          @php
                                              $page = App\Models\PageSetting::find($subMenu->page_id);
                                          @endphp
                                          @if (isset($page))
                                              <li>
                                                  <a @if ($page->type == 'link') ?  href="{{ $page->page_url }}"  @else  href="{{ route('description.page', $subMenu->slug) }}" @endif
                                                      tabindex="0">{{ $page->title }}
                                                  </a>
                                              </li>
                                          @endif
                                      @endforeach
                                  </ul>
                              </div>
                          </div>
                      @endforeach

                  @endif
              </div>
              <div class="footer-bottom">
                  <div class="row align-items-center">
                      <div class="col-12">
                          <p>© {{ date('Y') }} {{ config('app.name') }}.</p>
                      </div>
                  </div>
              </div>
          </div>
      </footer>
      <!--footer end here-->

      <!--scripts start here-->
      <script src="{{ asset('vendor/landing-page2/js/jquery.min.js') }}"></script>
      <script src="{{ asset('vendor/landing-page2/js/slick.min.js') }}"></script>
      <script src="{{ asset('vendor/landing-page2/js/custom.js') }}"></script>
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
      @stack('script')

      @if (Utility::getsettings('cookie_setting_enable') == 'on')
          @include('layouts.cookie-consent')
      @endif
      </body>

      </html>
