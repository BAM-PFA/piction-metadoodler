// function openCity(evt, cityName) {
//     // Declare all variables
//     var i, tabcontent, tablinks;

//     // Get all elements with class="tabcontent" and hide them
//     tabcontent = document.getElementsByClassName("tabcontent");
//     for (i = 0; i < tabcontent.length; i++) {
//         tabcontent[i].style.display = "none";
//     }

//     // Get all elements with class="tablinks" and remove the class "active"
//     tablinks = document.getElementsByClassName("tablinks");
//     for (i = 0; i < tablinks.length; i++) {
//         tablinks[i].className = tablinks[i].className.replace(" active", "");
//     }

//     // Show the current tab, and add an "active" class to the button that opened the tab
//     document.getElementById(cityName).style.display = "block";
//     evt.currentTarget.className += " active";
// }

// function adjust_textarea(h) {
//     h.style.height = "20px";
//     h.style.height = (h.scrollHeight)+"px";
// }

function addTag(divName,cat){
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "<input type='text' class='form-control' name='"+cat+"tagarray[]'/>";
          document.getElementById(divName).appendChild(newdiv);
}

// function hoverdiv(e,divid){ 
//     if ($('#doShowHints').is(':checked')){
//         var left = e.clientX + "px"; 
//         var top = e.clientY + "px"; 

//         $("#"+divid).css('left',left); 
//         $("#"+divid).css('top',top); 
//         $("#"+divid).css('position','fixed'); 
//         $("#"+divid).toggle(); 
//         return false; 
//         }
// }


