<?php
    class OpportunitiesAfterDeleteRelationshipHook
    {
        public function handleUnlinkPrimaryContact(&$bean, $event, $arguments)
        {
            if ($arguments['related_module'] == 'Contacts' && $arguments['link'] == "contacts") {
                if ($bean->contact_id_c == $arguments['related_id']) {
                    $bean->contact_id_c = '';
                    $bean->save();
                }
            }
        }
    }
?>