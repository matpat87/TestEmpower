<?php
    // Regulatory Documents
    $layout_defs["CI_CustomerItems"]["subpanel_setup"]["rd_regulatorydocuments_ci_customeritems_1"]["get_subpanel_data"] = 'function:rd_regulatorydocuments_ci_customeritems_1';
    $layout_defs["CI_CustomerItems"]["subpanel_setup"]["rd_regulatorydocuments_ci_customeritems_1"]["generate_select"] = true;
    $layout_defs["CI_CustomerItems"]["subpanel_setup"]["rd_regulatorydocuments_ci_customeritems_1"]["get_distinct_data"] = true;
    $layout_defs["CI_CustomerItems"]["subpanel_setup"]["rd_regulatorydocuments_ci_customeritems_1"]["function_parameters"] = array(
        'import_function_file' => 'custom/modules/CI_CustomerItems/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'rd_regulatorydocuments_ci_customeritems_1'
    );
?>