<?php

require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');
require_once('custom/modules/MKT_Markets/helpers/MarketsHelper.php');

class OpportunitiesAfterSaveHook
{
    public function send_mail_notification(&$bean, $event, $arguments)
    {
        global $sugar_config, $app_list_strings, $current_user, $log;

        // $log->fatal(print_r($bean, true));
        
        if (($bean->mkt_markets_opportunities_1_name != $bean->fetched_rel_row['mkt_markets_opportunities_1_name']) 
            && ($bean->mkt_markets_opportunities_1_name == 'To Be Defined (Chroma Color)' 
            || $bean->mkt_markets_opportunities_1_name == 'To Be Defined (Epolin)' )) {

                global $sugar_config, $app_list_strings;

                $mail = new SugarPHPMailer();
                $emailObj = new Email();
                $defaults = $emailObj->getSystemDefaultEmail();
                $mail = new SugarPHPMailer();
                $mail->setMailerForSystem();
                $mail->From = $defaults['email'];
                $mail->FromName = $defaults['name'];
                $mail->Subject = 'EmpowerCRM New TBD market request';
                
                $mail->Body = from_html(OpportunitiesHelper::tbdMarketEmailNotificationBody($bean));
                MarketsHelper::attachRecipients('Opportunities', $bean, $mail);

                $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
                $mail->isHTML(true);
                $mail->prepForOutbound();
                $mail->Send();
            
        }
    }

    public function custom_industry_ida_value(&$bean, $event, $argument)
    {
        global $log, $db;

        if ($bean->sub_industry_c != $bean->fetched_row['sub_industry_c']) {
            $industryBean = BeanFactory::getBean('MKT_Markets', $bean->sub_industry_c); // Industry Module

            if ($industryBean && $industryBean->id) {
                $bean->mkt_markets_opportunities_1->add($industryBean);
            }

            $getPrevIndustryBean = BeanFactory::getBean('MKT_Markets', $bean->fetched_row['sub_industry_c']);

            if ($getPrevIndustryBean && $getPrevIndustryBean->id) {
                $bean->load_relationship('mkt_markets_opportunities_1');
                $bean->mkt_markets_opportunities_1->delete($bean->id, $getPrevIndustryBean);
            }
        }
    }

    public function custom_markets_id_save(&$bean, $event, $argument)
    {
        global $log;

        if ($bean->fetched_row['market_c'] != $bean->market_c) {
            $marketBean = BeanFactory::getBean('MKT_NewMarkets', $bean->market_c); // markets
            $bean->mkt_newmarkets_opportunities_1->add($marketBean);
        }
    }
    
}

?>