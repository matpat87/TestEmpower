var ModuleManagementCore = function(){
    let moduleManagementCore = this;

    moduleManagementCore.setPrevValByCurrentVal = function(){
        var rowObj;
        var selectObj;
        var selectObjText;
        var selectObjVal
        var tdObj;

        $('#tblModuleManagement tbody tr').each(function(index, item){
            rowObj = $(item);

            rowObj.find('td').each(function(tdIndex, td){
                tdObj = $(td);

                selectObj = tdObj.find('.act_guid');

                if(selectObj.attr('id') != undefined){
                    selectObjVal = selectObj.val();
                    
                    // console.log('id: ' + selectObj.attr('id'));
                    // console.log('selectObjVal: ' + selectObjVal);

                    selectObj.attr('data-prevval', selectObjVal);
                }
            });
        });
    }

    moduleManagementCore.formPostData = function(){
        var result = [];
        var act_guid_list = $('.act_guid');

        /*act_guid_list.each(function(index, item){
            var itemObj = $(item);

            result[index] = {
                name: itemObj.attr('name'),
                val: itemObj.val()
            };
        });*/

        var act_guid_index = 0;
        var roleIdVal = '';
        $('#tblModuleManagement tbody tr').each(function(rowItemIndex, item){
            var rowItemObj = $(item);
            roleIdVal = rowItemObj.find('.role_id').val();
            //console.log(roleIdVal);

            rowItemObj.find('.act_guid').each(function(index, item){
                var itemObj = $(item);
    
                result[act_guid_index] = {
                    name: itemObj.attr('name'),
                    val: itemObj.val(),
                    roleId: roleIdVal,
                    actionId: itemObj.data('actionid'),
                    actionName: itemObj.data('actionname'),
                    moduleName: itemObj.data('modulename'),
                };

                act_guid_index++;
            });
        });


        return JSON.stringify(result);
    };

    moduleManagementCore.save = function(){

        var postData = {'act_guid_list': moduleManagementCore.formPostData()};

        $.ajax({
            url: 'index.php?module=MDM_ModuleManagement&action=save_details&to_pdf=1',
            type: 'JSON',
            method: 'POST',
            async: true,
            //cache: false,
            data: postData,
            beforeSend: function(){
                SUGAR.ajaxUI.showLoadingPanel();
            },
            success: function(data) {
                //SUGAR.ajaxUI.showLoadingPanel();
                moduleManagementCore.setPrevValByCurrentVal();
            },
            complete: function(){
                SUGAR.ajaxUI.hideLoadingPanel();
            },
            error: function(err) {
                console.log(err);
            }
        });

        
    };

    moduleManagementCore.tdCloseAllExept = function(idToExempt){
        console.log('closeAllExcept');

        $('.act_guid').each(function(index, item){
            var selectObj = $(item);
            //var selectedOption = selectObj.find('option:selected');
            var parent = selectObj.closest('.tdAction');

            //console.log('id: ' + selectObj.attr('id'));
            if(selectObj.attr('id') != idToExempt){
                selectObj.addClass('select-hidden');
                parent.find('.action-name').removeClass('label-hidden');
            }
            
        });
    }

    moduleManagementCore.thCloseAllExept = function(idToExempt){
        console.log('closeAllExcept');

        $('.header-action').each(function(index, item){
            var selectObj = $(item);
            //var selectedOption = selectObj.find('option:selected');
            var parent = selectObj.closest('.thAction');

            //console.log('id: ' + selectObj.attr('id'));
            if(selectObj.attr('id') != idToExempt){
                selectObj.addClass('select-hidden');
                parent.find('.header-action-name').removeClass('label-hidden');
            }
            
        });
    }

    moduleManagementCore.clearHeaderDropdowns = function(){
        $('.header-action').each(function(index, item){
            var headerActionObj = $(item);
            headerActionObj.blur();
        });
    }

    moduleManagementCore.clearDetailDropdowns = function(){
        $('.act_guid').each(function(index, item){
            var actGuidObj = $(item);
            actGuidObj.blur();
        });
    }

    $('#SAVE_HEADER, #SAVE_FOOTER').on('click', function(ev){
        moduleManagementCore.save();
    });

    //for tbody details
    $('.tdAction').on('click', function(ev){
        var tdObj = $(this);

        var selectObj = tdObj.find('.act_guid');
        selectObj.removeClass('select-hidden');

        tdObj.find('.action-name').addClass('label-hidden');
        moduleManagementCore.tdCloseAllExept(selectObj.attr('id'));
        moduleManagementCore.clearHeaderDropdowns();
    });

    $('.act_guid').on('change', function(ev){
        console.log('act_guid changed...');

        var selectObj = $(this);
        var selectedOption = selectObj.find('option:selected');
        var parent = selectObj.closest('.tdAction');

        parent.find('.action-name').html(selectedOption.text());
    });

    $('.act_guid').on('blur', function(ev){
        console.log('act_guid blur...');

        var selectObj = $(this);
        var parent = selectObj.closest('.tdAction');

        parent.find('.action-name').removeClass('label-hidden');
        selectObj.addClass('select-hidden');
    });

    //for header details
    $('.thAction').on('click', function(ev){
        var thObj = $(this);

        var selectObj = thObj.find('.header-action');
        selectObj.removeClass('select-hidden');

        thObj.find('.header-action-name').addClass('label-hidden');
        moduleManagementCore.thCloseAllExept(selectObj.attr('id'));
        moduleManagementCore.clearDetailDropdowns();
    });

    $('.header-action').on('change', function(ev){
        console.log('header-action changed...');

        var selectObj = $(this);
        var selectedOption = selectObj.find('option:selected');
        var parent = selectObj.closest('.thAction');
        var parentIndex = parent.index();
        var selectObjVal = selectObj.val();
        var selectObjText = selectObj.find('option:selected').text();

        $('#tblModuleManagement tbody tr').each(function(index, item){
            var rowObj = $(item);
            var tdObj = rowObj.find('td').eq(parentIndex);

            
            tdObj.find('.act_guid').val(selectObjVal);
            tdObj.find('.action-name').html(selectObjText);
        });

        parent.find('.header-action-name').html(selectedOption.text());
    });

    $('.header-action').on('blur', function(ev){
        console.log('header-action blur...');

        var selectObj = $(this);
        var parent = selectObj.closest('.thAction');

        parent.find('.header-action-name').removeClass('label-hidden');
        selectObj.addClass('select-hidden');
        parent.find('.header-action-name').text(parent.find('.header-action-name').data('header-label'));
    });

    //set the header
    $('.header-action').each(function(index, item){
        var headerObj = $(item);
        headerObj.val(0);
    });

    $('input[name="cancel"').on('click', function(ev){
        var rowObj;
        var selectObj;
        var selectObjText;
        var selectObjVal
        var tdObj;

        $('#tblModuleManagement tbody tr').each(function(index, item){
            rowObj = $(item);

            rowObj.find('td').each(function(tdIndex, td){
                tdObj = $(td);

                selectObj = tdObj.find('.act_guid');
                selectObjVal = selectObj.val();
                selectObjText = selectObj.find('option[value="'+ selectObj.data('prevval') +'"]').text();

                tdObj.find('.act_guid').val(selectObjVal);
                tdObj.find('.action-name').html(selectObjText);
            });
        });
    });
};