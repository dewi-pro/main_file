 <script>
     <?php if(session('failed')): ?>
         show_toastr('Falied!', '<?php echo e(session('failed')); ?>', 'failed');
     <?php endif; ?>
     <?php if($errors = session('errors')): ?>
         <?php if(is_object($errors)): ?>
             <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 show_toastr('Error!', '<?php echo e($error); ?>', 'danger');
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php else: ?>
             show_toastr('Error!', '<?php echo e(session('errors')); ?>', 'danger');
         <?php endif; ?>
     <?php endif; ?>
     <?php if(session('successful')): ?>
         show_toastr('Successfully!', '<?php echo e(session('successful')); ?>', 'success');
     <?php endif; ?>
     <?php if(session('success')): ?>
         show_toastr('Success!', '<?php echo e(session('success')); ?>', 'success');
     <?php endif; ?>
     <?php if(session('warning')): ?>
         show_toastr('Warning!', '<?php echo e(session('warning')); ?>', 'warning');
     <?php endif; ?>
     <?php if(session('status')): ?>
         show_toastr('Great!', '<?php echo e(session('status')); ?>', 'info');
     <?php endif; ?>
 </script>
 <script>
     $(document).on('click', '.delete-action', function() {
         var form_id = $(this).attr('data-form-id')
         $.confirm({
             title: '<?php echo e(__('Alert !')); ?>',
             conentt: '<?php echo e(__('Are You sure ?')); ?>',
             buttons: {
                 confirm: function() {
                     $("#" + form_id).submit();
                 },
                 cancel: function() {}
             }
         });
     });
 </script>
 <script>
     const sweetAlert = Swal.mixin({
         customClass: {
             confirmButton: 'btn btn-success m-1',
             cancelButton: 'btn btn-danger m-1'
         },
         buttonsStyling: false,
         title: 'Are you sure?',
         text: "23sfdcvdcgvThis action can not be undone. Do you want to continue?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Next Page',
         cancelButtonText: 'No',
         reverseButtons: true
     })
 </script>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/layouts/includes/alerts.blade.php ENDPATH**/ ?>