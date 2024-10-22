<?php
    require_once('custom/include/PHP_XLSXWriter/xlsxwriter.class.php');

    class TimeExportCSV
    {
        const FILE_TYPE = 'xlsx';
        const FILE_NAME = 'Timesheet Report';
        const LBL_AUTHOR = 'Chroma Colors';

        private function handleRetrieveExportHeaders()
        {
            return [
                translate('LBL_ONTRACK_NUMBER', 'Time') => 'string',
                translate('LBL_FLEX_RELATE', 'Time') => 'string',
                translate('LBL_MODULE', 'OTR_OnTrack') => 'string',
                translate('LBL_TYPE', 'OTR_OnTrack') => 'string',
                translate('LBL_SEVERITY', 'OTR_OnTrack') => 'string',
                translate('LBL_NAME', 'Time') => 'string',
                translate('LBL_DESCRIPTION', 'Time') => 'string',
                translate('LBL_ASSIGNED_TO_NAME', 'Time') => 'string',
                translate('LBL_DATE_ENTERED', 'Time') => 'string',
                translate('LBL_DATE_WORKED', 'Time') => 'string',
                translate('LBL_TIME', 'Time') => 'string',
            ];
        }

        private function handleRetrieveExportData()
        {
            global $app_list_strings;

            $exportData = [];

            $beanListData = self::handleRetrieveBeanListData();
            
            foreach ($beanListData as $bean) {
                $relatedBean = BeanFactory::getBean($bean->parent_type, $bean->parent_id);

                $exportData[] = [
                    $relatedBean->otr_ontrack_number,
                    $relatedBean->name,
                    $app_list_strings['module_dropdown_list'][$relatedBean->module_c],
                    $app_list_strings['bug_type_dom'][$relatedBean->type],
                    $app_list_strings['severity_list'][$relatedBean->severity_c],
                    $bean->name,
                    $bean->description,
                    $bean->assigned_user_name,
                    $bean->date_entered,
                    $bean->date_worked,
                    $bean->time,
                ];
            }

            return $exportData;
        }

        private function handleRetrieveBeanListData()
        {
            $whereQuery = self::handleRetrieveWhereQuery();
            $orderByQuery = $_SESSION['TimeQueryOrderBy'] ?? 'name';

            $bean = BeanFactory::getBean('Time');            
            $beanList = $bean->get_full_list($orderByQuery, $whereQuery);
            
            return (! empty($beanList) && count($beanList) > 0)
                ? $beanList
                : [];
        }

        private function handleRetrieveWhereQuery()
        {
            $whereQuery = '';

            // If Checkbox are manually ticked or Select This Page is chosen
            if(! empty($_REQUEST['uid'])) {
                $explodedUIDs = explode(',', $_REQUEST['uid']);
                $whereInFormattedIds = handleArrayToWhereInFormatAll(array_combine($explodedUIDs, $explodedUIDs));
                $whereQuery = "times.id IN ({$whereInFormattedIds})";
            }
            
            // If Select All is chosen
            if (! empty($_REQUEST['current_post'])) {
                $whereQuery = $_SESSION['TimeQueryWhere'];
            }

            return $whereQuery;
        }
        
        public static function export()
        {
            global $current_user, $log;

            $dateTime = new DateTime();
            $dateNow = $dateTime->format('d-m-Y');
            $fileName = self::FILE_NAME . "-{$dateNow}." . self::FILE_TYPE;

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename={$fileName}");
            header('Cache-Control: max-age=0');

            $exportHeaders = self::handleRetrieveExportHeaders();
            $exportData = self::handleRetrieveExportData();

            $writer = new XLSXWriter();
            $writer->setAuthor(self::LBL_AUTHOR);
            $writer->writeSheet($exportData, self::FILE_NAME, $exportHeaders);
            $writer->writeToStdOut();
        }
    }

    $TimeExportCSV = new TimeExportCSV();
    $TimeExportCSV->export();
?>