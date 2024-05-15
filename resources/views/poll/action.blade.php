@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($poll->id);
@endphp
@if ($poll->voting_type == 'Multiple_choice')
    @can('vote-poll')
        <a class="btn btn-primary btn-sm" href="{{ route('poll.fill', $poll->id) }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Vote') }}"><i class="ti ti-list"></i></a>
    @endcan
    @can('vote-poll')
        <a class="btn btn-info btn-sm copy_form" onclick="copyToClipboard('#copy-poll-{{ $poll->id }}')"
            href="javascript:void(0)" id="copy-poll-{{ $poll->id }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
             data-bs-original-title="{{ __('Copy Vote URL') }}" data-url="{{ route('poll.survey', $id) }}"><i
                class="ti ti-copy"></i></a>
    @endcan
    @can('result-poll')
        <a class="btn btn-success btn-sm" href="{{ route('poll.result', $poll->id) }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Result Show') }}"><i class="ti ti-confetti"></i></a>
    @endcan
    @can('result-poll')
        <a class="btn btn-warning btn-sm copy_form" onclick="copyToClipboard('#copy-result-{{ $poll->id }}')"
            href="javascript:void(0)" id="copy-result-{{ $poll->id }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="{{ __('Copy Result URL') }}"
            data-url="{{ route('poll.public.result', $id) }}"><i class="ti ti-copy"></i></a>
    @endcan
@elseif($poll->voting_type == 'Meeting_poll')
    @can('vote-poll')
        <a class="btn btn-primary btn-sm" href="{{ route('meeting.poll.fill', $poll->id) }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom"  data-bs-original-title="{{ __('Vote') }}"><i class="ti ti-list"></i></a>
    @endcan
    @can('vote-poll')
        <a class="btn btn-info btn-sm copy_form" onclick="copyToClipboard('#copy-meeting-{{ $poll->id }}')"
            href="javascript:void(0)" id="copy-meeting-{{ $poll->id }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom"  data-bs-original-title="{{ __('Copy Vote URL') }}"
            data-url="{{ route('poll.survey.meeting', $id) }}"><i class="ti ti-copy"></i></a>
    @endcan
    @can('result-poll')
        <a class="btn btn-success btn-sm"
            href="{{ route('poll.meeting.result', $poll->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
             data-bs-original-title="{{ __('Result Show') }}"><i
                class="ti ti-confetti"></i></a>
    @endcan
    @can('result-poll')
        <a class="btn btn-warning btn-sm  copy_form"
            onclick="copyToClipboard('#copy-result-meeting-{{ $poll->id }}')" href="javascript:void(0)"
            id="copy-result-meeting-{{ $poll->id }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Copy Result URL') }}"
            data-url="{{ route('poll.public.result.meeting', $id) }}"><i class="ti ti-copy"></i></a>
    @endcan
@else
    @can('vote-poll')
        <a class="btn btn-primary btn-sm" href="{{ route('image.poll.fill', $poll->id) }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom"  data-bs-original-title="{{ __('Vote') }}"><i class="ti ti-list"></i></a>
    @endcan
    @can('vote-poll')
        <a class="btn btn-info btn-sm copy_form" onclick="copyToClipboard('#copy-image-{{ $poll->id }}  ')"
            href="javascript:void(0)" id="copy-image-{{ $poll->id }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom"  data-bs-original-title="{{ __('Copy Vote URL') }}"
            data-url="{{ route('poll.survey.image', $id) }}"><i class="ti ti-copy"></i></a>
    @endcan
    @can('result-poll')
        <a class="btn btn-success btn-sm" href="{{ route('poll.image.result', $poll->id) }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Result Show') }}"><i class="ti ti-confetti"></i></a>
    @endcan
    @can('result-poll')
        <a class="btn btn-warning btn-sm copy_form"
            onclick="copyToClipboard('#copy-result-image-{{ $poll->id }}')" href="javascript:void(0)"
            id="copy-result-image-{{ $poll->id }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
             data-bs-original-title="{{ __('Copy Result URL') }}"
            data-url="{{ route('poll.public.result.image', $id) }}"><i class="ti ti-copy"></i></a>
    @endcan
@endif
@can('edit-poll')
    <a class="btn btn-primary btn-sm" href="{{ route('poll.edit', $poll->id) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom"  data-bs-original-title="{{ __('Edit') }}"><i
            class="ti ti-edit"></i></a>
@endcan
@can('delete-poll')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['poll.destroy', $poll->id],
        'id' => 'delete-form-' . $poll->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip"
        data-bs-placement="bottom"  data-bs-original-title="{{ __('Delete') }}"
        id="delete-form-{{ $poll->id }}"><i class="ti ti-trash"></i></a>
    {!! Form::close() !!}
@endcan
