{!! Form::model($headerMenuEdit, [
    'route' => ['header.menu.update', $headerMenuEdit->id],
    'method' => 'POST',
    'data-validate',
    'no-validate',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('select_page', __('Select page'), ['class' => 'col-form-label']) }}
                {!! Form::select('page_id', $pages, null, [
                    'class' => 'form-select',
                    'required',
                    'id' => 'page_name',
                ]) !!}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{{ Form::close() }}
