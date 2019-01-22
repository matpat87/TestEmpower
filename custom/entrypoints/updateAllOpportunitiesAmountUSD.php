<?php

	$opportunitiesBean = BeanFactory::getBean('Opportunities');
	$opportunities = $opportunitiesBean->get_full_list("", "", false, 0);

	foreach($opportunities as $opportunity)
	{
		echo $opportunity->id . '<br>';

		if(empty($opportunity->amount_usd_c))
		{
	        $opportunity->amount_usd_c = "$" . number_format($opportunity->amount, 2, '.', ',');
	        $opportunity->save();
    	}
	}

?>