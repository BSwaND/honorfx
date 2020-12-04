/* jce - 2.7.19 | 2019-10-25 | https://www.joomlacontenteditor.net | Copyright (C) 2006 - 2019 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
!function($,Wf){function onBeforeBuildList(){var mode=getMode();"grid"===mode&&$("li.file","#item-list").hide()}function onAfterBuildList(){var mode=getMode();"grid"===mode&&togglePreviewThumbnails()}function loadPreviewThumbnail(item){var src=($(item).attr("id"),$(item).data("preview"));if($(item).data("thumbnail")&&(src=$(item).data("thumbnail")),src){var img=new Image;if($(item).addClass("thumbnail-loading"),$(img).on("load",function(){var span=$(".uk-thumbnail",item).get(0);span||(span=$("<span/>").addClass("uk-thumbnail uk-position-cover").appendTo(item),$.support.backgroundSize?$(span).css("background-image",'url("'+img.src+'")'):$(span).append('<img src="'+img.src+'" />')),$(item).removeClass("thumbnail-loading").addClass("thumbnail-loaded")}),$(img).bind("error.local",function(){$(item).removeClass("thumbnail-loading").addClass("thumbnail-error")}),options.can_edit_images&&options.cache_enable&&!$(item).data("thumbnail")){var args={action:"thumbnail",img:$(item).attr("id")},fields=$(":input","form").serializeArray();$.each(fields,function(i,field){args[field.name]=field.value}),src="index.php?option=com_jce&task=plugin.display&plugin="+$("body").data("plugin")+"&"+$.param(args),$(img).unbind("error.local").bind("error.server",function(){$(this).unbind("error.server").bind("error.local",function(){$(item).removeClass("thumbnail-loading").addClass("thumbnail-error")}),src=$(item).data("preview"),$(item).data("thumbnail")&&(src=$(item).data("thumbnail")),img.src=src})}img.src=src}}function createPreviewThumbnails(force){var area=$("#browser-list").height()+$("#browser-list").scrollTop(),selector=[".thumbnail-loading"];force||selector.concat(".thumbnail-loading",".thumbnail-loaded",".thumbnail-error");var filter=[".jpg",".jpeg",".bmp",".tiff",".png",".webp"];$("#item-list .file").filter(filter.join(",")).not(selector.join(",")).each(function(){var pos=$(this).position();pos.top<area&&loadPreviewThumbnail(this)})}function togglePreviewThumbnails(force){var mode=getMode();"grid"===mode?(createPreviewThumbnails(force),$("#browser-list").bind("scroll.browser-list",function(e){createPreviewThumbnails()}),$("#item-list").data("sortable")&&$("#item-list").sortable("option","axis",!1)):($("#browser-list").unbind("scroll.browser-list"),$("#item-list").unbind("click.item-list-images"),$("#item-list").data("sortable")&&$("#item-list").sortable("option","axis","y"))}function getMode(){var mode=Wf.Cookie.get("wf_"+Wf.getName()+"_mode",options.view_mode);return"images"===mode?"grid":mode}function toggleMode(mode){$("#browser").toggleClass("view-mode-grid","grid"===mode),togglePreviewThumbnails(!0)}function switchMode(){var mode=getMode();mode="list"===mode?"grid":"list",Wf.Cookie.set("wf_"+Wf.getName()+"_mode",mode),toggleMode(mode)}function editImage(){var item=$.fn.filebrowser.getselected(),ed=tinyMCEPopup.editor,iw=parseFloat($(item).data("width")),ih=parseFloat($(item).data("height")),src=($(window).width()-20,$(window).height()-20,$(item).attr("id")),url=$(item).data("preview"),query=url.indexOf("?");query!==-1&&(url=url.substring(0,query));ed.windowManager.open({url:ed.getParam("site_url")+"index.php?option=com_jce&task=plugin.display&plugin="+Wf.getName()+"&layout=editor",size:"mce-modal-landscape-full",close_previous:!1,inline:!0,title:tinyMCEPopup.getLang("dlg.edit_image","Edit Image")},{src:src,url:url,width:iw,height:ih,save:function(item){$(".filebrowser").trigger("filebrowser:load",item)},scope:this})}function getUploadOptions(){var rw=options.upload_resize_width||"",rh=options.upload_resize_height||"",$resize=$('<div class="uk-form-row uk-repeatable uk-flex uk-flex-wrap uk-width-1-1 uk-position-relative uk-placeholder uk-placeholder-small"><div class="uk-width-1-1 uk-width-small-2-10">   <input name="upload_resize_state" type="checkbox" value="0" />   <label for="upload_resize_state" title="'+tinyMCEPopup.getLang("dlg.upload_resize_tip","Resize Image")+'" class="hastip">'+tinyMCEPopup.getLang("dlg.resize","Resize Image")+'</label></div><div class="uk-width-1-1 uk-width-small-5-10 uk-form-constrain uk-flex">   <div class="uk-form-controls uk-width-1-6">       <input type="text" name="upload_resize_width[]" class="uk-text-center" value="" />   </div>   <div class="uk-form-controls uk-width-1-10">       <strong class="uk-form-label uk-text-center uk-vertical-align-middle uk-display-block">&times;</strong>   </div>   <div class="uk-form-controls uk-width-1-6">       <input type="text" name="upload_resize_height[]" class="uk-text-center" value="" />   </div>   <label class="uk-form-label uk-width-1-2"><input class="uk-constrain-checkbox" type="checkbox" checked />'+tinyMCEPopup.getLang("dlg.proportional","Proportional")+'</label></div><div class="uk-width-1-1 uk-width-small-2-10 uk-flex">   <div class="uk-width-9-10 uk-flex">       <label class="uk-form-label uk-width-1-5">'+tinyMCEPopup.getLang("dlg.upload_resize_suffix","Suffix")+'</label>       <div class="uk-form-controls uk-width-4-5">           <input type="text" name="upload_resize_suffix[]" class="uk-margin-small-left" value="" />       </div>   </div></div><div class="uk-text-right uk-position-top-right uk-margin-small-top">   <button class="uk-button uk-button-link uk-repeatable-create"><i class="uk-icon-plus"></i></button>   <button class="uk-button uk-button-link uk-repeatable-delete"><i class="uk-icon-trash"></i></button></div></div>'),$watermark=$('<div class="uk-form-row uk-flex uk-flex-wrap uk-width-1-1 uk-placeholder uk-placeholder-small" id="upload_watermark_options">   <div class="uk-width-1-1 uk-width-small-2-10">       <input id="upload_watermark" name="upload_watermark_state" type="checkbox" value="0" />       <label for="upload_watermark" title="'+tinyMCEPopup.getLang("dlg.upload_watermark_tip","Watermark Image")+'" class="hastip">'+tinyMCEPopup.getLang("dlg.upload_watermark","Watermark Image")+"</label>   </div></div>"),$thumbnail=$('<div class="uk-form-row uk-flex uk-flex-wrap uk-width-1-1 uk-placeholder uk-placeholder-small"><div class="uk-width-1-1 uk-width-small-2-10">   <input name="upload_thumbnail_state" type="checkbox" value="0" />   <label for="upload_thumbnail_state" title="'+tinyMCEPopup.getLang("imgmanager_ext_dlg.upload_thumbnail_tip","Thumbnail")+'" class="hastip">'+tinyMCEPopup.getLang("imgmanager_ext_dlg.thumbnail","Thumbnail")+'</label></div><div class="uk-width-1-1 uk-width-small-5-10 uk-form-constrain uk-flex">   <div class="uk-form-controls uk-width-1-6">       <input type="text" name="upload_thumbnail_width" class="uk-text-center" value="" />   </div>   <div class="uk-form-controls uk-width-1-10">       <strong class="uk-form-label uk-text-center uk-vertical-align-middle uk-display-block">&times;</strong>   </div>   <div class="uk-form-controls uk-width-1-6">       <input type="text" name="upload_thumbnail_height" class="uk-text-center" value="" />   </div>   <label class="uk-form-label uk-width-1-2"><input class="uk-constrain-checkbox" type="checkbox" checked />'+tinyMCEPopup.getLang("dlg.proportional","Proportional")+'</label></div><div class="uk-width-1-1 uk-width-small-2-10">   <label class="uk-form-label uk-width-1-1" title="'+tinyMCEPopup.getLang("imgmanager_ext_dlg.upload_thumbnail_crop","Crop Thumbnail")+'" class="hastip"><input name="upload_thumbnail_crop" type="checkbox" value="0" /> '+tinyMCEPopup.getLang("imgmanager_ext_dlg.upload_thumbnail_crop","Crop Thumbnail")+"</label></div></div>");if(options.upload_resize&&options.can_edit_images){"string"==typeof rw&&(rw=rw.split(",")),"string"==typeof rh&&(rh=rh.split(",")),num=Math.max(rw.length,rh.length);for(var state=parseInt(options.upload_resize_state),i=0;i<num;i++){var $opt=$resize.clone(),w=rw[i]||"",h=rh[i]||"";$("#upload-options").append($opt),$opt.find('input[name^="upload_resize_width"]').val(w),$opt.find('input[name^="upload_resize_height"]').val(h),$opt.find(".uk-constrain-checkbox").constrain(),i>0&&$('input[name="upload_resize_state"]',$opt).remove(),$opt.repeatable().on("repeatable:create",function(e,o,n){$('input[name="upload_resize_state"]',n).remove(),$(n).find(".uk-constrain-checkbox").trigger("constrain:update")}),$opt.find('input[name="upload_resize_state"]').prop("checked",!!state).click(function(){var el=this;this.value=this.checked?1:0,$(".uk-repeatable","#upload-options").each(function(){$(this).find(":input").not(el).prop("disabled",!el.checked)})}).val(state),$opt.find(":input").not('input[name="upload_resize_state"]').prop("disabled",!state)}}if(options.upload_thumbnail&&options.can_edit_images){var tw=options.upload_thumbnail_width||"",th=options.upload_thumbnail_height||"";tw||th||(tw=120,th=90),$("#upload-options").append($thumbnail),$thumbnail.find('input[name^="upload_thumbnail_width"]').val(tw),$thumbnail.find('input[name^="upload_thumbnail_height"]').val(th),$thumbnail.find(".uk-constrain-checkbox").constrain();var state=parseInt(options.upload_thumbnail_state);$thumbnail.find('input[name="upload_thumbnail_state"]').prop("checked",!!state).click(function(){this.value=this.checked?1:0,$thumbnail.find(":input").not(this).prop("disabled",!this.checked)}).val(state),$thumbnail.find(":input").not('input[name="upload_thumbnail_state"]').prop("disabled",!state);var crop_state=parseInt(options.upload_thumbnail_crop);$thumbnail.find('input[name="upload_thumbnail_crop"]').prop("checked",!!crop_state).click(function(){this.value=this.checked?1:0}).val(crop_state)}if(options.upload_watermark&&options.can_edit_images){var state=parseInt(options.upload_watermark_state);$("#upload-options").append($watermark).find('input[name="upload_watermark_state"]').prop("checked",!!state).click(function(){this.value=this.checked?1:0}).val(state)}(options.upload_resize||options.upload_watermark)&&options.can_edit_images&&($("#upload-options").prepend('<h4 class="uk-text-bold">'+tinyMCEPopup.getLang("dlg.image_options","Image Options")+"</h4>"),$("#upload-options").show(),$(".hastip","#upload-options").tips()),$("#upload-queue").on("uploadwidget:fileadded",function(e,file){if(/^(jpg|jpeg|png|bmp|tiff|gif)$/i.test(file.extension)&&options.upload_resize&&options.can_edit_images){$('<div class="uk-flex uk-flex-wrap uk-width-1-1 queue-item-resize uk-placeholder uk-placeholder-small uk-repeatable uk-position-relative uk-hidden"> <div class="uk-width-1-1 uk-width-small-1-6">   <label for="upload_resize" title="'+tinyMCEPopup.getLang("dlg.upload_resize_tip","Resize")+'">'+tinyMCEPopup.getLang("dlg.resize","Resize")+'</label> </div><div class="uk-width-1-1 uk-width-small-4-10 uk-flex uk-form-constrain">   <div class="uk-form-controls uk-width-1-6">       <input type="text" name="upload_file_resize_width[]" class="uk-text-center" value="" />   </div>   <div class="uk-form-controls uk-width-1-10">       <strong class="uk-form-label uk-text-center uk-vertical-align-middle uk-display-block">&times;</strong>   </div>   <div class="uk-form-controls uk-width-1-6">       <input type="text" name="upload_file_resize_height[]" class="uk-text-center" value="" />   </div>   <label class="uk-form-label"><input class="uk-constrain-checkbox" type="checkbox" checked />'+tinyMCEPopup.getLang("dlg.proportional","Proportional")+'</label></div><div class="uk-width-1-1 uk-width-small-3-10">   <div class="uk-repeatable-hidden-first uk-width-1-1 uk-flex uk-margin-small-top">       <label class="uk-form-label uk-width-1-5 uk-width-small-3-10">'+tinyMCEPopup.getLang("dlg.upload_resize_suffix","Suffix")+'</label>       <div class="uk-form-controls uk-width-4-5 uk-width-small-7-10">           <input type="text" name="upload_file_resize_suffix[]" value="" />       </div>   </div></div> <div class="uk-position-top-right uk-margin-small-top">   <button class="uk-button uk-button-link uk-repeatable-create uk-float-right"><i class="uk-icon-plus"></i></button>   <button class="uk-button uk-button-link uk-repeatable-delete uk-float-right"><i class="uk-icon-trash"></i></button> </div></div>').appendTo(file.element).repeatable().on("repeatable:create",function(e,o,n){$(n).find(".uk-constrain-checkbox").trigger("constrain:update")}).find(".uk-constrain-checkbox").constrain();var btn=$('<button class="uk-button uk-button-link queue-item-action" title="'+tinyMCEPopup.getLang("dlg.resize_item_options","Options")+'"><i class="uk-icon uk-icon-gear"></i></button>').click(function(e){e.preventDefault(),e.stopPropagation(),$(".queue-item-resize",file.element).toggleClass("uk-hidden")});$(".queue-item-actions",file.element).append(btn)}})}function onInit(e,o){var mode=getMode();$('<button class="uk-button view-mode" aria-label="View Mode"><i class="uk-icon-list"></i><i class="uk-icon-grid"></i></button>').insertBefore("#show-details").click(function(){switchMode()}),$("#show-details").click(function(e){"grid"===mode&&createPreviewThumbnails()}),"grid"===mode&&toggleMode(mode)}function onUpload(){}var options={view_mode:"list"};$(window).ready(function(){$("input.filebrowser").on("filebrowser:oninit",onInit).on("filebrowser:onbeforebuildList",onBeforeBuildList).on("filebrowser:onafterbuildlist",onAfterBuildList).on("filebrowser:onpaste",onAfterBuildList).on("filebrowser:editimage",editImage).on("filebrowser:onuploadopen",getUploadOptions).on("filebrowser:onupload",onUpload).on("filebrowser:onlistsort",createPreviewThumbnails).on("filebrowser:onmaximise",createPreviewThumbnails),options=$.extend(options,FileBrowser.options)})}(jQuery,Wf);