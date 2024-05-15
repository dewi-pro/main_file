{!! Form::model($dashboard, [
    'route' => ['update.dashboard', $dashboard->id],
    'method' => 'Put',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group ">
            {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
            {!! Form::text('title', null, [
                'class' => 'form-control',
                'id' => 'password',
                'required',
                'placeholder' => __('Enter title'),
            ]) !!}
        </div>
        <div class="form-group ">
            {{ Form::label('size', __('Size'), ['class' => 'form-label']) }}
            {!! Form::select('size', config('static.widget_size'), round($dashboard->size), [
                'size' => '1',
                'class' => 'form-select',
                'required',
                'data-trigger',
            ]) !!}
        </div>
        <div class="form-group">
            {{ Form::label('type', __('Type'), ['class' => 'form-label']) }}
            {!! Form::text('type', $dashboard->type, [
                'class' => 'form-control',
                'required',
                'readonly',
            ]) !!}
        </div>
        <div id="form" class="{{ $dashboard->type == 'form' ? 'd-block' : 'd-none' }}">
            <div class="form-group ">
                {{ Form::label('form_title', __('Form Title'), ['class' => 'form-label']) }}
                {!! Form::select('form_title', $forms, $dashboard->form_id, [
                    'class' => 'form-select',
                    'id' => 'form_title',
                    'data-trigger',
                ]) !!}
            </div>
            <div class="form-group ">
                {{ Form::label('field_name', __('Field Name'), ['class' => 'form-label']) }}
                <div class="field_name">
                    {!! Form::select('field_name', $label, $dashboard->field_name, ['class' => 'form-control', 'data-trigger']) !!}
                    <div class="invalid-feedback">
                        {{ __('Sel Inter is required') }}
                    </div>
                </div>
            </div>
        </div>
        <div id="poll" class="{{ $dashboard->type == 'poll' ? 'd-block' : 'd-none' }}">
            <div class="form-group">
                {{ Form::label('poll_title', __('Poll Title'), ['class' => 'form-label']) }}
                {!! Form::select('poll_title', $polls, $dashboard->poll_id, [
                    'class' => 'form-select',
                    'id' => 'poll_title',
                    'data-trigger',
                ]) !!}
            </div>
        </div>
        <div class="form-group ">
            {{ Form::label('chart_type', __('Chart Type'), ['class' => 'form-label']) }}
            {!! Form::select('chart_type', config('static.chart_type'), $dashboard->chart_type, [
                'size' => '1',
                'class' => 'form-select',
                'required',
                'data-trigger',
            ]) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        {{ Form::button(__('Cancel'), ['class' => 'btn btn-secondary', 'data-bs-dismiss' => 'modal']) }}
        {!! Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-primary']) !!}
    </div>
</div>
{!! Form::close() !!}
<script>
    $("#type").change(function() {
        var test = $(this).val();
        if (test == 'form') {
            $("#form").fadeIn(500);
            $("#form").removeClass('d-none');
            $('#poll').fadeOut(500);
            $("#poll").addClass('d-none');
        } else {
            $("#form").fadeOut(500);
            $("#poll").fadeIn(500);
            $("#poll").removeClass('d-none');
            $("#form").addClass('d-none');
        }
    });
</script>
