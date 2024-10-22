<?php
 if(!defined('sugarEntry'))define('sugarEntry', true);

// To Make SugarConfig Available 

require_once('include/entryPoint.php');

// Upload files on selection
$module 			= $_POST['module'];
$current_user 		= $_POST['current_user'];

$folder_permission  = 0777;
$file_permission  	= 0755;

$install_path 	= dirname(__FILE__);
// Make sure path has slash in the end 
$install_path	= rtrim($install_path, '/') . '/';

$upload_dir 	= $sugar_config['upload_dir'];
$upload_dir		= rtrim($upload_dir, '/') . '/';

if( isset($_FILES['fileToUpload']) && (count($_FILES['fileToUpload']['name']) > 0))
{
	// Check/Create File Upload Directory
	$record_id 		= $_REQUEST['record_id'];
	$field_name 	= $_REQUEST['file_input_id'];
	$uploaddir		= $install_path.$upload_dir.$module."/".$record_id."/".$field_name;
	// If Path does not exist, create one 
	if (!is_dir($uploaddir)) {
		if(!mkdir($uploaddir , $folder_permission , true))
		{
			die(json_encode("#Failed to Create Dir at ". $uploaddir));
		}
	}
	
	$file_name		= $_FILES['fileToUpload']['name'][0];
	$tmp_name		= $_FILES['fileToUpload']['tmp_name'][0];

	if(!file_exists($uploaddir."/".$file_name))
	{ 
		move_uploaded_file($tmp_name, $uploaddir."/".$file_name);
		// Change file permission
		chmod($uploaddir."/".$file_name, $file_permission);

		$msg = "#UPLOADED SUCCESS# Uploaded to: ".$uploaddir;

		$reply = array(
						'msg'=> $msg,
						'status' => true
			);

		// Insert Record into Gallery Table
		$id =  create_guid();
	
		$create_record = "INSERT INTO 
							`cs_multiupload_gallery` 
						(
						  `id`,
						  `date_entered`,
						  `date_modified`,
						  `modified_user_id`,
						  `created_by`,
						  `parent_type`,
						  `parent_id`,
						  `field_name`,
						  `file_name`
						  )
						 VALUES(
							'".$id."',
							NOW(),
							NOW(),
							'".$current_user."',
							'".$current_user."',
							'".$module."',
							'".$record_id."',
							'".$field_name."',
							'".$file_name."'
						 )";

		$GLOBALS['db']->query($create_record);

		$GLOBALS['log']->fatal($create_record);

		$reply['id'] = $id;
	}
	else{
		$reply = array(
						'msg'=> "File name ".$file_name." already exists at destination",
						'status' => false
			);
	}
	
	echo json_encode($reply);
	
}


// Remove File
if($_POST['delete'] != '')
{
	$remove_id = $_POST['field_id'];
	$user_id = $_POST['user_id'];
	
	$select_rec = "	SELECT 
					  `parent_type`,
					  `parent_id`,
					  `field_name`,
					  `file_name` 
				   	FROM 
				   		`cs_multiupload_gallery` 
					WHERE 
						id ='".$remove_id ."' 
					AND deleted = 0 ";
	$remove_rs = $GLOBALS['db']->query($select_rec);
	
	if($remove_rs->num_rows > 0)
	{
		$remove_row = $GLOBALS['db']->fetchByAssoc($remove_rs);

		// Delete File from uploaded folder 
		$file_path = $install_path.$upload_dir."/".$remove_row['parent_type']."/".$remove_row['parent_id'].'/'.$remove_row['field_name'].'/'.$remove_row['file_name'];

		if(file_exists($file_path))
		{
			unlink($file_path);	
			// DELETE record entry
			$delete_rec = " UPDATE
								`cs_multiupload_gallery` 
							SET  
								deleted =1,
								date_modified = NOW(),
								modified_user_id = ".$user_id."
							WHERE 
								id ='".$remove_id ."'";
			$GLOBALS['db']->query($delete_rec);
	
			echo json_encode("#FILE DELETED# PATH = " . $file_path);
		}
		else{
			echo json_encode("#FILE DOES NOT EXISTS. PATH = " . $file_path);
			
		}
	}else{
		echo json_encode("#FILE ID PROVIDED IS NOT CORRECT.");
	}
}

?>