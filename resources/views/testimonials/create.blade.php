@extends('layouts.main')
@section('title', __('Create Testimonials'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Testimonials') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('testimonial.index'), __('Testimonial'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Create Testimonials') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="section-body">
            <div class="m-auto col-md-6">
                <div class="card ">
                    <div class="card-header">
                        <h5> {{ __('Create Testimonial') }}</h5>
                    </div>
                    {!! Form::open([
                        'route' => 'testimonial.store',
                        'method' => 'Post',
                        'enctype' => 'multipart/form-data',
                        'data-validate',
                    ]) !!}
                    <div class="card-body">
                        <div class="form-group ">
                            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                            {!! Form::text('name', null, ['class' => 'form-control', ' required', 'placeholder' => __('Enter name')]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                            {!! Form::text('title', null, ['class' => 'form-control', ' required', 'placeholder' => __('Enter title')]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('image', __('Image'), ['class' => 'form-label']) }}
                            {!! Form::file('image', ['class' => 'form-control' , 'id'=>'image']) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('designation', __('Designation'), ['class' => 'form-label']) }}
                            {!! Form::text('designation', null, [
                                'class' => 'form-control',
                                ' required',
                                'placeholder' => __('Enter designation'),
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('desc', __('Description'), ['class' => 'form-label']) }}
                            {!! Form::textarea('desc', null, [
                                'class' => 'form-control',
                                ' required',
                                'rows' => 3,
                                'placeholder' => __('Enter description'),
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('rating', __('Star Rating'), ['class' => 'form-label']) }}
                            <div id="rating" class="starRating jq-ry-container" data-value="0" data-num_of_star="5">
                            </div>
                            {!! Form::hidden('rating', 0, ['class' => 'calculate', 'data-star' => 5, ]) !!}
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="mb-3 btn-flt float-end">
                            {!! Html::link(route('testimonial.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                            {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('style')
    <link href="{{ asset('vendor/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet" />
@endpush
@push('script')
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
    <script>
        var $starRating = $('.starRating');
        if ($starRating.length) {
            $starRating.each(function() {
                var val = $(this).attr('data-value');
                var num_of_star = $(this).attr('data-num_of_star');
                $(this).rateYo({
                    rating: val,
                    halfStar: true,
                    numStars: num_of_star,
                    precision: 2,
                    onSet: function(rating, rateYoInstance) {
                        num_of_star = $(rateYoInstance.node).attr('data-num_of_star');
                        var input = ($(rateYoInstance.node).attr('id'));
                        if (num_of_star == 10) {
                            rating = rating * 2;
                        }
                        $('input[name="' + input + '"]').val(rating);
                    }
                })
            });
        }
    </script>
@endpush
