{!! Form::open([
    'route' => 'store.dashboard',
    'method' => 'Post',
    'data-validate',
    'novalidate',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
            {!! Form::text('title', null, [
                'class' => 'form-control',
                'id' => 'password',
                'required',
                'placeholder' => __('Enter title'),
            ]) !!}
        </div>
        <div class="form-group">
            {{ Form::label('size', __('Size'), ['class' => 'form-label']) }}
            {!! Form::select('size', config('static.widget_size'), null, [
                'class' => 'form-select',
                'required',
                'data-trigger',
            ]) !!}
        </div>
        <div class="form-group">
            {{ Form::label('type', __('Type'), ['class' => 'form-label']) }}
            {!! Form::select('type', $p, null, [
                'class' => 'form-select text-upper',
                'required',
                'data-trigger',
            ]) !!}
            <div class="error-message" id="bouncer-error_type"></div>
        </div>
        <div id="form" class="d-none">
            <div class="form-group">
                {{ Form::label('form_title', __('Form Title'), ['class' => 'form-label']) }}
                {!! Form::select('form_title', $forms, null, [
                    'class' => 'form-select',
                    'id' => 'form_title',
                    'data-trigger',
                ]) !!}
            </div>
            <div class="form-group">
                {{ Form::label('field_name', __('Field Name'), ['class' => 'form-label']) }}
                <div class="field_name">
                    {!! Form::select('field_name', [], null, ['class' => 'form-control', 'data-trigger']) !!}
                </div>
            </div>
        </div>
        <div id="poll" class="d-none">
            <div class="form-group">
                {{ Form::label('poll_title', __('Poll Title'), ['class' => 'form-label']) }}
                {!! Form::select('poll_title', $polls, null, [
                    'class' => 'form-select',
                    'id' => 'poll_title',
                    'data-trigger',
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('chart_type', __('Chart Type'), ['class' => 'form-label']) }}
            {!! Form::select('chart_type', config('static.chart_type'), null, [
                'class' => 'form-select text-upper',
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
        $('#poll').hide();
        $('#form').hide();
        var test = $(this).val();
        if (test == 'form') {
            $('#poll').hide();
            $('#form').show();
            $("#form").fadeIn(500);
            $("#form").removeClass('d-none');
            $('#poll').fadeOut(500);
        } else {
            $('#form').hide();
            $('#poll').show();
            $("#form").fadeOut(500);
            $("#poll").fadeIn(500);
            $("#poll").removeClass('d-none');
        }
    });
</script>
