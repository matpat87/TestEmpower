<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

require_once('service/v4_1/SugarWebServiceUtilv4_1.php');

function Qcmp_beans($a, $b)
{
    global $sugar_web_service_order_by;
    //If the order_by field is not valid, return 0;
    if (empty($sugar_web_service_order_by) || !isset($a->$sugar_web_service_order_by) || !isset($b->$sugar_web_service_order_by)){
        return 0;
    }
    if (is_object($a->$sugar_web_service_order_by) || is_object($b->$sugar_web_service_order_by)
        || is_array($a->$sugar_web_service_order_by) || is_array($b->$sugar_web_service_order_by))
    {
        return 0;
    }
	if (is_string($a->$sugar_web_service_order_by)){
		if (strtoupper($a->$sugar_web_service_order_by) == strtoupper($b->$sugar_web_service_order_by)){
			return 0;
		}
		if (strtoupper($a->$sugar_web_service_order_by) < strtoupper($b->$sugar_web_service_order_by))
		{
			return -1;
		} else {
			return 1;
		}
	}
	else {
		if ($a->$sugar_web_service_order_by == $b->$sugar_web_service_order_by) return 0;
		if ($a->$sugar_web_service_order_by < $b->$sugar_web_service_order_by)
		{
			return -1;
		} else {
			return 1;
		}
	}
}

function Qorder_beans($beans, $field_name)
{
    //Since php 5.2 doesn't include closures, we must use a global to pass the order field to cmp_beans.
    global $sugar_web_service_order_by;
    $sugar_web_service_order_by = $field_name;
    usort($beans, "Qcmp_beans");
    return $beans;
}


class SugarWebServiceUtilquickcrm extends SugarWebServiceUtilv4_1
{

	function get_user_roles($user_id){
		global $sugar_config;
		$db = DBManagerFactory::getInstance();
		
	    $query = "SELECT acl_roles.name,acl_roles.id ".
                "FROM acl_roles ".
                "INNER JOIN acl_roles_users ON acl_roles_users.user_id = '$user_id' ".
                    "AND acl_roles_users.role_id = acl_roles.id AND acl_roles_users.deleted = 0 ".
                "WHERE acl_roles.deleted=0 ";

		if (isset($sugar_config['securitysuite_version'])){
	    	$query .= "UNION " .
				"SELECT acl_roles.name,acl_roles.id " .
				"FROM acl_roles " .
				"INNER JOIN securitygroups_users ON securitygroups_users.user_id = '$user_id' AND  securitygroups_users.deleted = 0 ".
				"INNER JOIN securitygroups_acl_roles ON securitygroups_acl_roles.role_id=acl_roles.id AND securitygroups_users.securitygroup_id = securitygroups_acl_roles.securitygroup_id and securitygroups_acl_roles.deleted = 0 ".
				"WHERE acl_roles.deleted=0";
		}
		
		$result = $db->query($query);

		$roles_names = array();
		$roles_ids = array();
        while($row = $db->fetchByAssoc($result))
        {
            $roles_ids[] = $row['id'];
            $roles_names[] = $row['name'];
        }
        
        return array(
        	'ids' => $roles_ids,
        	'names' => $roles_names,
        );
	}

    public function after_login($user_name, $user, $application,$success)
	{
    	if(file_exists('custom/QuickCRM/after_login.php')){
    		require_once('custom/QuickCRM/after_login.php');
    		QCRM_after_login($user_name, $user, $application,$success);
    	}
	}
		
    public function email2Send($email,$request,$mail_from,$mail_from_name)
    {
        global $mod_strings;
        global $app_strings;
        global $current_user;
        global $sugar_config;
        global $locale;
        global $timedate;
        global $beanList;
        global $beanFiles;

        $OBCharset = $locale->getPrecedentPreference('default_email_charset');

        /**********************************************************************
         * Sugar Email PREP
         */
        /* preset GUID */

        $orignialId = "";
        if (!empty($email->id)) {
            $orignialId = $email->id;
        } // if

        if (empty($email->id)) {
            $email->id = create_guid();
            $email->new_with_id = true;
        }

        /* satisfy basic HTML email requirements */
        $email->name = $request['sendSubject'];
        $email->description_html = '&lt;html&gt;&lt;body&gt;' . $request['sendDescription'] . '&lt;/body&gt;&lt;/html&gt;';

        /**********************************************************************
         * PHPMAILER PREP
         */
        $mail = new SugarPHPMailer();
        $mail = $email->setMailer($mail, '', $request['fromAccount']);
        if (empty($mail->Host) && !$email->isDraftEmail($request)) {
            $email->status = 'send_error';

            if ($mail->oe->type == 'system') {
                echo($app_strings['LBL_EMAIL_ERROR_PREPEND'] . $app_strings['LBL_EMAIL_INVALID_SYSTEM_OUTBOUND']);
            } else {
                echo($app_strings['LBL_EMAIL_ERROR_PREPEND'] . $app_strings['LBL_EMAIL_INVALID_PERSONAL_OUTBOUND']);
            }

            return false;
        }

        $subject = $email->name;
        $mail->Subject = from_html($email->name);

        // work-around legacy code in SugarPHPMailer
        if ($request['setEditor'] == 1) {
            $request['description_html'] = $request['sendDescription'];
            $email->description_html = $request['description_html'];
        } else {
            $email->description_html = '';
            $email->description = $request['sendDescription'];
        }
        // end work-around

        if ($email->isDraftEmail($request)) {
            if ($email->type != 'draft' && $email->status != 'draft') {
                $email->id = create_guid();
                $email->new_with_id = true;
                $email->date_entered = "";
            } // if
            $q1 = "update emails_email_addr_rel set deleted = 1 WHERE email_id = '{$email->id}'";
            $r1 = $email->db->query($q1);
        } // if

        if (isset($request['saveDraft'])) {
            $email->type = 'draft';
            $email->status = 'draft';
            $forceSave = true;
        } else {
            /* Apply Email Templates */
            // do not parse email templates if the email is being saved as draft....
            $toAddresses = $email->email2ParseAddresses($request['sendTo']);
            $sea = new SugarEmailAddress();
            $object_arr = array();

            if (isset($request['parent_type']) && !empty($request['parent_type']) &&
                isset($request['parent_id']) && !empty($request['parent_id']) &&
                ($request['parent_type'] == 'Accounts' ||
                $request['parent_type'] == 'Contacts' ||
                $request['parent_type'] == 'Leads' ||
                $request['parent_type'] == 'Users' ||
                $request['parent_type'] == 'Prospects')) {
                if (isset($beanList[$request['parent_type']]) && !empty($beanList[$request['parent_type']])) {
                    $className = $beanList[$request['parent_type']];
                    if (isset($beanFiles[$className]) && !empty($beanFiles[$className])) {
                        if (!class_exists($className)) {
                            require_once($beanFiles[$className]);
                        }
                        $bean = new $className();
                        $bean->retrieve($request['parent_id']);
                        $object_arr[$bean->module_dir] = $bean->id;
                    } // if
                } // if
            }
            foreach ($toAddresses as $addrMeta) {
                $addr = $addrMeta['email'];
                $beans = $sea->getBeansByEmailAddress($addr);
                foreach ($beans as $bean) {
                    if (!isset($object_arr[$bean->module_dir])) {
                        $object_arr[$bean->module_dir] = $bean->id;
                    }
                }
            }

            /* template parsing */
            if (empty($object_arr)) {
                $object_arr= array('Contacts' => '123');
            }
            $object_arr['Users'] = $current_user->id;
            $email->description_html = EmailTemplate::parse_template($email->description_html, $object_arr);
            $email->name = EmailTemplate::parse_template($email->name, $object_arr);
            $email->description = EmailTemplate::parse_template($email->description, $object_arr);
            $email->description = html_entity_decode($email->description, ENT_COMPAT, 'UTF-8');
            if ($email->type != 'draft' && $email->status != 'draft') {
                $email->id = create_guid();
                $email->date_entered = "";
                $email->new_with_id = true;
                $email->type = 'out';
                $email->status = 'sent';
            }
        }

        if (isset($request['parent_type']) && empty($request['parent_type']) &&
            isset($request['parent_id']) && empty($request['parent_id'])) {
            $email->parent_id = "";
            $email->parent_type = "";
        } // if


        $mail->Subject = $email->name;
        $mail = $email->handleBody($mail);
        $mail->Subject = $email->name;
        $email->description_html = from_html($email->description_html);
        $email->description_html = $email->decodeDuringSend($email->description_html);
        $email->description = $email->decodeDuringSend($email->description);

        /* from account */
        $replyToAddress = $current_user->emailAddress->getReplyToAddress($current_user, true);
        $replyToName = "";
        if (empty($request['fromAccount'])) {
            $defaults = $current_user->getPreferredEmail();
            $mail->From = $defaults['email'];
            isValidEmailAddress($mail->From);
            $mail->FromName = $defaults['name'];
            $replyToName = $mail->FromName;
			$GLOBALS['log']->info('QuickCRM Use default fromAccount '.$mail->From);
        //$replyToAddress = $current_user->emailAddress->getReplyToAddress($current_user);
        } else {
            // passed -> user -> system default
            $ie = BeanFactory::newBean('InboundEmail');
            $ie->retrieve($request['fromAccount']);
            $storedOptions = sugar_unserialize(base64_decode($ie->stored_options));
            $fromName = "";
            $fromAddress = "";
            $replyToName = "";
            //$replyToAddress = "";
            if (!empty($mail_from)) {
                $fromAddress = $mail_from;
                isValidEmailAddress($fromAddress);
                $fromName = $mail_from_name;
            } // if
            else if (!empty($storedOptions)) {
                $fromAddress = $storedOptions['from_addr'];
                isValidEmailAddress($fromAddress);
                $fromName = from_html($storedOptions['from_name']);
                $replyToAddress = (isset($storedOptions['reply_to_addr']) ? $storedOptions['reply_to_addr'] : "");
                $replyToName = (isset($storedOptions['reply_to_name']) ? from_html($storedOptions['reply_to_name']) : "");
            } // if
            $defaults = $current_user->getPreferredEmail();
            // Personal Account doesn't have reply To Name and Reply To Address. So add those columns on UI
            // After adding remove below code

            // code to remove
            if ($ie->is_personal) {
                if (empty($replyToAddress)) {
                    $replyToAddress = $current_user->emailAddress->getReplyToAddress($current_user, true);
                } // if
                if (empty($replyToName)) {
                    $replyToName = $defaults['name'];
                } // if
                //Personal accounts can have a reply_address, which should
                //overwrite the users set default.
                if (!empty($storedOptions['reply_to_addr'])) {
                    $replyToAddress = $storedOptions['reply_to_addr'];
                }
            }
            // end of code to remove
            $mail->From = (!empty($fromAddress)) ? $fromAddress : $defaults['email'];
            isValidEmailAddress($mail->From);
            $mail->FromName = (!empty($fromName)) ? $fromName : $defaults['name'];
            $replyToName = (!empty($replyToName)) ? $replyToName : $mail->FromName;
			$GLOBALS['log']->info('QuickCRM Use system fromAccount '.$mail->From);
        }

        $mail->Sender = $mail->From; /* set Return-Path field in header to reduce spam score in emails sent via Sugar's Email module */
        isValidEmailAddress($mail->Sender);

        if (!empty($replyToAddress)) {
            $mail->AddReplyTo($replyToAddress, $locale->translateCharsetMIME(trim($replyToName), 'UTF-8', $OBCharset));
        } else {
            $mail->AddReplyTo($mail->From, $locale->translateCharsetMIME(trim($mail->FromName), 'UTF-8', $OBCharset));
        } // else
        $emailAddressCollection = array(); // used in linking to beans below
        // handle to/cc/bcc
        foreach ($email->email2ParseAddresses($request['sendTo']) as $addr_arr) {
            if (empty($addr_arr['email'])) {
                continue;
            }

            if (empty($addr_arr['display'])) {
                $mail->AddAddress($addr_arr['email'], "");
            } else {
                $mail->AddAddress(
                    $addr_arr['email'],
                    $locale->translateCharsetMIME(trim($addr_arr['display']), 'UTF-8', $OBCharset)
                );
            }
            $emailAddressCollection[] = $addr_arr['email'];
        }
        foreach ($email->email2ParseAddresses($request['sendCc']) as $addr_arr) {
            if (empty($addr_arr['email'])) {
                continue;
            }

            if (empty($addr_arr['display'])) {
                $mail->AddCC($addr_arr['email'], "");
            } else {
                $mail->AddCC(
                    $addr_arr['email'],
                    $locale->translateCharsetMIME(trim($addr_arr['display']), 'UTF-8', $OBCharset)
                );
            }
            $emailAddressCollection[] = $addr_arr['email'];
        }

        foreach ($email->email2ParseAddresses($request['sendBcc']) as $addr_arr) {
            if (empty($addr_arr['email'])) {
                continue;
            }

            if (empty($addr_arr['display'])) {
                $mail->AddBCC($addr_arr['email'], "");
            } else {
                $mail->AddBCC(
                    $addr_arr['email'],
                    $locale->translateCharsetMIME(trim($addr_arr['display']), 'UTF-8', $OBCharset)
                );
            }
            $emailAddressCollection[] = $addr_arr['email'];
        }


        /* parse remove attachments array */
        $removeAttachments = array();
        if (!empty($request['templateAttachmentsRemove'])) {
            $exRemove = explode("::", $request['templateAttachmentsRemove']);

            foreach ($exRemove as $file) {
                $removeAttachments = substr($file, 0, 36);
            }
        }

        /* handle attachments */
        if (!empty($request['attachments'])) {
            $exAttachments = explode("::", $request['attachments']);

            foreach ($exAttachments as $file) {
                $file = trim(from_html($file));
                $file = str_replace("\\", "", $file);
                if (!empty($file)) {
                    //$fileLocation = $email->et->userCacheDir."/{$file}";
                    $fileGUID = preg_replace('/[^a-z0-9\-]/', "", substr($file, 0, 36));
                    $fileLocation = $email->et->userCacheDir . "/{$fileGUID}";
                    $filename = substr(
                        $file,
                        36,
                        strlen($file)
                    ); // strip GUID	for PHPMailer class to name outbound file

                    $mail->AddAttachment($fileLocation, $filename, 'base64', $email->email2GetMime($fileLocation));
                    //$mail->AddAttachment($fileLocation, $filename, 'base64');

                    // only save attachments if we're archiving or drafting
                    if ((($email->type == 'draft') && !empty($email->id)) || (isset($request['saveToSugar']) && $request['saveToSugar'] == 1)) {
                        $note = BeanFactory::newBean('Notes');
                        $note->id = create_guid();
                        $note->new_with_id = true; // duplicating the note with files
                        $note->parent_id = $email->id;
                        $note->parent_type = $email->module_dir;
                        $note->name = $filename;
                        $note->filename = $filename;
                        $note->file_mime_type = $email->email2GetMime($fileLocation);
                        $dest = "upload://{$note->id}";
                        if (!copy($fileLocation, $dest)) {
                            $GLOBALS['log']->debug("EMAIL 2.0: could not copy attachment file to $fileLocation => $dest");
                        }

                        $note->save();
                    }
                }
            }
        }

        /* handle sugar documents */
        if (!empty($request['documents'])) {
            $exDocs = explode("::", $request['documents']);

            foreach ($exDocs as $docId) {
                $docId = trim($docId);
                if (!empty($docId)) {
                    $doc = BeanFactory::newBean('Documents');
                    $docRev = BeanFactory::newBean('DocumentRevisions');
                    $doc->retrieve($docId);
                    $docRev->retrieve($doc->document_revision_id);

                    $filename = $docRev->filename;
                    $docGUID = preg_replace('/[^a-z0-9\-]/', "", $docRev->id);
                    $fileLocation = "upload://{$docGUID}";
                    $mime_type = $docRev->file_mime_type;
                    $mail->AddAttachment(
                        $fileLocation,
                        $locale->translateCharsetMIME(trim($filename), 'UTF-8', $OBCharset),
                        'base64',
                        $mime_type
                    );

                    // only save attachments if we're archiving or drafting
                    if ((($email->type == 'draft') && !empty($email->id)) || (isset($request['saveToSugar']) && $request['saveToSugar'] == 1)) {
                        $note = BeanFactory::newBean('Notes');
                        $note->id = create_guid();
                        $note->new_with_id = true; // duplicating the note with files
                        $note->parent_id = $email->id;
                        $note->parent_type = $email->module_dir;
                        $note->name = $filename;
                        $note->filename = $filename;
                        $note->file_mime_type = $mime_type;
                        $dest = "upload://{$note->id}";
                        if (!copy($fileLocation, $dest)) {
                            $GLOBALS['log']->debug("EMAIL 2.0: could not copy SugarDocument revision file $fileLocation => $dest");
                        }

                        $note->save();
                    }
                }
            }
        }

        /* handle template attachments */
        if (!empty($request['templateAttachments'])) {
            $exNotes = explode("::", $request['templateAttachments']);
            foreach ($exNotes as $noteId) {
                $noteId = trim($noteId);
                if (!empty($noteId)) {
                    $note = BeanFactory::newBean('Notes');
                    $note->retrieve($noteId);
                    if (!empty($note->id)) {
                        $filename = $note->filename;
                        $noteGUID = preg_replace('/[^a-z0-9\-]/', "", $note->id);
                        $fileLocation = "upload://{$noteGUID}";
                        $mime_type = $note->file_mime_type;
                        if (!$note->embed_flag) {
                            $mail->AddAttachment($fileLocation, $filename, 'base64', $mime_type);
                            // only save attachments if we're archiving or drafting
                            if ((($email->type == 'draft') && !empty($email->id)) || (isset($request['saveToSugar']) && $request['saveToSugar'] == 1)) {
                                if ($note->parent_id != $email->id) {
                                    $email->saveTempNoteAttachments($filename, $fileLocation, $mime_type);
                                }
                            } // if
                        } // if
                    } else {
                        //$fileLocation = $email->et->userCacheDir."/{$file}";
                        $fileGUID = preg_replace('/[^a-z0-9\-]/', "", substr($noteId, 0, 36));
                        $fileLocation = $email->et->userCacheDir . "/{$fileGUID}";
                        //$fileLocation = $email->et->userCacheDir."/{$noteId}";
                        $filename = substr(
                            $noteId,
                            36,
                            strlen($noteId)
                        ); // strip GUID	for PHPMailer class to name outbound file

                        $mail->AddAttachment(
                            $fileLocation,
                            $locale->translateCharsetMIME(trim($filename), 'UTF-8', $OBCharset),
                            'base64',
                            $email->email2GetMime($fileLocation)
                        );

                        //If we are saving an email we were going to forward we need to save the attachments as well.
                        if ((($email->type == 'draft') && !empty($email->id))
                            || (isset($request['saveToSugar']) && $request['saveToSugar'] == 1)
                        ) {
                            $mimeType = $email->email2GetMime($fileLocation);
                            $email->saveTempNoteAttachments($filename, $fileLocation, $mimeType);
                        } // if
                    }
                }
            }
        }


        /**********************************************************************
         * Final Touches
         */
        /* save email to sugar? */
        $forceSave = false;

        if ($email->type == 'draft' && !isset($request['saveDraft'])) {
            // sending a draft email
            $email->type = 'out';
            $email->status = 'sent';
            $forceSave = true;
        } elseif (isset($request['saveDraft'])) {
            $email->type = 'draft';
            $email->status = 'draft';
            $forceSave = true;
        }

        /**********************************************************************
         * SEND EMAIL (finally!)
         */
        $mailSent = false;
        if ($email->type != 'draft') {
            $mail->prepForOutbound();
            $mail->Body = $email->decodeDuringSend($mail->Body);
            $mail->AltBody = $email->decodeDuringSend($mail->AltBody);
            if (!$mail->Send()) {
		        $GLOBALS['log']->fatal('QuickCRM: Email could not be sent from '.$mail->From . ': '.$mail->ErrorInfo);
                $email->status = 'send_error';
                return false;
            }
        }

        if ((!(empty($orignialId) || isset($request['saveDraft']) || ($email->type == 'draft' && $email->status == 'draft'))) &&
            (($request['composeType'] == 'reply') || ($request['composeType'] == 'replyAll') || ($request['composeType'] == 'replyCase')) && ($orignialId != $email->id)) {
            $originalEmail = BeanFactory::newBean('Emails');
            $originalEmail->retrieve($orignialId);
            $originalEmail->reply_to_status = 1;
            $originalEmail->save();
            $email->reply_to_status = 0;
        } // if

        if ($request['composeType'] == 'reply' || $request['composeType'] == 'replyCase') {
            if (isset($request['ieId']) && isset($request['mbox'])) {
                $emailFromIe = BeanFactory::newBean('InboundEmail');
                $emailFromIe->retrieve($request['ieId']);
                $emailFromIe->mailbox = $request['mbox'];
                if (isset($emailFromIe->id) && $emailFromIe->is_personal) {
                    if ($emailFromIe->isPop3Protocol()) {
                        $emailFromIe->mark_answered($email->uid, 'pop3');
                    } elseif ($emailFromIe->connectMailserver() == 'true') {
                        $emailFromIe->markEmails($email->uid, 'answered');
                        $emailFromIe->mark_answered($email->uid);
                    }
                }
            }
        }


        if ($forceSave ||
            $email->type == 'draft' ||
            (isset($request['saveToSugar']) && $request['saveToSugar'] == 1)
        ) {

            // saving a draft OR saving a sent email
            $decodedFromName = mb_decode_mimeheader($mail->FromName);
            $email->from_addr = "{$decodedFromName} <{$mail->From}>";
            $email->from_addr_name = $email->from_addr;
            $email->to_addrs = $request['sendTo'];
            $email->to_addrs_names = $request['sendTo'];
            $email->cc_addrs = $request['sendCc'];
            $email->cc_addrs_names = $request['sendCc'];
            $email->bcc_addrs = $request['sendBcc'];
            $email->bcc_addrs_names = $request['sendBcc'];
            $email->assigned_user_id = $current_user->id;

            $email->date_sent_received = $timedate->now();
            ///////////////////////////////////////////////////////////////////
            ////	LINK EMAIL TO SUGARBEANS BASED ON EMAIL ADDY

            if (isset($request['parent_type']) && !empty($request['parent_type']) &&
                isset($request['parent_id']) && !empty($request['parent_id'])) {
                $email->parent_id = $request['parent_id'];
                $email->parent_type = $request['parent_type'];
                $q = "SELECT count(*) c FROM emails_beans WHERE  email_id = '{$email->id}' AND bean_id = '{$request['parent_id']}' AND bean_module = '{$request['parent_type']}'";
                $r = $email->db->query($q);
                $a = $email->db->fetchByAssoc($r);
                if ($a['c'] <= 0) {
                    if (isset($beanList[$request['parent_type']]) && !empty($beanList[$request['parent_type']])) {
                        $className = $beanList[$request['parent_type']];
                        if (isset($beanFiles[$className]) && !empty($beanFiles[$className])) {
                            if (!class_exists($className)) {
                                require_once($beanFiles[$className]);
                            }
                            $bean = new $className();
                            $bean->retrieve($request['parent_id']);
                            if ($bean->load_relationship('emails')) {
                                $bean->emails->add($email->id);
                            } // if
                        } // if
                    } // if
                } // if
            } else {
                if (!class_exists('aCase')) {
                } else {
                    $c = BeanFactory::newBean('Cases');
                    if ($caseId = InboundEmail::getCaseIdFromCaseNumber($mail->Subject, $c)) {
                        $c->retrieve($caseId);
                        $c->load_relationship('emails');
                        $c->emails->add($email->id);
                        $email->parent_type = "Cases";
                        $email->parent_id = $caseId;
                    } // if
                }
            } // else

            ////	LINK EMAIL TO SUGARBEANS BASED ON EMAIL ADDY
            ///////////////////////////////////////////////////////////////////
            $email->save();
        }

        if (!empty($request['fromAccount'])) {
            if (isset($ie->id) && !$ie->isPop3Protocol() && $mail->oe->mail_smtptype != 'gmail') {
                $sentFolder = $ie->get_stored_options("sentFolder");
                if (!empty($sentFolder)) {
                    // Call CreateBody() before CreateHeader() as that is where boundary IDs are generated.
                    $emailbody = $mail->CreateBody();
                    $emailheader = $mail->CreateHeader();
                    $data = $emailheader . "\r\n" . $emailbody . "\r\n";
                    $ie->mailbox = $sentFolder;
                    if ($ie->connectMailserver() == 'true') {
                        $connectString = $ie->getConnectString($ie->getServiceString(), $ie->mailbox);
                        $returnData = $ie->getImap()->append($connectString, $data, "\\Seen");
                        if (!$returnData) {
                            $GLOBALS['log']->debug("could not copy email to {$ie->mailbox} for {$ie->name}");
                        } // if
                    } else {
                        $GLOBALS['log']->debug("could not connect to mail serve for folder {$ie->mailbox} for {$ie->name}");
                    } // else
                } else {
                    $GLOBALS['log']->debug("could not copy email to {$ie->mailbox} sent folder as its empty");
                } // else
            } // if
        } // if
        return true;
    } // end email2send

	function use_std_search($module_name){
        global $sugar_config;
        
        return ($sugar_config['dbconfig']['db_type'] =='mssql' || (isset($sugar_config['quickcrm_norelatesearch']) && ($sugar_config['quickcrm_norelatesearch']==true || (is_array($sugar_config['quickcrm_norelatesearch']) && (in_array($module_name,$sugar_config['quickcrm_norelatesearch']))))));
	}
	
	function get_name_value_list_for_fields($value, $fields) {
		// add support for function fields (currently aop_case_updates_threaded and reschedule_history only)
		$GLOBALS['log']->info('Begin: SoapHelperWebServices->get_name_value_list_for_fields');
		global $app_list_strings;
		global $sugar_config;
		global $invalid_contact_fields;

		$list = array();
		if(!empty($value->field_defs)){
			if(empty($fields))$fields = array_keys($value->field_defs);
			if(isset($value->assigned_user_name) && in_array('assigned_user_name', $fields)) {
				$list['assigned_user_name'] = $this->get_name_value('assigned_user_name', $value->assigned_user_name);
			}
			if(isset($value->modified_by_name) && in_array('modified_by_name', $fields)) {
				$list['modified_by_name'] = $this->get_name_value('modified_by_name', $value->modified_by_name);
			}
			if(isset($value->created_by_name) && in_array('created_by_name', $fields)) {
				$list['created_by_name'] = $this->get_name_value('created_by_name', $value->created_by_name);
			}

			$filterFields = $this->filter_fields($value, $fields);


			foreach($filterFields as $field){
				if ($field == 'edit_access' || $field == 'delete_access'){
					$list[$field] = $this->get_name_value($field, $value->$field);
					continue;
				}
				if (!isset($value->field_defs[$field])){ // avoid warning for new_with_id
					continue;
				}
				$var = $value->field_defs[$field];
				if(isset($value->{$var['name']})){
					$val = $value->{$var['name']};
					$type = $var['type'];

					if(strcmp($type, 'date') == 0){
						$val = substr($val, 0, 10);
					}
					
					if (isset($var['function']) && !empty($var['function']['returns']) && isset($var['function']['include']) && $var['function']['returns'] == 'html')
						{
							$valid_field = true;
							$GLOBALS['disable_date_format']= false;
							$function = $var['function']['name'];
							$custom_function = false;
							$req_file = $var['function']['include'];
							$_REQUEST[$var['name']] = $value;
							if (!empty($sugar_config['quickcrm_custom_includes'])){
								if (isset($sugar_config['quickcrm_custom_includes'][$req_file])){
									$custom_function = true;
									$req_file = $sugar_config['quickcrm_custom_includes'][$req_file];
								}
							}
							if ($custom_function){
								// OK
							}
							else if ($var['name'] == 'aop_case_updates_threaded'){
								$req_file = 'custom/QuickCRM/Case_Updates.php';
							}
							else if ($var['name'] == 'reminders' && $var['function']['name'] == 'Reminder::getRemindersListView'){
								$req_file = 'custom/QuickCRM/Reminders.php';
								$function = 'getRemindersListView';
							}
							else if ($var['name'] == 'reschedule_history' || substr( $var['name'], 0, 4 ) === "qcrm") {
								// only these function fields are supported	
							}
							else {
								$valid_field = false;
							}
							
							if ($valid_field){
								require_once($req_file);
								if (function_exists($function)){
									$val = $function($value, $var['name'], '', 'DetailView');
								}
							}
							$GLOBALS['disable_date_format']= true;
						}
					
					$list[$var['name']] = $this->get_name_value($var['name'], $val);
				} // if
			} // foreach
		} // if
		$GLOBALS['log']->info('End: SoapHelperWebServices->get_name_value_list_for_fields');
		if ($this->isLogLevelDebug()) {
			$GLOBALS['log']->debug('SoapHelperWebServices->get_name_value_list_for_fields - return data = ' . var_export($list, true));
		} // if
		return $list;

	} // fn

	function checkQuery($errorObject, $query, $order_by = '', $allow_subqueries = false)
    {
        global $sugar_config;
        if ($allow_subqueries && isset($sugar_config['quickcrm_allqueries']) && $sugar_config['quickcrm_allqueries'] == true){
			// !!!
			// !!! USE THAT AT YOUR OWN RISKS
			// !!!
			// !!! SOME CUSTOMIZATIONS REQUIRE COMPLEX WHERE STATEMENTS WITH SUBQUERIES
			// !!! SUBQUERIES ARE PROHIBITED BY include/SugarSQLValidate.php
			// !!! EXCEPT FOR A LIST OF TABLES SUCH AS email_addr_bean_rel
			// !!!
			// !!! SETTING THIS CONFIGURATION VARIABLE WILL ALLOW ANY WHERE CONDITION
			// !!! BUT ONLY IN get_entry_list FUNCTION
			// !!!
        	return true;
    	}
        return parent::checkQuery($errorObject, $query, $order_by);
    }

    function filter_fields($value, $fields)
    {
        // fix bug with one2one or many2one relationship fields not returned
        $GLOBALS['log']->info('Begin: SoapHelperWebServices->filter_fields');
        global $invalid_contact_fields;
        $filterFields = array();
        foreach($fields as $field)
        {
            if (is_array($invalid_contact_fields))
            {
                if (in_array($field, $invalid_contact_fields))
                {
                    continue;
                }
            }
            if (isset($value->field_defs[$field]))
            {
                $var = $value->field_defs[$field];
                //if($var['type'] == 'link') continue;
                if($var['type'] == 'link' && !isset($var['side'])) continue;
                if( isset($var['source'])
                    && ($var['source'] != 'db' && $var['source'] != 'custom_fields' && $var['source'] != 'non-db')
                    && $var['name'] != 'email1' && $var['name'] != 'email2'
                    && (!isset($var['type'])|| $var['type'] != 'relate')) {

                    if( $value->module_dir == 'Emails'
                        && (($var['name'] == 'description') || ($var['name'] == 'description_html') || ($var['name'] == 'from_addr_name')
                            || ($var['name'] == 'reply_to_addr') || ($var['name'] == 'to_addrs_names') || ($var['name'] == 'cc_addrs_names')
                            || ($var['name'] == 'bcc_addrs_names') || ($var['name'] == 'raw_source')))
                    {

                    }
                    else
                    {
                        continue;
                    }
                }
            }
            $filterFields[] = $field;
        }
        $GLOBALS['log']->info('End: SoapHelperWebServices->filter_fields');
        return $filterFields;
    }

	function Qget_name_value($field,$value){
		return $value;
	}
	
	function Qget_return_value_for_link_fields($bean, $module, $link_name_to_value_fields_array) {
		$GLOBALS['log']->info('Begin: SoapHelperWebServices->Qget_return_value_for_link_fields');
		global $module_name, $current_user;
		$module_name = $module;
		if($module == 'Users' && $bean->id != $current_user->id){
			$bean->user_hash = '';
		}
		if(function_exists("clean_sensitive_data")) { // doesn't exist in older versions
			$bean = clean_sensitive_data($bean->field_defs, $bean);
		}

		if (empty($link_name_to_value_fields_array) || !is_array($link_name_to_value_fields_array)) {
			$GLOBALS['log']->debug('End: SoapHelperWebServices->Qget_return_value_for_link_fields - Invalid link information passed ');
			return array();
		}

		if ($this->isLogLevelDebug()) {
			$GLOBALS['log']->debug('SoapHelperWebServices->Qget_return_value_for_link_fields - link info = ' . var_export($link_name_to_value_fields_array, true));
		} // if
		$link_output = array();
		foreach($link_name_to_value_fields_array as $link_name_value_fields) {
			if (!is_array($link_name_value_fields) || !isset($link_name_value_fields['name']) || !isset($link_name_value_fields['value'])) {
				continue;
			}
			$link_field_name = $link_name_value_fields['name'];
			$link_module_fields = $link_name_value_fields['value'];
			if (is_array($link_module_fields) && !empty($link_module_fields)) {

				$bean->load_relationship($link_field_name);
				if (isset($bean->$link_field_name)) {
		            $related_beans = $bean->$link_field_name->get();
		            if (!$related_beans){
						$link_output[] = array('name' => $link_field_name, 'records' => array());
						continue;
		            }
					$rowArray = array();
					foreach($related_beans as $id) {
						$nameValueArray = array();
						$nameValueArray['id'] = $id;
						$rowArray[] = $nameValueArray;
					} // foreach
					$link_output[] = array('name' => $link_field_name, 'records' => $rowArray);
		        }
			} // if
		} // foreach
		$GLOBALS['log']->debug('End: SoapHelperWebServices->Qget_return_value_for_link_fields');
		if ($this->isLogLevelDebug()) {
			$GLOBALS['log']->debug('SoapHelperWebServices->Qget_return_value_for_link_fields - output = ' . var_export($link_output, true));
		} // if
		return $link_output;
	} // fn
	
	function Qget_name_value_list_for_fields($value, $fields) {
		$GLOBALS['log']->info('Begin: SoapHelperWebServices->get_name_value_list_for_fields');
		global $app_list_strings;
		global $invalid_contact_fields;

		$list = array();
		if(!empty($value->field_defs)){
			if(empty($fields))$fields = array_keys($value->field_defs);
			if(isset($value->assigned_user_name) && in_array('assigned_user_name', $fields)) {
				$list['assigned_user_name'] = $this->Qget_name_value('assigned_user_name', $value->assigned_user_name);
			}
			if(isset($value->modified_by_name) && in_array('modified_by_name', $fields)) {
				$list['modified_by_name'] = $this->Qget_name_value('modified_by_name', $value->modified_by_name);
			}
			if(isset($value->created_by_name) && in_array('created_by_name', $fields)) {
				$list['created_by_name'] = $this->Qget_name_value('created_by_name', $value->created_by_name);
			}

			$filterFields = $this->filter_fields($value, $fields);


			foreach($filterFields as $field){
				$var = $value->field_defs[$field];
				if(isset($value->{$var['name']})){
					$val = $value->{$var['name']};
					$type = $var['type'];

					if(strcmp($type, 'date') == 0){
						$val = substr($val, 0, 10);
					}
					
					if (isset($var['function']) && !empty($var['function']['returns']) && isset($var['function']['include']) && $var['function']['returns'] == 'html')
						{
							if ($var['name'] == 'reminders' && $var['function']['name'] == 'Reminder::getRemindersListView'){
								require_once('custom/QuickCRM/Reminders.php');
								$_REQUEST[$var['name']] = $value;
								$val = getRemindersListView($value, $var['name'], '', 'DetailView');
							}
						}

					$list[$var['name']] = $this->Qget_name_value($var['name'], $val);
				} // if
			} // foreach
		} // if
		$GLOBALS['log']->info('End: SoapHelperWebServices->get_name_value_list_for_fields');
		if ($this->isLogLevelDebug()) {
			$GLOBALS['log']->debug('SoapHelperWebServices->get_name_value_list_for_fields - return data = ' . var_export($list, true));
		} // if
		return $list;

	} // fn

	function Qget_return_value_for_fields($value, $module, $fields) {
		$GLOBALS['log']->info('Begin: SoapHelperWebServices->get_return_value_for_fields');
		global $module_name, $current_user;
		$module_name = $module;
		if($module == 'Users' && $value->id != $current_user->id){
			$value->user_hash = '';
		}
		if(function_exists("clean_sensitive_data")) { // doesn't exist in older versions
			$value = clean_sensitive_data($value->field_defs, $value);
		}
		$GLOBALS['log']->info('End: SoapHelperWebServices->get_return_value_for_fields');
		return Array('id'=>$value->id,
					'module_name'=> $module,
					'name_value_list'=>$this->Qget_name_value_list_for_fields($value, $fields)
					);
	}


    /**
     * Equivalent of get_list function within SugarBean but allows the possibility to pass in an indicator
     * if the list should filter for favorites.  Should eventually update the SugarBean function as well.
     *
	 * NS-TEAM : - fix bug with order by 
     */
    function get_data_list_query($seed, $order_by = "", $where = "", $select_fields="", $row_offset = 0, $limit=-1, $max=-1, $show_deleted = 0, $favorites = false,$single_select=false)
	{
		global $sugar_version;
		$GLOBALS['log']->debug("get_list:  order_by = '$order_by' and where = '$where' and limit = '$limit'");
		if(isset($_SESSION['show_deleted']))
		{
			$show_deleted = 1;
		}
		// Fix bug with sort order in get_entry_list
		if ($sugar_version < '6.5.15') {
			$order_by=$seed->process_order_by($order_by, null);
		}
		else {
			if (!empty($order_by)){
				// fix issue where order by date fields does not always return records in the same order for equal dates
				$order_by .= ',id';
			}
		}

		$params = array();
		if(!empty($favorites)) {
		  $params['favorites'] = true;
		}
		
		$single_select = false;
		$filter=array();
		
		if (is_array ($select_fields)){
			foreach ($select_fields as $key=>$value_array) {
				$filter[$value_array]=true;
				//if (isset($seed->field_name_map[$value_array])){
					//if($seed->field_name_map[$value_array]['type'] == 'relate' || $seed->field_name_map[$value_array]['type'] == 'parent'){
					//	$single_select = true;
					//}
				//}
			}
		}
		
		
		$query = $seed->create_new_list_query($order_by, $where,$filter,$params, $show_deleted, '', false, null, $single_select);

		if ($seed->module_name == 'Meetings' && strpos($where, 'm_u.') !== false) // Allow searching participants
			$query = str_replace ('FROM meetings','FROM meetings LEFT JOIN  meetings_users m_u on m_u.meeting_id = meetings.id',$query);
		
		return $query;
	}
	
    function Qget_data_list($seed, $order_by = "", $where = "", $select_fields = "",$row_offset = 0, $limit=-1, $max=-1, $show_deleted = 0, $favorites = false, $single_select = false)
	{
		$query = self::get_data_list_query($seed, $order_by, $where, $select_fields,$row_offset, $limit, $max, $show_deleted, $favorites,$single_select);
		if ($seed->module_name == 'Meetings' && strpos($where, 'm_u.') !== false){ // Allow searching participants
			$query = str_replace ('FROM meetings','FROM meetings LEFT JOIN  meetings_users m_u on m_u.meeting_id = meetings.id',$query);
		}
		else if (strpos($where, $seed->table_name .'.email1') !== false){ // Allow searching email
			$query = str_replace ("FROM ".$seed->table_name,"FROM ".$seed->table_name." LEFT JOIN email_addr_bean_rel eabl  ON eabl.bean_id = ".$seed->table_name.".id AND eabl.bean_module = '" . $seed->module_dir. "' and eabl.primary_address = 1 and eabl.deleted=0 LEFT JOIN email_addresses ea ON (ea.id = eabl.email_address_id)",$query);
			$query = str_replace ($seed->table_name . '.email1','email_address',$query);
		}
		return $seed->process_list_query($query, $row_offset, $limit, $max, $where);
	}
	
    function get_data_list_with_relate_qry($seed, $order_by = "", $where = "", $select_fields ="", $row_offset = 0, $limit=-1, $max=-1, $show_deleted = 0, $favorites = false)
	{
		global $sugar_version;
		//$GLOBALS['log']->debug("get_list:  order_by = '$order_by' and where = '$where' and limit = '$limit'");
		if(isset($_SESSION['show_deleted']))
		{
			$show_deleted = 1;
		}			   

		// Fix bug with sort order in get_entry_list
		if ($sugar_version < '6.5.15') {
			$order_by=$seed->process_order_by($order_by, null);
		}
		else {
			if (!empty($order_by)){
				// fix for app < 6.1.5 (search distinct order by date_modified)
				if(isset($seed->field_name_map['date_modified'])  && is_array ($select_fields) && !in_array('date_modified',$select_fields)){
					$select_fields[] = 'date_modified';
				}
				// fix issue where order by date fields does not always return records in the same order for equal dates
				$order_by .= ',id';
			}
		}

		$single_select = true;
		$filter=array();
		if (is_array ($select_fields)){
			foreach ($select_fields as $key=>$value_array) {
				$filter[$value_array]=true;
				/*
				if (isset($seed->field_name_map[$value_array])){
					if($seed->field_name_map[$value_array]['type'] == 'relate' || $seed->field_name_map[$value_array]['type'] == 'parent'){
						$single_select = true;
					}
				}
				*/
			}
		}
		
		$params = array('distinct'=>true);
		if(!empty($favorites)) {
		  $params['favorites'] = true;
		}
		
		if ($seed->module_name == 'Users' || $seed->module_name == 'Employees') {
			$query = $seed->create_new_list_query($order_by, $where,array(),$params, $show_deleted);
		}
		else {
			$query = $seed->create_new_list_query($order_by, $where,$filter,$params, $show_deleted, '', false, null, true);
		}
		if ($seed->module_name == 'Meetings' && strpos($where, 'm_u.') !== false){ // Allow searching participants
			$query = str_replace ('FROM meetings','FROM meetings LEFT JOIN  meetings_users m_u on m_u.meeting_id = meetings.id',$query);
		}
		else if (strpos($where, $seed->table_name .'.email1') !== false){ // Allow searching email
			$query = str_replace ("FROM ".$seed->table_name,"FROM ".$seed->table_name." LEFT JOIN email_addr_bean_rel eabl  ON eabl.bean_id = ".$seed->table_name.".id AND eabl.bean_module = '" . $seed->module_dir. "' and eabl.primary_address = 1 and eabl.deleted=0 LEFT JOIN email_addresses ea ON (ea.id = eabl.email_address_id)",$query);
			$query = str_replace ($seed->table_name . '.email1','email_address',$query);
		}

		//$GLOBALS['log']->debug("QuickCRM get_list:  $query");
		return $query;
	}
	
    function get_data_list_with_relate($seed, $order_by = "", $where = "", $select_fields ="", $row_offset = 0, $limit=-1, $max=-1, $show_deleted = 0, $favorites = false)
	{
		$query = self::get_data_list_with_relate_qry($seed, $order_by, $where, $select_fields, $row_offset, $limit, $max, $show_deleted, $favorites);
		return $seed->process_list_query($query, $row_offset, $limit, $max, $where);
	}

    function getEmailRelationshipResults($init_array,$bean, $link_field_name, $link_module_fields, $optional_where = '', $order_by = '', $offset = 0, $limit = '') {
        $GLOBALS['log']->info('Begin: SoapHelperWebServices->getEmailRelationshipResults');
		require_once('include/TimeDate.php');
		global $beanList, $beanFiles, $current_user;
		global $disable_date_format, $timedate;
		
		$bean->load_relationship($link_field_name);

		$p = array('link'=>'contacts');
		$GLOBALS['app']->controller->bean = $bean;
		$qry_params = $bean->get_unlinked_email_query(array('return_as_array'=>true), $bean);

		$emails_query = $qry_params['select'] . ' ' . $qry_params['from']. ' ' . $qry_params['join']. ' ' . $qry_params['where'];
		if ($order_by != '') $emails_query .= 'ORDER BY emails.' . $order_by;
		$linked_emails = $GLOBALS['db']->query($emails_query);

		$related_beans= array();
			while($val = $GLOBALS['db']->fetchByAssoc($linked_emails,false))
				{
					$email= new Email();
					$related_beans[$val['id']] = $email->retrieve($val['id']);
				}		


			//First get all the related beans
            $params = array();
            $params['offset'] = $offset;
            $params['limit'] = $limit;

            if (!empty($optional_where))
            {
                $params['where'] = $optional_where;
            }

            //Create a list of field/value rows based on $link_module_fields
			$list = $init_array['rows'];
            $filterFields = $init_array['fields_set_on_rows'];
            if (!empty($order_by) && !empty($related_beans))
            {
                $related_beans = Qorder_beans($related_beans, $order_by);
            }
            foreach($related_beans as $id => $bean)
            {
                if (empty($filterFields) && !empty($link_module_fields))
                {
                    $filterFields = $this->filter_fields($bean, $link_module_fields);
                }
                $row = array();
                foreach ($filterFields as $field) {
                    if (isset($bean->$field))
                    {
                        if (isset($bean->field_defs[$field]['type']) && $bean->field_defs[$field]['type'] == 'date') {
                            $row[$field] = $timedate->to_display_date_time($bean->$field);
                        } else {
                            $row[$field] = $bean->$field;
                        }
                    }
                    else
                    {
                        $row[$field] = "";
                    }
                }
                //Users can't see other user's hashes
                if(is_a($bean, 'User') && $current_user->id != $bean->id && isset($row['user_hash'])) {
                    $row['user_hash'] = "";
                }
				if(function_exists("clean_sensitive_data")) { // doesn't exist in older versions
					$row = clean_sensitive_data($bean->field_defs, $row);
				}
                $list[] = $row;
            }
            $GLOBALS['log']->info('End: SoapHelperWebServices->getEmailRelationshipResults');
            return array('rows' => $list, 'fields_set_on_rows' => $filterFields);

	} // fn
	
    function getAccountsEmailRelationshipResults($bean, $link_field_name, $link_module_fields, $optional_where = '', $order_by = '', $offset = 0, $limit = '') {
        $GLOBALS['log']->info('Begin: SoapHelperWebServices->getAccountsEmailRelationshipResults');
		require_once('include/TimeDate.php');
		global $beanList, $beanFiles, $current_user;
		global $disable_date_format, $timedate;
		
		$bean->load_relationship($link_field_name);

		$p = array('link'=>'contacts');
		$GLOBALS['app']->controller->bean = $bean;
		$qry_params = get_emails_by_assign_or_link($p);

		$emails_query = $qry_params['select'] . ' ' . $qry_params['from']. ' ' . $qry_params['join']. ' ' . $qry_params['where'];
		if ($order_by != '') $emails_query .= 'ORDER BY emails.' . $order_by;
		$linked_emails = $GLOBALS['db']->query($emails_query);

		$related_beans= array();
			while($val = $GLOBALS['db']->fetchByAssoc($linked_emails,false))
				{
					$email= new Email();
					$related_beans[$val['id']] = $email->retrieve($val['id']);
				}		

			//First get all the related beans
            $params = array();
            $params['offset'] = $offset;
            $params['limit'] = $limit;

            if (!empty($optional_where))
            {
                $params['where'] = $optional_where;
            }

            //Create a list of field/value rows based on $link_module_fields
			$list = array();
            $filterFields = array();
            if (!empty($order_by) && !empty($related_beans))
            {
                //$related_beans = Qorder_beans($related_beans, $order_by);
            }
            foreach($related_beans as $id => $bean)
            {
                if (empty($filterFields) && !empty($link_module_fields))
                {
                    $filterFields = $this->filter_fields($bean, $link_module_fields);
                }
                $row = array();
                foreach ($filterFields as $field) {
                    if (isset($bean->$field))
                    {
                        if (isset($bean->field_defs[$field]['type']) && $bean->field_defs[$field]['type'] == 'date') {
                            $row[$field] = $timedate->to_display_date_time($bean->$field);
                        } else {
                            $row[$field] = $bean->$field;
                        }
                    }
                    else
                    {
                        $row[$field] = "";
                    }
                }
				$row['edit_access']= $bean->ACLAccess("EditView");
				$row['delete_access']= $bean->ACLAccess("Delete");
				$filterFields[] = 'edit_access';
				$filterFields[] = 'delete_access';
                //Users can't see other user's hashes
                if(is_a($bean, 'User') && $current_user->id != $bean->id && isset($row['user_hash'])) {
                    $row['user_hash'] = "";
                }
				if(function_exists("clean_sensitive_data")) { // doesn't exist in older versions
					$row = clean_sensitive_data($bean->field_defs, $row);
				}
                $list[] = $row;
            }
            $GLOBALS['log']->info('End: SoapHelperWebServices->getAccountsEmailRelationshipResults');
            return array('total_count'=> count($related_beans),'rows' => $list, 'fields_set_on_rows' => $filterFields);

	} // fn

    function getRelationshipIds($bean, $link_field_name, $link_module_fields, $optional_where = '', $order_by = '', $offset = 0, $limit = '', $with_access_rights=false) {
		// fix bug with sort order and offset
        $GLOBALS['log']->info('Begin: SoapHelperWebServices->getRelationshipResults');
		require_once('include/TimeDate.php');
		global $beanList, $beanFiles, $current_user;
		global $disable_date_format, $timedate;

		$bean->load_relationship($link_field_name);

		if (isset($bean->$link_field_name)) {
			//First get all the related beans
            $params = array();
            //$params['offset'] = $offset;
            //$params['limit'] = $limit;

            if (!empty($optional_where))
            {
                $params['where'] = $optional_where;
            }

            $related_beans = $bean->$link_field_name->getBeans($params);
            //Create a list of field/value rows based on $link_module_fields
			$list = array();
            $filterFields = array();

            foreach($related_beans as $id => $rel_bean)
            {
            	if (!$with_access_rights || $rel_bean->ACLAccess('DetailView')) {
					$row['id']= $rel_bean->id;
    	            $list[] = $row;
                }
            }
            $GLOBALS['log']->info('End: SoapHelperWebServices->getRelationshipIds');
            return array('total_count'=> count($related_beans), 'rows' => $list, 'fields_set_on_rows' => $filterFields);
		} else {
			$GLOBALS['log']->info('End: SoapHelperWebServices->getRelationshipIds - ' . $link_field_name . ' relationship does not exists');
			return false;
		} // else

	} // fn
	
	
    function getRelationshipResults($bean, $link_field_name, $link_module_fields, $optional_where = '', $order_by = '', $offset = 0, $limit = '', $with_access_rights=true) {
		// fix bug with sort order and offset
        $GLOBALS['log']->info('Begin: SoapHelperWebServices->getRelationshipResults');
		require_once('include/TimeDate.php');
		global $beanList, $beanFiles, $current_user, $sugar_config;
		global $disable_date_format, $timedate;
		
		$bugged_version = true;
/* TODO: CHECK WHICH VERSION OF SUITECRM FIXED THE BUG WITH ORDER AND LIMITS
		if (isset($sugar_config['suitecrm_version'])){
			$bugged_version = version_compare($sugar_config['suitecrm_version'], '7.3.2', '<');
		}
*/
		$bean->load_relationship($link_field_name);

		if (isset($bean->$link_field_name)) {
			//First get all the related beans
            $params = array();

            if (!empty($optional_where))
            {
                $params['where'] = $optional_where;
            }

			if (!$bugged_version){
	            $params['offset'] = $offset;
	            $params['limit'] = $limit;

    	        if (!empty($order_by)) {
        	        $params['order_by'] = $order_by;
            	}
            }

            $related_beans = $bean->$link_field_name->getBeans($params);
    		$submodulename = $bean->$link_field_name->getRelatedModuleName();

            //Create a list of field/value rows based on $link_module_fields
			$list = array();
            $filterFields = array();
            if ($bugged_version && !empty($order_by) && !empty($related_beans))
            {
                $order_by_elts = explode(' ', $order_by);
				$related_beans = Qorder_beans($related_beans, $order_by_elts[0]);
				if (isset($order_by_elts[1]) && $order_by_elts[1] =='desc')
					$related_beans = array_reverse($related_beans);
            }
			
            foreach($related_beans as $id => $rel_bean)
            {
 				
				if (!$rel_bean->ACLAccess('DetailView')) continue;
				
				if (empty($filterFields) && !empty($link_module_fields))
                {
                    $filterFields = $this->filter_fields($rel_bean, $link_module_fields);
                }
                
                $row = array();
                foreach ($filterFields as $field) {
                    if (isset($rel_bean->$field))
                    {
                        if (isset($rel_bean->field_defs[$field]['type']) && $rel_bean->field_defs[$field]['type'] == 'date') {
                            $row[$field] = $timedate->to_display_date_time($rel_bean->$field);
                        } else {
                            $row[$field] = $rel_bean->$field;
                        }
                    }
                    else
                    {
                        $row[$field] = "";
                    }
                }
                $row['id']=$rel_bean->id;
                if ($with_access_rights && ($submodulename != 'Users')){
                	// Not needed during Offline Sync
					$row['edit_access']= $rel_bean->ACLAccess("EditView");
					$row['delete_access']= $rel_bean->ACLAccess("Delete");
					$filterFields[] = 'edit_access';
					$filterFields[] = 'delete_access';
				}
                //Users can't see other user's hashes
                if(is_a($rel_bean, 'User') && $current_user->id != $rel_bean->id && isset($row['user_hash'])) {
                    $row['user_hash'] = "";
                }
				if(function_exists("clean_sensitive_data")) { // doesn't exist in older versions
					$row = clean_sensitive_data($rel_bean->field_defs, $row);
				}
                $list[] = $row;
            }
            $GLOBALS['log']->info('End: SoapHelperWebServices->getRelationshipResults');
            return array('total_count'=> count($list), 'rows' => $list, 'fields_set_on_rows' => $filterFields);
		} else {
			$GLOBALS['log']->info('End: SoapHelperWebServices->getRelationshipResults - ' . $link_field_name . ' relationship does not exists');
			return false;
		} // else

	} // fn
	
    function QgetRelationshipResults($bean, $link_field_name, $link_module_fields, $optional_where = '', $order_by = '', $offset = 0, $limit = '') {
		// fix bug with sort order and offset
        $GLOBALS['log']->info('Begin: SoapHelperWebServices->getRelationshipResults');
		require_once('include/TimeDate.php');
		global $beanList, $beanFiles, $current_user;
		global $disable_date_format, $timedate;

		$bean->load_relationship($link_field_name);

		if (isset($bean->$link_field_name)) {
			//First get all the related beans
            $params = array();
            // offset and limits are not used so that sort order can be applied to the full list
            //$params['offset'] = $offset;
            //$params['limit'] = $limit;

            if (!empty($optional_where))
            {
                $params['where'] = $optional_where;
            }

            if (!empty($order_by)) {
                $params['order_by'] = $order_by;
            }

            $related_beans = $bean->$link_field_name->getBeans($params);
            //Create a list of field/value rows based on $link_module_fields
			$list = array();
            $filterFields = array();

/*
            if (!empty($order_by) && !empty($related_beans))
            {
                $count_order = explode(' ', $order_by);
				$order_field = $count_order[0];
				$related_beans = Qorder_beans($related_beans, $order_field);
				if (count($count_order) == 2 && ( strtoupper($count_order[1]) == 'DESC')){
					$related_beans = array_reverse($related_beans);
				}
            }
*/
            foreach($related_beans as $id => $bean)
            {
				if (empty($filterFields) && !empty($link_module_fields))
                {
                    $filterFields = $this->filter_fields($bean, $link_module_fields);
                }
                $row = array();
                foreach ($filterFields as $field) {
                    if (isset($bean->$field))
                    {
                        if (isset($bean->field_defs[$field]['type']) && $bean->field_defs[$field]['type'] == 'date') {
                            $row[$field] = $timedate->to_display_date_time($bean->$field);
                        } else {
                            $row[$field] = $bean->$field;
                        }
                    }
                    else
                    {
                        $row[$field] = "";
                    }
                }
                //Users can't see other user's hashes
                if(is_a($bean, 'User') && $current_user->id != $bean->id && isset($row['user_hash'])) {
                    $row['user_hash'] = "";
                }
				if(function_exists("clean_sensitive_data")) { // doesn't exist in older versions
					$row = clean_sensitive_data($bean->field_defs, $row);
				}
                $list[] = $row;
            }
            $GLOBALS['log']->info('End: SoapHelperWebServices->getRelationshipResults');
            return array('total_count'=> count($related_beans),'rows' => $list, 'fields_set_on_rows' => $filterFields);
		} else {
			$GLOBALS['log']->info('End: SoapHelperWebServices->getRelationshipResults - ' . $link_field_name . ' relationship does not exists');
			return false;
		} // else

	} // fn
	
    public function buildChartImage($chart, array $reportData, array $fields,$asDataURI = true, $generateImageMapId = false){
    	// used only with oldest SuiteCRM version when bug on render call was not fixed
        global $current_user;
        require_once 'modules/AOR_Charts/lib/pChart/pChart.php';

        if($generateImageMapId !== false){
            $generateImageMapId = $current_user->id."-".$generateImageMapId;
        }

        $html = '';
        if(!in_array($chart->type, array('bar','line','pie','radar','rose', 'grouped_bar', 'stacked_bar'))){
            return $html;
        }
        $x = $fields[$chart->x_field];
        $y = $fields[$chart->y_field];
        if(!$x || !$y){
            //Malformed chart object - missing an axis field
            return '';
        }
        $xName = str_replace(' ','_',$x->label) . $chart->x_field;
        $yName = str_replace(' ','_',$y->label) . $chart->y_field;

        $chartData = new pData();
        $chartData->loadPalette("modules/AOR_Charts/lib/pChart/palettes/navy.color", TRUE);
        $labels = array();
        foreach($reportData as $row){
            $chartData->addPoints($row[$yName],'data');
            $chartData->addPoints($row[$xName],'Labels');
            $labels[] = $row[$xName];
        }

        $chartData->setSerieDescription("Months","Month");
        $chartData->setAbscissa("Labels");

        $imageHeight = 700;
        $imageWidth = 700;

        $chartPicture = new pImage($imageWidth,$imageHeight,$chartData);
        if($generateImageMapId){
            $imageMapDir = create_cache_directory('modules/AOR_Charts/ImageMap/'.$current_user->id.'/');
            $chartPicture->initialiseImageMap($generateImageMapId,IMAGE_MAP_STORAGE_FILE,$generateImageMapId,$imageMapDir);
        }

        $chartPicture->Antialias = True;

        $chartPicture->drawFilledRectangle(0,0,$imageWidth-1,$imageHeight-1,array("R"=>240,"G"=>240,"B"=>240,"BorderR"=>0,"BorderG"=>0,"BorderB"=>0,));

        $chartPicture->setFontProperties(array("FontName"=>"modules/AOR_Charts/lib/pChart/fonts/verdana.ttf","FontSize"=>18));

        $chartPicture->drawText($imageWidth/2,20,$chart->name,array("R"=>0,"G"=>0,"B"=>0,'Align'=>TEXT_ALIGN_TOPMIDDLE));
        $chartPicture->setFontProperties(array("FontName"=>"modules/AOR_Charts/lib/pChart/fonts/verdana.ttf","FontSize"=>8));

        $chartPicture->setGraphArea(60,60,$imageWidth-60,$imageHeight-100);

        switch($chart->type){
            case 'radar':
                $chart->buildChartImageRadar($chartPicture, $chartData, !empty($generateImageMapId));
                break;
            case 'pie':
                $chart->buildChartImagePie($chartPicture,$chartData, $reportData,$imageHeight, $imageWidth, $xName, !empty($generateImageMapId));
                break;
            case 'line':
                $chart->buildChartImageLine($chartPicture, !empty($generateImageMapId));
                break;
            case 'bar':
            default:
                $chart->buildChartImageBar($chartPicture, !empty($generateImageMapId));
                break;
        }
        if($generateImageMapId) {
            $chartPicture->replaceImageMapTitle("data", $labels);
        }
        ob_start();
        // BUG in SuiteCRM
        $chartPicture->render(NULL);
        $img = ob_get_clean();
        if($asDataURI){
            return 'data:image/png;base64,'.base64_encode($img);
        }else{
            return $img;
        }
    }

    private function getGroupField($report)
    {

        $sql = "SELECT id FROM aor_fields WHERE aor_report_id = '" . $report->id . "' AND deleted = 0 ORDER BY field_order ASC";
        $result = $report->db->query($sql);

        $fields = array();

        $mainGroupField = null;

        while ($row = $report->db->fetchByAssoc($result)) {

            $field = new AOR_Field();
            $field->retrieve($row['id']);
            if ($field->group_display) {
                return $field;
            }
        }

        return;
    }
    
    public function buildChartHTMLPChart($report,$chart,array $reportData, array $fields,$index = 0,$withRGraph = 0){

		global $sugar_config;

    	if ($withRGraph){
				$mainGroupField = $this->getGroupField($report);
 				$img = $chart->buildChartHTML($reportData,$fields,$index,'rgraph',$mainGroupField);
	 	}
	 	else {
	    	if (version_compare($sugar_config['suitecrm_version'], '7.9.8', '>=') 
    			|| version_compare($sugar_config['suitecrm_version'], '7.8.9', '>=')
    		){
    			// Bug in render function fixed
	 			$imgUri = $chart->buildChartImage($reportData,$fields,true,$index);
			}
    		else {
    			// not fixed. Use our workaround
				$imgUri = $this->buildChartImage($chart,$reportData,$fields,true,$index);
    		}
	        $img = "<img id='{$chart->id}_img' src='{$imgUri}'>";
    	}
        return $img;
    }

    function AOSgetLineItems($focus,$return_as_nvl){
			if($focus->id != '') {
				require_once('modules/AOS_Products_Quotes/AOS_Products_Quotes.php');
				require_once('modules/AOS_Line_Item_Groups/AOS_Line_Item_Groups.php');

				$sql = "SELECT pg.id, pg.group_id FROM aos_products_quotes pg LEFT JOIN aos_line_item_groups lig ON pg.group_id = lig.id WHERE pg.parent_type = '" . $focus->object_name . "' AND pg.parent_id = '" . $focus->id . "' AND pg.deleted = 0 ORDER BY lig.number ASC, pg.number ASC";

				$result = $focus->db->query($sql);
				$line_items=array();
				$groups=array();
				$stored_groups=array();
				while ($row = $focus->db->fetchByAssoc($result)) {
					$line_item = new AOS_Products_Quotes();
					$line_item->retrieve($row['id']);
					$line_item = $return_as_nvl ? self::get_name_value_list_for_fields($line_item, "") : self::Qget_name_value_list_for_fields($line_item, "");

					$group_item = 'null';
					if ($row['group_id'] != null) {
						$group_item = new AOS_Line_Item_Groups();
						$group_item->retrieve($row['group_id']);
						$group_item = $return_as_nvl ? self::get_name_value_list_for_fields($group_item, "") : self::Qget_name_value_list_for_fields($group_item, "");
						if (!in_array($row['group_id'],$stored_groups)){
							$groups[] = $group_item;
							$stored_groups[]=$row['group_id'];
						}
					}
					$line_items[]=$line_item;

				}
				return array('lineitems' =>$line_items,'groups'=>$groups);
			}
			else return array('lineitems' => array() ,'groups'=>array());
	}
}