<?php
    /**
     * Created using PhpStorm.
     * User: shad
     * Date: 9/6/16
     * Time: 5:53 PM
     * File Name: DashletTemplateLogic.php
     * Project: jackal_dashboards
     */

    class DashletTemplateLogic
    {

        public function checkUserChange($bean, $event, $arguments)
        {

            if ($bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id) {

                $bean->updateEncodedData($bean->assigned_user_id);
            }

        }
    }