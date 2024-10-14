<?php

namespace App\Exports;

use App\Models\FormValue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\formRule;
use App\Models\FormValueDetail10;
use App\Models\Form;


class ReportExport implements FromView
{
    public $startDate;
    public $endDate;
    public $user;
    public $cat_id;
    public $clu_id;
    public $lea_id;
    public $form1;

    public function __construct($startDate, $endDate, $user, $cat_id, $clu_id, $lea_id, $form1 )
    {
        $this->startDate    = $startDate;
        $this->endDate      = $endDate;
        $this->user         = $user;
        $this->cat_id       = $cat_id;
        $this->clu_id       = $clu_id;
        $this->lea_id       = $lea_id;
        $this->form1       = $form1;

    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        if (\Auth::user()->type == 'Admin') {
            $formValues = FormValue::select('form_values.*','forms.tour_leader_name', 'forms.destination', 'forms.title', \DB::raw('AVG(form_rules.rule_name) AS sum'),)
                        ->join('form_rules', 'form_rules.condition', '=', 'form_values.id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('forms.end_tour', '>=', $this->startDate)
                        ->where('forms.end_tour', '<=', $this->endDate)
                        ->where('forms.category_id', $this->cat_id)
                        ->groupBy('form_rules.condition');
        } else {
            $formValues = FormValue::where('user_id', \Auth::user()->id);
        }
        $formValues = $formValues->get();
        
        $form = Form::where('forms.end_tour', '>=', $this->startDate)
            ->where('forms.end_tour', '<=', $this->endDate)
            ->where('category_id', $this->cat_id)
            ->get('tour_leader_name', 'id');
            
            $value1 = formRule::select(\DB::raw('avg(rule_name) as total'),)
            ->join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('end_tour', '>=', $this->startDate)
            ->where('end_tour', '<=', $this->endDate)
            ->where('if_json', 'like', '1.%')
            ->where('category_id', $this->cat_id)
            ->get();

            $value2 = formRule::select(\DB::raw('avg(rule_name) as total'),)
            ->join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('end_tour', '>=', $this->startDate)
            ->where('end_tour', '<=', $this->endDate)
            ->where('if_json', 'like', '2.%')
            ->where('category_id', $this->cat_id)
            ->get();

            $value3 = formRule::select(\DB::raw('avg(rule_name) as total'),)
            ->join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('end_tour', '>=', $this->startDate)
            ->where('end_tour', '<=', $this->endDate)
            ->where('if_json', 'like', '3.%')
            ->where('category_id', $this->cat_id)
            ->get();

            $value4 = formRule::select(\DB::raw('avg(rule_name) as total'),)
            ->join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('end_tour', '>=', $this->startDate)
            ->where('end_tour', '<=', $this->endDate)
            ->where('if_json', 'like', '4.%')
            ->where('category_id', $this->cat_id)
            ->get();

            $value5 = formRule::select(\DB::raw('avg(rule_name) as total'),)
            ->join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('end_tour', '>=', $this->startDate)
            ->where('end_tour', '<=', $this->endDate)
            ->where('if_json', 'like', '5.%')
            ->where('category_id', $this->cat_id)
            ->get();

            $value6 = formRule::select(\DB::raw('avg(rule_name) as total'),)
            ->join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('end_tour', '>=', $this->startDate)
            ->where('end_tour', '<=', $this->endDate)
            ->where('if_json', 'like', '6.%')
            ->where('category_id', $this->cat_id)
            ->get();

            $value7 = formRule::select(\DB::raw('avg(rule_name) as total'),)
            ->join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('end_tour', '>=', $this->startDate)
            ->where('end_tour', '<=', $this->endDate)
            ->where('if_json', 'like', '7.%')
            ->where('category_id', $this->cat_id)
            ->get();

            $value8 = formRule::select(\DB::raw('avg(rule_name) as total'),)
            ->join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('end_tour', '>=', $this->startDate)
            ->where('end_tour', '<=', $this->endDate)
            ->where('if_json', 'like', '8.%')
            ->where('category_id', $this->cat_id)
            ->get();

            $value9 = formRule::select(\DB::raw('avg(rule_name) as total'),)
            ->join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('end_tour', '>=', $this->startDate)
            ->where('end_tour', '<=', $this->endDate)
            ->where('if_json', 'like', '9.%')
            ->where('category_id', $this->cat_id)
            ->get();

            $value10 = formRule::select(\DB::raw('avg(rule_name) as total'),)
            ->join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('end_tour', '>=', $this->startDate)
            ->where('end_tour', '<=', $this->endDate)
            ->where('if_json', 'like', '10.%')
            ->where('category_id', $this->cat_id)
            ->get();

        $valueDetail = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '1.%')
                        ->where('category_id', $this->cat_id)
                        ->get();
       
        $valueDetail2 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '2.%')
                        ->where('category_id', $this->cat_id)
                        ->get();

        $valueDetail3 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '3.%')
                        ->where('category_id', $this->cat_id)
                        ->get();

        $valueDetail4 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '4.%')
                        ->where('category_id', $this->cat_id)
                        ->get();
        $valueDetail5 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '5.%')
                        ->where('category_id', $this->cat_id)
                        ->get();
        $valueDetail6 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '6.%')
                        ->where('category_id', $this->cat_id)
                        ->get();
        $valueDetail7 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '7.%')
                        ->where('category_id', $this->cat_id)
                        ->get();
        $valueDetail8 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '8.%')
                        ->where('category_id', $this->cat_id)
                        ->get();
        $valueDetail9 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '9.%')
                        ->where('category_id', $this->cat_id)
                        ->get();
        $valueDetail10 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '10.%')
                        ->where('category_id', $this->cat_id)
                        ->get();

        $valueDetail11 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '1.%')
                        ->where('category_id', $this->cat_id)
                        ->get();       
        
        $valueDetail12 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '2.%')
                        ->where('category_id', $this->cat_id)
                        ->get();  
        $valueDetail13 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '3.%')
                        ->where('category_id', $this->cat_id)
                        ->get();  
        $valueDetail14 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '4.%')
                        ->where('category_id', $this->cat_id)
                        ->get(); 
        $valueDetail15 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '5.%')
                        ->where('category_id', $this->cat_id)
                        ->get();         
        $valueDetail16 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '6.%')
                        ->where('category_id', $this->cat_id)
                        ->get(); 
        $valueDetail17 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '7.%')
                        ->where('category_id', $this->cat_id)
                        ->get();         
        $valueDetail18 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '8.%')
                        ->where('category_id', $this->cat_id)
                        ->get(); 
        $valueDetail19 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '9.%')
                        ->where('category_id', $this->cat_id)
                        ->get(); 
        $valueDetail20 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('end_tour', '>=', $this->startDate)
                        ->where('end_tour', '<=', $this->endDate)
                        ->where('label', 'like', '10.%')
                        ->where('category_id', $this->cat_id)
                        ->get(); 

    return view('export.formvalue', ['formvalues' => $formValues], compact('valueDetail', 'valueDetail2', 'valueDetail3', 'valueDetail4', 'valueDetail5', 'valueDetail6',
         'valueDetail7', 'valueDetail8', 'valueDetail9', 'valueDetail10', 'valueDetail11', 'valueDetail12', 'valueDetail13', 'valueDetail14', 'valueDetail15', 'valueDetail16'
         , 'valueDetail17', 'valueDetail18', 'valueDetail19', 'valueDetail20', 'form', 'value1', 'value2', 'value3', 'value4', 'value5', 'value6', 'value7', 'value8', 'value9', 'value10'));
    }
}
