@extends('layouts.main')
@section('title', __('Users'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('View') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('View') }}</li>
        </ul>

        <div class="float-end">
            <div class="d-flex align-items-center">
                <a href="{{ route('grid.view') }}" data-bs-toggle="tooltip" title="{{ __('List View') }}"
                    class="btn btn-sm btn-primary" data-bs-placement="bottom">
                    <i class="ti ti-list"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                @foreach ($users as $user)
                    <div class="col-xl-3 col-lg-4 col-me-6 col-sm-6 col-12 d-flex">
                        <div class="text-center text-white card w-100 h-100">
                            <div class="pb-0 border-0 card-header">
                                <div class="d-flex align-items-center">
                                    <span class="p-2 px-3 rounded badge bg-primary">{{ $user->type }}</span>
                                </div>
                                <div class="card-header-right">
                                    <div class="btn-group card-option">
                                        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @can('edit-user')
                                                <a class="dropdown-item" href="javascript:void(0);" id="edit-user"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-original-title="{{ __('Edit') }}"
                                                    data-url="{{ route('users.edit', $user->id) }}"><i class="ti ti-edit"></i>
                                                    <span>{{ __('Edit') }}</span></a>
                                            @endcan

                                            @if ($user->email_verified_at != '')
                                                <a class="dropdown-item" href="{{ route('user.verified', $user->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-original-title="{{ __('Email Verified') }}">
                                                    <i class="ti ti-mail"></i><span>{{ __('Email Verified') }}</span></a>
                                            @else
                                                <a class="dropdown-item" href="{{ route('user.verified', $user->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-original-title="{{ __('Email Unverified') }}">
                                                    <i
                                                        class="ti ti-mail-forward"></i><span>{{ __('Email Unverified') }}</span></a>
                                            @endif
                                            @if ($user->phone_verified_at != '')
                                                <a class="dropdown-item"
                                                    href="{{ route('user.phoneverified', $user->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-original-title="{{ __('Phone Verified') }}">
                                                    <i
                                                        class="ti ti-message-circle"></i><span>{{ __('Phone Verified') }}</span></a>
                                            @else
                                                <a class="dropdown-item"
                                                    href="{{ route('user.phoneverified', $user->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-original-title="{{ __('Phone Unverified') }}">
                                                    <i
                                                        class="ti ti-message-circle"></i><span>{{ __('Phone Unverified') }}</span></a>
                                            @endif
                                            @can('impersonate-user')
                                                <a class="dropdown-item" target="_new"
                                                    href="{{ route('users.impersonate', $user->id) }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-original-title="{{ __('Impersonate') }}"
                                                    aria-label="{{ __('Impersonate') }}">
                                                    <i class="ti ti-new-section"><span
                                                            class="font-fmaily">{{ __('Impersonate') }}</span></i>
                                                </a>
                                            @endcan
                                            @can('delete-user')
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['users.destroy', $user->id],
                                                    'id' => 'delete-form-' . $user->id,
                                                    'class' => 'd-inline',
                                                ]) !!}
                                                <a href="#" class="dropdown-item show_confirm"
                                                    id="delete-form-{{ $user->id }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-original-title="{{ __('Delete') }}"><i
                                                        class="mr-0 ti ti-trash"></i><span>Delete</span></a>
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <img src="{{ Storage::exists(Auth::user()->avatar) ? Storage::url(Auth::user()->avatar) : Auth::user()->avatar_image }}"
                                    alt="user-image" width="100px" class="rounded-circle">
                                <h4 class="mt-2 text-dark">{{ $user->name }}</h4>
                                <small class="text-dark">{{ $user->email }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-xl-3 col-lg-4 col-me-6 col-sm-6 col-12 d-flex create-grid-user">
                    <a class="btn-addnew-project h-100 w-100 add_user">
                        <div class="bg-primary add_user proj-add-icon">
                            <i class="ti ti-plus"></i>
                        </div>
                        <h6 class="mt-4 mb-2">{{ __('New User') }}</h6>
                        <p class="text-center text-muted">{{ __('Click here to add new User') }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        $(function() {
            $('body').on('click', '.add_user', function() {
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: '{{ route('users.create') }}',
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('{{ __('Create User') }}');
                        modal.find('.body').html(response.html);
                        modal.modal('show');
                        var multipleCancelButton = new Choices('#roles', {
                            removeItemButton: true,
                        });
                        var multipleCancelButton = new Choices('#country_code', {
                            removeItemButton: true,
                        });
                    },
                    error: function(error) {}
                });
            });

            $('body').on('click', '#edit-user', function() {
                var action = $(this).attr('data-url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Edit User') }}');
                    modal.find('.body').html(response.html);
                    modal.modal('show');
                    var multipleCancelButton = new Choices('#roles', {
                        removeItemButton: true,
                    });
                    var multipleCancelButton = new Choices('#country_code', {
                        removeItemButton: true,
                    });
                })
            });
        });
    </script>
@endpush
