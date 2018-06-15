<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>jsTree v.1.0 - dnd documentation</title>
		<script type="text/javascript" src="jsTree%20v.1.0%20-%20dnd%20documentation_files/jquery_003.js"></script>
		<script type="text/javascript" src="jsTree%20v.1.0%20-%20dnd%20documentation_files/jquery_002.js"></script>
		<script type="text/javascript" src="jsTree%20v.1.0%20-%20dnd%20documentation_files/jquery.js"></script>
		<script type="text/javascript" src="jsTree%20v.1.0%20-%20dnd%20documentation_files/jquery_004.js"></script>

		<link type="text/css" rel="stylesheet" href="jsTree%20v.1.0%20-%20dnd%20documentation_files/style.css">
		<link type="text/css" rel="stylesheet" href="jsTree%20v.1.0%20-%20dnd%20documentation_files/style_003.css">
		<script type="text/javascript" src="jsTree%20v.1.0%20-%20dnd%20documentation_files/script.js"></script>
		<style id="vakata-stylesheet" type="text/css">
			#vakata-dragged {
				display: block;
				margin: 0 0 0 0;
				padding: 4px 4px 4px 24px;
				position: absolute;
				top: -2000px;
				line-height: 16px;
				z-index: 10000;
			}
			#vakata-contextmenu {
				display: block;
				visibility: hidden;
				left: 0;
				top: -200px;
				position: absolute;
				margin: 0;
				padding: 0;
				min-width: 180px;
				background: #ebebeb;
				border: 1px solid silver;
				z-index: 10000;
				*width: 180px;
			}
			#vakata-contextmenu ul {
				min-width: 180px;
				*width: 180px;
			}
			#vakata-contextmenu ul, #vakata-contextmenu li {
				margin: 0;
				padding: 0;
				list-style-type: none;
				display: block;
			}
			#vakata-contextmenu li {
				line-height: 20px;
				min-height: 20px;
				position: relative;
				padding: 0px;
			}
			#vakata-contextmenu li a {
				padding: 1px 6px;
				line-height: 17px;
				display: block;
				text-decoration: none;
				margin: 1px 1px 0 1px;
			}
			#vakata-contextmenu li ins {
				float: left;
				width: 16px;
				height: 16px;
				text-decoration: none;
				margin-right: 2px;
			}
			#vakata-contextmenu li a:hover, #vakata-contextmenu li.vakata-hover > a {
				background: gray;
				color: white;
			}
			#vakata-contextmenu li ul {
				display: none;
				position: absolute;
				top: -2px;
				left: 100%;
				background: #ebebeb;
				border: 1px solid gray;
			}
			#vakata-contextmenu .right {
				right: 100%;
				left: auto;
			}
			#vakata-contextmenu .bottom {
				bottom: -1px;
				top: auto;
			}
			#vakata-contextmenu li.vakata-separator {
				min-height: 0;
				height: 1px;
				line-height: 1px;
				font-size: 1px;
				overflow: hidden;
				margin: 0 2px;
				background: silver; /* border-top:1px solid #fefefe; */
				padding: 0;
			}
		</style>
		<style id="jstree-stylesheet" type="text/css">
			.jstree ul, .jstree li {
				display: block;
				margin: 0 0 0 0;
				padding: 0 0 0 0;
				list-style-type: none;
			}
			.jstree li {
				display: block;
				min-height: 18px;
				line-height: 18px;
				white-space: nowrap;
				margin-left: 18px;
				min-width: 18px;
			}
			.jstree-rtl li {
				margin-left: 0;
				margin-right: 18px;
			}
			.jstree > ul > li {
				margin-left: 0px;
			}
			.jstree-rtl > ul > li {
				margin-right: 0px;
			}
			.jstree ins {
				display: inline-block;
				text-decoration: none;
				width: 18px;
				height: 18px;
				margin: 0 0 0 0;
				padding: 0;
			}
			.jstree a {
				display: inline-block;
				line-height: 16px;
				height: 16px;
				color: black;
				white-space: nowrap;
				text-decoration: none;
				padding: 1px 2px;
				margin: 0;
			}
			.jstree a:focus {
				outline: none;
			}
			.jstree a > ins {
				height: 16px;
				width: 16px;
			}
			.jstree a > .jstree-icon {
				margin-right: 3px;
			}
			.jstree-rtl a > .jstree-icon {
				margin-left: 3px;
				margin-right: 0;
			}
			li.jstree-open > ul {
				display: block;
			}
			li.jstree-closed > ul {
				display: none;
			}
			#vakata-dragged ins {
				display: block;
				text-decoration: none;
				width: 16px;
				height: 16px;
				margin: 0 0 0 0;
				padding: 0;
				position: absolute;
				top: 4px;
				left: 4px;
				-moz-border-radius: 4px;
				border-radius: 4px;
				-webkit-border-radius: 4px;
			}
			#vakata-dragged .jstree-ok {
				background: green;
			}
			#vakata-dragged .jstree-invalid {
				background: red;
			}
			#jstree-marker {
				padding: 0;
				margin: 0;
				font-size: 12px;
				overflow: hidden;
				height: 12px;
				width: 8px;
				position: absolute;
				top: -30px;
				z-index: 10001;
				background-repeat: no-repeat;
				display: none;
				background-color: transparent;
				text-shadow: 1px 1px 1px white;
				color: black;
				line-height: 10px;
			}
			#jstree-marker-line {
				padding: 0;
				margin: 0;
				line-height: 0%;
				font-size: 1px;
				overflow: hidden;
				height: 1px;
				width: 100px;
				position: absolute;
				top: -30px;
				z-index: 10000;
				background-repeat: no-repeat;
				display: none;
				background-color: #456c43;
				cursor: pointer;
				border: 1px solid #eeeeee;
				border-left: 0;
				-moz-box-shadow: 0px 0px 2px #666;
				-webkit-box-shadow: 0px 0px 2px #666;
				box-shadow: 0px 0px 2px #666;
				-moz-border-radius: 1px;
				border-radius: 1px;
				-webkit-border-radius: 1px;
			}
			.jstree .jstree-real-checkbox {
				display: none;
			}
			.jstree-themeroller .ui-icon {
				overflow: visible;
			}
			.jstree-themeroller a {
				padding: 0 2px;
			}
			.jstree-themeroller .jstree-no-icon {
				display: none;
			}
			.jstree .jstree-wholerow-real {
				position: relative;
				z-index: 1;
			}
			.jstree .jstree-wholerow-real li {
				cursor: pointer;
			}
			.jstree .jstree-wholerow-real a {
				border-left-color: transparent !important;
				border-right-color: transparent !important;
			}
			.jstree .jstree-wholerow {
				position: relative;
				z-index: 0;
				height: 0;
			}
			.jstree .jstree-wholerow ul, .jstree .jstree-wholerow li {
				width: 100%;
			}
			.jstree .jstree-wholerow, .jstree .jstree-wholerow ul, .jstree .jstree-wholerow li, .jstree .jstree-wholerow a {
				margin: 0 !important;
				padding: 0 !important;
			}
			.jstree .jstree-wholerow, .jstree .jstree-wholerow ul, .jstree .jstree-wholerow li {
				background: transparent !important;
			}
			.jstree .jstree-wholerow ins, .jstree .jstree-wholerow span, .jstree .jstree-wholerow input {
				display: none !important;
			}
			.jstree .jstree-wholerow a, .jstree .jstree-wholerow a:hover {
				text-indent: -9999px;!important;
				width: 100%;
				padding: 0 !important;
				border-right-width: 0px !important;
				border-left-width: 0px !important;
			}
			.jstree .jstree-wholerow-span {
				position: absolute;
				left: 0;
				margin: 0px;
				padding: 0;
				height: 18px;
				border-width: 0;
				padding: 0;
				z-index: 0;
			}
		</style>
		<style class="firebugResetStyles" type="text/css" charset="utf-8">
			/* See license.txt for terms of usage */
			/** reset styling **/
			.firebugResetStyles {
				z-index: 2147483646 !important;
				top: 0 !important;
				left: 0 !important;
				display: block !important;
				border: 0 none !important;
				margin: 0 !important;
				padding: 0 !important;
				outline: 0 !important;
				min-width: 0 !important;
				max-width: none !important;
				min-height: 0 !important;
				max-height: none !important;
				position: fixed !important;
				transform: rotate(0deg) !important;
				transform-origin: 50% 50% !important;
				border-radius: 0 !important;
				box-shadow: none !important;
				background: transparent none !important;
				pointer-events: none !important;
				white-space: normal !important;
			}
			style.firebugResetStyles {
				display: none !important;
			}

			.firebugBlockBackgroundColor {
				background-color: transparent !important;
			}

			.firebugResetStyles:before, .firebugResetStyles:after {
				content: "" !important;
			}
			/**actual styling to be modified by firebug theme**/
			.firebugCanvas {
				display: none !important;
			}

			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
			.firebugLayoutBox {
				width: auto !important;
				position: static !important;
			}

			.firebugLayoutBoxOffset {
				opacity: 0.8 !important;
				position: fixed !important;
			}

			.firebugLayoutLine {
				opacity: 0.4 !important;
				background-color: #000000 !important;
			}

			.firebugLayoutLineLeft, .firebugLayoutLineRight {
				width: 1px !important;
				height: 100% !important;
			}

			.firebugLayoutLineTop, .firebugLayoutLineBottom {
				width: 100% !important;
				height: 1px !important;
			}

			.firebugLayoutLineTop {
				margin-top: -1px !important;
				border-top: 1px solid #999999 !important;
			}

			.firebugLayoutLineRight {
				border-right: 1px solid #999999 !important;
			}

			.firebugLayoutLineBottom {
				border-bottom: 1px solid #999999 !important;
			}

			.firebugLayoutLineLeft {
				margin-left: -1px !important;
				border-left: 1px solid #999999 !important;
			}

			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
			.firebugLayoutBoxParent {
				border-top: 0 none !important;
				border-right: 1px dashed #E00 !important;
				border-bottom: 1px dashed #E00 !important;
				border-left: 0 none !important;
				position: fixed !important;
				width: auto !important;
			}

			.firebugRuler {
				position: absolute !important;
			}

			.firebugRulerH {
				top: -15px !important;
				left: 0 !important;
				width: 100% !important;
				height: 14px !important;
				background: url("data:image/png,%89PNG%0D%0A%1A%0A%00%00%00%0DIHDR%00%00%13%88%00%00%00%0E%08%02%00%00%00L%25a%0A%00%00%00%04gAMA%00%00%D6%D8%D4OX2%00%00%00%19tEXtSoftware%00Adobe%20ImageReadyq%C9e%3C%00%00%04%F8IDATx%DA%EC%DD%D1n%E2%3A%00E%D1%80%F8%FF%EF%E2%AF2%95%D0D4%0E%C1%14%B0%8Fa-%E9%3E%CC%9C%87n%B9%81%A6W0%1C%A6i%9A%E7y%0As8%1CT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AATE9%FE%FCw%3E%9F%AF%2B%2F%BA%97%FDT%1D~K(%5C%9D%D5%EA%1B%5C%86%B5%A9%BDU%B5y%80%ED%AB*%03%FAV9%AB%E1%CEj%E7%82%EF%FB%18%BC%AEJ8%AB%FA'%D2%BEU9%D7U%ECc0%E1%A2r%5DynwVi%CFW%7F%BB%17%7Dy%EACU%CD%0E%F0%FA%3BX%FEbV%FEM%9B%2B%AD%BE%AA%E5%95v%AB%AA%E3E5%DCu%15rV9%07%B5%7F%B5w%FCm%BA%BE%AA%FBY%3D%14%F0%EE%C7%60%0EU%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5JU%88%D3%F5%1F%AE%DF%3B%1B%F2%3E%DAUCNa%F92%D02%AC%7Dm%F9%3A%D4%F2%8B6%AE*%BF%5C%C2Ym~9g5%D0Y%95%17%7C%C8c%B0%7C%18%26%9CU%CD%13i%F7%AA%90%B3Z%7D%95%B4%C7%60%E6E%B5%BC%05%B4%FBY%95U%9E%DB%FD%1C%FC%E0%9F%83%7F%BE%17%7DkjMU%E3%03%AC%7CWj%DF%83%9An%BCG%AE%F1%95%96yQ%0Dq%5Dy%00%3Et%B5'%FC6%5DS%95pV%95%01%81%FF'%07%00%00%00%00%00%00%00%00%00%F8x%C7%F0%BE%9COp%5D%C9%7C%AD%E7%E6%EBV%FB%1E%E0(%07%E5%AC%C6%3A%ABi%9C%8F%C6%0E9%AB%C0'%D2%8E%9F%F99%D0E%B5%99%14%F5%0D%CD%7F%24%C6%DEH%B8%E9rV%DFs%DB%D0%F7%00k%FE%1D%84%84%83J%B8%E3%BA%FB%EF%20%84%1C%D7%AD%B0%8E%D7U%C8Y%05%1E%D4t%EF%AD%95Q%BF8w%BF%E9%0A%BF%EB%03%00%00%00%00%00%00%00%00%00%B8vJ%8E%BB%F5%B1u%8Cx%80%E1o%5E%CA9%AB%CB%CB%8E%03%DF%1D%B7T%25%9C%D5(%EFJM8%AB%CC'%D2%B2*%A4s%E7c6%FB%3E%FA%A2%1E%80~%0E%3E%DA%10x%5D%95Uig%15u%15%ED%7C%14%B6%87%A1%3B%FCo8%A8%D8o%D3%ADO%01%EDx%83%1A~%1B%9FpP%A3%DC%C6'%9C%95gK%00%00%00%00%00%00%00%00%00%20%D9%C9%11%D0%C0%40%AF%3F%EE%EE%92%94%D6%16X%B5%BCMH%15%2F%BF%D4%A7%C87%F1%8E%F2%81%AE%AAvzr%DA2%ABV%17%7C%E63%83%E7I%DC%C6%0Bs%1B%EF6%1E%00%00%00%00%00%00%00%00%00%80cr%9CW%FF%7F%C6%01%0E%F1%CE%A5%84%B3%CA%BC%E0%CB%AA%84%CE%F9%BF) % EC % 13% 08WU % AE % AB % B1 % AE % 2BO % EC % 8E % CBYe % FE % 8CN % ABr % 5Dy % 60 ~%CFA%0D%F4%AE%D4%BE%C75%CA%EDVB%EA(%B7%F1%09g%E5%D9%12%00%00%00%00%00%00%00%00%00H%F6%EB%13S%E7y%5E%5E%FB%98%F0%22%D1%B2'%A7%F0%92%B1%BC%24z3%AC%7Dm%60%D5%92%B4%7CEUO%5E%F0%AA*%3BU%B9%AE%3E%A0j%94%07%A0%C7%A0%AB%FD%B5%3F%A0%F7%03T%3Dy%D7%F7%D6%D4%C0%AAU%D2%E6%DFt%3F%A8%CC%AA%F2%86%B9%D7%F5%1F%18%E6%01%F8%CC%D5%9E%F0%F3z%88%AA%90%EF%20%00%00%00%00%00%00%00%00%00%C0%A6%D3%EA%CFi%AFb%2C%7BB%0A%2B%C3%1A%D7%06V%D5%07%A8r%5D%3D%D9%A6%CAu%F5%25%CF%A2%99%97zNX%60%95%AB%5DUZ%D5%FBR%03%AB%1C%D4k%9F%3F%BB%5C%FF%81a%AE%AB'%7F%F3%EA%FE%F3z%94%AA%D8%DF%5B%01%00%00%00%00%00%00%00%00%00%8E%FB%F3%F2%B1%1B%8DWU%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*UiU%C7%BBe%E7%F3%B9%CB%AAJ%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5*%AAj%FD%C6%D4%5Eo%90%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5%86%AF%1B%9F%98%DA%EBm%BBV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%AD%D6%E4%F58%01%00%00%00%00%00%00%00%00%00%00%00%00%00%40%85%7F%02%0C%008%C2%D0H%16j%8FX%00%00%00%00IEND%AEB%60%82") repeat-x !important;
				border-top: 1px solid #BBBBBB !important;
				border-right: 1px dashed #BBBBBB !important;
				border-bottom: 1px solid #000000 !important;
			}

			.firebugRulerV {
				top: 0 !important;
				left: -15px !important;
				width: 14px !important;
				height: 100% !important;
				background: url("data:image/png,%89PNG%0D%0A%1A%0A%00%00%00%0DIHDR%00%00%00%0E%00%00%13%88%08%02%00%00%00%0E%F5%CB%10%00%00%00%04gAMA%00%00%D6%D8%D4OX2%00%00%00%19tEXtSoftware%00Adobe%20ImageReadyq%C9e%3C%00%00%06~IDATx%DA%EC%DD%D1v%A20%14%40Qt%F1%FF%FF%E4%97%D9%07%3BT%19%92%DC%40(%90%EEy%9A5%CB%B6%E8%F6%9Ac%A4%CC0%84%FF%DC%9E%CF%E7%E3%F1%88%DE4%F8%5D%C7%9F%2F%BA%DD%5E%7FI%7D%F18%DDn%BA%C5%FB%DF%97%BFk%F2%10%FF%FD%B4%F2M%A7%FB%FD%FD%B3%22%07p%8F%3F%AE%E3%F4S%8A%8F%40%EEq%9D%BE8D%F0%0EY%A1Uq%B7%EA%1F%81%88V%E8X%3F%B4%CEy%B7h%D1%A2E%EBohU%FC%D9%AF2fO%8BBeD%BE%F7X%0C%97%A4%D6b7%2Ck%A5%12%E3%9B%60v%B7r%C7%1AI%8C%BD%2B%23r%00c0%B2v%9B%AD%CA%26%0C%1Ek%05A%FD%93%D0%2B%A1u%8B%16-%95q%5Ce%DCSO%8E%E4M%23%8B%F7%C2%FE%40%BB%BD%8C%FC%8A%B5V%EBu%40%F9%3B%A72%FA%AE%8C%D4%01%CC%B5%DA%13%9CB%AB%E2I%18%24%B0n%A9%0CZ*Ce%9C%A22%8E%D8NJ%1E%EB%FF%8F%AE%CAP%19*%C3%BAEKe%AC%D1%AAX%8C*%DEH%8F%C5W%A1e%AD%D4%B7%5C%5B%19%C5%DB%0D%EF%9F%19%1D%7B%5E%86%BD%0C%95%A12%AC%5B*%83%96%CAP%19%F62T%86%CAP%19*%83%96%CA%B8Xe%BC%FE) T % 19% A1 % 17xg % 7F % DA % CBP % 19 *%C3%BA%A52T%86%CAP%19%F62T%86%CA%B0n%A9%0CZ%1DV%C6%3D%F3%FCH%DE%B4%B8~%7F%5CZc%F1%D6%1F%AF%84%F9%0F6%E6%EBVt9%0E~%BEr%AF%23%B0%97%A12T%86%CAP%19%B4T%86%CA%B8Re%D8%CBP%19*%C3%BA%A52huX%19%AE%CA%E5%BC%0C%7B%19*CeX%B7h%A9%0C%95%E1%BC%0C%7B%19*CeX%B7T%06%AD%CB%5E%95%2B%BF.%8F%C5%97%D5%E4%7B%EE%82%D6%FB%CF-%9C%FD%B9%CF%3By%7B%19%F62T%86%CA%B0n%D1R%19*%A3%D3%CA%B0%97%A12T%86uKe%D0%EA%B02*%3F1%99%5DB%2B%A4%B5%F8%3A%7C%BA%2B%8Co%7D%5C%EDe%A8%0C%95a%DDR%19%B4T%C66%82fA%B2%ED%DA%9FC%FC%17GZ%06%C9%E1%B3%E5%2C%1A%9FoiB%EB%96%CA%A0%D5qe4%7B%7D%FD%85%F7%5B%ED_%E0s%07%F0k%951%ECr%0D%B5C%D7-g%D1%A8%0C%EB%96%CA%A0%A52T%C6)*%C3%5E%86%CAP%19%D6-%95A%EB*%95q%F8%BB%E3%F9%AB%F6%E21%ACZ%B7%22%B7%9B%3F%02%85%CB%A2%5B%B7%BA%5E%B7%9C%97%E1%BC%0C%EB%16-%95%A12z%AC%0C%BFc%A22T%86uKe%D0%EA%B02V%DD%AD%8A%2B%8CWhe%5E%AF%CF%F5%3B%26%CE%CBh%5C%19%CE%CB%B0%F3%A4%095%A1%CAP%19*Ce%A8%0C%3BO*Ce%A8%0C%95%A12%3A%AD%8C%0A%82%7B%F0v%1F%2FD%A9%5B%9F%EE%EA%26%AF%03%CA%DF9%7B%19*Ce%A8%0C%95%A12T%86%CA%B8Ze%D8%CBP%19*Ce%A8%0C%95%D1ae%EC%F7%89I%E1%B4%D7M%D7P%8BjU%5C%BB%3E%F2%20%D8%CBP%19*Ce%A8%0C%95%A12T%C6%D5*%C3%5E%86%CAP%19*Ce%B4O%07%7B%F0W%7Bw%1C%7C%1A%8C%B3%3B%D1%EE%AA%5C%D6-%EBV%83%80%5E%D0%CA%10%5CU%2BD%E07YU%86%CAP%19*%E3%9A%95%91%D9%A0%C8%AD%5B%EDv%9E%82%FFKOee%E4%8FUe%A8%0C%95%A12T%C6%1F%A9%8C%C8%3D%5B%A5%15%FD%14%22r%E7B%9F%17l%F8%BF%ED%EAf%2B%7F%CF%ECe%D8%CBP%19*Ce%A8%0C%95%E1%93~%7B%19%F62T%86%CAP%19*Ce%A8%0C%E7%13%DA%CBP%19*Ce%A8%0CZf%8B%16-Z%B4h%D1R%19f%8B%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1%A2%A52%CC%16-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2EKe%98-Z%B4h%D1%A2EKe%D02%5B%B4h%D1%A2EKe%D02%5B%B4h%D1%A2E%8B%96%CA0%5B%B4h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%16-%95a%B6h%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-Z*%C3l%D1%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z%B4T%86%D9%A2E%8B%16-Z%B4T%06-%B3E%8B%16-Z%B4T%06-%B3E%8B%16-Z%B4h%A9%0C%B3E%8B%16-Z%B4h%A9%0CZf%8B%16-Z%B4h%A9%0CZf%8B%16-Z%B4h%D1R%19f%8B%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1%A2%A52%CC%16-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2EKe%98-Z%B4h%D1%A2EKe%D02%5B%B4h%D1%A2EKe%D02%5B%B4h%D1%A2E%8B%96%CA0%5B%B4h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%16-%95a%B6h%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-Z*%C3l%D1%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z%B4T%86%D9%A2E%8B%16-Z%B4T%06-%B3E%8B%16-Z%B4T%06-%B3E%8B%16-Z%B4h%A9%0C%B3E%8B%16-Z%B4h%A9%0CZf%8B%16-Z%B4h%A9%0CZf%8B%16-Z%B4h%D1R%19f%8B%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1%A2%A52%CC%16-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2EKe%98-Z%B4h%D1%A2EKe%D02%5B%B4h%D1%A2EKe%D02%5B%B4h%D1%A2E%8B%96%CA0%5B%B4h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%16-%95a%B6h%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-Z*%C3l%D1%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z%B4T%86%D9%A2E%8B%16-Z%B4T%06-%B3E%8B%16-Z%B4%AE%A4%F5%25%C0%00%DE%BF%5C'%0F%DA%B8q%00%00%00%00IEND%AEB%60%82") repeat-y !important;
				border-left: 1px solid #BBBBBB !important;
				border-right: 1px solid #000000 !important;
				border-bottom: 1px dashed #BBBBBB !important;
			}

			.overflowRulerX > .firebugRulerV {
				left: 0 !important;
			}

			.overflowRulerY > .firebugRulerH {
				top: 0 !important;
			}

			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
			.fbProxyElement {
				position: fixed !important;
				pointer-events: auto !important;
			}
		</style>
		<link href="jsTree%20v.1.0%20-%20dnd%20documentation_files/style_002.css" media="all" type="text/css" rel="stylesheet">
	</head>
	<body>
		<div id="container">

			<h1 id="dhead">jsTree v.1.0</h1>
			<h1>dnd plugin</h1>
			<h2>Description</h2>
			<div id="description">
				<p>
					The <code>
						dnd</code>
					plugin enables drag'n'drop support for jstree, also using foreign nodes and drop targets.
				</p>
				<p class="note">
					All foreign node options and callback functions in the
					config (drop_target, drop_check, drop_finish, drag_target, drag_check,
					drag_finish) are to be used ONLY when nodes that are not part of any
					tree are involved.
					<br>
					If moving nodes from one tree instance to another - just listen for the "move_node.jstree" event on the receiving tree.
					<br>
					<span style="color:red">DO NOT SET drag_target AND drop_target to match tree nodes!</span>
				</p>
			</div>

			<h2 id="configuration">Configuration</h2>
			<div class="panel configuration">

				<h3>copy_modifier</h3>
				<p class="meta">
					A string. Default is <code>
						"ctrl"</code>
					.
				</p>
				<p>
					The special key used to make a drag copy instead of move (<code>
						"ctrl"</code>
					, <code>
						"shift"</code>
					, <code>
						"alt"</code>
					, <code>
						"meta"</code>
					).
				</p>

				<h3>check_timeout</h3>
				<p class="meta">
					A number. Default is <code>
						200</code>
					.
				</p>
				<p>
					The number of milliseconds to wait before checking if a move is valid upon hovering a node (while dragging). <code>
						200</code>
					is a reasonable value - a higher number means better performance but
					slow feedback to the user, a lower number means lower performance
					(possibly) but the user will get feedback faster.
				</p>

				<h3>open_timeout</h3>
				<p class="meta">
					A number. Default is <code>
						500</code>
					.
				</p>
				<p>
					The number of milliseconds to wait before opening a hovered if it has
					children (while dragging). This means that the user has to stop over
					the node for half a second in order to trigger the open operation. Keep
					in mind that a low value in combination with async data could mean a lot
					of unneeded traffic, so <code>
						500</code>
					is quite reasonable.
				</p>

				<h3>drop_target</h3>
				<p class="meta">
					A string (jQuery selector) (or <code>
						false</code>
					). Default is <code>
						".jstree-drop"</code>
					.
				</p>
				<p>
					A jquery selector matching all drop targets (you can also use the comma <code>
						,</code>
					in the string to specify multiple valid targets). If set to <code>
						false</code>
					drop targets are disabled.
				</p>

				<h3>drop_check</h3>
				<p class="meta">
					A function. Default is <code>
						function (data) { return true; }</code>
					.
				</p>
				<p>
					Return <code>
						false</code>
					to mark the move as invalid, otherwise return <code>
						true</code>
					. The <code>
						data</code>
					parameter is as follows:
				</p>
				<p style="margin-left:2em;">
					<code>
						data.o</code>
					- the object being dragged
				</p>
				<p style="margin-left:2em;">
					<code>
						data.r</code>
					- the drop target
				</p>

				<h3>drop_finish</h3>
				<p class="meta">
					A function. Default is <code>
						$.noop</code>
					.
				</p>
				<p>
					Gets executed after a valid drop, you get one parameter, which is as follows:
				</p>
				<p style="margin-left:2em;">
					<code>
						data.o</code>
					- the object being dragged
				</p>
				<p style="margin-left:2em;">
					<code>
						data.r</code>
					- the drop target
				</p>

				<h3>drag_target</h3>
				<p class="meta">
					A string (jQuery selector) (or <code>
						false</code>
					). Default is <code>
						".jstree-draggable"</code>
					.
				</p>
				<p>
					A jquery selector matching all foreign nodes that can be dropped on the tree (you can also use the comma <code>
						,</code>
					in the string to specify multiple valid foreign nodes). If set to <code>
						false</code>
					dragging foreign nodes is disabled.
				</p>

				<h3>drag_check</h3>
				<p class="meta">
					A function. Default is <code>
						function (data) { return { after : false, before : false, inside : true }; }</code>
					.
				</p>
				<p>
					Return a boolean for each position. The <code>
						data</code>
					parameter is as follows:
				</p>
				<p style="margin-left:2em;">
					<code>
						data.o</code>
					- the foreign object being dragged
				</p>
				<p style="margin-left:2em;">
					<code>
						data.r</code>
					- the hovered node
				</p>

				<h3>drag_finish</h3>
				<p class="meta">
					A function. Default is <code>
						$.noop</code>
					.
				</p>
				<p>
					Gets executed after a dropping a foreign element on a tree item, you get one parameter, which is as follows:
				</p>
				<p style="margin-left:2em;">
					<code>
						data.o</code>
					- the foreign object being dragged
				</p>
				<p style="margin-left:2em;">
					<code>
						data.r</code>
					- the target node
				</p>

			</div>

			<h2 id="demos">Demos</h2>
			<div class="panel">
				<h3>Using the dnd plugin</h3>
				<p>
					Drag stuff around!
				</p>
				<div class="jstree-drop" style="clear:both; border:5px solid green; background:lime; color:green; height:40px; line-height:40px; text-align:center; font-size:20px;">
					I have the jstree-drop class
				</div>
				<div class="jstree-draggable" style="margin:10px 0; clear:both; border:5px solid navy; background:aqua; color:navy; height:40px; line-height:40px; text-align:center; font-size:20px;">
					I have the jstree-draggable class
				</div>
				<div style="height: 397px;" id="demo1" class="demo jstree jstree-0 jstree-default jstree-focused">
					<ul>
						<li class="jstree-closed" id="phtml_1">
							<ins class="jstree-icon">&nbsp;</ins><a style="-moz-user-select: none;" href="#"><ins class="jstree-icon">&nbsp;</ins>Root node 1</a>
							<ul>
								<li class="jstree-leaf" id="phtml_2">
									<ins class="jstree-icon">&nbsp;</ins><a href="#"><ins class="jstree-icon">&nbsp;</ins>Child node 1</a>
								</li>
								<li class="jstree-last jstree-leaf" id="phtml_3">
									<ins class="jstree-icon">&nbsp;</ins><a href="#"><ins class="jstree-icon">&nbsp;</ins>Child node 2</a>
								</li>
							</ul>
						</li>
						<li class="jstree-last jstree-leaf" id="phtml_4">
							<ins class="jstree-icon">&nbsp;</ins><a href="#"><ins class="jstree-icon">&nbsp;</ins>Root node 2</a>
						</li>
					</ul>
				</div>
				<script type="text/javascript" class="source">
                    $(function() {
                        $("#demo1").jstree({
                            "dnd" : {
                                "drop_finish" : function() {
                                    alert("DROP");
                                }, "drag_check" : function(data) {
                                    if (data.r.attr("id") == "phtml_1") {
                                        return false;
                                    }
                                    return {
                                        after : false, before : false, inside : true
                                    };
                                }, "drag_finish" : function(data) {
                                    alert("DRAG OK");
                                }
                            }, "plugins" : ["themes", "html_data", "dnd"]
                        });
                    });
				</script>
				<div style="height: 397px;" class="code">
					<div class="syntaxhighlighter  " id="highlighter_620911">
						<div class="bar                                          ">
							<div class="toolbar">
								<a class="item viewSource" style="width: 16px; height: 16px;" title="view source" href="#viewSource">view source</a>
								<div class="item copyToClipboard">
									<embed id="highlighter_620911_clipboard" type="application/x-shockwave-flash" title="copy to clipboard" allowscriptaccess="always" wmode="transparent" flashvars="highlighterId=highlighter_620911" menu="false" src="jsTree%20v.1.0%20-%20dnd%20documentation_files/clipboard.swf" height="16" width="16">
								</div><a class="item printSource" style="width: 16px; height: 16px;" title="print" href="#printSource">print</a><a class="item about" style="width: 16px; height: 16px;" title="?" href="#about">?</a>
							</div>
						</div>
						<div class="lines">
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												01</code></td><td class="content"><code class="plain">
												$(</code><code class="keyword">
												function</code><code class="plain">
												() {</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												02</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												$(</code><code class="string">
												"#demo1"</code><code class="plain">
												).jstree({ </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												03</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"dnd"</code><code class="plain">
												: {</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												04</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"drop_finish"</code><code class="plain">
												: </code><code class="keyword">
												function</code><code class="plain">
												() { </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												05</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												alert(</code><code class="string">
												"DROP"</code><code class="plain">
												); </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												06</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												},</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												07</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"drag_check"</code><code class="plain">
												: </code><code class="keyword">
												function</code><code class="plain">
												(data) {</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												08</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="keyword">
												if</code><code class="plain">
												(data.r.attr(</code><code class="string">
												"id"</code><code class="plain">
												) == </code><code class="string">
												"phtml_1"</code><code class="plain">
												) {</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												09</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="keyword">
												return</code><code class="keyword">
												false</code><code class="plain">
												;</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												10</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												}</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												11</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="keyword">
												return</code><code class="plain">
												{ </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												12</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												after : </code><code class="keyword">
												false</code><code class="plain">
												, </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												13</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												before : </code><code class="keyword">
												false</code><code class="plain">
												, </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												14</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												inside : </code><code class="keyword">
												true</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												15</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												};</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												16</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												},</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												17</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"drag_finish"</code><code class="plain">
												: </code><code class="keyword">
												function</code><code class="plain">
												(data) { </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												18</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												alert(</code><code class="string">
												"DRAG OK"</code><code class="plain">
												); </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												19</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												}</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												20</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												},</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												21</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"plugins"</code><code class="plain">
												: [ </code><code class="string">
												"themes"</code><code class="plain">
												, </code><code class="string">
												"html_data"</code><code class="plain">
												, </code><code class="string">
												"dnd"</code><code class="plain">
												]</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												22</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												});</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												23</code></td><td class="content"><code class="plain">
												});</code></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<h3>Reorder only demo</h3>
				<div style="height: 365px;" id="demo2" class="demo jstree jstree-1 jstree-default">
					<ul>
						<li class="jstree-open" id="rhtml_1">
							<ins class="jstree-icon">&nbsp;</ins><a href="#"><ins class="jstree-icon">&nbsp;</ins>Root node 1</a>
							<ul style="">

								<li class="jstree-leaf" id="rhtml_3">
									<ins class="jstree-icon">&nbsp;</ins><a href="#"><ins class="jstree-icon">&nbsp;</ins>Child node 2</a>
								</li>
								<li class="jstree-leaf" id="rhtml_2">
									<ins class="jstree-icon">&nbsp;</ins><a style="-moz-user-select: none;" href="#"><ins class="jstree-icon">&nbsp;</ins>Child node 1</a>
								</li>
								<li class="jstree-leaf" id="rhtml_4">
									<ins class="jstree-icon">&nbsp;</ins><a href="#"><ins class="jstree-icon">&nbsp;</ins>Child node 3</a>
								</li>
								<li class="jstree-leaf jstree-last" id="rhtml_5">
									<ins class="jstree-icon">&nbsp;</ins><a href="#"><ins class="jstree-icon">&nbsp;</ins>Child node 4</a>
								</li>
							</ul>
						</li>
						<li class="jstree-leaf" id="rhtml_6">
							<ins class="jstree-icon">&nbsp;</ins><a style="-moz-user-select: none;" href="#"><ins class="jstree-icon">&nbsp;</ins>Root node 2</a>
						</li>
						<li class="jstree-last jstree-leaf" id="rhtml_7">
							<ins class="jstree-icon">&nbsp;</ins><a href="#"><ins class="jstree-icon">&nbsp;</ins>Root node 3</a>
						</li>
					</ul>
				</div>
				<script type="text/javascript" class="source">
                    $(function() {
                        $("#demo2").jstree({
                            "crrm" : {
                                "move" : {
                                    "check_move" : function(m) {
                                        var p = this._get_parent(m.o);
                                        if (!p)
                                            return false;
                                        p = p == -1 ? this.get_container() : p;
                                        if (p === m.np)
                                            return true;
                                        if (p[0] && m.np[0] && p[0] === m.np[0])
                                            return true;
                                        return false;
                                    }
                                }
                            }, "dnd" : {
                                "drop_target" : false, "drag_target" : false
                            }, "plugins" : ["themes", "html_data", "crrm", "dnd"]
                        });
                    });
				</script>
				<div style="height: 365px;" class="code">
					<div class="syntaxhighlighter  " id="highlighter_231939">
						<div class="bar     ">
							<div class="toolbar">
								<a class="item viewSource" style="width: 16px; height: 16px;" title="view source" href="#viewSource">view source</a>
								<div class="item copyToClipboard">
									<embed id="highlighter_231939_clipboard" type="application/x-shockwave-flash" title="copy to clipboard" allowscriptaccess="always" wmode="transparent" flashvars="highlighterId=highlighter_231939" menu="false" src="jsTree%20v.1.0%20-%20dnd%20documentation_files/clipboard.swf" height="16" width="16">
								</div><a class="item printSource" style="width: 16px; height: 16px;" title="print" href="#printSource">print</a><a class="item about" style="width: 16px; height: 16px;" title="?" href="#about">?</a>
							</div>
						</div>
						<div class="lines">
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												01</code></td><td class="content"><code class="plain">
												$(</code><code class="keyword">
												function</code><code class="plain">
												() {</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												02</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												$(</code><code class="string">
												"#demo2"</code><code class="plain">
												).jstree({ </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												03</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"crrm"</code><code class="plain">
												: { </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												04</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"move"</code><code class="plain">
												: {</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												05</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"check_move"</code><code class="plain">
												: </code><code class="keyword">
												function</code><code class="plain">
												(m) { </code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												06</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="keyword">
												var</code><code class="plain">
												p = </code><code class="keyword">
												this</code><code class="plain">
												._get_parent(m.o);</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												07</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="keyword">
												if</code><code class="plain">
												(!p) </code><code class="keyword">
												return</code><code class="keyword">
												false</code><code class="plain">
												;</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												08</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												p = p == -1 ? </code><code class="keyword">
												this</code><code class="plain">
												.get_container() : p;</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												09</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="keyword">
												if</code><code class="plain">
												(p === m.np) </code><code class="keyword">
												return</code><code class="keyword">
												true</code><code class="plain">
												;</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												10</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="keyword">
												if</code><code class="plain">
												(p[0] &amp;&amp; m.np[0] &amp;&amp; p[0] === m.np[0]) </code><code class="keyword">
												return</code><code class="keyword">
												true</code><code class="plain">
												;</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												11</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="keyword">
												return</code><code class="keyword">
												false</code><code class="plain">
												;</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												12</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												}</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												13</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												}</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												14</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												},</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												15</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"dnd"</code><code class="plain">
												: {</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												16</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"drop_target"</code><code class="plain">
												: </code><code class="keyword">
												false</code><code class="plain">
												,</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												17</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"drag_target"</code><code class="plain">
												: </code><code class="keyword">
												false</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												18</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												},</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												19</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="string">
												"plugins"</code><code class="plain">
												: [ </code><code class="string">
												"themes"</code><code class="plain">
												, </code><code class="string">
												"html_data"</code><code class="plain">
												, </code><code class="string">
												"crrm"</code><code class="plain">
												, </code><code class="string">
												"dnd"</code><code class="plain">
												]</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt2">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												20</code></td><td class="content"><code class="spaces">
												&nbsp;&nbsp;&nbsp;&nbsp;</code><code class="plain">
												});</code></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="line alt1">
								<table>
									<tbody>
										<tr>
											<td class="number"><code>
												21</code></td><td class="content"><code class="plain">
												});</code></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

			</div>

			<h2 id="api">API</h2>
			<div class="panel api">

				<div style="height:1px; visibility:hidden;">
					<span id="dnd_show">&nbsp;</span>
					<span id="dnd_open">&nbsp;</span>
					<span id="dnd_finish">&nbsp;</span>
					<span id="dnd_enter">&nbsp;</span>
					<span id="start_drag">&nbsp;</span>
				</div>
				<h3 id="dnd_prepare">.dnd_prepare ( ), .dnd_show ( ), .dnd_open ( ), .dnd_finish ( ), .dnd_enter ( ), .dnd_leave ( ), .start_drag ( )</h3>
				<p>
					All those functions are used internally only. If you want more information - examine the source code.
				</p>

			</div>

		</div>

		<div class="jstree-default" style="display: none; top: -2000px; left: 600.5px;" id="jstree-marker">
			»
		</div><div class="jstree-default" style="display: none; top: -2000px; left: 608.5px;" id="jstree-marker-line"></div><div id="vakata-contextmenu"></div>
		<div style="left: 572.167px ! important; top: -568.733px ! important;" class="firebugResetStyles firebugBlockBackgroundColor firebugLayoutBox firebugLayoutBoxOffset">
			<div style="padding: 0px 0px 0px 26px ! important; background-color: rgb(237, 255, 100) ! important;" class="firebugResetStyles firebugLayoutBox">
				<div style="padding: 0px ! important; background-color: rgb(68, 68, 68) ! important;" class="firebugResetStyles firebugLayoutBox">
					<div style="padding: 0px 0px 6px ! important; background-color: SlateBlue ! important;" class="firebugResetStyles firebugLayoutBox">
						<div style="width: 733.333px ! important; height: 25.1667px ! important; background-color: SkyBlue ! important;" class="firebugResetStyles firebugLayoutBox"></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>