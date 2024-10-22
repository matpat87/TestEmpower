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
{assign var="filename" value={{sugarvar key='value' string=true}} }

<span class="sugar_field" id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}">
<a href="index.php?entryPoint=ff_download&id={$fields.{{$vardef.fileId}}.value}_{{sugarvar key='name'}}&type={{$vardef.linkModule}}&tempName={{sugarvar key='value'}}" class="tabDetailViewDFLink" target='_blank'>{{sugarvar key='value'}}</a>
</span>
{if $filename != ""}
	&nbsp;
	<a href="index.php?preview=yes&entryPoint=ff_download&id={$fields.{{$vardef.fileId}}.value}_{{sugarvar key='name'}}&type={{$vardef.linkModule}}" class="tabDetailViewDFLink" target='_blank' style="border-bottom: 0px;">
	{if $filename|upper|strstr:".PNG" || $filename|upper|strstr:".JPG" || $filename|upper|strstr:".JPEG" || $filename|upper|strstr:".BMP"}
			<img style="vertical-align: middle;max-width:25%;max-height:150px;" src="index.php?entryPoint=ff_download&id={$fields.{{$vardef.fileId}}.value}_{{sugarvar key='name'}}&type=temp&isTempFile=true&tempName={{sugarvar key='value'}}">	
	{else}
			<i class="glyphicon glyphicon-eye-open"></i>
	{/if}
	</a>
{/if}

{{if isset($vardef) && isset($vardef.allowEapm) && $vardef.allowEapm}}
{if isset($fields.{{$vardef.docType}}) && !empty($fields.{{$vardef.docType}}.value) && $fields.{{$vardef.docType}}.value != 'SugarCRM' && !empty($fields.{{$vardef.docUrl}}.value) }
{capture name=imageNameCapture assign=imageName}
{$fields.{{$vardef.docType}}.value}_image_inline.png
{/capture}
<a href="{$fields.{{$vardef.docUrl}}.value}" class="tabDetailViewDFLink" target="_blank">{sugar_getimage name=$imageName alt=$imageName other_attributes='border="0" '}</a>
{/if}
{{/if}}
{{if !empty($displayParams.enableConnectors)}}
{{sugarvar_connector view='DetailView'}}
{{/if}}
