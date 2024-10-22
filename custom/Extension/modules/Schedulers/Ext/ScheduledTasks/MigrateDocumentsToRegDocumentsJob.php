<?php
// require('include/UploadFile.php');

class MigrateDocumentsToRegDocumentsJob implements RunnableSchedulerJob
{
	public function run($arguments)
	{
		$db =  DBManagerFactory::getInstance();
		
        $GLOBALS['log']->fatal("START OF MIGRATION");
		// GET All Documents related to Regulatory Requests
		$retrieveRegulatoryRequestDocumentsQuery = "
			SELECT 
					rrq_regulatoryrequests.id AS regulatory_request_id,
					rrq_regulatoryrequests.name AS rrq_name,
					documents.id AS document_id,
					documents.document_name,
					documents.active_date AS document_active_date,
					documents.exp_date AS document_exp_date,
					documents.assigned_user_id AS assigned_user_id,
					documents.created_by AS document_created_by,
					documents.modified_user_id AS document_modified_user_id,
					documents.description AS document_description,
					document_revisions.id AS document_revision_id,
					document_revisions.filename AS document_revision_filename,
					document_revisions.*
			FROM
					rrq_regulatoryrequests_documents_1_c
			LEFT JOIN
				rrq_regulatoryrequests ON rrq_regulatoryrequests_documents_1_c.rrq_regulatoryrequests_documents_1rrq_regulatoryrequests_ida = rrq_regulatoryrequests.id
			LEFT JOIN
					documents ON documents.id = rrq_regulatoryrequests_documents_1_c.rrq_regulatoryrequests_documents_1documents_idb
					AND documents.deleted = 0
			LEFT JOIN
					document_revisions ON document_revisions.document_id = documents.id
			WHERE
					rrq_regulatoryrequests.deleted = 0
			AND rrq_regulatoryrequests_documents_1_c.deleted = 0
		";

		$result = $db->query($retrieveRegulatoryRequestDocumentsQuery);

		while ($row = $db->fetchByAssoc($result)) {
			// Get Regulatory Request
			$regulatoryRequestBean = BeanFactory::getBean('RRQ_RegulatoryRequests', $row['regulatory_request_id']);
			

			// Create new Regulatory Documents Bean and copy details from Document Module
			$regDocumentBean = BeanFactory::newBean('RD_RegulatoryDocuments');
			$regDocumentBean->document_name = $row['document_name'];
			$regDocumentBean->filename = $row['filename'];
			$regDocumentBean->status_id = 'Active';
			$regDocumentBean->description = $row['document_description'];
			$regDocumentBean->category_id = 'Other';
			$regDocumentBean->assigned_user_id = $row['assigned_user_id'];
			$regDocumentBean->created_by = $row['document_created_by'];
			$regDocumentBean->modified_by_user_id = $row['document_modified_user_id'];
			$regDocumentBean->exp_date = $row['document_exp_date'];
			$regDocumentBean->save();

			// Load Regulatory Documents Relationship
			$regulatoryRequestBean->load_relationship('rrq_regulatoryrequests_rd_regulatorydocuments_1');
			$regulatoryRequestBean->rrq_regulatoryrequests_rd_regulatorydocuments_1->add($regDocumentBean);

			// UploadFile.php --> duplicate_file($old_id, $new_id, $file_name)
			// Duplicate file from old documents to Regulatory Documents
			UploadFile::duplicate_file($row['document_revision_id'], $regDocumentBean->id, $row['document_revision_filename']);

			// Soft delete the Document row
			$deleteDbInstance =  DBManagerFactory::getInstance();
			$deleteQuery = $deleteDbInstance->query("UPDATE documents SET deleted = 1 WHERE id = '{$row['document_id']}'");

			$GLOBALS['log']->fatal("Migrated Documents from Regulatory Request: {$row['regulatory_request_id']}");
		} // END OF WHILE

		$GLOBALS['log']->fatal("END OF MIGRATION");

		return true;
	}

	public function setJob(SchedulersJob $job)
	{
		$this->job = $job;
	}
}