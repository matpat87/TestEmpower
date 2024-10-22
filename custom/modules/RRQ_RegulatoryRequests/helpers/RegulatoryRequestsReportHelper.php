<?php
    // handleVerifyBeforeRequire('custom/modules/RRQ_RegulatoryRequests/ManageTimelyNotif.php');

    class RegulatoryRequestsReportHelper
    {
       
        public function handleGenerateReportQueryByMonth($queryStr = "")
        {
            global $app_list_strings, $log;
            $returnArray = [];
            $db = DBManagerFactory::getInstance();
            $whereClause = "";

            if (! empty($_REQUEST['uid'])) {
                $explodedUIDs = explode(',', $_REQUEST['uid']);
                $whereInFormattedIds = handleArrayToWhereInFormatAll(array_combine($explodedUIDs, $explodedUIDs));
                $whereClause .= " AND rrq_regulatoryrequests.id IN ({$whereInFormattedIds}) ";

            } else {
                $whereInFormattedIds = self::getRowIds($queryStr);
                $whereClause .= " AND rrq_regulatoryrequests.id IN {$whereInFormattedIds} ";
            }


            $queryStr = "
                SELECT 
                    MONTHNAME(rrq_regulatoryrequests.date_entered) AS `row_labels`,
                    COALESCE(SUM(rrq_regulatoryrequests_cstm.total_requests_c),0) AS sum_of_total_requests
                FROM
                    rrq_regulatoryrequests
                        LEFT JOIN
                    rrq_regulatoryrequests_cstm ON rrq_regulatoryrequests_cstm.id_c = rrq_regulatoryrequests.id
                        AND rrq_regulatoryrequests.deleted = 0
                WHERE rrq_regulatoryrequests.deleted = 0 {$whereClause}
                GROUP BY MONTHNAME(rrq_regulatoryrequests.date_entered)
                ORDER BY MONTHNAME(rrq_regulatoryrequests.date_entered) ASC
            ";

            $results = $db->query($queryStr);
            while ($row = $db->fetchByAssoc($results)) {
                $returnArray[] = [
                    // $app_list_strings['reg_req_statuses'][$row['status']],
                    $row['row_labels'],
                    $row['sum_of_total_requests'],
                ];
            }

            return $returnArray;
        }

        public function handleGenerateReportQueryByAccount($queryStr = "")
        {
            global $app_list_strings;
            $returnArray = [];
            $db = DBManagerFactory::getInstance();
            $whereClause = "";

            if (! empty($_REQUEST['uid'])) {
                $explodedUIDs = explode(',', $_REQUEST['uid']);
                $whereInFormattedIds = handleArrayToWhereInFormatAll(array_combine($explodedUIDs, $explodedUIDs));
                $whereClause .= " AND rrq_regulatoryrequests.id IN ({$whereInFormattedIds}) ";

            } else {
                $whereInFormattedIds = self::getRowIds($queryStr);
                $whereClause .= " AND rrq_regulatoryrequests.id IN {$whereInFormattedIds} ";
            }

            $queryStr = "
                SELECT 
                    jt0.name AS `row_labels`,
                    COALESCE(SUM(rrq_regulatoryrequests_cstm.total_requests_c),0) AS sum_of_total_requests
                FROM
                    rrq_regulatoryrequests
                        LEFT JOIN
                    rrq_regulatoryrequests_cstm ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_cstm.id_c
                        LEFT JOIN
                    accounts_rrq_regulatoryrequests_1_c jtl0 ON rrq_regulatoryrequests.id = jtl0.accounts_rrq_regulatoryrequests_1rrq_regulatoryrequests_idb
                        AND jtl0.deleted = 0
                        LEFT JOIN
                    accounts jt0 ON jt0.id = jtl0.accounts_rrq_regulatoryrequests_1accounts_ida
                        AND jt0.deleted = 0
                WHERE
                    rrq_regulatoryrequests.deleted = 0 {$whereClause}
                GROUP BY jt0.name
                ORDER BY jt0.name ASC
            ";
            
            $results = $db->query($queryStr);
            while ($row = $db->fetchByAssoc($results)) {
                $returnArray[] = [
                    // $app_list_strings['reg_req_statuses'][$row['status']],
                    $row['row_labels'],
                    $row['sum_of_total_requests'],
                ];
            }

            return $returnArray;
        }
        
        public function handleGenerateReportQueryByUser($queryStr = ""): array
        {
            global $app_list_strings;
            $returnArray = [];
            $whereClause = "";
            $db = DBManagerFactory::getInstance();

            if (! empty($_REQUEST['uid'])) {
                $explodedUIDs = explode(',', $_REQUEST['uid']);
                $whereInFormattedIds = handleArrayToWhereInFormatAll(array_combine($explodedUIDs, $explodedUIDs));
                $whereClause .= " AND rrq_regulatoryrequests.id IN ({$whereInFormattedIds}) ";

            } else {
                $whereInFormattedIds = self::getRowIds($queryStr);
                $whereClause .= " AND rrq_regulatoryrequests.id IN {$whereInFormattedIds} ";
            }

            $queryStr = "
                SELECT 
                    users.user_name AS `row_labels`,
                    COALESCE(SUM(rrq_regulatoryrequests_cstm.total_requests_c),
                            0) AS sum_of_total_requests
                FROM
                    rrq_regulatoryrequests
                        LEFT JOIN
                    rrq_regulatoryrequests_cstm ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_cstm.id_c
                        LEFT JOIN
                    rrq_regulatoryrequests_audit AS audit1 ON rrq_regulatoryrequests.id = audit1.parent_id
                        AND audit1.field_name = 'assigned_user_id'
                        AND audit1.date_created = (SELECT 
                            date_created
                        FROM
                            rrq_regulatoryrequests_audit
                        WHERE
                            parent_id = rrq_regulatoryrequests.id
                                AND before_value_string = 'new'
                                AND after_value_string = 'assigned'
                        ORDER BY date_created
                        LIMIT 1)
                        LEFT JOIN
                    rrq_regulatoryrequests_audit AS audit2 ON rrq_regulatoryrequests.id = audit2.parent_id
                        AND audit2.field_name = 'status_c'
                        AND audit2.before_value_string = 'new'
                        AND audit2.after_value_string = 'assigned'
                        INNER JOIN
                    users ON users.id = COALESCE(audit1.after_value_string,
                            audit2.created_by)
                WHERE
                    rrq_regulatoryrequests.deleted = 0
                        {$whereClause}
                GROUP BY users.user_name
                ORDER BY users.user_name ASC
            ";

            $results = $db->query($queryStr);
            while ($row = $db->fetchByAssoc($results)) {
                $returnArray[] = [
                    // $app_list_strings['reg_req_statuses'][$row['status']],
                    $row['row_labels'],
                    $row['sum_of_total_requests'],
                ];
            }

            return $returnArray;
        }

        private function getRowIds($queryStr)
        {
            $db = DBManagerFactory::getInstance();
            $ids = [];
            $results = $db->query($queryStr);

            while ($row = $db->fetchByAssoc($results)) {
                $ids[] = $row['id'];
            }

            $whereInStructure = !empty($ids) ? "('" . implode("','", $ids) . "')" : "";
            return $whereInStructure;
        }
        
    }


?>