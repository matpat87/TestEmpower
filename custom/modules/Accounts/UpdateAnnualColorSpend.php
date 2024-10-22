<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Accounts&action=UpdateAnnualColorSpend
updateAnnualColorSpend();

function updateAnnualColorSpend()
{
	global $db;

    $newAccountData = [];
    
    $newAccountData[] = ['account_id' => '1bc55b77-8957-1aaa-3278-5d7ab00e0444','type'=> 'Customer Parent','customer_number' => 'P010270','annual_color_spend' => 3600000];
    $newAccountData[] = ['account_id' => '976004c2-5339-5f43-442b-5d7ab0f0deb3','type'=> 'Customer Parent','customer_number' => 'P010358','annual_color_spend' => 1800000];
    $newAccountData[] = ['account_id' => '8d180768-6fe0-9f65-ecc9-5d7ab0a0c9fe','type'=> 'Customer Parent','customer_number' => 'P010681','annual_color_spend' => 7300000];
    $newAccountData[] = ['account_id' => '887979af-a9be-11ec-aa94-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P011045','annual_color_spend' => 6300000];
    $newAccountData[] = ['account_id' => '9a4f15f1-ac66-11ec-aa94-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P011054','annual_color_spend' => 1100000];
    $newAccountData[] = ['account_id' => '3ec8a01f-f3fd-cb77-adcb-5d7ab0ec3e0b','type'=> 'Customer Parent','customer_number' => 'P011257','annual_color_spend' => 1800000];
    $newAccountData[] = ['account_id' => 'e9e9727b-a5f9-3760-10da-5d7ab010a2c4','type'=> 'Customer Parent','customer_number' => 'P013246','annual_color_spend' => 620000];
    $newAccountData[] = ['account_id' => '9193a0c7-6301-150a-8c05-5d7ab0505dec','type'=> 'Customer Parent','customer_number' => 'P013291','annual_color_spend' => 1500000];
    $newAccountData[] = ['account_id' => '72b8ec81-2804-11eb-834a-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P015690','annual_color_spend' => 650000];
    $newAccountData[] = ['account_id' => '4c0e523d-e1f0-38ef-6b27-5d7ab0d79048','type'=> 'Customer Parent','customer_number' => 'P015897','annual_color_spend' => 1700000];
    $newAccountData[] = ['account_id' => 'c7748387-eb97-ca91-e85b-5f11c392fff9','type'=> 'Customer Parent','customer_number' => 'P016046','annual_color_spend' => 1600000];
    $newAccountData[] = ['account_id' => '2d04bc59-bd84-993d-1bd1-5d7ab0cadb88','type'=> 'Customer Parent','customer_number' => 'P016050','annual_color_spend' => 1700000];
    $newAccountData[] = ['account_id' => 'a402af39-d7f9-5137-ff2b-5d7ab098a1b0','type'=> 'Customer Parent','customer_number' => 'P016565','annual_color_spend' => 6800000];
    $newAccountData[] = ['account_id' => '6bfd564e-4402-b90d-9296-5d7ab03a6e99','type'=> 'Customer Parent','customer_number' => 'P016912','annual_color_spend' => 600000];
    $newAccountData[] = ['account_id' => 'e73eebd9-cc82-eb94-bddc-5f29b8e75852','type'=> 'Customer Parent','customer_number' => 'P017685','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => '11262c13-102d-c979-eba6-5dc8afd530de','type'=> 'Customer Parent','customer_number' => 'P018404','annual_color_spend' => 2100000];
    $newAccountData[] = ['account_id' => '65b9aa11-4c87-ecb0-f50a-5f29c1e9f3b5','type'=> 'Customer Parent','customer_number' => 'P018669','annual_color_spend' => 430000];
    $newAccountData[] = ['account_id' => '2d59576f-5f7f-11ec-bace-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P019282','annual_color_spend' => 730000];
    $newAccountData[] = ['account_id' => '29588c49-9e48-4160-9845-5d7ab012b20a','type'=> 'Customer Parent','customer_number' => 'P010853','annual_color_spend' => 700000];
    $newAccountData[] = ['account_id' => '758fdb75-2804-11eb-834a-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P011757','annual_color_spend' => 1500000];
    $newAccountData[] = ['account_id' => '590c6ee7-349d-72bd-4adf-5d7ab0b562fc','type'=> 'Customer Parent','customer_number' => 'P011846','annual_color_spend' => 500000];
    $newAccountData[] = ['account_id' => '9a83bf7d-c6de-9d87-173b-5d7ab0889977','type'=> 'Customer Parent','customer_number' => 'P014285','annual_color_spend' => 2000000];
    $newAccountData[] = ['account_id' => 'b87207db-0b77-cffe-a836-5d7ab0b40e58','type'=> 'Customer Parent','customer_number' => 'P014465','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => 'b083ac0e-3ec0-e803-ec6c-5d7ab03eadc5','type'=> 'Customer Parent','customer_number' => 'P014807','annual_color_spend' => 1200000];
    $newAccountData[] = ['account_id' => '3db1dc61-9113-6645-8966-5d7ab0cde422','type'=> 'Customer Parent','customer_number' => 'P017639','annual_color_spend' => 3000000];
    $newAccountData[] = ['account_id' => 'b6cccbaa-6545-2272-e4a1-5d7ab0d146f1','type'=> 'Customer Parent','customer_number' => 'P010101','annual_color_spend' => 400000];
    $newAccountData[] = ['account_id' => 'da9ea60f-fa4d-21a5-850c-5d7ab0429b9c','type'=> 'Customer Parent','customer_number' => 'P010510','annual_color_spend' => 800000];
    $newAccountData[] = ['account_id' => '63773711-afa1-fc2c-e6dd-5d7ab010f637','type'=> 'Customer Parent','customer_number' => 'P011656','annual_color_spend' => 3700000];
    $newAccountData[] = ['account_id' => '8ed59422-bf6c-cbe9-9896-5d7ab0adc2c0','type'=> 'Customer Parent','customer_number' => 'P011778','annual_color_spend' => 1607000];
    $newAccountData[] = ['account_id' => '47e903af-da21-03f4-4d98-5d7ab0c5a936','type'=> 'Customer Parent','customer_number' => 'P011947','annual_color_spend' => 425000];
    $newAccountData[] = ['account_id' => '3fc9d9f9-f2e1-11ea-8626-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P012445','annual_color_spend' => 300000];
    $newAccountData[] = ['account_id' => '84e96837-d041-f5a4-5887-5d7ab09d48de','type'=> 'Customer Parent','customer_number' => 'P014528','annual_color_spend' => 170000];
    $newAccountData[] = ['account_id' => '87f6412a-9fe3-11ec-aa94-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P015426','annual_color_spend' => 325000];
    $newAccountData[] = ['account_id' => '5f74d917-64b9-1fd5-22ca-5d7ab01126b2','type'=> 'Customer Parent','customer_number' => 'P015986','annual_color_spend' => 3000000];
    $newAccountData[] = ['account_id' => 'aa87d9e7-5d2e-f631-bd04-5d7ab0b5af59','type'=> 'Customer Parent','customer_number' => 'P016467','annual_color_spend' => 400000];
    $newAccountData[] = ['account_id' => 'b9550bac-f102-0be5-e3ff-5d7ab0cc52a7','type'=> 'Customer Parent','customer_number' => 'P017051','annual_color_spend' => 300000];
    $newAccountData[] = ['account_id' => '46bb0e12-2049-6dea-7241-5d7ab0db585f','type'=> 'Customer Parent','customer_number' => 'P017094','annual_color_spend' => 2500000];
    $newAccountData[] = ['account_id' => 'd580403a-a400-1a10-af54-5d7ab0ecfe58','type'=> 'Customer Parent','customer_number' => 'P017877','annual_color_spend' => 2000000];
    $newAccountData[] = ['account_id' => '72f4e4d7-2804-11eb-834a-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P018453','annual_color_spend' => 700000];
    $newAccountData[] = ['account_id' => 'dfc7cf93-8075-a85d-ade5-5d7ab086ed8a','type'=> 'Customer Parent','customer_number' => 'P010244','annual_color_spend' => 364201];
    $newAccountData[] = ['account_id' => '3ff98934-4d87-00b9-d844-5d7ab01c037b','type'=> 'Customer Parent','customer_number' => 'P010290','annual_color_spend' => 900000];
    $newAccountData[] = ['account_id' => '12632129-57fc-38ab-2946-5d7ab0db5a00','type'=> 'Customer Parent','customer_number' => 'P012510','annual_color_spend' => 3200000];
    $newAccountData[] = ['account_id' => 'e8a31de3-2dc1-4885-70f1-5d7ab0ce2a75','type'=> 'Customer Parent','customer_number' => 'P012639','annual_color_spend' => 200000];
    $newAccountData[] = ['account_id' => '36f158ee-d8ae-e750-c9d6-5d7ab0bc01a3','type'=> 'Customer Parent','customer_number' => 'P013449','annual_color_spend' => 283757];
    $newAccountData[] = ['account_id' => 'a07f7674-59f1-77fa-748c-5d7ab0dc45c5','type'=> 'Customer Parent','customer_number' => 'P013973','annual_color_spend' => 3500000];
    $newAccountData[] = ['account_id' => 'b3d2bbc1-b0bf-0135-6f04-5d7ab0ee0a64','type'=> 'Customer Parent','customer_number' => 'P017241','annual_color_spend' => 120000000];
    $newAccountData[] = ['account_id' => '5df381d5-3af3-a439-ac11-5d7ab04963f0','type'=> 'Customer Parent','customer_number' => 'P017481','annual_color_spend' => 425000];
    $newAccountData[] = ['account_id' => '1234b761-6469-23c8-4906-5d7ab0fbe9da','type'=> 'Customer Parent','customer_number' => 'P017896','annual_color_spend' => 260372];
    $newAccountData[] = ['account_id' => '44073556-f2e1-11ea-8626-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P018701','annual_color_spend' => 307745];
    $newAccountData[] = ['account_id' => '1e298ec8-5f7f-11ec-bace-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P019002','annual_color_spend' => 500000];
    $newAccountData[] = ['account_id' => '161c9459-5f7f-11ec-bace-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P018912','annual_color_spend' => 2400000];
    $newAccountData[] = ['account_id' => '802bbd2c-a110-8510-1032-5d7ab0010d55','type'=> 'Customer Parent','customer_number' => 'P010159','annual_color_spend' => 500000];
    $newAccountData[] = ['account_id' => '84d5cb16-05c3-c71f-19d3-5d7ab0588be9','type'=> 'Customer Parent','customer_number' => 'P010487','annual_color_spend' => 650000];
    $newAccountData[] = ['account_id' => 'aa7a60f8-b58b-4e96-d503-5d7ab0938b55','type'=> 'Customer Parent','customer_number' => 'P010490','annual_color_spend' => 650000];
    $newAccountData[] = ['account_id' => 'ae3a1323-377c-b024-5cff-5d7ab09d4d45','type'=> 'Customer Parent','customer_number' => 'P010915','annual_color_spend' => 600000];
    $newAccountData[] = ['account_id' => '1cd4da71-921a-6fd3-dc2a-5d7ab08af48d','type'=> 'Customer Parent','customer_number' => 'P011393','annual_color_spend' => 1150000];
    $newAccountData[] = ['account_id' => '243dc28c-8c03-b4e7-a9aa-5d7ab0b6240b','type'=> 'Customer Parent','customer_number' => 'P011633','annual_color_spend' => 1600000];
    $newAccountData[] = ['account_id' => '2b0794b1-266e-87dd-752f-5d7ab0d3feb2','type'=> 'Customer Parent','customer_number' => 'P014258','annual_color_spend' => 1115000];
    $newAccountData[] = ['account_id' => 'b5fbe7c3-b046-0bc4-c954-5d7ab0166b48','type'=> 'Customer Parent','customer_number' => 'P015226','annual_color_spend' => 3900000];
    $newAccountData[] = ['account_id' => '60a48371-5474-6516-6c2f-5d7ab08faabd','type'=> 'Customer Parent','customer_number' => 'P015761','annual_color_spend' => 850000];
    $newAccountData[] = ['account_id' => 'c89a3e94-7ec0-c2a9-2c22-5d7ab0272e38','type'=> 'Customer Parent','customer_number' => 'P016354','annual_color_spend' => 4500000];
    $newAccountData[] = ['account_id' => '2878f0fa-616e-2c0a-c25a-5d7ab0e776d2','type'=> 'Customer Parent','customer_number' => 'P018037','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => 'df5d6c9a-a5c6-b597-484c-5d7ab02ef753','type'=> 'Customer Parent','customer_number' => 'P010191','annual_color_spend' => 600000];
    $newAccountData[] = ['account_id' => '60205f3b-605f-13b7-bf80-5d7ab02f7c1f','type'=> 'Customer Parent','customer_number' => 'P011410','annual_color_spend' => 600000];
    $newAccountData[] = ['account_id' => 'a952edf9-e6af-addd-aab9-5d7ab022393e','type'=> 'Customer Parent','customer_number' => 'P012370','annual_color_spend' => 1244358];
    $newAccountData[] = ['account_id' => 'e3dbb7bb-4364-2eac-3c42-5d7ab0eba906','type'=> 'Customer Parent','customer_number' => 'P013910','annual_color_spend' => 343136];
    $newAccountData[] = ['account_id' => 'ccb79075-cf63-87d8-10ac-5d7ab01f8101','type'=> 'Customer Parent','customer_number' => 'P015508','annual_color_spend' => 750000];
    $newAccountData[] = ['account_id' => 'e05d5398-2a0a-8d5a-6caf-5d7ab0bc076a','type'=> 'Customer Parent','customer_number' => 'P016578','annual_color_spend' => 282863];
    $newAccountData[] = ['account_id' => '0c273543-5f7f-11ec-bace-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P017042','annual_color_spend' => 1064000];
    $newAccountData[] = ['account_id' => '51c65da0-1d83-1d81-073f-5d7ab0f003fd','type'=> 'Customer Parent','customer_number' => 'P017477','annual_color_spend' => 1078350];
    $newAccountData[] = ['account_id' => '837c4b5e-6ae5-a5e3-122a-5d7ab0cd8743','type'=> 'Customer Parent','customer_number' => 'P010002','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => '7f832746-0365-0ffd-d704-5d7ab0d74444','type'=> 'Customer Parent','customer_number' => 'P011777','annual_color_spend' => 500000];
    $newAccountData[] = ['account_id' => 'f0fa6c03-8742-2264-a832-5d7ab0b3e1ae','type'=> 'Customer Parent','customer_number' => 'P012259','annual_color_spend' => 500000];
    $newAccountData[] = ['account_id' => '30e94409-2855-75d5-3548-5d7ab0b6edf9','type'=> 'Customer Parent','customer_number' => 'P012335','annual_color_spend' => 1500000];
    $newAccountData[] = ['account_id' => 'c45835ef-a534-2faa-e21c-5d7ab07baa7d','type'=> 'Customer Parent','customer_number' => 'P013821','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => 'ce810170-e033-2a07-8ec5-5d7ab0afa596','type'=> 'Customer Parent','customer_number' => 'P015367','annual_color_spend' => 5000000];
    $newAccountData[] = ['account_id' => '99f20c93-196b-0a9d-b00f-5d7ab0abde23','type'=> 'Customer Parent','customer_number' => 'P016267','annual_color_spend' => 650000];
    $newAccountData[] = ['account_id' => '82517056-2983-8324-18fa-5d7ab058476d','type'=> 'Customer Parent','customer_number' => 'P016331','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => '9a9feb94-daaf-523f-7cb9-5d7ab0b8afdc','type'=> 'Customer Parent','customer_number' => 'P016339','annual_color_spend' => 350000];
    $newAccountData[] = ['account_id' => '4ddd3df5-2f94-e6cf-8c7f-5d7ab0d8bc4c','type'=> 'Customer Parent','customer_number' => 'P017111','annual_color_spend' => 4000000];
    $newAccountData[] = ['account_id' => 'e2ea1cd4-0fef-36bc-e8f5-5d7ab0bdb147','type'=> 'Customer Parent','customer_number' => 'P017246','annual_color_spend' => 800000];
    $newAccountData[] = ['account_id' => '4ba68f3c-6ba0-6bc0-cdb2-5d7ab0d92a15','type'=> 'Customer Parent','customer_number' => 'P017741','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => '4efde1c6-504f-34f0-251b-5d7ab03cb76c','type'=> 'Customer Parent','customer_number' => 'P018050','annual_color_spend' => 550000];
    $newAccountData[] = ['account_id' => '47a9c37b-f2e1-11ea-8626-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P018733','annual_color_spend' => 500000];
    $newAccountData[] = ['account_id' => 'a2fea90a-23e4-11ed-ab51-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P011081','annual_color_spend' => 5500000];
    $newAccountData[] = ['account_id' => '3f243e93-e417-257c-915a-5d7ab0290b83','type'=> 'Customer Parent','customer_number' => 'P010378','annual_color_spend' => 2500000];
    $newAccountData[] = ['account_id' => 'ceff58d1-3ec1-8947-8780-5d7ab0c05402','type'=> 'Customer Parent','customer_number' => 'P010415','annual_color_spend' => 10000000];
    $newAccountData[] = ['account_id' => 'a4a5d716-23e4-11ed-ab51-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P011353','annual_color_spend' => 40000000];
    $newAccountData[] = ['account_id' => 'ce2ae1dd-7202-017b-b7e0-5d7ab088208e','type'=> 'Customer Parent','customer_number' => 'P013182','annual_color_spend' => 4000000];
    $newAccountData[] = ['account_id' => '43f9768c-f458-dcd5-3a5c-5d7ab045a488','type'=> 'Customer Parent','customer_number' => 'P010607','annual_color_spend' => 700000];
    $newAccountData[] = ['account_id' => '97470045-008b-2047-3e85-5d7ab02c7ed1','type'=> 'Customer Parent','customer_number' => 'P010005','annual_color_spend' => 450000];
    $newAccountData[] = ['account_id' => '7f6ea5b8-0286-d37d-78b1-5d7ab0bccf67','type'=> 'Customer Parent','customer_number' => 'P013612','annual_color_spend' => 300000];
    $newAccountData[] = ['account_id' => 'ae1e7c4f-1b69-11eb-834a-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P015131','annual_color_spend' => 1500000];
    $newAccountData[] = ['account_id' => 'b7f2a3f4-9d9a-6cba-d4f4-5d7ab0a61835','type'=> 'Customer Parent','customer_number' => 'P016945','annual_color_spend' => 600000];
    $newAccountData[] = ['account_id' => '2cfcb187-5f7f-11ec-bace-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P019228','annual_color_spend' => 600000];
    $newAccountData[] = ['account_id' => '9fd5a7d5-17c7-481b-2945-5d7ab01dc5d5','type'=> 'Customer Parent','customer_number' => 'P015828','annual_color_spend' => 950000];
    $newAccountData[] = ['account_id' => '56f8cb21-5208-8225-0901-5d7ab0c9f405','type'=> 'Customer Parent','customer_number' => 'P010295','annual_color_spend' => 2000000];
    $newAccountData[] = ['account_id' => '88a849d5-a9be-11ec-aa94-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P011529','annual_color_spend' => 7000000];
    $newAccountData[] = ['account_id' => '63b7d827-1aa0-11eb-834a-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P015379','annual_color_spend' => 12000000];
    $newAccountData[] = ['account_id' => '588ae735-3c0d-bcd8-efd2-5d7ab04fd1f1','type'=> 'Customer Parent','customer_number' => 'P015585','annual_color_spend' => 500000];
    $newAccountData[] = ['account_id' => '402443c0-f2e1-11ea-8626-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P016926','annual_color_spend' => 5000000];
    $newAccountData[] = ['account_id' => '41889961-cd15-87e7-007e-5d7ab0490106','type'=> 'Customer Parent','customer_number' => 'P017108','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => '4f9cd7cc-b0b7-ccd2-88fc-5d7ab0ac8bb9','type'=> 'Customer Parent','customer_number' => 'P017370','annual_color_spend' => 6000000];
    $newAccountData[] = ['account_id' => '42fd1fa7-f2e1-11ea-8626-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P017712','annual_color_spend' => 3000000];
    $newAccountData[] = ['account_id' => '0ef727dc-5f7f-11ec-bace-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P018816','annual_color_spend' => 3000000];
    $newAccountData[] = ['account_id' => 'abc4b42a-b6c0-bc32-637f-5d7ab0690665','type'=> 'Customer Parent','customer_number' => 'P010655','annual_color_spend' => 320000];
    $newAccountData[] = ['account_id' => '3cf3f453-192e-be69-fd48-5d7ab0ff2cb7','type'=> 'Customer Parent','customer_number' => 'P011668','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => '5c8cea14-ac84-edd7-3079-5d7ab018b935','type'=> 'Customer Parent','customer_number' => 'P013760','annual_color_spend' => 880000];
    $newAccountData[] = ['account_id' => '92c496e5-1586-ebe2-3427-5d7ab078d5f2','type'=> 'Customer Parent','customer_number' => 'P014422','annual_color_spend' => 400000];
    $newAccountData[] = ['account_id' => '0e230579-ac39-11ec-aa94-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P011053','annual_color_spend' => 0];
    $newAccountData[] = ['account_id' => '725c8a46-03d6-11eb-8626-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P013861','annual_color_spend' => 1800000];
    $newAccountData[] = ['account_id' => '49eb8c60-6e3e-c798-890f-5d7ab09a4b80','type'=> 'Customer Parent','customer_number' => 'P014025','annual_color_spend' => 300000];
    $newAccountData[] = ['account_id' => 'a1987993-e5b8-0386-64e6-5d7ab0a2ef5b','type'=> 'Customer Parent','customer_number' => 'P018478','annual_color_spend' => 450000];
    $newAccountData[] = ['account_id' => '360afa0c-9263-c4bd-aa01-5d7ab036c3b6','type'=> 'Customer Parent','customer_number' => 'P018560','annual_color_spend' => 475000];
    $newAccountData[] = ['account_id' => '103141ae-1cd4-5e73-6f49-5f29bfdbdcd3','type'=> 'Customer Parent','customer_number' => 'P018645','annual_color_spend' => 480000];
    $newAccountData[] = ['account_id' => '5b46b12e-1fd0-64cc-4012-5d7ab06e1038','type'=> 'Customer Parent','customer_number' => 'P010140','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => 'e82e0110-f8bd-7e26-541c-5d7ab05d40a5','type'=> 'Customer Parent','customer_number' => 'P010590','annual_color_spend' => 325000];
    $newAccountData[] = ['account_id' => '419517fd-9e5b-0ac6-9a56-5d7ab09a2ab6','type'=> 'Customer Parent','customer_number' => 'P011316','annual_color_spend' => 300000];
    $newAccountData[] = ['account_id' => '3e070a56-1c1d-f282-eb60-5d7ab0bdc886','type'=> 'Customer Parent','customer_number' => 'P014021','annual_color_spend' => 700000];
    $newAccountData[] = ['account_id' => '2104c12e-08af-500c-3252-5d7ab01fbe64','type'=> 'Customer Parent','customer_number' => 'P016047','annual_color_spend' => 291000];
    $newAccountData[] = ['account_id' => '718265e3-2804-11eb-834a-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P017281','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => '7bcab580-7367-62b9-6595-5d7ab08862f1','type'=> 'Customer Parent','customer_number' => 'P018472','annual_color_spend' => 323000];
    $newAccountData[] = ['account_id' => 'bc64b19b-2416-11eb-834a-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P010944','annual_color_spend' => 70000000];
    $newAccountData[] = ['account_id' => '52e42578-9923-7e45-a812-5d7ab08b72a9','type'=> 'Customer Parent','customer_number' => 'P011481','annual_color_spend' => 415000];
    $newAccountData[] = ['account_id' => 'bdb9aa04-63f3-c5fc-33d7-5d7ab057fe36','type'=> 'Customer Parent','customer_number' => 'P011867','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => '84fa3bf8-bab7-081a-75f8-5d7ab03f5c5d','type'=> 'Customer Parent','customer_number' => 'P015771','annual_color_spend' => 5000000];
    $newAccountData[] = ['account_id' => 'e5d2064a-d708-4636-859e-5d7ab042b60c','type'=> 'Customer Parent','customer_number' => 'P016792','annual_color_spend' => 1000000];
    $newAccountData[] = ['account_id' => '0b4762be-5f7f-11ec-bace-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P016062','annual_color_spend' => 6000000];
    $newAccountData[] = ['account_id' => 'ad6d3d42-f743-11ea-8626-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P018765','annual_color_spend' => 260000];
    $newAccountData[] = ['account_id' => '8769c9d7-9fe3-11ec-aa94-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P011323','annual_color_spend' => 800000];
    $newAccountData[] = ['account_id' => 'bbcb21e3-1f97-ff46-2b0d-5d7ab0c96574','type'=> 'Customer Parent','customer_number' => 'P011281','annual_color_spend' => 600000];
    $newAccountData[] = ['account_id' => 'c013f09e-348c-415f-1947-5d7ab0019939','type'=> 'Customer Parent','customer_number' => 'P012474','annual_color_spend' => 1656395];
    $newAccountData[] = ['account_id' => '7e8cde4e-2804-11eb-834a-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P012602','annual_color_spend' => 594701];
    $newAccountData[] = ['account_id' => '72e5a5f5-5192-3bbb-4aa9-5d7ab00f46b6','type'=> 'Customer Parent','customer_number' => 'P013605','annual_color_spend' => 3000000];
    $newAccountData[] = ['account_id' => 'd72706f1-7135-3f10-124a-5d7ab052696d','type'=> 'Customer Parent','customer_number' => 'P016871','annual_color_spend' => 500000];
    $newAccountData[] = ['account_id' => '1346fe10-d4d8-1cfd-d9fe-5d7ab08bfbd4','type'=> 'Customer Parent','customer_number' => 'P010043','annual_color_spend' => 500000];
    $newAccountData[] = ['account_id' => 'e2b33e57-a478-2ef7-03e5-5d7ab0f75409','type'=> 'Customer Parent','customer_number' => 'P012016','annual_color_spend' => 2000000];
    $newAccountData[] = ['account_id' => '866723df-a8e2-c140-8e68-5d7ab094af02','type'=> 'Customer Parent','customer_number' => 'P012364','annual_color_spend' => 1350000];
    $newAccountData[] = ['account_id' => '4c682589-5a7d-8673-3d59-5d7ab0983353','type'=> 'Customer Parent','customer_number' => 'P015583','annual_color_spend' => 7000000];
    $newAccountData[] = ['account_id' => 'e7dbc0d9-8eb2-371c-aba6-5d7ab0d435d1','type'=> 'Customer Parent','customer_number' => 'P016790','annual_color_spend' => 4500000];
    $newAccountData[] = ['account_id' => '88db9397-dc28-23ea-80c0-5d7ab033f697','type'=> 'Customer Parent','customer_number' => 'P011269','annual_color_spend' => 2500000];
    $newAccountData[] = ['account_id' => '51f30da4-30fe-5b63-0884-5d7ab0ca7bfa','type'=> 'Customer Parent','customer_number' => 'P012023','annual_color_spend' => 2900000];
    $newAccountData[] = ['account_id' => '7a4ddba0-02ae-d3ee-89f0-5d7ab04315c1','type'=> 'Customer Parent', 'customer_number' => 'P010312','annual_color_spend' => 3000000];
    $newAccountData[] = ['account_id' => '93fe0200-265b-e14b-dbd4-5d7ab0e9c180','type'=> 'Customer Parent','customer_number' => 'P010527','annual_color_spend' => 1200000];
    $newAccountData[] = ['account_id' => '979e5635-ee41-57cf-518a-5d7ab04baa2b','type'=> 'Customer Parent','customer_number' => 'P010558','annual_color_spend' => 45000000];
    $newAccountData[] = ['account_id' => '0e0e17ae-ac39-11ec-aa94-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P011052','annual_color_spend' => 545500];
    $newAccountData[] = ['account_id' => '7033f198-dc42-1d31-f92e-5d7ab077ff13','type'=> 'Customer Parent','customer_number' => 'P011267','annual_color_spend' => 4000000];
    $newAccountData[] = ['account_id' => 'dbfa2518-8a5f-3185-ef86-5d7ab0b8f1e7','type'=> 'Customer Parent','customer_number' => 'P011620','annual_color_spend' => 7000000];
    $newAccountData[] = ['account_id' => '7133593b-17cf-928f-d02c-5d7ab0e94ef7','type'=> 'Customer Parent','customer_number' => 'P012828','annual_color_spend' => 35000000];
    $newAccountData[] = ['account_id' => '4094a7bd-f2e1-11ea-8626-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P014749','annual_color_spend' => 100000000];
    $newAccountData[] = ['account_id' => 'cbb42de8-7f3b-d947-a7d4-5d7ab07a1ac3','type'=> 'Customer Parent','customer_number' => 'P015936','annual_color_spend' => 800000];
    $newAccountData[] = ['account_id' => '4adc796b-bc9a-3346-9f5c-5d7ab0f7ee11','type'=> 'Customer Parent','customer_number' => 'P016998','annual_color_spend' => 600000];
    $newAccountData[] = ['account_id' => 'a3e81d92-e1d8-95a8-a60f-5d7ab04c2156','type'=> 'Customer Parent','customer_number' => 'P018242','annual_color_spend' => 2900000];
    $newAccountData[] = ['account_id' => '41be2287-f2e1-11ea-8626-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P018742','annual_color_spend' => 700000];
    $newAccountData[] = ['account_id' => '186d5d93-5f7f-11ec-bace-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P018937','annual_color_spend' => 20000000];
    $newAccountData[] = ['account_id' => '27d353e4-5f7f-11ec-bace-00155d160a19','type'=> 'Customer Parent','customer_number' => 'P019134','annual_color_spend' => 650000];

    foreach ($newAccountData as $account) {
        $updateSQL = "
            UPDATE accounts
                    LEFT JOIN
                accounts_cstm ON accounts_cstm.id_c = accounts.id 
            SET 
                accounts_cstm.annual_revenue_potential_c = {$account['annual_color_spend']}
            WHERE
                accounts.id = '{$account['account_id']}' AND accounts_cstm.cust_num_c = '{$account['customer_number']}'
        ";

        $db->query($updateSQL);

        echo "<pre>";
        echo $updateSQL;
        echo "</pre>";
    }

}
