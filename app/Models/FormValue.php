<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class FormValue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['form_id', 'user_id', 'json', 'transaction_id', 'currency_symbol', 'form_edit_lock_status','currency_name', 'status', 'amount', 'payment_type','transfer_slip' , 'form_status',
    'submited_forms_ip','submited_forms_country','submited_forms_region','submited_forms_city','submited_forms_latitude','submited_forms_longitude'];

    public function Form()
    {
        return $this->hasOne('App\Models\Form', 'id', 'form_id');
    }

    public function User()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function getFormArray()
    {
        return json_decode($this->json);
    }

    public function createPDF()
    {
        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle($this->Form->title);
        $pdf->setHeaderFont(['helvetica', '', 10]);
        $pdf->setFooterFont(['helvetica', '', 10]);
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetHeaderMargin(5);
        $pdf->setFontSubsetting(true);
        $pdf->AddPage();
        $pdf->setJPEGQuality(75);
        $setY = 20;
        $pdf->SetY($setY);
        $ValuForm_array = json_decode($this->json);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if ($this->Form->logo) {
            $pdf->Image(Storage::url($this->Form->logo), 10, 20, 80, 30, 'PNG');
            $setY += 40;
            $pdf->SetY($setY);
        }
        $pdf->SetFont('helvetica', '', 20);
        $pdf->Cell(170, 1, $this->Form->title, 0, 0, '', 0, '', 0, false, 'T', 'M');
        $setY += 10;
        $pdf->SetY($setY);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(170, 1, ($this->created_at->format('d M Y') . " / " . (($this->User) ? $this->User->name : '')), 0, 0, '', 0, '', 0, false, 'T', 'M');
        $setY += 10;
        $pdf->SetY($setY);
        $pdf->SetFont('helvetica', '', 14);
        $html = '
                    <table width="100%" border="1" cellpadding="5">

                    </table>
                    ';

        $html .= '<p></p><table width="100%" border="1" cellpadding="5"><tbody>';
        $skip = 0;
        $formRule = formRule::where('form_id', $this->form_id)->get();
        $hideFields = [];

        // foreach ($formRule as $rule) {
        //     $thenJsonData = json_decode($rule->then_json, true);
        //     if (is_array($thenJsonData)) {
        //         foreach ($thenJsonData as $condition) {
        //             if ($condition['else_rule_type'] === 'hide') {
        //                 $hideFields = array_merge($hideFields, $condition['else_field_name']);
        //             }
        //         }
        //     }
        // }
        foreach ($ValuForm_array as $value) {
            foreach ($value as $data) {
                if ($skip) {
                    $skip--;
                    continue;
                }
                // $fieldHidden = false;
                // if (in_array($data->name, $hideFields)) {
                //     $fieldHidden = true;
                // }

                if (isset($data->value) || isset($data->values)) {
                    if ($data->type == "starRating") {
                        // if (!$fieldHidden) {
                            $html .= '<tr><td><span style="font-size: 14px">' . str_replace('&nbsp;', ' ', $data->label) . '</span><div style="font-size: 25px;font-weight: bold">';
                            $starNumber = $data->value;
                            $final_stars = isset($data->number_of_star) ? $data->number_of_star : 5;
                            for ($x = 1; $x <= $starNumber; $x++) {
                                $html .= '<img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/full.png') . '">';
                            }
                            if (strpos($starNumber, '.')) {
                                $starNumber_array = explode(".", $starNumber);
                                /* half start */
                                if ($starNumber_array[1] > 0) {
                                    $html .= '<img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/half.png') . '">';
                                    $x++;
                                }
                            }
                            while ($x <= $final_stars) {
                                $html .= '<img style="height:17px;padding-left:20px;" src="' . asset('assets/images/ratings/empty.png') . '">';
                                $x++;
                            }
                            $html .= '</div></td></tr>';
                        // }
                    } else if ($data->type == 'SignaturePad') {
                        // if (!$fieldHidden) {
                            $html .= '<tr><td style="height: 200px;">' . $data->label . '<br><div><img src="' . Storage::url($data->value) . '"></div></td></tr>';
                        // }
                    } elseif ($data->type == 'location') {
                        // if (!$fieldHidden) {
                            $value = $data->value;
                            $html .= '<tr><td style="height: 100px;">' . $data->label . '<br><a target="_blank" style="margin-top:15px;" href="http://www.google.com/maps/place/' . $value . '"><img style="height:40px; margin-top:10px;" src="' . asset('assets/images/map.jpg') . '"></a></td></tr>';
                        // }
                    } elseif ($data->type == 'video') {
                        // if (!$fieldHidden) {
                            $html .= '<tr><td style="height: 100px;">' . $data->label . '<br><a href="' . route('selfie.image.download', $this->id) . '"><button style="padding:10px; background-color: #584ED2;" id="downloadButton">Download Video</button></a></td></tr>';
                        // }
                    } elseif ($data->type == 'selfie') {
                        // if (!$fieldHidden) {
                            $html .= '<tr><td style="height: 100px;">' . $data->label . '<br><a href="' . route('selfie.image.download', $this->id) . '"><button style="padding:10px; background-color: #584ED2;" id="downloadButton">Download Image</button></a></td></tr>';
                        // }
                    } elseif ($data->type == 'autocomplete') {
                        // if (!$fieldHidden) {
                            $html .= '<tr><td style="height: 100px;">' . $data->label . '<br><span>'.$data->value .'</span></td></tr>';
                        // }
                    }else if (isset($data->values)) {
                        // if (!$fieldHidden) {

                            $html .= '<tr><td><span style="font-size: 14px">' . str_replace('&nbsp;', ' ', $data->label) . '</span><div style="font-size: 18px">';
                            $value = '';
                            foreach ($data->values as $sub_data) {
                                if ($data->type == "checkbox-group") {
                                    if (isset($sub_data->selected)) {
                                        $html .= '<br><img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/checked.png') . '"> ' . $sub_data->label;
                                        $value .= $sub_data->label . ', ';
                                    } else {
                                        $html .= '<br><img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/unchecked.png') . '"> ' . $sub_data->label;
                                    }
                                } else {
                                    if (isset($sub_data->selected)) {
                                        $html .=  $sub_data->label;
                                        $value .= $sub_data->label . ', ';
                                    }
                                }
                            }
                            $html .= '</div></td></tr>';
                            $value = rtrim($value, ', ');
                        // }
                    } else {
                        if ($data->type == "file") {
                            // if (!$fieldHidden) {

                                $html .= '<tr><td><span style="font-size: 14px">' . str_replace('&nbsp;', ' ', $data->label) . '</span><div style="font-size: 18px"><br>';
                                if (!empty($data->value)) {
                                    if (is_array($data->value)) {
                                        if (isset($data->file_extention) && $data->file_extention == 'image') {
                                            $table_html = '<table width="100%" border="0" cellpadding="2"><tbody><tr>';
                                            foreach ($data->value as $k => $val) {
                                                $table_html .= '<td><img width="320px" src="' . Storage::url($val) . '"/></td>';
                                                if ((($k + 1) % 2) == 0) {
                                                    $table_html .= "</tr><tr>";
                                                }
                                            }
                                            while ((($k + 1) % 2) == 0) {
                                                $table_html .= '<td></td>';
                                                $k++;
                                            }
                                            $table_html .= '</tr></tbody></table>';
                                            $html .= $table_html;
                                        } else {
                                            $table_html = '<table width="100%" border="0" cellpadding="2"><tbody><tr>';
                                            foreach ($data->value as $k => $val) {
                                                $file_name = explode('/', $val);
                                                $file_name = end($file_name);
                                                $table_html .= '<td> <div class="col-6"> <a class="btn btn-info my-2" type="image" download="" style="background-color: #3ec9d6;" href="' . Storage::url($val) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '')  . '  </a> </div> </td>';
                                                if ((($k + 1) % 2) == 0) {
                                                    $table_html .= "</tr><tr>";
                                                }
                                            }
                                            while ((($k + 1) % 2) == 0) {
                                                $table_html .= '<td></td>';
                                                $k++;
                                            }
                                            $table_html .= '</tr></tbody></table>';
                                            $html .= $table_html;
                                        }
                                    } elseif (is_object($data->value)) {
                                        $data->value = json_decode(json_encode($data->value), true);
                                        $table_html = '<table width="100%" border="0" cellpadding="2"><tbody><tr>';
                                        foreach ($data->value as $k => $val) {
                                            $table_html .= '<td><img width="320px" src="' . Storage::url($val) . '"/></td>';
                                            if ((($k + 1) % 2) == 0) {
                                                $table_html .= "</tr><tr>";
                                            }
                                        }
                                        while ((($k + 1) % 2) == 0) {
                                            $table_html .= '<td></td>';
                                            $k++;
                                        }
                                        $table_html .= '</tr></tbody></table>';
                                        $html .= $table_html;
                                    } else {
                                        if ($data->file_extention == 'image') {
                                            $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                            $html .= '<td><img width="320px" src="' . Storage::url($data->value) . '"/></td>';
                                            $html .= '</tr></table>';
                                        } else {
                                            $file_name = explode('/', $data->value);
                                            $file_name = end($file_name);
                                            $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                            $html .= '<td> <div class="row"> <div class="col-6" style="flex: 0 0 auto;width: 50%;"> <a class="btn btn-info my-2" type="image" download="" style="background-color: #3ec9d6; color: #ffffff; background-color: #3ec9d6; border-color: #3ec9d6;" href="' . Storage::url($data->value) . '">' . substr($file_name, 0, 30) . (strlen($file_name) > 30 ? '...' : '') . ' </a> </div> </div> </td>';
                                            $html .= '</tr></table>';
                                        }
                                    }
                                }
                                $html .= '</div></td></tr>';
                            // }
                        } else {
                            if ($data->label == 'Color') {
                                // if (!$fieldHidden) {
                                    $html .= '<tr><td style="height:50px">' . $data->label . '<br><div style="background-color:' . $data->value . ';"></div></td></tr>';
                                // }
                            } else {
                                // if (!$fieldHidden) {
                                    $html .= '<tr><td><span style="font-size: 14px">' . str_replace('&nbsp;', ' ', $data->label) . '</span><div style="font-size: 18px">' . $data->value . '</div></td></tr>';
                                // }
                            }
                        }
                    }
                } else if ($data->type == "header") {
                    // if (!$fieldHidden) {
                        if (isset($data->selected) && $data->selected) {
                            $skip = intval($data->number_of_control);
                            $html .= '<tr><td><span style="font-size: 20px;font-weight: bold">' . str_replace('&nbsp;', ' ', $data->label) . '</span> - ' . __('N/A') . '</td></tr>';
                        } else {
                            $html .= '<tr><td><span style="font-size: 20px;font-weight: bold">' . str_replace('&nbsp;', ' ', $data->label) . '</span></td></tr>';
                        }
                    // }
                } else {
                    // $html .= '<tr><td><span style="font-size: 14px">' . str_replace('&nbsp;', ' ', $data->label) . '</span><div style="font-size: 18px"></div></td></tr>';
                }
            }
        }
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($this->Form->title . '_' . (($this->User) ? $this->User->name : '') . '_' . $this->created_at . '.pdf', 'D');
    }

    public function columns()
    {
        $columns = [];
        $data = json_decode($this->json, true);
        foreach ($data as $page) {
            $columns = array_merge($columns, array_column($page, 'label'));
        }
        return $columns;
    }
}
