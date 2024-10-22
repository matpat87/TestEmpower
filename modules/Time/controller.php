<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class TimeController extends SugarController
{
    public function action_get_time_data()
    {
        global $log;

        $result = array('success' => false, 'data' => array());
        if ($_GET['time_id'] != '') {
            $timeBean = BeanFactory::getBean("Time", $_GET['time_id']);

            $result['success'] = true;
            $result['data'] = array(
                'time' => $timeBean->time,
                'parent_type' => $timeBean->parent_type
            );
           
        }
        

       

        echo json_encode($result);
    }

    
}