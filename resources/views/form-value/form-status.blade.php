{{ Form::model($formValue , ['route' => ['form-value.status.update' , $formValue->id] ,'method' => 'POST'] ) }}
<div class="row">
    <div class="form-group">
        {{ Form::label('form_status' , __('Form Status') , ['class'=> 'form-label']) }}
        {{ Form::select('form_status' , $formStatus , $formValue->form_status ,  ['class' => 'form-control form-select' ,  'data-trigger']) }}

    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary"><a href="{{ route('forms.index') }}" class="text-white">{{ __('Back') }}</a></button>
    {{ Form::button(__('Save') , ['class' => 'btn btn-primary' , 'type'=>'submit']) }}
</div>
{{ Form::close() }}

