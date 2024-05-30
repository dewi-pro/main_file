<?php
    use App\Facades\UtilityFacades;
    use App\Models\Role;
    use App\Models\AssignFormsRoles;
    use App\Models\AssignFormsUsers;
?>
<?php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($form->id);
?>
<div class="section-body">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-7">

            <?php if(!empty($form->logo)): ?>
                <div class="mb-2 text-center gallery gallery-md">
                    <img id="app-dark-logo" class="float-none gallery-item"
                        src="<?php echo e(isset($form->logo) ? Storage::url($form->logo) : Storage::url('/not-exists-data-images/78x78.png')); ?>">
                </div>
            <?php endif; ?>
            <?php if(session()->has('success')): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100"><?php echo e($form->title); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center gallery" id="success_loader">
                            <img src="<?php echo e(asset('assets/images/success.gif')); ?>" />
                            <br>
                            <br>
                            <h2 class="w-100 "><?php echo e(session()->get('success')); ?></h2>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <?php
                        $formRules = App\Models\formRule::where('form_id', $form->id)->get();
                        // foreach ($formRules as $formRule) {
                        //     $ifJsonArray = json_decode($formRule->if_json, true);
                        //     $thenJsonArray = json_decode($formRule->then_json, true);
                        // }
                    ?>
                    <div class="card-header">
                        <h5 class="text-center w-100"><?php echo e($form->title); ?></h5>
                    </div>
                    <div class="card-body form-card-body">
                        <form action="<?php echo e(route('forms.fill.store', $form->id)); ?>" method="POST"
                            enctype="multipart/form-data" id="fill-form">
                            <?php echo method_field('PUT'); ?>
                            <?php if(isset($array)): ?>
                                <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab">
                                        <div class="row">
                                            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    if (isset($row->column)) {
                                                        if ($row->column == 1) {
                                                            $col = 'col-12 step-' . $keys;
                                                        } elseif ($row->column == 2) {
                                                            $col = 'col-6 step-' . $keys;
                                                        } elseif ($row->column == 3) {
                                                            $col = 'col-4 step-' . $keys;
                                                        }
                                                    } else {
                                                        $col = 'col-12 step-' . $keys;
                                                    }
                                                ?>
                                                <?php if($row->type == 'checkbox-group'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name="<?php echo e($row->name); ?>">
                                                        <label for="<?php echo e($row->name); ?>"
                                                            class="d-block form-label"><?php echo e($row->label); ?>

                                                            <?php if($row->required): ?>
                                                                <span
                                                                    class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                            <?php if(isset($row->description)): ?>
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="<?php echo e($row->description); ?>">
                                                                    ?
                                                                </span>
                                                            <?php endif; ?>
                                                        </label>
                                                        <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $attr = [
                                                                    'class' => 'form-check-input',
                                                                    'id' => $row->name . '_' . $key,
                                                                ];
                                                                $attr['name'] = $row->name . '[]';
                                                                if ($row->required) {
                                                                    $attr['required'] = 'required';
                                                                    $attr['class'] = $attr['class'] . ' required';
                                                                }
                                                                if ($row->inline) {
                                                                    $class = 'form-check form-check-inline col-4 ';
                                                                    if ($row->required) {
                                                                        $attr['class'] =
                                                                            'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label mb-0 ml-1';
                                                                } else {
                                                                    $class = 'form-check';
                                                                    if ($row->required) {
                                                                        $attr['class'] =
                                                                            'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label';
                                                                }
                                                            ?>
                                                            <div class="<?php echo e($class); ?>">
                                                                <?php echo e(Form::checkbox($row->name, $options->value, isset($options->selected) && $options->selected == 1 ? true : false, $attr)); ?>

                                                                <label class="<?php echo e($l_class); ?>"
                                                                    for="<?php echo e($row->name . '_' . $key); ?>"><?php echo e($options->label); ?></label>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($row->required): ?>
                                                            <div class=" error-message required-checkbox"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'file'): ?>
                                                    <?php
                                                        $attr = [];
                                                        $attr['class'] = 'form-control upload';
                                                        if ($row->multiple) {
                                                            $maxupload = 10;
                                                            $attr['multiple'] = 'true';
                                                            if ($row->subtype != 'fineuploader') {
                                                                $attr['name'] = $row->name . '[]';
                                                            }
                                                        }
                                                        if (
                                                            $row->required &&
                                                            (!isset($row->value) || empty($row->value))
                                                        ) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        if ($row->subtype == 'fineuploader') {
                                                            $attr['class'] = $attr['class'] . ' ' . $row->name;
                                                        }
                                                    ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name="<?php echo e($row->name); ?>">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php if($row->subtype == 'fineuploader'): ?>
                                                            <div class="dropzone" id="<?php echo e($row->name); ?>"
                                                                data-extention="<?php echo e($row->file_extention); ?>">
                                                            </div>
                                                            <?php echo $__env->make('form.js.dropzone', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                            <?php echo Form::hidden($row->name, null, $attr); ?>

                                                        <?php else: ?>
                                                            <?php echo e(Form::file($row->name, $attr)); ?>

                                                        <?php endif; ?>
                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-file"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'header'): ?>
                                                    <?php
                                                        $class = '';
                                                        if (isset($row->className)) {
                                                            $class = $class . ' ' . $row->className;
                                                        }
                                                    ?>
                                                    <div class="<?php echo e($col); ?>">
                                                        <<?php echo e($row->subtype); ?> class="<?php echo e($class); ?>">
                                                            <?php echo e(html_entity_decode($row->label)); ?>

                                                            </<?php echo e($row->subtype); ?>>
                                                    </div>
                                                <?php elseif($row->type == 'paragraph'): ?>
                                                    <?php
                                                        $class = '';
                                                        if (isset($row->className)) {
                                                            $class = $class . ' ' . $row->className;
                                                        }
                                                    ?>
                                                    <div class="<?php echo e($col); ?>">
                                                        <<?php echo e($row->subtype); ?> class="<?php echo e($class); ?>">
                                                            <?php echo e(html_entity_decode($row->label)); ?>

                                                            </<?php echo e($row->subtype); ?>>
                                                    </div>
                                                <?php elseif($row->type == 'radio-group'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <label for="<?php echo e($row->name); ?>"
                                                            class="d-block form-label"><?php echo e($row->label); ?>

                                                            <?php if($row->required): ?>
                                                                <span
                                                                    class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                            <?php if(isset($row->description)): ?>
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="<?php echo e($row->description); ?>">
                                                                    ?
                                                                </span>
                                                            <?php endif; ?>
                                                        </label>
                                                        <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                if ($row->required) {
                                                                    $attr['required'] = 'required';
                                                                    $attr = [
                                                                        'class' => 'form-check-input required',
                                                                        'required' => 'required',
                                                                        'id' => $row->name . '_' . $key,
                                                                    ];
                                                                } else {
                                                                    $attr = [
                                                                        'class' => 'form-check-input',
                                                                        'id' => $row->name . '_' . $key,
                                                                    ];
                                                                }
                                                                if ($row->inline) {
                                                                    $class = 'form-check form-check-inline ';
                                                                    if ($row->required) {
                                                                        $attr['class'] =
                                                                            'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label mb-0 ml-1';
                                                                } else {
                                                                    $class = 'form-check';
                                                                    if ($row->required) {
                                                                        $attr['class'] =
                                                                            'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label';
                                                                }
                                                            ?>
                                                            <div class=" <?php echo e($class); ?>">
                                                                <?php echo e(Form::radio($row->name, $options->value, isset($options->selected) && $options->selected ? true : false, $attr)); ?>

                                                                <label class="<?php echo e($l_class); ?>"
                                                                    for="<?php echo e($row->name . '_' . $key); ?>"><?php echo e($options->label); ?></label>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-radio "></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'select'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $attr = [
                                                                'class' => 'form-select w-100',
                                                                'id' => 'sschoices-multiple-remove-button',
                                                                'data-trigger',
                                                            ];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                            if (isset($row->multiple) && !empty($row->multiple)) {
                                                                $attr['multiple'] = 'true';
                                                                $attr['name'] = $row->name . '[]';
                                                            }
                                                            if (
                                                                isset($row->className) &&
                                                                $row->className == 'calculate'
                                                            ) {
                                                                $attr['class'] =
                                                                    $attr['class'] . ' ' . $row->className;
                                                            }
                                                            if ($row->label == 'Registration') {
                                                                $attr['class'] = $attr['class'] . ' registration';
                                                            }
                                                            if (
                                                                isset($row->is_parent) &&
                                                                $row->is_parent == 'true'
                                                            ) {
                                                                $attr['class'] = $attr['class'] . ' parent';
                                                                $attr['data-number-of-control'] = isset(
                                                                    $row->number_of_control,
                                                                )
                                                                    ? $row->number_of_control
                                                                    : 1;
                                                            }
                                                            $values = [];
                                                            $selected = [];
                                                            foreach ($row->values as $options) {
                                                                $values[$options->value] = $options->label;
                                                                if (
                                                                    isset($options->selected) &&
                                                                    $options->selected
                                                                ) {
                                                                    $selected[] = $options->value;
                                                                }
                                                            }
                                                        ?>
                                                        <?php if(isset($row->is_parent) && $row->is_parent == 'true'): ?>
                                                            <?php echo e(Form::label($row->name, $row->label)); ?><?php if($row->required): ?>
                                                                <span
                                                                    class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                            <div class="input-group">
                                                                <?php echo e(Form::select($row->name, $values, $selected, $attr)); ?>

                                                            </div>
                                                        <?php else: ?>
                                                            <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                            <?php if($row->required): ?>
                                                                <span
                                                                    class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                            <?php if(isset($row->description)): ?>
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="<?php echo e($row->description); ?>">?</span>
                                                            <?php endif; ?>
                                                            <?php echo e(Form::select($row->name, $values, $selected, $attr)); ?>

                                                        <?php endif; ?>
                                                        <?php if($row->label == 'Registration'): ?>
                                                            <span class="text-warning registration-message"></span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'autocomplete'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        
                                                        <?php
                                                            $attr = [
                                                                'class' => 'form-select w-100',
                                                                'id' => 'sschoices-multiple-remove-button',
                                                                'data-trigger',
                                                            ];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                            if (isset($row->multiple) && !empty($row->multiple)) {
                                                                $attr['multiple'] = 'true';
                                                                $attr['name'] = $row->name . '[]';
                                                            }
                                                            if (
                                                                isset($row->className) &&
                                                                $row->className == 'calculate'
                                                            ) {
                                                                $attr['class'] =
                                                                    $attr['class'] . ' ' . $row->className;
                                                            }
                                                            if ($row->label == 'Registration') {
                                                                $attr['class'] = $attr['class'] . ' registration';
                                                            }
                                                            if (
                                                                isset($row->is_parent) &&
                                                                $row->is_parent == 'true'
                                                            ) {
                                                                $attr['class'] = $attr['class'] . ' parent';
                                                                $attr['data-number-of-control'] = isset(
                                                                    $row->number_of_control,
                                                                )
                                                                    ? $row->number_of_control
                                                                    : 1;
                                                            }
                                                            $values = [];
                                                            $selected = [];
                                                        ?>
                                                        <div class="form-group">
                                                            <label for="autocompleteInputZero"
                                                                class="form-label"><?php echo e($row->label); ?></label>
                                                            <input type="text" class="form-control"
                                                                placeholder="<?php echo e($row->label); ?>"
                                                                list="list-timezone" name="autocomplete"
                                                                id="input-datalist">
                                                            <datalist id="list-timezone">
                                                                <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(is_object($options) && property_exists($options, 'value')): ?>
                                                                        <option value="<?php echo e($options->value); ?>">
                                                                        </option>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                <?php elseif($row->type == 'date'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $attr = ['class' => 'form-control'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                        ?>
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::date($row->name, isset($row->value) ? $row->value : null, $attr)); ?>

                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-date"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'hidden'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php echo e(Form::hidden($row->name, isset($row->value) ? $row->value : null)); ?>

                                                    </div>
                                                <?php elseif($row->type == 'number'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $row_class = isset($row->className)
                                                                ? $row->className
                                                                : '';
                                                            $attr = ['class' => 'number ' . $row_class];
                                                            if (isset($row->min)) {
                                                                $attr['min'] = $row->min;
                                                            }
                                                            if (isset($row->max)) {
                                                                $attr['max'] = $row->max;
                                                            }
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required ';
                                                            }
                                                        ?>
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::number($row->name, isset($row->value) ? $row->value : null, $attr)); ?>

                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-number"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'textarea'): ?>
                                                    <div class="form-group <?php echo e($col); ?> "
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $attr = ['class' => 'form-control text-area-height'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                            if (isset($row->rows)) {
                                                                $attr['rows'] = $row->rows;
                                                            } else {
                                                                $attr['rows'] = '3';
                                                            }
                                                            if (isset($row->placeholder)) {
                                                                $attr['placeholder'] = $row->placeholder;
                                                            }
                                                            if ($row->subtype == 'ckeditor') {
                                                                $attr['class'] = $attr['class'] . ' ck_editor';
                                                            }
                                                        ?>
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::textarea($row->name, isset($row->value) ? $row->value : null, $attr)); ?>

                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-textarea"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'button'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php if(isset($row->value) && !empty($row->value)): ?>
                                                            <a href="<?php echo e($row->value); ?>" target="_new"
                                                                class="<?php echo e($row->className); ?>"><?php echo e(__($row->label)); ?></a>
                                                        <?php else: ?>
                                                            <?php echo e(Form::button(__($row->label), ['name' => $row->name, 'type' => $row->subtype, 'class' => $row->className, 'id' => $row->name])); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'text'): ?>
                                                    <?php
                                                        $class = '';
                                                        if ($row->subtype == 'text' || $row->subtype == 'email') {
                                                            $class = 'form-group-text';
                                                        }
                                                    ?>
                                                    <div class="form-group <?php echo e($class); ?> <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $attr = ['class' => 'form-control ' . $row->subtype];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                            if (isset($row->maxlength)) {
                                                                $attr['max'] = $row->maxlength;
                                                            }
                                                            if (isset($row->placeholder)) {
                                                                $attr['placeholder'] = $row->placeholder;
                                                            }
                                                            $value = isset($row->value) ? $row->value : '';
                                                            if ($row->subtype == 'datetime-local') {
                                                                $row->subtype = 'datetime-local';
                                                                $attr['class'] = $attr['class'] . ' date_time';
                                                            }
                                                        ?>
                                                        <label for="<?php echo e($row->name); ?>"
                                                            class="form-label"><?php echo e($row->label); ?>

                                                            <?php if($row->required): ?>
                                                                <span
                                                                    class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                        </label>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::input($row->subtype, $row->name, $value, array_merge($attr, ['data-input' => $row->name]))); ?>

                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-text"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'starRating'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $value = isset($row->value) ? $row->value : 0;
                                                            $num_of_star = isset($row->number_of_star)
                                                                ? $row->number_of_star
                                                                : 5;
                                                        ?>
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <div id="<?php echo e($row->name); ?>" class="starRating"
                                                            data-value="<?php echo e($value); ?>"
                                                            data-num_of_star="<?php echo e($num_of_star); ?>">
                                                        </div>
                                                        <input type="hidden" name="<?php echo e($row->name); ?>"
                                                            value="<?php echo e($value); ?>" class="calculate"
                                                            data-star="<?php echo e($num_of_star); ?>">
                                                    </div>
                                                <?php elseif($row->type == 'SignaturePad'): ?>
                                                    <?php
                                                        $attr = ['class' => $row->name];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : null;
                                                    ?>
                                                    <div class="row form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php echo $__env->make('form.js.signature', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <div class="col-12">
                                                            <label for="<?php echo e($row->name); ?>"
                                                                class="form-label"><?php echo e($row->label); ?></label>
                                                            <?php if($row->required): ?>
                                                                <span
                                                                    class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                            <?php if(isset($row->description)): ?>
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    title="<?php echo e($row->description); ?>">
                                                                    ?
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <div class="signature-pad-body">
                                                                <canvas class="signaturePad form-control"
                                                                    id="<?php echo e($row->name); ?>"></canvas>
                                                                <div class="sign-error"></div>
                                                                <?php echo Form::hidden($row->name, $value, $attr); ?>

                                                                <div class="buttons signature_buttons">
                                                                    <button id="save<?php echo e($row->name); ?>"
                                                                        type="button" data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom"
                                                                        data-bs-original-title="<?php echo e(__('Save')); ?>"
                                                                        class="btn btn-primary btn-sm"><?php echo e(__('Save')); ?></button>
                                                                    <button id="clear<?php echo e($row->name); ?>"
                                                                        type="button" data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom"
                                                                        data-bs-original-title="<?php echo e(__('Clear')); ?>"
                                                                        class="btn btn-danger btn-sm"><?php echo e(__('Clear')); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if(@$row->value != ''): ?>
                                                            <div class="col-lg-6 col-md-12 col-12">
                                                                <img src="<?php echo e(Storage::url($row->value)); ?>"
                                                                    width="80%" class="border" alt="">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'break'): ?>
                                                    <hr class="hr_border">
                                                <?php elseif($row->type == 'location'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php echo $__env->make('form.js.map', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <input id="pac-input" class="controls" type="text"
                                                            name="location" placeholder="Search Box" />
                                                        <div id="map"></div>
                                                    </div>
                                                <?php elseif($row->type == 'video'): ?>
                                                    <?php
                                                        $attr = ['class' => $row->name];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : null;
                                                    ?>
                                                    <div class="row form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php echo $__env->make('form.js.video', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <label for="<?php echo e($row->name); ?>"
                                                            class="form-label"><?php echo e($row->label); ?></label>
                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <div class="d-flex justify-content-start">
                                                            <button type="button" class="btn btn-primary"
                                                                id="videostream">
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M5 5h-3v-1h3v1zm8 5c-1.654 0-3 1.346-3 3s1.346 3 3 3 3-1.346 3-3-1.346-3-3-3zm11-4v15h-24v-15h5.93c.669 0 1.293-.334 1.664-.891l1.406-2.109h8l1.406 2.109c.371.557.995.891 1.664.891h3.93zm-19 4c0-.552-.447-1-1-1-.553 0-1 .448-1 1s.447 1 1 1c.553 0 1-.448 1-1zm13 3c0-2.761-2.239-5-5-5s-5 2.239-5 5 2.239 5 5 5 5-2.239 5-5z"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                                <?php echo e(__('Record Video')); ?>

                                                            </button>
                                                        </div>
                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-text"></div>
                                                        <?php endif; ?>
                                                        <div class="cam-buttons d-none">
                                                            <video autoplay controls id="web-cam-container"
                                                                class="p-2" style="width:100%; height:80%;">
                                                                <?php echo e(__("Your browser doesn't support the video tag")); ?>

                                                            </video>
                                                            <div class="py-4">
                                                                <div class="field-required">
                                                                    <div
                                                                        class="mb-2 btn btn-lg btn-primary float-end">
                                                                        <div id="timer">
                                                                            <span id="hours">00:</span>
                                                                            <span id="mins">00:</span>
                                                                            <span id="seconds">00</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id='gUMArea' class="video_cam">
                                                                    <div class="web_cam_video">
                                                                        <input type="hidden"
                                                                            class="<?php echo e(implode(' ', $attr)); ?>"
                                                                            name="media" checked
                                                                            value="<?php echo e($value); ?>"
                                                                            id="mediaVideo">

                                                                    </div>
                                                                </div>
                                                                <div id='btns'>
                                                                    <div id="controls">
                                                                        <button class="btn btn-light-primary"
                                                                            id='start' type="button">
                                                                            <span class="svg-icon svg-icon-2">
                                                                                <span class="svg-icon svg-icon-2">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24"
                                                                                        height="24"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path
                                                                                            d="M16 18c0 1.104-.896 2-2 2h-12c-1.105 0-2-.896-2-2v-12c0-1.104.895-2 2-2h12c1.104 0 2 .896 2 2v12zm8-14l-6 6.223v3.554l6 6.223v-16z"
                                                                                            fill="black" />
                                                                                    </svg>
                                                                                </span>
                                                                            </span>
                                                                            <?php echo e(__('Start')); ?>

                                                                        </button>
                                                                        <button class="btn btn-light-danger"
                                                                            id='stop' type="button">
                                                                            <span class="svg-icon svg-icon-2">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24">
                                                                                    <path d="M2 2h20v20h-20z"
                                                                                        fill="black" />
                                                                                </svg>
                                                                            </span>
                                                                            <span
                                                                                class="indicator-label"><?php echo e(__('Stop')); ?></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php elseif($row->type == 'selfie'): ?>
                                                    <?php
                                                        $attr = ['class' => $row->name];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : null;
                                                    ?>
                                                    <div class="row <?php echo e($col); ?> selfie_screen"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php echo $__env->make('form.js.selfie', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <div class="col-md-6 selfie_photo">
                                                            <div class="form-group">
                                                                <label for="<?php echo e($row->name); ?>"
                                                                    class="form-label"><?php echo e($row->label); ?></label>
                                                                <?php if($row->required): ?>
                                                                    <span
                                                                        class="text-danger align-items-center">*</span>
                                                                <?php endif; ?>
                                                                <div id="my_camera" class="camera_screen"></div>
                                                                <br />
                                                                <button type="button"
                                                                    class="btn btn-default btn-light-primary"
                                                                    onClick="take_snapshot()">
                                                                    <i class="ti ti-camera"></i>
                                                                    <?php echo e(__('Take Selfie')); ?>

                                                                </button>
                                                                <input type="hidden" name="image"
                                                                    value="<?php echo e($value); ?>"
                                                                    class="image-tag  <?php echo e(implode(' ', $attr)); ?>">
                                                            </div>

                                                        </div>
                                                        <div class="mt-4 col-md-6">
                                                            <div id="results" class="selfie_result">
                                                                <?php echo e(__('Your captured image will appear here...')); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col cap">
                                    <?php if(UtilityFacades::getsettings('captcha_enable') == 'on'): ?>
                                        <?php if(UtilityFacades::getsettings('captcha') == 'hcaptcha'): ?>
                                            <?php echo HCaptcha::renderJs(); ?>

                                            <small
                                                class="text-danger font-weight-bold"><?php echo e(__('Note :- reCAPTCHA Is required')); ?></small>
                                            <div class="g-hcaptcha"
                                                data-sitekey="<?php echo e(UtilityFacades::getsettings('hcaptcha_key')); ?>">
                                            </div>
                                            <?php echo HCaptcha::display(); ?>

                                            <?php $__errorArgs = ['g-hcaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger text-bold"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <?php endif; ?>
                                        <?php if(UtilityFacades::getsettings('captcha') == 'recaptcha'): ?>
                                            <?php echo NoCaptcha::renderJs(); ?>

                                            <small
                                                class="text-danger font-weight-bold"><?php echo e(__('Note :- reCAPTCHA Is required')); ?></small>
                                            <div class="g-recaptcha"
                                                data-sitekey="<?php echo e(UtilityFacades::getsettings('captcha_sitekey')); ?>">
                                            </div>
                                            <?php echo NoCaptcha::display(); ?>

                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <div class="pb-0 mt-3 form-actions">
                                        <input type="hidden" name="form_value_id"
                                            value="<?php echo e(isset($formValue) ? $formValue->id : ''); ?>"
                                            id="form_value_id">
                                    </div>
                                </div>
                            </div>

                            <?php if(!isset($formValue) && $form->payment_status == 1): ?>
                                <?php if(!isset($formValue) && $form->payment_type == 'stripe'): ?>
                                    <div class="strip">
                                        <strong class="d-block"><?php echo e(__('Payment')); ?>

                                            (<?php echo e($form->currency_symbol); ?><?php echo e($form->amount); ?>)</strong>
                                        <div id="card-element" class="form-control">
                                        </div>
                                        <span id="card-errors" class="payment-errors"></span>
                                        <br>
                                    </div>
                                <?php elseif(!isset($formValue) && $form->payment_type == 'razorpay'): ?>
                                    <div class="razorpay">
                                        <p><?php echo e(__('Make Payment')); ?></p>
                                        <input type="hidden" name="payment_id" id="payment_id">
                                        <h5><?php echo e(__('Payable Amount')); ?> : <?php echo e($form->currency_symbol); ?>

                                            <?php echo e($form->amount); ?></h5>
                                    </div>
                                <?php elseif(!isset($formValue) && $form->payment_type == 'paypal'): ?>
                                    <div class="paypal">
                                        <p><?php echo e(__('Make Payment')); ?></p>
                                        <input type="hidden" name="payment_id" id="payment_id">
                                        <h5><?php echo e(__('Payable Amount')); ?> : <?php echo e($form->currency_symbol); ?>

                                            <?php echo e($form->amount); ?></h5>
                                        <div id="paypal-button-container"></div>
                                        <span id="paypal-errors" class="payment-errors"></span>
                                        <br>
                                    </div>
                                <?php elseif(!isset($formValue) && $form->payment_type == 'paytm'): ?>
                                    <div class="paytm">
                                        <p><?php echo e(__('Make Payment')); ?></p>
                                        <?php echo Form::hidden('payment_id', null, ['id' => 'payment_id']); ?>

                                        <h5><?php echo e(__('Payble Amount')); ?> : <?php echo e($form->currency_symbol); ?>

                                            <?php echo e($form->amount); ?></h5>
                                    </div>
                                <?php elseif(!isset($formValue) && $form->payment_type == 'flutterwave'): ?>
                                    <div class="flutterwave">
                                        <p><?php echo e(__('Make Payment')); ?></p>
                                        <?php echo Form::hidden('payment_id', null, ['id' => 'payment_id']); ?>

                                        <h5><?php echo e(__('Payble Amount')); ?> : <?php echo e($form->currency_symbol); ?>

                                            <?php echo e($form->amount); ?></h5>
                                    </div>
                                <?php elseif(!isset($formValue) && $form->payment_type == 'paystack'): ?>
                                    <div class="paystack">
                                        <p><?php echo e(__('Make Payment')); ?></p>
                                        <?php echo Form::hidden('payment_id', null, ['id' => 'payment_id']); ?>

                                        <h5><?php echo e(__('Payble Amount')); ?> : <?php echo e($form->currency_symbol); ?>

                                            <?php echo e($form->amount); ?></h5>
                                    </div>
                                <?php elseif(!isset($formValue) && $form->payment_type == 'coingate'): ?>
                                    <div class="coingate">
                                        <p><?php echo e(__('Make Payment')); ?></p>
                                        <?php echo Form::hidden('payment_id', null, ['id' => 'payment_id']); ?>

                                        <h5><?php echo e(__('Payble Amount')); ?> : <?php echo e($form->currency_symbol); ?>

                                            <?php echo e($form->amount); ?></h5>
                                    </div>
                                <?php elseif(!isset($formValue) && $form->payment_type == 'mercado'): ?>
                                    <div class="mercado">
                                        <p><?php echo e(__('Make Payment')); ?></p>
                                        <?php echo Form::hidden('payment_id', null, ['id' => 'payment_id']); ?>

                                        <h5><?php echo e(__('Payble Amount')); ?> : <?php echo e($form->currency_symbol); ?>

                                            <?php echo e($form->amount); ?></h5>
                                    </div>
                                <?php elseif(!isset($formValue) && $form->payment_type == 'payumoney'): ?>
                                    <div class="payumoney">
                                        <p><?php echo e(__('Make Payment')); ?></p>
                                        <?php echo Form::hidden('payment_id', null, ['id' => 'payment_id']); ?>

                                        <h5><?php echo e(__('Payble Amount')); ?> : <?php echo e($form->currency_symbol); ?>

                                            <?php echo e($form->amount); ?></h5>
                                    </div>
                                <?php elseif(!isset($formValue) && $form->payment_type == 'mollie'): ?>
                                    <div class="mollie">
                                        <p><?php echo e(__('Make Payment')); ?></p>
                                        <?php echo Form::hidden('payment_id', null, ['id' => 'payment_id']); ?>

                                        <h5><?php echo e(__('Payble Amount')); ?> : <?php echo e($form->currency_symbol); ?>

                                            <?php echo e($form->amount); ?></h5>
                                    </div>
                                <?php elseif(!isset($formValue) && $form->payment_type == 'offlinepayment'): ?>
                                    <div class="offlinepayment">
                                        <p><?php echo e(__('Make Payment')); ?></p>
                                        <input type="hidden" name="payment_id" id="payment_id">
                                        <h5><?php echo e(__('Payble Amount')); ?> : <?php echo e($form->currency_symbol); ?>

                                            <?php echo e($form->amount); ?></h5>

                                        <div class="form-group">
                                            <?php echo e(Form::label('payment_details', __('Payment Details'), ['class' => 'form-label'])); ?>

                                            <P><?php echo e(UtilityFacades::getsettings('offline_payment_details')); ?></P>
                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('transfer_slip', __('Upload Payment Slip'), ['class' => 'form-label'])); ?>

                                            <span><?php echo e(__('( jpg, png, pdf )')); ?></span>
                                            <?php echo Form::file('transfer_slip', ['class' => 'form-control required', 'required' => 'required']); ?>

                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php echo e(Form::hidden('ip_data', '', ['id' => 'ip_data'])); ?>

                            <div class="over-auto">
                                <div class="float-right">
                                    <?php echo Form::button(__('Previous'), ['class' => 'btn btn-default', 'id' => 'prevBtn', 'onclick' => 'nextPrev(-1)']); ?>

                                    <?php echo Form::button(__('Next'), ['class' => 'btn btn-primary', 'id' => 'nextBtn', 'onclick' => 'nextPrev(1)']); ?>

                                </div>
                            </div>
                            <div class="extra_style">
                                <?php if(isset($array)): ?>
                                    <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="step"></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </form>
                        <?php echo Form::open(['route' => ['coingateprepare'], 'method' => 'post', 'id' => 'coingate_payment_frms']); ?>

                        <?php echo e(Form::hidden('cg_currency', null, ['id' => 'cg_currency'])); ?>

                        <?php echo e(Form::hidden('cg_amount', null, ['id' => 'cg_amount'])); ?>

                        <?php echo e(Form::hidden('cg_form_id', null, ['id' => 'cg_form_id'])); ?>

                        <?php echo Form::hidden('cg_submit_type', null, ['id' => 'cg_submit_type']); ?>

                        <?php echo Form::close(); ?>

                        <?php echo Form::open([
                            'route' => ['payumoneyfillprepare'],
                            'method' => 'post',
                            'id' => 'payumoney_payment_frms',
                            'name' => 'payuForm',
                        ]); ?>

                        <?php echo e(Form::hidden('payumoney_currency', null, ['id' => 'payumoney_currency'])); ?>

                        <?php echo e(Form::hidden('payumoney_amount', null, ['id' => 'payumoney_amount'])); ?>

                        <?php echo e(Form::hidden('payumoney_form_id', null, ['id' => 'payumoney_form_id'])); ?>

                        <?php echo e(Form::hidden('payumoney_created_by', null, ['id' => 'payumoney_created_by'])); ?>

                        <?php echo Form::hidden('payumoney_submit_type', null, ['id' => 'payumoney_submit_type']); ?>

                        <?php echo Form::close(); ?>

                        <?php echo Form::open([
                            'route' => ['molliefillprepare'],
                            'method' => 'post',
                            'id' => 'mollie_payment_frms',
                            'name' => 'mollieForm',
                        ]); ?>

                        <?php echo e(Form::hidden('mollie_currency', null, ['id' => 'mollie_currency'])); ?>

                        <?php echo e(Form::hidden('mollie_amount', null, ['id' => 'mollie_amount'])); ?>

                        <?php echo e(Form::hidden('mollie_form_id', null, ['id' => 'mollie_form_id'])); ?>

                        <?php echo e(Form::hidden('mollie_created_by', null, ['id' => 'mollie_created_by'])); ?>

                        <?php echo Form::hidden('mollie_submit_type', null, ['id' => 'mollie_submit_type']); ?>

                        <?php echo Form::close(); ?>

                        <?php echo Form::open(['route' => ['mercadofillprepare'], 'method' => 'post', 'id' => 'mercado_payment_frms']); ?>

                        <?php echo e(Form::hidden('mercado_amount', null, ['id' => 'mercado_amount'])); ?>

                        <?php echo e(Form::hidden('mercado_form_id', null, ['id' => 'mercado_form_id'])); ?>

                        <?php echo e(Form::hidden('mercado_created_by', null, ['id' => 'mercado_created_by'])); ?>

                        <?php echo Form::hidden('mercado_submit_type', null, ['id' => 'mercado_submit_type']); ?>

                        <?php echo Form::close(); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if($form->conditional_rule == '1'): ?>
    <?php echo $__env->make('form.js.conditional-rule', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('vendor/location-get/intlTelInput.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/location-get/utils.js')); ?>"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $.get("https://ipinfo.io", function(data) {
                $('#ip_data').val(JSON.stringify(data));
            }, "jsonp");
        }, 2000);
    });
</script>
<script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/clipboard.min.js')); ?>"></script>
<script>
    new ClipboardJS('[data-clipboard=true]').on('success', function(e) {
        e.clearSelection();
    });
</script>
<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).attr('data-url')).select();
        document.execCommand("copy");
        $temp.remove();
        show_toastr('Great!', '<?php echo e(__('Copy Link Successfully..')); ?>', 'success',
            '<?php echo e(asset('assets/images/notification/ok-48.png')); ?>', 4000);
    }

    $(document).ready(function() {
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
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/main_file/resources/views/form/public-multi-form.blade.php ENDPATH**/ ?>