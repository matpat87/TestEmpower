<?php

//OnTrack #563 - Email Validation
$dictionary['Contact']['fields']['alternate_email_c']['validation'] = array(
    'type' => 'callback',
    'callback' => 'function(formname, nameIndex) {
        var result = false;
        var val = document.forms[formname][nameIndex].value;
        
        if(val != "" && validateEmail(val) == null){
            add_error_style(formname, nameIndex, "Invalid Alternate Email");
            result = false;
        }
        else{
            result = true;
        }

      return result;
    }'
  );

?>