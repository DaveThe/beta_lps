var imgs;
var ids = '[';
var startUploadForm = function() {
    
    preview_list = "{";
    
    $('div[class^=MKU_IMG]').each(function(){
        var idimg = $("input", this).attr('id');
        var srcimg = $("input", this).attr('value');
        preview_list += '"'+this.id+'": { "img": "'+srcimg+'", "id_img": "'+idimg+'"},';    
        ids += '{"id": "#'+this.id+'"},';     
        $(this).replaceWith((template['IMG']).replace(/MKUID/g,this.id));   
        if(srcimg != '')
        {
            var path = (this.id).replace(/\_/g, '/');
            
            $( "#"+this.id+"_img_src" ).attr('src','/media/'+path+"/"+srcimg); 
            $( "#"+this.id+"_text-avatar" ).attr('value',srcimg); 
        }
        imgs = $("#"+this.id+"_"+opts.dropZone).html();
        //if(opts.debug) { console.log($("#"+this.id+"_"+opts.dropZone).html()); }
    });
    $('div[class^=MKU_FULL]').each(function(){
        var idimg = $("input", this).attr('id');
        var srcimg = $("input", this).attr('value');
        preview_list += '"'+this.id+'": { "img": "'+srcimg+'", "id_img": "'+idimg+'"},'; 
        ids += '{"id": "#'+this.id+'"},';
        $(this).replaceWith((template['FULL']).replace(/MKUID/g,this.id));    
        if(srcimg != '')
        {   
            var path = (this.id).replace(/\_/g, '/');
            $("#"+this.id+"_"+opts.dropZoneId_finish).fadeIn();
            $( "#"+this.id+"_list_group" ).append( '<a href="#" class="list-group-item list-group-item-success" onclick="openImg(\'/media/'+path+"/"+srcimg+'\');"><span class="badge alert-success pull-right">Success</span>'+srcimg+'</a>' );
            $( "#"+this.id+"_list_group" ).append( '<input type="hidden" name="'+idimg+'" id="img" value="'+srcimg+'" />' ); 
        }
    });
    $('div[class^=MKU_DND]').each(function(){
        var idimg = $("input", this).attr('id');
        var srcimg = $("input", this).attr('value');
        preview_list += '"'+this.id+'": { "img": "'+srcimg+'", "id_img": "'+idimg+'"},'; 
        ids += '{"id": "#'+this.id+'"},';
        $(this).replaceWith((template['DND']).replace(/MKUID/g,this.id)); 
        if(srcimg != '')
        {
            var path = (this.id).replace(/\_/g, '/');
            $("#"+this.id+"_"+opts.dropZoneId_finish).fadeIn();
            $( "#"+this.id+"_list_group" ).append( '<a href="#" class="list-group-item list-group-item-success" onclick="openImg(\'/media/'+path+"/"+srcimg+'\');"><span class="badge alert-success pull-right">Success</span>'+srcimg+'</a>' );
            $( "#"+this.id+"_list_group" ).append( '<input type="hidden" name="'+idimg+'" id="img" value="'+srcimg+'" />' ); 
        }
    });        
    $("button[name^=upload_btn_]").on("click",function(){
        var result = this.name.replace('upload_btn_','');
        $(this).uploadFile('img-post',result.toUpperCase()); 
    });
    
    if(opts.list)
    {
        preview_list = preview_list.slice(0, -1);
        preview_list += "}";
        preview_list = $.parseJSON(preview_list);
    }
    
    ids = ids.slice(0, -1);
    ids += "]";
    ids          = $.parseJSON(ids);
    //console.log(ids);
    //console.log($.parseJSON(ids));
    //console.log($.parseJSON(preview_list)['home'].id_img);
    //console.log($.parseJSON(preview_list).news);
};

/*
* Variabili utilizzate dalle funzioni
*/
var max_file_size   = 21;
var file_type       = "";
var div_img_id = null;
var opts = null;
var lng = '';
var dropZoneId_finish = '';
/*
var jsonL = 'plugin/MagicUpload/core/js/lang.js';
$.getJSON('plugin/MagicUpload/core/js/lang.js', function(data) {
                                    langTxt = data;

                                  });*/

                                   
 $.fn.MagicUpload = function(options) {
    var defaults = {
      Anchor                : "panel-body", //classe di ancoraggio per recuperare l'id di upload
      drop                  : false, //abilita funzione drag and drop
      dropZone              : 'drop-zone', //id zona drag drop
      uploadForm            : 'js-upload-form', //id form upload
      inputfiles            : 'js-upload-files', //id input file
      dropZoneCss           : 'upload-drop-zone', //classe css per la zona del drag and drop
      dropZoneCss_drop      : 'upload-drop-zone drop', //stile grafico per quando si passa un file sopra alla zona dd
      dropZoneId_finish     : 'js-upload-finished', //id sezione elenco file già caricati
      error_shake           : true, //error shake
      errorCss              : 'error', //css errore
      successCss            : 'good', //css successo
      lang                  : 'EN', // lingua messaggi
	  list                  : true, // visualizzare lista file caricati
      preview               : false, // visualizzare anteprima
      previewImg            : '',  // immagine anteprima da visualizzare
      multiUpload           : true,  //abilita l'upload di più immagini con un solo drag and drop
      debug                 : false  //abilita i console log
    }
    
    //##############################
    //## Private Variables
    //##############################
    opts = $.extend(defaults, options);
    dropZoneId_finish = opts.dropZoneId_finish;
    startUploadForm();
/* -------------------------------INIZIO-------------------------------------------
* Le seguenti funzioni servono per il funzionamento del drag & drop upload
*  -------------------------------INIZIO-------------------------------------------
*/
//$(function() {
    if(opts == null){return;}
    lng = opts.lang;
    //console.log(langTxt[lng].retry);
    //console.log(langTxt.opts.lang.retry);
    //$('#'+div_img_id).find("div#"+opts.dropZone)
    
    var dropZone = $("."+opts.dropZone);//document.getElementById(opts.dropZone);
    var uploadForm = $("#"+opts.uploadForm);//document.getElementById(opts.uploadForm);
    
    /*
    var dropZone = document.getElementById(opts.dropZone);
    var uploadForm = document.getElementById(opts.uploadForm);
    */
    var startUpload = function(files) {
        console.log(files);
        console.log(div_img_id);
        if(typeof div_img_id !== 'undefined')
        {
            $.ajax({dataType: "json",
                    url: "plugin/MagicUpload/core/class/GetConfig.php",
                    data: 'section=' + div_img_id, 
                    success: function(result){
                        
                            console.log(result);
                            if(result.err !== '')
                            {     
                                
                                $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
                                $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss); 
                                if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );         
                                $("#"+div_img_id+"_"+opts.dropZone).html( result.err+langTxt[lng].retry );
                                       
                            }
                            else
                            {
                                max_file_size = result.max_size;
                                file_type = result.fle_type;
                                
                                if(file_type=="IMG") 
                                { 
                                	ext_list= ["image/png","image/gif","image/jpeg","image/pjpeg"];	
                                }
                                else
                                {        
                                    ext_list= ["application/pdf", "application/zip"];
                                }
                                validateFile(files);
                            }
                        }
                    });
        }
        else
        {
            console.log('Errore bloccante!');
        }
    };
    var formid = '';
    var dropzoneid = '';
    var avatarUpload = '';
    var avatar = '';
    for(var i = 0; i < ids.length; i++) { 
        formid += ids[i].id+"_"+opts.uploadForm+", ";
        dropzoneid += ids[i].id+"_"+opts.dropZone+", ";
        avatarUpload += ids[i].id+"_upload_btn, ";
        avatar += ids[i].id+"_avatar, ";
    }
    
    $(formid.slice(0, -2)).bind('submit', function(e) {
        div_img_id = $(this).closest("."+opts.Anchor).attr("id");console.log(div_img_id);
        var uploadFiles = $('#'+div_img_id).find("input#"+opts.inputfiles)[0].files;
        e.preventDefault();
        startUpload(uploadFiles);
    });  
    
    //bind click
    $(avatarUpload.slice(0, -2)).click(function(event) {
      $("#"+(this.id).replace(/_upload_btn/g,'')+"_avatar").click();
    });

    //capture selected filename
    $(avatar.slice(0, -2)).change(function(click) {
      $("#"+(this.id).replace(/_avatar/g,'')+"_text-avatar").val((this.value).replace(/^.*\\/, ""));
        div_img_id = (this.id).replace(/_avatar/g,'');console.log(div_img_id);
        //console.log($(this));
        var uploadFiles = $(this)[0].files;
        console.log(uploadFiles);
        startUpload(uploadFiles);
    });
    
    /*
    uploadForm.addEventListener('submit', function(e) {
        var uploadFiles = document.getElementById(opts.inputfiles).files;
        div_img_id = $(this).closest("."+opts.Anchor).attr("id");
        e.preventDefault();

        startUpload(uploadFiles);
    }); 
        console.log(ids);
        $.each(ids, function(idx, obj) {
        	console.log(obj.tagName);
        });
    */
    
    $(dropzoneid.slice(0, -2)).on("drop", function(e) {//.ondrop = function(e) {
        e.preventDefault();
        this.className = opts.dropZoneCss;
        console.log((this.id).replace('_'+opts.dropZone,''));
        div_img_id = (this.id).replace('_'+opts.dropZone,'');//$(this).closest("."+opts.Anchor).attr("id");
        if(opts.debug) { console.log(e.originalEvent.dataTransfer.files); }
        console.log(div_img_id);
        var files = e.originalEvent.dataTransfer.files;
        if( (opts.drop && opts.multiUpload))
        {
            for (var i = 0, f; f = files[i]; i++)
            {
                startUpload(f);
            }
        }
        else
        {     
            if(opts.debug) { console.log("# file "+files.length);}
            if( files.length > 1 )
            {
                $('<div></div>').appendTo('body')
                                .html('<div><h6>'+langTxt[lng].no_multiupload+'</h6></div>')
                                .dialog({
                                    modal: true,
                                    title: langTxt[lng].warning,
                                    zIndex: 10000,
                                    autoOpen: true,
                                    width: 'auto',
                                    resizable: false,
                                    buttons: {
                                        Yes: function () {
                                            // $(obj).removeAttr('onclick');                                
                                            // $(obj).parents('.Parent').remove();                        
                                            
                                            startUpload(files[0]);
                                            
                                            $(this).dialog("close");
                                        },
                                        No: function () {
                                            $(this).dialog("close");
                                        }
                                    },
                                    close: function (event, ui) {
                                        $(this).remove();
                                    }
                                });
            }
            else
            {
                startUpload(files[0]);
            }
        }
    });

    $(dropzoneid.slice(0, -2)).on("dragover", function(e) {//dropZone.ondragover = function() { 
        this.className = opts.dropZoneCss_drop;
        return false;
    });

    $(dropzoneid.slice(0, -2)).on("dragleave", function(e) {//dropZone.ondragleave = function() {console.log(this.className);
        this.className = opts.dropZoneCss;
        return false;
    });
    
};
//);
/* -------------------------------FINE-------------------------------------------
* Le seguenti funzioni servono per il funzionamento del drag & drop upload
*  -------------------------------FINE-------------------------------------------
*/


/*
* Funzione per controllare che il file passato rispetta i vincoli
* In caso di errore attiva la segnalazione su schermo
*/
function validateFile(file_source)
{	if(opts.debug) { console.log(file_source.name); }
	var file = file_source;//[0];//.files[0];
    var name = file.name;
    var size = file.size;
    var type = file.type;
	if(size<=max_file_size*1024*1024)
	{          
		if(ext_list.indexOf(type)!=-1)
		{    
			$("#"+div_img_id+"_"+opts.dropZone).html(name); 
            $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
            $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.successCss);
            $("#"+div_img_id+"_"+opts.dropZone).html( langTxt[lng].loading ); 
            $("#"+div_img_id+"_js-upload-form").data("files", file);
            //uploadFile(file_source[0]);
            uploadFile(file);
		}
		else
		{   
            $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
            $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss);
            if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );         
            $("#"+div_img_id+"_"+opts.dropZone).html( langTxt[lng].NotAllowed );  
		}
        
	}
	else
	{   
        if(opts.debug) { console.log('size ko'); }
        $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
        $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss);     
        if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );         
        $("#"+div_img_id+"_"+opts.dropZone).html( langTxt[lng].TooBig );
	}
    
   
}


/* -------------------------------INIZIO-------------------------------------------
* Le seguenti funzioni servono per verificare quali tecnologie supporta il browser
*  -------------------------------INIZIO-------------------------------------------
*/
$(document).ready(function(e) {
    if(supportAjaxUploadWithProgress())
	{
		if(FirefoxDetect())
		{
			//NEW VERSION
			$("#form_ie").remove();
			$(".upload_button").show();
		}
		else
		{
			//OLDER VERSION
			$("#"+opts.uploadForm+" h4").text(langTxt[lng].status);
			$(".progress").hide();
		}
	}
	else
	{
		//OLDER VERSION
		$("#"+opts.uploadForm+" h4").text(langTxt[lng].status);
		$(".progress").hide();
	}
	
});
function supportAjaxUploadWithProgress() 
{
      return supportFileAPI() && supportAjaxUploadProgressEvents();
}

function supportFileAPI() 
{
         var fi = document.createElement('INPUT');
          fi.type = 'file';
         return 'files' in fi;
}
 
function supportAjaxUploadProgressEvents() 
{
         var xhr = new XMLHttpRequest();
         return !! (xhr && ('upload' in xhr) && ('onprogress' in xhr.upload));
}

function FirefoxDetect()
{
	var det_firefox;
	if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1)
	{
		det_firefox= parseInt(navigator.userAgent.toLowerCase().substr(navigator.userAgent.toLowerCase().indexOf('firefox/')+8,3)+"0");
	}
	else
	{
		return true;
	}
	if(det_firefox > 20)
	{
		 return true;
	}
	else
	{
		return false;
	}
}
/* -------------------------------FINE-------------------------------------------
* Le seguenti funzioni servono per verificare quali tecnologie supporta il browser
*  -------------------------------FINE-------------------------------------------
*/


/* -------------------------------INIZIO-------------------------------------------
* Le seguenti funzioni si occupano dell'effettivo caricamento dell'immagine
* creando anche l'effetto della progressbar
*  -------------------------------INIZIO-------------------------------------------
*/
function uploadFile(file_source)
{
    var formData = new FormData($(opts.uploadForm)[0]);
    formData.append('section',div_img_id);
    formData.append('files[]',file_source);
    if(opts.debug) { console.log("FormData - "); console.log(formData);}
        
    $.ajax({
        url: 'plugin/MagicUpload/core/upload.php',  //Server script to process data
        type: 'POST',
        xhr: function() {  // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload)
            { 
                // Check if upload property exists
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            }
            return myXhr;
        },
        //Ajax events
        beforeSend: beforeSendHandler,
        success: completeHandler,
        error: errorHandler,
        // Form data
        data: formData,
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });
    
}
function progressHandlingFunction(e)
{
    if(e.lengthComputable)
    {
        if(opts.debug) { console.log("progess: "+(e.loaded/e.total)*100); }
		$("#"+div_img_id+"_progress-bar").css("width",(e.loaded/e.total)*100+"%");
		$('.percent').text(Math.round(e.loaded/e.total)*100+"%");
		if(opts.debug) { console.log(Math.round(e.loaded/e.total)*100+"%"); }
		if(Math.round(e.loaded/e.total)*100==100)
		{
            $("#"+div_img_id+"_progress-bar").css("background-color", "rgb(74, 173, 74)"); 
            $("#"+div_img_id+"_progress-bar").css("border-color", "rgb(74, 173, 74)"); 
            $("#"+div_img_id+"_progress-bar").css("color", "rgb(74, 173, 74)");      
		}
    }
    
}
function beforeSendHandler(e)
{
    if(opts.debug) { console.log(' ---beforeSendHandler-- '); }
	if(opts.debug) { console.log(e); }
}
function completeHandler(e)
{
    if(opts.debug) { console.log(' ---completeHandler start-- '+e); }
	var objJson = JSON.parse(e);
	
	if ( objJson )
	{		
		if(objJson.error !== 0)
		{
			$("#"+div_img_id+"_"+opts.dropZone).html(objJson.error); 
            $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
            $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss);
            if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );
            if(opts.debug) { console.log(' ---completeHandler 1-- '); }
		}
		else
		{     
		      
            if(opts.debug) { console.log('file_type --  '+file_type); }
			if(file_type=="IMG")
			{	
				if(objJson.image.result_resize)
				{
					if(objJson.image.result_thumb)
					{
                        $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
                        $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.dropZoneCss);
                        $("#"+div_img_id+"_"+opts.dropZone).html( langTxt[lng].upload_ok );
                        if(opts.list)
                        {
                            $("#"+div_img_id+"_"+opts.dropZoneId_finish).fadeIn();
                            $( "#"+div_img_id+"_list_group" ).append( '<a href="#" class="list-group-item list-group-item-success" onclick="openImg(\' '+objJson.filedir+"/"+objJson.filename+'\');"><span class="badge alert-success pull-right">Success</span>'+objJson.filename+'</a>' );
                            $( "#"+div_img_id+"_list_group" ).append( '<input type="hidden" name="'+preview_list[div_img_id].id_img+'" id="img" value="'+objJson.filename+'" />' ); 
                            //console.log("#"+div_img_id+"_img_src");console.log(objJson.filedir+objJson.filename);
                            //$( "#"+div_img_id+"_img_src" ).attr('src',objJson.filedir+"/"+objJson.filename);
                            
                            //$("#"+div_img_id+"_"+opts.dropZone).html( '<img id="'+div_img_id+'_img_src" class="thumbnail img-responsive" style="min-height: 225px; min-width: 225px;" src="'+objJson.filedir+"/"+objJson.filename+'" />' );
                            
                        }
                        else
                        {
                            if(opts.debug) { console.log('immagine --  '+objJson.filedir+objJson.filename); }
                            if(opts.debug) { console.log(objJson); }
                            $("#"+div_img_id+"_"+opts.dropZone).html(imgs);
                            $( "#"+div_img_id+"_img_src" ).attr('src',objJson.filedir+objJson.filename); 
                            $( "#"+div_img_id+"_text-avatar" ).attr('value',objJson.filename);
                            $( "#extra_photo" ).attr('value',JSON.stringify(objJson.exif_data) );
                            $( "#extra_photo_average_colour" ).attr('value',objJson.average_colour );
                            $( "#extra_photo_Lat" ).attr('value',objJson.Lat );
                            $( "#extra_photo_Lng" ).attr('value',objJson.Lng );
                        }
                        
                        if(opts.preview)
                        {
                            alert(langTxt[lng].no_preview);
                        }
                        if(opts.debug) { console.log(' ---completeHandler 2-- '); }
					}
					else
					{
                        $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
                        $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss);
                        if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );         
                        $("#"+div_img_id+"_"+opts.dropZone).html( langTxt[lng].error_thumbs );  
						 
                        if(opts.debug) { console.log(' ---completeHandler 3-- '); }
					}
				}
				else
				{
                    $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
                    $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss);
                    if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );         
                    $("#"+div_img_id+"_"+opts.dropZone).html( langTxt[lng].upload_ko );  
					 
                    if(opts.debug) { console.log(' ---completeHandler 4-- '); }
				}
			}
			else
			{            
                $("#"+div_img_id+"_"+opts.dropZone).html( langTxt[lng].upload_ok );
                $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
                $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.dropZoneCss);
                if(opts.list)
                {
                    $("#"+div_img_id+"_"+opts.dropZoneId_finish).fadeIn();
                    $( "#"+div_img_id+"_list_group" ).append( '<a href="#" class="list-group-item list-group-item-success"><span class="badge alert-success pull-right">Success</span>'+objJson.filename+'</a>' );
                }
                if(opts.debug) { console.log(' ---completeHandler 5-- '); }
                
				//saveUpload('echo(isset($elem_id)?$elem_id:''); ',objJson.filedir,objJson.filename);
                
			}
		}
	}
	else
	{
        $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
        $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss);
        if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );         
        $("#"+div_img_id+"_"+opts.dropZone).text( e+langTxt[lng].retry ); 
	}
    if(opts.debug) { console.log(' ---completeHandler Exit-- '); }
	
}
function errorHandler(e)
{
    if(opts.debug) { console.log(' ---errorHandler-- '+e); }
    
    $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
    $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss);
    if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );         
    $("#"+div_img_id+"_"+opts.dropZone).text( langTxt[lng].upload_ko ); 
}
/* -------------------------------FINE-------------------------------------------
* Le seguenti funzioni si occupano dell'effettivo caricamento dell'immagine
* creando anche l'effetto della progressbar
*  -------------------------------FINE-------------------------------------------
*/