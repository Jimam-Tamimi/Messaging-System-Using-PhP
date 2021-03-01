document.getElementById('all-messages').scrollTop = document.getElementById('all-messages').scrollHeight;
let sendMessage = document.getElementById('send-message')
sendMessage.addEventListener('click', () => {
    sendFunc()
})


document.getElementById('message').addEventListener('keyup', function (event) {
    if (event.code === 'Enter') {
        sendMessage.click()  
    }
});
function sendFunc() {
    let messageElm = document.getElementById('message')

    message = messageElm.value
    if (message != '') {
        messageElm.value = ''
        message = `<div class="sent my-4">
        <div class="msg-text">
            <p>${message}</p>
        </div>
        <div class="condition "></div>
    </div>`
        document.getElementById('all-messages').innerHTML += message

        // $("#all-messages").animate({ scrollTop:  n*10}, 1000);
        // console.log($("#all-messages").height());
        document.getElementById('all-messages').scrollTop = document.getElementById('all-messages').scrollHeight;

    }
}




