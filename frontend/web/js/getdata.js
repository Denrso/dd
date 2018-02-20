$( document ).ready(function() {
setInterval(function(){

    var stops = [0,10,20,30,40,50,60,70,85,100];
    $.each(stops, function(index, value){
        setTimeout(function(){
            $( ".progress-bar" ).css( "width", value + "%" ).attr( "aria-valuenow", value );
        }, index*1000);
    });





    $.ajax({
        type: "POST",
        dataType: "text",
        url: "/source/about", //Relative or absolute path to response.php file
        data: 'json=go',
        success: function (data) {
            console.log(data);
            $(".result tbody tr").remove();

            $.each(JSON.parse(data), function(idx, obj) {
                //alert(obj.tagName);

                $(".result").append(
                    "<tr><td><i class=\"glyphicon glyphicon-euro\"></i> </td><td>1</td><td><b>"+obj.currency+"</b><i class=\"glyphicon glyphicon-ruble\"></i></td><td>"+obj.url+"</td></tr>"
                );
            });



            //alert("Form submitted successfully.\nReturned json: " + data["json"]);
        }
    });

    },  10000);

});