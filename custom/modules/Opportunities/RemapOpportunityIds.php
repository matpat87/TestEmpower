<?php
    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    // Call function in browser: <url>/index.php?module=Opportunities&action=RemapOpportunityIds
    remapOpportunityIds();

    function remapOpportunityIds()
    {
        global $db;

        $oppIdsArray = [
            ['incorrect' => 1516, 'actual' => 1396 ],
            ['incorrect' => 1517, 'actual' => 1293 ],
            ['incorrect' => 1518, 'actual' => 1458 ],
            ['incorrect' => 1527, 'actual' => 1020 ],
            ['incorrect' => 1528, 'actual' => 1021 ],
            ['incorrect' => 1529, 'actual' => 1022 ],
            ['incorrect' => 1530, 'actual' => 1180 ],
            ['incorrect' => 1531, 'actual' => 1410 ],
            ['incorrect' => 1532, 'actual' => 1220 ],
            ['incorrect' => 1533, 'actual' => 1268 ],
            ['incorrect' => 1534, 'actual' => 1287 ],
            ['incorrect' => 1535, 'actual' => 1288 ],
            ['incorrect' => 1536, 'actual' => 1356 ],
            ['incorrect' => 1537, 'actual' => 1414 ],
            ['incorrect' => 1543, 'actual' => 1499 ],
            ['incorrect' => 1546, 'actual' => 1500 ],
            ['incorrect' => 1548, 'actual' => 951 ],
            ['incorrect' => 1550, 'actual' => 828 ],
            ['incorrect' => 1551, 'actual' => 674 ],
            ['incorrect' => 1552, 'actual' => 974 ],
            ['incorrect' => 1554, 'actual' => 973 ],
            ['incorrect' => 1555, 'actual' => 877 ],
            ['incorrect' => 1556, 'actual' => 830 ],
            ['incorrect' => 1557, 'actual' => 976 ],
            ['incorrect' => 1558, 'actual' => 665 ],
            ['incorrect' => 1559, 'actual' => 975 ],
            ['incorrect' => 1560, 'actual' => 834 ],
            ['incorrect' => 1562, 'actual' => 952 ],
            ['incorrect' => 1563, 'actual' => 835 ],
            ['incorrect' => 1564, 'actual' => 864 ],
            ['incorrect' => 1566, 'actual' => 1409 ],
            ['incorrect' => 1569, 'actual' => 1272 ],
            ['incorrect' => 1570, 'actual' => 1327 ],
            ['incorrect' => 1572, 'actual' => 1455 ],
            ['incorrect' => 1579, 'actual' => 985 ],
            ['incorrect' => 1582, 'actual' => 1379 ],
            ['incorrect' => 1591, 'actual' => 1113 ],
            ['incorrect' => 1593, 'actual' => 1452 ],
            ['incorrect' => 1594, 'actual' => 1433 ],
        ];
        
        foreach ($oppIdsArray as $key => $value) {
            $sql = "UPDATE opportunities_cstm SET oppid_c = {$value['actual']} WHERE oppid_c = {$value['incorrect']};";

            $opportunityBean = BeanFactory::getBean('Opportunities')->retrieve_by_string_fields(
                array(
                    "oppid_c" => $value['incorrect'],
                ), false, true
            );
    
            echo '<pre>';
                print_r($sql);
            echo '</pre>';

            $db->query($sql);
        }
    }
?>