<?php
    
    $job_strings[] = 'vendorCodeOfConductDocumentExpiryScheduler';

    function vendorCodeOfConductDocumentExpiryScheduler()
    {
        global $db, $log;
        /**
         *      OnTrack #1655
         *  	1. Get ALL Documents where Category = 'Technical' && Sub Category = Code of Conduct
         * 		2. Check if Expiry date == current day
         * 			a. IF YES: remove file from db trigger the 'Remove' core function from 
         * 				custom/include/SugarFields/Fields/Cstmfile/deleteAttachment.php
         * 
         */

        $documentsQueryString = "
            SELECT 
                documents.id AS document_id,
                vend_vendors_documents_1_c.vend_vendors_documents_1vend_vendors_ida AS vendor_id,
                documents.exp_date
            FROM
                documents
                    LEFT JOIN
                vend_vendors_documents_1_c ON vend_vendors_documents_1_c.vend_vendors_documents_1documents_idb = documents.id
                    AND vend_vendors_documents_1_c.deleted = 0
            WHERE
                documents.deleted = 0
                    AND vend_vendors_documents_1_c.vend_vendors_documents_1vend_vendors_ida IS NOT NULL
                    AND documents.status_id <> 'Expired'
                    AND documents.category_id = 'Vendor'
                    AND documents.subcategory_id = 'Vendor_Code_of_Conduct' ";

        $documentQryResult = $db->query($documentsQueryString);

        $log->fatal("Vendor Code Of Conduct Document Expiry Scheduler - START");

        while ($row = $db->fetchByAssoc($documentQryResult)) {

            $documentExpDate = Carbon\Carbon::parse($row['exp_date']);
            
            if ($documentExpDate->isToday() || $documentExpDate->isPast()) {
                $_REQUEST['field'] = 'code_of_conduct_c';
                $_REQUEST['code_of_conduct_c_record_id'] = $row['vendor_id'];
                $_REQUEST['module'] = 'VEND_Vendors';

                $log->fatal("Unlinking COC file from Vendor");

                // SET Document Status to 'Expired'
                $db->query("
                    UPDATE documents SET status_id = 'Expired' WHERE id = '{$row['document_id']}'
                ");
                require('custom/include/SugarFields/Fields/Cstmfile/deleteAttachment.php'); // this is the actual unlink file used from the Remove button click event
            }
            
        }

        $log->fatal("Vendor Code Of Conduct Document Expiry Scheduler - END");
        return true;
        
    }


    
?>