@extends('layouts.main')
@section('title', __('Create Poll'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Poll') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('poll.index'), __('Polls'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Create Poll') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        {!! Form::open([
            'route' => ['poll.store'],
            'method' => 'POST',
            'data-validate',
            'id' => 'payment-form',
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data',
        ]) !!}
        <div class="row">
            <div class="col-xl-6 mx-auto order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Create Poll') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('title', __('Title of Poll'), ['class' => 'form-label']) }}
                            {!! Form::text('title', null, [
                                'class' => 'form-control',
                                'id' => 'password',
                                'required',
                                'placeholder' => __('Enter title of poll'),
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('description', __('Description (optional)'), ['class' => 'form-label']) }}
                            {!! Form::textarea('description', null, [
                                'class' => 'form-control',
                                'id' => 'password',
                                'required',
                                'placeholder' => __('Enter description'),
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('voting_type', __('Voting type'), ['class' => 'form-label']) }}
                            <div>
                                {!! Form::select(
                                    'voting_type',
                                    ['Multiple_choice' => 'Multiple choice', 'Image_poll' => 'Image poll', 'Meeting_poll' => 'Meeting poll'],
                                    'Multiple_choice',
                                    ['class' => 'form-control', 'data-trigger'],
                                ) !!}
                            </div>
                        </div>
                        <div id="Multiple_choice" class="">
                            <div class="form-group">
                                {{ Form::label('answer_options', __('Answer Options'), ['class' => 'form-label']) }}
                                <div class='repeater'>
                                    <div class="row">
                                        <div data-repeater-list="multiple_answer_options">
                                            <div data-repeater-item class="repeater-answer-option">
                                                {!! Form::text('answer_options', null, [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter options'),
                                                ]) !!}
                                                <input data-repeater-delete class="btn options-close-btn" type="button"
                                                    value="x" />
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input data-repeater-create class="btn btn-primary" type="button"
                                            value="Add Options" />
                                    </div>
                                </div>
                            </div>
                            <h5 class="mt-5">{{ __('Settings') }}</h5>
                            <hr>
                            <div class="form-group row">
                                <div class="col-md-8">
                                    {{ Form::label('multiple_choice_require_participate_names', __('Require participants names'), ['class' => 'form-label d-block']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-switch mt-2 float-end custom-switch-v1">
                                        <input type="checkbox" name="require_participants_names"
                                            id="multiple_choice_require_participate_names"
                                            class="form-check-input input-primary" {{ 'unchecked' }}>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('voting_type', __('Voting restrictions'), ['class' => 'form-label']) }}
                                <div>
                                    {!! Form::select(
                                        'voting_restrictions',
                                        [
                                            'One_vote_per_browser_session' => 'One vote per browser session',
                                            'One_vote_per_ip_address' => 'One vote per IP address',
                                            'One_vote_per_user_account' => 'One vote per user account',
                                        ],
                                        'One_vote_per_browser_session',
                                        ['class' => 'form-control', 'data-trigger'],
                                    ) !!}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('multiple_choice_set_end_date', __('Set end date'), ['class' => 'form-label']) }}
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            <input type="checkbox" name="set_end_date" id="multiple_choice_set_end_date"
                                                class="form-check-input input-primary" {{ 'unchecked' }}>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="set_end_date" class="{{ 'd-none' }}">
                                <div class="form-group">
                                    <input class="form-control" name="set_end_date_time" id="set_end_date_time">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('multiple_choice_allow_comments', __('Allow comments'), ['class' => 'form-label']) }}
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            <input type="checkbox" name="allow_comments" id="multiple_choice_allow_comments"
                                                class="form-check-input input-primary" {{ 'unchecked' }}>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="require_participants_names" class="{{ 'd-none' }}">
                                <div class="form-group row">
                                    <div class="col-md-8">
                                        {{ Form::label('multiple_choice_hide_participate_from_each_other', __('Hide participants from each other'), ['class' => 'form-label d-block']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            <input type="checkbox" name="hide_participants_from_each_other"
                                                id="multiple_choice_hide_participate_from_each_other"
                                                class="form-check-input input-primary" {{ 'unchecked' }}>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('results_visibility', __('Results visibility'), ['class' => 'form-label']) }}
                                <div>
                                    {!! Form::select(
                                        'results_visibility',
                                        [
                                            'always_public' => 'Always public',
                                            'public_after_end_date' => 'Public after end date',
                                            'public_after_vote' => 'Public after vote',
                                            'not_public' => 'Not public',
                                        ],
                                        'always_public',
                                        ['class' => 'form-control', 'data-trigger'],
                                    ) !!}
                                </div>
                            </div>
                        </div>
                        <div id="Image_poll" class="d-none">
                            <div class='repeater-image'>
                                <div data-repeater-list="image_answer_options" class="answer_options">
                                    <div data-repeater-item>
                                        <div class="form-group d-flex">
                                            <div class="upload-box">
                                                <div class="top-div">
                                                    <div class="image-preview"></div>
                                                    <label>
                                                        <input type="file" name="image"
                                                            class="custom-file-input image-input">
                                                        <svg class="" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                        <span>click to upload</span>
                                                    </label>
                                                    <input data-repeater-delete class="btn options-close-btn" type="button"
                                                        value="x" />
                                                </div>
                                                <input type="text" name="optional_name" class="form-control"
                                                    placeholder="optional">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <input data-repeater-create class="btn btn-primary" type="button"
                                        value="Add Options" />
                                </div>
                            </div>
                            <h5 class="mt-5">{{ __('Settings') }}</h5>
                            <hr>
                            <div class="form-group row">
                                <div class="col-md-8">
                                    {{ Form::label('image_poll_require_participate_names', __('Require participants names'), ['class' => 'form-label d-block']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-switch mt-2 float-end custom-switch-v1">
                                        <input type="checkbox" name="image_require_participants_names"
                                            id="image_poll_require_participate_names"
                                            class="form-check-input input-primary" {{ 'unchecked' }}>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('image_voting_type', __('Voting restrictions'), ['class' => 'form-label']) }}
                                <div>
                                    {!! Form::select(
                                        'image_voting_restrictions',
                                        [
                                            'One_vote_per_browser_session' => 'One vote per browser session',
                                            'One_vote_per_ip_address' => 'One vote per IP address',
                                            'One_vote_per_user_account' => 'One vote per user account',
                                        ],
                                        'One_vote_per_browser_session',
                                        ['class' => 'form-control', 'data-trigger'],
                                    ) !!}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('image_poll_set_end_date', __('Set end date'), ['class' => 'form-label']) }}
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            <input type="checkbox" name="image_set_end_date" id="image_poll_set_end_date"
                                                class="form-check-input input-primary" {{ 'unchecked' }}>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="image_set_end_date" class="{{ 'd-none' }}">
                                <div class="form-group">
                                    <input class="form-control" name="image_set_end_date_time"
                                        id="image_set_end_date_time">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('image_poll_allow_comments', __('Allow comments'), ['class' => 'form-label']) }}
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            <input type="checkbox" name="image_allow_comments"
                                                id="image_poll_allow_comments" class="form-check-input input-primary"
                                                {{ 'unchecked' }}>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="image_require_participants_names" class="{{ 'd-none' }}">
                                <div class="form-group row">
                                    <div class="col-md-8">
                                        {{ Form::label('image_poll_hide_participate_from_each_other', __('Hide participants from each other'), ['class' => 'form-label d-block']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            <input type="checkbox" name="image_hide_participants_from_each_other"
                                                id="image_poll_hide_participate_from_each_other"
                                                class="form-check-input input-primary" {{ 'unchecked' }}>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('image_results_visibility', __('Results visibility'), ['class' => 'form-label']) }}
                                <div>
                                    {!! Form::select(
                                        'image_results_visibility',
                                        [
                                            'always_public' => 'Always public',
                                            'public_after_end_date' => 'Public after end date',
                                            'public_after_vote' => 'Public after vote',
                                            'not_public' => 'Not public',
                                        ],
                                        'always_public',
                                        ['class' => 'form-control', 'data-trigger'],
                                    ) !!}
                                </div>
                            </div>
                        </div>
                        <div id="Meeting_poll" class="d-none">
                            {{ Form::label('answer_options', __('Answer Options'), ['class' => 'form-label']) }}
                            <div class='repeater-meeting'>
                                <div data-repeater-list="meeting_answer_options" class="meeting-answer-options">
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                {!! Form::text('datetime', null, [
                                                    'placeholder' => __('Enter drops time:'),
                                                    'class' => 'form-control time-picker',
                                                    'required',
                                                ]) !!}
                                            </div>
                                            <div class="col-sm-2">
                                                <input data-repeater-delete class="btn btn-danger" type="button"
                                                    value="Delete" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input data-repeater-create class="btn btn-primary" type="button"
                                        value="Add Options" />
                                </div>
                            </div>
                            <h5 class="mt-5">{{ __('Settings') }}</h5>
                            <hr>
                            <div class="form-group  row">
                                <div class="col-md-8">
                                    {{ Form::label('meeting_poll_time_zone', __('Fixed time zone'), ['class' => 'form-label d-block']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-switch mt-2 float-end custom-switch-v1">
                                        <input type="checkbox" name="meeting_fixed_time_zone" id="meeting_poll_time_zone"
                                            class="form-check-input input-primary" {{ 'unchecked' }}>
                                    </label>
                                </div>
                            </div>
                            <div id="meeting_fixed_time_zone" class="{{ 'd-none' }}">
                                <div class="form-group">
                                    <select name="meetings_fixed_time_zone" class="form-control">
                                        <option value="Pacific/Midway"
                                            {{ Utility::getsettings('time_zone') == 'Pacific/Midway' ? 'selected' : '' }}>
                                            (GMT-11:00) Midway Island, Samoa</option>
                                        <option
                                            value="America/Adak"{{ Utility::getsettings('time_zone') == 'America/Adak' ? 'selected' : '' }}>
                                            (GMT-10:00) Hawaii-Aleutian</option>
                                        <option
                                            value="Etc/GMT+10"{{ Utility::getsettings('time_zone') == 'Etc/GMT+10' ? 'selected' : '' }}>
                                            (GMT-10:00) Hawaii</option>
                                        <option
                                            value="Pacific/Marquesas"{{ Utility::getsettings('time_zone') == 'Pacific/Marquesas' ? 'selected' : '' }}>
                                            (GMT-09:30) Marquesas Islands</option>
                                        <option
                                            value="Pacific/Gambier"{{ Utility::getsettings('time_zone') == 'Pacific/Gambier' ? 'selected' : '' }}>
                                            (GMT-09:00) Gambier Islands</option>
                                        <option
                                            value="America/Anchorage"{{ Utility::getsettings('time_zone') == 'America/Anchorage' ? 'selected' : '' }}>
                                            (GMT-09:00) Alaska</option>
                                        <option
                                            value="America/Ensenada"{{ Utility::getsettings('time_zone') == 'America/Ensenada' ? 'selected' : '' }}>
                                            (GMT-08:00) Tijuana, Baja California</option>
                                        <option
                                            value="Etc/GMT+8"{{ Utility::getsettings('time_zone') == 'Etc/GMT+8' ? 'selected' : '' }}>
                                            (GMT-08:00) Pitcairn Islands</option>
                                        <option
                                            value="America/Los_Angeles"{{ Utility::getsettings('time_zone') == 'America/Los_Angeles' ? 'selected' : '' }}>
                                            (GMT-08:00) Pacific Time (US & Canada)</option>
                                        <option
                                            value="America/Denver"{{ Utility::getsettings('time_zone') == 'America/Denver' ? 'selected' : '' }}>
                                            (GMT-07:00) Mountain Time (US & Canada)</option>
                                        <option
                                            value="America/Chihuahua"{{ Utility::getsettings('time_zone') == 'America/Chihuahua' ? 'selected' : '' }}>
                                            (GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                        <option
                                            value="America/Dawson_Creek"{{ Utility::getsettings('time_zone') == 'America/Dawson_Creek' ? 'selected' : '' }}>
                                            (GMT-07:00) Arizona</option>
                                        <option
                                            value="America/Belize"{{ Utility::getsettings('time_zone') == 'America/Belize' ? 'selected' : '' }}>
                                            (GMT-06:00) Saskatchewan, Central America</option>
                                        <option
                                            value="America/Cancun"{{ Utility::getsettings('time_zone') == 'America/Cancun' ? 'selected' : '' }}>
                                            (GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                        <option
                                            value="Chile/EasterIsland"{{ Utility::getsettings('time_zone') == 'Chile/EasterIsland' ? 'selected' : '' }}>
                                            (GMT-06:00) Easter Island</option>
                                        <option
                                            value="America/Chicago"{{ Utility::getsettings('time_zone') == 'America/Chicago' ? 'selected' : '' }}>
                                            (GMT-06:00) Central Time (US & Canada)</option>
                                        <option
                                            value="America/New_York"{{ Utility::getsettings('time_zone') == 'America/New_York' ? 'selected' : '' }}>
                                            (GMT-05:00) Eastern Time (US & Canada)</option>
                                        <option
                                            value="America/Havana"{{ Utility::getsettings('time_zone') == 'America/Havana' ? 'selected' : '' }}>
                                            (GMT-05:00) Cuba</option>
                                        <option
                                            value="America/Bogota"{{ Utility::getsettings('time_zone') == 'America/Bogota' ? 'selected' : '' }}>
                                            (GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                        <option
                                            value="America/Caracas"{{ Utility::getsettings('time_zone') == 'America/Caracas' ? 'selected' : '' }}>
                                            (GMT-04:30) Caracas</option>
                                        <option
                                            value="America/Santiago"{{ Utility::getsettings('time_zone') == 'America/Santiago' ? 'selected' : '' }}>
                                            (GMT-04:00) Santiago</option>
                                        <option
                                            value="America/La_Paz"{{ Utility::getsettings('time_zone') == 'America/La_Paz' ? 'selected' : '' }}>
                                            (GMT-04:00) La Paz</option>
                                        <option
                                            value="Atlantic/Stanley"{{ Utility::getsettings('time_zone') == 'Atlantic/Stanley' ? 'selected' : '' }}>
                                            (GMT-04:00) Faukland Islands</option>
                                        <option
                                            value="America/Campo_Grande"{{ Utility::getsettings('time_zone') == 'America/Campo_Grande' ? 'selected' : '' }}>
                                            (GMT-04:00) Brazil</option>
                                        <option
                                            value="America/Goose_Bay"{{ Utility::getsettings('time_zone') == 'America/Goose_Bay' ? 'selected' : '' }}>
                                            (GMT-04:00) Atlantic Time (Goose Bay)</option>
                                        <option
                                            value="America/Glace_Bay"{{ Utility::getsettings('time_zone') == 'America/Glace_Bay' ? 'selected' : '' }}>
                                            (GMT-04:00) Atlantic Time (Canada)</option>
                                        <option
                                            value="America/St_Johns"{{ Utility::getsettings('time_zone') == 'America/St_Johns' ? 'selected' : '' }}>
                                            (GMT-03:30) Newfoundland</option>
                                        <option
                                            value="America/Araguaina"{{ Utility::getsettings('time_zone') == 'America/Araguaina' ? 'selected' : '' }}>
                                            (GMT-03:00) UTC-3</option>
                                        <option
                                            value="America/Montevideo"{{ Utility::getsettings('time_zone') == 'America/Montevideo' ? 'selected' : '' }}>
                                            (GMT-03:00) Montevideo</option>
                                        <option
                                            value="America/Miquelon"{{ Utility::getsettings('time_zone') == 'America/Miquelon' ? 'selected' : '' }}>
                                            (GMT-03:00) Miquelon, St. Pierre</option>
                                        <option
                                            value="America/Godthab"{{ Utility::getsettings('time_zone') == 'America/Godthab' ? 'selected' : '' }}>
                                            (GMT-03:00) Greenland</option>
                                        <option
                                            value="America/Argentina/Buenos_Aires"{{ Utility::getsettings('time_zone') == 'America/Argentina/Buenos_Aires' ? 'selected' : '' }}>
                                            (GMT-03:00) Buenos Aires</option>
                                        <option
                                            value="America/Sao_Paulo"{{ Utility::getsettings('time_zone') == 'America/Sao_Paulo' ? 'selected' : '' }}>
                                            (GMT-03:00) Brasilia</option>
                                        <option
                                            value="America/Noronha"{{ Utility::getsettings('time_zone') == 'America/Noronha' ? 'selected' : '' }}>
                                            (GMT-02:00) Mid-Atlantic</option>
                                        <option
                                            value="Atlantic/Cape_Verde"{{ Utility::getsettings('time_zone') == 'Atlantic/Cape_Verde' ? 'selected' : '' }}>
                                            (GMT-01:00) Cape Verde Is.</option>
                                        <option
                                            value="Atlantic/Azores"{{ Utility::getsettings('time_zone') == 'Atlantic/Azores' ? 'selected' : '' }}>
                                            (GMT-01:00) Azores</option>
                                        <option
                                            value="Europe/Belfast"{{ Utility::getsettings('time_zone') == 'Europe/Belfast' ? 'selected' : '' }}>
                                            (GMT) Greenwich Mean Time : Belfast</option>
                                        <option
                                            value="Europe/Dublin"{{ Utility::getsettings('time_zone') == 'Europe/Dublin' ? 'selected' : '' }}>
                                            (GMT) Greenwich Mean Time : Dublin</option>
                                        <option
                                            value="Europe/Lisbon"{{ Utility::getsettings('time_zone') == 'Europe/Lisbon' ? 'selected' : '' }}>
                                            (GMT) Greenwich Mean Time : Lisbon</option>
                                        <option
                                            value="Europe/London"{{ Utility::getsettings('time_zone') == 'Europe/London' ? 'selected' : '' }}>
                                            (GMT) Greenwich Mean Time : London</option>
                                        <option
                                            value="Africa/Abidjan"{{ Utility::getsettings('time_zone') == 'Africa/Abidjan' ? 'selected' : '' }}>
                                            (GMT) Monrovia, Reykjavik</option>
                                        <option
                                            value="Europe/Amsterdam"{{ Utility::getsettings('time_zone') == 'Europe/Amsterdam' ? 'selected' : '' }}>
                                            (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                        <option
                                            value="Europe/Belgrade"{{ Utility::getsettings('time_zone') == 'Europe/Belgrade' ? 'selected' : '' }}>
                                            (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                        <option
                                            value="Europe/Brussels"{{ Utility::getsettings('time_zone') == 'Europe/Brussels' ? 'selected' : '' }}>
                                            (GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                        <option
                                            value="Africa/Algiers"{{ Utility::getsettings('time_zone') == 'Africa/Algiers' ? 'selected' : '' }}>
                                            (GMT+01:00) West Central Africa</option>
                                        <option
                                            value="Africa/Windhoek"{{ Utility::getsettings('time_zone') == 'Africa/Windhoek' ? 'selected' : '' }}>
                                            (GMT+01:00) Windhoek</option>
                                        <option
                                            value="Asia/Beirut"{{ Utility::getsettings('time_zone') == 'Asia/Beirut' ? 'selected' : '' }}>
                                            (GMT+02:00) Beirut</option>
                                        <option
                                            value="Africa/Cairo"{{ Utility::getsettings('time_zone') == 'Africa/Cairo' ? 'selected' : '' }}>
                                            (GMT+02:00) Cairo</option>
                                        <option
                                            value="Asia/Gaza"{{ Utility::getsettings('time_zone') == 'Asia/Gaza' ? 'selected' : '' }}>
                                            (GMT+02:00) Gaza</option>
                                        <option
                                            value="Africa/Blantyre"{{ Utility::getsettings('time_zone') == 'Africa/Blantyre' ? 'selected' : '' }}>
                                            (GMT+02:00) Harare, Pretoria</option>
                                        <option
                                            value="Asia/Jerusalem"{{ Utility::getsettings('time_zone') == 'Asia/Jerusalem' ? 'selected' : '' }}>
                                            (GMT+02:00) Jerusalem</option>
                                        <option
                                            value="Europe/Minsk"{{ Utility::getsettings('time_zone') == 'Europe/Minsk' ? 'selected' : '' }}>
                                            (GMT+02:00) Minsk</option>
                                        <option
                                            value="Asia/Damascus"{{ Utility::getsettings('time_zone') == 'Asia/Damascus' ? 'selected' : '' }}>
                                            (GMT+02:00) Syria</option>
                                        <option
                                            value="Europe/Moscow"{{ Utility::getsettings('time_zone') == 'Europe/Moscow' ? 'selected' : '' }}>
                                            (GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                        <option
                                            value="Africa/Addis_Ababa"{{ Utility::getsettings('time_zone') == 'Africa/Addis_Ababa' ? 'selected' : '' }}>
                                            (GMT+03:00) Nairobi</option>
                                        <option
                                            value="Asia/Tehran"{{ Utility::getsettings('time_zone') == 'Asia/Tehran' ? 'selected' : '' }}>
                                            (GMT+03:30) Tehran</option>
                                        <option
                                            value="Asia/Dubai"{{ Utility::getsettings('time_zone') == 'Asia/Dubai' ? 'selected' : '' }}>
                                            (GMT+04:00) Abu Dhabi, Muscat</option>
                                        <option
                                            value="Asia/Yerevan"{{ Utility::getsettings('time_zone') == 'Asia/Yerevan' ? 'selected' : '' }}>
                                            (GMT+04:00) Yerevan</option>
                                        <option
                                            value="Asia/Kabul"{{ Utility::getsettings('time_zone') == 'Asia/Kabul' ? 'selected' : '' }}>
                                            (GMT+04:30) Kabul</option>
                                        <option
                                            value="Asia/Yekaterinburg"{{ Utility::getsettings('time_zone') == 'Asia/Yekaterinburg' ? 'selected' : '' }}>
                                            (GMT+05:00) Ekaterinburg</option>
                                        <option
                                            value="Asia/Tashkent"{{ Utility::getsettings('time_zone') == 'Asia/Tashkent' ? 'selected' : '' }}>
                                            (GMT+05:00) Tashkent</option>
                                        <option
                                            value="Asia/Kolkata"{{ Utility::getsettings('time_zone') == 'Asia/Kolkata' ? 'selected' : '' }}>
                                            (GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                        <option
                                            value="Asia/Katmandu"{{ Utility::getsettings('time_zone') == 'Asia/Katmandu' ? 'selected' : '' }}>
                                            (GMT+05:45) Kathmandu</option>
                                        <option
                                            value="Asia/Dhaka"{{ Utility::getsettings('time_zone') == 'Asia/Dhaka' ? 'selected' : '' }}>
                                            (GMT+06:00) Astana, Dhaka</option>
                                        <option
                                            value="Asia/Novosibirsk"{{ Utility::getsettings('time_zone') == 'Asia/Novosibirsk' ? 'selected' : '' }}>
                                            (GMT+06:00) Novosibirsk</option>
                                        <option
                                            value="Asia/Rangoon"{{ Utility::getsettings('time_zone') == 'Asia/Rangoon' ? 'selected' : '' }}>
                                            (GMT+06:30) Yangon (Rangoon)</option>
                                        <option
                                            value="Asia/Bangkok"{{ Utility::getsettings('time_zone') == 'Asia/Bangkok' ? 'selected' : '' }}>
                                            (GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                        <option
                                            value="Asia/Krasnoyarsk"{{ Utility::getsettings('time_zone') == 'Asia/Krasnoyarsk' ? 'selected' : '' }}>
                                            (GMT+07:00) Krasnoyarsk</option>
                                        <option
                                            value="Asia/Hong_Kong"{{ Utility::getsettings('time_zone') == 'Asia/Hong_Kong' ? 'selected' : '' }}>
                                            (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                        <option
                                            value="Asia/Irkutsk"{{ Utility::getsettings('time_zone') == 'Asia/Irkutsk' ? 'selected' : '' }}>
                                            (GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                        <option
                                            value="Australia/Perth"{{ Utility::getsettings('time_zone') == 'Australia/Perth' ? 'selected' : '' }}>
                                            (GMT+08:00) Perth</option>
                                        <option
                                            value="Australia/Eucla"{{ Utility::getsettings('time_zone') == 'Australia/Eucla' ? 'selected' : '' }}>
                                            (GMT+08:45) Eucla</option>
                                        <option
                                            value="Asia/Tokyo"{{ Utility::getsettings('time_zone') == 'Asia/Tokyo' ? 'selected' : '' }}>
                                            (GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                        <option
                                            value="Asia/Seoul"{{ Utility::getsettings('time_zone') == 'Asia/Seoul' ? 'selected' : '' }}>
                                            (GMT+09:00) Seoul</option>
                                        <option
                                            value="Asia/Yakutsk"{{ Utility::getsettings('time_zone') == 'Asia/Yakutsk' ? 'selected' : '' }}>
                                            (GMT+09:00) Yakutsk</option>
                                        <option
                                            value="Australia/Adelaide"{{ Utility::getsettings('time_zone') == 'Australia/Adelaide' ? 'selected' : '' }}>
                                            (GMT+09:30) Adelaide</option>
                                        <option
                                            value="Australia/Darwin"{{ Utility::getsettings('time_zone') == 'Australia/Darwin' ? 'selected' : '' }}>
                                            (GMT+09:30) Darwin</option>
                                        <option
                                            value="Australia/Brisbane"{{ Utility::getsettings('time_zone') == 'Australia/Brisbane' ? 'selected' : '' }}>
                                            (GMT+10:00) Brisbane</option>
                                        <option
                                            value="Australia/Hobart"{{ Utility::getsettings('time_zone') == 'Australia/Hobart' ? 'selected' : '' }}>
                                            (GMT+10:00) Hobart</option>
                                        <option
                                            value="Asia/Vladivostok"{{ Utility::getsettings('time_zone') == 'Asia/Vladivostok' ? 'selected' : '' }}>
                                            (GMT+10:00) Vladivostok</option>
                                        <option
                                            value="Australia/Lord_Howe"{{ Utility::getsettings('time_zone') == 'Australia/Lord_Howe' ? 'selected' : '' }}>
                                            (GMT+10:30) Lord Howe Island</option>
                                        <option
                                            value="Etc/GMT-11"{{ Utility::getsettings('time_zone') == 'Etc/GMT-11' ? 'selected' : '' }}>
                                            (GMT+11:00) Solomon Is., New Caledonia</option>
                                        <option
                                            value="Asia/Magadan"{{ Utility::getsettings('time_zone') == 'Asia/Magadan' ? 'selected' : '' }}>
                                            (GMT+11:00) Magadan</option>
                                        <option
                                            value="Pacific/Norfolk"{{ Utility::getsettings('time_zone') == 'Pacific/Norfolk' ? 'selected' : '' }}>
                                            (GMT+11:30) Norfolk Island</option>
                                        <option
                                            value="Asia/Anadyr"{{ Utility::getsettings('time_zone') == 'Asia/Anadyr' ? 'selected' : '' }}>
                                            (GMT+12:00) Anadyr, Kamchatka</option>
                                        <option
                                            value="Pacific/Auckland"{{ Utility::getsettings('time_zone') == 'Pacific/Auckland' ? 'selected' : '' }}>
                                            (GMT+12:00) Auckland, Wellington</option>
                                        <option
                                            value="Etc/GMT-12"{{ Utility::getsettings('time_zone') == 'Etc/GMT-12' ? 'selected' : '' }}>
                                            (GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                        <option
                                            value="Pacific/Chatham"{{ Utility::getsettings('time_zone') == 'Pacific/Chatham' ? 'selected' : '' }}>
                                            (GMT+12:45) Chatham Islands</option>
                                        <option
                                            value="Pacific/Tongatapu"{{ Utility::getsettings('time_zone') == 'Pacific/Tongatapu' ? 'selected' : '' }}>
                                            (GMT+13:00) Nuku'alofa</option>
                                        <option
                                            value="Pacific/Kiritimati"{{ Utility::getsettings('time_zone') == 'Pacific/Kiritimati' ? 'selected' : '' }}>
                                            (GMT+14:00) Kiritimati</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group  row">
                                <div class="col-md-8">
                                    {{ Form::label('meeting_poll_limit_selection', __('Limit selection to one option only'), ['class' => 'form-label d-block']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-switch mt-2 float-end custom-switch-v1">
                                        <input type="checkbox" name="limit_selection_to_one_option_only"
                                            id="meeting_poll_limit_selection" class="form-check-input input-primary"
                                            {{ 'unchecked' }}>
                                    </label>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('meeting_poll_set_end_date', __('Set end date'), ['class' => 'form-label']) }}
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            <input type="checkbox" name="meeting_set_end_date"
                                                id="meeting_poll_set_end_date" class="form-check-input input-primary"
                                                {{ 'unchecked' }}>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="meeting_set_end_date" class="{{ 'd-none' }}">
                                <div class="form-group">
                                    <input class="form-control" name="meeting_set_end_date_time"
                                        id="meeting_set_end_date_time">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('meeting_poll_allow_comments', __('Allow comments'), ['class' => 'form-label']) }}
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            <input type="checkbox" name="meeting_allow_comments"
                                                id="meeting_poll_allow_comments" class="form-check-input input-primary"
                                                {{ 'checked' }}>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8">
                                    {{ Form::label('meeting_poll_hide_participants_from_each_other', __('Hide participants from each other'), ['class' => 'form-label']) }}
                                </div>
                                <div class="col-md-4">
                                    <label class="form-switch mt-2 float-end custom-switch-v1">
                                        <input type="checkbox" name="meeting_hide_participants_from_each_other"
                                            id="meeting_poll_hide_participants_from_each_other"
                                            class="form-check-input input-primary" {{ 'unchecked' }}>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end mb-3">
                            {!! Html::link(route('poll.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/polldatepicker/daterangepicker.css') }}" />
@endpush
@push('script')
    <script src="{{ asset('vendor/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/repeater/repeater.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/polldatepicker/daterangepicker.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });
        $(document).on("change", ".image-input", function() {
            files = this.files[0];
            var imgPreview = $(this).parent().parent().find('.image-preview');
            if (files) {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(files);
                fileReader.addEventListener("load", function() {
                    imgPreview.show();
                    imgPreview.parent().addClass('label-none');
                    imgPreview.html('<img src="' + this.result + '" class="img-responsive" />');
                });
            }
        });
    </script>
    <script>
        $("#voting_type").change(function() {
            var test = $(this).val();
            if (test == 'Multiple_choice') {
                $("#Multiple_choice").fadeIn(500);
                $("#Multiple_choice").removeClass('d-none');
                $('#Image_poll').fadeOut(500);
                $('#Meeting_poll').fadeOut(500);
            } else if (test == 'Image_poll') {
                $("#Multiple_choice").fadeOut(500);
                $("#Image_poll").fadeIn(500);
                $("#Image_poll").removeClass('d-none');
                $('#Meeting_poll').fadeOut(500);
            } else {
                $("#Multiple_choice").fadeOut(500);
                $("#Meeting_poll").fadeIn(500);
                $("#Meeting_poll").removeClass('d-none');
                $('#Image_poll').fadeOut(500);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            var $repeater = $('.repeater').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown("fast");
                },
                isFirstItemUndeletable: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var $repeater = $('.repeater-image').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown("fast");
                },
                isFirstItemUndeletable: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(this).find('.time-picker').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                showDropdowns: true,
                minYear: 2000,
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            });
            var $repeater = $('.repeater-meeting').repeater({
                initEmpty: false,
                show: function() {
                    $(this).find('.time-picker').daterangepicker({
                        singleDatePicker: true,
                        timePicker: true,
                        showDropdowns: true,
                        minYear: 2000,
                        locale: {
                            format: 'YYYY-MM-DD HH:mm:ss'
                        }
                    });
                    $(this).slideDown("fast");
                },
                isFirstItemUndeletable: true
            });

        });
    </script>
    <script>
        $(function() {
            $('input[name="set_end_date_time"]').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                showDropdowns: true,
                minYear: 2000,
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            });
        });
        $(function() {
            $('input[name="image_set_end_date_time"]').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                showDropdowns: true,
                minYear: 2000,
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            });
        });
        $(function() {
            $('input[name="meeting_set_end_date_time"]').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                showDropdowns: true,
                minYear: 2000,
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            });
        });
    </script>
    <script>
        $(document).on('click', "input[name$='require_participants_names']", function() {
            if (this.checked) {
                $('#require_participants_names').fadeIn(500);
                $("#require_participants_names").removeClass('d-none');
                $("#require_participants_names").addClass('d-block');
            } else {
                $('#require_participants_names').fadeOut(500);
                $("#require_participants_names").removeClass('d-block');
                $("#require_participants_names").addClass('d-none');
            }
        });
    </script>
    <script>
        $(document).on('click', "input[name$='image_require_participants_names']", function() {
            if (this.checked) {
                $('#image_require_participants_names').fadeIn(500);
                $("#image_require_participants_names").removeClass('d-none');
                $("#image_require_participants_names").addClass('d-block');
            } else {
                $('#image_require_participants_names').fadeOut(500);
                $("#image_require_participants_names").removeClass('d-block');
                $("#image_require_participants_names").addClass('d-none');
            }
        });
    </script>
    <script>
        $(document).on('click', "input[name$='allow_selection']", function() {
            if (this.checked) {
                $('#allow_selection').fadeIn(500);
                $("#allow_selection").removeClass('d-none');
                $("#allow_selection").addClass('d-block');
            } else {
                $('#allow_selection').fadeOut(500);
                $("#allow_selection").removeClass('d-block');
                $("#allow_selection").addClass('d-none');
            }
        });
    </script>
    <script>
        $(document).on('click', "input[name$='image_allow_selection']", function() {
            if (this.checked) {
                $('#image_allow_selection').fadeIn(500);
                $("#image_allow_selection").removeClass('d-none');
                $("#image_allow_selection").addClass('d-block');
            } else {
                $('#image_allow_selection').fadeOut(500);
                $("#image_allow_selection").removeClass('d-block');
                $("#image_allow_selection").addClass('d-none');
            }
        });
    </script>
    <script>
        $(document).on('click', "input[name$='set_end_date']", function() {
            if (this.checked) {
                $('#set_end_date').fadeIn(500);
                $("#set_end_date").removeClass('d-none');
                $("#set_end_date").addClass('d-block');
            } else {
                $('#set_end_date').fadeOut(500);
                $("#set_end_date").removeClass('d-block');
                $("#set_end_date").addClass('d-none');
            }
        });
    </script>
    <script>
        $(document).on('click', "input[name$='meeting_set_end_date']", function() {
            if (this.checked) {
                $('#meeting_set_end_date').fadeIn(500);
                $("#meeting_set_end_date").removeClass('d-none');
                $("#meeting_set_end_date").addClass('d-block');
            } else {
                $('#meeting_set_end_date').fadeOut(500);
                $("#meeting_set_end_date").removeClass('d-block');
                $("#meeting_set_end_date").addClass('d-none');
            }
        });
    </script>
    <script>
        $(document).on('click', "input[name$='image_set_end_date']", function() {
            if (this.checked) {
                $('#image_set_end_date').fadeIn(500);
                $("#image_set_end_date").removeClass('d-none');
                $("#image_set_end_date").addClass('d-block');
            } else {
                $('#image_set_end_date').fadeOut(500);
                $("#image_set_end_date").removeClass('d-block');
                $("#image_set_end_date").addClass('d-none');
            }
        });
    </script>
    <script>
        $(document).on('click', "input[name$='meeting_fixed_time_zone']", function() {
            if (this.checked) {
                $('#meeting_fixed_time_zone').fadeIn(500);
                $("#meeting_fixed_time_zone").removeClass('d-none');
                $("#meeting_fixed_time_zone").addClass('d-block');
            } else {
                $('#meeting_fixed_time_zone').fadeOut(500);
                $("#meeting_fixed_time_zone").removeClass('d-block');
                $("#meeting_fixed_time_zone").addClass('d-none');
            }
        });
    </script>
@endpush
