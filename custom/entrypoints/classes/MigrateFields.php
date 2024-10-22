<?php
    //OnTrack #1218 - For Migration of fields
    class MigrateFields{
        private function get_tr_compititor_c(){
            global $db;
            $result = false;

            $sql = "select t.id,
                        tc.ci_competitor_c
                from tr_technicalrequests t
                inner join tr_technicalrequests_cstm tc
                    on tc.id_c = t.id
                where t.deleted = 0
                    and (tc.ci_competitor_c <> '' 
                    or tc.ci_competitor_c <> null)";

            $data = $db->query($sql);

            while($rowData = $db->fetchByAssoc($data)){
                $result[] = $rowData;
            }

            return $result;
        }

        private function update_tr_compititor_c($id, $ci_competitor_c){
            global $db;
            $result = false;

            $sql = "update tr_technicalrequests_cstm
                    set ci_competitor_c = '{$ci_competitor_c}'
                    where id_c = '{$id}' ";

            $result = $db->query($sql);

            return $result;
        }

        private function manage_tr_competitor_c(){
            global $log, $app_list_strings;

            $data = $this->get_tr_compititor_c();

            foreach($data as $record){
                $ci_competitor_c_val = !empty($app_list_strings['ci_competitor_list'][$record['ci_competitor_c']]) ? 
                    $app_list_strings['ci_competitor_list'][$record['ci_competitor_c']] : '';

                if(!empty($ci_competitor_c_val)){
                    $print_str = "MigrateFields.manage_tr_competitor_c: Changing from {$record['ci_competitor_c']} to {$ci_competitor_c_val}";
                    $log->fatal($print_str);
                    echo $print_str . '<br/>';
                    $this->update_tr_compititor_c($record['id'], $ci_competitor_c_val);
                }
            }
        }

        public function process(){
            global $app_list_strings;

            $this->manage_tr_competitor_c();
        }
    }
?>