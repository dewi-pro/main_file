<?php

namespace App\Exports;

use App\Models\FormValue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FormValuesExport implements FromView
{
    public $request;
    public $startDate;
    public $endDate;
    public $user;



    public function __construct($request, $startDate, $endDate, $user)
    {
        $this->request      = $request;
        $this->startDate    = $startDate;
        $this->endDate      = $endDate;
        $this->user         = $user;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        if (\Auth::user()->type == 'Admin') {
            $formValues = FormValue::where('form_id', $this->request->form_id);
        } else {
            $formValues = FormValue::where('form_id', $this->request->form_id)->where('user_id', \Auth::user()->id);
        }
        if ($this->startDate && $this->endDate) {
            $formValues->whereBetween('form_values.created_at', [$this->startDate, $this->endDate]);
        } else if ($this->user) {
            $formValues->where('user_id', $this->user);
        }
        $formValues = $formValues->get();
        return view('export.formvalue', [
            'formvalues' => $formValues
        ]);
    }
}
