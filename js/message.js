setTimeout(() =>{
    document.querySelector('#act-now').click();
    }, 100);

setTimeout(() =>{
document.querySelector('#act-now').click();
}, 50);
setTimeout(() =>{
    
document.querySelector('#act-now').click();
}, 1000);

setTimeout(() =>{
    
document.querySelector('#act-now').click();
}, 10000);





let ctId = '';
let id_2 = '';
let height  = '';
function ref(id, id2){
    ctId = id;
    id_2 = id2;
    $.post(
        "partials/_msg/_msg.php",
        {id: `${id}`},
        function(data){
            $('#all-messages').html(data);
    document.getElementById('all-messages').scrollTop = document.getElementById('all-messages').scrollHeight;

        }
    )
    $.post(
        "partials/_msg/_msg.php",
        {user_id: `${id_2}`},
        function(data){
            $('#con-header').html(data);
        }
    )
    // height = $('#messages').prop("scrollHeight");
    // $("#messages").animate({ scrollTop:  height}, 100);
    document.getElementById('all-messages').scrollTop = document.getElementById('all-messages').scrollHeight;

    var obj = { Title: 'jimam', Url: `messages.php?cid=${id}`};
    history.pushState(obj, obj.Title, obj.Url);
    

    // $.post(
    //     "partials/_msg/_msg-nav-img-loader.php",
    //     {id: `${id_2}`},
    //     function(data){
    //         $('#talking-img').html(data);
    //     }
    // )
}
setTimeout(()=>{


    Data = ``;
    setInterval(() => {
        $.ajax({
            url: "partials/_msg/_last-msg.php",
            type: "POST",
            data: {cid: ctId},
            
            success: function (data) {
                if (Data != data) {
                    $('#cons').html(data)
                    Data = data;
                }
            }
        });

    }, 1000)


}, 3500)



msg = '';
setInterval(() =>{

    $.ajax({
        url: 'partials/_msg/_msg.php',
        type: "POST",
        data: {id: ctId},
        success: function(data){
            if(msg != data){
                $('#all-messages').html(data);
                msg = data;

                
                // height = $('#messages').prop("scrollHeight");
                // $("#messages").animate({ scrollTop:  height}, 100);
    document.getElementById('all-messages').scrollTop = document.getElementById('all-messages').scrollHeight;



            }
        }

    })  
} , 1000)



function send(){
    let msgInp = document.getElementById('message');
        let msgValue = msgInp.value;
        // msgValue = msgValue.replace("'", "\'");
        // msgValue = msgValue.replace("\\", "\\\\");
        // msgValue = msgValue.replace("<?", "?");
        // msgValue = msgValue.replace("<?php", "php");
        console.log(msgValue);
        $.post(

            'partials/_msg/_msg-save.php',
            {msg: msgValue , chatId: ctId, id: id_2},
        )

}
