<?php
    class DistributionMassUpdateHook {

        // Custom mass update to update Distirubtion Items instead of the actual Distributions
        public function handleDistroItemMassUpdate(&$bean, $event, $arguments)
        {
            if ($_REQUEST['action'] == 'MassUpdate') {
                if (! empty($_REQUEST['record'])) {
                    $distroItemBean = BeanFactory::getBean('DSBTN_DistributionItems', $_REQUEST['record']);
                    $distroItemBean->assigned_user_id = (isset($_REQUEST['users_id']) && (! empty($_REQUEST['users_id']))) ? $_REQUEST['users_id'] : $distroItemBean->assigned_user_id;
                    $distroItemBean->status_c = (isset($_REQUEST['distro_item_status_non_db']) && (! empty($_REQUEST['distro_item_status_non_db']))) ? $_REQUEST['distro_item_status_non_db'] : $distroItemBean->status_c;
                    $distroItemBean->save();
                }
            }
        }
    }

?>