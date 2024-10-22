<?php
    class SurveysHelper
    {
        public static function handleSurveyIdNumberAssignment($recordId)
        {
            $surveyBean = BeanFactory::getBean('Surveys');
            $surveyBeanList = $surveyBean->get_full_list('id', "surveys.id = '{$recordId}'", false, 0);
            $surveyIdNumber = 0;

            if (isset($surveyBeanList) && count($surveyBeanList) > 0) {
                $latestSurveyBean = $surveyBeanList[0];

                if (! $latestSurveyBean->survey_id_number_c) {
                    $surveyIdNumber = self::retrieveSurveyIdNumber();
                } else {
                    $surveyIdNumber = $latestSurveyBean->survey_id_number_c;
                }
            } else {
                $surveyIdNumber = self::retrieveSurveyIdNumber();
            }
            
            return $surveyIdNumber;
        }

        private function retrieveSurveyIdNumber()
        {
            $db = DBManagerFactory::getInstance();
            $query = "SELECT surveys_cstm.survey_id_number_c 
                        FROM surveys_cstm 
                        ORDER BY surveys_cstm.survey_id_number_c DESC 
                        LIMIT 1";

            $surveyIdNumber = $db->getOne($query);

            if (! $surveyIdNumber) {
                $surveyIdNumber = 0;
            }

            $surveyIdNumber++;

            return $surveyIdNumber;
        }
    }
?>