var modifica_form=false;
function ChangeForm(){
		modifica_form=true;

	}
function ChangeTab(tab,div){
	if(modifica_form){
			if(confirm("Ci sono delle modifiche non salvate, desideri continuare comunque?")){
				$("ul.tabs li").removeClass("active");
		tab.addClass("active"); 
		$(".tab_cont").hide();
		var activeTab = tab.find("a").attr("href"); 
		$(div).fadeIn();
		modifica_form=false;
		return false;
				}else{}
			}else{
		$("ul.tabs li").removeClass("active");
		tab.addClass("active"); 
		$(".tab_cont").hide();
		var activeTab = tab.find("a").attr("href"); 
		$(div).fadeIn();
		return false;
		}
	}
 
 $(document).ready(function() {
    $("input[id^=selecctall_").click(function(){
        if(this.checked) 
        { // check select status
            if(this.className.indexOf("sel_") )
            {
                cls = this.className.match(/\bsel_(\d+)/);                
            
                $('.'+cls[0]).each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            }
        }
        else
        {
            if(this.className.indexOf("sel_") )
            {
                cls = this.className.match(/\bsel_(\d+)/);
                $('.'+cls[0]).each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });
            }         
        }
       
       
        //do stuff
    });
    
    /*function(event) {  //on click 
        if(this.checked) { // check select status
            $('.'+this.className).each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.'+this.className).each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });*/
    
});
