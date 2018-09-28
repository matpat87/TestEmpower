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
        $time_and_date = new TimeAndDateCustom();
        $current_datetime_timestamp = $time_and_date->get_timestamp($time_and_date->new_york_format);

        if($bean->next_step_temp_c != ""){
            $conjunction = "<br/>";
            $next_step = '<div>' . $bean->next_step_temp_c . '</div>' . ' <div style="font-size: 10px;">(' . $current_user->user_name . '-' . $current_datetime_timestamp . ')</div>';

            if($bean->next_step != "")
            {
                $next_step .= "$conjunction " . $bean->next_step;
            }

            $bean->next_step = $next_step;
        }
    }
}

?>