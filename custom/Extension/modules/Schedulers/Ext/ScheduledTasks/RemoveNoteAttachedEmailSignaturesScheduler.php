<?php  
  $job_strings[] = 'RemoveNoteAttachedEmailSignaturesScheduler';

  function RemoveNoteAttachedEmailSignaturesScheduler() {
    global $db, $log;
    
    $log->fatal("Remove Note Attached Email Signatures Scheduler - START");
    
    // Set as array in the event that there are other Email Signature file extensions that can be added in the future
    $imageFileTypes = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'jfif', 'pjpeg', 'pjp', 'avif', 'apng', 'bmp', 'ico', 'cur', 'tif', 'tiff', 'heic'];
    
    if (isset($imageFileTypes) && count($imageFileTypes) > 0) {
      foreach ($imageFileTypes as $name) {
        // Fetch via DB Query as get_full_List kills scheduler process
        $sql = "SELECT notes.id, notes.filename FROM notes WHERE notes.deleted = 0 AND notes.parent_type = 'Emails' AND notes.name LIKE '%{$name}%' ORDER BY notes.name ASC";
        $result = $db->query($sql);

        $ctr = 0;

        while ($row = $db->fetchByAssoc($result)) {
          $explodedFileName = explode('.', $row['filename']);
          $fileExtension = isset($explodedFileName) && count($explodedFileName) > 0 ? $explodedFileName[1] : '';

          // Skip if file extension is not in list of accepted image file types
          if (! in_array($fileExtension, $imageFileTypes)) {
            continue;
          }

          $fileLocation = "upload://{$row['id']}"; // Attached file location
          
          // If file exists and size is greater than 50KB, skip process as it may not be a signature
          if (file_exists($fileLocation) && filesize($fileLocation) > 50000) {
            continue;
          }

          // Set Note to deleted = 1
          $softDeleteSQL = "UPDATE notes SET notes.deleted = 1 WHERE notes.id = '{$row['id']}' AND notes.deleted = 0";
          $db->query($softDeleteSQL);
          
          // Set Security Group relationship to deleted = 1 
          $softDeleteSecurityGroupLinkSQL = "UPDATE securitygroups_records SET securitygroups_records.deleted = 1 WHERE securitygroups_records.record_id = '{$row['id']}' AND securitygroups_records.deleted = 0";
          $db->query($softDeleteSecurityGroupLinkSQL);

          // Remove file from upload directory
          // Ex. upload://{record_id}
          unlink($fileLocation);
          
          $ctr++;
        }

        $log->fatal("Number of deleted {$name} records: {$ctr}");
      }
    }

    $log->fatal("Remove Note Attached Email Signatures Scheduler - END");
    
    return true;
  }