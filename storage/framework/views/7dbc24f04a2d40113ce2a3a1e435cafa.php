<?php $__env->startSection('title', __('Condition Rules')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div class="previous-next-btn">
                <div class="page-header-title">
                    <h4 class="m-b-10"><?php echo e(__('Form Rules')); ?></h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('forms.index')); ?>"><?php echo e(__('Forms')); ?></a></li>
                    <li class="breadcrumb-item"> <?php echo e(__('Form Rules')); ?> </li>
                </ul>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-12 m-auto">
            <?php echo e(Form::open(['route' => 'rule.store', 'method' => 'post', 'id' => 'form-rule', 'data-validate', 'no-validate'])); ?>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5 class="card-title"><?php echo e(__('New Rule')); ?></h5>
                            <p class="text-muted">
                                <?php echo e(__('Configure rules to show or hide fields based on the input of another field.')); ?></p>
                        </div>
                        <div class="col-lg-4 form-check form-switch custom-switch-v1">
                            <div class="form-group">
                                <label class="mt-2 form-switch float-end custom-switch-v1">
                                    <input type="hidden" name="conditional_rule" value="0">
                                    <input type="checkbox" name="conditional_rule" class="form-check-input input-primary"
                                        <?php echo e('unchecked'); ?> value="1">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group mb-6">
                            <label for="rule" class="mb-1"><?php echo e(__('Rule Name')); ?></label>
                            <?php echo e(Form::text('rule_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Rule name'])); ?>

                            <small><?php echo e('(Maximum 50 characters)'); ?></small>
                            <input type="hidden" name="form_id" value="<?php echo e($formRules->id); ?>">
                        </div>

                        <div class="form-group mb-6 condition-select d-none w-25">
                            <select name="condition_type" class="form-control" data-trigger>
                                <option value="" selected disabled><?php echo e(__('Select Condition type')); ?></option>
                                <option value="and"><?php echo e(__('And')); ?></option>
                                <option value="or"><?php echo e(__('Or')); ?></option>
                            </select>
                        </div>
                        <div class="form-group mb-6">
                            <div class="row">
                                <div class="col-2">
                                    <button type="button" class="btn btn-secondary"><?php echo e(__('IF')); ?></button>
                                </div>
                                <div class="col-10">
                                    <div class="repeater">
                                        <div data-repeater-list="rules">
                                            <div data-repeater-item class="border-bottom py-2">
                                                <div class="row count-row">
                                                    <div class="col-lg-4">
                                                        <select name="if_field_name" class="if_field_name form-control"
                                                            data-trigger>
                                                            <option selected disabled><?php echo e(__('Select Field')); ?></option>
                                                            <?php $__currentLoopData = $jsonData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jsons): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $__currentLoopData = $jsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $json): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(
                                                                        !in_array($json->type, [
                                                                            'SignaturePad',
                                                                            'header',
                                                                            'file',
                                                                            'location',
                                                                            'video',
                                                                            'selfie',
                                                                            'autocomplete',
                                                                            'button',
                                                                            'break',
                                                                            'starRating',
                                                                            'hidden',
                                                                            'paragraph',
                                                                            'number',
                                                                        ])): ?>
                                                                        <?php if(isset($json->name) && isset($json->label)): ?>
                                                                            <?php
                                                                                $ifDataFieldNames = [];
                                                                                $rules = App\Models\FormRule::where('form_id', $formRules->id)->get();
                                                                            ?>

                                                                            <?php $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php
                                                                                    $ifJsonArray = json_decode($rule->if_json, true);
                                                                                    foreach ($ifJsonArray as $ifData) {
                                                                                        $ifDataFieldNames[] = $ifData['if_field_name'];
                                                                                    }
                                                                                ?>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                                            <?php if(!in_array($json->name, $ifDataFieldNames)): ?>
                                                                                <option value="<?php echo e($json->name); ?>">
                                                                                    <?php echo e($json->label); ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <select name="if_rule_type" id="if_rule_type" class="form-control"
                                                            data-trigger>
                                                            <option value="" selected disabled>
                                                                <?php echo e(__('Select Type')); ?>

                                                            </option>
                                                            <option value="is"><?php echo e(__('Is')); ?></option>
                                                            <option value="is-not"><?php echo e(__('Is Not')); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 input-container">
                                                        <?php echo e(Form::text('if_rule_value', null, ['class' => 'form-control', 'id' => 'if_rule_value'])); ?>

                                                    </div>
                                                    <div class="col-lg-1">
                                                        <input data-repeater-delete class="btn btn-danger p-2"
                                                            type="button" value="Delete" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <input data-repeater-create class="btn btn-primary p-2 add-repeater-button"
                                                type="button" value="Add" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-6">
                            <div class="row">
                                <div class="col-2">
                                    <button type="button" class="btn btn-secondary"><?php echo e(__('Then')); ?></button>
                                </div>
                                <div class="col-10">
                                    <div class="repeater2">
                                        <div data-repeater-list="rules2">
                                            <div data-repeater-item class="border-bottom py-2">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <select name="else_rule_type" id="else_rule_type"
                                                            class="form-control" data-trigger>
                                                            <option value="" selected disabled>
                                                                <?php echo e(__('Select Type')); ?>

                                                            </option>
                                                            <option value="show"><?php echo e(__('Show')); ?></option>
                                                            <option value="hide"><?php echo e(__('Hide')); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <select name="else_field_name" id="else_field_name"
                                                            class="form-control form-select" data-trigger multiple>
                                                            <?php
                                                                $thenDataFieldNames = [];
                                                                foreach ($rules as $rule) {
                                                                    $ThenJsonArray = json_decode($rule->then_json, true);
                                                                    foreach ($ThenJsonArray as $thenData) {
                                                                        $thenDataFieldNames = array_merge($thenDataFieldNames, $thenData['else_field_name']);
                                                                    }
                                                                }
                                                            ?>
                                                            <?php $__currentLoopData = $jsonData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jsons): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $__currentLoopData = $jsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $json): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(isset($json->name) && isset($json->label)): ?>
                                                                        <?php if(!in_array($json->name, $thenDataFieldNames)): ?>
                                                                            <option value="<?php echo e($json->name); ?>">
                                                                                <?php echo e($json->label); ?>

                                                                            </option>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <input data-repeater-delete class="btn btn-danger p-2"
                                                            type="button" value="Delete" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <input data-repeater-create class="btn btn-primary p-2 " type="button"
                                                value="Add" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    
                    <?php echo e(form::button(__('Save'), ['class' => 'btn btn-primary', 'id' => 'save-btn', 'type' => 'submit'])); ?>

                </div>
            </div>
        </div>
        <?php echo e(Form::close()); ?>

    </div>

    <div class="row">
        <div class="m-auto col-lg-8 col-md-8 col-sm-12 col-12">
            <div class="card">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo e(__('No')); ?></th>
                            <th><?php echo e(__('Rule Name')); ?></th>
                            <th><?php echo e(__('Action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($rules) || is_object($rules)): ?>
                            <?php
                                $ff_no = 1;
                            ?>
                            <?php $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($ff_no++); ?></td>
                                    <td><?php echo e($rule->rule_name); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('rule.edit', $rule->id)); ?>"><button
                                                class="btn btn-primary btn-sm small"><?php echo e(__('Edit')); ?></button></a>
                                        <?php echo Form::open([
                                            'method' => 'DELETE',
                                            'class' => 'd-inline',
                                            'route' => ['rule.delete', $rule->id],
                                            'id' => 'delete-form-' . $rule->id,
                                        ]); ?>

                                        <a href="#" class="btn btn-sm small btn-danger show_confirm"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            id="delete-form-<?php echo e($rule->id); ?>"
                                            data-bs-original-title="<?php echo e(__('Cancel Rule')); ?>"
                                            aria-label="<?php echo e(__('Cancel Rule')); ?>"><?php echo e(__('Delete')); ?></a>
                                        <?php echo Form::close(); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/repeater/reapeater.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/repeater/jquery.input.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/repeater/jquery.repeater.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            var $repeater = $('.repeater').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                    var data = $(this).find('input, textarea, select').toArray();
                    data.forEach(function(val) {
                        $(val).parents('.form-group').find('label').attr('for', $(val).attr(
                            'name'));
                        $(val).attr('id', $(val).attr('name'));
                    });

                    var $selects = $(this).find('select[data-trigger]');
                    $selects.each(function() {
                        var select = this;
                        new Choices(select, {
                            removeItemButton: true,
                        });
                    });
                    var rowCount = $('.count-row').length;
                    if (rowCount > 1) {
                        $('.condition-select').removeClass('d-none');
                        $('.condition-select').addClass('d-block');
                        $('.condition-select').fadeIn(500);
                    }
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function(setIndexes) {
                    var $initialSelects = $('.repeater [data-trigger]');
                    $initialSelects.each(function() {
                        var select = this;
                        new Choices(select, {
                            placeholderValue: 'This is a placeholder set in the config',
                            searchPlaceholderValue: 'This is a search placeholder',
                            removeItemButton: true,

                        });
                    });
                },
                isFirstItemUndeletable: true
            });

            var $repeater2 = $('.repeater2').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                    var data = $(this).find('input, textarea, select').toArray();
                    data.forEach(function(val) {
                        $(val).parents('.form-group').find('label').attr('for', $(val).attr(
                            'name'));
                        $(val).attr('id', $(val).attr('name'));
                    });

                    var $selects = $(this).find('select[data-trigger]');
                    $selects.each(function() {
                        var select = this;
                        new Choices(select, {
                            removeItemButton: true,
                        });
                    });
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function(setIndexes) {
                    var genericExamples = document.querySelectorAll('[data-trigger]');
                    for (i = 0; i < genericExamples.length; ++i) {
                        var element = genericExamples[i];
                        new Choices(element, {
                            placeholderValue: 'This is a placeholder set in the config',
                            searchPlaceholderValue: 'This is a search placeholder',
                            removeItemButton: true,

                        });
                    }
                },
                isFirstItemUndeletable: true
            });
        });
    </script>

    <script>
        $(document).on('click', '#save-btn', function(e) {
            e.preventDefault();
            $('.is-invalid').removeClass('is-invalid');
            $('.error-message').remove();

            var isValid = true;
            if ($('input[name="rule_name"]').val() === '') {
                $('input[name="rule_name"]').addClass('is-invalid');
                $('input[name="rule_name"]').after('<div class="error-message">Please fill this field.</div>');
                isValid = false;
            }

            if ($(".if_field_name").val() === '') {
                $(".if_field_name").addClass('is-invalid');
                $(".if_field_name").after('<div class="error-message">Select Any One.</div>');
                isValid = false;
            }

            if ($("#if_rule_type").val() === '') {
                $("#if_rule_type").addClass('is-invalid');
                $("#if_rule_type").after('<div class="error-message">Select Any One.</div>');
                isValid = false;
            }

            if ($("#if_rule_value").val() === '') {
                $("#if_rule_value").addClass('is-invalid');
                $("#if_rule_value").after('<div class="error-message">Please fill this field.</div>');
                isValid = false;
            }

            if ($("#else_rule_type").val() === '') {
                $("#else_rule_type").addClass('is-invalid');
                $("#else_rule_type").after('<div class="error-message">Select Any One.</div>');
                isValid = false;
            }

            if ($("#else_field_name").val() === '') {
                $("#else_field_name").addClass('is-invalid');
                $("#else_field_name").after('<div class="error-message">Select Any One.</div>');
                isValid = false;
            }
            if (isValid) {
                $("#form-rule").submit();
            }

        });
    </script>

    <script>
        var repeaterIndex = 0;
        $(document).on('click', '.add-repeater-button', function() {
            repeaterIndex++;
        });
        $(document).on('change', '.if_field_name', function() {
            var fieldName = $(this).find(':selected').val();
            var id = '<?php echo e($formRules->id); ?>';
            console.log(id);
            var inputContainer = $(this).closest('[data-repeater-item]').find('.input-container');
            inputContainer.empty();

            $.ajax({
                type: "GET",
                url: "<?php echo e(route('get.field')); ?>",
                data: {
                    id: id,
                    fieldname: fieldName
                },
                success: function(response) {
                    var inputType = '';
                    if (response.matchingField.type == 'date') {
                        inputType = 'date';
                        var html = '<input class="form-control" name="rules[' + repeaterIndex +
                            '][if_rule_value]" data-name="' + response.matchingField.name + '" type="' +
                            inputType + '">';
                        inputContainer.append(html);
                    } else if (response.matchingField.type == 'text') {
                        inputType = 'text';
                        var html = '<input class="form-control" name="rules[' + repeaterIndex +
                            '][if_rule_value]" data-name="' + response.matchingField.name + '" type="' +
                            inputType + '">';
                        inputContainer.append(html);

                    } else if (response.matchingField.type == 'textarea') {
                        inputType = 'textarea';
                        var html = '<textarea class="form-control" name="rules[' + repeaterIndex +
                            '][if_rule_value]" data-name="' + response.matchingField.name + '" type="' +
                            inputType + '"></textarea>';
                        inputContainer.append(html);
                    } else {
                        var select = $('<select>', {
                            name: 'rules[' + repeaterIndex + '][if_rule_value]',
                            class: 'form-control',
                        });
                        response.matchingField.values.forEach(function(value) {
                            var option = $('<option>', {
                                value: value.value,
                                text: value.label
                            });
                            select.append(option);
                        });
                        inputContainer.append(select);
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/conditional-rules/rules.blade.php ENDPATH**/ ?>