<div class="col-lg-4 col-sm-6 col-md-6 d-flex">
    <div class="card w-100">
        <div class="card-header">
            <h5 class="mb-0">
                {{ __('Menu') }}
                <div class="float-end">
                    <a class="btn btn-primary btn-sm add_docmenu text-bold" href="javascript:void(0);" id="create-docmenu"
                        data-ajax-popup="true" data-url="{{ route('docmenu.create', $document->id) }}"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                        data-bs-original-title="{{ __('Menu Create') }}"><i class="ti ti-plus"></i>
                    </a>
                </div>
            </h5>
        </div>
        <div class="card-body pt-2">
            <div class="inner-content">
                <div class="ddd" id="domenu">
                    <div class="list-group" id="list-tab" role="tablist">
                        <ol class="dd-lists sortable" href="{{ route('updatedesign.document') }}">
                            @foreach ($docMenu as $key => $menu)
                                @if ($menu->parent_id == 0)
                                    <li class="dd-items toolone">
                                        <div
                                            class="dd3-contents menu-content d-flex justify-content-between flex-wrap align-item-center
                                            list-group-item list-group-item-action @if ($key == 0) active @endif">
                                            <span data-id="{{ $menu->id }}" class="fonts-weight">
                                                {{ substr($menu->title, 0, 30) . (strlen($menu->title) > 30 ? '...' : '') }}
                                            </span>
                                            <div class="dd3-contents-inner">
                                                <button type="button"
                                                    data-url="{{ route('document.design.menu', $menu->id) }}"
                                                    data-id="{{ $menu->id }}"
                                                    class="document_menu btn btn-default menu-btn"
                                                    data-token="{{ csrf_token() }}"><i
                                                        class="ti ti-brush"></i></button>
                                                <a class="btn btn-sm add_docsubmenu menu-btn" href="javascript:void(0);"
                                                    id="create-docsubmenu" data-ajax-popup="true"
                                                    data-url="{{ route('docsubmenu.create', [$menu->id, $menu->document_id]) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                                    data-bs-original-title="{{ __('Create Submenu') }}"><i
                                                        class="ti ti-plus"></i>
                                                </a>
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'class' => 'd-inline',
                                                    'route' => ['document.design.delete', $menu->id],
                                                    'id' => 'delete-form-' . $menu->id,
                                                ]) !!}
                                                <a href="javascript:void(0);" class="btn btn-sm small show_confirm menu-btn"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                                    data-bs-original-title="{{ __('Delete') }}"
                                                    id="delete-form-{{ $menu->id }}"><i
                                                        class="ti ti-trash mr-0"></i></a>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        <input type="hidden" name="menu_id" id="menu_id"
                                            value="{{ $menu->id }}">
                                        @php
                                            $documentMenu  = App\Models\DocumentMenu::where('parent_id', $menu->id)->get();
                                        @endphp
                                        @foreach ($documentMenu  as $key => $docMenu)
                                            <ol class="dd-lists plugin sub-display">
                                                <li class="dd-items plugin-class">
                                                    <div
                                                        class="dd3-contents menu-content d-flex justify-content-between align-item-center
                                                        list-group-item list-group-item-action">
                                                        <span data-id="{{ $docMenu->id }}">
                                                            {{ substr($docMenu->title, 0, 30) . (strlen($docMenu->title) > 30 ? '...' : '') }}
                                                        </span>
                                                        <div class="d-flex align-items-center">
                                                            <button type="button"
                                                                data-url="{{ route('document.design.menu', $docMenu->id) }}"
                                                                data-id="{{ $docMenu->id }}"
                                                                class="document_menu btn btn-default menu-btn"
                                                                data-token="{{ csrf_token() }}"><i
                                                                    class="ti ti-brush"></i>
                                                            </button>
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'd-inline',
                                                                'route' => ['document.submenu.design.delete', $docMenu->id],
                                                                'id' => 'delete-form-' . $docMenu->id,
                                                            ]) !!}
                                                            <a href="{{ route('document.submenu.design.delete', $docMenu->id) }}"
                                                                class="btn btn-sm small show_confirm menu-btn"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                title=""
                                                                data-bs-original-title="{{ __('Delete') }}"
                                                                id="delete-form-{{ $docMenu->id }}"><i
                                                                    class="ti ti-trash mr-0"></i></a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>
                                        @endforeach
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
