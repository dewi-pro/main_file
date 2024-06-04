<?php echo e(Form::model($formValue , ['route' => ['form-value.status.update' , $formValue->id] ,'method' => 'POST'] )); ?>

<div class="row">
    <div class="form-group">
        <?php echo e(Form::label('form_status' , __('Form Status') , ['class'=> 'form-label'])); ?>

        <?php echo e(Form::select('form_status' , $formStatus , $formValue->form_status ,  ['class' => 'form-control form-select' ,  'data-trigger'])); ?>


    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary"><a href="<?php echo e(route('forms.index')); ?>" class="text-white"><?php echo e(__('Back')); ?></a></button>
    <?php echo e(Form::button(__('Save') , ['class' => 'btn btn-primary' , 'type'=>'submit'])); ?>

</div>
<?php echo e(Form::close()); ?>


<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form-value/form-status.blade.php ENDPATH**/ ?>