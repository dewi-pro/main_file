@php
    $currantColumn = [];
@endphp
<table>
    <tbody>
        @foreach ($formvalues as $key => $formValue)
            @php
                $column = $formValue->columns();
            @endphp
            @if ($currantColumn != $column)
                @php
                    $currantColumn = $column;
                @endphp
                @if ($key != 0)
                    <tr></tr>
                @endif
                <tr>
                    @foreach ($currantColumn as $value)
                        <th>{{ $value }}</th>
                    @endforeach
                    <!-- <th>{{ __('Amount') }}</th>
                    <th>{{ __('Transaction ID') }}</th>
                    <th>{{ __('Created At') }}</th>} -->
                </tr>
            @endif
            <tr>
                @foreach (json_decode($formValue->json) as $jsons)
                    @foreach ($jsons as $json)
                        @if (isset($json->value) || isset($json->values))
                            @if (isset($json->value))
                                @if ($json->type == 'starRating')
                                    <td>{{ isset($json->value) ? $json->value : '' }}</td>
                                @elseif ($json->type == 'button')
                                    <td> </td>
                                @elseif ($json->type == 'date')
                                    <td>{{ isset($json->value) ? $json->value : '' }}</td>
                                @elseif ($json->type == 'number')
                                    <td>{{ isset($json->value) ? $json->value : '' }}</td>
                                @elseif ($json->type == 'text')
                                    <td>{{ isset($json->value) ? $json->value : '' }}</td>
                                @elseif ($json->type == 'textarea')
                                    <td>{{ isset($json->value) ? $json->value : '' }}</td>
                                @elseif ($json->type == 'video')
                                    @if ($json->value)
                                        <td>
                                            {!! Html::link(Storage::path($json->value), __('video'), []) !!}
                                        </td>
                                    @else
                                        <td>null</td>
                                    @endif
                                @elseif ($json->type == 'selfie')
                                    @if ($json->value)
                                        <td>
                                            {!! Html::link(Storage::path($json->value), __('photo'), []) !!}
                                        </td>
                                    @else
                                        <td>null</td>
                                    @endif
                                @elseif ($json->type == 'SignaturePad')
                                    @if ($json->value)
                                        <td>
                                            {!! Html::link(Storage::path($json->value), __('image'), []) !!}
                                        </td>
                                    @else
                                        <td>null</td>
                                    @endif
                                @elseif ($json->type == 'autocomplete')
                                    <td>{{ isset($json->value) ? $json->value : null }}</td>
                                @elseif ($json->type == 'location')
                                    @if ($json->value != '')
                                        <td>{{ isset($json->value) }}</td>
                                    @else
                                        <td>null</td>
                                    @endif
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
                                            @php  $value .= $subData->value . ',' @endphp
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

                            @if ($json->type == 'file')
                                @if (isset($json->value))
                                    @php
                                        $fileData = json_decode($json->value);
                                    @endphp
                                        @if (is_array($fileData))
                                            @foreach ($fileData as $key => $subData)
                                                <td>
                                                    {!! Html::link(Storage::path($subData), __('image'), []) !!}
                                                </td>
                                            @endforeach
                                        @else
                                            <td>
                                                {!! Html::link(Storage::path($json->value), __('image'), []) !!}
                                            </td>
                                        @endif
                                    @endif

                                @endif
                            @endif
                            @if ($json->type == 'header')
                            @if (isset($json->selected) && $json->selected)
                                {{ intval($json->number_of_control) }}
                                <td> {{ __('N/A') }}</td>
                            @else
                                <td>{{ isset($json->value) ? $json->value : '' }}</td>
                            @endif
                        @else
                            @if ($json->type == 'paragraph')
                                <td>{{ isset($json->label) ? $json->label : '' }}</td>
                            @endif
                            @if ($json->type == 'break')
                                <td>{{ isset($json->label) ? $json->label : '' }}</td>
                            @endif
                            @if ($json->type == 'button')
                                <td>{{ isset($json->label) ? $json->label : '' }}</td>
                            @endif
                            {{-- @if (isset($json->value))
                                <td> {{ isset($json->value) ? $json->value : 'null' }}</td>
                            @endif --}}
                        @endif

                    @endforeach
                    {{-- <td>{{ isset($formValue->amount) ? $formValue->amount : 'null' }}</td>
                    @if (is_null($formValue->transaction_id))
                        <td>null</td>
                    @else
                        <td>{{ $formValue->transaction_id }}</td>
                    @endif
                    <td>{{ isset($formValue->created_at) ? Utility::date_time_format($formValue->created_at) : 'null' }}
                    </td> --}}
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
