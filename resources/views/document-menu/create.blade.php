{!! Form::open([
    'route' => 'docmenu.store',
    'method' => 'Post',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
            {!! Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter title')]) !!}
        </div>
        <input type="hidden" name="document_id" value="{{ $documents->id }}">
    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}

