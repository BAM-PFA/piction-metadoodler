function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

function adjust_textarea(h) {
    h.style.height = "20px";
    h.style.height = (h.scrollHeight)+"px";
}

function addTag(divName){
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "<label for='anothertag'><span>Tag</span><input type='text' name='tagarray[]'/></label>";
          document.getElementById(divName).appendChild(newdiv);
}

// function hoverdiv(e,divid){

//     var left  = e.clientX  + "px";
//     var top  = e.clientY  + "px";

//     var div = document.getElementById(divid);

//     div.style.left = left;
//     div.style.top = top;

//     $("#"+divid).toggle();
//     return false;
// }

function hoverdiv(e,divid){ 

    var left = e.clientX + "px"; 
    var top = e.clientY + "px"; 

    $("#"+divid).css('left',left); 
    $("#"+divid).css('top',top); 
    $("#"+divid).css('position','fixed'); 
    $("#"+divid).toggle(); 
    return false; 
}