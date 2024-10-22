<?php
    class PDFHelper{
        public static function getTotalColumnsHasValue($pdf_index, $pdf_data)
		{
			$result = 0;

			if(!empty($pdf_index)){
				foreach($pdf_data[$pdf_index] as $pdf_var => $pdf)
				{
					if(!empty($pdf['value'])){
						$result++;
					}
				}
			}

			return $result;
		}

        public static function getHTMLDataV2($pdf_index, $pdf_var, $pdf_data){
			$result = '';
			$pdf = $pdf_data[$pdf_index][$pdf_var];

			if(!$pdf['is_ui_added'])
			{
				$pdf['is_ui_added'] = true;
				$result .= '<table>';
					$result .= '<tr>';
						$result .= '<td style="width: 2%;"></td>';
						$result .= '<td style="width: 96%;">';
							$result .= '<table>';
								$result .= '<tr>';
									$result .= '<td class="tdLabel">' . $pdf['label'] . ':</td>';
									$result .= '<td style="'. $pdf['style'] .'" class="tdValue '. 
										$pdf['class'] .'" >' . $pdf['value'] . '</td>';
								$result .= '</tr>';
							$result .= '</table>';
						$result .= '</td>';
						$result .= '<td style="width: 2%;"></td>';
					$result .= '</tr>';
				$result .= '</table>';
			}

			return $result;
		}

        public static function getHTMLDataV3($pdf_value){
			$result = '';

			if(!empty($pdf_value))
			{
				$result .= '<table style="width: 100%;">';
				$result .= '<tr>';
				$result .= '<td style="width: 2%;"></td>';
				$result .= '<td style="width:96%">' . $pdf_value . '</td>';
				$result .= '<td style="width: 2%;"></td>';
				$result .= '</tr>';
				$result .= '</table>';
			}

			return $result;
		}
    }
?>