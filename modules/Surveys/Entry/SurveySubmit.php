<?php
if (empty($_REQUEST['id'])) {
    do404();
}
$surveyId = $_REQUEST['id'];
$survey = BeanFactory::getBean('Surveys', $surveyId);
if (empty($survey->id)) {
    do404();
}

// APX Custom Codes: Added Survey Preview Mode -- START
if (! isset($_REQUEST['preview_mode'])) {
    if (! in_array($survey->status, ['Public'])) {
        do404();
    }
}
// APX Custom Codes: Added Survey Preview Mode -- END

$contactId = !empty($_REQUEST['contact']) ? $_REQUEST['contact'] : '';

$trackerId = !empty($_REQUEST['tracker']) ? $_REQUEST['tracker'] : '';

require_once 'modules/Campaigns/utils.php';
if ($trackerId) {
    log_campaign_activity($trackerId, 'Survey');
}

// APX Custom Codes: Added Survey Preview Mode -- START
if (! isset($_REQUEST['preview_mode'])) {
    if ($survey->status == 'Public') {
        processSurvey($survey, $trackerId, $contactId, $_REQUEST);
    } else {
        do404();
    }
} else {
    header("Location: index.php?entryPoint=surveyThanks&name={$survey->name}&preview_mode={$_REQUEST['preview_mode']}");
}
// APX Custom Codes: Added Survey Preview Mode -- END

function getCampaignIdFromTracker($trackerId)
{
    $db = DBManagerFactory::getInstance();
    $trackerId = $db->quote($trackerId);
    $sql = <<<EOF
            SELECT campaign_id 
            FROM campaign_log WHERE target_tracker_key = "$trackerId"
EOF;

    $row = $db->fetchOne($sql);
    if ($row) {
        return $row['campaign_id'];
    }

    return false;
}

function processSurvey(Surveys $survey, $trackerId, $contactId, $request)
{
    $contactName = 'Unknown Contact';
    $accountId = '';
    $campaignId = '';
    if ($trackerId) {
        $campaignId = getCampaignIdFromTracker($trackerId);
    }

    if ($contactId) {
        $contact = BeanFactory::getBean('Contacts', $contactId);
        if (!empty($contact->id)) {
            $contactName = $contact->name;
            $accountId = $contact->account_id;
        }
    }
    $response = BeanFactory::newBean('SurveyResponses');
    $response->id = create_guid();
    $response->new_with_id = true;
    $response->name = $survey->name . ' - ' . $contactName;
    $response->contact_id = $contactId;
    $response->account_id = $accountId;
    $response->survey_id = $survey->id;
    $response->campaign_id = $campaignId;
    $response->happiness = -1;
    $response->happiness_text = '';
    $response->assigned_user_id = $survey->assigned_user_id;

    foreach ($survey->get_linked_beans('surveys_surveyquestions', 'SurveyQuestions', 'sort_order') as $question) {
        $userResponse = $request['question'][$question->id];
        switch ($question->type) {
            case "Checkbox":
                $qr = BeanFactory::newBean('SurveyQuestionResponses');
                $qr->surveyresponse_id = $response->id;
                $qr->surveyquestion_id = $question->id;
                $qr->answer_bool = $userResponse;
                $qr->save();
                break;
            case "Radio":
            case "Dropdown":
                $qr = BeanFactory::newBean('SurveyQuestionResponses');
                $qr->surveyresponse_id = $response->id;
                $qr->surveyquestion_id = $question->id;
                $qr->save();
                $qr->load_relationship('surveyquestionoptions_surveyquestionresponses');
                $qr->surveyquestionoptions_surveyquestionresponses->add($userResponse);
                break;
            case "Multiselect":
                foreach ($userResponse as $selected) {
                    $qr = BeanFactory::newBean('SurveyQuestionResponses');
                    $qr->surveyresponse_id = $response->id;
                    $qr->surveyquestion_id = $question->id;
                    $qr->save();
                    $qr->load_relationship('surveyquestionoptions_surveyquestionresponses');
                    $qr->surveyquestionoptions_surveyquestionresponses->add($selected);
                }
                break;
            case "Matrix":
                foreach ($userResponse as $key => $val) {
                    $qo = BeanFactory::getBean('SurveyQuestionOptions', $key);
                    $qr = BeanFactory::newBean('SurveyQuestionResponses');
                    $qr->surveyresponse_id = $response->id;
                    $qr->surveyquestion_id = $question->id;
                    $qr->answer = $val;
                    if ($val == 2) {//Dissatisfied
                        $response->happiness = 0;
                        $response->happiness_text .= $qo->name . " - Dissatisfied<br>";
                    }
                    $qr->save();
                    $qr->load_relationship('surveyquestionoptions_surveyquestionresponses');
                    $qr->surveyquestionoptions_surveyquestionresponses->add($key);
                }
                break;
            case "DateTime":
                $qr = BeanFactory::newBean('SurveyQuestionResponses');
                $qr->surveyresponse_id = $response->id;
                $qr->surveyquestion_id = $question->id;
                $qr->answer_datetime = $userResponse . ':00';
                $qr->save();
                break;
            case "Date":
                //TODO: Convert from user format
                $qr = BeanFactory::newBean('SurveyQuestionResponses');
                $qr->surveyresponse_id = $response->id;
                $qr->surveyquestion_id = $question->id;
                $qr->answer_datetime = $userResponse . ' 00:00:00';
                $qr->save();
                break;
            case "Textbox":
                if ($userResponse) {
                    $response->happiness = 0;
                    $response->happiness_text .= $question->name . " - " . $userResponse . "<br>";
                }
                // no break
            case "Rating":
            case "Scale":
            case "Text":
            default:
                $qr = BeanFactory::newBean('SurveyQuestionResponses');
                $qr->surveyresponse_id = $response->id;
                $qr->surveyquestion_id = $question->id;
                $qr->answer = $userResponse;
                $qr->save();
                break;
        }
    }
   
    $response->save();

    // APX Custom Codes: OnTrack #1660 -- START
    if (isset($survey->enable_response_notification_c) && $survey->enable_response_notification_c == 1) {
        handleSurveyResponseNotification($survey);
    }
    // APX Custom Codes: OnTrack #1660 -- END

    header('Location: index.php?entryPoint=surveyThanks&name=' . $survey->name);
}

function do404()
{
    header("HTTP/1.0 404 Not Found"); ?>
    <html>
    <head></head>
    <body><h1>Page not found</h1></body>
    </html>
    <?php
    exit();
}
