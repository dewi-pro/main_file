<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\UtilityFacades;
use Illuminate\Support\Facades\Storage;
use App\Models\FooterSetting;
use App\Models\HeaderSetting;
use App\Models\PageSetting;
use App\Models\settings;

class LandingPageController extends Controller
{
    private function updateSettings($input)
    {
        foreach ($input as $key => $value) {
            settings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }

    public function landingPageSetting(Request $request)
    {
        if (\Auth::user()->can('manage-landing-page')) {
            return view('landing-page.app-setting');
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    public function appSettingStore(Request $request)
    {
        if ($request->apps_setting_enable == 'on') {
            request()->validate([
                'apps_name' => 'required|max:50',
                'apps_bold_name' => 'required|max:50',
                'app_detail' => 'required',
                'apps_image' => 'image|mimes:png,jpg,jpeg',
            ]);

            if ($request->apps_multiple_image != '') {
                $data = [];
                if ($request->hasFile('apps_multiple_image')) {
                    $images = $request->file('apps_multiple_image');
                    foreach ($images as $image) {
                        $imageName = time() . '_' . $image->getClientOriginalName();
                        $image->storeAs('landing-page/app/', $imageName);
                        $data[] = ['apps_multiple_image' => 'landing-page/app/' . $imageName];
                    }
                }
                $data = json_encode($data);
                settings::updateOrCreate(
                    ['key' => 'apps_multiple_image_setting'],
                    ['value' => $data]
                );
            }
            $data = [
                'apps_setting_enable' => $request->apps_setting_enable == 'on' ? 'on' : 'off',
                'apps_name' => $request->apps_name,
                'apps_bold_name' => $request->apps_bold_name,
                'app_detail' => $request->app_detail,
            ];
            if ($request->apps_image) {
                $imageName = 'app.' . $request->apps_image->extension();
                $request->apps_image->storeAs('landing-page/app/', $imageName);
                $data['apps_image'] = 'landing-page/app/' . $imageName;
            }
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('App setting updated successfully.'));
        } else {
            $data = [
                'apps_setting_enable' => 'off',
            ];
            $arrEnv = [
                'apps_setting_enable' => 'off',
            ];

            $this->updateSettings($data);
            return redirect()->back()->with('success', __('App setting disabled.'));
        }
    }

    public function menuSetting(Request $request)
    {
        return view('landing-page.menu.index');
    }
    public function MenuSettingSection1Store(Request $request)
    {
        if ($request->menu_setting_section1_enable == 'on') {
            request()->validate([
                'menu_name_section1' => 'required|max:100',
                'menu_bold_name_section1' => 'required|max:100',
                'menu_detail_section1' => 'required',
                'menu_image_section1' => 'image|mimes:png,jpg,jpeg',
            ]);

            $data = [
                'menu_setting_section1_enable' => $request->menu_setting_section1_enable == 'on' ? 'on' : 'off',
                'menu_name_section1' => $request->menu_name_section1,
                'menu_bold_name_section1' => $request->menu_bold_name_section1,
                'menu_detail_section1' => $request->menu_detail_section1,
            ];
            if ($request->menu_image_section1) {
                $imageName = 'menusection1.' . $request->menu_image_section1->extension();
                $request->menu_image_section1->storeAs('landing-page/menu/', $imageName);
                $data['menu_image_section1'] = 'landing-page/menu/' . $imageName;
            }
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Menu setting updated successfully.'));
        } else {
            $data = [
                'menu_setting_section1_enable' => 'off',
            ];
            $arrEnv = [
                'menu_setting_section1_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('App setting disabled.'));
        }
    }

    public function MenuSettingSection2Store(Request $request)
    {
        if ($request->menu_setting_section2_enable == 'on') {
            request()->validate([
                'menu_name_section2' => 'required|max:100',
                'menu_bold_name_section2' => 'required|max:100',
                'menu_detail_section2' => 'required',
                'menu_image_section2' => 'image|mimes:png,jpg,jpeg',
            ]);

            $data = [
                'menu_setting_section2_enable' => $request->menu_setting_section2_enable == 'on' ? 'on' : 'off',
                'menu_name_section2' => $request->menu_name_section2,
                'menu_bold_name_section2' => $request->menu_bold_name_section2,
                'menu_detail_section2' => $request->menu_detail_section2,
            ];
            if ($request->menu_image_section2) {
                $imageName = 'menusection12.' . $request->menu_image_section2->extension();
                $request->menu_image_section2->storeAs('landing-page/menu/', $imageName);
                $data['menu_image_section2'] = 'landing-page/menu/' . $imageName;
            }
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Menu setting updated successfully.'));
        } else {
            $data = [
                'menu_setting_section2_enable' => 'off',
            ];
            $arrEnv = [
                'menu_setting_section2_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('App setting disabled.'));
        }
    }

    public function MenuSettingSection3Store(Request $request)
    {
        if ($request->menu_setting_section3_enable == 'on') {
            request()->validate([
                'menu_name_section3' => 'required|max:100',
                'menu_bold_name_section3' => 'required|max:100',
                'menu_detail_section3' => 'required',
                'menu_image_section3' => 'image|mimes:png,jpg,jpeg',
            ]);
            $data = [
                'menu_setting_section3_enable' => $request->menu_setting_section3_enable == 'on' ? 'on' : 'off',
                'menu_name_section3' => $request->menu_name_section3,
                'menu_bold_name_section3' => $request->menu_bold_name_section3,
                'menu_detail_section3' => $request->menu_detail_section3,
            ];
            if ($request->menu_image_section3) {
                $imageName = 'menusection13.' . $request->menu_image_section3->extension();
                $request->menu_image_section3->storeAs('landing-page/menu/', $imageName);
                $data['menu_image_section3'] = 'landing-page/menu/' . $imageName;
            }
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Menu setting updated successfully.'));
        } else {
            $data = [
                'menu_setting_section3_enable' => 'off',
            ];
            $arrEnv = [
                'menu_setting_section3_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('App setting disabled.'));
        }
    }

    public function faqSetting(Request $request)
    {
        return view('landing-page.faq-setting');
    }

    public function faqSettingStore(Request $request)
    {
        if ($request->faq_setting_enable == 'on') {
            request()->validate([
                'faq_name' => 'required|max:100',
            ]);

            $data = [
                'faq_setting_enable' => $request->faq_setting_enable == 'on' ? 'on' : 'off',
                'faq_name' => $request->faq_name,
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Faq setting updated successfully.'));
        } else {
            $data = [
                'faq_setting_enable' => 'off',
            ];
            $arrEnv = [
                'faq_setting_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Faq setting disabled.'));
        }
    }

    public function FeatureSetting(Request $request)
    {
        $settingData = [
            "feature_setting" => UtilityFacades::getsettings('feature_setting'),
        ];
        $settings = $settingData;
        $featureSettings = json_decode($settings['feature_setting'], true) ?? [];
        return view('landing-page.feature.index', compact('featureSettings'));
    }

    public function featureSettingStore(Request $request)
    {
        if ($request->feature_setting_enable == 'on') {
            request()->validate([
                'feature_name' => 'required|max:50',
                'feature_bold_name' => 'required|max:50',
                'feature_detail' => 'required',
            ]);

            $data = [
                'feature_setting_enable' => $request->feature_setting_enable == 'on' ? 'on' : 'off',
                'feature_name' => $request->feature_name,
                'feature_bold_name' => $request->feature_bold_name,
                'feature_detail' => $request->feature_detail,
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Feature setting updated successfully.'));
        } else {
            $data = [
                'feature_setting_enable' => 'off',
            ];
            $arrEnv = [
                'feature_setting_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Feature setting disabled.'));
        }
    }

    public function featureCreate(Request $request)
    {
        return view('landing-page.feature.create');
    }

    public function featureStore(Request $request)
    {

        request()->validate([
            'feature_name'      => 'required|max:50|regex:/(^[A-Za-z ]+$)+/|string',
            'feature_bold_name' => 'required|max:50|regex:/(^[A-Za-z ]+$)+/|string',
            'feature_detail'   => 'required',
            'feature_image'     => 'required|mimes:svg',

        ]);
        $settingData = [
            "feature_setting" => UtilityFacades::getsettings('feature_setting'),
        ];
        $settings = $settingData;
        $data = json_decode($settings['feature_setting'], true);
        if ($request->feature_image) {
            $allowedfileExtension = ['svg'];
            $featureImage = time() . "-feature_image." . $request->feature_image->getClientOriginalExtension();
            $extension =  $request->feature_image->extension();
            $check = in_array($extension, $allowedfileExtension);
            if ($check) {
                $image_name = $featureImage;
                $request->feature_image->storeAs('landing-page/feature', $image_name);
                $datas['feature_image'] = 'landing-page/feature/' . $image_name;
            } else {
                return redirect()->back()->with('failed', __('File Type Not Valid. Please Upload Svg File'));
            }
        }
        $datas['feature_name'] = $request->feature_name;
        $datas['feature_bold_name'] = $request->feature_bold_name;
        $datas['feature_detail'] = $request->feature_detail;
        $data[] = $datas;
        $data = json_encode($data);
        settings::updateOrCreate(
            ['key' => 'feature_setting'],
            ['value' => $data]
        );
        return redirect()->back()->with(['success' => 'Feature setting created successfully.']);
    }

    public function featureEdit($key)
    {
        $settingData = [
            "feature_setting" => UtilityFacades::getsettings('feature_setting'),
        ];
        $settings = $settingData;
        $features = json_decode($settings['feature_setting'], true);
        $feature = $features[$key];
        return view('landing-page.feature.edit', compact('feature', 'key'));
    }

    public function featureUpdate(Request $request, $key)
    {


        request()->validate([
            'feature_name'      => 'required|max:50|regex:/(^[A-Za-z ]+$)+/|string',
            'feature_bold_name' => 'required|max:50|regex:/(^[A-Za-z ]+$)+/|string',
            'feature_detail'   => 'required',
            'feature_image'     => 'required|mimes:svg',

        ]);

        $settingData = [
            "feature_setting" => UtilityFacades::getsettings('feature_setting'),
        ];
        $settings = $settingData;
        $data = json_decode($settings['feature_setting'], true);
        if ($request->feature_image) {
            $allowedfileExtension = ['svg'];
            $featureImage = time() . "-feature_image." . $request->feature_image->getClientOriginalExtension();
            $extension =  $request->feature_image->extension();
            $check = in_array($extension, $allowedfileExtension);
            if ($check) {
                $image_name = $featureImage;
                $request->feature_image->storeAs('landing-page/feature', $image_name);
                $data[$key]['feature_image'] = 'landing-page/feature/' . $image_name;
            } else {
                return redirect()->back()->with('failed', __('File type not valid.'));
            }
        }
        $data[$key]['feature_name'] = $request->feature_name;
        $data[$key]['feature_bold_name'] = $request->feature_bold_name;
        $data[$key]['feature_detail'] = $request->feature_detail;
        $data = json_encode($data);
        settings::updateOrCreate(
            ['key' => 'feature_setting'],
            ['value' => $data]
        );
        return redirect()->back()->with(['success' => 'Feature setting updated successfully.']);
    }

    public function featureDelete($key)
    {
        $settingData = [
            "feature_setting" => UtilityFacades::getsettings('feature_setting'),
        ];
        $pages = json_decode($settingData['feature_setting'], true);
        unset($pages[$key]);
        settings::updateOrCreate(['key' =>  'feature_setting'], ['value' => $pages]);
        return redirect()->back()->with(['success' => 'Feature setting deleted successfully']);
    }

    public function startViewSetting(Request $request)
    {
        return view('landing-page.start-view-setting');
    }

    public function startViewSettingStore(Request $request)
    {
        if ($request->start_view_setting_enable == 'on') {
            request()->validate([
                'start_view_name' => 'required',
                'start_view_detail' => 'required',
                'start_view_link_name' => 'required',
                'start_view_link' => 'required',
                'start_view_image' => 'image|mimes:png,jpg,jpeg',
            ]);

            $data = [
                'start_view_setting_enable' => $request->start_view_setting_enable == 'on' ? 'on' : 'off',
                'start_view_name' => $request->start_view_name,
                'start_view_detail' => $request->start_view_detail,
                'start_view_link_name' => $request->start_view_link_name,
                'start_view_link' => $request->start_view_link,
            ];

            if ($request->start_view_image) {
                $imageName = 'startview.' . $request->start_view_image->extension();
                $request->start_view_image->storeAs('landing-page', $imageName);
                $data['start_view_image'] = 'landing-page/' . $imageName;
            }
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Start view setting updated successfully.'));
        } else {
            $data = [
                'start_view_setting_enable' => 'off',
            ];
            $arrEnv = [
                'start_view_setting_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Start view setting disabled.'));
        }
    }

    public function businessGrowthSetting(Request $request)
    {
        $settingData = [
            "business_growth_setting" => UtilityFacades::getsettings('business_growth_setting'),
            "business_growth_view_setting" => UtilityFacades::getsettings('business_growth_view_setting'),
        ];
        $settings = $settingData;
        $businessGrowthSettings = json_decode($settings['business_growth_setting'], true) ?? [];
        $businessGrowthViewSettings = json_decode($settings['business_growth_view_setting'], true);
        return view('landing-page.business-growth.index', compact('businessGrowthSettings', 'businessGrowthViewSettings'));
    }

    public function businessGrowthSettingStore(Request $request)
    {
        if ($request->business_growth_setting_enable == 'on') {
            request()->validate([
                'business_growth_name' => 'required',
                'business_growth_bold_name' => 'required',
                'business_growth_detail' => 'required',
                'business_growth_video' => 'mimes:mp4,avi,wmv,mov,webm',
                'business_growth_front_image' => 'image|mimes:png,jpg,jpeg',
            ]);

            $data = [
                'business_growth_setting_enable' => $request->business_growth_setting_enable == 'on' ? 'on' : 'off',
                'business_growth_name' => $request->business_growth_name,
                'business_growth_bold_name' => $request->business_growth_bold_name,
                'business_growth_detail' => $request->business_growth_detail,
            ];
            if ($request->business_growth_front_image) {
                $imageName = '10.' . $request->business_growth_front_image->extension();
                $request->business_growth_front_image->storeAs('landing-page/businessgrowth/', $imageName);
                $data['business_growth_front_image'] = 'landing-page/businessgrowth/' . $imageName;
            }
            if ($request->business_growth_video) {
                $filename = 'vedio.' . $request->business_growth_video->extension();
                $request->business_growth_video->storeAs('landing-page/businessgrowth/', $filename);
                $data['business_growth_video'] = $request->business_growth_video->storeAs('landing-page/businessgrowth/', $filename);
            }
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Business growth updated successfully.'));
        } else {
            $data = [
                'business_growth_setting_enable' => 'off',
            ];
            $arrEnv = [
                'business_growth_setting_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Business growth disabled.'));
        }
    }

    public function businessGrowthCreate(Request $request)
    {
        return view('landing-page.business-growth.create');
    }

    public function businessGrowthStore(Request $request)
    {
        $settingData = [
            "business_growth_setting" => UtilityFacades::getsettings('business_growth_setting'),
        ];
        $settings = $settingData;
        $data = json_decode($settings['business_growth_setting'], true);

        $datas['business_growth_title'] = $request->business_growth_title;
        $data[] = $datas;
        $data = json_encode($data);
        settings::updateOrCreate(
            ['key' => 'business_growth_setting'],
            ['value' => $data]
        );
        return redirect()->back()->with(['success' => 'Business growth setting created successfully.']);
    }

    public function businessGrowthEdit($key)
    {
        $settingData = [
            "business_growth_setting" => UtilityFacades::getsettings('business_growth_setting'),
        ];
        $settings = $settingData;
        $businessGrowthSettings = json_decode($settings['business_growth_setting'], true);
        $businessGrowthSetting = $businessGrowthSettings[$key];
        return view('landing-page.business-growth.edit', compact('businessGrowthSetting', 'key'));
    }

    public function businessGrowthUpdate(Request $request, $key)
    {
        $settingData = [
            "business_growth_setting" => UtilityFacades::getsettings('business_growth_setting'),
        ];
        $settings = $settingData;
        $data = json_decode($settings['business_growth_setting'], true);

        $data[$key]['business_growth_title'] = $request->business_growth_title;
        $data = json_encode($data);
        settings::updateOrCreate(
            ['key' => 'business_growth_setting'],
            ['value' => $data]
        );
        return redirect()->back()->with(['success' => 'Business growth setting updated successfully.']);
    }

    public function businessGrowthDelete($key)
    {
        $settingData = [
            "business_growth_setting" => UtilityFacades::getsettings('business_growth_setting'),
        ];
        $pages = json_decode($settingData['business_growth_setting'], true);
        unset($pages[$key]);
        settings::updateOrCreate(['key' =>  'business_growth_setting'], ['value' => $pages]);
        return redirect()->back()->with(['success' => 'Business growth setting deleted successfully']);
    }

    public function businessGrowthViewCreate(Request $request)
    {
        return view('landing-page.business-growth.business-growth-view-create');
    }

    public function businessGrowthViewStore(Request $request)
    {
        $settingData = [
            "business_growth_view_setting" => UtilityFacades::getsettings('business_growth_view_setting'),
        ];
        $settings = $settingData;
        $data = json_decode($settings['business_growth_view_setting'], true);

        $datas['business_growth_view_name'] = $request->business_growth_view_name;
        $datas['business_growth_view_amount'] = $request->business_growth_view_amount;
        $data[] = $datas;
        $data = json_encode($data);
        settings::updateOrCreate(
            ['key' => 'business_growth_view_setting'],
            ['value' => $data]
        );
        return redirect()->back()->with(['success' => 'Business growth view setting created successfully.']);
    }

    public function businessGrowthViewEdit($key)
    {
        $setting_data = [
            "business_growth_view_setting" => UtilityFacades::getsettings('business_growth_view_setting'),
        ];
        $settings = $setting_data;
        $businessGrowthViewSettings = json_decode($settings['business_growth_view_setting'], true);
        $businessGrowthViewSetting = $businessGrowthViewSettings[$key];
        return view('landing-page.business-growth.business-growth-view-edit', compact('businessGrowthViewSetting', 'key'));
    }

    public function businessGrowthViewUpdate(Request $request, $key)
    {
        $settingData = [
            "business_growth_view_setting" => UtilityFacades::getsettings('business_growth_view_setting'),
        ];
        $settings = $settingData;
        $data = json_decode($settings['business_growth_view_setting'], true);

        $data[$key]['business_growth_view_name'] = $request->business_growth_view_name;
        $data[$key]['business_growth_view_amount'] = $request->business_growth_view_amount;
        $data = json_encode($data);
        settings::updateOrCreate(
            ['key' => 'business_growth_view_setting'],
            ['value' => $data]
        );
        return redirect()->back()->with(['success' => 'Business growth view setting updated successfully.']);
    }

    public function businessGrowthViewDelete($key)
    {
        $settingData = [
            "business_growth_view_setting" => UtilityFacades::getsettings('business_growth_view_setting'),
        ];
        $pages = json_decode($settingData['business_growth_view_setting'], true);
        unset($pages[$key]);
        settings::updateOrCreate(['key' =>  'business_growth_view_setting'], ['value' => $pages]);
        return redirect()->back()->with(['success' => 'Business growth view setting deleted successfully']);
    }

    public function contactusSetting(Request $request)
    {
        return view('landing-page.contactus-setting');
    }

    public function contactusSettingStore(Request $request)
    {
        if ($request->contactus_setting_enable == 'on') {
            request()->validate([
                'contact_email' => 'required|email',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);

            $data = [
                'contactus_setting_enable' => $request->contactus_setting_enable == 'on' ? 'on' : 'off',
                'contact_email' => $request->contact_email,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Contactus setting updated successfully.'));
        } else {
            $data = [
                'contactus_setting_enable' => 'off',
            ];
            $arrEnv = [
                'contactus_setting_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Contactus setting disabled.'));
        }
    }

    public function formSetting(Request $request)
    {
        return view('landing-page.form-setting');
    }

    public function formSettingStore(Request $request)
    {
        if ($request->form_setting_enable == 'on') {
            request()->validate([
                'form_name' => 'required',
                'form_detail' => 'required',
            ]);

            $data = [
                'form_setting_enable' => $request->form_setting_enable == 'on' ? 'on' : 'off',
                'form_name' => $request->form_name,
                'form_detail' => $request->form_detail,
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('form setting updated successfully.'));
        } else {
            $data = [
                'form_setting_enable' => 'off',
            ];
            $arrEnv = [
                'form_setting_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('failed', __('form setting disabled.'));
        }
    }

    public function blogsetting(Request $request)
    {
        return view('landing-page.blog-setting');
    }

    public function blogSettingStore(Request $request)
    {
        if ($request->blog_setting_enable == 'on') {
            request()->validate([
                'blog_name' => 'required',
                'blog_detail' => 'required',
            ]);

            $data = [
                'blog_setting_enable' => $request->blog_setting_enable == 'on' ? 'on' : 'off',
                'blog_name' => $request->blog_name,
                'blog_detail' => $request->blog_detail,
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('blog setting updated successfully.'));
        } else {
            $data = [
                'blog_setting_enable' => 'off',
            ];
            $arrEnv = [
                'blog_setting_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('failed', __('blog setting disabled.'));
        }
    }

    public function headerSetting()
    {
        $headerSettings = HeaderSetting::all();
        return view('landing-page.header.index', compact('headerSettings'));
    }

    public function headerMenuCreate()
    {
        $pages = PageSetting::pluck('title', 'id');
        return view('landing-page.header.create', compact('pages'));
    }

    public function headerMenuStore(Request $request)
    {
        $page = PageSetting::where('id', $request->page_id)->first();
        request()->validate([
            'page_id' => 'required',
        ]);

        $headerMenu               = new HeaderSetting();
        $headerMenu->menu         = $page->title;
        $headerMenu->page_id      = $request->page_id;
        $headerMenu->save();
        return redirect()->back()->with('success', 'Header Menu created successfully');
    }

    public function headerMenuEdit($id)
    {
        $headerMenuEdit = HeaderSetting::find($id);
        $pages = PageSetting::pluck('title', 'id');
        return view('landing-page.header.edit', compact('headerMenuEdit', 'pages'));
    }


    public function headerMenuUpdate(Request $request, $id)
    {
        $page = PageSetting::where('id', $request->page_id)->first();
        request()->validate([
            'page_id' => 'required',
        ]);

        $headerMenu = HeaderSetting::where('id', $id)->first();
        $headerMenu->menu = $page->title;
        $headerMenu->page_id      = $request->page_id;
        $headerMenu->update();
        return redirect()->back()->with('success', 'Header Menu updated successfully');
    }

    public function headerMenuDelete(Request $request, $id)
    {

        $headerMenu = HeaderSetting::where('id', $id)->first();
        $headerMenu->delete();
        return redirect()->back()->with('success', 'Footer Menu Updated Successfully');
    }

    public function footerSetting(Request $request)
    {

        $footerMainMenus = FooterSetting::where('parent_id', 0)->get();
        $footerSubMenus = FooterSetting::where('parent_id', '!=', 0)->get();
        return view('landing-page.footer.index', compact('footerMainMenus', 'footerSubMenus'));
    }

    public function footerSettingStore(Request $request)
    {
        if ($request->footer_setting_enable == 'on') {
            request()->validate([
                'footer_description' => 'required',
            ]);

            $data = [
                'footer_setting_enable' => $request->footer_setting_enable == 'on' ? 'on' : 'off',
                'footer_description' => $request->footer_description,
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Footer setting updated successfully.'));
        } else {
            $data = [
                'footer_setting_enable' => 'off',
            ];
            $arrEnv = [
                'footer_setting_enable' => 'off',
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Footer setting disabled.'));
        }
    }

    public function footerMainMenuCreate()
    {
        return view('landing-page.footer.create');
    }

    public function footerMainMenuStore(Request $request)
    {
        request()->validate([
            'menu' => 'required|regex:/(^[A-Za-z ]+$)+/',
        ]);

        $footerMainMenu           = new FooterSetting();
        $footerMainMenu->menu = $request->menu;
        $footerMainMenu->parent_id     = 0;
        $footerMainMenu->save();

        return redirect()->back()->with('success', 'Footer Main Menu created successfully');
    }

    public function footerMainMenuEdit($id)
    {
        $footerMainMenuEdit = FooterSetting::where('id', $id)->first();
        return view('landing-page.footer.edit', compact('footerMainMenuEdit'));
    }

    public function footerMainMenuUpdate(Request $request, $id)
    {
        request()->validate([
            'menu' => 'required|regex:/(^[A-Za-z ]+$)+/',
        ]);

        $footerMainMenu = FooterSetting::where('id', $id)->first();
        $footerMainMenu->menu = $request->menu;
        $footerMainMenu->parent_id = 0;
        $footerMainMenu->save();

        return redirect()->back()->with('success', 'Footer Main Menu updated successfully');
    }

    public function footerMainMenuDelete($id)
    {
        $footerMainMenu = FooterSetting::find($id);
        if ($footerMainMenu ->parent_id == 0) {
            FooterSetting::where('parent_id', $id)->delete();
        }
        $footerMainMenu ->delete();
        return redirect()->back()->with('success', 'Footer Menu Updated Successfully');
    }

    public function footerSubMenuCreate()
    {
        $pages = PageSetting::pluck('title', 'id');
        $footers = FooterSetting::where('parent_id', 0)->pluck('menu', 'id');
        return view('landing-page.footer.create-sub-menu', compact('pages', 'footers'));
    }

    public function footerSubMenuStore(Request $request)
    {
        $pages = PageSetting::where('id', $request->page_id)->first();
        $footerSubMenu             = new FooterSetting();
        $footerSubMenu->menu       = $pages->title;
        $footerSubMenu->page_id    = $request->page_id;
        $footerSubMenu->parent_id  = $request->parent_id;
        $footerSubMenu->save();
        return redirect()->route('landing.footer.index')->with('success', 'Footer sub menu created successfully');
    }

    public function footerSubMenuEdit($id)
    {
        $footerPage = FooterSetting::find($id);
        $pages = PageSetting::pluck('title', 'id');
        $footer = FooterSetting::where('parent_id', 0)->pluck('menu', 'id');
        $footerMenu = FooterSetting::where('id', $footerPage->parent_id)->pluck('menu', 'id');
        return view('landing-page.footer.edit-sub-menu', compact('pages', 'footerPage', 'footer', 'footerMenu'));
    }

    public function footerSubMenuUpdate(Request $request, $id)
    {
        $pages = PageSetting::where('id', $request->page_id)->first();
        request()->validate([
            //'type'=>'required',
        ]);
        $footerSubMenu = FooterSetting::where('id', $id)->first();
        $footerSubMenu->menu        = $pages->title;
        $footerSubMenu->page_id     = $request->page_id;
        $footerSubMenu->parent_id   = $request->parent_id;
        $footerSubMenu->save();
        return redirect()->route('landing.footer.index')->with('success', 'Footer sub menu updated successfully');
    }

    public function footerSubMenuDelete($id)
    {
        $footerSubMenu = FooterSetting::where('id', $id)->first();
        $footerSubMenu->delete();
        return redirect()->back()->with('success', 'Footer Sub Menu Updated Successfully');
    }

    public function pagesView($slug)
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        $pageFooter = FooterSetting::where('slug', $slug)->first();
        $footerMainMenus = FooterSetting::where('parent_id', 0)->get();
        return view('landing-page.footer.pagesView', compact('pageFooter', 'footerMainMenus', 'lang', 'slug'));
    }

    public function loginSetting()
    {
        return view('landing-page.login-page-setting');
    }

    public function loginSettingStore(Request $request)
    {
        request()->validate([
            'login_title' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:191',
            'login_subtitle' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:191',
            'login_image' => 'image|mimes:svg',
        ]);

        $data = [
            'login_title' => $request->login_title,
            'login_subtitle' => $request->login_subtitle,
        ];
        if ($request->login_image) {
            $loginImageName = 'login-page.' . $request->login_image->extension();
            $request->login_image->storeAs('landing-page', $loginImageName);
            $data['login_image'] = 'landing-page/' . $loginImageName;
        }
        $this->updateSettings($data);
        return redirect()->back()->with('success', __('Login page setting updated successfully.'));
    }

    public function captchaSetting()
    {
        return view('landing-page.captcha-setting');
    }

    public function captchaSettingStore(Request $request)
    {
        if ($request->contact_us_recaptcha_status == 'on' || $request->login_recaptcha_status == 'on') {
            request()->validate([
                'recaptcha_key' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/',
                'recaptcha_secret' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/',
            ]);
        }
        $data = [
            'contact_us_recaptcha_status' => ($request->contact_us_recaptcha_status == 'on') ? '1' : '0',
            'login_recaptcha_status' => ($request->login_recaptcha_status == 'on') ? '1' : '0',
            'recaptcha_key' => $request->recaptcha_key,
            'recaptcha_secret' => $request->recaptcha_secret,
        ];
        $this->updateSettings($data);
        return redirect()->back()->with('success', __('Recaptcha setting updated successfully.'));
    }

    public function pageBackground(Request $request)
    {
        return view('landing-page.background-image');
    }

    public function pageBackgroundstore(Request $request)
    {
        request()->validate([
            'background_image' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        if ($request->background_image) {
            $imageName = 'background.' . $request->background_image->extension();
            $request->background_image->storeAs('landing-page/', $imageName);
            $data['background_image'] = 'landing-page/' . $imageName;
        }
        $this->updateSettings($data);
        return redirect()->back()->with('success', __('Background setting updated successfully.'));
    }

    public function announcementsSetting()
    {
        return view('landing-page.announcements-setting');
    }

    public function announcementsSettingStore(Request $request)
    {
        request()->validate([
            'announcements_title'                  => 'required|max:191',
            'announcement_short_description'       => 'required',
        ]);
        $data = [
            'announcements_setting_enable'         => $request->announcements_setting_enable == 'on' ? 'on' : 'off',
            'announcements_title'                  => $request->announcements_title,
            'announcement_short_description'       => $request->announcement_short_description,
        ];
        foreach ($data as $key => $value) {
            settings::updateOrCreate([
                'key'   => $key,
                'value' => $value
            ]);
        }
        return redirect()->back()->with('success', __('Announcements setting updated successfully.'));
    }
}
