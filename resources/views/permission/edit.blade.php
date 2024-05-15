{!! Form::model($permission, [
    'route' => ['permission.update', $permission->id],
    'method' => 'Put',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-6 ">
            {{ Form::label('name', __('Enter first name'), ['class' => 'form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="btn-flt float-end">
        {{ Form::button(__('Cancel'), ['class' => 'btn btn-secondary', 'data-bs-dismiss' => 'modal']) }}
        {!! Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-primary']) !!}
    </div>
</div>
{!! Form::close() !!}
