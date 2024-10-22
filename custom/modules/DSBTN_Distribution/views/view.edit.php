<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');
require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');
require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');

class DSBTN_DistributionViewEdit extends ViewEdit {

    public $is_tr_edit = true;

    function __construct(){
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function DSBTN_DistributionViewEdit() {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    function display() {
        global $app_list_strings;

        $distribution_id = $this->bean->id;
        if(!DistributionHelper::is_id_exists($distribution_id )){
            $this->bean->distribution_number_c  = TBD;
        }
        else{
            $this->bean->distribution_number_c = DistributionHelper::assign_distribution_number($this->bean->id);
        }
        
        $this->AssignAccount();
        $this->AssignTechnicalRequest($this->bean);
        $this->AddCSS();
        $duplicate_arr = $this->Duplicate();
        
        //Colormatch 185
        if($duplicate_arr['is_duplicate'])
        {
            $distribution_id = $duplicate_arr['source_distribution_id'];
        }
        parent::display();

        $this->AddJS();
        $this->AddDistributionItems($this->bean->id);
        $this->handleDistributionItemsAddDelete($this->bean);

        // Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
        echo "<script type='text/javascript' src='custom/modules/DSBTN_Distribution/js/edit.js?v={$guid}'></script>";
    }

    //Colormatch 185
    private function Duplicate()
    {
        $result = array('is_duplicate' => false, 'source_distribution_id' => '');

        if(isset($_POST['is_copy_full']) && $_POST['is_copy_full'] == 'true'){
            $fields_not_to_copy = array('id', 'created_by_name', 'date_entered',
                'contact_id_c', 'contact_c', 'primary_address_country', 
                'primary_address_street', 'primary_address_city', 'primary_address_state',
                'primary_address_postalcode', 'ship_to_address_c');

            $distribution_bean = BeanFactory::getBean('DSBTN_Distribution', $_POST['distribution_id']);
            
            foreach (get_object_vars($distribution_bean) as $key => $value) {
                if(!in_array($key, $fields_not_to_copy))
                {
                    $this->bean->$key = $value;
                }
            }

            $this->bean->id = '';
            //$this->bean->distribution_number_c = DistributionHelper::assign_distribution_number($this->bean->id);
            $this->bean->distribution_number_c  = TBD;

            $result['is_duplicate'] = true;
            $result['source_distribution_id'] = $_POST['distribution_id'];
        }

        return $result;
    }

    private function AssignAccount()
    {
        $get = $_GET;

        if(isset($get['parent_module']) && $get['parent_module'] == 'TR_TechnicalRequests')
        {
            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $get['parent_id']);

            if($technical_request_bean != null){
                $this->bean->account_c = $technical_request_bean->tr_technicalrequests_accounts_name;
                $this->bean->account_id_c = $technical_request_bean->tr_technicalrequests_accountsaccounts_ida;
            }
        }
    }

    private function AssignTechnicalRequest($bean)
    {
        
        if(isset($_REQUEST['parent_module']) && $_REQUEST['parent_module'] == 'TR_TechnicalRequests')
        {
            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $_REQUEST['parent_id']);
            $distroBean = BeanFactory::getBean('DSBTN_Distribution');
            $distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$technical_request_bean->id}'", false, 0);
        
            $bean->custom_technical_request_id_non_db = $technical_request_bean->id;
            $bean->tr_technicalrequests_id_c = $technical_request_bean->id;
            $bean->technical_request_c = $technical_request_bean->name;

            // If TR has no associated Distro, populate Contact field
            if (! $distroBeanList) {
                $bean->contact_c = $technical_request_bean->contact_c;
                $bean->contact_id_c = $technical_request_bean->contact_id1_c;
            }
        }
    }

    private function AddDistributionItems($bean_id)
    {
       $tr_html = DistributionHelper::GetDistributionItemsEditView('DSBTN_Distribution', $bean_id);

       echo "<script type=\"text/javascript\">
               $(document).ready(function(e){
                    $('#tbl_line_items tbody').append('$tr_html');
               });
           </script>";
    }

    function AddJS()
    {
        $fields_js = "div[field='custom_recipient_information_label_non_db'], div[field='custom_overview_label_non_db'], div[field='custom_distribution_items_label_non_db'], div[field='custom_distribution_items_label_non_db']";
        $is_tr_exists_html = (!$this->is_tr_edit) ? 'removeFromValidate("EditView","technical_request_c")' : '';
        //echo $is_tr_exists_html;

        echo 
		"<script>
			$(document).ready(function(){
                var panel_bg_color = 'var(--custom-panel-bg)';
		
                $(\"$fields_js\")
                    .prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('padding', '0px 0px 8px 10px').parent().css('padding-left', '0px').css('padding-right', '0px');

                $(\"$fields_js\")
                    .prev().css('margin-top', '0px');

                $(\"$fields_js\")
                    .addClass('hidden');

                $(\"div[field='custom_line_items_non_db']\").parent().find('div:first').hide();
                $(\"div[field='custom_line_items_non_db']\").removeClass('col-sm-8').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12');

                $(\"div[field='custom_distribution_items_label_non_db']\")
                    .prev()
                    .css('border-radius', '0.25em 0px 0px 0.25em');

                $(\"div[field='sync_to_contact_distribution_items']\")
                    .prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('text-align', 'right').css('padding', '7px 10px 2px 10px').css('height', '28px')
                    .css('border-radius', '0px 0.25em 0.25em 0px')
                    .parent()
                    .css('padding-left', '0px');
                
                $(\"div[field='sync_to_contact_distribution_items']\")
                    .prev().css('margin-top', '0px');      

                $(\"div[field='sync_to_contact_distribution_items']\")
                    .prev().html('Sync to Contact:&nbsp;&nbsp;<input type=\"checkbox\" id=\"sync_to_contact_distribution_items\" name=\"sync_to_contact_distribution_items\" value=\"1\" abindex=\"0\" style=\"margin-bottom: 3px\">');                    

                $(\"div[field='sync_to_contact_distribution_items']\")
                    .addClass('hidden')
                    .find(\"input[type='hidden']\").remove();
                {$is_tr_exists_html}
			});
        </script>";
        
        if(DistributionHelper::is_id_exists($this->bean->id)) {
            echo "<script>
                $('#technical_request_c')
                    .addClass('custom-readonly')
                    .parent()
                    .find('.id-ff.multiple')
                    .css('visibility', 'hidden');
            </script>";
        }
    }

    private function AddCSS()
    {
        echo '<style type="text/css">
            
                ::placeholder {
                    color: #817c8d;
                    opacity: 0.8; /* Firefox */
                }
                
                :-ms-input-placeholder { /* Internet Explorer 10-11 */
                    color: #817c8d;
                }
                
                ::-ms-input-placeholder { /* Microsoft Edge */
                    color: #817c8d;
                }
            </style>';

        // if(DistributionHelper::is_id_exists($this->bean->id))
        // {
            // echo '<style type="text/css">
            //     div[data-label="LBL_TECHNICAL_REQUEST"]{
            //         visibility: hidden !important;
            //     }

            //     div[field="technical_request_c"]{
            //         visibility: hidden !important;
            //     }
            // </style>';
            // $this->is_tr_edit = false;
        // }
    }

    private function handleDistributionItemsAddDelete($bean)
    {
        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $bean->tr_technicalrequests_id_c);

        if ($trBean->id) {
            $convertedTrStatus = TechnicalRequestHelper::get_status($trBean->approval_stage)[$trBean->status];
            
            if (! in_array($trBean->approval_stage, ['understanding_requirements', 'development', 'quoting_or_proposing', 'sampling'])) {
                // Change cursor to not-allowed and maintain button height to 32px as it changes to 20px if disabled
                echo "<style>
                    #tbl_line_items input[type='button'][disabled] {
                        height: 32px !important;
                        cursor: not-allowed;
                    }

                    #tbl_line_items input[type='text'][disabled] {
                        cursor: not-allowed;
                    }
                </style>";

                // Disable Distro Item fields
                echo "<script>
                    jQuery( () => {
                        $(`div[field='custom_line_items_non_db']`)
                            .closest('.edit-view-row-item')
                            .find('input')
                            .attr('disabled', true)
                            .closest('.edit-view-row-item')
                            .find('select')
                            .attr('disabled', true);
                    });
                </script>";
            }
        }
    }
}
?>
