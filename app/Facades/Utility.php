<?php

namespace App\Facades;

use App\Mail\config;
use App\Models\Form;
use App\Models\settings;
use Carbon\Carbon;
use App\Models\FormValue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class Utility
{
    public function settings()
    {
        $data = DB::table('settings');
        $data = $data->get();
        $settings = [
            "date_format" => "M j,Y",
            "time_format" => "g:i A",
        ];
        foreach ($data as $row) {
            $settings[$row->key] = $row->value;
        }
        return $settings;
    }

    public function date_format($date)
    {
        return Carbon::parse($date)->format($this->getsettings('date_format'));
    }

    public function time_format($time)
    {
        return Carbon::parse($time)->format($this->getsettings('time_format'));
    }

    public function date_time_format($date)
    {
        return Carbon::parse($date)->format($this->getsettings('date_format') . ' ' . $this->getsettings('time_format'));
    }

    public function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }
        return true;
    }

    public function getActiveLanguage()
    {
        $lang = Cookie::get('lang');
        if ($lang) {
            return $lang;
        } else {
            return Self::getValByName('default_language');
        }
    }

    public function keysettings($key = '', $form_user_id = '')
    {
        $val = '';
        $setting = settings::select('value');
        $set =  $setting->where('key', $key)->first();
        if (!empty($set->value)) {
            $val = $set->value;
        }
        return $val;
    }

    public static function GetCacheSize()
    {
        $file_size = 0;
        foreach (File::allFiles(storage_path('/framework')) as $file) {
            $file_size += $file->getSize();
        }
        $file_size = number_format($file_size / 1000000, 4);
        return $file_size;
    }

    public static function get_device_type($user_agent)
    {
        $mobile_regex = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
        $tablet_regex = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';
        if(preg_match_all($mobile_regex, $user_agent)) {
            return 'mobile';
        } else {
            if(preg_match_all($tablet_regex, $user_agent)) {
                return 'tablet';
            } else {
                return 'desktop';
            }
        }
    }

    public function getValByName($key)
    {
        $setting = $this->settings();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }
        return $setting[$key];
    }

    public function languages()
    {
        $dir     = base_path() . '/resources/lang/';
        $glob    = glob($dir . "*", GLOB_ONLYDIR);
        $arrLang = array_map(
            function ($value) use ($dir) {
                return str_replace($dir, '', $value);
            },
            $glob
        );
        $arrLang = array_map(
            function ($value) use ($dir) {
                return preg_replace('/[0-9]+/', '', $value);
            },
            $arrLang
        );
        $arrLang = array_filter($arrLang);
        return $arrLang;
    }

    public static function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }

    public function getpath($name)
    {
        $src = $name ? Storage::url($name) : Storage::url('logo/app-logo.png');
        return $src;
    }

    public function getsettings($value = '')
    {
        $val = '';
        $setting = settings::select('value');
        $set =  $setting->where('key', $value)->first();
        if (!empty($set->value)) {
            $val = $set->value;
        }
        return $val;
    }


    public function getformpaymenttypes()
    {
        $payment_type = [];
        $payment_type[''] = 'Select payment';
        if (Self::getsettings('stripesetting') == 'on') {
            $payment_type['stripe'] = 'Stripe';
        }
        if (Self::getsettings('paypalsetting') == 'on') {
            $payment_type['paypal'] = 'Paypal';
        }
        if (Self::getsettings('razorpaysetting') == 'on') {
            $payment_type['razorpay'] = 'Razorpay';
        }
        if (Self::getsettings('paytmsetting') == 'on') {
            $payment_type['paytm'] = 'Paytm';
        }
        if (Self::getsettings('flutterwavesetting') == 'on') {
            $payment_type['flutterwave'] = 'Flutterwave';
        }
        if (Self::getsettings('paystacksetting') == 'on') {
            $payment_type['paystack'] = 'Paystack';
        }
        if (Self::getsettings('coingatesetting') == 'on') {
            $payment_type['coingate'] = 'Coingate';
        }
        if (Self::getsettings('mercadosetting') == 'on') {
            $payment_type['mercado'] = 'Mercado';
        }
        return $payment_type;
    }


    public function WidgetChartData($form_id)
    {
        $chartArray = [];
        $form_values = FormValue::select('forms.json as form_json', 'form_values.*')->where('form_id', $form_id)->join('forms', 'forms.id', '=', 'form_values.form_id');
        $form_values = $form_values->get();
        foreach ($form_values as $form_value) {
            $array1 = json_decode($form_value->form_json);
            foreach ($array1 as $rows1) {
                foreach ($rows1 as $row_key1 => $row1) {
                    if (property_exists($row1, 'name')) {
                        if (!isset($chartArray[$row1->name])) {
                            $options = [];
                            if ($row1->type == 'radio-group' || $row1->type == 'select' || $row1->type == 'checkbox-group') {
                                foreach ($row1->values as $value) {
                                    $options[$value->label] = 0;
                                }
                                if (isset($row1->value)) {
                                    $options['other'] = 0;
                                }
                            } elseif ($row1->type == 'starRating') {
                                $options = [
                                    '0' => 0, '0.5' => 0, '1' => 0, '1.5' => 0, '2' => 0, '2.5' => 0, '3' => 0, '3.5' => 0, '4' => 0, '4.5' => 0, '5' => 0,
                                ];
                            } elseif ($row1->type == 'date') {
                                $options = [];
                            } else {
                                $row1->chart_type = '';
                                $row1->label = '';
                            }
                            $tmp = [
                                'name' => $row1->name,
                                'label' => $row1->label,
                                'options' => $options,
                                'chart_type' => $row1->chart_type
                            ];
                            $chartArray[$row1->name] = $tmp;
                        }
                    }
                }
            }
            $array = json_decode($form_value->json);
            foreach ($array as $rows) {
                foreach ($rows as $row_key => $row) {
                    if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group'   || $row->type == 'starRating' || $row->type == 'date' || $row->type == 'number') {
                        if (!isset($chartArray[$row->name])) {
                            $options = [];
                            if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group') {

                                foreach ($row->values as $value) {
                                    $options[$value->label] = 0;
                                }
                                if (isset($row->value)) {
                                    $options['other'] = 0;
                                }
                                if (isset($row->other)) {
                                    $options['other'] = 0;
                                }
                            } elseif ($row->type == 'starRating') {
                                $options = [
                                    '0' => 0, '0.5' => 0, '1' => 0, '1.5' => 0, '2' => 0, '2.5' => 0, '3' => 0, '3.5' => 0, '4' => 0, '4.5' => 0, '5' => 0,
                                ];
                            } elseif ($row->type == 'date') {
                                $options = [];
                            } else {
                                $row->chart_type = '';
                                $row->label = '';
                            }
                            $tmp = [
                                'name' => $row->name,
                                'label' => $row->label,
                                'options' => $options,
                                'chart_type' => $chartArray
                            ];
                            $chartArray[$row->name] = $tmp;
                        }
                        if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group') {
                            foreach ($row->values as $value) {
                                if (isset($value->selected)) {
                                    if (isset($chartArray[$row->name]['options'][$value->label])) {
                                        $chartArray[$row->name]['options'][$value->label]++;
                                    }
                                }
                            }
                            if (isset($row->value)) {
                                if (!isset($chartArray[$row->name]['options']['other'])) {
                                    $chartArray[$row->name]['options']['other'] = 0;
                                }
                                $chartArray[$row->name]['options']['other']++;
                            }
                        }
                        if ($row->type == 'starRating') {
                            if (isset($chartArray[$row->name]['options'][$row->value])) {
                                $chartArray[$row->name]['options'][$row->value]++;
                            }
                        }
                        if ($row->type == 'date') {
                            if (!isset($chartArray[$row->name]['options'][$row->value])) {
                                $chartArray[$row->name]['options'][$row->value] = 0;
                            }
                            $chartArray[$row->name]['options'][$row->value]++;
                        }
                    }
                }
            }
        }
        return $chartArray;
    }



    //start Google Calendar
    public static function colorCodeData($type)
    {
        if ($type == 'event') {
            return 1;
        } elseif ($type == 'zoom_meeting') {
            return 2;
        } elseif ($type == 'task') {
            return 3;
        } elseif ($type == 'appointment') {
            return 11;
        } elseif ($type == 'rotas') {
            return 3;
        } elseif ($type == 'holiday') {
            return 4;
        } elseif ($type == 'call') {
            return 10;
        } elseif ($type == 'meeting') {
            return 5;
        } elseif ($type == 'leave') {
            return 6;
        } elseif ($type == 'work_order') {
            return 7;
        } elseif ($type == 'lead') {
            return 7;
        } elseif ($type == 'deal') {
            return 8;
        } elseif ($type == 'interview_schedule') {
            return 9;
        } else {
            return 11;
        }
    }

    public static $colorCode = [
        1 => 'event-warning',
        2 => 'event-secondary',
        3 => 'event-info',
        4 => 'event-warning',
        5 => 'event-danger',
        6 => 'event-dark',
        7 => 'event-black',
        8 => 'event-info',
        9 => 'event-dark',
        10 => 'event-success',
        11 => 'event-warning',

    ];




    public function dataChart($form_id)
    {
        $chartArray = [];
        $form_values = FormValue::select('forms.json as form_json', 'form_values.*')->where('form_id', $form_id)->join('forms', 'forms.id', '=', 'form_values.form_id');
        $form_values = $form_values->get();
        foreach ($form_values as $form_value) {
            $array1 = json_decode($form_value->form_json);
            if (isset($array1)) {
                foreach ($array1 as $rows1) {
                    foreach ($rows1 as $row_key1 => $row1) {
                        if (isset($row1->is_enable_chart) && $row1->is_enable_chart) {
                            if (!isset($chartArray[$row1->name])) {
                                $options = [];
                                if ($row1->type == 'radio-group' || $row1->type == 'select' || $row1->type == 'checkbox-group') {
                                    foreach ($row1->values as $value) {
                                        $options[$value->label] = 0;
                                    }
                                    if (isset($row1->value)) {
                                        $options['other'] = 0;
                                    }
                                } elseif ($row1->type == 'starRating') {
                                    $options = [
                                        '0' => 0, '0.5' => 0, '1' => 0, '1.5' => 0, '2' => 0, '2.5' => 0, '3' => 0, '3.5' => 0, '4' => 0, '4.5' => 0, '5' => 0,
                                    ];
                                } elseif ($row1->type == 'date' || $row1->type == 'number') {
                                    $options = [];
                                }
                                if (isset($row1->is_enable_chart)) {
                                    $tmp = [
                                        'name' => $row1->name,
                                        'label' => $row1->label,
                                        'options' => $options,
                                        'is_enable_chart' => (property_exists($row1, 'is_enable_chart')) ? $row1->is_enable_chart : false,
                                        'chart_type' => $row1->chart_type
                                    ];
                                    $chartArray[$row1->name] = $tmp;
                                } else {
                                    $tmp = [
                                        'name' => $row1->name,
                                        'label' => $row1->label,
                                        'options' => $options,
                                        'chart_type' => $chartArray
                                    ];
                                    $chartArray[$row1->name] = $tmp;
                                }
                            }
                        }
                    }
                }
            }
            $array = json_decode($form_value->json);
            foreach ($array as $rows) {
                foreach ($rows as $row_key => $row) {
                    if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group'   || $row->type == 'starRating' || $row->type == 'date' || $row->type == 'number') {
                        if (!isset($chartArray[$row->name])) {
                            $options = [];
                            if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group') {
                                foreach ($row->values as $value) {
                                    $options[$value->label] = 0;
                                }
                                if (isset($row->value)) {
                                    $options['other'] = 0;
                                }
                                if (isset($row->other)) {
                                    $options['other'] = 0;
                                }
                            } elseif ($row->type == 'starRating') {
                                $options = [
                                    '0' => 0, '0.5' => 0, '1' => 0, '1.5' => 0, '2' => 0, '2.5' => 0, '3' => 0, '3.5' => 0, '4' => 0, '4.5' => 0, '5' => 0,
                                ];
                            } elseif ($row->type == 'date' || $row->type == 'number') {
                                $options = [];
                            }
                            if (isset($row->is_enable_chart)) {
                                $tmp = [
                                    'name' => $row->name,
                                    'label' => $row->label,
                                    'options' => $options,
                                    'is_enable_chart' => (property_exists($row, 'is_enable_chart')) ? $row->is_enable_chart : false,
                                    'chart_type' => $chartArray
                                ];
                                $chartArray[$row->name] = $tmp;
                            } else {
                                $tmp = [
                                    'name' => $row->name,
                                    'label' => $row->label,
                                    'options' => $options,
                                    'chart_type' => $chartArray
                                ];
                                $chartArray[$row->name] = $tmp;
                            }
                        }
                        if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group') {
                            foreach ($row->values as $value) {
                                if (isset($value->selected)) {
                                    $key = $row->name;
                                    $option = $value->label;
                                    if (!isset($chartArray[$key])) {
                                        $chartArray[$key] = ['options' => []];
                                    }
                                    if (!isset($chartArray[$key]['options'][$option])) {
                                        $chartArray[$key]['options'][$option] = 1;
                                    } else {
                                        $chartArray[$key]['options'][$option]++;
                                    }
                                }
                            }
                        }
                        if ($row->type == 'starRating') {
                            $chartArray[$row->name]['options'][$row->value]++;
                        }
                        if ($row->type == 'date' ||  $row->type == 'number') {
                            if (!isset($chartArray[$row->name]['options'][$row->value])) {
                                $chartArray[$row->name]['options'][$row->value] = 0;
                            }
                            $chartArray[$row->name]['options'][$row->value]++;
                        }
                    }
                }
            }
        }
        return $chartArray;
    }

    public function updateSettings($input)
    {
        foreach ($input as $key => $value) {
            settings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }

}
