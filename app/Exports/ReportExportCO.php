<?php

namespace App\Exports;

use App\Models\FormValue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\formRule;
use App\Models\FormValueDetail10;
use App\Models\formValuesReportcos;
use App\Models\FormValueDetailReportcos;
use Carbon\Carbon;

class ReportExportCO implements FromView
{
    public $company;
    public $rate;
    public $date;
    public $month;

    public function __construct($company, $rate, $date, $month)
    {
        $this->company    = $company;
        $this->rate       = $rate;
        $this->date = explode(',', $date); // Mengonversi string ke array
        $this->month       = $month;
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

        $table2 = formValuesReportcos::where('status', '1');
        $table3 = FormValueDetailReportcos::join('form_values_reportcos', 'form_values_reportcos.id', '=', 'form_value_detail_reportcos.form_values_id')
                ->where('form_values_reportcos.status', '1');
        $tourconsultant = formValuesReportcos::where('status', '1')->select('tour_consultant')
                ->distinct();
        $tcc = formValuesReportcos::where('status', '1')->select('tour_consultant')
                ->distinct();

        // $weekly1 = collect();
        // $weekly2 = collect();
        // $weekly3 = collect();
        // $weekly4 = collect();
        $weekly1 = FormValueDetailReportcos::join('form_values_reportcos', 'form_values_reportcos.id', '=', 'form_value_detail_reportcos.form_values_id')
        ->where('form_values_reportcos.status', '1');
        $weekly2 = FormValueDetailReportcos::join('form_values_reportcos', 'form_values_reportcos.id', '=', 'form_value_detail_reportcos.form_values_id')
        ->where('form_values_reportcos.status', '1');
        $weekly3 = FormValueDetailReportcos::join('form_values_reportcos', 'form_values_reportcos.id', '=', 'form_value_detail_reportcos.form_values_id')
        ->where('form_values_reportcos.status', '1');
        $weekly4 = FormValueDetailReportcos::join('form_values_reportcos', 'form_values_reportcos.id', '=', 'form_value_detail_reportcos.form_values_id')
        ->where('form_values_reportcos.status', '1');
        $overall = FormValueDetailReportcos::join('form_values_reportcos', 'form_values_reportcos.id', '=', 'form_value_detail_reportcos.form_values_id')
        ->where('form_values_reportcos.status', '1');
        $overall3 = FormValueDetailReportcos::join('form_values_reportcos', 'form_values_reportcos.id', '=', 'form_value_detail_reportcos.form_values_id')
        ->where('form_values_reportcos.status', '1');
        $overall2 = FormValueDetailReportcos::join('form_values_reportcos', 'form_values_reportcos.id', '=', 'form_value_detail_reportcos.form_values_id')
        ->where('form_values_reportcos.status', '1');
        $test = $this->date;

        if ($this->month && $this->date) {
            $formValues->whereMonth('form_values_reportcos.created_at', $this->month) 
                ->whereYear('form_values_reportcos.created_at', now()->year)
                ->whereBetween(\DB::raw('DAY(form_values_reportcos.created_at)'), $this->date);
            $table2->whereMonth('form_values_reportcos.created_at', $this->month) 
                ->whereYear('form_values_reportcos.created_at', now()->year)
                ->whereBetween(\DB::raw('DAY(form_values_reportcos.created_at)'), $this->date);
            $table3->whereMonth('form_values_reportcos.created_at', $this->month) 
                ->whereYear('form_values_reportcos.created_at', now()->year)
                ->whereBetween(\DB::raw('DAY(form_values_reportcos.created_at)'), $this->date);
            $tourconsultant->whereMonth('form_values_reportcos.created_at', $this->month) 
                ->whereYear('form_values_reportcos.created_at', now()->year)
                ->whereBetween(\DB::raw('DAY(form_values_reportcos.created_at)'), $this->date);
            $tcc->whereMonth('form_values_reportcos.created_at', $this->month) 
                ->whereYear('form_values_reportcos.created_at', now()->year)
                ->whereBetween(\DB::raw('DAY(form_values_reportcos.created_at)'), $this->date);
            $weekly1->whereMonth('form_value_detail_reportcos.created_at', $this->month) // Bulan Oktober
                ->whereYear('form_value_detail_reportcos.created_at', now()->year) // Tahun saat ini
                ->whereBetween(\DB::raw('DAY(form_value_detail_reportcos.created_at)'), [1, 8])->get();
            $weekly2->whereMonth('form_value_detail_reportcos.created_at', $this->month) // Bulan Oktober
                ->whereYear('form_value_detail_reportcos.created_at', now()->year) // Tahun saat ini
                ->whereBetween(\DB::raw('DAY(form_value_detail_reportcos.created_at)'), [9, 15])->get();
            $weekly3->whereMonth('form_value_detail_reportcos.created_at', $this->month) // Bulan Oktober
                ->whereYear('form_value_detail_reportcos.created_at', now()->year) // Tahun saat ini
                ->whereBetween(\DB::raw('DAY(form_value_detail_reportcos.created_at)'), [16, 22])->get();
            $weekly4->whereMonth('form_value_detail_reportcos.created_at', $this->month) // Bulan Oktober
                ->whereYear('form_value_detail_reportcos.created_at', now()->year) // Tahun saat ini
                ->whereBetween(\DB::raw('DAY(form_value_detail_reportcos.created_at)'), [23, 31])->get();
            $overall->whereMonth('form_value_detail_reportcos.created_at', $this->month) // Bulan Oktober
                ->whereYear('form_value_detail_reportcos.created_at', now()->year);
            $overall3->whereMonth('form_value_detail_reportcos.created_at', $this->month) // Bulan Oktober
                ->whereYear('form_value_detail_reportcos.created_at', now()->year) // Tahun saat ini
                ->whereBetween(\DB::raw('DAY(form_value_detail_reportcos.created_at)'), [1, 22])->get();
            $overall2->whereMonth('form_value_detail_reportcos.created_at', $this->month) // Bulan Oktober
                ->whereYear('form_value_detail_reportcos.created_at', now()->year) // Tahun saat ini
                ->whereBetween(\DB::raw('DAY(form_value_detail_reportcos.created_at)'), [1, 15])->get();
        } else if ($this->company) {
            $formValues->where('company_name', $this->company);
            $table2->where('company_name', $this->company);
            $table3->where('company_name', $this->company);
            $tourconsultant->where('company_name', $this->company);
            $tcc->where('company_name', $this->company);
        } else if ($this->rate) {
            $formValues->where('rate_label', $this->rate);
            $table2->where('rate_label', $this->rate);
            $table3->where('rate_label', $this->rate);
            $tourconsultant->where('rate_label', $this->rate);
            $tcc->where('rate_label', $this->rate);
        }

        $formValues = $formValues->get();
        $table2 = $table2->get();
        $table3 = $table3->get();
        $tourconsultant = $tourconsultant->get();
        $tcc = $tcc->get();
    return view('export.reportco', ['formvalues' => $formValues],compact('table2', 'table3', 'tourconsultant', 'weekly1',
            'weekly2', 'weekly3', 'weekly4', 'tcc', 'test', 'overall', 'overall3', 'overall2'));
    }
}
