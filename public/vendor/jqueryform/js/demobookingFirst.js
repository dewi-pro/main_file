"use strict";
const newLocal = true;
jQuery(function ($) {
    var fields = [{
            type: 'autocomplete',
            label: 'Custom Autocomplete',
            required: true,
            values: [{
                    label: 'SQL'
                },
                {
                    label: 'C#'
                },
                {
                    label: 'JavaScript'
                },
                {
                    label: 'Java'
                },
                {
                    label: 'Python'
                },
                {
                    label: 'C++'
                },
                {
                    label: 'PHP'
                },
                {
                    label: 'Swift'
                },
                {
                    label: 'Ruby'
                }
            ]
        },
        {
            label: 'Star Rating',
            attrs: {
                type: 'starRating',
                number_of_star: 5
            },
            icon: '🌟'
        }, {
            label: "Spinner",
            type: "spinner",
            icon: '<i class="ti ti-arrows-left-right"></i>'
        },
        {
            label: "SignaturePad",
            type: "SignaturePad",
            required: true,
            icon: '<i class="ti ti-writing-sign"></i>'
        },
        {
            label: "Line break",
            type: 'break',
            icon: '<i class="ti ti-line-dashed"></i>'
        }, {
            label: "location",
            type: "location",
            required: true,
            icon: '<i class="ti ti-location"></i>'
        }, {
            label: "Color",
            type: "text",
            subtype: "color",
            icon: '<i class="ti ti-color-picker"></i>'
        },

    ];
    var actionButtons = [{
        id: 'smile',
        className: 'btn btn-success',
        label: '😁',
        type: 'button',
        events: {
            click: function () {
                alert('😁😁😁 !SMILE! 😁😁😁');
            }
        }
    }];
    var templates = {
        starRating: function (fieldData) {
            return {
                field: '<span id="' + fieldData.name + '">',
                onRender: function () {
                    $(document.getElementById(fieldData.name)).rateYo({
                        rating: fieldData.value,
                        numStars: fieldData.number_of_star,
                        halfStar: true,
                        precision: 2
                    });
                }
            };
        },
        "SignaturePad": function (fieldData) {
            return {
                field: '<canvas id="' + fieldData.name + '" class="signature-style">',
                onRender: function () {}
            };
        },
        "spinner": function (fieldData) {
            return {
                field: '<div class="form-group"><div class="input-group spinner"><button type="button" class="spin-minus">-</button><input id="' + fieldData.name + '" type="number" class="form-control"/><button type="button" class="spin-plus">+</button></div></div>',
                onRender: function () {}
            };
        },
        "break": function (fieldData) {
            return {
                field: '<hr class=' + fieldData.className + '>'
            };
        },
        "location": function (fieldData) {
            return {
                field: '<span id="' + fieldData.name + '">',
            };
        }
    };
    var inputSets = [{
        label: 'User Details',
        icon: '👨',
        fields: [{
            type: 'text',
            label: 'First Name',
            className: 'form-control'
        }, {
            type: 'select',
            label: 'Profession',
            className: 'form-control',
            values: [{
                label: 'Street Sweeper',
                value: 'option-2',
                selected: false
            }, {
                label: 'Brain Surgeon',
                value: 'option-3',
                selected: false
            }]
        }, {
            type: 'textarea',
            label: 'Short Bio:',
            className: 'form-control'
        }]
    }, {
        label: 'User Agreement',
        fields: [{
            type: 'header',
            subtype: 'h3',
            label: 'Terms & Conditions',
            className: 'header'
        }, {
            type: 'paragraph',
            label: 'Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.',
        }, {
            type: 'paragraph',
            label: 'Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.',
        }, {
            type: 'checkbox',
            label: 'Do you agree to the terms and conditions?',
        }]
    }];
    var typeUserDisabledAttrs = {};
    var newAttributes = {
        column: {
            label: 'Columns',
            options: {
                '1': '1 Column',
                '2': '2 Column',
                '3': '3 Column',
            },
        }
    };
    var typeUserAttrs = {};
    var options = ["Longitude", "Latitude"];
    const fieldss = ["autocomplete", "button", "checkbox-group", "file", "header", "paragraph", "date", "number", "radio-group", "select", "text", "textarea", "starRating", "spinner", "signaturePad", "break", "location", "color"];
    fieldss.forEach(function (item, index) {
        if (item == 'radio-group' || item == 'select' || item == 'checkbox-group' || item == 'date' || item == 'select' || item == 'starRating') {
            typeUserAttrs[item] = {
                column: newAttributes.column,
                is_enable_chart: {
                    label: 'Enable Chart',
                    type: 'checkbox',
                    value: false,
                },
                column: newAttributes.column,
                chart_type: {
                    label: 'Chart Type',
                    options: {
                        'bar': 'Bar',
                        'pie': 'Pie',
                    },
                },
                column: newAttributes.column,
                show_datatable: {
                    label: 'Show DataTable',
                    type: 'checkbox',
                    value: false,
                }
            };

        } else if (item == 'textarea') {
            typeUserAttrs[item] = {
                column: newAttributes.column,
                show_datatable: {
                    label: 'Show DataTable',
                    type: 'checkbox',
                    value: false,
                }
            };
        } else if (item == 'location') {
            typeUserAttrs[item] = {
                value: {
                    label: "location",
                    options: options,
                },
            };
        } else if (item == 'text') {
            typeUserAttrs[item] = {
                column: newAttributes.column,
                is_client_email: {
                    label: 'Is Client Email',
                    type: 'checkbox',
                    value: '1',
                },
                column: newAttributes.column,
                show_datatable: {
                    label: 'Show DataTable',
                    type: 'checkbox',
                    value: false,
                }
            };
        } else if (item == 'number' || item == 'spinner') {
            typeUserAttrs[item] = {
                show_datatable: {
                    label: 'Show DataTable',
                    type: 'checkbox',
                    value: false,
                }
            };

        } else if (item == 'file') {
            typeUserAttrs[item] = {
                column: newAttributes.column,
                file_extention: {
                    label: 'File extention',
                    options: {
                        'image': 'Image',
                        'pdf': 'PDF',
                        'excel': 'Excel',
                    },
                },
                column: newAttributes.column,
                max_file_size_mb: {
                    label: 'Max File Size (MB)',
                    type: 'number',
                    value: 1024,
                    default: 1024
                },
            };
        } else {
            typeUserAttrs[item] = newAttributes;
        }
    });
    var disabledSubtypes = {
        textarea: ["tinymce", "quill"]
    };
    var disabledAttrs = ['placeholder'];
    var fbOptions = {
        subtypes: {
            text: ['datetime-local', 'email'],
            textarea: ['ckeditor']
        },
        typeUserEvents: {
            text: {
                onadd: function (fld) {
                    var $patternField = $(".fld-is_client_email", fld);
                    var $patternField1 = $(".fld-is_enable_chart", fld);

                    var $patternWrap = $patternField.parents(".is_client_email-wrap:eq(0)");
                    var $patternWrap1 = $patternField1.parents(".is_enable_chart-wrap:eq(0)");

                    $patternField1.prop("checked", false);


                    var select = fld.querySelector(".fld-subtype");
                    if (select.value != "email") {
                        $patternWrap.hide();
                        $patternField.prop("checked", false);
                        $patternField.prop("disabled", true);
                    }
                    var val = $patternField.prop("checked") ? 1 : 0;
                    if (val == 1) {
                        $patternWrap.show();
                        $patternField.prop("checked", true);
                        $patternField.prop("disabled", false);
                    }
                    fld.querySelector(".fld-subtype").onchange = function (e) {
                        var toggle = e.target.value === "email";

                        if (e.target.value == 'email') {
                            $patternWrap.show(!toggle);
                            $patternField.prop("disabled", !toggle);
                            $patternField.prop("checked", !toggle);
                        } else {
                            $patternWrap.hide(!toggle);
                            $patternField.prop("disabled", !toggle);
                            $patternField.prop("checked", !toggle);
                        }
                    };
                }
            },
            select: {
                onadd: function (fld) {
                    if ($(fld).find('.fld-is_enable_chart').prop('checked') == false) {
                        $(fld).find('.chart_type-wrap').hide();
                    }
                    $(document).on('change', ".fld-is_enable_chart", function () {
                        if (this.checked) {
                            $(this).parent().parent().parent().find('.chart_type-wrap').show();
                        } else {
                            $(this).parent().parent().parent().find('.chart_type-wrap').hide();
                        }
                    });
                }
            },
            date: {
                onadd: function (fld) {
                    if ($(fld).find('.fld-is_enable_chart').prop('checked') == false) {
                        $(fld).find('.chart_type-wrap').hide();
                    }
                    $(document).on('change', ".fld-is_enable_chart", function () {
                        if (this.checked) {
                            $(this).parent().parent().parent().find('.chart_type-wrap').show();
                        } else {
                            $(this).parent().parent().parent().find('.chart_type-wrap').hide();
                        }
                    });
                }
            },
            'checkbox-group': {
                onadd: function (fld) {
                    if ($(fld).find('.fld-is_enable_chart').prop('checked') == false) {
                        $(fld).find('.chart_type-wrap').hide();
                    }
                    if ($(fld).find('.fld-other').prop('checked')) {
                        $(fld).parent('.form-elements').find('.field-options').find('.sortable-options-wrap ol').prepend(' <li class="ui-sortable-handle"><input value="false" type="checkbox" data-attr="selected" class="option-selected option-attr"><input value="Other" type="text" placeholder="" data-attr="label" class="option-label option-attr"><input value="other" type="text" placeholder="" data-attr="value" class="option-value option-attr"><a class="remove btn formbuilder-icon-cancel" title="Remove Element"></a></li>');
                    }
                    $(document).on('change', ".fld-is_enable_chart", function () {
                        if (this.checked) {
                            $(this).parent().parent().parent().find('.chart_type-wrap').show();
                        } else {
                            $(this).parent().parent().parent().find('.chart_type-wrap').hide();
                        }
                    });
                }
            },
            'radio-group': {
                onadd: function (fld) {
                    if ($(fld).find('.fld-is_enable_chart').prop('checked') == false) {
                        $(fld).find('.chart_type-wrap').hide();
                    }
                    if ($(fld).find('.fld-other').prop('checked')) {
                        $(fld).parent('.form-elements').find('.field-options').find('.sortable-options-wrap ol').prepend('<li class="ui-sortable-handle"><input value="false" type="radio" data-attr="selected" class="option-selected option-attr"><input value="Other" type="text" placeholder="" data-attr="label" class="option-label option-attr"><input value="other" type="text" placeholder="" data-attr="value" class="option-value option-attr"><a class="remove btn formbuilder-icon-cancel" title="Remove Element"></a></li>');
                    }
                    $(document).on('change', ".fld-is_enable_chart", function () {
                        if (this.checked) {
                            $(this).parent().parent().parent().find('.chart_type-wrap').show();
                        } else {
                            $(this).parent().parent().parent().find('.chart_type-wrap').hide();
                        }
                    });
                }
            },
            starRating: {
                onadd: function (fld) {
                    if ($(fld).find('.fld-is_enable_chart').prop('checked') == false) {
                        $(fld).find('.chart_type-wrap').hide();
                    }
                    $(document).on('change', ".fld-is_enable_chart", function () {
                        if (this.checked) {
                            $(this).parent().parent().parent().find('.chart_type-wrap').show();
                        } else {
                            $(this).parent().parent().parent().find('.chart_type-wrap').hide();
                        }
                    });
                }
            },
            "break": {
                onadd: function (fld) {}
            }
        },
        onSave: function (e, formData) {
            toggleEdit();
            $('.render-wrap').formRender({
                formData: formData,
                templates: templates
            });
            window.sessionStorage.setItem('formData', JSON.stringify(formData));
        },
        onOpenFieldEdit: function (editPanel) {
            var fld = $(editPanel).find('.fld-other');
            if ($(editPanel).find('.sortable-options.ui-sortable li').find('input[data-attr="selected"]').attr('type') == "radio") {
                if ($(fld).is(":checked") && !fld.prevObject.find('.sortable-options.ui-sortable li input[value="Other"]').length > 0) {
                    $(editPanel).find('.sortable-options.ui-sortable').append('<li class="ui-sortable-handle other"><input value="false" type="radio" data-attr="selected" class="option-selected option-attr"><input value="Other" type="text" placeholder="" data-attr="label" class="option-label option-attr"><input value="other" type="text" placeholder="" data-attr="value" class="option-value option-attr"><a class="remove btn formbuilder-icon-cancel" title="Remove Element"></a></li>');
                }
                var uid = $(editPanel).data('field-id');
                $(editPanel).find('.sortable-options.ui-sortable li [type="radio"]').attr('name', uid);
            } else {
                if ($(fld).is(":checked") && !fld.prevObject.find('.sortable-options.ui-sortable li input[value="Other"]').length > 0) {
                    $(editPanel).find('.sortable-options.ui-sortable').append('<li class="ui-sortable-handle other"><input value="false" type="checkbox" data-attr="selected" class="option-selected option-attr"><input value="Other" type="text" placeholder="" data-attr="label" class="option-label option-attr"><input value="other" type="text" placeholder="" data-attr="value" class="option-value option-attr"><a class="remove btn formbuilder-icon-cancel" title="Remove Element"></a></li>');
                }
                var uid = $(editPanel).data('field-id');
                $(editPanel).find('.sortable-options.ui-sortable li [type="checkbox"]').attr('name', uid);
            }
        },
        onCloseFieldEdit: function (editPanel) {
            var as = $('#' + $(editPanel).data('field-id')).find('.prev-holder');
            if ($(editPanel).find('.sortable-options.ui-sortable li').find('input[data-attr="selected"]').attr('type') == "radio") {
                setTimeout(() => {
                    $(as).find('.radio-group .formbuilder-radio input[type="radio"].other-option').parents('.formbuilder-radio').remove();
                }, 500);
            } else {
                setTimeout(() => {
                    $(as).find('.checkbox-group .formbuilder-checkbox input[type="checkbox"].other-option').parents('.formbuilder-checkbox').remove();
                }, 500);
            }
        },
        onAddFieldAfter: function (fieldId, fieldData) {
            if ($('#' + fieldId).find('.radio-group .formbuilder-radio input[type="radio"].other-option').parents('.formbuilder-radio')) {
                $('#' + fieldId).find('.radio-group .formbuilder-radio input[type="radio"].other-option').parents('.formbuilder-radio').remove();
            }
            if ($('#' + fieldId).find('.checkbox-group .formbuilder-checkbox input[type="checkbox"].other-option').parents('.formbuilder-checkbox')) {
                $('#' + fieldId).find('.checkbox-group .formbuilder-checkbox input[type="checkbox"].other-option').parents('.formbuilder-checkbox').remove();
            }
        },
        onAddOption: (optionTemplate, optionIndex) => {
            return optionTemplate
        },
        stickyControls: {
            enable: true
        },
        sortableControls: true,
        fields: fields,
        templates: templates,
        inputSets: inputSets,
        typeUserDisabledAttrs: typeUserDisabledAttrs,
        typeUserAttrs: typeUserAttrs,
        disableInjectedStyle: false,
        actionButtons: actionButtons,
        disableFields: [],
        disabledSubtypes: disabledSubtypes,
        disabledFieldButtons: {
            text: ['copy']
        }
    };

    var formData = window.sessionStorage.getItem('formData');
    var editing = true;
    if (formData) {
        fbOptions.formData = JSON.parse(formData);
    }

    function toggleEdit() {
        document.body.classList.toggle('form-rendered', editing);
        return editing = !editing;
    }
    var setFormData = $("input[name='json']").val();
    if (setFormData.length) {
        setFormData = JSON.parse(setFormData);
    }


    var fbPages = $(document.getElementById("design-form"));
    var addPageTab = document.getElementById("add-page-tab");
    var fbInstances = [];
    fbPages.tabs({
        beforeActivate: function (event, ui) {
            if (ui.newPanel.selector === "#new-page") {
                return false;
            }
        }
    });
    if (addPageTab) {
        addPageTab.addEventListener(
            "click",
            (click) => {
                addPage([]);
            },
            false
        );
    }

    function addPage(data) {
        const tabCount = document.getElementById("tabs").children.length;
        const tabId = "page" + tabCount.toString();
        const newPageTemplate = document.getElementById("new-page");
        const newTabTemplate = document.getElementById("add-page-tab");
        const newPage = newPageTemplate.cloneNode(true);
        sweetAlert.fire().then((result) => {
            if (result.isConfirmed) {
                newPage.setAttribute("id", tabId);
                newPage.classList.add("build-wrap");
                const $newTab = newTabTemplate.cloneNode(true);
                $newTab.removeAttribute("id");
                const tabLink = $newTab.querySelector("a");
                tabLink.setAttribute("href", "#" + tabId);
                tabLink.innerText = lang_Page + tabCount;
                newPageTemplate.parentElement.insertBefore(newPage, newPageTemplate);
                newTabTemplate.parentElement.insertBefore($newTab, newTabTemplate);
                fbPages.tabs("refresh");
                fbPages.tabs("option", "active", tabCount - 1);
                if (data.length) {
                    fbOptions.formData = data;
                } else {
                    fbOptions.formData = [];
                }
                var formbuilder = $(newPage).formBuilder(fbOptions);
                // setTimeout(function () {
                //     formbuilder.actions.setLang(lang);
                // }, 800);
                fbInstances.push(formbuilder);
            } else {
                return false;
            }
        });
    }
    // fbInstances.push($(".build-wrap").formBuilder(fbOptions));
    // setTimeout(function () {
    //     fbInstances[0].actions.setLang(lang);
    // }, 800);
    // $(document).ready(function () {
    //     setTimeout(function () {
    //         $.each(setFormData, function (i, item) {
    //             if (fbInstances[i]) {
    //                 fbInstances[i].actions.setData(item);
    //                 // fbInstances[i].actions.setLang(lang);
    //             } else {
    //                 addPage(item);
    //             }
    //         });
    //     }, 2000);
    // });


    var json = setFormData;
    if (json.length == 0) {
        fbInstances.push($("#page-1").formBuilder(fbOptions));
    } else {
        $(json).each(function (index, data) {
            setTimeout(function () {
                fbOptions.formData = data;
                fbInstances.push($("#page-" + (index + 1)).formBuilder(fbOptions));
            }, index * 1000)
        })
    }

    $(document.getElementById("getJSON")).click(function () {
        const allData = fbInstances.map((fb) => {
            var json = fb.actions.getData('json', true);
            return json;
        });
        $("input[name='json']").val("[" + allData + "]");
        $("#design-form").submit();
    });

    $(document).delegate(".fld-other", "change", function () {
        if ($(this).is(":checked") && !$(this).parents('.frm-holder').find('.sortable-options.ui-sortable li input[value="Other"]').length > 0) {
            if ($(this).parents('.frm-holder').find('.sortable-options.ui-sortable li').find('input[data-attr="selected"]').attr('type') == "radio") {
                $(this).parents('.frm-holder').find('.sortable-options.ui-sortable').append('<li class="ui-sortable-handle other"><input value="false" type="radio" data-attr="selected" class="option-selected option-attr"><input value="Other" type="text" placeholder="" data-attr="label" class="option-label option-attr"><input value="other" type="text" placeholder="" data-attr="value" class="option-value option-attr"><a class="remove btn formbuilder-icon-cancel" title="Remove Element"></a></li>');
            } else {
                $(this).parents('.frm-holder').find('.sortable-options.ui-sortable').append('<li class="ui-sortable-handle other"><input value="false" type="checkbox" data-attr="selected" class="option-selected option-attr"><input value="Other" type="text" placeholder="" data-attr="label" class="option-label option-attr"><input value="other" type="text" placeholder="" data-attr="value" class="option-value option-attr"><a class="remove btn formbuilder-icon-cancel" title="Remove Element"></a></li>');
            }
        } else if ($(this).parents('.frm-holder').find('.sortable-options.ui-sortable li input[value="Other"]').length > 0) {
            $(this).parents('.frm-holder').find('.sortable-options.ui-sortable li input[value="Other"]').parents('.ui-sortable-handle').remove();
        }
    });
});
