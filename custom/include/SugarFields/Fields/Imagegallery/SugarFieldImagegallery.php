<?php

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldImagegallery extends SugarFieldBase
{

    function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false)
    {
        global $mod_strings, $current_user, $db, $app_list_strings; // APX Custom Codes: added $app_list_strings

        $displayParams['bean_id'] = 'id';
        $record = $_REQUEST['record'];
        $module = $_REQUEST['module'] . "/";

        $crm_path = dirname($_SERVER["SCRIPT_FILENAME"]);
        $crm_path = rtrim($crm_path, '/') . '/';

        $upload_dir = $GLOBALS['sugar_config']['upload_dir'];
        $upload_dir = rtrim($upload_dir, '/') . '/';

        $files_path = $crm_path . $upload_dir . $module;

        $this->ss->assign('PATH', $files_path);
        $this->ss->assign('FIELD_NAME', $vardef['name']);
        $this->ss->assign('FILE_VIEW_PATH', $upload_dir . $module);
        $this->ss->assign('CREATE_NO_ID_ERROR', 'Gallery images can be added once record is saved.');

        // APX Custom Codes: {php} tags are deprecated on latest Smarty template, so moved variable assignment to backend -- START
        $this->ss->assign('APP_LIST_STRINGS', $app_list_strings);
        $this->ss->assign('CURRENT_USER_ID', $current_user->id);
        // APX Custom Codes: {php} tags are deprecated on latest Smarty template, so moved variable assignment to backend -- END

        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch($this->findTemplate('EditView'));
    }

    function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false)
    {
        global $db, $app_list_strings; // APX Custom Codes: added $app_list_strings

        $displayParams['bean_id'] = 'id';
        $record = $_REQUEST['record'];
        $module = $_REQUEST['module'];

        $crm_path = dirname($_SERVER["SCRIPT_FILENAME"]);
        $crm_path = rtrim($crm_path, '/') . '/';

        $upload_dir = $GLOBALS['sugar_config']['upload_dir'];
        $upload_dir = rtrim($upload_dir, '/') . '/';

        $files_path = $crm_path . $upload_dir;
        $file_view_path = $upload_dir;

        $GLOBALS['log']->debug("FilesPath: " . $files_path);
        $GLOBALS['log']->debug("FileViewPath: " . $file_view_path);
		
		$this->ss->assign('GALLERY_LIC', true);
        $this->ss->assign('PATH', $files_path);
        $this->ss->assign('FIELD_NAME', $vardef['name']);
        $this->ss->assign('FILE_VIEW_PATH', $file_view_path);
        $this->ss->assign('MODULE', $module);
        $this->ss->assign('RECORD', $record);

        // APX Custom Codes: {php} tags are deprecated on latest Smarty template, so moved variable assignment to backend -- START
        $this->ss->assign('APP_LIST_STRINGS', $app_list_strings);
        // APX Custom Codes: {php} tags are deprecated on latest Smarty template, so moved variable assignment to backend -- END

		require_once('modules/Imagegallery/license/ImagegalleryOFLicense.php');
		
		$validate_license = ImagegalleryOFLicense::isValid('Imagegallery');
		
		if($validate_license !== true) {
			$this->ss->assign('GALLERY_LIC', false);
			$this->ss->assign('LICENSE_EXPIRED', 'Gallery plugin license has expired.<br > <a href="index.php?module=Imagegallery&action=license">Click here to enter new License Key.</a>');
		
		}
		else{
			// Get Images for this Record
			$select = " SELECT id, tag , file_name
						FROM 
							`cs_multiupload_gallery` 
							WHERE 
								parent_type = '" . $_REQUEST['module'] . "' 
							AND parent_id 	= '" . $_REQUEST['record'] . "' 
							AND field_name 	= '" . $vardef['name'] . "' 
							AND deleted=0 ";

			$GLOBALS['log']->debug($select);
			$rs_sel = $db->query($select);
			$mappings = array();

			if ($rs_sel->num_rows > 0) {
				while ($row = $db->fetchByAssoc($rs_sel)) {
					$mappings[$row['file_name']] = $row['tag'];
				}
			} else {
				$GLOBALS['log']->fatal("No records found for images in DB.");
			}

			$GLOBALS['log']->debug("Mappings : " . print_r($mappings, 1));
			$this->ss->assign('MAPPINGS', $mappings);
		}
		
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch($this->findTemplate('DetailView'));
    }

    function getUserEditView($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false)
    {
        $displayParams['bean_id'] = 'id';
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex, false);
        return $this->fetch($this->findTemplate('UserEditView'));
    }

    function getUserDetailView($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false)
    {
        $displayParams['bean_id'] = 'id';
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex, false);
        return $this->fetch($this->findTemplate('UserDetailView'));
    }

    function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        return $this->getSmartyView($parentFieldArray, $vardef, $displayParams, $tabindex, 'SearchView');
    }

    /* Read uploaded files from folder to save names
    */
    public function save(&$bean, $params, $field, $properties, $prefix = '')
    {
        if (!empty($bean->id)) {
            global $current_user, $db;
			
			 // get updated values for tags
			if(is_array($params[$field])){
				
				foreach ($params[$field] as $key => $image_name) {
					if ($image_name != '') {
						$mapping_save[$params[$field . "_id"][$key]] = $params[$field . "_tag"][$key];

						$save_data[] = array(
							'file_name' => $image_name,
							'file_db_id' => $params[$field . "_id"][$key],
							'file_tag' => $params[$field . "_tag"][$key],
						);
					}
				}
			}
			else{
				$GLOBALS['log']->debug("Params Field is Emtpy");
			}
			// For Backward Compatibility, some versions bean don't set params, we need to check files. 
			if(is_array($_FILES[$field]['name'])){
				
				foreach ($_FILES[$field]['name'] as $key => $image_name) {
					if ($image_name != '') {
						$mapping_save[$params[$field . "_id"][$key]] = $params[$field . "_tag"][$key];

						$save_data[] = array(
							'file_name' => $image_name,
							'file_db_id' => $params[$field . "_id"][$key],
							'file_tag' => $params[$field . "_tag"][$key],
						);
					}
				}
			}
			else{
				$GLOBALS['log']->debug("Files Field is Emtpy");
			}
			
            $field_value = json_encode($save_data);
            $GLOBALS['log']->debug("Save Data Array: " . print_r($save_data, 1));
            $GLOBALS['log']->debug("Save Data Json: " . $field_value);

            // Pull saved values for tags to compare with submitted values for changes
            $select = " SELECT id, tag 
						FROM 
							`cs_multiupload_gallery` 
						WHERE 
							parent_type = '" . $params['module'] . "' 
						AND parent_id 	= '" . $params['record'] . "'  
						AND field_name 	= '" . $field . "' 
						AND deleted = 0 ";

            $rs_sel = $db->query($select);

            if($rs_sel->num_rows > 0)
            {
                while($row_db = $db->fetchByAssoc($rs_sel))
                {
                    $mapping_db[$row_db['id']] = $row_db['tag'];
                }
				
				$difference = array_diff_assoc($mapping_save,$mapping_db);
                
				$GLOBALS['log']->debug("Mapping Difference: ".print_r($difference,1));
				
				if(!empty($difference)){
					foreach($difference as $id=>$tag)
					{
						if($id !='')
						{
							$when .= " WHEN (id ='".$id."') THEN '".$tag."' ";
							$ids .= "'".$id."',";
						}
					}

					// remove last comma
					$ids = substr($ids, 0, -1);

					$update_tags = "
						UPDATE
							`cs_multiupload_gallery`
						SET
							tag = 	CASE
										". $when ."
									END
						WHERE id IN(".$ids.")
						";

					$db->query($update_tags);

					$GLOBALS['log']->debug("UPDATE TAGS: ".$update_tags);
				}
            }
            else{
                $GLOBALS['log']->debug("New Rec no Tags saved...");
            }
			
            $GLOBALS['log']->debug("Gallery Field Value >" . $field_value);
            $bean->$field = $field_value;
        }
    }
}

?>