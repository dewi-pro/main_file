<?php

namespace App\Exports;

use App\Models\FormValue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\formRule;
use App\Models\FormValueDetail10;
use App\Models\formValuesReportcos;


class ReportExportCO implements FromView
{
    public $startDate;
    public $endDate;
    public $company;
    public $rate;

    public function __construct($startDate, $endDate, $company, $rate)
    {
        $this->startDate  = $startDate;
        $this->endDate    = $endDate;
        $this->company    = $company;
        $this->rate       = $rate;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        if (\Auth::user()->type == 'Admin') {
            $formValues = formValuesReportcos::where('status', '1');
        } else {
            $formValues = FormValue::where('user_id', \Auth::user()->id);
        }

        if ($this->startDate && $this->endDate) {
            $formValues->whereBetween('created_at', [$this->startDate, $this->endDate]);
        } else if ($this->company) {
            $formValues->where('company_name', $this->company);
        } else if ($this->rate) {
            $formValues->where('rate_label', $this->rate);
        }

        $formValues = $formValues->get();
        
    return view('export.reportco', ['formvalues' => $formValues]);
    }
}
