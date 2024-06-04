<div class="col-lg-4 col-sm-6 col-md-6 d-flex">
    <div class="card w-100">
        <div class="card-header">
            <h5 class="mb-0">
                <?php echo e(__('Menu')); ?>

                <div class="float-end">
                    <a class="btn btn-primary btn-sm add_docmenu text-bold" href="javascript:void(0);" id="create-docmenu"
                        data-ajax-popup="true" data-url="<?php echo e(route('docmenu.create', $document->id)); ?>"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                        data-bs-original-title="<?php echo e(__('Menu Create')); ?>"><i class="ti ti-plus"></i>
                    </a>
                </div>
            </h5>
        </div>
        <div class="card-body pt-2">
            <div class="inner-content">
                <div class="ddd" id="domenu">
                    <div class="list-group" id="list-tab" role="tablist">
                        <ol class="dd-lists sortable" href="<?php echo e(route('updatedesign.document')); ?>">
                            <?php $__currentLoopData = $docMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($menu->parent_id == 0): ?>
                                    <li class="dd-items toolone">
                                        <div
                                            class="dd3-contents menu-content d-flex justify-content-between flex-wrap align-item-center
                                            list-group-item list-group-item-action <?php if($key == 0): ?> active <?php endif; ?>">
                                            <span data-id="<?php echo e($menu->id); ?>" class="fonts-weight">
                                                <?php echo e(substr($menu->title, 0, 30) . (strlen($menu->title) > 30 ? '...' : '')); ?>

                                            </span>
                                            <div class="dd3-contents-inner">
                                                <button type="button"
                                                    data-url="<?php echo e(route('document.design.menu', $menu->id)); ?>"
                                                    data-id="<?php echo e($menu->id); ?>"
                                                    class="document_menu btn btn-default menu-btn"
                                                    data-token="<?php echo e(csrf_token()); ?>"><i
                                                        class="ti ti-brush"></i></button>
                                                <a class="btn btn-sm add_docsubmenu menu-btn" href="javascript:void(0);"
                                                    id="create-docsubmenu" data-ajax-popup="true"
                                                    data-url="<?php echo e(route('docsubmenu.create', [$menu->id, $menu->document_id])); ?>"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                                    data-bs-original-title="<?php echo e(__('Create Submenu')); ?>"><i
                                                        class="ti ti-plus"></i>
                                                </a>
                                                <?php echo Form::open([
                                                    'method' => 'DELETE',
                                                    'class' => 'd-inline',
                                                    'route' => ['document.design.delete', $menu->id],
                                                    'id' => 'delete-form-' . $menu->id,
                                                ]); ?>

                                                <a href="javascript:void(0);" class="btn btn-sm small show_confirm menu-btn"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                                    data-bs-original-title="<?php echo e(__('Delete')); ?>"
                                                    id="delete-form-<?php echo e($menu->id); ?>"><i
                                                        class="ti ti-trash mr-0"></i></a>
                                                <?php echo Form::close(); ?>

                                            </div>
                                        </div>
                                        <input type="hidden" name="menu_id" id="menu_id"
                                            value="<?php echo e($menu->id); ?>">
                                        <?php
                                            $documentMenu  = App\Models\DocumentMenu::where('parent_id', $menu->id)->get();
                                        ?>
                                        <?php $__currentLoopData = $documentMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $docMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <ol class="dd-lists plugin sub-display">
                                                <li class="dd-items plugin-class">
                                                    <div
                                                        class="dd3-contents menu-content d-flex justify-content-between align-item-center
                                                        list-group-item list-group-item-action">
                                                        <span data-id="<?php echo e($docMenu->id); ?>">
                                                            <?php echo e(substr($docMenu->title, 0, 30) . (strlen($docMenu->title) > 30 ? '...' : '')); ?>

                                                        </span>
                                                        <div class="d-flex align-items-center">
                                                            <button type="button"
                                                                data-url="<?php echo e(route('document.design.menu', $docMenu->id)); ?>"
                                                                data-id="<?php echo e($docMenu->id); ?>"
                                                                class="document_menu btn btn-default menu-btn"
                                                                data-token="<?php echo e(csrf_token()); ?>"><i
                                                                    class="ti ti-brush"></i>
                                                            </button>
                                                            <?php echo Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'd-inline',
                                                                'route' => ['document.submenu.design.delete', $docMenu->id],
                                                                'id' => 'delete-form-' . $docMenu->id,
                                                            ]); ?>

                                                            <a href="<?php echo e(route('document.submenu.design.delete', $docMenu->id)); ?>"
                                                                class="btn btn-sm small show_confirm menu-btn"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                title=""
                                                                data-bs-original-title="<?php echo e(__('Delete')); ?>"
                                                                id="delete-form-<?php echo e($docMenu->id); ?>"><i
                                                                    class="ti ti-trash mr-0"></i></a>
                                                            <?php echo Form::close(); ?>

                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/document/sidebar-menu.blade.php ENDPATH**/ ?>