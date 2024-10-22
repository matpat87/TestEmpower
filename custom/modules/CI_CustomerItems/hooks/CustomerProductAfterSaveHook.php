<?php

require_once('custom/modules/CI_CustomerItems/helpers/CustomerItemsHelper.php');
require_once('custom/modules/MKT_Markets/helpers/MarketsHelper.php');

class CustomerProductAfterSaveHook
{
    // Send Mail to specific recipients when Markets set to To Be Defined
    public function send_mail_notification(&$bean, $event, $arguments)
    {
        global $sugar_config, $app_list_strings, $current_user, $log;
        
        if (($bean->mkt_markets_ci_customeritems_1_name != $bean->fetched_rel_row['mkt_markets_ci_customeritems_1_name']) && ($bean->mkt_markets_ci_customeritems_1_name == 'To Be Defined (Chroma Color)' 
            || $bean->mkt_markets_ci_customeritems_1_name == 'To Be Defined (Epolin)' )) {

                global $sugar_config, $app_list_strings;

                $mail = new SugarPHPMailer();
                $emailObj = new Email();
                $defaults = $emailObj->getSystemDefaultEmail();
                $mail = new SugarPHPMailer();
                $mail->setMailerForSystem();
                $mail->From = $defaults['email'];
                $mail->FromName = $defaults['name'];
                $mail->Subject = 'EmpowerCRM New TBD market request';
                
                $mail->Body = from_html(CustomerItemsHelper::tbdMarketEmailNotificationBody($bean));
                MarketsHelper::attachRecipients('CI_CustomerItems', $bean, $mail);

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
                $bean->mkt_markets_ci_customeritems_1->add($industryBean);
            }

            $getPrevIndustryBean = BeanFactory::getBean('MKT_Markets', $bean->fetched_row['sub_industry_c']);

            if ($getPrevIndustryBean && $getPrevIndustryBean->id) {
                $bean->load_relationship('mkt_markets_ci_customeritems_1');
                $bean->mkt_markets_ci_customeritems_1->delete($bean->id, $getPrevIndustryBean);
            }
        }
    }

    public function custom_markets_id_save(&$bean, $event, $argument)
    {
        global $log;

        if ($bean->fetched_row['new_market_c'] != $bean->new_market_c) {
            $marketBean = BeanFactory::getBean('MKT_NewMarkets', $bean->new_market_c); // Industry Moduel
            $bean->mkt_newmarkets_ci_customeritems_1->add($marketBean);
        }
    }
}
?>