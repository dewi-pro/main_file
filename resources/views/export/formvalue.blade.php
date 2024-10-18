@php
    $currantColumn = [];
@endphp
<table>
    <tbody>
                <tr>
                    <th>{{ __('Date Submitted') }}</th>
                    <th>{{ __('Destination') }}</th>
                    <th>{{ __('Tour Name') }}</th>
                    <th>{{ __('TL') }}</th>
                    <th>{{ __('Participant Name') }}</th>
                    <th>{{ __('Q1') }}</th>
                    <th>{{ __('Q2') }}</th>
                    <th>{{ __('Q3') }}</th>
                    <th>{{ __('Q4') }}</th>
                    <th>{{ __('Q5') }}</th>
                    <th>{{ __('Q6') }}</th>
                    <th>{{ __('Q7') }}</th>
                    <th>{{ __('Q8') }}</th>
                    <th>{{ __('Q9') }}</th>
                    <th>{{ __('Q10') }}</th>
                </tr>
            @foreach ($formvalues as $key => $formValue)
            <tr>
            <td>{{ isset($formValue->created_at) ? $formValue->created_at : '' }}</td>
            <td>{{ isset($formValue->destination) ? $formValue->destination : '' }}</td>
            <td>{{ isset($formValue->title) ? $formValue->title : '' }}</td>
            <td>{{ isset($formValue->tour_leader_name) ? $formValue->tour_leader_name : '' }}</td>
                @foreach (json_decode($formValue->json) as $jsons)
                    @foreach ($jsons as $json)
                        @if (isset($json->value) || isset($json->values))
                            @if (isset($json->value))
                                @if ($json->label == 'Participant Name')
                                    <td>{{ isset($json->value) ? $json->value : '' }}</td>
                                @endif
                            @elseif (isset($json->values))
                                @php
                                    $value = '';
                                @endphp
                                @foreach ($json->values as $subData)
                                    @if ($json->type == 'checkbox-group')
                                        @if (isset($subData->selected))
                                            @php  $value .= $subData->value . ',' @endphp
                                        @endif
                                    @elseif ($json->type == 'radio-group')
                                        @if (isset($subData->selected))
                                            @if ($subData->value == 100 || $subData->value ==75|| $subData->value ==50|| $subData->value ==25)
                                                @php  $value .= $subData->label . ',' @endphp
                                            @endif
                                        @endif
                                    @elseif($json->type == 'select')
                                        @if (isset($subData->selected))
                                            @php  $value .= $subData->value . ',' @endphp
                                        @endif
                                    @endif
                                @endforeach
                                @php  $value = rtrim($value, ',') @endphp
                                <td>{{ $value ? $value : '' }}</td>    
                            @endif
                        @endif
                    @endforeach
                @endforeach 
            </tr> 
        @endforeach
    </tbody>
</table>
<table>
    <tbody>
                <tr>
                    <th>{{ __('TL') }}</th>
                    <th>{{ __('RESPONDENT') }}</th>
                    <th>{{ __('Q1') }}</th>
                    <th>{{ __('Q2') }}</th>
                    <th>{{ __('Q3') }}</th>
                    <th>{{ __('Q4') }}</th>
                    <th>{{ __('Q5') }}</th>
                    <th>{{ __('Q6') }}</th>
                    <th>{{ __('Q7') }}</th>
                    <th>{{ __('Q8') }}</th>
                    <th>{{ __('Q9') }}</th>
                    <th>{{ __('Q10') }}</th>
                    <th>{{ __('Overall') }}</th>
                </tr>
        @foreach ($formvalues as $key => $formValue)
            <tr>
            <td>{{ isset($formValue->tour_leader_name) ? $formValue->tour_leader_name : '' }}</td>
                @foreach (json_decode($formValue->json) as $jsons)
                    @foreach ($jsons as $json)
                        @if (isset($json->value) || isset($json->values))
                            @if (isset($json->value))
                                @if ($json->label == 'Participant Name')
                                    <td>{{ isset($json->value) ? 1 : '' }}</td>
                                @endif
                            @elseif (isset($json->values))
                                @php
                                    $value = '';
                                @endphp
                                @foreach ($json->values as $subData)
                                    @if ($json->type == 'checkbox-group')
                                        @if (isset($subData->selected))
                                            @php  $value .= $subData->value . ',' @endphp
                                        @endif
                                    @elseif ($json->type == 'radio-group')
                                        @if (isset($subData->selected))
                                            @if ($subData->value == 100 || $subData->value ==75|| $subData->value ==50|| $subData->value ==25)
                                                @php  $value .= $subData->value . ',' @endphp
                                            @endif
                                        @endif
                                    @elseif($json->type == 'select')
                                        @if (isset($subData->selected))
                                            @php  $value .= $subData->value . ',' @endphp
                                        @endif
                                    @endif
                                @endforeach
                                @php  $value = rtrim($value, ',') @endphp
                                <td>{{ $value ? $value : '' }}</td>    
                            @endif
                        @endif
                    @endforeach
                @endforeach 
            <td>{{ round($formValue->sum, 0)}}</td>
            </tr> 
        @endforeach
        <tr>
        <td>Overall</td>
        <td></td>
        @foreach ($value1 as $key => $value)
            <td>{{round($value->total, 0)}}</td>
        @endforeach    
        @foreach ($value2 as $key => $value)
            <td>{{round($value->total, 0)}}</td>
        @endforeach 
        @foreach ($value3 as $key => $value)
            <td>{{round($value->total, 0)}}</td>
        @endforeach 
        @foreach ($value4 as $key => $value)
            <td>{{round($value->total, 0)}}</td>
        @endforeach 
        @foreach ($value5 as $key => $value)
            <td>{{round($value->total, 0)}}</td>
        @endforeach 
        @foreach ($value6 as $key => $value)
            <td>{{round($value->total, 0)}}</td>
        @endforeach    
        @foreach ($value7 as $key => $value)
            <td>{{round($value->total, 0)}}</td>
        @endforeach 
        @foreach ($value8 as $key => $value)
            <td>{{round($value->total, 0)}}</td>
        @endforeach 
        @foreach ($value9 as $key => $value)
            <td>{{round($value->total, 0)}}</td>
        @endforeach 
        @foreach ($value10 as $key => $value)
            <td>{{round($value->total, 0)}}</td>
        @endforeach 
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('TL') }}</th>
            <th>{{ __('RESPONDENT') }}</th>
            <th>{{ __('Q1') }}</th>
            <th>{{ __('Q2') }}</th>
            <th>{{ __('Q3') }}</th>
            <th>{{ __('Q4') }}</th>
            <th>{{ __('Q5') }}</th>
            <th>{{ __('Q6') }}</th>
            <th>{{ __('Q7') }}</th>
            <th>{{ __('Q8') }}</th>
            <th>{{ __('Q9') }}</th>
            <th>{{ __('Q10') }}</th>
        </tr>
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td></td>
            <td>{{round($value11->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{round($valueindex2->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{round($valueindex3->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{round($valueindex4->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{round($valueindex5->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{round($valueindex6->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{round($valueindex7->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{round($valueindex8->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{round($valueindex9->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{round($valueindex10->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        @endforeach 
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q1 : Airlines') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
            <th></th>
            <th>{{ __('Q2 : Bus Driver') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
            <th></th>
            <th>{{ __('Q3 : Bus Comfort & Cleanlines') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
            <th></th>
            <th>{{ __('Q4 : Lunch/Dinner') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach

    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail->pluck('not_satisfied')->sum() }}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail2->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail2->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail2->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail2->pluck('not_satisfied')->sum() }}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail3->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail3->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail3->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail3->pluck('not_satisfied')->sum() }}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail4->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail4->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail4->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail4->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q5 : Hotel') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
            <th></th>
            <th>{{ __('Q6 : Local Guide') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
            <th></th>
            <th>{{ __('Q7 : TL Responsibility') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach

    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail5->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail5->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail5->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail5->pluck('not_satisfied')->sum() }}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail6->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail6->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail6->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail6->pluck('not_satisfied')->sum() }}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail7->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail7->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail7->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail7->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q8 : TL Hospitality') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
            <th></th>
            <th>{{ __('Q9 : TL Knowledge') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
            <th></th>
            <th>{{ __('Q10 : TL Mutual Interest') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail8->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail8->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail8->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail8->pluck('not_satisfied')->sum() }}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail9->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail9->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail9->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail9->pluck('not_satisfied')->sum() }}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail10->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail10->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail10->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail10->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q1 : Airlines')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('Respondent') }}</th>
            <th></th>
            <th>{{ __('Q2 : Bus Driver')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('Respondent') }}</th>
            <th></th>
            <th>{{ __('Q3 : Bus Comfort & Cleanlines')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('Respondent') }}</th>
            <th></th>
            <th>{{ __('Q4 : Lunch/Dinner')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('Respondent') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            @php
            $a1 = $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
            $b1 = $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
            $a2 = $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
            $b2 = $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
            $a3 = $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
            $b3 = $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
            $a4 = $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
            $b4 = $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
            @endphp
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a1 + $b1 }}</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($value11->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{ $value11->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->count()}}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a2 + $b2 }}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex2->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{ $valueindex2->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->count()}}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a3 + $b3 }}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex3->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{ $valueindex3->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->count()}}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a4 + $b4 }}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex4->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{ $valueindex4->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->count()}}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail11 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail->pluck('not_satisfied')->sum() }}</td>
        <td>{{ round($value11->pluck('rule_name')->avg(), 0)}}</td>
        <td>{{ $value11->pluck('rule_name')->count()}}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail2->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail12 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail2->pluck('not_satisfied')->sum() }}</td>
        <td>{{ round($valueindex2->pluck('rule_name')->avg(), 0)}}</td>
        <td>{{ $valueindex2->pluck('rule_name')->count()}}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail3->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail13 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail3->pluck('not_satisfied')->sum() }}</td>
        <td>{{ round($valueindex3->pluck('rule_name')->avg(), 0)}}</td>
        <td>{{ $valueindex3->pluck('rule_name')->count()}}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail4->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail14 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail4->pluck('not_satisfied')->sum() }}</td>
        <td>{{ round($valueindex4->pluck('rule_name')->avg(), 0)}}</td>
        <td>{{ $valueindex4->pluck('rule_name')->count()}}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
    <tr>
            <th>{{ __('Q5 : Hotel')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('Respondent') }}</th>
            <th></th>
            <th>{{ __('Q6 : Local Guide')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('Respondent') }}</th>
            <th></th>
            <th>{{ __('Q7 : TL Responsibility')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('Respondent') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            @php
                $a5 = $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b5 = $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
                $a6 = $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b6 = $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
                $a7 = $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b7 = $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
            @endphp
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a5 + $b5 }}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex5->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{ $valueindex5->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->count()}}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a6 + $b6 }}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex6->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{ $valueindex6->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->count()}}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a7 + $b7 }}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex7->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{ $valueindex7->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->count()}}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail5->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail15 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach
        <td>{{ $valueDetail5->pluck('not_satisfied')->sum() }}</td>
        <td>{{ round($valueindex5->pluck('rule_name')->avg(), 0)}}</td>
        <td>{{ $valueindex5->pluck('rule_name')->count()}}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail6->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail16 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail6->pluck('not_satisfied')->sum() }}</td>        
        <td>{{ round($valueindex6->pluck('rule_name')->avg(), 0)}}</td>
        <td>{{ $valueindex6->pluck('rule_name')->count()}}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail7->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail17 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail7->pluck('not_satisfied')->sum() }}</td>
        <td>{{ round($valueindex7->pluck('rule_name')->avg(), 0)}}</td>
        <td>{{ $valueindex7->pluck('rule_name')->count()}}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
    <tr>
            <th>{{ __('Q8 : TL Hospitality')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('Respondent') }}</th>
            <th></th>
            <th>{{ __('Q9 : TL Knowledge')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('Respondent') }}</th>
            <th></th>
            <th>{{ __('Q10 : TL Mutual Interest')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
            <th>{{ __('Respondent') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            @php
                $a8 = $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b8 = $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
                $a9 = $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b9 = $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
                $a10 = $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b10 = $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
            @endphp
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a8 + $b8 }}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex8->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{ $valueindex8->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->count()}}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a9 + $b9 }}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex9->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{ $valueindex9->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->count()}}</td>
            <td></td>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a10 + $b10 }}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex10->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
            <td>{{ $valueindex10->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->count()}}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail8->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail18 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail8->pluck('not_satisfied')->sum() }}</td>
        <td>{{ round($valueindex8->pluck('rule_name')->avg(), 0)}}</td>
        <td>{{ $valueindex8->pluck('rule_name')->count()}}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail9->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail19 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail9->pluck('not_satisfied')->sum() }}</td>
        <td>{{ round($valueindex9->pluck('rule_name')->avg(), 0)}}</td>
        <td>{{ $valueindex9->pluck('rule_name')->count()}}</td>
        <td></td>
        <td>Overall</td>
        <td>{{ $valueDetail10->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail20 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach
        <td>{{ $valueDetail10->pluck('not_satisfied')->sum() }}</td>
        <td>{{ round($valueindex10->pluck('rule_name')->avg(), 0)}}</td>
        <td>{{ $valueindex10->pluck('rule_name')->count()}}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
    @foreach ($form as $key => $forms)
        <tr>
            <th>{{$forms->tour_leader_name}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
        </tr> 
        @php
        $a1 = $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
        $b1 = $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
        $a2 = $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
        $b2 = $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
        $a3 = $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
        $b3 = $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
        $a4 = $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
        $b4 = $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
        $a5 = $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b5 = $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
                $a6 = $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b6 = $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
                $a7 = $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b7 = $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
                $a8 = $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b8 = $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
                $a9 = $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b9 = $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
                $a10 = $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b10 = $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
                $overalla =$overall->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $overallb =$overall->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();

        @endphp
        <tr>
            <td>Q1 : Airlines</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a1 + $b1 }}</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($value11->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q2 : Bus Driver</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a2 + $b2 }}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex2->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q3 : Bus Comfort Cleanlines</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a3 + $b3 }}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex3->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q4 : Lunch/Dinner</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a4 + $b4 }}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex4->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q5 : Hotel</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a5 + $b5 }}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex5->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q6 : Local Guide</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a6 + $b6 }}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex6->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q7 : TL Responsibility</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a7 + $b7 }}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex7->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q8 : TL Hospitality</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a8 + $b8 }}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex8->where('tour_leader_name', $forms->tour_leader_name)->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q9 : TL Knowledge</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a9 + $b9 }}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex9->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q10 : TL Mutual Interest</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a10 + $b10 }}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex10->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Overall</td>
            <td>{{ $overall->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $overalla + $overallb }}</td>
            <td>{{ $overall->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($overallindex->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr></tr>
        @endforeach
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ implode(', ', $destination->pluck('destination')->toArray()) }}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
        </tr> 
        @php
                $a1 = $valueDetail->pluck('satisfied')->sum();
                $b1 = $valueDetail->pluck('failry_satisfied')->sum();
                $a2 = $valueDetail2->pluck('satisfied')->sum();
                $b2 = $valueDetail2->pluck('failry_satisfied')->sum();
                $a3 = $valueDetail3->pluck('satisfied')->sum();
                $b3 = $valueDetail3->pluck('failry_satisfied')->sum();
                $a4 = $valueDetail4->pluck('satisfied')->sum();
                $b4 = $valueDetail4->pluck('failry_satisfied')->sum();
                $a5 = $valueDetail5->pluck('satisfied')->sum();
                $b5 = $valueDetail5->pluck('failry_satisfied')->sum();
                $a6 = $valueDetail6->pluck('satisfied')->sum();
                $b6 = $valueDetail6->pluck('failry_satisfied')->sum();
                $a7 = $valueDetail7->pluck('satisfied')->sum();
                $b7 = $valueDetail7->pluck('failry_satisfied')->sum();
                $a8 = $valueDetail8->pluck('satisfied')->sum();
                $b8 = $valueDetail8->pluck('failry_satisfied')->sum();
                $a9 = $valueDetail9->pluck('satisfied')->sum();
                $b9 = $valueDetail9->pluck('failry_satisfied')->sum();
                $a10 = $valueDetail10->pluck('satisfied')->sum();
                $b10 = $valueDetail10->pluck('failry_satisfied')->sum();
                $overalla =$overall->pluck('satisfied')->sum();
                $overallb =$overall->pluck('failry_satisfied')->sum();
        @endphp
        <tr>
            <td>Q1 : Airlines</td>
            <td>{{ $valueDetail->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a1 + $b1 }}</td>
            <td>{{ $valueDetail->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($value11->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q2 : Bus Driver</td>
            <td>{{ $valueDetail2->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a2 + $b2 }}</td>
            <td>{{ $valueDetail2->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex2->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q3 : Bus Comfort Cleanlines</td>
            <td>{{ $valueDetail3->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a3 + $b3 }}</td>
            <td>{{ $valueDetail3->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex3->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q4 : Lunch/Dinner</td>
            <td>{{ $valueDetail4->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a4 + $b4 }}</td>
            <td>{{ $valueDetail4->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex4->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q5 : Hotel</td>
            <td>{{ $valueDetail5->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a5 + $b5 }}</td>
            <td>{{ $valueDetail5->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex5->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q6 : Local Guide</td>
            <td>{{ $valueDetail6->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a6 + $b6 }}</td>
            <td>{{ $valueDetail6->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex6->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q7 : TL Responsibility</td>
            <td>{{ $valueDetail7->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a7 + $b7 }}</td>
            <td>{{ $valueDetail7->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex7->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q8 : TL Hospitality</td>
            <td>{{ $valueDetail8->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a8 + $b8 }}</td>
            <td>{{ $valueDetail8->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex8->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q9 : TL Knowledge</td>
            <td>{{ $valueDetail9->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a9 + $b9 }}</td>
            <td>{{ $valueDetail9->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex9->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Q10 : TL Mutual Interest</td>
            <td>{{ $valueDetail10->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a10 + $b10 }}</td>
            <td>{{ $valueDetail10->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($valueindex10->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr>
            <td>Overall</td>
            <td>{{ $overall->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $overalla + $overallb }}</td>
            <td>{{ $overall->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($overallindex->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        <tr></tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ implode(', ', $destination->pluck('destination')->toArray()) }}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
            <th>{{ __('Index') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        @php
                $a1 = $overall->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum();
                $b1 = $overall->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum();
        @endphp
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $overall->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $a1 + $b1 }}</td>
            <td>{{ $overall->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
            <td>{{ round($overallindex->where('tour_leader_name', $forms->tour_leader_name)->pluck('rule_name')->avg(), 0)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

