<?php

class CompetitorAfterSaveHook 
{
    public function handleCompetitorValueSave($bean, $event, $arguments)
    {
        $competitionBean = BeanFactory::getBean('COMP_Competition', $bean->competitor);
        $bean->load_relationship('comp_competitor_comp_competition');
        $bean->comp_competitor_comp_competition->add($competitionBean);
    } // end of handleCompetitorValueSave
}

?>