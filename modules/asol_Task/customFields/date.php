<?php 
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

global $app_list_strings;

$date = $focus->date;

$rowIndex = 'forFieldDate';

$datetimeParsed = wfm_utils::parseDatetime($date);

$baseDatetime_forFieldDate = (isset($_REQUEST['baseDatetime_forFieldDate'])) ? $_REQUEST['baseDatetime_forFieldDate']: $datetimeParsed['baseDatetime_forFieldDate'];
$offsetSign_forFieldDate = (isset($_REQUEST['offsetSign_forFieldDate'])) ? $_REQUEST['offsetSign_forFieldDate']: $datetimeParsed['offsetSign_forFieldDate'];
$date_start_years_forFieldDate = (isset($_REQUEST['date_start_years_forFieldDate'])) ? $_REQUEST['date_start_years_forFieldDate']: $datetimeParsed['date_start_years_forFieldDate'];
$date_start_months_forFieldDate = (isset($_REQUEST['date_start_months_forFieldDate'])) ? $_REQUEST['date_start_months_forFieldDate']: $datetimeParsed['date_start_months_forFieldDate'];
$date_start_days_forFieldDate = (isset($_REQUEST['date_start_days_forFieldDate'])) ? $_REQUEST['date_start_days_forFieldDate']: $datetimeParsed['date_start_days_forFieldDate'];
$date_start_hours_forFieldDate = (isset($_REQUEST['date_start_hours_forFieldDate'])) ? $_REQUEST['date_start_hours_forFieldDate']: $datetimeParsed['date_start_hours_forFieldDate'];
$date_start_minutes_forFieldDate = (isset($_REQUEST['date_start_minutes_forFieldDate'])) ? $_REQUEST['date_start_minutes_forFieldDate']: $datetimeParsed['date_start_minutes_forFieldDate'];

$fieldDate = "<span id='date_field'>";
$fieldDate .= wfm_utils::generate_DateTime_Field_HTML_and_Remember_DataBase_if_needed($rowIndex, $baseDatetime_forFieldDate, $offsetSign_forFieldDate, $date_start_years_forFieldDate, $date_start_months_forFieldDate, $date_start_days_forFieldDate, $date_start_hours_forFieldDate, $date_start_minutes_forFieldDate); 
$fieldDate .= "</span>";

echo $fieldDate;

?>