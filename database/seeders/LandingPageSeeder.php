<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FooterSetting;
use App\Models\PageSetting;
use App\Models\settings;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $settings = [
            ['key' => 'apps_setting_enable', 'value' => 'on'],
            ['key' => 'apps_name', 'value' => 'Prime Laravel'],
            ['key' => 'apps_bold_name', 'value' => 'Form Builder'],
            ['key' => 'app_detail', 'value' => 'Prime Laravel Form Builder is software for creating automated systems, you can create your own forms without writing a line of code. you have only to use the Drag & Drop to build your form and start using it.'],
            ['key' => 'apps_image', 'value' => 'seeder-images/app.png'],
            ['key' => 'apps_multiple_image_setting', 'value' => '[{"apps_multiple_image":"seeder-images/1.png"},
                                                                  {"apps_multiple_image":"seeder-images/2.png"},
                                                                  {"apps_multiple_image":"seeder-images/3.png"},
                                                                  {"apps_multiple_image":"seeder-images/4.png"},
                                                                  {"apps_multiple_image":"seeder-images/5.png"},
                                                                  {"apps_multiple_image":"seeder-images/6.png"},
                                                                  {"apps_multiple_image":"seeder-images/7.png"},
                                                                  {"apps_multiple_image":"seeder-images/8.png"},
                                                                  {"apps_multiple_image":"seeder-images/9.png"}]'],


            ['key' => 'feature_setting_enable', 'value' => 'on'],
            ['key' => 'feature_name', 'value' => 'Prime Laravel Form Builder'],
            ['key' => 'feature_bold_name', 'value' => 'Features'],
            ['key' => 'feature_detail', 'value' => 'Prime Laravel Form Builder The features of Prime make it one of the most flexible systems for optimal inventory management. Features such as godown management, multiple stock valuation, manufacturing, batch and expiry date, job costing, etc., and powerful inventory reports make inventory management a cakewalk.'],
            ['key' => 'feature_setting', 'value' => '[
                                                        {"feature_image":"seeder-images/active.svg","feature_name":"Email Notification","feature_bold_name":"On From Submit","feature_detail":"You can send a notification email to someone in your organization when a contact submits a form. You can use this type of form processing step so that..."},
                                                        {"feature_image":"seeder-images/security.svg","feature_name":"Two Factor","feature_bold_name":"Authentication","feature_detail":"Security is our priority. With our robust two-factor authentication (2FA) feature, you can add an extra layer of protection to your Prime Laravel Form"},
                                                        {"feature_image":"seeder-images/secretary.svg","feature_name":"Multi Users With","feature_bold_name":"Role & permission","feature_detail":"Assign roles and permissions to different users based on their responsibilities and requirements. Admins can manage user accounts, define access level"},
                                                        {"feature_image":"seeder-images/documents.svg","feature_name":"Document builder","feature_bold_name":"Easy and fast","feature_detail":"Template Library: Offer a selection of pre-designed templates for various document types (e.g., contracts, reports).Template Creation: Allow users to create custom templates with placeholders for dynamic content.\r\n\r\nTemplate Library: Offer a selection of pre-designed templates for various document types (e.g., contracts, reports).Template Creation: Allow users to create custom templates with placeholders for dynamic content."}]'],


            ['key' => 'menu_setting_section1_enable', 'value' => 'on'],
            ['key' => 'menu_image_section1', 'value' => 'seeder-images/menusection1.png'],
            ['key' => 'menu_name_section1', 'value' => 'Form Builder'],
            ['key' => 'menu_bold_name_section1', 'value' => 'With Drag & Drop Dashboard Widgets'],
            ['key' => 'menu_detail_section1', 'value' => 'Creating beautiful dashboards has never been easier. Our drag-and-drop interface lets you effortlessly arrange and resize widgets, allowing you to design dynamic and interactive dashboards without any coding.'],

            ['key' => 'menu_setting_section2_enable', 'value' => 'on'],
            ['key' => 'menu_image_section2', 'value' => 'seeder-images/menusection12.png'],
            ['key' => 'menu_name_section2', 'value' => 'Multi builders'],
            ['key' => 'menu_bold_name_section2', 'value' => 'Poll Management & Document Generator & Booking System'],
            ['key' => 'menu_detail_section2', 'value' => 'you can create customized surveys with ease. From multiple choice questionss to rating scales, our drag-and-drop builder lets you construct your polls in minutes, saving you valuable time and effort.'],

            ['key' => 'menu_setting_section3_enable', 'value' => 'on'],
            ['key' => 'menu_image_section3', 'value' => 'seeder-images/setting.png'],
            ['key' => 'menu_name_section3', 'value' => 'Setting Features With'],
            ['key' => 'menu_bold_name_section3', 'value' => 'Multiple Section settings'],
            ['key' => 'menu_detail_section3', 'value' => 'A settings page is a crucial component of many digital products, allowing users to customize their experience according to their preferences. Designing a settings page with dynamic data enhances user satisfaction and engagement. Here s a guide on how to create such a page.'],

            ['key' => 'business_growth_setting_enable', 'value' => 'on'],
            ['key' => 'business_growth_front_image', 'value' => 'seeder-images/10.png'],
            ['key' => 'business_growth_video', 'value' => 'seeder-images/Dashboard _ Prime Laravel Form Builder.mp4'],
            ['key' => 'business_growth_name', 'value' => 'Makes Quick'],
            ['key' => 'business_growth_bold_name', 'value' => 'Business Growth'],
            ['key' => 'business_growth_detail', 'value' => 'Offer unique products, services, or solutions that stand out in the market. Innovation and differentiation can attract customers and give you a competitive edge.'],
            ['key' => 'business_growth_view_setting', 'value' => '[{"business_growth_view_name":"Positive Reviews","business_growth_view_amount":"20 k+"},{"business_growth_view_name":"Total Sales","business_growth_view_amount":"300 +"},{"business_growth_view_name":"Happy Users","business_growth_view_amount":"100 k+"}]'],
            ['key' => 'business_growth_setting', 'value' => '[{"business_growth_title":"User Friendly"},{"business_growth_title":"Products Analytic"},{"business_growth_title":"Manufacturers"},{"business_growth_title":"Order Status Tracking"},{"business_growth_title":"Supply Chain"},{"business_growth_title":"Chatting Features"},{"business_growth_title":"Workflows"},{"business_growth_title":"Transformation"},{"business_growth_title":"Easy Payout"},{"business_growth_title":"Data Adjustment"},{"business_growth_title":"Order Status Tracking"},{"business_growth_title":"Store Swap Link"},{"business_growth_title":"Manufacturers"},{"business_growth_title":"Order Status Tracking"}]'],


            ['key' => 'form_setting_enable', 'value' => 'on'],
            ['key' => 'form_name', 'value' => 'Survey Form'],
            ['key' => 'form_detail', 'value' => 'Prime Laravel Form Builder is software for creating automated systems, you can create your own forms without writing a line of code. you have only to use the Drag & Drop to build your form and start using it.'],

            ['key' => 'faq_setting_enable', 'value' => 'on'],
            ['key' => 'faq_name', 'value' => 'Frequently asked questionss'],


            ['key' => 'blog_setting_enable', 'value' => 'on'],
            ['key' => 'blog_name', 'value' => 'BLOGS'],
            ['key' => 'blog_detail', 'value' => 'Optimize your manufacturing business with Quebix, offering a seamless user interface for streamlined operations, one convenient platform.'],


            ['key' => 'start_view_setting_enable', 'value' => 'on'],
            ['key' => 'start_view_name', 'value' => 'Prime Laravel Form Builder'],
            ['key' => 'start_view_detail', 'value' => 'Prime Laravel Form Builder is software for creating automated systems, you can create your own forms without writing a line of code. you have only to use the Drag & Drop to build your form and start using it.'],
            ['key' => 'start_view_link_name', 'value' => 'Contact US'],
            ['key' => 'start_view_link', 'value' => 'https://quebixtechnology.com/contact_us'],
            ['key' => 'start_view_image', 'value' => 'seeder-images//11.png'],

            ['key' => 'footer_setting_enable', 'value' => 'on'],
            ['key' => 'footer_description', 'value' => 'in this product, we provide you, with form builder & poll management, Multi users & permissions, email notification, event calender with ( google Calendar) And Document Generator.'],

        ];

        foreach ($settings as $setting) {
            settings::firstOrCreate($setting);
        }

        Faq::firstOrCreate(
            ['questions' => 'What is Prime Laravel Form Builder?'],
            [
                'answer' => 'Prime Laravel Form Builder is a powerful and user-friendly form-building solution specifically designed for Laravel, a popular PHP framework. It provides developers with a comprehensive set of tools and components to effortlessly create and manage forms within their Laravel applications.',
                'order' => 0,
            ]
        );
        Faq::firstOrCreate(
            ['questions' => 'What are the key features of Prime Laravel Form Builder?'],
            [
                'answer' => 'Prime Laravel Form Builder offers an array of features to simplify the form-building process. Some key features include: 1. Drag-and-drop form builder interface for intuitive form creation. 2. Wide range of pre-built form elements such as text fields, checkboxes, radio buttons, dropdowns, and more. 3. Flexible customization options to tailor forms to specific requirements. 4. Form validation rules and error handling for data integrity. 5. Seamless integration with Laravel\'s form handling and processing capabilities. 6. Ability to generate clean and semantic HTML code for optimal performance. 7. Built-in support for form themes and templates for consistent styling across applications. 8. Extensive documentation and dedicated customer support for assistance and troubleshooting.',
                'order' => 1,
            ]
        );
        Faq::firstOrCreate(
            ['questions' => 'Is Prime Laravel Form Builder compatible with Laravel versions?'],
            [
                'answer' => 'Yes, Prime Laravel Form Builder is designed to seamlessly integrate with different versions of Laravel, ensuring compatibility and smooth functioning. It is regularly updated to align with the latest Laravel releases, ensuring developers can leverage its features without compatibility concerns.',
                'order' => 2,
            ]
        );
        Faq::firstOrCreate(
            ['questions' => 'Can Prime Laravel Form Builder handle complex form requirements?'],
            [
                'answer' => 'Absolutely. Prime Laravel Form Builder is built to handle a wide range of form complexities. Whether you need multi-step forms, conditional logic, form validation rules, or dynamic form elements, it provides a robust framework to handle even the most intricate form requirements efficiently.',
                'order' => 3,
            ]
        );

        Testimonial::firstOrCreate(
            ['name' => 'Fex'],
            [
                'title' => 'Customer Support Specialist',
                'desc' => 'As a Customer Support Specialist for Prime-Laravel-Form-Builder, I have had the incredible opportunity to assist our valued customers in their journey of utilizing this revolutionary form-building solution.',
                'designation' => 'Support Specialist',
                'image' => 'seeder-images/13.png',
                'rating' => 5.0,
                'status' => 1,
            ]
        );

        Testimonial::firstOrCreate(
            ['name' => 'Johnsi'],
            [
                'title' => 'A Journey of Growth and Transformation',
                'desc' => 'As the Lead Developer for Prime-Laravel-Form-Builder, I have had the privilege of being at the forefront of developing a cutting-edge product that revolutionizes form-building.',
                'designation' => 'Lead Developer',
                'image' => 'seeder-images/14.png',
                'rating' => 5.0,
                'status' => 1,
            ]
        );

        Testimonial::firstOrCreate(
            ['name' => 'Fex Ilizania'],
            [
                'title' => 'Customer Support Specialist',
                'desc' => 'As a Customer Support Specialist for Prime-Laravel-Form-Builder, I have had the incredible opportunity to assist our valued customers in their journey of utilizing this revolutionary form-building solution.',
                'designation' => 'Support Specialist',
                'image' => 'seeder-images/15.png',
                'rating' => 5.0,
            ]
        );

        Testimonial::firstOrCreate(
            ['name' => 'John'],
            [
                'title' => 'A Remarkable Journey of Collaboration and Success',
                'desc' => 'As a Project Manager, my primary responsibility has been to ensure that projects are delivered on time, within budget. I have had the opportunity to work closely with cross-functional teams, marketers, and stakeholders, initiation to completion.',
                'designation' => 'Project Manager',
                'image' => 'seeder-images/16.png',
                'rating' => 5.0,
                'status' => 1,
            ]
        );

        $parent_id1 = FooterSetting::firstOrCreate([
            'menu' => 'Company',
        ], [
            'slug' => 'company',
            'parent_id' => 0,
            'page_id' => null,
        ]);

        $parent_id2 = FooterSetting::firstOrCreate([
            'menu' => 'Product',
        ], [
            'slug' => 'product',
            'parent_id' => 0,
            'page_id' => null,
        ]);


        $parent_id3 = FooterSetting::firstOrCreate([
            'menu' => 'Download',
        ], [
            'slug' => 'download',
            'parent_id' => 0,
            'page_id' => null,
        ]);

        $parent_id4 = FooterSetting::firstOrCreate([
            'menu' => 'Support',
        ], [
            'slug' => 'support',
            'parent_id' => 0,
            'page_id' => null,
        ]);



        $PageSetting1 = PageSetting::firstOrCreate(
            [
                'title' => 'About Us',
            ],
            [
                'type' => 'desc',
                'url_type' => null,
                'page_url' => null,
                'friendly_url' => null,
                'description' => 'At Prime Laravel Form Builder, we understand the importance of data privacy and security. That&#39;s why we offer robust privacy settings to ensure the protection of your sensitive information. Here&#39;s how our privacy settings work:\r\n\r\n\r\n\r\nData Encryption: We employ industry-standard encryption protocols to safeguard your data during transit and storage. Your form submissions and user information are encrypted, making it extremely difficult for unauthorized parties to access or tamper with the data.\r\n\r\n\r\nUser Consent Management: Our privacy settings include options for managing user consents. You can configure your forms to include consent checkboxes for users to agree to your data handling practices. This helps you ensure compliance with privacy regulations and builds trust with your users.\r\n\r\n\r\nData Retention Controls: Take control of how long you retain user data with our data retention settings. Define retention periods that align with your business needs or regulatory requirements. Once the specified retention period expires, the data is automatically and permanently deleted from our servers.\r\n\r\n\r\nAccess Controls: Grant specific access permissions to team members or clients based on their roles and responsibilities. With our access control settings, you can limit who can view, edit, or export form data, ensuring that only authorized individuals can access sensitive information.\r\n\r\n\r\nThird-Party Integrations: If you integrate third-party services or applications with Prime Laravel Form Builder, our privacy settings enable you to manage the data shared with these services. You have the flexibility to control which data is shared, providing an extra layer of privacy and control.',
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'About Us',
        ], [
            'slug' => 'about-us',
            'parent_id' => $parent_id1->id,
            'page_id' => $PageSetting1->id,
        ]);


        $PageSetting2 = PageSetting::firstOrCreate(
            [
                'title' => 'Our Team',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => '#',
                'friendly_url' => '#',
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Our Team',
        ], [
            'slug' => 'our-team',
            'parent_id' => $parent_id1->id,
            'page_id' => $PageSetting2->id,
        ]);


        $PageSetting3 = PageSetting::firstOrCreate(
            [
                'title' => 'Products',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => 'https://codecanyon.net/user/quebix-technology',
                'friendly_url' => 'https://codecanyon.net/user/quebix-technology',
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Products',
        ], [
            'slug' => 'products',
            'parent_id' => $parent_id1->id,
            'page_id' => $PageSetting3->id,
        ]);


        $PageSetting4 = PageSetting::firstOrCreate(
            [
                'title' => 'Contact',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => url('contact/us'),
                'friendly_url' => url('contact/us'),
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Contact',
        ], [
            'slug' => 'contact',
            'parent_id' => $parent_id1->id,
            'page_id' => $PageSetting4->id,
        ]);

        $PageSetting5 =  PageSetting::firstOrCreate(
            [
                'title' => 'Feature',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => '#',
                'friendly_url' => '#',
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Feature',
        ], [
            'slug' => 'feature',
            'parent_id' => $parent_id2->id,
            'page_id' => $PageSetting5->id,
        ]);


        $PageSetting6 =  PageSetting::firstOrCreate(
            [
                'title' => 'Pricing',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => '#',
                'friendly_url' => '#',
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Pricing',
        ], [
            'slug' => 'pricing',
            'parent_id' => $parent_id2->id,
            'page_id' => $PageSetting6->id,
        ]);



        $PageSetting7 = PageSetting::firstOrCreate(
            [
                'title' => 'Credit',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => '#',
                'friendly_url' => '#',
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Credit',
        ], [
            'slug' => 'Credit',
            'parent_id' => $parent_id2->id,
            'page_id' => $PageSetting7->id,
        ]);



        $PageSetting8 = PageSetting::firstOrCreate(
            [
                'title' => 'News',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => '#',
                'friendly_url' => '#',
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'News',
        ], [
            'slug' => 'news',
            'parent_id' => $parent_id2->id,
            'page_id' => $PageSetting8->id,
        ]);



        $PageSetting9 =  PageSetting::firstOrCreate(
            [
                'title' => 'iOS',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => '#',
                'friendly_url' => '#',
                'description' => null,
            ]
        );


        FooterSetting::firstOrCreate([
            'menu' => 'iOS',
        ], [
            'slug' => 'ios',
            'parent_id' => $parent_id3->id,
            'page_id' => $PageSetting9->id,
        ]);


        $PageSetting10 = PageSetting::firstOrCreate(
            [
                'title' => 'Android',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => '#',
                'friendly_url' => '#',
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Android',
        ], [
            'slug' => 'android',
            'parent_id' => $parent_id3->id,
            'page_id' => $PageSetting10->id,
        ]);


        $PageSetting11 =  PageSetting::firstOrCreate(
            [
                'title' => 'Microsoft',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => '#',
                'friendly_url' => '#',
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Microsoft',
        ], [
            'slug' => 'microsoft',
            'parent_id' => $parent_id3->id,
            'page_id' => $PageSetting11->id,
        ]);

        $PageSetting12 =   PageSetting::firstOrCreate(
            [
                'title' => 'Desktop',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => '#',
                'friendly_url' => '#',
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Desktop',
        ], [
            'slug' => 'desktop',
            'parent_id' => $parent_id3->id,
            'page_id' => $PageSetting12->id,
        ]);


        $PageSetting13 =  PageSetting::firstOrCreate(
            [
                'title' => 'Help',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => '#',
                'friendly_url' => '#',
                'description' => null,
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Help',
        ], [
            'slug' => 'help',
            'parent_id' => $parent_id4->id,
            'page_id' => $PageSetting13->id,
        ]);

        $PageSetting14 =   PageSetting::firstOrCreate(
            [
                'title' => 'Terms',
            ],
            [
                'type' => 'desc',
                'url_type' => null,
                'page_url' => null,
                'friendly_url' => null,
                'description' => 'Prime Laravel Form builder Terms and Conditions



                Acceptance of Terms By accessing and using [Prime Laravel Form builder ] (the &quot;Service&quot;), you agree to be bound by these terms and conditions. If you do not agree with any part of these terms, please refrain from using the Service.


                Intellectual Property Rights All content and materials provided on the Service are the property of [Prime Laravel Form builder - Saas]&nbsp;and protected by applicable intellectual property laws. You may not use, reproduce, distribute, or modify any content from the Service without prior written consent from [Prime Laravel Form builder ].


                User Responsibilities a. You are solely responsible for any content you submit or upload on the Service. You agree not to post, transmit, or share any material that is unlawful, harmful, defamatory, obscene, or infringes upon the rights of others. b. You agree not to interfere with or disrupt the Service or its associated servers and networks. c. You are responsible for maintaining the confidentiality of your account information and agree to notify [Prime Laravel Form builder - Saas] immediately of any unauthorized use of your account.


                Disclaimer of Warranties The Service is provided on an &quot;as-is&quot; and &quot;as available&quot; basis. [Prime Laravel Form builder ] makes no warranties, expressed or implied, regarding the accuracy, reliability, or availability of the Service. Your use of the Service is at your own risk.


                Limitation of Liability In no event shall [Prime Laravel Form builder ] be liable for any direct, indirect, incidental, consequential, or punitive damages arising out of or in connection with the use of the Service. This includes but is not limited to any errors or omissions in the content, loss of data, or any other loss or damage.


                Indemnification You agree to indemnify and hold&nbsp; harmless from any claims, damages, liabilities, or expenses arising out of your use of the Service, your violation of these terms and conditions, or your infringement of any rights of a third party.


                Modification and Termination [Prime Laravel Form builder - Saas] reserves the right to modify or terminate the Service at any time, without prior notice. We also reserve the right to update these terms and conditions from time to time. It is your responsibility to review the most current version regularly.


                Governing Law These terms and conditions shall be governed by and construed in accordance with the laws of India. Any disputes arising out of these terms shall be subject to the exclusive jurisdiction of the courts located in india.

            ',
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Terms',
        ], [
            'slug' => 'terms',
            'parent_id' => $parent_id4->id,
            'page_id' => $PageSetting14->id,
        ]);

        $PageSetting15 =   PageSetting::firstOrCreate(
            [
                'title' => 'FAQ',
            ],
            [
                'type' => 'link',
                'url_type' => 'internal link',
                'page_url' => url('all/faqs'),
                'friendly_url' => url('all/faqs'),
                'description' => null,
            ]
        );


        FooterSetting::firstOrCreate([
            'menu' => 'FAQ',
        ], [
            'slug' => 'fAQ',
            'parent_id' => $parent_id4->id,
            'page_id' => $PageSetting15->id,
        ]);



        $PageSetting16 =    PageSetting::firstOrCreate(
            [
                'title' => 'Privacy',
            ],
            [
                'type' => 'desc',
                'url_type' => null,
                'page_url' => null,
                'friendly_url' => null,
                'description' => '

                Acceptance of Terms By accessing and using [Prime Laravel Form builder ] (the &quot;Service&quot;), you agree to be bound by these terms and conditions. If you do not agree with any part of these terms, please refrain from using the Service.


                Intellectual Property Rights All content and materials provided on the Service are the property of [Prime Laravel Form builder - Saas]&nbsp;and protected by applicable intellectual property laws. You may not use, reproduce, distribute, or modify any content from the Service without prior written consent from [Prime Laravel Form builder ].


                User Responsibilities a. You are solely responsible for any content you submit or upload on the Service. You agree not to post, transmit, or share any material that is unlawful, harmful, defamatory, obscene, or infringes upon the rights of others. b. You agree not to interfere with or disrupt the Service or its associated servers and networks. c. You are responsible for maintaining the confidentiality of your account information and agree to notify [Prime Laravel Form builder - Saas] immediately of any unauthorized use of your account.


                Disclaimer of Warranties The Service is provided on an &quot;as-is&quot; and &quot;as available&quot; basis. [Prime Laravel Form builder ] makes no warranties, expressed or implied, regarding the accuracy, reliability, or availability of the Service. Your use of the Service is at your own risk.


                Limitation of Liability In no event shall [Prime Laravel Form builder ] be liable for any direct, indirect, incidental, consequential, or punitive damages arising out of or in connection with the use of the Service. This includes but is not limited to any errors or omissions in the content, loss of data, or any other loss or damage.


                Indemnification You agree to indemnify and hold&nbsp; harmless from any claims, damages, liabilities, or expenses arising out of your use of the Service, your violation of these terms and conditions, or your infringement of any rights of a third party.


                Modification and Termination [Prime Laravel Form builder - Saas] reserves the right to modify or terminate the Service at any time, without prior notice. We also reserve the right to update these terms and conditions from time to time. It is your responsibility to review the most current version regularly.


                Governing Law These terms and conditions shall be governed by and construed in accordance with the laws of India. Any disputes arising out of these terms shall be subject to the exclusive jurisdiction of the courts located in india.

            ',
            ]
        );

        FooterSetting::firstOrCreate([
            'menu' => 'Privacy',
        ], [
            'slug' => 'privacy',
            'parent_id' => $parent_id4->id,
            'page_id' => $PageSetting16->id,
        ]);
    }
}
