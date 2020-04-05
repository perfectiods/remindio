/*     function showEdit(editableObj) {
       $(editableObj).css("background","#FFF");
     } 

    function saveToDatabase(editableObj,column,id) {
      $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
      $.ajax({
        url: "birthdays.php",
        type: "POST",
        data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        success: function(data){
         $(editableObj).css("background","#FDFDFD");
         
          //$(editableObj).css("background","#FDFDFD");
         // $("#birthday-data").replaceWith(data); //The .replaceWith() method removes content from the DOM and inserts new content in its place with a single call
        }        
       });
    }
*/
function showEdit(editableObj) {
     $(editableObj).css("background","#FFF");
} 

function saveToDatabase(editableObj,column,id) {
  $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
    $.ajax({
      url: "/include/show.php",
      type: "POST",
      dataType: "text",
      data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
      success: function(data){

      $(editableObj).css("background","#FDFDFD");

    //$(editableObj).css("background","#FDFDFD");
   // $("#birthday-data").replaceWith(data); //The .replaceWith() method removes content from the DOM and inserts new content in its place with a single call

     $("#one").text(data);
     $("#two").text(data);
     $("#three").text(data);
  }        
 });
}
