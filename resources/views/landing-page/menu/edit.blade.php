{{Form::model(null, array('route' => array('menu.update', $key), 'method' => 'POST','enctype' => "multipart/form-data" , 'data-validate',
'no-validate')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('menu_name', __('Menu Name'), ['class' => 'form-label']) }}
                {!! Form::text('menu_name', $menu['menu_name'], [
                    'class' => 'form-control',
                    'placeholder' => __('Enter menu name'),
                ]) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('menu_bold_name', __('Menu Bold Name'), ['class' => 'form-label']) }}
                {!! Form::text('menu_bold_name', $menu['menu_bold_name'], [
                    'class' => 'form-control',
                    'placeholder' => __('Enter menu bold name'),
                ]) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('menu_detail', __('Menu Detail'), ['class' => 'form-label']) }}
                {!! Form::textarea('menu_detail', $menu['menu_detail'], [
                    'class' => 'form-control',
                    'rows' => '3',
                    'placeholder' => __('Enter menu detail'),
                ]) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('menu_image', __('Image'), ['class' => 'form-label']) }}
                *
                {!! Form::file('menu_image', ['class' => 'form-control', 'id' => 'menu_image']) !!}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        {{ Form::button(__('Save'), ['type' => 'submit',  'class' => 'btn btn-primary']) }}
    </div>
</div>
{{ Form::close() }}
