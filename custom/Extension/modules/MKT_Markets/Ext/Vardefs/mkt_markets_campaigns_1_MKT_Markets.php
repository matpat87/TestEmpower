<?php 

$dictionary['MKT_Markets']['fields']['campaigns_markets'] = array(
        'name'         => 'campaigns_markets',
        'type'         => 'link', //Keep as this
        'relationship' => 'campaigns_markets', //Many to Many relationship table
        'source'       => 'non-db', //Leave as is
        'module' => 'Campaigns',
  		'bean_name' => 'Campaign',
        'vname'        => 'LBL_CAMPAIGN_MARKETS_FROM_CAMPAIGNS_TITLE',
    );
?>
