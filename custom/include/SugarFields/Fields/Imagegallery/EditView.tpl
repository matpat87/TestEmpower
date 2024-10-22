<script type="text/javascript" src='{sugar_getjspath file="custom/include/SugarFields/Fields/Imagegallery/SugarFieldImagegallery.js"}'></script>
{{capture name=idName assign=idName}}{{sugarvar key='name'}}{{/capture}}
{{if !empty($displayParams.idName)}}
{{assign var=idName value=$displayParams.idName}}
{{/if}}


{if !empty($fields.id.value)}
    {assign var="file_names" value={{sugarvar key='value' stringFormat=true}} }
    {assign var="record_id" value=$fields.id.value}
    {assign var=files value=$file_names|html_entity_decode|json_decode:true}
	<!-- Gallery Add New Row Button --> 
	<div class="col-xs-12">
        <div class="col-sm-8 email-address-add-line-container emailaddresses" id="">
            <button type="button" class="btn btn-info email-address-add-button" title="Add Gallery Image" id=""
                    onClick="addRow('{{$idName}}' , '{{$module}}')"><span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>
    </div>

    <!-- Gallery Area -->
    <div id="gal_{{$idName}}" class="">

        <!-- original base row start -->
        <div class="row parent col-xs-11 hidden" id="base_row_{{$idName}}">
            <div class="col-sm-6">
                <div>
                    <div class="col-sm-2"><label class="control-label required">Image</label></div>
                    <div class="col-sm-8">
                        <input type='file'
                               onchange="galleryChanged(this, '{{$idName}}', '{$fields.id.value}', '{$module}', '{{$CURRENT_USER_ID}}');"
                               accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" class="form-control">
                        <input type="hidden" class="form-control" value="">
                        <div class="form-control hidden"><img border='0' src='{sugar_getimagepath file="img_loading.gif"}'></div>
                        <div class="form-control hidden"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="col-sm-2">
                    <label class="control-label">Tag</label>
                </div>
                <div class="col-sm-8">
                    <select class="form-control ">
                        {html_options options=$APP_LIST_STRINGS['gallery_images_tags_dom']}
                    </select>
                </div>
            </div>
            <div class="col-sm-1">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-danger email-address-remove-button"
                        onclick="removeRow(this);"
                        data-field="{{$idName}}"
                        data-gallery="gal_{{$idName}}"
                        data-file-id=""
                        data-user-id="{{$CURRENT_USER_ID}}">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                </span>
            </div>
        </div>
        <!-- original base row end -->

        <!-- existing files start -->
        {foreach from=$files item=i name=file}
            {assign var="file_name" value=$i.file_name}
            {assign var="file_tag" value=$i.file_tag}
            {assign var="file_id" value=$i.file_db_id}

            {if !empty($file_name)}
                {assign var="index" value=$smarty.foreach.file.index}
             
                <div class="row parent col-xs-11" id="">
                    <div class="col-sm-6">
                        <div>
                            <div class="col-sm-2"><label class="control-label required">Image</label></div>
                            <div class="col-sm-8">
                                <input type="hidden" value="{$file_name}" name="{{$idName}}[{$index}]" class="form-control gallery-image-{{$idName}}">
                                <input type="hidden" value="{$file_id}" name="{{$idName}}_id[{$index}]" class="form-control">
                                <div class="form-control hidden" id="{{$idName}}_loading_{$index}">
                                    <img border='0' src='{sugar_getimagepath file="img_loading.gif"}'>
                                </div>
                                <div class="form-control" id="{{$idName}}_link_{$index}">{$file_name}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="col-sm-2">
                            <label class="control-label">Tag</label>
                        </div>
                        <div class="col-sm-8">
                            <select class="form-control gallery-image-tag-{{$idName}}" name="{{$idName}}_tag[{$index}]">
                                {html_options options=$APP_LIST_STRINGS['gallery_images_tags_dom'] selected=$file_tag}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger email-address-remove-button"
                                onclick="removeRow(this);"
                                data-field="{{$idName}}"
                                data-gallery="gal_{{$idName}}"
                                data-file-id="{$file_id}"
                                data-user-id="{{$CURRENT_USER_ID}}">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                        </span>
                    </div>
                </div>
            {/if}
        {/foreach}
    <!-- existing files end -->
    </div>
{else}
    <div class="col-xs-12">
		<div class="alert alert-warning" role="alert">
		  <strong>Warning!</strong> {{$CREATE_NO_ID_ERROR}}
		</div> 
    </div>
{/if}