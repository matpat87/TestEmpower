<?php

require_once('include/SugarFields/Fields/File/SugarFieldFile.php');
class SugarFieldCstmfile extends SugarFieldFile {

	public function fetch($path){
			$fileName = end(explode('/', $path));
			$fileType = array_shift(explode('View', $fileName));
			$errorMessage = "<p class='error'>File Field: Invalid <a href='index.php?module=Preview_Image_files&action=license&checklicense=file-field' >license</a></p>";

            // APX Custom Codes: {php} tags are deprecated on latest Smarty template, so no need for else statement -- START
            require_once('modules/FileField/license/OutfittersLicense.php');

            if (FFOutfittersLicense::isValid('FileField') !== true) {
                return $errorMessage;
            } else {
                return parent::fetch($path);
            }
            // APX Custom Codes: {php} tags are deprecated on latest Smarty template, so no need for else statement -- END
	}


    public function getListViewSmarty($parentFieldArray, $vardef, $displayParams, $col)
    {
        if (isset($displayParams['module']) && !empty($displayParams['module'])) {
            $this->ss->assign("module", $displayParams['module']);
        } else {
            $this->ss->assign("module", $_REQUEST['module']);
        }
        if ( !isset($vardef['fileId']) ) {
            if ( isset($displayParams['id']) ) {
	            $vardef['fileId'] = $displayParams['id'];
            } else {
    	        $vardef['fileId'] = 'id';
           	}
        }
        if ( !isset($displayParams['preview']) ) {
			$displayParams['preview'] = true;
        }
        return parent::getListViewSmarty($parentFieldArray, $vardef, $displayParams, $col);
    }


    public function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $col)
    {
        global $sugar_config, $app_strings;
        $this->ss->assign("allow_drag_and_drop", isset($sugar_config['allow_drag_and_drop']) && $sugar_config['allow_drag_and_drop']);
        return parent::getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $col);
    }

    private function fillInOptions(&$vardef, &$displayParams)
    {
        if (isset($vardef['allowEapm']) && $vardef['allowEapm'] == true) {
            if (empty($vardef['docType'])) {
                $vardef['docType'] = 'doc_type';
            }
            if (empty($vardef['docId'])) {
                $vardef['docId'] = 'doc_id';
            }
            if (empty($vardef['docUrl'])) {
                $vardef['docUrl'] = 'doc_url';
            }
        } else {
            $vardef['allowEapm'] = false;
        }
        // Override the default module
        if (isset($vardef['linkModuleOverride'])) {
            $vardef['linkModule'] = $vardef['linkModuleOverride'];
        } else {
            $vardef['linkModule'] = '{$module}';
        }
        // This is needed because these aren't always filled out in the edit/detailview defs
        if (!isset($vardef['fileId'])) {
            if (isset($displayParams['id'])) {
                $vardef['fileId'] = $displayParams['id'];
            } else {
                $vardef['fileId'] = 'id';
            }
        }

    }

    public function save(&$bean, $params, $field, $vardef, $prefix = '')
    {

		require_once('modules/FileField/license/OutfittersLicense.php');
		if (FFOutfittersLicense::isValid('FileField') !== true) {
			return;
		}

        $fakeDisplayParams = array();
        $this->fillInOptions($vardef, $fakeDisplayParams);

        require_once('include/upload_file.php');
        $upload_file = new UploadFile($prefix . $field . '_file');
        //remove file
        if (isset($_REQUEST['remove_file_' . $field]) && $params['remove_file_' . $field] == 1) {
            $upload_file->unlink_file($bean->$field);
            $bean->$field = "";
        }

        $move = false;
        if (isset($_FILES[$prefix . $field . '_file']) && $upload_file->confirm_upload()) {
                $bean->$field = $upload_file->get_stored_file_name();
                $move = true;
        }

        if (empty($bean->id)) {
            $bean->id = create_guid();
            $bean->new_with_id = true;
        }

        if ($move) {
            $upload_file->final_move($bean->id . '_' . $field); //BEAN ID IS THE FILE NAME IN THE INSTANCE.

            $docType = isset($vardef['docType']) && isset($params[$prefix . $vardef['docType']]) ?
                $params[$prefix . $vardef['docType']] : '';
            $upload_file->upload_doc($bean, $bean->id, $docType, $bean->$field, $upload_file->mime_type);
        } else {
            if (!empty($old_id)) {
                // It's a duplicate, I think

                if (empty($params[$prefix . $vardef['docUrl']])) {
                    $upload_file->duplicate_file($old_id, $bean->id, $bean->$field);
                } else {
                    $docType = $vardef['docType'];
                    $bean->$docType = $params[$prefix . $field . '_old_doctype'];
                }
            } else {
                if (!empty($params[$prefix . $field . '_remoteName'])) {
                    // We aren't moving, we might need to do some remote linking
                    $displayParams = array();
                    $this->fillInOptions($vardef, $displayParams);

                    if (isset($params[$prefix . $vardef['docId']])
		                && !empty($params[$prefix . $vardef['docId']])
        		        && isset($params[$prefix . $vardef['docType']])
                		&& !empty($params[$prefix . $vardef['docType']])
            		) {
                        $bean->$field = $params[$prefix . $field . '_remoteName'];

                        require_once('include/utils/file_utils.php');
                        $extension = get_file_extension($bean->$field);
                        if (!empty($extension)) {
                            $bean->file_ext = $extension;
                            $bean->file_mime_type = get_mime_content_type_from_filename($bean->$field);
                        }
                    }
                }
            }
        }

    }
}