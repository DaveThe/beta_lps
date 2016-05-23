/********SCRIPT UPLOAD********/

/*                                      INIZIO
* VARIABILI NECESSARIE ALLO STORAGE DI EVENTUALI IMMAGINI CARICATE IN PRECEDENZA NEL DB
*/
var imgs;
var ids = '[';
/*                                      FINE
* VARIABILI NECESSARIE ALLO STORAGE DI EVENTUALI IMMAGINI CARICATE IN PRECEDENZA NEL DB
*/
var startUploadForm = function() {
    
    preview_list = "{";
    /*
    *   OGNI EACH VA A CERCARE UNA CLASSE CON AL SUO INTERNO LA PAROLA CHIAVE MKU_ E UN'IDENTIFICATIVO SCELTO DAL PROGRAMMATORE
    */
    $('div[class^=MKU_AVATARS]').each(function()
    {
        var idimg       = $("input", this).attr('id');
        var srcimg      = $("input", this).attr('value');
        preview_list    += '"'+this.id+'": { "img": "'+srcimg+'", "id_img": "'+idimg+'"},';    
        ids             += '{"id": "#'+this.id+'"},';
             
        $(this).replaceWith((template['AVATARS']).replace(/MKUID/g,this.id));
          
        //console.log('AVATARS'+this.id);
         
        if(srcimg != '')
        {
            var path    = (this.id).replace(/\_/g, '/');
            
            $( "#"+this.id+"_img_src" ).attr('src','/media/'+path+"/"+srcimg); 
            $( "#"+this.id+"_text-avatar" ).attr('value',srcimg); 
        }
        
        imgs            = $("#"+this.id+"_"+opts.dropZone).html();
        
        //if(opts.debug) { console.log($("#"+this.id+"_"+opts.dropZone).html()); }
    });
    
    $('div[class^=MKU_UPL]').each(function()
    {
        var idimg       = $("input", this).attr('id');
        var srcimg      = $("input", this).attr('value');
        preview_list    += '"'+this.id+'": { "img": "'+srcimg+'", "id_img": "'+idimg+'"},';    
        ids             += '{"id": "#'+this.id+'"},';     
        
        $(this).replaceWith((template['UPLOAD']).replace(/MKUID/g,this.id));   
        
        if(srcimg != '')
        {
            var path    = (this.id).replace(/\_/g, '/');
            
            $( "#"+this.id+"_img_src" ).attr('src','/media/'+path+"/"+srcimg); 
            $( "#"+this.id+"_text-upload" ).attr('value',srcimg); 
        }
        
        imgs            = $("#"+this.id+"_"+opts.dropZone).html();
        
        //if(opts.debug) { console.log($("#"+this.id+"_"+opts.dropZone).html()); }
    });
    
    $('div[class^=MKU_IMG]').each(function()
    {
        var idimg       = $("input", this).attr('id');
        var srcimg      = $("input", this).attr('value');
        preview_list    += '"'+this.id+'": { "img": "'+srcimg+'", "id_img": "'+idimg+'"},';    
        ids             += '{"id": "#'+this.id+'"},';    
        
        $(this).replaceWith((template['IMG']).replace(/MKUID/g,this.id));   
        
        if(srcimg != '')
        {
            var path    = (this.id).replace(/\_/g, '/');
            
            $( "#"+this.id+"_img_src" ).attr('src','/media/'+path+"/"+srcimg); 
            $( "#"+this.id+"_text-avatar" ).attr('value',srcimg); 
        }
        
        imgs            = $("#"+this.id+"_"+opts.dropZone).html();
        
        //if(opts.debug) { console.log($("#"+this.id+"_"+opts.dropZone).html()); }
    });
    
    $('div[class^=MKU_FULL]').each(function()
    {
        var idimg       = $("input", this).attr('id');
        var srcimg      = $("input", this).attr('value');
        preview_list    += '"'+this.id+'": { "img": "'+srcimg+'", "id_img": "'+idimg+'"},'; 
        ids             += '{"id": "#'+this.id+'"},';
        
        $(this).replaceWith((template['FULL']).replace(/MKUID/g,this.id));
            
        if(srcimg != '')
        {   
            var path    = (this.id).replace(/\_/g, '/');
            
            $("#"+this.id+"_"+opts.dropZoneId_finish).fadeIn();
            $( "#"+this.id+"_list_group" ).append( '<a href="#" class="list-group-item list-group-item-success" onclick="openImg(\'/media/'+path+"/"+srcimg+'\');"><span class="badge alert-success pull-right">Success</span>'+srcimg+'</a>' );
            $( "#"+this.id+"_list_group" ).append( '<input type="hidden" name="'+idimg+'" id="img" value="'+srcimg+'" />' ); 
        }
        
    });
    
    $('div[class^=MKU_DND]').each(function()
    {
        var idimg       = $("input", this).attr('id');
        var srcimg      = $("input", this).attr('value');
        preview_list    += '"'+this.id+'": { "img": "'+srcimg+'", "id_img": "'+idimg+'"},'; 
        ids             += '{"id": "#'+this.id+'"},';
        
        $(this).replaceWith((template['DND']).replace(/MKUID/g,this.id));
         
        if(srcimg != '')
        {
            var path    = (this.id).replace(/\_/g, '/');
            
            $("#"+this.id+"_"+opts.dropZoneId_finish).fadeIn();
            $( "#"+this.id+"_list_group" ).append( '<a href="#" class="list-group-item list-group-item-success" onclick="openImg(\'/media/'+path+"/"+srcimg+'\');"><span class="badge alert-success pull-right">Success</span>'+srcimg+'</a>' );
            $( "#"+this.id+"_list_group" ).append( '<input type="hidden" name="'+idimg+'" id="img" value="'+srcimg+'" />' ); 
        }
        
    });
      
    $('div[class^=MKU_UPDND]').each(function()
    {
        var idimg       = $("input", this).attr('id');
        var srcimg      = $("input", this).attr('value');
        preview_list    += '"'+this.id+'": { "img": "'+srcimg+'", "id_img": "'+idimg+'"},'; 
        ids             += '{"id": "#'+this.id+'"},';
        
        $(this).replaceWith((template['UPLDND']).replace(/MKUID/g,this.id));
         
        if(srcimg != '')
        {
            var path    = (this.id).replace(/\_/g, '/');
            
            $("#"+this.id+"_"+opts.dropZoneId_finish).fadeIn();
            $( "#"+this.id+"_list_group" ).append( '<li class="box-photo-add-vuoto-caricamento"><img style="height: 177px; width: 200px;" src="\'/media/'+path+"/"+srcimg+'\'" onclick="openImg(\'/media/'+path+"/"+srcimg+'\');"><img src="images/add-image.png" width="32" class="img-abs-center" alt=""></li>');
            //$( "#"+this.id+"_list_group" ).append( '<div class="box-photo-add-vuoto"><img style="height: 177px; width: 200px;" src="\'/media/'+path+"/"+srcimg+'\'" onclick="openImg(\'/media/'+path+"/"+srcimg+'\');" /><img src="images/add-image.png" width="32" class="img-abs-center" alt=""/></div>' );
            $( "#"+this.id+"_list_group" ).append( '<input type="hidden" name="'+idimg+'" id="img" value="'+srcimg+'" />' ); 
            /*
            $( "#"+this.id+"_list_group" ).append( '<a href="#" class="list-group-item list-group-item-success" onclick="openImg(\'/media/'+path+"/"+srcimg+'\');"><span class="badge alert-success pull-right">Success</span>'+srcimg+'</a>' );
            $( "#"+this.id+"_list_group" ).append( '<input type="hidden" name="'+idimg+'" id="img" value="'+srcimg+'" />' ); */
        }
        
    }); 
          
    $("button[name^=upload_btn_]").on("click",function()
    {
        var result      = this.name.replace('upload_btn_','');
        $(this).uploadFile('img-post',result.toUpperCase()); 
    });
    
    /*
    *   COSTRUISCO GLI ARRAY PER MOSTRARE LE EVENUTALI IMMAGINI CARICATE IN PRECEDENZA
    */
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
    // variabile di default per dimensione massima immagine caricata
    var max_file_size   = 30;
    // variabile di default per la tipologia di immagini ammesse
    var file_type       = "";
    // variabile che conterrà l'id principale del blocco di upload
    var div_img_id = null;
    // variabile di default per le opzioni del plugin
    var opts = null;
    // variabile di default per la lingua da adottare
    var lng = '';
    // variabile di default per l'id del blocco da riempire con le foto caricate correttamente
    var dropZoneId_finish = '';

/*
* FUNZIONE CHE INIZIALIZZA IL PLUGIN E ASSEGNA I VALORE DI DEFAULT ALLE VARAIBILI IN CASO NON SIANO STATE ASSEGNATE DALL'ESTERNO
*/                                   
    $.fn.MagicUpload = function(options) 
    {
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
        // assegno alle variabili di default definite in precedenza il valore ricevuto dall'esterno
        opts = $.extend(defaults, options);
        dropZoneId_finish = opts.dropZoneId_finish;
        
        // ATTIVO LA FUNZIONE CHE VA A CERCARE NEL FILE IL CORRETTO TEMPLATE DA INIETTARE
        startUploadForm();
    
    
        /* -------------------------------INIZIO-------------------------------------------
        * Le seguenti funzioni servono per il funzionamento del drag & drop upload
        *  -------------------------------INIZIO-------------------------------------------
        */
        if(opts == null){return;}
        lng = opts.lang;
        //console.log(langTxt[lng].retry);
        //console.log(langTxt.opts.lang.retry);
        
        //assegno id e classe per iniziare a operare sugli elementi DOM
        var dropZone = $("."+opts.dropZone);
        var uploadForm = $("#"+opts.uploadForm);
        	
    	/*
        *   Chiamata al file di configurazione PHP per recuperare i settaggi della sezione chiamata e restituire eventuali errori
        */
        var startUpload = function(files) 
        {
            if(opts.debug) { console.log(files); }
            if(opts.debug) { console.log(div_img_id); }
            
            if(typeof div_img_id !== 'undefined')
            {
                $.ajax(
                {
                    dataType: "json",
                    url: "/config/class/MagicUpload/core/class/GetConfig.php",
                    data: 'section=' + div_img_id, 
                    success: function(result)
                    {                    
                        if(opts.debug) { console.log(result); }
                        
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
                            
                            // avvio le operazioni dei controlli preliminari di validazione
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
        
        
    	/*Recupero tutti gli id dei div per l'upload*/
        var formid = '';
        var dropzoneid = '';
        var avatarUpload = '';
        var avatar = '';
    	/*Ciclo che recupera le informazioni del form di upload*/
    	
    	/*
    		formid = upload_js-upload-form;
    		_avatar da cambiare
    	*/
        for(var i = 0; i < ids.length; i++) 
        { 
            formid          += ids[i].id+"_"+opts.uploadForm+", ";
            dropzoneid      += ids[i].id+"_"+opts.dropZone+", ";
    		$(dropzoneid.slice(0,-2)).html('<span class="text-msg">'+langTxt[lng].start+'</span>'); 
            avatarUpload    += ids[i].id+"_upload_btn, ";
            avatar          += ids[i].id+"_avatar, ";
        }
        
        /*
        *   LISTENER SUL SUBMIT
        */
        console.log(formid.slice(0, -2));
        $(formid.slice(0, -2)).bind('submit', function(e) 
        {
            div_img_id      = $(this).closest("."+opts.Anchor).attr("id");
            if(opts.debug) { console.log(div_img_id); }
            var uploadFiles = $('#'+div_img_id).find("input#"+opts.inputfiles)[0].files;
            e.preventDefault();
            
            // parte upload
            startUpload(uploadFiles);
            
        });  
        $('#root_form').bind('submit', function(e) 
        {
            var numb_img = $(":input[name='source_name[]']").length;
            console.log(numb_img);
            if(numb_img == 0)
            {
                e.preventDefault(); // this will prevent from submitting the form.
                console.log('non ci sono elementi');
                return;
            }
            /*
            else
            {
                e.preventDefault(); // this will prevent from submitting the form.
                parent.$.fancybox.close();
            }*/
            //alert($(":input[name='source_name[]']").length);
            
        }); 
        
        /*GESTIONE UPLOAD CLICK*/	
    	
        //bind click
        // 
        $(dropzoneid.slice(0, -2)).click(function(event)
        {
            console.log('asdasdasd');
            console.log("#"+opts.inputfiles);
            $("#"+opts.inputfiles).click();            
            //$("#"+(this.id).replace(/_upload_btn/g,'')+"_avatar").click();
        });
    console.log("dropzoneid - "+dropzoneid.slice(0, -2));
        //capture selected filename
        $(avatar.slice(0, -2)).change(function(click) 
        {
            $("#"+(this.id).replace(/_avatar/g,'')+"_text-avatar").val((this.value).replace(/^.*\\/, ""));
            div_img_id      = (this.id).replace(/_avatar/g,'');console.log(div_img_id);
            //console.log($(this));
            var uploadFiles = $(this)[0].files;
            
            if(opts.debug) { console.log(uploadFiles); }
            
            // parte upload
            startUpload(uploadFiles);
            
        });
        console.log('avatar.slice - '+avatar.slice(0, -2));
        /**********/
        $("input:file").change(function (e){
           //console.log('aaaaaaaaaaaaaaaaaaaaaa');
           var fileName = $(this).val();
           //console.log('fileName - '+fileName);
           //console.log('opts.inputfiles - '+opts.inputfiles);
           //var uploadFiles = document.getElementById(opts.inputfiles).files;
           var uploadFiles = $(this)[0].files[0];//.files;
           //console.log('uploadFiles - '+uploadFiles);
           console.log(uploadFiles);
            div_img_id = $(this).closest("."+opts.Anchor).attr("id");
            e.preventDefault();
    
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
        
    	/*
    	GESTIONE DRAG AND DROP
    	*/
        $(dropzoneid.slice(0, -2)).on("drop", function(e) 
        {
            e.preventDefault();
            this.className  = opts.dropZoneCss;
            
            if(opts.debug) { console.log((this.id).replace('_'+opts.dropZone,'')); }
            
            div_img_id      = (this.id).replace('_'+opts.dropZone,'');//$(this).closest("."+opts.Anchor).attr("id");
            
            if(opts.debug) { console.log(e.originalEvent.dataTransfer.files); }
            
            if(opts.debug) { console.log(div_img_id); }
            
            var files = e.originalEvent.dataTransfer.files;
            
    		//Controllo che sia drag and drop e multiupload
            if( (opts.drop && opts.multiUpload))
            {
                for (var i = 0, f; f = files[i]; i++)
                {
                    startUpload(f);
                }
            }
            else
            {     
                //controllo che venga effetivamente caricato un solo file
    		
                if(opts.debug) { console.log("# file "+files.length);}
    
                if( files.length > 1 )
                {
    				$("#"+div_img_id+"_"+opts.dropZone).html('<span class="text-msg red">'+langTxt[lng].no_multiupload+'</span>'); 
                }
                else
                {
    				//parte l'upload del primo file
                    startUpload(files[0]);
                }
            }
        });
    
        $(dropzoneid.slice(0, -2)).on("dragover", function(e) 
        { 
            this.className = opts.dropZoneCss_drop;
            return false;
        });
    
        $(dropzoneid.slice(0, -2)).on("dragleave", function(e) 
        {
            this.className = opts.dropZoneCss;
            return false;
        });
    
    };
/* -------------------------------FINE-------------------------------------------
* Le seguenti funzioni servono per il funzionamento del drag & drop upload
*  -------------------------------FINE-------------------------------------------
*/


/*
* Funzione per controllare che il file passato rispetta i vincoli
* In caso di errore attiva la segnalazione su schermo
*/
function validateFile(file_source)
{
    if(opts.debug) { console.log('- function validateFile -'); }
    if(opts.debug) { console.log(file_source.name); }
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
            $("#"+div_img_id+"_"+opts.dropZone).html('<span class="text-msg">'+langTxt[lng].loading+'</span>'); 
            $("#"+div_img_id+"_js-upload-form").data("files", file);
            if(opts.debug) { console.log('- ok proseguo con upload -'); }
            //uploadFile(file_source[0]);
            uploadFile(file);
		}
		else
		{   
            $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
            $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss);
            if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );         
            $("#"+div_img_id+"_"+opts.dropZone).html('<span class="text-msg red">'+langTxt[lng].NotAllowed+'</span>');  
		}
        
	}
	else
	{   
        if(opts.debug) { console.log('size ko'); }
        $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
        $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss);     
        if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );         
        $("#"+div_img_id+"_"+opts.dropZone).html('<span class="text-msg red">'+langTxt[lng].TooBig+'</span>');
	}
    
   
}


/* -------------------------------INIZIO-------------------------------------------
* Le seguenti funzioni servono per verificare quali tecnologie supporta il browser
*  -------------------------------INIZIO-------------------------------------------
*/
/*
$(document).ready(function(e) {
    if(supportAjaxUploadWithProgress())
	{
		if(FirefoxDetect())
		{
			
			$("#"+opts.uploadForm+" h4").text(langTxt[lng].status);
			$(".progress").hide();
			
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
	console.log(navigator.userAgent);
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
*/
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
    if(opts.debug) { console.log('- function uploadFile -'); }
    var formData = new FormData($(opts.uploadForm)[0]);
    formData.append('section',div_img_id);
    formData.append('files[]',file_source);
    if(opts.debug) { console.log("section - "); console.log(div_img_id);}
    if(opts.debug) { console.log("files[] - "); console.log(file_source);}
    if(opts.debug) { console.log("FormData - "); console.log(formData);}
        
    $.ajax({
        url: '/config/class/MagicUpload/core/upload.php',  //Server script to process data
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
        $("#"+div_img_id+"_progress-bar").css("background-color", "rgb(74, 173, 74)"); 
        $("#"+div_img_id+"_progress-bar").css("border-color", "rgb(74, 173, 74)"); 
        $("#"+div_img_id+"_progress-bar").css("color", "rgb(74, 173, 74)");      
        if(opts.debug) { console.log("progess: "+(e.loaded/e.total)*100); }
        var percent = Math.round((e.loaded / e.total) * 100);
		$("#"+div_img_id+"_progress-bar").css('width', percent + '%');//((e.loaded/e.total)*100)+"%");
        $(".sr-only").html(percent +'% Complete');
		//$('.percent').text(Math.round(e.loaded/e.total)*100+"%");
		if(opts.debug) { console.log(Math.round(e.loaded/e.total)*100+"%"); }
                
		if(((e.loaded/e.total)*100)==100)
		{
            $("#"+div_img_id+"_progress-bar").css("background-color", "rgb(74, 173, 74)"); 
            $("#"+div_img_id+"_progress-bar").css("border-color", "rgb(74, 173, 74)"); 
            $("#"+div_img_id+"_progress-bar").css("color", "rgb(74, 173, 74)");      
            
            $( "#"+div_img_id+"_list_group" ).css('backgroud-image','loadin.GIF');
		}
    }
    
}
function beforeSendHandler(e)
{
    if(opts.debug) { console.log(' ---beforeSendHandler-- '); }
	if(opts.debug) { console.log(e); }
    $( "#"+div_img_id+"_list_group" ).append( '<li id="loading_img" class="box-photo-add-vuoto-caricamento"><img style="height: 177px; width: 200px;"/><img src="config/class/MagicUpload/core/js/loader.gif" width="41" class="img-abs-center" alt=""></li>');
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
                        $('#loading_img').remove();
                        if(opts.list)
                        {
                            if(opts.debug) { console.log('div_img_id --  '+div_img_id); }
                            $("#"+div_img_id+"_"+opts.dropZoneId_finish).fadeIn();
                            if(div_img_id != 'upload')
                            {
                                $( "#"+div_img_id+"_list_group" ).append( '<a href="#" class="list-group-item list-group-item-success" onclick="openImg(\' '+objJson.filedir+"/"+objJson.filename+'\');"><span class="badge alert-success pull-right">Success</span>'+objJson.filename+'</a>' );
                                $( "#"+div_img_id+"_list_group" ).append( '<input type="hidden" name="'+preview_list[div_img_id].id_img+'" id="img" value="'+objJson.filename+'" />' ); 
                            }
                            else
                            {
                                $( "#"+div_img_id+"_list_group" ).append( '<li class="box-photo-add-vuoto-caricamento"><img style="height: 177px; width: 200px;" src="'+objJson.filedir+"../"+objJson.filename+'"/><img src="images/add-image.png" width="32" class="img-abs-center" alt=""></li>');
                                //$( "#"+div_img_id+"_list_group" ).append( '<div class="box-photo-add-vuoto"><img style="height: 177px; width: 200px;" src="'+objJson.filedir+"/"+objJson.filename+'" /><img src="images/add-image.png" width="32" class="img-abs-center" alt=""/></div>' );
                                $( "#"+div_img_id+"_list_group" ).append( '<input type="hidden" name="'+preview_list[div_img_id].id_img+'[]" id="img" value="'+objJson.filename+'" />' ); 
                                $( "#"+div_img_id+"_list_group" ).append( '<input type="hidden" name="'+preview_list[div_img_id].id_img+'['+objJson.filename+'][extra_photo]" id="img" value=\''+JSON.stringify(objJson.exif_data)+'\' />' );
                                $( "#"+div_img_id+"_list_group" ).append( '<input type="hidden" name="'+preview_list[div_img_id].id_img+'['+objJson.filename+'][extra_photo_average_colour]" id="img" value="'+objJson.average_colour+'" />' );
                                $( "#"+div_img_id+"_list_group" ).append( '<input type="hidden" name="'+preview_list[div_img_id].id_img+'['+objJson.filename+'][extra_photo_Lat]" id="img" value="'+objJson.Lat+'" />' );
                                $( "#"+div_img_id+"_list_group" ).append( '<input type="hidden" name="'+preview_list[div_img_id].id_img+'['+objJson.filename+'][extra_photo_Lng]" id="img" value="'+objJson.Lng+'" />' );
                                
                            }
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
                        if(opts.debug) { console.log(objJson.image); }
					}
				}
				else
				{
                    $("#"+div_img_id+"_"+opts.dropZone).removeClass(opts.successCss+" "+opts.successCss);
                    $("#"+div_img_id+"_"+opts.dropZone).addClass(opts.errorCss);
                    if(opts.error_shake) $("#"+div_img_id+"_"+opts.dropZone).effect( "shake" );         
                    $("#"+div_img_id+"_"+opts.dropZone).html( langTxt[lng].upload_ko );  
					 
                    if(opts.debug) { console.log(' ---completeHandler 4-- '); }
                    if(opts.debug) { console.log(objJson); }
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