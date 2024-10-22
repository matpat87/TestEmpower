<?php

$dictionary['Account']['indices'][] = array(
     'name' => 'idx_cust_num_cstm',
     'type' => 'index',
     'fields' => array(
         0 => 'cust_num_c',
     ),
     'source' => 'non-db',
);