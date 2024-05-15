@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($poll->id);
    use Carbon\Carbon;
    use App\Facades\UtilityFacades;
@endphp
@extends('layouts.form')
@section('title', __('Vote'))
@section('content')
    <div class="row">
        {{ Form::model($poll, ['route' => ['image.poll.store', $poll->id], 'data-validate', 'method' => 'POST', 'class' => 'form-horizontal']) }}
        <div class="row">
            <div class="mx-auto col-xl-7 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Vote') }}</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="mb-0">{{ $poll->title }}</h3>
                        <span class="text-left">
                            <small>{{ $poll->created_at->diffForHumans() }}</small>
                        </span>
                        <div class="form-group">
                            <label class="col-3 col-form-label">{{ __('Make a choice:') }}</label>
                        </div>
                        <div class="row">
                            @if (isset($options->image_answer_options))
                                @foreach ($options->image_answer_options as $key => $option)
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div id="carouselExampleSlidesOnly" class="carousel slide"
                                                    data-bs-ride="carousel">
                                                    <div class="carousel-inner">
                                                        <div class="carousel-item active">
                                                            <img class="img-fluid d-block" height="200"
                                                                src="{{ Storage::exists($option->image) ? Storage::url($option->image) : Storage::url('app-logo/200x100.png') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="optional_name"
                                                        value="{{ $option->optional_name }}"
                                                        id="{{ $option->optional_name }}">
                                                    <label class="form-check-label" for="{{ $option->optional_name }}">
                                                        {{ $option->optional_name }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if ($poll->image_require_participants_names == 1)
                                <div class="form-group">
                                    {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter Name')]) !!}
                                </div>
                            @endif
                            @if ($poll->image_set_end_date == 1)
                                <h6>{{ __('Voting ends in') }}
                                    {{ Carbon::parse($poll->image_set_end_date_time)->diffForHumans() }}</h6>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            {!! Form::button(__('Vote'), ['type' => 'submit','class' => 'btn btn-primary col-md-3']) !!}
                            @if ($poll->image_results_visibility == 'always_public')
                                <a href="{{ route('poll.public.result.image', $id) }}" class="btn btn-success"><i
                                        class="me-2" data-feather="award"></i>{{ __('Result') }}</a>
                            @elseif($poll->image_results_visibility == 'public_after_end_date')
                                <a href="{{ route('poll.public.result.image', $id) }}" class="btn btn-success"><i
                                        class="me-2" data-feather="award"></i>{{ __('Result') }}</a>
                            @elseif($poll->image_results_visibility == 'public_after_vote')
                                <a href="{{ route('poll.public.result.image', $id) }}" class="btn btn-success"><i
                                        class="me-2" data-feather="award"></i>{{ __('Result') }}</a>
                            @else
                            @endif
                            <a class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="share"
                                href="javascript:void(0);" id="share-poll"
                                data-action="{{ route('poll.share.image', $id) }}"><i class="me-2"
                                    data-feather="share-2"></i>{{ __('Share') }}</a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="m-auto form-group col-2">
        @if ($poll->image_voting_restrictions == 'One_vote_per_ip_address')
            <p><i class="me-2" data-feather="lock"></i>{{ __('One vote per IP-Address allowed.') }}</p>
        @elseif ($poll->image_voting_restrictions == 'One_vote_per_browser_session')
            <p><i class="me-2" data-feather="lock"></i>{{ __('One vote per browser sesssion allowed.') }}</p>
        @else
            <p><i class="me-2" data-feather="lock"></i>{{ __('One vote per user account allowed..') }}</p>
        @endif
    </div>
    <div class="row">
        <div class="mx-auto col-xl-7 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <h5> <i class="me-2" data-feather="share-2"></i>{{ __('Share') }}</h5>
                </div>
                <div class="card-body ">
                    <div class="m-auto form-group col-6">
                        <p>{{ __('Use this link to share the poll with your participants.') }}</p>
                        <div class="input-group">
                            <input type="text" value="{{ route('poll.survey.image', $id) }}"
                                class="form-control js-content" id="pc-clipboard-1" placeholder="Type some value to copy">
                            <a href="#" class="btn btn-primary js-copy" data-clipboard="true"
                                data-clipboard-target="#pc-clipboard-1"> {{ __('Copy') }}
                            </a>
                        </div>
                        <div class="mt-3 social-links-share">
                            <a href="https://api.whatsapp.com/send?text={{ route('poll.survey.image', $id) }}"
                                title="Whatsapp" class="social-links-share-main">
                                <i class="ti ti-brand-whatsapp"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ route('poll.survey.image', $id) }}"
                                title="Twitter" class="social-links-share-main">
                                <i class="ti ti-brand-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/share.php?u={{ route('poll.survey.image', $id) }}"
                                title="Facebook" class="social-links-share-main">
                                <i class="ti ti-brand-facebook"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('poll.survey.image', $id) }}"
                                title="Linkedin" class="social-links-share-main">
                                <i class="ti ti-brand-linkedin"></i>
                            </a>
                            <a href="javascript:void(1);" class="social-links-share-main" title="Show QR Code"
                                data-action="{{ route('poll.share.qr.image', $id) }}" id="share-qr-image">
                                <i class="ti ti-qrcode"></i>
                            </a>
                            <a href="javascript:void(0)" title="Embed" class="social-links-share-main"
                                onclick="copyToClipboard('#embed-form-{{ $poll->id }}')"
                                id="embed-form-{{ $poll->id }}"
                                data-url='<iframe src="{{ route('poll.survey.image', $id) }}" scrolling="auto" align="bottom" height="100vh" width="100%"></iframe>'>
                                <i class="ti ti-code"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($poll->image_allow_comments == 1)
        <div class="row">
            <div class="mx-auto col-xl-7 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <h5> <i class="me-2" data-feather="message-circle"></i>{{ __('Comments') }}</h5>
                    </div>
                    {!! Form::open([
                        'route' => 'comment.store',
                        'method' => 'Post',
                    ]) !!}
                    <div class="card-body">
                        <div class="form-group">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter your name')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::textarea('comment', null, [
                                'class' => 'form-control',
                                'rows' => '3',
                                'required',
                                'placeholder' => __('Add a comment'),
                            ]) !!}
                        </div>
                    </div>
                    <input type="hidden" id="poll_id" name="poll_id" value="{{ $poll->id }}">
                    <div class="card-footer">
                        <div class="text-end">
                            {!! Form::button(__('Add a comment'), ['type' => 'submit','class' => 'btn btn-primary col-md-3']) !!}
                        </div>
                        {!! Form::close() !!}

                        @foreach ($poll->commmant as $value)
                            <div class="comments-item">
                                <div class="comment-user-icon">
                                    <img src="{{ asset('assets/images/comment.png') }}" alt="">
                                </div>
                                <span class="text-left comment-info">
                                    <h6>{{ $value->name }}</h6>
                                    <span class="d-block"><small>{{ $value->comment }}</small></span>
                                    <h6 class="d-block"><small>({{ $value->created_at->diffForHumans() }})</small>
                                        <a href="#reply-comment" class="text-dark reply-comment-{{ $value->id }}"
                                            id="comment-reply" data-bs-toggle="collapse" data-id="{{ $value->id }}"
                                            title="{{ __('Reply') }}">
                                            {{ __('Reply') }}</i></a>
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['comment.destroy', $value->id],
                                            'id' => 'delete-form-' . $value->id,
                                            'class' => 'd-inline',
                                        ]) !!}
                                        {!! Form::close() !!}
                                    </h6>
                                    <li class="list-inline-item"> </li>
                                    @foreach ($value->replyby as $replyValue)
                                        <div class="comment-replies">
                                            <div class="comment-user-icon">
                                                <img src="{{ asset('assets/images/comment.png') }}" alt="">
                                            </div>
                                            <div class="comment-replies-content">
                                                <h6>{{ $replyValue->name }}</h6>
                                                <span class="d-block"><small>{{ $replyValue->reply }}</small></span>
                                                <h6 class="d-block">
                                                    <small>({{ $replyValue->created_at->diffForHumans() }})</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </span>
                            </div>
                            {!! Form::open([
                                'route' => 'comment.reply.store',
                                'method' => 'Post',
                                'data-validate',
                            ]) !!}
                            <div class="row commant" id="reply-comment-{{ $value->id }}">
                                <div class="form-group">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter your name')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::textarea('reply', null, [
                                        'class' => 'form-control',
                                        'rows' => '2',
                                        'required',
                                        'placeholder' => __('Add a comment'),
                                    ]) !!}
                                </div>
                                <input type="hidden" id="poll_id" name="poll_id" value="{{ $poll->id }}">
                                <input type="hidden" id="comment_id" name="comment_id" value="{{ $value->id }}">
                                <div class="card-footer">
                                    <div class="text-end">
                                        {!! Form::button(__('Add a Reply'), ['type' => 'submit','class' => 'btn btn-primary col-md-3']) !!}
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('script')
    <script src="{{ asset('assets/js/plugins/clipboard.min.js') }}"></script>
    <script>
        new ClipboardJS('[data-clipboard=true]').on('success', function(e) {
            e.clearSelection();
        });
    </script>
    <script>
        $(function() {
            $('body').on('click', '#share-poll', function() {
                var action = $(this).data('action');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Share') }}');
                    modal.find('.modal-body').html(response.html);
                    feather.replace();
                    let area = document.createElement('textarea');
                    document.body.appendChild(area);
                    area.style.display = "none";
                    let content = document.querySelectorAll('.js-content');
                    let copy = document.querySelectorAll('.js-copy');
                    for (let i = 0; i < copy.length; i++) {
                        copy[i].addEventListener('click', function() {
                            area.style.display = "block";
                            area.value = content[i].innerText;
                            area.select();
                            document.execCommand('copy');
                            area.style.display = "none";
                            this.innerHTML = 'Copied ';
                            setTimeout(() => this.innerHTML = "Copy", 2000);
                        });
                    }
                    modal.modal('show');
                })
            });
        });
    </script>
    <script>
        $(function() {
            $('body').on('click', '#share-qr-image', function() {
                var action = $(this).data('action');
                var modal = $('#common_modal1');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('QR Code') }}');
                    modal.find('.modal-body').html(response.html);
                    feather.replace();
                    modal.modal('show');
                })
            });
        });
    </script>
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).attr('data-url')).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Great!', '{{ __('Copy Link Successfully..') }}', 'success',
                '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.commant').hide();
            $(document).on('click', '#comment-reply', function() {
                var dataId = $(this).attr("data-id");
                $('#reply-comment-' + dataId).show();

            });
        });
    </script>
    <script>
        (function() {
            let area = document.createElement('textarea');
            document.body.appendChild(area);
            area.style.display = "none";
            let content = document.querySelectorAll('.js-content');
            let copy = document.querySelectorAll('.js-copy');
            for (let i = 0; i < copy.length; i++) {
                copy[i].addEventListener('click', function() {
                    area.style.display = "block";
                    area.value = content[i].innerText;
                    area.select();
                    document.execCommand('copy');
                    area.style.display = "none";
                    this.innerHTML = 'Copied ';
                    setTimeout(() => this.innerHTML = "Copy", 2000);
                });
            }
        })();
    </script>
@endpush
