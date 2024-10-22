<?php
    class VI_VendorIssuesHelper {
        public static function assign_issue_number($vi_vendorissues_number = '')
        {
            global $db;
            $result = 0;
            $vi_vendorissues_bean = BeanFactory::getBean('VI_VendorIssues');
            
            $vi_vendorissues_bean_list = $vi_vendorissues_bean->get_full_list('id', "vi_vendorissues.id = '{$vi_vendorissues_number}'", false, 0);
    
            if(!empty($vi_vendorissues_bean_list) && count($vi_vendorissues_bean_list) > 0){
                $result = $vi_vendorissues_bean_list[0]->vi_vendorissues_number;
            } else {
                $data = $db->query("select vi_vendorissues_number 
                    from vi_vendorissues
                    order by vi_vendorissues_number desc
                    limit 1");
                $rowData = $db->fetchByAssoc($data);
        
                if($rowData != null)
                {
                    $result = $rowData['vi_vendorissues_number'];
                }
                
                $result += 1;
            }
    
            return $result;
        } 
    }
?>