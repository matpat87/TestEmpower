<?php

class CompetitorBeforeSaveHook 
{
    public function handleSaveCompetitionName($bean, $event, $arguments)
    {
        $competitionBean = BeanFactory::getBean('COMP_Competition', $bean->competitor);
        $bean->name = $competitionBean->name;
    } // end of handleCompetitorValueSave
}

?>