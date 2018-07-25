<?php

include_once 'include/SugarFields/Fields/Html/SugarFieldHtml.php';

class CustomSugarFieldHtml extends SugarFieldHtml {

	/**
	 * @param string $parentFieldArray
	 * @param array $vardef
	 * @param array $displayParams
	 * @param integer $tabindex
	 * @return string
	 */
	public function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {

		$sugarCleaner = new SugarCleaner();
		$vardef['value'] = $sugarCleaner::cleanHtml($this->getVardefValue($vardef));


		require_once 'include/SuiteEditor/SuiteEditorConnector.php';

		$settings = SuiteEditorConnector::getSuiteSettings($vardef['value'], 600);
		
		// set real field name
		$settings['textareaId'] = $vardef['name'];
		// and remove onclick actions
		$settings['clickHandler'] = 'function(e){}';
		$settings['tinyMCESetup'] = "{
                setup: function(editor) {},
                plugins: ['code', 'table', 'link'],
            }";

		$this->ss->assign('BODY_EDITOR', SuiteEditorConnector::getHtml($settings));
		$this->ss->assign('value', $vardef['value']);

		$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
		return $this->fetch($this->findTemplate('EditView'));
	}

	private function getVardefValue($vardef) {
		if (empty($vardef['value'])) {
			if (!empty($vardef['default'])) {
				return $vardef['default'];
			} elseif (!empty($vardef['default_value'])) {
				return $vardef['default_value'];
			}
		}

		return utf8_decode($vardef['value']);
	}

}

?>