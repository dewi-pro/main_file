{!! Form::model($formLeader, [
    'route' => ['form-leader.update', $formLeader->id],
    'method' => 'put',
    'data-validate',
]) !!}
</div>
<div class="modal-body">
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
        {!! Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group">
        {{ Form::label('handphone', __('Handphone'), ['class' => 'form-label']) }}
        {!! Form::text('handphone', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group">
        {{ Form::label('divisi', __('Divisi'), ['class' => 'form-label']) }}
        {!! Form::text('divisi', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
    </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        {!! Html::link(route('form-leader.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}
</div>
