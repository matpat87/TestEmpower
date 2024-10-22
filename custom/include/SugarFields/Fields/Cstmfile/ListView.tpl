{*
/*********************************************************************************
 * This file is part of package File Field addon.
 * 
 * Author : NS-Team (http://www.ns-team.fr)
 * All rights (c) 2016 by NS-Team
 *
 * You can contact NS-Team at NS-Team - 55 Chemin de Mervilla - 31320 Auzeville - France
 * or via email at infos@ns-team.fr
 * 
 ********************************************************************************/

*}
{assign var="filename" value=$parentFieldArray.$col }
<a href="index.php?entryPoint=ff_download&id={$parentFieldArray.ID}_{$col|lower}&type={$module}&tempName={sugar_fetch object=$parentFieldArray key=$col}" class="tabDetailViewDFLink" target='_blank'>{sugar_fetch object=$parentFieldArray key=$col}
{if isset($vardef.allowEapm) && $vardef.allowEapm && isset($parentFieldArray.DOC_TYPE) }
{capture name=imageNameCapture assign=imageName}
{sugar_fetch object=$parentFieldArray key=DOC_TYPE}_image_inline.png
{/capture}
{capture name=imageURLCapture assign=imageURL}
{sugar_getimagepath file=$imageName}
{/capture}
{if strlen($imageURL)>1}{sugar_getimage name=$imageName alt=$imageName other_attributes='border="0" '}{/if}
{/if}
</a>
{if $filename != ""}
	{if $filename|upper|strstr:".PNG" || $filename|upper|strstr:".JPG" || $filename|upper|strstr:".JPEG" || $filename|upper|strstr:".BMP"}
			&nbsp;<img style="vertical-align: middle;max-width:25%;max-height:80px;" src="index.php?entryPoint=ff_download&id={sugar_fetch object=$parentFieldArray key=$vardef.fileId|upper}_{$col|lower}&type=temp&isTempFile=true&tempName={sugar_fetch object=$parentFieldArray key=$col}">	
	{/if}
{/if}
