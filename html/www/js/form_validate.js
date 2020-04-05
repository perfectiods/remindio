
  $(document).ready(function() {


      $('#submit').click(function(e){
        e.preventDefault();


        var name = $("#name").val();
        var surname = $("#surname").val();


        $.ajax({
            type: "POST",
            url: "/download/a/scripts/delete.phpfunctions.php",
            dataType: "json",
            data: {name:name, surname:surname},
            success : function(data){
                if (data.code == "200"){
                    alert("Success: " +data.msg);
                } else {
                    $(".display-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-error").css("display","block");
                }
            }
        });


      });
  });
