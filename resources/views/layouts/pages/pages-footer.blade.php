      <!--footer start here-->
      <footer class="site-footer">
          <div class="container">
              <div class="footer-row">
                  <div class="footer-col footer-link">
                      <div class="footer-widget">
                          <div class="footer-logo">
                              <img src="{{ Storage::url(setting('app_logo')) ? Storage::url('app-logo/app-logo.png') : asset('assets/images/app-logo.png') }}"
                                  alt="footer-logo" class="footer-light-logo">
                              <img src="{{ Utility::getsettings('app_dark_logo') ? Storage::url('app-logo/app-dark-logo.png') : asset('assets/images/app-dark-logo.png') }}"
                                  alt="footer-logo" class="footer-dark-logo">
                          </div>
                          <p>{{ Utility::getsettings('footer_description')
                              ? Utility::getsettings('footer_description')
                              : 'A feature is a unique quality or characteristic that something has. Real-life examples: Elaborately colored tail feathers are peacocks most well-known feature.' }}
                          </p>
                      </div>
                  </div>
                  @if (!empty($footerMainMenus))
                      @foreach ($footerMainMenus as $footerMainMenus)
                          <div class="footer-col">
                              <div class="footer-widget">
                                  <h3>{{ $footerMainMenus->menu }}</h3>
                                  @php
                                      $subMenus = App\Models\FooterSetting::where('parent_id', $footerMainMenus->id)->get();
                                  @endphp
                                  <ul>
                                      @foreach ($subMenus as $subMenu)
                                          @php
                                              $page = App\Models\PageSetting::find($subMenu->page_id);
                                          @endphp
                                          <li>
                                              <a @if ($page->type == 'link') ?  href="{{ $page->page_url }}"  @else  href="{{ route('description.page', $subMenu->slug) }}" @endif
                                                  tabindex="0">{{ $page->title }}
                                              </a>
                                          </li>
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
