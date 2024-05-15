<?php $__env->startSection('title', 'View Forms'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('View Forms')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo Html::link(route('forms.index'), __('Forms'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo e(__('View Forms')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="section-body">
            <div class="row">
                <?php if(!empty($formValue->Form->logo)): ?>
                    <div class="mb-2 text-center gallery gallery-md">
                        <img id="app-dark-logo" class="float-none gallery-item"
                            src="<?php echo e(Storage::exists($formValue->Form->logo) ? Storage::url($formValue->Form->logo) : Storage::url('not-exists-data-images/78x78.png')); ?>">
                    </div>
                <?php endif; ?>
                <div
                    class="card col-xl-8 col-lg-7 <?php echo e(isset($formValue->submited_forms_latitude) && isset($formValue->submited_forms_longitude) ? '' : 'mx-auto'); ?>">
                    <div class="card-header">
                        <h5> <?php echo e($formValue->Form->title); ?>


                        </h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="view-form-data">
                            <div class="row">
                                <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            // $fieldHidden = false;
                                            // if (in_array($row->name, $hideFields)) {
                                            //     $fieldHidden = true;
                                            // }
                                        ?>
                                        <?php if($row->type == 'checkbox-group'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <p>
                                                    <ul>
                                                        <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if(isset($options->selected)): ?>
                                                                <li>
                                                                    <label><?php echo e($options->label); ?></label>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                    </p>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'file'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <p>
                                                        <?php if(property_exists($row, 'value')): ?>
                                                            <?php if($row->value): ?>
                                                                <?php
                                                                    $allowed_extensions = [
                                                                        'pdf',
                                                                        'pdfa',
                                                                        'fdf',
                                                                        'xdp',
                                                                        'xfa',
                                                                        'pdx',
                                                                        'pdp',
                                                                        'pdfxml',
                                                                        'pdxox',
                                                                        'xlsx',
                                                                        'csv',
                                                                        'xlsm',
                                                                        'xltx',
                                                                        'xlsb',
                                                                        'xltm',
                                                                        'xlw',
                                                                    ];
                                                                ?>
                                                                <?php if($row->multiple): ?>
                                                                    <div class="row">
                                                                        <?php if(App\Facades\UtilityFacades::getsettings('storage_type') == 'local'): ?>
                                                                            <?php $__currentLoopData = $row->value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $fileName = explode('/', $img);
                                                                                        $fileName = end($fileName);
                                                                                    ?>
                                                                                    <?php if(in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                        <?php
                                                                                            $fileName = explode(
                                                                                                '/',
                                                                                                $img,
                                                                                            );
                                                                                            $fileName = end($fileName);
                                                                                        ?>
                                                                                        <a class="my-2 btn btn-info"
                                                                                            href="<?php echo e(asset('storage/app/' . $img)); ?>"
                                                                                            type="image"
                                                                                            download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                    <?php else: ?>
                                                                                        <img src="<?php echo e(Storage::exists($img) ? asset('storage/app/' . $img) : Storage::url('not-exists-data-images/78x78.png')); ?>"
                                                                                            class="mb-2 img-responsive img-thumbnail">
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php else: ?>
                                                                            <?php $__currentLoopData = $row->value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $fileName = explode('/', $img);
                                                                                        $fileName = end($fileName);
                                                                                    ?>
                                                                                    <?php if(in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                        <?php
                                                                                            $fileName = explode(
                                                                                                '/',
                                                                                                $img,
                                                                                            );
                                                                                            $fileName = end($fileName);
                                                                                        ?>
                                                                                        <a class="my-2 btn btn-info"
                                                                                            href="<?php echo e(Storage::url($img)); ?>"
                                                                                            type="image"
                                                                                            download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                    <?php else: ?>
                                                                                        <img src="<?php echo e(Storage::url($img)); ?>"
                                                                                            class="mb-2 img-responsive img-thumbnail">
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <?php if($row->subtype == 'fineuploader'): ?>
                                                                                <?php if(App\Facades\UtilityFacades::getsettings('storage_type') == 'local'): ?>
                                                                                    <?php if($row->value[0]): ?>
                                                                                        <?php $__currentLoopData = $row->value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                            <?php
                                                                                                $fileName = explode(
                                                                                                    '/',
                                                                                                    $img,
                                                                                                );
                                                                                                $fileName = end(
                                                                                                    $fileName,
                                                                                                );
                                                                                            ?>
                                                                                            <?php if(in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                                <a class="my-2 btn btn-info"
                                                                                                    href="<?php echo e(asset('storage/app/' . $img)); ?>"
                                                                                                    type="image"
                                                                                                    download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                            <?php else: ?>
                                                                                                <img src="<?php echo e(Storage::exists($img) ? asset('storage/app/' . $img) : Storage::url('not-exists-data-images/78x78.png')); ?>"
                                                                                                    class="mb-2 img-responsive img-thumbnail">
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                    <?php endif; ?>
                                                                                <?php else: ?>
                                                                                    <?php if($row->value[0]): ?>
                                                                                        <?php $__currentLoopData = $row->value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                            <?php
                                                                                                $fileName = explode(
                                                                                                    '/',
                                                                                                    $img,
                                                                                                );
                                                                                                $fileName = end(
                                                                                                    $fileName,
                                                                                                );
                                                                                            ?>
                                                                                            <?php if(in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                                <a class="my-2 btn btn-info"
                                                                                                    href="<?php echo e(Storage::url($img)); ?>"
                                                                                                    type="image"
                                                                                                    download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                            <?php else: ?>
                                                                                                <img src="<?php echo e(Storage::url($img)); ?>"
                                                                                                    class="mb-2 img-responsive img-thumbnail">
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>
                                                                            <?php else: ?>
                                                                                <?php if(App\Facades\UtilityFacades::getsettings('storage_type') == 'local'): ?>
                                                                                    <?php if(in_array(pathinfo($row->value, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                        <?php
                                                                                            $fileName = explode(
                                                                                                '/',
                                                                                                $row->value,
                                                                                            );
                                                                                            $fileName = end($fileName);
                                                                                        ?>
                                                                                        <a class="my-2 btn btn-info"
                                                                                            href="<?php echo e(asset('storage/app/' . $row->value)); ?>"
                                                                                            type="image"
                                                                                            download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                    <?php else: ?>
                                                                                        <img src="<?php echo e(Storage::exists($row->value) ? asset('storage/app/' . $row->value) : Storage::url('not-exists-data-images/78x78.png')); ?>"
                                                                                            class="mb-2 img-responsive img-thumbnailss">
                                                                                    <?php endif; ?>
                                                                                <?php else: ?>
                                                                                    <?php if(in_array(pathinfo($row->value, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                        <?php
                                                                                            $fileName = explode(
                                                                                                '/',
                                                                                                $row->value,
                                                                                            );
                                                                                            $fileName = end($fileName);
                                                                                        ?>
                                                                                        <a class="my-2 btn btn-info"
                                                                                            href="<?php echo e(Storage::url($row->value)); ?>"
                                                                                            type="image"
                                                                                            download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                    <?php else: ?>
                                                                                        <img src="<?php echo e(Storage::url($row->value)); ?>"
                                                                                            class="mb-2 img-responsive img-thumbnailss">
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'header'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <<?php echo e($row->subtype); ?>>
                                                        <?php echo e(html_entity_decode($row->label)); ?>

                                                        </<?php echo e($row->subtype); ?>>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'paragraph'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <<?php echo e($row->subtype); ?>>
                                                        <?php echo e(html_entity_decode($row->label)); ?>

                                                        </<?php echo e($row->subtype); ?>>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'radio-group'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <p>
                                                        <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if(isset($options->selected)): ?>
                                                                <?php echo e($options->label); ?>

                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </p>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'select'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>

                                                    <p>
                                                        <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if(isset($options->selected)): ?>
                                                                <?php echo e($options->label); ?>

                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </p>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'autocomplete'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <p>
                                                        <?php echo e($row->value); ?>

                                                    </p>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'number'): ?>
                                            
                                            <div class="col-12">
                                                <b><?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                </b>
                                                <p>
                                                    <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                </p>
                                            </div>
                                            
                                        <?php elseif($row->type == 'text'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <?php if($row->subtype == 'color'): ?>
                                                        <div class="p-2" style="background-color: <?php echo e($row->value); ?>;">
                                                        </div>
                                                    <?php else: ?>
                                                        <p>
                                                            <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'date'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <p>
                                                        <?php echo e(isset($row->value) ? date('d-m-Y', strtotime($row->value)) : ''); ?>

                                                    </p>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'textarea'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <?php if($row->subtype == 'ckeditor'): ?>
                                                        <?php echo isset($row->value) ? $row->value : ''; ?>

                                                    <?php else: ?>
                                                        <p>
                                                            <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'starRating'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php
                                                        $attr = ['class' => 'form-control'];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : 0;
                                                        $noOfStar = isset($row->number_of_star)
                                                            ? $row->number_of_star
                                                            : 5;
                                                    ?>
                                                    <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <p>
                                                    <div id="<?php echo e($row->name); ?>" class="starRating"
                                                        data-value="<?php echo e($value); ?>"
                                                        data-no_of_star="<?php echo e($noOfStar); ?>">
                                                    </div>
                                                    <input type="hidden" name="<?php echo e($row->name); ?>"
                                                        value="<?php echo e($value); ?>">
                                                    </p>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'SignaturePad'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php
                                                        $attr = ['class' => 'form-control'];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : 0;
                                                        $noOfStar = isset($row->number_of_star)
                                                            ? $row->number_of_star
                                                            : 5;
                                                    ?>
                                                    <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                    <?php if($row->required): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <?php if(property_exists($row, 'value')): ?>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <img src="<?php echo e(asset(Storage::url($row->value))); ?>">
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'break'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <hr class="hr_border">
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'location'): ?>
                                            
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo Form::label('location_id', 'Location:'); ?>

                                                    <iframe width="100%" height="260" frameborder="0" scrolling="no"
                                                        marginheight="0" marginwidth="0"
                                                        src="https://maps.google.com/maps?q=<?php echo e($row->value); ?>&hl=en&z=14&amp;output=embed">
                                                    </iframe>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($row->type == 'video'): ?>
                                            <?php if($row->value && Storage::exists($row->value)): ?>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?><br>
                                                        <a href="<?php echo e(route('selfie.image.download', $formValue->id)); ?>">
                                                            <button class="btn btn-primary p-2"
                                                                id="downloadButton"><?php echo e(__('Download Video')); ?></button></a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif($row->type == 'selfie'): ?>
                                            <?php if($row->value && Storage::exists($row->value)): ?>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?><br>
                                                        <img
                                                            src=" <?php echo e(Illuminate\Support\Facades\File::exists(Storage::path($row->value)) ? Storage::url($row->value) : Storage::url('app-logo/78x78.png')); ?>"class="img-responsive img-thumbnailss mb-2">
                                                        <br>
                                                        <a href="<?php echo e(route('selfie.image.download', $formValue->id)); ?>">
                                                            <button class="btn btn-primary p-2"
                                                                id="downloadButton"><?php echo e(__('Download Image')); ?></button></a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label($row->name, isset($row->label))); ?><?php if(isset($row->required)): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <p>
                                                        <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                    </p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($formValue->payment_type == 'offlinepayment' && isset($formValue->transfer_slip)): ?>
                                    <div>
                                        <h5><?php echo e(__('Download Payment Slip')); ?></h5>
                                        <a href="<?php echo e(route('download.form.values.pdf', $formValue->id)); ?>"
                                            class="btn btn-primary btn-lg mt-2">Download</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="javascript:javascript:history.go(-1)"
                            class="btn btn-secondary float-end"><?php echo e(__('Back')); ?></a>
                    </div>
                </div>
                <?php if(isset($formValue->submited_forms_latitude) && isset($formValue->submited_forms_longitude)): ?>
                    <div class="col-xl-4 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo e(__('User Details')); ?></h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-responsive">
                                    <tr>
                                        <th><?php echo e(__('IP Address')); ?></th>
                                        <td><?php echo e(isset($formValue->submited_forms_ip) ? $formValue->submited_forms_ip : '-'); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('Country Name')); ?></th>
                                        <td><?php echo e(isset($formValue->submited_forms_country) ? $formValue->submited_forms_country : '-'); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('Region Name')); ?></th>
                                        <td><?php echo e(isset($formValue->submited_forms_region) ? $formValue->submited_forms_region : '-'); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('City Name')); ?></th>
                                        <td><?php echo e(isset($formValue->submited_forms_city) ? $formValue->submited_forms_city : '-'); ?>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div id="map" class="mb-0"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <link href="<?php echo e(asset('vendor/jqueryform/css/jquery.rateyo.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('vendor/jqueryform/js/jquery.rateyo.min.js')); ?>"></script>
    <script>
        var $starRating = $('.starRating');
        if ($starRating.length) {
            $starRating.each(function() {
                var val = $(this).attr('data-value');
                var noOfStar = $(this).attr('data-no_of_star');
                if (noOfStar == 10) {
                    val = val / 2;
                }
                $(this).rateYo({
                    rating: val,
                    readOnly: true,
                    numStars: noOfStar
                })
            });
        }
    </script>
    <?php if(isset($formValue->submited_forms_latitude) && isset($formValue->submited_forms_longitude)): ?>
        <script>
            function initMap() {
                const myLatLng = {
                    lat: <?php echo e($formValue->submited_forms_latitude); ?>,
                    lng: <?php echo e($formValue->submited_forms_longitude); ?>

                };

                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 5,
                    center: myLatLng,
                });

                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: '<?php echo e($formValue->submited_forms_city); ?>',
                });
            }
            window.initMap = initMap;
        </script>

        <script src="https://maps.google.com/maps/api/js?key=<?php echo e(Utility::getsettings('google_map_api')); ?>&callback=initMap">
        </script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form-value/view.blade.php ENDPATH**/ ?>