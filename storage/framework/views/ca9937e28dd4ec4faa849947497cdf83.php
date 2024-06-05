<?php $__env->startSection('title', __('Form Integration')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div class="previous-next-btn">
                <div class="page-header-title">
                    <h4 class="m-b-10"><?php echo e(__('Form Integration')); ?></h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('forms.index')); ?>"><?php echo e(__('Forms')); ?></a></li>
                    <li class="breadcrumb-item"> <?php echo e(__('Form Integration')); ?> </li>
                </ul>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="m-auto col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Integration')); ?></h5>
                </div>
                <?php echo Form::open([
                    'route' => ['form.integration.store', $form->id],
                    'method' => 'POST',
                    'data-validate',
                ]); ?>

                <div class="card-body">
                    <div class="btn-group integrate">
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('slack.integration', $form->id)); ?>" id="slack"><i
                                class="ti ti-plus"></i><?php echo e(__('Slack')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('telegram.integration', $form->id)); ?>" id="telegram"><i
                                class="ti ti-plus"></i><?php echo e(__('Telegram')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('mailgun.integration', $form->id)); ?>" id="mailgun"><i
                                class="ti ti-plus"></i><?php echo e(__('Mailgun')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('bulkgate.integration', $form->id)); ?>" id="bulkgate"><i
                                class="ti ti-plus"></i><?php echo e(__('BulkGate')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('nexmo.integration', $form->id)); ?>" id="nexmo"><i
                                class="ti ti-plus"></i><?php echo e(__('Nexmo')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('fast2sms.integration', $form->id)); ?>" id="fast2sms"><i
                                class="ti ti-plus"></i><?php echo e(__('Fast2SMS')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('vonage.integration', $form->id)); ?>" id="vonage"><i
                                class="ti ti-plus"></i><?php echo e(__('Vonage')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('sendgrid.integration', $form->id)); ?>" id="sendgrid"><i
                                class="ti ti-plus"></i><?php echo e(__('SendGrid')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('twilio.integration', $form->id)); ?>" id="twilio"><i
                                class="ti ti-plus"></i><?php echo e(__('Twilio')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('textlocal.integration', $form->id)); ?>" id="textlocal"><i
                                class="ti ti-plus"></i><?php echo e(__('Textlocal')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('messente.integration', $form->id)); ?>" id="messente"><i
                                class="ti ti-plus"></i><?php echo e(__('Messente')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('smsgateway.integration', $form->id)); ?>" id="smsgateway"><i
                                class="ti ti-plus"></i><?php echo e(__('SmsGateway')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('clicktell.integration', $form->id)); ?>" id="clicktell"><i
                                class="ti ti-plus"></i><?php echo e(__('Clicktell')); ?></button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="<?php echo e(route('clockwork.integration', $form->id)); ?>" id="clockwork"><i
                                class="ti ti-plus"></i><?php echo e(__('Clockwork')); ?></button>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-xxl-12">
                            <div class="faq justify-content-center">
                                <div class="accordion accordion-flush setting-accordion" id="accordionExample-integration">
                                    <?php if($slackJsons): ?>
                                        <?php $__currentLoopData = $slackJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slackJsonkey => $slackJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.slack', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($telegramJsons): ?>
                                        <?php $__currentLoopData = $telegramJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $telegramJsonkey => $telegramJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.telegram', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($mailgunJsons): ?>
                                        <?php $__currentLoopData = $mailgunJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mailgunJsonkey => $mailgunJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.mailgun', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($bulkgateJsons): ?>
                                        <?php $__currentLoopData = $bulkgateJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bulkgateJsonkey => $bulkgateJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.bulkgate', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($nexmoJsons): ?>
                                        <?php $__currentLoopData = $nexmoJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nexmoJsonkey => $nexmoJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.nexmo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($fast2smsJsons): ?>
                                        <?php $__currentLoopData = $fast2smsJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fast2smsJsonkey => $fast2smsJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.fast2sms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($vonageJsons): ?>
                                        <?php $__currentLoopData = $vonageJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vonageJsonkey => $vonageJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.vonage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($sendgridJsons): ?>
                                        <?php $__currentLoopData = $sendgridJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sendgridJsonkey => $sendgridJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.sendgrid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($twilioJsons): ?>
                                        <?php $__currentLoopData = $twilioJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $twilioJsonkey => $twilioJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.twilio', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($textlocalJsons): ?>
                                        <?php $__currentLoopData = $textlocalJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $textlocalJsonkey => $textlocalJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.textlocal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($messenteJsons): ?>
                                        <?php $__currentLoopData = $messenteJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $messenteJsonkey => $messenteJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.messente', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($smsgatewayJsons): ?>
                                        <?php $__currentLoopData = $smsgatewayJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $smsgatewayJsonkey => $smsgatewayJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.smsgateway', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($clicktellJsons): ?>
                                        <?php $__currentLoopData = $clicktellJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clicktellJsonkey => $clicktellJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.clicktell', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($clockworkJsons): ?>
                                        <?php $__currentLoopData = $clockworkJsons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clockworkJsonkey => $clockworkJson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('form.integration.clockwork', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        <?php echo Html::link(route('forms.index'), __('Cancel'), ['class' => 'btn btn-secondary']); ?>

                        <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                    removeItemButton: true,
                });
            }
        });
        $(document).ready(function() {
            $(document).on('click', '.integrate button', function() {
                var $this = $(this);
                var url = $this.attr('data-url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        var html = $.parseHTML(response);
                        var countId = $this.attr('id');
                        var classCount = $('.aria-' + countId).length;
                        var inputData = $(html).find('input,textarea').toArray();
                        inputData.forEach(function(val, key) {
                            var id = $(val).attr('id');
                            $(val).parent().find('label').attr('for', id + classCount);
                            $(val).attr('id', id + classCount);
                        });
                        var selectData = $(html).find('select').toArray();
                        selectData.forEach(function(val, key) {
                            var id = $(val).attr('id');
                            $(val).parent().find('label').attr('for', id + classCount);
                            $(val).attr('id', id + classCount);
                            $(val).attr('name', id + classCount + '[]');
                        });

                        var genericExamples = $(html).find('[data-trigger]');
                        for (i = 0; i < genericExamples.length; ++i) {
                            var element = genericExamples[i];
                            new Choices(element, {
                                placeholderValue: 'This is a placeholder set in the config',
                                searchPlaceholderValue: 'This is a search placeholder',
                                removeItemButton: true,
                            });
                        }
                        var accordionBtn = $(html).find('.collapse').attr('id');
                        $(html).find('.collapse').attr('id', accordionBtn + '-' + classCount);
                        $(html).find('.accordion-button').attr('data-bs-target', '#' +
                            accordionBtn + '-' + classCount);
                        $('#accordionExample-integration').append(html);
                    },
                    error: function(xhr, status, error) {

                    }
                });
            });
            $(document).on('click', '.remove-card', function() {
                $(this).parents('.accordion-item').remove();
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/integration/index.blade.php ENDPATH**/ ?>