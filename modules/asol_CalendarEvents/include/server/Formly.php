<?php
/**
 * @author AlineaSol
 */
class asol_Formly {
	static public $calendarevents_id 		= "asol_CalendarEvents";
	static public $calendarevents_table 	= "asol_calendarevents";
	/**
	 * @method It generates the form rendered into calendar view
	 * @param string $type
	 * @param string $id
	 * @return string
	 */
	static public function generateForm($type, $id) {
		require_once ("modules/asol_CalendarEvents/include/server/models/configCRUD.php");
		
		$html = "";
		$model = new asol_CalendarEvents ();
		$custom_fields = $model->field_defs;
		$structure = asol_ConfigCRUD::getStructure ();
		
		$html .= "<form><fieldset>";
		
		$html .= self::fixedFields ( $type, $structure, $id );
		
		$html .= self::customFields ( $type, $custom_fields, $structure );
		
		$html .= self::lastFixedFields ();
		
		$html .= "</fieldset></form>";
		
		return $html;
	}
	/**
	 * @method Insert the custom fields inputs inside the form
	 * @param string $type
	 * @param array $custom_fields
	 * @param array $structure
	 * @return string
	 */
	private function customFields($type, $custom_fields, $structure) {
		require_once ("modules/asol_CalendarEvents/include/server/models/modelFormly.php");
		
		global $app_list_strings;
		
		$html = "";
		
		foreach ( $structure [$type] ['customFields'] as $key => $value ) {
			
			switch ($custom_fields [$value] ['type']) {
				case 'varchar' :
					
					$html .= '<div class="inputForm">';
					$array = array (
							"attributes" => array (
									"for" => $value,
									"class" => "textInputLabel" 
							) 
					);
					$html .= asol_ModelFormly::Label ( $array ["attributes"], translate ( $custom_fields [$value] ['vname'], self::$calendarevents_id ) );
					$array = array (
							"attributes" => array (
									"id" => $value,
									"class" => "text ui-widget-content ui-corner-all inputText",
									"type" => "text",
									"name" => $value,
									"value" => "" 
							) 
					);
					$html .= asol_ModelFormly::Input ( $array ["attributes"] );
					$html .= '</div>';
					break;
				
				case 'text' :
					
					$html .= '<div class="inputForm">';
					$array = array (
							"attributes" => array (
									"for" => $value,
									"class" => "textInputLabel" 
							) 
					);
					$html .= asol_ModelFormly::Label ( $array ["attributes"], translate ( $custom_fields [$value] ['vname'], self::$calendarevents_id ) );
					$array = array (
							"attributes" => array (
									"id" => $value,
									"class" => "textAreaInput" 
							) 
					);
					$html .= asol_ModelFormly::TextArea ( $array ["attributes"], "" );
					$html .= '</div>';
					break;
				
				case 'bool' :
					
					$html .= '<div class="inputForm">';
					$array = array (
							"attributes" => array (
									"id" => $value,
									"class" => "inputCheckbox",
									"type" => "checkbox",
									"name" => $value,
									"value" => "" 
							) 
					);
					$html .= asol_ModelFormly::Input ( $array ["attributes"] );
					$array = array (
							"attributes" => array (
									"for" => $value,
									"class" => "checkBoxInputLabel" 
							) 
					);
					$html .= asol_ModelFormly::Label ( $array ["attributes"], translate ( $custom_fields [$value] ['vname'], self::$calendarevents_id ) );
					$html .= '</div>';
					break;
				
				case 'date' :
					
					$html .= '<div class="inputForm">';
					$array = array (
							"attributes" => array (
									"for" => $value,
									"class" => "textInputLabel" 
							) 
					);
					$html .= asol_ModelFormly::Label ( $array ["attributes"], translate ( $custom_fields [$value] ['vname'], self::$calendarevents_id ) );
					$array = array (
							"attributes" => array (
									"id" => $value,
									"class" => "text ui-widget-content ui-corner-all inputText datePicker",
									"type" => "text",
									"name" => $value,
									"placeholder" => "YYYY-MM-DD",
									"value" => "" 
							) 
					);
					$html .= asol_ModelFormly::Input ( $array ["attributes"] );
					$html .= '</div>';
					break;
				
				case 'enum' :
					
					$html .= '<div class="inputForm">';
					$array = array (
							"attributes" => array (
									"for" => $value,
									"class" => "textInputLabel" 
							) 
					);
					$html .= asol_ModelFormly::Label ( $array ["attributes"], translate ( $custom_fields [$value] ['vname'], self::$calendarevents_id ) );
					$options = array ();
					foreach ( $app_list_strings [$custom_fields [$value] ['options']] as $optionKey => $optionValue ) {
						$options [str_replace ( " ", "_", $optionKey )] = $optionValue;
					}
					$array = array (
							"attributes" => array (
									"id" => $value,
									"class" => "ui-widget-content ui-state-default selectJqueryStyle" 
							),
							"options" => $options 
					);
					$html .= asol_ModelFormly::Select ( $array ["attributes"], $array ["options"] );
					$html .= '</div>';
					break;
				
				case 'multienum' :
					
					$html .= '<div class="inputForm">';
					$array = array (
							"attributes" => array (
									"for" => $value,
									"class" => "textInputLabel" 
							) 
					);
					$html .= asol_ModelFormly::Label ( $array ["attributes"], translate ( $custom_fields [$value] ['vname'], self::$calendarevents_id ) );
					$options = array ();
					foreach ( $app_list_strings [$custom_fields [$value] ['options']] as $optionKey => $optionValue ) {
						$options [str_replace ( " ", "_", $optionKey )] = $optionValue;
					}
					$array = array (
							"attributes" => array (
									"id" => $value,
									"class" => "multiselect",
									"multiple" => "multiple" 
							),
							"options" => $options 
					);
					$html .= asol_ModelFormly::Select ( $array ["attributes"], $array ["options"] );
					$html .= '</div>';
					break;
				
				case 'radioenum' :
					
					$name = $custom_fields [$value] ['name'];
					foreach ( $app_list_strings [$custom_fields [$value] ['options']] as $radioKey => $radioValue ) {
						$html .= '<div class="inputForm">';
						$array = array (
								"attributes" => array (
										"id" => $value,
										"class" => "inputCheckbox",
										"type" => "radio",
										"name" => $name,
										"value" => $key 
								) 
						);
						$html .= asol_ModelFormly::Input ( $array ["attributes"] );
						$array = array (
								"attributes" => array (
										"for" => $value,
										"class" => "checkBoxInputLabel" 
								) 
						);
						$html .= asol_ModelFormly::Label ( $array ["attributes"], $value );
						$html .= '</div>';
					}
					break;
			}
		}
		return $html;
	}
	/**
	 * @method Insert the last fixed fields into the form (WFM multiselect and CKEditor)
	 * @return string
	 */
	private function lastFixedFields() {
		require_once ("modules/asol_CalendarEvents/include/server/models/modelFormly.php");
		require_once ("modules/asol_CalendarEvents/include/server/calendarUtils.php");
		require_once ("modules/asol_Common/include/commonUtils.php");
		
		$html = "";
		
		// ////////////////////////////////////////////////////////////////////
		
		if (asol_CommonUtils::isWFMInstalled ()) {
			$workflows = asol_CalendarUtils::getWorkflows ();
			if (! empty ( $workflows )) {
				$html .= '<div class="inputWorkflow">';
				$array = array (
						"attributes" => array (
								"for" => "workflow",
								"class" => "textInputLabel" 
						) 
				);
				$html .= asol_ModelFormly::Label ( $array ["attributes"], asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_WORKFLOW' ) );
				$options = array ();
				foreach ( $workflows as $key => $value ) {
					$options [$key] = $value;
				}
				$array = array (
						"attributes" => array (
								"id" => "workflow",
								"class" => "multiselect",
								"multiple" => "multiple" 
						),
						"options" => $options 
				);
				$html .= asol_ModelFormly::Select ( $array ["attributes"], $array ["options"] );
				$html .= '</div>';
			}
		}
		
		// ////////////////////////////////////////////////////////////////////
		
		// ////////////////////////////////////////////////////////////////////
		
		$html .= '<hr>';
		
		// ////////////////////////////////////////////////////////////////////
		
		$html .= '<div class="inputInfo">';
		$array = array (
				"attributes" => array (
						"for" => "info",
						"class" => "textInputLabel" 
				) 
		);
		$html .= asol_ModelFormly::Label ( $array ["attributes"], asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_DESCRIPTION' ) );
		$array = array (
				"attributes" => array (
						"id" => "info",
						"class" => "textAreaInput" 
				) 
		);
		$html .= asol_ModelFormly::TextArea ( $array ["attributes"], "" );
		$html .= '</div>';
		
		// ////////////////////////////////////////////////////////////////////
		
		return $html;
	}
	/**
	 * @method Insert all the needed fields into the form
	 * @param string $type
	 * @param string $structure
	 * @param string $id
	 * @return string
	 */
	private function fixedFields($type, $structure, $id) {
		require_once ("modules/asol_CalendarEvents/include/server/models/modelFormly.php");
		require_once ("modules/asol_CalendarEvents/include/server/calendarUtils.php");
		require_once ("modules/asol_Common/include/commonUtils.php");
		
		$html = "";
		
		// ////////////////////////////////////////////////////////////////////
		
		$html .= '<div class="titleCategory"></div>';
		
		// ////////////////////////////////////////////////////////////////////
		
		// ////////////////////////////////////////////////////////////////////
		
		$html .= '<div class="inputTitle">';
		$array = array (
				"attributes" => array (
						"for" => "title",
						"class" => "textInputLabel" 
				) 
		);
		$html .= asol_ModelFormly::Label ( $array ["attributes"], asol_CalendarEvents::translateCalendarLabel ( "LBL_FORM_EVENT_TITLE" ) );
		$array = array (
				"attributes" => array (
						"id" => "title",
						"class" => "text ui-widget-content ui-corner-all inputText",
						"type" => "text",
						"name" => "title",
						"placehodler" => asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_EXAMPLE_TITLE' ),
						"value" => "" 
				) 
		);
		$html .= asol_ModelFormly::Input ( $array ["attributes"] );
		$html .= '</div>';
		
		// ////////////////////////////////////////////////////////////////////
		
		// ////////////////////////////////////////////////////////////////////
		
		$html .= '<div class="inputForm">';
		$array = array (
				"attributes" => array (
						"for" => "allDay",
						"class" => "checkBoxInputLabel" 
				) 
		);
		$html .= asol_ModelFormly::Label ( $array ["attributes"], asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_ALLDAY' ) );
		if ($structure [$type] ['allDay'] == "1") {
			$array = array (
					"attributes" => array (
							"id" => "allDay",
							"class" => "inputCheckbox",
							"type" => "checkbox",
							"name" => "allDay",
							"placehodler" => asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_EXAMPLE_TITLE' ),
							"checked" => "checked",
							"disabled" => "disabled",
							"value" => "" 
					) 
			);
		} else {
			$array = array (
					"attributes" => array (
							"id" => "allDay",
							"class" => "inputCheckbox",
							"type" => "checkbox",
							"name" => "allDay",
							"placehodler" => asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_EXAMPLE_TITLE' ),
							"disabled" => "disabled",
							"value" => "" 
					) 
			);
		}
		$html .= asol_ModelFormly::Input ( $array ["attributes"] );
		$html .= '</div>';
		
		// ////////////////////////////////////////////////////////////////////
		
		// ////////////////////////////////////////////////////////////////////
		
		$html .= '<div id="initialInputDate" class="inputDate left">';
		$array = array (
				"attributes" => array (
						"for" => "initialDate",
						"class" => "textInputLabel" 
				) 
		);
		$html .= asol_ModelFormly::Label ( $array ["attributes"], asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_START_DATE' ) );
		$array = array (
				"attributes" => array (
						"id" => "initialDate",
						"class" => "text ui-widget-content ui-corner-all inputText datePicker",
						"type" => "text",
						"name" => "date",
						"placehodler" => "YYYY-MM-DD",
						"value" => "" 
				) 
		);
		$html .= asol_ModelFormly::Input ( $array ["attributes"] );
		$html .= '</div>';
		
		// ////////////////////////////////////////////////////////////////////
		
		// ////////////////////////////////////////////////////////////////////
		
		if ($structure [$type] ['allDay'] != "1") {
			$html .= '<div class="combodateInline">';
			$array = array (
					"attributes" => array (
							"id" => "initialTime",
							"class" => "text ui-widget-content ui-corner-all inputText",
							"type" => "text",
							"name" => "initialTime",
							"data-format" => "HH:mm",
							"data-template" => "HH : mm" 
					) 
			);
			$html .= asol_ModelFormly::Input ( $array ["attributes"] );
			$html .= '</div>';
			
			$html .= '<div style="clear: both;"></div>';
		}
		
		// ////////////////////////////////////////////////////////////////////
		
		// ////////////////////////////////////////////////////////////////////
		
		$html .= '<div id="finalInputDate" class="inputDate left">';
		$array = array (
				"attributes" => array (
						"for" => "finalDate",
						"class" => "textInputLabel" 
				) 
		);
		$html .= asol_ModelFormly::Label ( $array ["attributes"], asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_FINAL_DATE' ) );
		$array = array (
				"attributes" => array (
						"id" => "finalDate",
						"class" => "text ui-widget-content ui-corner-all inputText datePicker",
						"type" => "text",
						"name" => "date",
						"placehodler" => "YYYY-MM-DD",
						"value" => "" 
				) 
		);
		$html .= asol_ModelFormly::Input ( $array ["attributes"] );
		$html .= '</div>';
		
		// ////////////////////////////////////////////////////////////////////
		
		// ////////////////////////////////////////////////////////////////////
		
		if ($structure [$type] ['allDay'] != "1") {
			$html .= '<div class="combodateInline">';
			$array = array (
					"attributes" => array (
							"id" => "finalTime",
							"class" => "text ui-widget-content ui-corner-all inputText",
							"type" => "text",
							"name" => "initialTime",
							"data-format" => "HH:mm",
							"data-template" => "HH : mm" 
					) 
			);
			$html .= asol_ModelFormly::Input ( $array ["attributes"] );
			$html .= '</div>';
		}
		
		// ////////////////////////////////////////////////////////////////////
		
		// ////////////////////////////////////////////////////////////////////
		
		$html .= '<hr>';
		
		// ////////////////////////////////////////////////////////////////////
		
		// ////////////////////////////////////////////////////////////////////
		
		if (asol_CommonUtils::isDomainsInstalled ()) {
			if ($structure [$type] ['domain'] == "domain") {
				$html .= '<div class="inputBrand">';
				$html .= asol_CalendarUtils::getDomainsHtml ( $id );
				$html .= '</div>';
			} else {
				$html .= '<div class="inputCountry">';
				$array = array (
						"attributes" => array (
								"for" => "country",
								"class" => "textInputLabel" 
						) 
				);
				$html .= asol_ModelFormly::Label ( $array ["attributes"], asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_COUNTRY' ) );
				$countries = asol_CalendarUtils::obtainCountriesByDomain ();
				$options = array ();
				foreach ( $countries as $country ) {
					$options [$country] = $country;
				}
				$array = array (
						"attributes" => array (
								"id" => "country",
								"class" => "multiselect",
								"multiple" => "multiple" 
						),
						"options" => $options 
				);
				$html .= asol_ModelFormly::Select ( $array ["attributes"], $array ["options"] );
				$html .= '</div>';
			}
		}
		
		// ////////////////////////////////////////////////////////////////////
		
		// ////////////////////////////////////////////////////////////////////
		
		$roles = asol_CalendarUtils::getRoles ();
		$html .= '<div class="elementInline">';
		$html .= '<div class="inputVisibility">';
		$array = array (
				"attributes" => array (
						"for" => "visibility",
						"class" => "textInputLabel" 
				) 
		);
		$html .= asol_ModelFormly::Label ( $array ["attributes"], asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_VISIBILITY' ) );
		if (empty ( $roles )) {
			$options = array (
					"private" => asol_CalendarEvents::translateCalendarLabel ( 'LBL_PRIVATE' ),
					"public" => asol_CalendarEvents::translateCalendarLabel ( 'LBL_PUBLIC' ) 
			);
		} else {
			$options = array (
					"private" => asol_CalendarEvents::translateCalendarLabel ( 'LBL_PRIVATE' ),
					"public" => asol_CalendarEvents::translateCalendarLabel ( 'LBL_PUBLIC' ),
					"role" => asol_CalendarEvents::translateCalendarLabel ( 'LBL_BY_ROLE' ) 
			);
		}
		$array = array (
				"attributes" => array (
						"id" => "visibility",
						"class" => "ui-widget-content ui-state-default selectJqueryStyle visibility" 
				),
				"options" => $options 
		);
		$html .= asol_ModelFormly::Select ( $array ["attributes"], $array ["options"] );
		$html .= '</div>';
		if (! empty ( $roles )) {
			$html .= '<div class="hideRole">
				<div class="symbol">
					>>
				</div>
			<div class="inputRole">';
			$array = array (
					"attributes" => array (
							"for" => "role",
							"class" => "textInputLabel" 
					) 
			);
			$html .= asol_ModelFormly::Label ( $array ["attributes"], asol_CalendarEvents::translateCalendarLabel ( 'LBL_FORM_ROLE' ) );
			$options = array ();
			foreach ( $roles as $role ) {
				$options [$role ["id"]] = $role ["name"];
			}
			$array = array (
					"attributes" => array (
							"id" => "role",
							"class" => "multiselect",
							"multiple" => "multiple" 
					),
					"options" => $options 
			);
			$html .= asol_ModelFormly::Select ( $array ["attributes"], $array ["options"] );
			$html .= '</div></div>';
		}
		$html .= '</div>';
		
		// ////////////////////////////////////////////////////////////////////
		
		return $html;
	}
}