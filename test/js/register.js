
$(document).ready(function(e) {

    if(lapsic_login == 'true')
    {        
        try{
            parent.jQuery.fancybox.close();
        }
        catch(err)
        {        
            parent.$('#fancybox-overlay').hide();
            parent.$('#fancybox-wrap').hide();
        }
    }
    
});