<?php $__env->startPush('script'); ?>

    <script>
        $(document).ready(function() {
            var formRules = <?php echo json_encode($formRules); ?>;
            formRules.forEach(function(rule) {
                var thenJsonData = JSON.parse(rule.then_json);
                thenJsonData.forEach(function(thenData) {
                    var fields = ShowHideElseFieldName(rule.if_field_name, thenData);
                    if (thenData.else_rule_type === 'show') {
                        if (fields && Array.isArray(fields)) {
                            fields.forEach(function(field) {
                                $('div[data-name="' + field + '"]').addClass('d-none');
                                $('div[data-name="' + field + '"]').removeClass('d-block');
                            });
                        }
                    }
                });
            });

            function ShowHideElseFieldName(ifFieldName, thenData) {
                return thenData.else_field_name;
            }

            function ShowField(fieldName) {
                $('div[data-name="' + fieldName + '"]').removeClass('d-none');
                $('div[data-name="' + fieldName + '"]').addClass('d-block');
                $('input[name="' + fieldName + '"]').attr('required', true).addClass('required');
                $('textarea[name="' + fieldName + '"]').attr('required', true).addClass('required');
                $('select[name="' + fieldName + '"]').attr('required', true).addClass('required');
                $('input[type="checkbox"]').attr('required', true).addClass('required');
            }

            function HideField(fieldName) {
                $('div[data-name="' + fieldName + '"]').addClass('d-none');
                $('div[data-name="' + fieldName + '"]').removeClass('d-block');
                $('input[name="' + fieldName + '"]').removeAttr('required').removeClass('required');
                $('textarea[name="' + fieldName + '"]').removeAttr('required').removeClass('required');
                $('select[name="' + fieldName + '"]').removeAttr('required').removeClass('required');
                $('input[type="checkbox"]').removeAttr('required').removeClass('required');
            }

            function handleInputFieldLogic(element, rule, selectedValues) {
                var ifjsonData = JSON.parse(rule.if_json);
                var thenJsonData = JSON.parse(rule.then_json);
                var condition = rule.condition;

                var fieldName = element.attr('name');
                var fieldValue = element.val();

                var results = [];
                ifjsonData.forEach(function(rule) {
                    var ShowHide = false;
                    if (rule.if_rule_type === "is") {
                        $.each(rule, function(key, value) {
                            if (key == 'if_field_name') {
                                var result = (fieldValue == rule.if_rule_value);
                                results.push(result);
                            }
                        });
                    } else if (rule.if_rule_type === "is-not") {
                        $.each(rule, function(key, value) {
                            if (key == 'if_field_name') {
                                var result = (fieldValue != rule
                                    .if_rule_value);
                                results.push(result);
                            }
                        });
                    }

                    if (condition === 'or') {
                        if (results.includes(true)) {
                            ShowHide = true;
                        }
                    } else if (condition === 'and') {
                        var blankValue = [];
                        var blankValue = $('input[name="' + rule.if_field_name + '"]').val();
                        if (results.some(result => result === false)) {
                            ShowHide = false;
                        } else if (blankValue != "") {
                            ShowHide = true;
                        }
                    }

                    if (ShowHide) {
                        thenJsonData.forEach(function(thenData) {
                            var elseFieldNames = ShowHideElseFieldName(rule.if_field_name,
                                thenData);
                            if (thenData.else_rule_type === 'hide') {
                                if (elseFieldNames && Array.isArray(elseFieldNames)) {
                                    console.log(elseFieldNames);
                                    elseFieldNames.forEach(function(fieldName) {
                                        HideField(fieldName);
                                    });
                                    $(document).on('keyup', 'input[name="' + fieldName + '"]',
                                        function() {
                                            var value = $(this).val();
                                            if (value != rule.if_rule_value) {
                                                if (elseFieldNames && Array.isArray(
                                                        elseFieldNames)) {
                                                    elseFieldNames.forEach(function(fieldName) {
                                                        ShowField(fieldName);
                                                    });
                                                }
                                            }
                                        });

                                    $(document).on('keyup', 'textarea[name="' + fieldName + '"]',
                                        function() {
                                            var value = $(this).val();
                                            if (value != rule.if_rule_value) {
                                                if (elseFieldNames && Array.isArray(
                                                        elseFieldNames)) {
                                                    elseFieldNames.forEach(function(fieldName) {
                                                        ShowField(fieldName);
                                                    });
                                                }
                                            }
                                        });

                                    $(document).on('change', 'input[name="' + fieldName + '"]',
                                        function() {
                                            var value = $(this).val();
                                            if (value != rule.if_rule_value) {
                                                if (elseFieldNames && Array.isArray(
                                                        elseFieldNames)) {
                                                    elseFieldNames.forEach(function(fieldName) {
                                                        ShowField(fieldName);
                                                    });
                                                }
                                            }

                                            // if (selectedValues.length === 0 || value != rule.if_rule_value) {
                                            //     if (elseFieldNames && Array.isArray(
                                            //             elseFieldNames)) {
                                            //         elseFieldNames.forEach(function(
                                            //             fieldName) {
                                            //             ShowField(fieldName);
                                            //         });
                                            //     }
                                            // }

                                        });

                                    $(document).on('change', 'select[name="' + fieldName + '"]',
                                        function() {
                                            var value = $(this).val();
                                            if (value != rule.if_rule_value) {
                                                if (elseFieldNames && Array.isArray(
                                                        elseFieldNames)) {
                                                    elseFieldNames.forEach(function(fieldName) {
                                                        ShowField(fieldName);
                                                    });
                                                }
                                            }
                                        });
                                }
                            } else if (thenData.else_rule_type === 'show') {
                                if (elseFieldNames && Array.isArray(elseFieldNames)) {
                                    elseFieldNames.forEach(function(fieldName) {
                                        ShowField(fieldName);
                                    });
                                    $(document).on('change', 'input[name="' + fieldName + '"]',
                                        function() {
                                            var value = $(this).val();
                                            if (value != rule.if_rule_value) {
                                                if (elseFieldNames && Array.isArray(
                                                        elseFieldNames)) {
                                                    elseFieldNames.forEach(function(fieldName) {
                                                        HideField(fieldName);
                                                    });
                                                }
                                            } else {
                                                ShowField(fieldName);
                                            }
                                        });
                                    $(document).on('keyup', 'textarea[name="' + fieldName + '"]',
                                        function() {
                                            var value = $(this).val();
                                            if (value != rule.if_rule_value) {
                                                if (elseFieldNames && Array.isArray(
                                                        elseFieldNames)) {
                                                    elseFieldNames.forEach(function(fieldName) {
                                                        HideField(fieldName);
                                                    });
                                                }
                                            } else if (value == rule.if_rule_value) {
                                                ShowField(fieldName);
                                            }
                                        });


                                    $(document).on('change', 'select[name="' + fieldName + '"]',
                                        function() {
                                            var value = $(this).val();
                                            if (value != rule.if_rule_value) {
                                                if (elseFieldNames && Array.isArray(
                                                        elseFieldNames)) {
                                                    elseFieldNames.forEach(function(fieldName) {
                                                        HideField(fieldName);
                                                    });
                                                }
                                            } else if (value == rule.if_rule_value) {
                                                ShowField(fieldName);
                                            }
                                        });
                                }
                            }
                        });
                    }
                });
            }

            formRules.forEach(function(rule) {
                var ifjsonData = JSON.parse(rule.if_json);
                ifjsonData.forEach(function(if_data) {
                    if (rule.condition === 'and') {
                        $(document).on('click', 'input[data-input="' + if_data.if_field_name + '"]',
                            function() {
                                var $this = $(this);
                                var fieldName = $this.attr('name');
                                if (if_data.if_field_name === fieldName) {
                                    handleInputFieldLogic($this, rule);
                                }
                            });
                    } else if (rule.condition === 'or') {
                        $(document).on('blur', 'input[data-input="' + if_data.if_field_name + '"]',
                            function() {
                                var $this = $(this);
                                var fieldName = $this.attr('name');
                                if (if_data.if_field_name === fieldName) {
                                    handleInputFieldLogic($this, rule);
                                }
                            });
                    }

                    // radio, date
                    $(document).on('change', 'input[name="' + if_data.if_field_name + '"]',
                        function() {
                            // console.log($(this));
                            var $this = $(this);
                            var fieldName = $this.attr('name');
                            if (if_data.if_field_name === fieldName) {
                                handleInputFieldLogic($this, rule);
                            }
                        });

                    $(document).on('change', 'textarea[name="' + if_data.if_field_name + '"]',
                        function() {
                            var $this = $(this);
                            var fieldName = $this.attr('name');
                            if (if_data.if_field_name === fieldName) {
                                handleInputFieldLogic($this, rule);
                            }
                        });
                    $(document).on('change', 'select[name="' + if_data.if_field_name + '"]',
                        function() {
                            var $this = $(this);
                            var fieldName = $this.attr('name');
                            if (if_data.if_field_name === fieldName) {
                                handleInputFieldLogic($this, rule);
                            }
                        });
                    $(document).on('click', 'input[name="' + if_data.if_field_name + '[]"]',
                        function() {
                            var $this = $(this);
                            var fieldName = $this.attr('name');

                            var selectedValues = [];

                            $('input[name="' + fieldName + '"]:checked').each(function() {
                                selectedValues.push($(this).val());
                            });

                            // if (if_data.if_field_name === fieldName) {
                            if (Array.isArray(selectedValues)) {
                                handleInputFieldLogic($this, rule, selectedValues);
                            }
                            // }
                        });
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/js/conditional-rule.blade.php ENDPATH**/ ?>