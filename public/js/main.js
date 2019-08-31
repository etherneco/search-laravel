
function doPage(page)
{
	document.getElementById('page_number').value = page;
	 
	document.getElementById('search_form').submit();
	 
	
	return false;
	 
}


window.onload = function(){
  flatpickr(".datepicker",
      {
        dateFormat: "m/d/y"
      });


};


var listButtons = document.querySelectorAll('.travel-type-wrap .item');
for(var indBut in listButtons){
	 listButtons[indBut].onclick = function(){
	 	var checkbox = document.getElementById(this.id.replace("_item", ''));
	 	if(checkbox.checked){
			checkbox.checked = false;
	 		this.classList.remove("active")	
		} else {
			checkbox.checked = true;
	 		this.classList.add("active")	
	 	}
	 };
	 
	
}


