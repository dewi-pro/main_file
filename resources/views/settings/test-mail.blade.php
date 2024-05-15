{!! Form::open(['route' => 'test.send.mail', 'method' => 'POST']) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12 ">
            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter email'), 'required']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        {{ Form::button(__('Cancel'), ['class' => 'btn btn-secondary', 'data-bs-dismiss' => 'modal']) }}
        {{ Form::button(__('Send'), ['type' => 'submit','class' => 'btn btn-primary', 'id' => 'save-btn']) }}
    </div>
</div>
{!! Form::close() !!}
