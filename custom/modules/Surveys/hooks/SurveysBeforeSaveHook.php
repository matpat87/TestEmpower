<?php

require_once('custom/modules/Surveys/helpers/SurveysHelper.php');

class SurveysBeforeSaveHook
{
    public function handleSurveyIdNumberAssignment(&$bean, $events, $arguments)
    {
        $bean->survey_id_number_c = SurveysHelper::handleSurveyIdNumberAssignment($bean->id);
    }
}