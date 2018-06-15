<?php
/**
 * @author AlineaSol
 */
class asol_ModelFormly {
	/**
	 * @param array $attributes
	 * @param string $text
	 * @return string
	 */
	static public function Label($attributes, $text) {
		$html = '';
		$html .= '<label ';
		
		foreach ( $attributes as $key => $value ) {
			
			$html .= $key . ' = "' . $value . '" ';
		}
		
		$html .= '> ' . $text . '</label>';
		
		return $html;
	}
	/**
	 * @param array $attributes
	 * @return string
	 */
	static public function Input($attributes) {
		$html = '';
		$html .= '<input ';
		
		foreach ( $attributes as $key => $value ) {
			
			$html .= $key . ' = "' . $value . '" ';
		}
		
		$html .= '>';
		
		return $html;
	}
	/**
	 * @param array $attributes
	 * @param array $options
	 * @return string
	 */
	static public function Select($attributes, $options) {
		$html = '';
		$html .= '<select ';
		
		foreach ( $attributes as $key => $value ) {
			
			$html .= $key . ' = "' . $value . '" ';
		}
		
		$html .= '> ';
		
		foreach ( $options as $key => $value ) {
			
			$html .= '<option value="' . $key . '" >' . $value . '</option> ';
		}
		
		$html .= '</select> ';
		
		return $html;
	}
	/**
	 * @param array $attributes
	 * @param string $text
	 * @return string
	 */
	static public function TextArea($attributes, $text) {
		$html = '';
		$html .= '<textarea ';
		
		foreach ( $attributes as $key => $value ) {
			
			$html .= $key . ' = "' . $value . '" ';
		}
		
		$html .= '> ';
		
		$html .= $text;
		
		$html .= ' </textarea>';
		
		return $html;
	}
	static public function DataList($attributes, $options) {
		// TODO: Implement DataList
	}
}