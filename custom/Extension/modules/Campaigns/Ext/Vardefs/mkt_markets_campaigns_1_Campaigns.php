<?php 

$dictionary['Campaign']['fields']['campaigns_markets'] = array(
        'name'         => 'campaigns_markets',
        'type'         => 'link', //Keep as this
        'relationship' => 'campaigns_markets', //Many to Many relationship table
     	'module'    => 'Campaigns',
     	'bean_name'    => 'Campaign',
        'source'       => 'non-db', //Leave as is
        'vname'        => 'LBL_CAMPAIGN_MARKETS_FROM_MARKETS_TITLE',
    );

?>