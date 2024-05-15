{{ Form::model($event, ['route' => ['event.update', $event->id], 'method' => 'patch']) }}
@method('put')
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            @if (Auth::user()->type == 'Admin')
                <div class="form-group">
                    {{ Form::label('user[]', __('User'), ['class' => 'form-label']) }}
                    {{ Form::select('user[]', $users, $selectedUsers, ['id' => 'user', 'required', 'class' => 'form-select', 'multiple', 'data-trigger']) }}
                </div>
            @endif
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('title', __('Event Title'), ['class' => 'form-label']) }}
                {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Event Title')]) }}
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
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('color', __('Event Select Color'), ['class' => 'col-form-label d-block mb-3']) }}
                <div class=" btn-group-toggle btn-group-colors event-tag" data-toggle="buttons">
                    <label
                        class="btn bg-info p-3 {{ $event->color == 'event-info'
                            ? 'custom_color_radio_button
                                                                                                                                                                                                                                                                                                                    '
                            : '' }} "><input
                            type="radio" name="color" class="d-none" id="color" value="event-info"
                            {{ $event->color == 'event-info' ? 'checked' : '' }}></label>

                    <label
                        class="btn bg-warning p-3 {{ $event->color == 'event-warning' ? 'active' : '' }}"><input
                            type="radio" class="d-none" name="color" id="color" value="event-warning"
                            {{ $event->color == 'event-warning' ? 'checked' : '' }}></label>

                    <label
                        class="btn bg-danger p-3 {{ $event->color == 'event-danger' ? 'active' : '' }}"><input
                            type="radio" name="color" class="d-none" id="color" value="event-danger"
                            {{ $event->color == 'event-danger' ? 'checked' : '' }}></label>


                    <label
                        class="btn bg-success p-3 {{ $event->color == 'event-success' ? 'active' : '' }}"><input
                            type="radio" class="d-none" name="color" id="color" value="event-success"
                            {{ $event->color == 'event-success' ? 'checked' : '' }}></label>

                    <label
                        class="btn bg-primary p-3 {{ $event->color == 'event-primary' ? 'active' : '' }}"><input
                            type="radio" class="d-none" name="color" id="color" value="event-primary"
                            {{ $event->color == 'event-primary' ? 'checked' : '' }}></label>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Event Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Event Description')]) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Save') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
