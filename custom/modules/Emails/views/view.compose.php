<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die ('Not A Valid Entry Point');
}

require_once('modules/Emails/views/view.compose.php');

class CustomEmailsViewCompose extends EmailsViewCompose
{
    public function display()
    {
        $this->setDefaultEmailTemplate();
        parent::display();
        $this->handleAttachDocument();
    }

    private function setDefaultEmailTemplate()
    {
        $emailTemplateBean = (isset($_REQUEST['email_template_id']) && $_REQUEST['email_template_id'])
            ? BeanFactory::getBean('EmailTemplates', $_REQUEST['email_template_id'])
            : BeanFactory::newBean('EmailTemplates');

        if ($emailTemplateBean && $emailTemplateBean->id) {
            $this->bean->emails_email_templates_name = $emailTemplateBean->name;
            $this->bean->emails_email_templates_idb = $emailTemplateBean->id;
            $this->bean->name = $emailTemplateBean->subject;
            $this->bean->description = $emailTemplateBean->body;
            $this->bean->description_html = $emailTemplateBean->body_html;
        }
    }

    private function handleAttachDocument()
    {
        if (isset($_REQUEST['document_id']) && $_REQUEST['document_id']) {
            $newId = create_guid();
            $documentBean = BeanFactory::getBean('Documents', $_REQUEST['document_id']);

            if (! $documentBean->id) {
                return;
            }

            echo '<script>
                jQuery(() => {
                    // Attach TR Document once Email Compose page is initialized
                    jQuery(`.document-attachments`).append(`
                        <div class="attachment-group-container">
                            <input type="hidden" id="file_'.$newId.'" name="documentId0" data-file-input="documentId" value="'.$documentBean->id.'"><label for="file_'.$newId.'" class="">
                            <div class="attachment-file-container">
                                <span class="attachment-name"> '.$documentBean->name.' </span></div></label><a class="attachment-remove"><span class="glyphicon glyphicon-remove"></span></a>
                        </div>
                        <input type="hidden" name="document_attachment_id" value="'.$documentBean->id.'">
                        <input type="hidden" name="document_attachment_name" value="'.$documentBean->name.'">
                    `);

                    // Set to zero so on first run it forces all attachment-remove buttons to have custom click features
                    let currentAttachmentRemoveButtonCount = 0;
                    
                    setInterval(() => {
                        let newAttachmentRemoveButtonCount = jQuery(`.attachment-remove`).length;

                        // If attachment button counters are not equal, update all buttons to have custom click features
                        if (currentAttachmentRemoveButtonCount != newAttachmentRemoveButtonCount) {
                            
                            // Use function() {} instead of () => {} as it does not seem to work on click
                            jQuery(`.attachment-remove`).on(`click`, function() {
                                jQuery(this).closest(`.attachment-group-container`).remove();
                                jQuery(this).closest(`input[name="document_attachment_id"]`).remove();
                                jQuery(this).closest(`input[name="document_attachment_name"]`).remove();
        
                                if (jQuery(`.document-attachments`).find(`.attachment-group-container`).length === 0) {
                                    jQuery(`.document-attachments`).empty();
                                }
                            });
                            
                            currentAttachmentRemoveButtonCount = newAttachmentRemoveButtonCount;
                        }
                    }, 100);
                });
            </script>';
        }
    }
}
