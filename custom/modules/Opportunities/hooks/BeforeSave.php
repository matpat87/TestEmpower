<?php


class BeforeSave{

    /**
     * This will fix on task in Ontrack #5 - OPPORTUNITY - SCREEN CHANGES - Amount field
     * @author Steven O Kyamko
    **/
    function amount_edited_before_save(&$bean, $event, $arguments){

        if(!empty($bean->amount_usd_c))
        {
            $amount_usd_c = preg_replace('/[^\d.]/', '', $bean->amount_usd_c);
            $amount_usd_c = floatVal(str_replace('$', '', $amount_usd_c ));

            $bean->amount = $amount_usd_c;
            $bean->amount_usdollar = $amount_usd_c;
            $bean->amount_usd_c = "$" . number_format($amount_usd_c, 2, '.', ',');
        }
    }

    /**
     * This will fix on task in Ontrack #5 - OPPORTUNITY - SCREEN CHANGES - Probability
     * @author Steven O Kyamko
    **/
    function probability_edited_before_save(&$bean, $event, $arguments)
    {
        $bean->probability = $bean->probability_list_c;
    }

    /**
     * This will fix on task in Ontrack #5 - OPPORTUNITY - SCREEN CHANGES - Next Step
     * @author Steven O Kyamko
    **/
    function next_step_edited_before_save(&$bean, $event, $arguments)
    {
        global $current_user;

        $comma = ($bean->next_step != "") ? "," : "";
        $bean->next_step = $bean->next_step_temp_c . " (" . $current_user->user_name . "-" . date("Y-m-d H:i:s") . ")$comma " . $bean->next_step;
    }
}

?>