@php
    $currantColumn = [];
@endphp

<table>
    <tbody>
        <tr>
            <th>{{ __('Date Submitted') }}</th>
            <th>{{ __('Company Name') }}</th>
            <th>{{ __('Full Name') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Rate Services') }}</th>
            <th>{{ __('Comment') }}</th>
            <th>{{ __('Tour Consultant') }}</th>
        </tr> 
        @foreach ($formvalues as $key => $formvalues)
        <tr>
            <td>{{$formvalues->created_at}}</td>
            <td>{{$formvalues->company_name}}</td>
            <td>{{$formvalues->full_name}}</td>
            <td>{{$formvalues->email}}</td>
            <td>{{$formvalues->rate_label}}</td>
            <td>{{$formvalues->comment}}</td>
            <td>{{$formvalues->tour_consultant}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('RESPONDENT') }}</th>
            <th>{{ __('TC') }}</th>
            <th>{{ __('Rate Services') }}</th>
            <th></th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Less Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
            <th>{{ __('Check') }}</th>
        </tr> 
        @foreach ($tourconsultant as $key => $tourconsultant)
        <tr>
            <td>{{ $table2->where('tour_consultant', $tourconsultant->tour_consultant)->pluck('tc')->count() }}</td>
            <td>{{ $tourconsultant->tour_consultant }}</td>
            <td>{{round($table2->where('tour_consultant', $tourconsultant->tour_consultant)->pluck('rate_value')->avg(), 0)}}</td>
            <td></td>
            <td>{{$table3->where('tc', $tourconsultant->tour_consultant)->pluck('very_satisfied')->sum()}}</td>
            <td>{{$table3->where('tc', $tourconsultant->tour_consultant)->pluck('satisfied')->sum()}}</td>
            <td>{{$table3->where('tc', $tourconsultant->tour_consultant)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{$table3->where('tc', $tourconsultant->tour_consultant)->pluck('not_satisfied')->sum()}}</td>
            <td>{{ $tourconsultant? 1 : '' }}</td>
            </tr>
        @endforeach

        <tr>
            <td>{{ $table2->pluck('full_name')->count()}}</td>
            <td>Overall</td>
            <td>{{ round($table2->pluck('rate_value')->avg(), 0)}}</td>  
            <td></td>
            <td>{{$table3->pluck('very_satisfied')->sum()}}</td>
            <td>{{$table3->pluck('satisfied')->sum()}}</td>
            <td>{{$table3->pluck('failry_satisfied')->sum()}}</td>
            <td>{{$table3->pluck('not_satisfied')->sum()}}</td>
            <td>{{ $table2->pluck('full_name')->count()}}</td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('RESPONDENT') }}</th>
            <th>{{ __('TC') }}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
        </tr> 
        @foreach ($tcc as $key => $tcc)
        <tr>
        @php
            $a1 = $table3->where('tc', $tcc->tour_consultant)->pluck('satisfied')->sum();
            $b1 = $table3->where('tc', $tcc->tour_consultant)->pluck('failry_satisfied')->sum();
            $ao11 = $table3->pluck('satisfied')->sum();
            $bo11 = $table3->pluck('failry_satisfied')->sum();
        @endphp
            <td>{{ $table3->where('tc', $tcc->tour_consultant)->pluck('tc')->count() }}</td>
            <td>{{$tcc->tour_consultant}}</td>
            <td>{{$table3->where('tc', $tcc->tour_consultant)->pluck('very_satisfied')->sum()}}</td>
            <td>{{ $a1 + $b1 }}</td>
            <td>{{$table3->where('tc', $tcc->tour_consultant)->pluck('not_satisfied')->sum()}}</td>
            <td>{{ round($table2->where('tour_consultant', $tcc->tour_consultant)->pluck('rate_value')->avg(), 0)}}</td>
        </tr>
        @endforeach

        <tr>
            <td>{{ $table3->pluck('tc')->count() }}</td>
            <td>Overall</td>
            <td>{{ $table3->pluck('very_satisfied')->sum()}}</td>  
            <td>{{ $ao11 + $bo11 }}</td>
            <td>{{$table3->pluck('not_satisfied')->sum()}}</td>
            <td>{{ round($table2->pluck('rate_value')->avg(), 0)}}</td>  
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Weekly Result') }}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('RESPONDENT') }}</th>
        </tr> 
        @php
            $ok1 = $weekly1->pluck('satisfied')->sum();
            $okb1 = $weekly1->pluck('failry_satisfied')->sum();
            $ao2 = $weekly2->pluck('satisfied')->sum();
            $bo2 = $weekly2->pluck('failry_satisfied')->sum();
            $ao3 = $weekly3->pluck('satisfied')->sum();
            $bo3 = $weekly3->pluck('failry_satisfied')->sum();
            $ao4 = $table3->pluck('satisfied')->sum();
            $bo4 = $table3->pluck('failry_satisfied')->sum();
            $ov = $overall->pluck('satisfied')->sum();
            $ovb = $overall->pluck('failry_satisfied')->sum();
        @endphp

    @if($test[0]==1)
        <tr>
            <td>Week 1</td>
            <td>{{ $weekly1->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ok1 + $okb1 }}</td>
            <td>{{ $weekly1->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly1->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly1? 1 : '' }}</td>
        </tr>
        <tr>
            <td>Overall</td>
            <td>{{ $weekly1->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ok1 + $okb1 }}</td>
            <td>{{ $weekly1->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly1->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly1->pluck('full_name')->count()}}</td>
        </tr>
    @elseif ($test[0]==9)
        <tr>
            <td>Week 1</td>
            <td>{{ $weekly1->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ok1 + $okb1 }}</td>
            <td>{{ $weekly1->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly1->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly1->pluck('full_name')->count() }}</td>
        </tr>
        <tr>
            <td>Week 2</td>
            <td>{{ $weekly2->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ao2 + $bo2 }}</td>
            <td>{{ $weekly2->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly2->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly2->pluck('full_name')->count() }}</td>
        </tr>
        <tr>
            <td>Overall</td>
            <td>{{ $overall2->pluck('very_satisfied')->sum()}}</td>
            <td>{{ $ok1 + $okb1+ $ao2 + $bo2 }}</td>
            <td>{{ $overall2->pluck('not_satisfied')->sum()}}</td>
            <td>{{ round($overall2->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $overall2->pluck('full_name')->count() }}</td>
        </tr>
    @elseif($test[0]==16)
    <tr>
            <td>Week 1</td>
            <td>{{ $weekly1->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ok1 + $okb1 }}</td>
            <td>{{ $weekly1->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly1->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly1->pluck('full_name')->count() }}</td>
        </tr>
        <tr>
            <td>Week 2</td>
            <td>{{ $weekly2->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ao2 + $bo2 }}</td>
            <td>{{ $weekly2->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly2->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly2->pluck('full_name')->count() }}</td>
        </tr>
        <tr>
            <td>Week 3</td>
            <td>{{ $weekly3->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ao3 + $bo3 }}</td>
            <td>{{ $weekly3->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly3->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly3->pluck('full_name')->count() }}</td>
        </tr>
        <tr>
            <td>Overall</td>
            <td>{{ $overall3->pluck('very_satisfied')->sum()}}</td>
            <td>{{ $ok1 + $okb1+ $ao2 + $bo2 + $ao3 + $bo3 }}</td>
            <td>{{ $overall3->pluck('not_satisfied')->sum()}}</td>
            <td>{{ round($overall3->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $overall3->pluck('full_name')->count() }}</td>
        </tr>
    @elseif($test[0]==23)
        <tr>
            <td>Week 1</td>
            <td>{{ $weekly1->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ok1 + $okb1 }}</td>
            <td>{{ $weekly1->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly1->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly1->pluck('full_name')->count() }}</td>
        </tr>
        <tr>
            <td>Week 2</td>
            <td>{{ $weekly2->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ao2 + $bo2 }}</td>
            <td>{{ $weekly2->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly2->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly2->pluck('full_name')->count() }}</td>
        </tr>
        <tr>
            <td>Week 3</td>
            <td>{{ $weekly3->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ao3 + $bo3 }}</td>
            <td>{{ $weekly3->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly3->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly3->pluck('full_name')->count() }}</td>
        </tr>
        <tr>
            <td>Week 4</td>
            <td>{{ $weekly4->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $ao4 + $bo4 }}</td>
            <td>{{ $weekly4->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($weekly4->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $weekly4->pluck('full_name')->count() }}</td>
        </tr>
        <tr>
            <td>Overall</td>
            <td>{{ $overall->pluck('very_satisfied')->sum()}}</td>
            <td>{{ $ov + $ovb}}</td>
            <td>{{ $overall->pluck('not_satisfied')->sum()}}</td>
            <td>{{ round($overall->pluck('rate_value')->avg(), 0) }}</td>
            <td>{{ $overall->pluck('full_name')->count()}}</td>
        </tr>
    @endif
     
    </tbody>
</table>

 <div id="chartContainer" style="height: 370px; width: 100%;"></div>
 <!-- <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script> -->
 @push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" />
    @include('layouts.includes.datatable-css')
@endpush
@push('script')
 <script src="{{ asset('assets/js/loader.js') }}"></script>
    <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script src="{{ asset('vendor/apex-chart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
@endpush

