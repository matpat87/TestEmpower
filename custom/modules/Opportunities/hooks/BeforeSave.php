<?php


class BeforeSave{

    /**
     * This will fix on task in Ontrack #5 - OPPORTUNITY - SCREEN CHANGES - Next Step
     * @author Steven O Kyamko
    **/
    function next_step_edited_before_save(&$bean, $event, $arguments)
    {
        global $current_user;
        $next_step = "";

        if($bean->next_step_temp_c != ""){
            $conjunction = " \r\n ";
            $next_step = $bean->next_step_temp_c . "$conjunction (" . $current_user->user_name . "-" . date("Y-m-d H:i:s") . ")";

            if($bean->next_step != "")
            {
                $next_step .= "$conjunction " . $bean->next_step;
            }

            $bean->next_step = $next_step;
        }
    }
}

?>