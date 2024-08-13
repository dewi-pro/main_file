{!! Form::open([
    'route' => 'form-destination.store',
    'method' => 'Post',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="form-group">
        {{ Form::label('type', __('Type'), ['class' => 'form-label']) }}
        {!! Form::hidden('type', null, ['id' => 'type-hidden']) !!}
        {{ Form::select(
            'Type',
            [
                '' => __('Select Form Type'),
                '1' => __('Tour'),
                '2' => __('NonTour'),
            ],
            null,
            ['class' => 'custom_select form-select', 'id' => 'type', 'data-trigger'],
        ) }}
    </div>
    <div class="form-group">
        {{ Form::label('category_id', __('Category'), ['class' => 'form-label']) }}
        {{ Form::select(
            'Category',
            [
                '' => __('Select Form Category'),
                '1' => __('SME'),
                '2' => __('MICE'),
            ],
            null,
            ['class' => 'custom_select form-select', 'id' => 'category_id', 'data-trigger'],
        ) }}
    </div>
    <div class="form-group">
        {{ Form::label('destination', __('Destination'), ['class' => 'form-label']) }}
        {!! Form::text('destination', null, ['placeholder' => __('Enter destination'), 'class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group">
        {{ Form::label('tourCode', __('Tour Code'), ['class' => 'form-label']) }}
        {!! Form::text('tourCode', null, ['placeholder' => __('Enter Tour Code'), 'class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group">
        {{ Form::label('tourLead', __('Tour Leader'), ['class' => 'form-label']) }}
        {!! Form::hidden('tourLead', null, ['id' => 'tourLead-hidden']) !!}
        {{ Form::select(
            'Tour Leader',
            [
                '' => __('Select Tour Leader'),
                '1' => __('Andrian'),
                '2' => __('Nanami'),
            ],
            null,
            ['class' => 'custom_select form-select', 'id' => 'tourLead', 'data-trigger'],
        ) }}
    </div>
</div>

<div class="modal-footer">
    <div class="text-end">
        {!! Html::link(route('form-destination.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}
