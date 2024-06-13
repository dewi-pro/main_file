<?php
    $currantColumn = [];
?>
<table>
    <tbody>
        <?php $__currentLoopData = $formvalues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $formValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $column = $formValue->columns();
            ?>
            <?php if($currantColumn != $column): ?>
                <?php
                    $currantColumn = $column;
                ?>
                <?php if($key != 0): ?>
                    <tr></tr>
                <?php endif; ?>
                <tr>
                    <?php $__currentLoopData = $currantColumn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($value); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </tr>
            <?php endif; ?>
            <tr>
                <?php $__currentLoopData = json_decode($formValue->json); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jsons): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $jsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $json): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($json->value) || isset($json->values)): ?>
                            <?php if(isset($json->value)): ?>
                                <?php if($json->type == 'starRating'): ?>
                                    <td><?php echo e(isset($json->value) ? $json->value : ''); ?></td>
                                <?php elseif($json->type == 'button'): ?>
                                    <td> </td>
                                <?php elseif($json->type == 'date'): ?>
                                    <td><?php echo e(isset($json->value) ? $json->value : ''); ?></td>
                                <?php elseif($json->type == 'number'): ?>
                                    <td><?php echo e(isset($json->value) ? $json->value : ''); ?></td>
                                <?php elseif($json->type == 'text'): ?>
                                    <td><?php echo e(isset($json->value) ? $json->value : ''); ?></td>
                                <?php elseif($json->type == 'textarea'): ?>
                                    <td><?php echo e(isset($json->value) ? $json->value : ''); ?></td>
                                <?php elseif($json->type == 'video'): ?>
                                    <?php if($json->value): ?>
                                        <td>
                                            <?php echo Html::link(Storage::path($json->value), __('video'), []); ?>

                                        </td>
                                    <?php else: ?>
                                        <td>null</td>
                                    <?php endif; ?>
                                <?php elseif($json->type == 'selfie'): ?>
                                    <?php if($json->value): ?>
                                        <td>
                                            <?php echo Html::link(Storage::path($json->value), __('photo'), []); ?>

                                        </td>
                                    <?php else: ?>
                                        <td>null</td>
                                    <?php endif; ?>
                                <?php elseif($json->type == 'SignaturePad'): ?>
                                    <?php if($json->value): ?>
                                        <td>
                                            <?php echo Html::link(Storage::path($json->value), __('image'), []); ?>

                                        </td>
                                    <?php else: ?>
                                        <td>null</td>
                                    <?php endif; ?>
                                <?php elseif($json->type == 'autocomplete'): ?>
                                    <td><?php echo e(isset($json->value) ? $json->value : null); ?></td>
                                <?php elseif($json->type == 'location'): ?>
                                    <?php if($json->value != ''): ?>
                                        <td><?php echo e(isset($json->value)); ?></td>
                                    <?php else: ?>
                                        <td>null</td>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php elseif(isset($json->values)): ?>
                                <?php
                                    $value = '';
                                ?>
                                <?php $__currentLoopData = $json->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($json->type == 'checkbox-group'): ?>
                                        <?php if(isset($subData->selected)): ?>
                                            <?php  $value .= $subData->value . ',' ?>
                                        <?php endif; ?>
                                    <?php elseif($json->type == 'radio-group'): ?>
                                        <?php if(isset($subData->selected)): ?>
                                            <?php  $value .= $subData->value . ',' ?>
                                        <?php endif; ?>
                                    <?php elseif($json->type == 'select'): ?>
                                        <?php if(isset($subData->selected)): ?>
                                            <?php  $value .= $subData->value . ',' ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php  $value = rtrim($value, ',') ?>
                                <td><?php echo e($value ? $value : ''); ?></td>
                            <?php endif; ?>

                            <?php if($json->type == 'file'): ?>
                                <?php if(isset($json->value)): ?>
                                    <?php
                                        $fileData = json_decode($json->value);
                                    ?>
                                        <?php if(is_array($fileData)): ?>
                                            <?php $__currentLoopData = $fileData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td>
                                                    <?php echo Html::link(Storage::path($subData), __('image'), []); ?>

                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <td>
                                                <?php echo Html::link(Storage::path($json->value), __('image'), []); ?>

                                            </td>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($json->type == 'header'): ?>
                            <?php if(isset($json->selected) && $json->selected): ?>
                                <?php echo e(intval($json->number_of_control)); ?>

                                <td> <?php echo e(__('N/A')); ?></td>
                            <?php else: ?>
                                <td><?php echo e(isset($json->value) ? $json->value : ''); ?></td>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if($json->type == 'paragraph'): ?>
                                <td><?php echo e(isset($json->label) ? $json->label : ''); ?></td>
                            <?php endif; ?>
                            <?php if($json->type == 'break'): ?>
                                <td><?php echo e(isset($json->label) ? $json->label : ''); ?></td>
                            <?php endif; ?>
                            <?php if($json->type == 'button'): ?>
                                <td><?php echo e(isset($json->label) ? $json->label : ''); ?></td>
                            <?php endif; ?>
                            
                        <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/export/formvalue.blade.php ENDPATH**/ ?>