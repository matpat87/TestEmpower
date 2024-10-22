<link rel="stylesheet" type="text/css" href="custom/include/SugarFields/Fields/Imagegallery/css/style.css">
<script type="text/javascript" src="custom/include/SugarFields/Fields/Imagegallery/js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="custom/include/SugarFields/Fields/Imagegallery/js/jcarousel.responsive.js"></script>
<script type="text/javascript" src="custom/include/SugarFields/Fields/Imagegallery/js/jquery.magnific-popup.min.js"></script>

{if strlen({{sugarvar key='value' string=true}}) <= 0}
    {assign var="value" value={{sugarvar key='default_value' string=true}} }
{else}
    {assign var="value" value={{sugarvar key='value' string=true}} }
{/if}

{assign var=record_id value=$fields.id.value}
{assign var=files value=$value|html_entity_decode|json_decode:true}
{assign var=file_field value={{sugarvar key='name' string=true}}}

{{if $GALLERY_LIC}}

	{if count($files) > 0 }
	<div class="gallery-wrapper">
		<div class="jcarousel-wrapper">
			<div class="jcarousel html-code grid-of-images">
				<ul class="zoom-gallery">
				{foreach from=$files item=file}
					{if !empty($file)}
						{assign var="file_name" value=$file.file_name}
						{assign var="file_tag" value=$file.file_tag}
						{assign var="filepath" value="{{$PATH}}{{$MODULE}}/$record_id/$file_field/$file_name"}
						{foreach from=$APP_LIST_STRINGS['gallery_images_tags_dom'] item=tag_value key=tag_key}
							{if ($tag_key == $file_tag)}
								{assign var="imagetag" value=$tag_value}
							{/if}
						{/foreach}

						{if file_exists($filepath)}
						<li>
							<a class="image-link" href="{{$FILE_VIEW_PATH}}{{$MODULE}}/{$record_id}/{$file_field}/{$file_name}" title="{$imagetag}">
								<img src="{{$FILE_VIEW_PATH}}{{$MODULE}}/{$record_id}/{$file_field}/{$file_name}" alt="{$imagetag}" />
							</a>
							<p>
							 {$imagetag}
							</p>
						</li>
						{/if}
					{/if}
				{/foreach}
				</ul>
			</div>
			<a href="#p" class="jcarousel-control-prev">&lsaquo;</a> <a href="#n" class="jcarousel-control-next">&rsaquo;</a>
			<p class="jcarousel-pagination"></p>
		</div>
	</div>
	{literal}
	<script type="text/javascript">
	$(document).ready(function() {
		$('.zoom-gallery').magnificPopup({
			delegate: 'a',
			type: 'image',
			closeOnContentClick: false,
			closeBtnInside: false,
			mainClass: 'mfp-with-zoom mfp-img-mobile',
			image: {
				verticalFit: true,
				titleSrc: function(item) {
					return item.el.attr('title');
				}
			},
			gallery: {
				enabled: true
			},
			zoom: {
				enabled: false,
				duration: 300,
				opener: function(element) {
					 return element.is('img') ? element : element.find('img');
				}
			}
		});
	});
	</script>
	{/literal}
	{/if}
{{else}}
 	<div class="col-xs-12">
		<div class="alert alert-danger" role="alert">
		  <strong>Alert!</strong> {{$LICENSE_EXPIRED}}
		</div>
    </div>
{{/if}}
