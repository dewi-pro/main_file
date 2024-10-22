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
                        ->groupBy('form_rules.condition');
        } else {
            $formValues = FormValue::where('user_id', \Auth::user()->id);
        }
        
        $form = Form::where('type', '=', 'Tour');
        $destination = Form::where('type', '=', 'Tour');    
        $overall = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
            ->join('forms', 'forms.id', '=', 'form_values.form_id');   
        $overallindex = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id');

        $valueDetail1 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where('label', 'like', '1.%');

        $valueDetail2 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where('label', 'like', '2.%');

        $valueDetail3 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where('label', 'like', '3.%');

        $valueDetail4 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where('label', 'like', '4.%');

        $valueDetail5 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where('label', 'like', '5.%');

        $valueDetail6 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where('label', 'like', '6.%');

        $valueDetail7 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where('label', 'like', '7.%');

        $valueDetail8 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where('label', 'like', '8.%');

        $valueDetail9 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where('label', 'like', '9.%');

        $valueDetail10 = FormValueDetail10::join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where('label', 'like', '10.%');

        $valueindex1 = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('if_json', 'like', '1.%');

        $valueindex2 = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('if_json', 'like', '2.%');

        $valueindex3 = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('if_json', 'like', '3.%');

        $valueindex4 = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('if_json', 'like', '4.%');

        $valueindex5 = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('if_json', 'like', '5.%');
            
        $valueindex6 = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('if_json', 'like', '6.%');

        $valueindex7 = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('if_json', 'like', '7.%');

        $valueindex8 = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('if_json', 'like', '8.%');

        $valueindex9 = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('if_json', 'like', '9.%');

        $valueindex10 = formRule::join('form_values', 'form_values.id', '=', 'form_rules.condition')
            ->join('forms', 'forms.id', '=', 'form_values.form_id')
            ->where('if_json', 'like', '10.%');
        

        if ($this->startDate && $this->endDate) {
            $formValues->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $form->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $destination->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $overall->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $overallindex->whereBetween('end_tour', [$this->startDate, $this->endDate]);

            $valueDetail1->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueDetail2->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueDetail3->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueDetail4->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueDetail5->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueDetail6->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueDetail7->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueDetail8->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueDetail9->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueDetail10->whereBetween('end_tour', [$this->startDate, $this->endDate]);

            $valueindex1->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueindex2->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueindex3->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueindex4->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueindex5->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueindex6->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueindex7->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueindex8->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueindex9->whereBetween('end_tour', [$this->startDate, $this->endDate]);
            $valueindex10->whereBetween('end_tour', [$this->startDate, $this->endDate]);
        } else if ($this->cat_id) {
            $formValues->where('category_id', $this->cat_id);
            $form->where('category_id', $this->cat_id);
            $destination->where('category_id', $this->cat_id);
            $overall->where('category_id', $this->cat_id);
            $overallindex->where('category_id', $this->cat_id);

            $valueDetail1->where('category_id', $this->cat_id);
            $valueDetail2->where('category_id', $this->cat_id);
            $valueDetail3->where('category_id', $this->cat_id);
            $valueDetail4->where('category_id', $this->cat_id);
            $valueDetail5->where('category_id', $this->cat_id);
            $valueDetail6->where('category_id', $this->cat_id);
            $valueDetail7->where('category_id', $this->cat_id);
            $valueDetail8->where('category_id', $this->cat_id);
            $valueDetail9->where('category_id', $this->cat_id);
            $valueDetail10->where('category_id', $this->cat_id);

            $valueindex1->where('category_id', $this->cat_id);
            $valueindex2->where('category_id', $this->cat_id);
            $valueindex3->where('category_id', $this->cat_id);
            $valueindex4->where('category_id', $this->cat_id);
            $valueindex5->where('category_id', $this->cat_id);
            $valueindex6->where('category_id', $this->cat_id);
            $valueindex7->where('category_id', $this->cat_id);
            $valueindex8->where('category_id', $this->cat_id);
            $valueindex9->where('category_id', $this->cat_id);
            $valueindex10->where('category_id', $this->cat_id);
        }  else if ($this->clu_id) {
            $formValues->where('cluster_id', $this->clu_id);
            $form->where('cluster_id', $this->clu_id);
            $destination->where('cluster_id', $this->clu_id);
            $overall->where('cluster_id', $this->clu_id);
            $overallindex->where('cluster_id', $this->clu_id);

            $valueDetail1->where('cluster_id', $this->clu_id);
            $valueDetail2->where('cluster_id', $this->clu_id);
            $valueDetail3->where('cluster_id', $this->clu_id);
            $valueDetail4->where('cluster_id', $this->clu_id);
            $valueDetail5->where('cluster_id', $this->clu_id);
            $valueDetail6->where('cluster_id', $this->clu_id);
            $valueDetail7->where('cluster_id', $this->clu_id);
            $valueDetail8->where('cluster_id', $this->clu_id);
            $valueDetail9->where('cluster_id', $this->clu_id);
            $valueDetail10->where('cluster_id', $this->clu_id);

            $valueindex1->where('cluster_id', $this->clu_id);
            $valueindex2->where('cluster_id', $this->clu_id);
            $valueindex3->where('cluster_id', $this->clu_id);
            $valueindex4->where('cluster_id', $this->clu_id);
            $valueindex5->where('cluster_id', $this->clu_id);
            $valueindex6->where('cluster_id', $this->clu_id);
            $valueindex7->where('cluster_id', $this->clu_id);
            $valueindex8->where('cluster_id', $this->clu_id);
            $valueindex9->where('cluster_id', $this->clu_id);
            $valueindex10->where('cluster_id', $this->clu_id);
        }  else if ($this->lea_id) {
            $formValues->where('leader_id', $this->lea_id);
            $form->where('leader_id', $this->lea_id);
            $destination->where('leader_id', $this->lea_id);
            $overall->where('leader_id', $this->lea_id);
            $overallindex->where('leader_id', $this->lea_id);

            $valueDetail1->where('leader_id', $this->lea_id);
            $valueDetail2->where('leader_id', $this->lea_id);
            $valueDetail3->where('leader_id', $this->lea_id);
            $valueDetail4->where('leader_id', $this->lea_id);
            $valueDetail5->where('leader_id', $this->lea_id);
            $valueDetail6->where('leader_id', $this->lea_id);
            $valueDetail7->where('leader_id', $this->lea_id);
            $valueDetail8->where('leader_id', $this->lea_id);
            $valueDetail9->where('leader_id', $this->lea_id);
            $valueDetail10->where('leader_id', $this->lea_id);

            $valueindex1->where('leader_id', $this->lea_id);
            $valueindex2->where('leader_id', $this->lea_id);
            $valueindex3->where('leader_id', $this->lea_id);
            $valueindex4->where('leader_id', $this->lea_id);
            $valueindex5->where('leader_id', $this->lea_id);
            $valueindex6->where('leader_id', $this->lea_id);
            $valueindex7->where('leader_id', $this->lea_id);
            $valueindex8->where('leader_id', $this->lea_id);
            $valueindex9->where('leader_id', $this->lea_id);
            $valueindex10->where('leader_id', $this->lea_id);
        }     

        $formValues = $formValues->get();
        $form = $form->get();
        $destination = $destination->get();
        $overall = $overall->get();
        $overallindex = $overallindex->get();

        $valueDetail = $valueDetail1->get();
        $valueDetail2 = $valueDetail2->get();
        $valueDetail3 = $valueDetail3->get();
        $valueDetail4 = $valueDetail4->get();
        $valueDetail5 = $valueDetail5->get();
        $valueDetail6 = $valueDetail6->get();
        $valueDetail7 = $valueDetail7->get();
        $valueDetail8 = $valueDetail8->get();
        $valueDetail9 = $valueDetail9->get();
        $valueDetail10 = $valueDetail10->get();

        $value11 = $valueindex1->get();
        $valueindex2 = $valueindex2->get();
        $valueindex3 = $valueindex3->get();
        $valueindex4 = $valueindex4->get();
        $valueindex5 = $valueindex5->get();
        $valueindex6 = $valueindex6->get();
        $valueindex7 = $valueindex7->get();
        $valueindex8 = $valueindex8->get();
        $valueindex9 = $valueindex9->get();
        $valueindex10 = $valueindex10->get();

          
    return view('export.formvalue', ['formvalues' => $formValues], compact('valueDetail', 'valueDetail2', 'valueDetail3', 'valueDetail4', 'valueDetail5', 'valueDetail6',
         'valueDetail7', 'valueDetail8', 'valueDetail9', 'valueDetail10', 'form', 'value11', 'valueindex2', 'valueindex3', 'valueindex4', 'valueindex5', 'valueindex6', 'valueindex7', 'valueindex8', 'valueindex9', 'valueindex10', 'overall', 
          'overallindex', 'destination'));
    }
}
