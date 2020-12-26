$("#sendMail").on("click" , function(){
    let mail = $("#mail").val().trim();
    let name = $("#name").val().trim();
    let phone = $("#phone").val().trim();
    let art= $("#art_name").val().trim();
    let data= $("#data").val().trim();

    alert(mail,name,phone);

    $.ajax({
        url: 'ActionForGallerey.php',
        type: 'POST',
        cache: false,
        data: { 
            'name' : name,
            'mail' : mail,
            'phone' : phone,
            'art_name' : art,
            'data' : data
         },
         dataType: 'html',
         beforeSend: function(){
            $("sendMail").prop("disabled", true);
         },
         success: function(data){
            alert(data)
            $("sendMail").prop("disabled", false;
         }
    });
});