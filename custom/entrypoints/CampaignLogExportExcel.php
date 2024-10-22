<?php
    require_once('custom/include/PHP_XLSXWriter/xlsxwriter.class.php');
    require_once('custom/include/Carbon/src/Carbon/Carbon.php');
    use Carbon\Carbon;

    class CampaignLogExportExcel
    {
        private function handleRetrieveExportHeaders()
        {
            return [
                translate('LBL_LIST_RECIPIENT_NAME', 'CampaignLog') => 'string',
                translate('LBL_LIST_RECIPIENT_EMAIL', 'CampaignLog') => 'string',
                translate('LBL_MARKETING_ID', 'CampaignLog') => 'string',
                translate('LBL_ACTIVITY_TYPE', 'CampaignLog') => 'string',
                translate('LBL_ACTIVITY_DATE', 'CampaignLog') => 'string',
                translate('LBL_RELATED', 'CampaignLog') => 'string',
                translate('LBL_HITS', 'CampaignLog') => 'string',
            ];
        }

        private function handleRetrieveExportData()
        {
            global $app_list_strings, $db, $timedate, $log;
            $exportData = [];

            // Retrieve logged user datetime format
            $userDateTimeFormat = $timedate->getInstance()->get_date_time_format();

            if (! isset($_REQUEST['campaign_sub_type'])) {
                $parameters = [0 => $_REQUEST['campaign_type'], 'EMAIL_MARKETING_ID_VALUE' => $_REQUEST['campaign_marketing_id']];
            } else {
                $parameters = [0 => $_REQUEST['campaign_type'], 1 => $_REQUEST['campaign_sub_type'], 'EMAIL_MARKETING_ID_VALUE' => $_REQUEST['campaign_marketing_id']];
            }

            $campaign = new Campaign;
            $campaign->retrieve($_REQUEST['campaignId']);
            $campaignLogQuery = $campaign->track_log_entries($parameters);

            $result = $db->query($campaignLogQuery);

            while ($row = $db->fetchByAssoc($result)) {
                if (! empty($row['target_type']) && ! empty($row['target_id'])) {
                    $recipient = BeanFactory::getBean($row['target_type']);
                    $recipient->retrieve($row['target_id'], true, false);
                }

                if (! empty($row['marketing_id'])) {
                    $emailMarketing = BeanFactory::getBean('EmailMarketing', $row['marketing_id']);
                }


                if (! empty($row['related_type']) && ! empty($row['related_id'])) {
                    $relatedTo = BeanFactory::getBean($row['related_type'], $row['related_id']);
                }

                $exportData[] = [
                    ($recipient && $recipient->id) ? $recipient->name : '',
                    ($recipient && $recipient->id) ? $recipient->emailAddress->getPrimaryAddress($recipient) : '',
                    ($emailMarketing && $emailMarketing->id) ? $emailMarketing->name : '',
                    $app_list_strings['campainglog_activity_type_dom'][$row['activity_type']] ?? '',
                    Carbon::parse($row['activity_date'])->format($userDateTimeFormat) ?? '',
                    ($relatedTo && $relatedTo->id) ? $relatedTo->name : '',
                    $row['hits'] ?? 0
                ];
            }

            return $exportData;
        }
        
        public static function export()
        {
            global $current_user, $log;
            $campaignBean = BeanFactory::getBean('Campaigns', $_REQUEST['campaignId']);
            $campaignName = str_replace(' ', '_', $campaignBean->name);
            $subpanelTitle = str_replace(' ', '_', translate($_REQUEST['subpanelTitleKey'], 'Campaigns'));
            $subpanelTitle = str_replace(',', '', $subpanelTitle);
            $dateTime = new DateTime();
            $dateNow = $dateTime->format('d_m_Y');
            $fileType = 'xlsx';
            $fileName = "{$campaignName}_{$subpanelTitle}_{$dateNow}.{$fileType}";
            $fileAuthor = 'Chroma Colors';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename={$fileName}");
            header('Cache-Control: max-age=0');

            $exportHeaders = self::handleRetrieveExportHeaders();
            $exportData = self::handleRetrieveExportData();

            $writer = new XLSXWriter();
            $writer->setAuthor($fileAuthor);
            $writer->writeSheet($exportData, $fileName, $exportHeaders);
            $writer->writeToStdOut();
        }
    }

    $campaignLogExportExcel = new CampaignLogExportExcel();
    $campaignLogExportExcel->export();
?>