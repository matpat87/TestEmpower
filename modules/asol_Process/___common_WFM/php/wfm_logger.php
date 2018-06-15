<?php
require_once('include/SugarLogger/SugarLogger.php');
class wfm_logger extends SugarLogger
{
    protected $logfile = 'wfm';
    protected $ext = '.log';
    protected $dateFormat = '%c';
    protected $logSize = '10MB';
    protected $maxLogs = 100;
    protected $filesuffix = "";
    protected $date_suffix = "";
    protected $log_dir = './';
    public function __construct()
    {
        $this->_doInitialization();
    }
}