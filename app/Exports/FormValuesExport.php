<?php

namespace App\Exports;

use App\Models\FormValue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\formRule;
use App\Models\FormValueDetail10;
use App\Models\Form;


class FormValuesExport implements FromView
{
    public $request;
    public $startDate;
    public $endDate;
    public $user;
    // public $name;
    public function __construct($request, $startDate, $endDate, $user)
    {
        $this->request      = $request;
        $this->startDate    = $startDate;
        $this->endDate      = $endDate;
        $this->user         = $user;
        // $this->name         = $name;

    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        if (\Auth::user()->type == 1) {
            $formValues = FormValue::select('form_values.*','forms.tour_leader_name', 'forms.destination', 'forms.title', \DB::raw('AVG(form_rules.rule_name) AS sum'),)
                        ->join('form_rules', 'form_rules.condition', '=', 'form_values.id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('form_values.form_id', $this->request->form_id)
                        ->groupBy('form_rules.condition');
        } else {
            $formValues = FormValue::where('form_id', $this->request->form_id)->where('user_id', \Auth::user()->id);
        }
        if ($this->startDate && $this->endDate) {
            $formValues->whereBetween('form_values.created_at', [$this->startDate, $this->endDate]);
        } else if ($this->user) {
            $formValues->where('user_id', $this->user);
        }

        $formValues = $formValues->get();
        
        $form = Form::where('id', $this->request->form_id)->get('tour_leader_name');

        $valueDetail = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->join('forms', 'forms.id', '=', 'form_values.form_id')
                        ->where('label', 'like', '1.%')
                        ->where('form_id', '=', [$this->request->form_id])->get();
        $valueDetail2 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '2.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail3 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '3.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail4 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '4.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail5 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '5.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail6 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '6.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail7 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '7.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail8 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '8.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail9 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '9.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail10 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '10.%')
                        ->where('form_id', '=', $this->request->form_id)->get();

        $valueDetail11 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '1.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail12 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '2.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail13 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '3.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail14 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '4.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail15 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '5.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail16 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '6.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail17 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '7.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail18 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '8.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail19 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '9.%')
                        ->where('form_id', '=', $this->request->form_id)->get();
        $valueDetail20 = FormValueDetail10::select(\DB::raw('SUM(satisfied + failry_satisfied) AS sum'),)
                        ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                        ->where('label', 'like', '10.%')
                        ->where('form_id', '=', $this->request->form_id)->get();

    return view('export.formvalue', ['formvalues' => $formValues], compact('valueDetail', 'valueDetail2', 'valueDetail3', 'valueDetail4', 'valueDetail5', 'valueDetail6',
         'valueDetail7', 'valueDetail8', 'valueDetail9', 'valueDetail10', 'valueDetail11', 'valueDetail12', 'valueDetail13', 'valueDetail14', 'valueDetail15', 'valueDetail16'
         , 'valueDetail17', 'valueDetail18', 'valueDetail19', 'valueDetail20', 'form'));
    }
}
