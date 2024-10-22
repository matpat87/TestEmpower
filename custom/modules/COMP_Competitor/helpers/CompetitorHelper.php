<?php

class CompetitorHelper
{
    /**
     * Checks all competitors of an Account, if the the Competition ID exists
     * @params Account Bean, String Competition ID (COMP_Competition module)
     * @return COMP_Competitor Bean if exists and NULL if otherwise
     */
    public static function checkAccountCompetitors($accountBean, $competitionID = null) 
    {
        global $log;

        if (isset($accountBean->id) && $accountBean->id != '' && isset($competitionID)) {
            $accountBean->load_relationship('accounts_comp_competitor_1');
            $competitors = $accountBean->accounts_comp_competitor_1->getBeans(); // COMP_Competitor Beans (array)

            if (count($competitors) > 0) {
                foreach ($competitors as $id => $bean) {
                    if ($bean->competitor == $competitionID) {
                        return $bean; // returns the COMP_Competitor Bean
                    }
                }
            }
        }   

        return null;
    }

    /**
     * Checks all competitors of the Account's TR's @param comeptitor if associated
     * @params Account Bean, String Competition ID (COMP_Competition module), TR_TechnicalRequest Bean
     * @return TR_TechnicalRequest Bean if exists and Boolean FALSE if otherwise
     */
    public static function checkRelatedAccountTrCompetitors($accountBean, $competitorID = null, $trBean = null) 
    {
        global $log, $db, $current_user;
        
        if (!$current_user->is_admin) {
            $current_user->is_admin = true;
        }
        
        if (isset($accountBean->id) && $accountBean->id != '' && isset($competitorID) && isset($trBean)) {
            $result = $db->query("
                SELECT 
                    tr_technicalrequests.id,
                    tr_technicalrequests_cstm.comp_competition_id_c
                FROM
                    tr_technicalrequests
                        JOIN
                    tr_technicalrequests_accounts_c ON tr_technicalrequests.id = tr_technicalrequests_accounts_c.tr_technicalrequests_accountstr_technicalrequests_idb
                        AND tr_technicalrequests_accounts_c.deleted = 0
                        LEFT JOIN
                    tr_technicalrequests_cstm ON tr_technicalrequests_cstm.id_c = tr_technicalrequests.id
                WHERE
                    tr_technicalrequests.deleted = 0
                        AND tr_technicalrequests_accounts_c.tr_technicalrequests_accountsaccounts_ida = '{$accountBean->id}'
                        AND tr_technicalrequests.id != '{$trBean->id}'
                        AND tr_technicalrequests_cstm.comp_competition_id_c = '{$trBean->fetched_row['comp_competition_id_c']}';
                ");

            if ($result->num_rows && $result->num_rows > 0) {
                return true;
            }

        }

        return false;
    }
} // end of class