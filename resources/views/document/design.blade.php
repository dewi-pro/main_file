@extends('layouts.main')
@section('title', __('Document Generate'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Document Generate') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item"><a href="{{ route('document.index') }}">{{ __('Documents') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Document Generate') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div id="document">
            <div class="card-body">
                <div class="row">
                    @include('document.sidebar-menu')
                    <div class="col-lg-8 col-sm-6 col-md-6 d-flex">
                        <div class="card w-100">
                            <div class="card-header">
                                <span>{{ __('Document Generate') }}</span>
                            </div>
                            <div class="card-body">
                                <div class="inner-content">
                                    @php
                                        $docMenu = App\Models\DocumentMenu::where('document_id', $document->id)
                                            ->orderBy('position')
                                            ->first();
                                    @endphp
                                    <div class="document_save">
                                        <div class="card-body" id="autoSave">
                                            <div id="editor" class="design_jss">
                                                <div id="editorjs"
                                                    data-json="{{ isset($docMenu->json) ? $docMenu->json : '' }}"
                                                    class="autoSave"
                                                    data-id="{{ isset($docMenu->id) ? $docMenu->id : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('vendor/editorjs/js/editorjslatest.js') }}"></script>
    <script src="{{ asset('vendor/editorjs/js/headerlatest.js') }}"></script>
    <script src="{{ asset('vendor/editorjs/js/listlatest.js') }}"></script>
    <script src="{{ asset('vendor/editorjs/js/checklistlatest.js') }}"></script>
    <script src="{{ asset('vendor/editorjs/js/quotelatest.js') }}"></script>
    <script src="{{ asset('vendor/editorjs/js/raw.js') }}"></script>
    <script src="{{ asset('vendor/editorjs/js/codelatest.js') }}"></script>
    <script src="{{ asset('vendor/editorjs/js/tablelatest.js') }}"></script>
    <script src="{{ asset('vendor/editorjs/js/warninglatest.js') }}"></script>
    <script src="{{ asset('vendor/editorjs/js/delimiterlatest.js') }}"></script>
    <script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        // menu submenu hide show
        $(document).ready(function() {
            $('.toolone').click(function() {
                $(this).find('.plugin').toggle(200);
            });
            $('.toolone li').click(function(e) {
                e.stopPropagation();
            })
        });

        var editor;

        function autoSave(value) {
            var dataid = $('#menu_id').attr('value');
            if (dataid) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('document/design-menu/') }}/" + dataid,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        value: value,
                        id: dataid
                    },
                    success: function(data) {},

                });
            } else {
                var url = $('.add_docmenu').attr('data-url');
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('Create Menu');
                        modal.find('.body').html(response);
                        modal.modal('show');
                    },
                    error: function(error) {}
                });
            }
        }

        function createEditor(json) {
            editor = new EditorJS({
                readOnly: false,
                holder: 'editorjs',
                inlineToolbar: ['link', 'bold', 'italic'],
                tools: {
                    heading: {
                        class: Header,
                        inlineToolbar: ['link'],
                        config: {
                            placeholder: 'Header'
                        },
                        shortcut: 'CMD+SHIFT+H'
                    },
                    list: {
                        class: List,
                        inlineToolbar: true,
                        shortcut: 'CMD+SHIFT+L'
                    },
                    checklist: {
                        class: Checklist,
                        inlineToolbar: true,
                    },
                    quote: {
                        class: Quote,
                        inlineToolbar: true,
                        config: {
                            quotePlaceholder: 'Enter a quote',
                            captionPlaceholder: 'Quote\'s author',
                        },
                        shortcut: 'CMD+SHIFT+O'
                    },
                    raw: RawTool,
                    code: {
                        class: CodeTool,
                        shortcut: 'CMD+SHIFT+C'
                    },
                    table: {
                        class: Table,
                        inlineToolbar: true,
                        shortcut: 'CMD+ALT+T'
                    },
                    warning: Warning,
                    delimiter: Delimiter,
                },
                data: {
                    time: 1553964811649,
                    blocks: json,
                },
                logLevel: 'ERROR',
                onReady: () => {},
                onChange: function(api, event) {
                    editor.save().then(savedData => {
                        autoSave(savedData.blocks);
                    }).catch((errors) => {});
                }
            });
        }

        var val = $("#editorjs").attr('data-json');
        var json = '';
        if (val) {
            json = JSON.parse($("#editorjs").attr('data-json'));
        }
        createEditor(json);

        $('.document_menu').click(function(e) {
            var $this = $(this);
            var url = $this.attr('data-url');
            $('#menu_id').attr('value', $this.data('id'));
            var dataid = $this.attr('data-id');
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                success: function(data) {
                    if (data.id == $this.data('id')) {
                        $('.dd3-contents').removeClass('active');
                        $this.parents('.dd3-contents').addClass('active');
                    }
                    var dataTitle = $(".data-title").text(data.title);
                    $('.autoSave').find('#editorjs').attr('data-json', data.json);
                    editor.destroy();
                    createEditor(JSON.parse(data.json));
                },
                error: function(data) {}
            });
        });

        //menu submenu drag and drop
        $(function() {
            $(".sortable").sortable();
            $(".sortable").disableSelection();
            $(".sortable").sortable({
                stop: function() {
                    var url = "{{ route('updatedesign.document') }}";
                    var position = [];
                    $(this).find('span').each(function(index, data) {
                        position[index] = $(data).attr('data-id');
                    });
                    $.ajax({
                        url: url,
                        data: {
                            position: position,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        type: 'POST',
                        success: function(data) {
                            show_toastr('Done!', 'Menu updated successfully', 'success');

                        },
                        error: function(data) {
                            show_toastr('Done!', 'Menu does not updated', 'success');

                        }
                    })
                }
            });
        });
        $(function() {
            //menu create
            $('body').on('click', '.add_docmenu', function() {
                var url = $(this).attr('data-url');
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('{{ __('Create Menu') }}');
                        modal.find('.body').html(response);
                        modal.modal('show');
                    },
                    error: function(error) {}
                });
            });
            //submenu create
            $('body').on('click', '.add_docsubmenu', function() {
                var url = $(this).attr('data-url');
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('{{ __('Create Submenu') }}');
                        modal.find('.body').html(response);
                        modal.modal('show');
                    },
                    error: function(error) {}
                });
            });
        });
    </script>
@endpush
