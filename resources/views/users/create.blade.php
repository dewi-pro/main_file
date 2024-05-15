{!! Form::open([
    'route' => 'users.store',
    'method' => 'Post',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group  ">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter name')]) !!}
        </div>
        <div class="form-group ">
            {{ Form::label('email', __('Email'), ['class' => 'col-form-label']) }}
            {!! Form::text('email', null, [
                'class' => 'form-control',
                'required',
                'placeholder' => __('Enter email address'),
            ]) !!}
        </div>
        <div class="form-group">
            {{ Form::label('password', __('Password'), ['class' => 'col-form-label']) }}
            {!! Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => __('Enter password')]) !!}
        </div>
        <div class="form-group">
            {{ Form::label('confirm-password', __('Confirm Password'), ['class' => 'col-form-label']) }}
            {{ Form::password('confirm-password', ['class' => 'form-control', 'required', 'placeholder' => __('Enter confirm password')]) }}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('country_code', __('Country Code'), ['class' => 'd-block form-label']) }}
            <select id="country_code" name="country_code"class="form-control" data-trigger>
                @foreach (\App\Core\Data::getCountriesList() as $key => $value)
                    <option data-kt-flag="{{ $value['flag'] }}" value="{{ $key }}">
                        +{{ $value['phone_code'] }} {{ $value['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            {{ Form::label('phone', __('Phone Number'), ['class' => 'form-label']) }}
            {!! Form::number('phone', null, [
                'autofocus' => '',
                'required' => true,
                'autocomplete' => 'off',
                'placeholder' => __('Enter phone Number'),
                'class' => 'form-control',
            ]) !!}
        </div>
        <div class="form-group">
            {{ Form::label('roles', __('Role'), ['class' => 'col-form-label']) }}
            {!! Form::select('roles', $roles, null, ['class' => 'form-select', 'id' => 'roles']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}
