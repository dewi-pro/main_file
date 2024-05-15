{{ Form::open([
    'route' => 'event.store',
    'method' => 'POST',
    'data-validate',
]) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
            <div class="form-group">
                @if (Auth::user()->type == 'Admin')
                {{ Form::label('user[]', __('User'), ['class' => 'form-label']) }}
                {{ Form::select('user[]', $users, null, ['class' => 'form-select', 'required','id' => 'user', 'multiple', 'data-trigger']) }}
                @endif
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
            <div class="form-group">
                {{ Form::label('title', __('Event Title'), ['class' => 'form-label']) }}
                {{ Form::text('title', null, ['class' => 'form-control ', 'placeholder' => __('Enter event title')]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                {{ Form::text('start_date', $startDate, ['class' => 'form-control ', 'placeholder' => __('Enter start date'), 'id' => 'start_date']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                {{ Form::text('end_date', $endDate, ['class' => 'form-control ', 'placeholder' => __('Enter end date'), 'id' => 'end_date']) }}
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
            <div class="form-group">
                {{ Form::label('color', __('Event Select Color'), ['class' => 'form-label d-block mb-3']) }}
                <div class="btn-group-toggle btn-group-colors event-tag" data-toggle="buttons">
                    <label class="p-3 btn bg-info"><input type="radio" name="color" id="color" value="event-info" checked
                            class="d-none"></label>
                    <label class="p-3 btn bg-warning"><input type="radio" name="color" id="color" value="event-warning"
                            class="d-none"></label>
                    <label class="p-3 btn bg-danger"><input type="radio" name="color" id="color" value="event-danger"
                            class="d-none"></label>
                    <label class="p-3 btn bg-success"><input type="radio" name="color" id="color" value="event-success"
                            class="d-none"></label>
                    <label class="p-3 btn bg-primary"><input type="radio" name="color" id="color" class="d-none"
                            value="event-primary"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('description', __('Event Description'), ['class' => 'form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter event description'), 'rows' => '5']) }}
        </div>
        @if (Utility::getsettings('google_calendar_enable') && Utility::getsettings('google_calendar_enable') == 'on')
            <div class="form-group col-md-12">
                {{ Form::label('switch-shadow', __('Synchronize in Google Calendar ?'), ['class' => 'form-label']) }}
                <div class="form-switch float-end">
                    <input type="checkbox" class="mt-2 form-check-input" name="synchronize_type" id="switch-shadow"
                        value="google_calender">
                    <label class="form-check-label" for="switch-shadow"></label>
                </div>
            </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Save') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
