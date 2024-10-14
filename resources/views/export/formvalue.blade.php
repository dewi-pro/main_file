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
            <td>{{$formValue->sum}}<td> 
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
            <th>{{ __('Q1 : Airlines') }}</th>
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
        </tr>
        @endforeach

    <tr>
        <td>Total</td>
        <td>{{ $valueDetail->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q2 : Bus Driver') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Total</td>
        <td>{{ $valueDetail2->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail2->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail2->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail2->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q3 : Bus Comfort & Cleanlines') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Total</td>
        <td>{{ $valueDetail3->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail3->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail3->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail3->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q4 : Lunch/Dinner') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Total</td>
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
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach

    <tr>
        <td>Total</td>
        <td>{{ $valueDetail5->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail5->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail5->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail5->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q6 : Local Guide') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach

    <tr>
        <td>Total</td>
        <td>{{ $valueDetail6->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail6->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail6->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail6->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q7 : TL Responsibility') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Total</td>
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
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Total</td>
        <td>{{ $valueDetail8->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail8->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail8->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail8->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q9 : TL Knowledge') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Total</td>
        <td>{{ $valueDetail9->pluck('very_satisfied')->sum() }}</td>
        <td>{{ $valueDetail9->pluck('satisfied')->sum() }}</td>
        <td>{{ $valueDetail9->pluck('failry_satisfied')->sum() }}</td>
        <td>{{ $valueDetail9->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q10 : TL Mutual Interest') }}</th>
            <th>{{ __('Very Satisfied') }}</th>
            <th>{{ __('Satisfied') }}</th>
            <th>{{ __('Failry Satisfied') }}</th>
            <th>{{ __('Not Satisfied') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied')->sum()}}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('failry_satisfied')->sum()}}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Total</td>
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
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied', 'failry_satisfied')->sum() }}</td>
            <td>{{ $valueDetail->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach

    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail11 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q2 : Bus Driver')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied', 'failry_satisfied')->sum() }}</td>
            <td>{{ $valueDetail2->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach

    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail2->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail12 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail2->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q3 : Bus Comfort & Cleanlines')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied', 'failry_satisfied')->sum() }}</td>
            <td>{{ $valueDetail3->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail3->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail13 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail3->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
    <tr>
            <th>{{ __('Q4 : Lunch/Dinner')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied', 'failry_satisfied')->sum() }}</td>
            <td>{{ $valueDetail4->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail4->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail14 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail4->pluck('not_satisfied')->sum() }}</td>
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
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied', 'failry_satisfied')->sum() }}</td>
            <td>{{ $valueDetail5->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail5->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail15 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach
        <td>{{ $valueDetail5->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q6 : Local Guide')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied', 'failry_satisfied')->sum() }}</td>
            <td>{{ $valueDetail6->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail6->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail16 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail6->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q7 : TL Responsibility')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied', 'failry_satisfied')->sum() }}</td>
            <td>{{ $valueDetail7->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail7->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail17 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail7->pluck('not_satisfied')->sum() }}</td>
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
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied', 'failry_satisfied')->sum() }}</td>
            <td>{{ $valueDetail8->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail8->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail18 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail8->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
    <tr>
            <th>{{ __('Q9 : TL Knowledge')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied', 'failry_satisfied')->sum() }}</td>
            <td>{{ $valueDetail9->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail9->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail19 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach        
        <td>{{ $valueDetail9->pluck('not_satisfied')->sum() }}</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th>{{ __('Q10 : TL Mutual Interest')}}</th>
            <th>{{ __('Top Boxes') }}</th>
            <th>{{ __('Neutral 2 Boxes') }}</th>
            <th>{{ __('Bottom Boxes') }}</th>
        </tr> 
        @foreach ($form as $key => $forms)
        <tr>
            <td>{{$forms->tour_leader_name}}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('very_satisfied')->sum() }}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('satisfied', 'failry_satisfied')->sum() }}</td>
            <td>{{ $valueDetail10->where('tour_leader_name', $forms->tour_leader_name)->pluck('not_satisfied')->sum() }}</td>
        </tr>
        @endforeach
    <tr>
        <td>Overall</td>
        <td>{{ $valueDetail10->pluck('very_satisfied')->sum() }}</td>
        @foreach ($valueDetail20 as $key => $valueDetails)
            <td>{{$valueDetails->sum}}</td>
        @endforeach
        <td>{{ $valueDetail10->pluck('not_satisfied')->sum() }}</td>
    </tr>
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

