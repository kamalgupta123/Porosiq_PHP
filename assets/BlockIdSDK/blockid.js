document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/qrcode.js" ></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/jquery.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/jquery.collapsible.min.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/swiper.min.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/jquery.countdown.min.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/circle-progress.min.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/jquery.countTo.min.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/jquery.barfiller.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/custom.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/jquery-2.1.4.min.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/jquery-ui.min.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/sockjs-client.min.js"></script>');
document.write('<script type="text/javascript" src="https://uwldemo.blockid.co/demo3/bid_web_sdk/js/stomp.js"></script>');	

let bidSDK = {
    api: "/assets/BlockIdSDK/index.php"
}
var sessionPoller = null;

function fetchNewSessionInfo(callback) {
    let data = {
        functionname: 'sessionpayload'
    }

    jQuery.ajax({
        type: "POST",
        url: bidSDK.api,
        dataType: 'json',
        data: data,
        success: function (obj, textstatus) {
            callback(obj)
        }
    })
}

function createNewSession(authType, scopes, qrDiv, qrReadyCallback, callback) {

    let renewCallback = function(result, error) {
        if (error !== null && error.error === "timeout") {
            createNewSession(authType, scopes, qrDiv, qrReadyCallback, callback)
        }
        else {
            callback(result, error)
        }
    }

    let appSessionId = Math.random().toString(36).substr(2, 16) + Math.random().toString(36).substr(2, 16)
    fetchNewSessionInfo(function(payload) {
        payload.session = appSessionId
        payload.authtype = authType
        payload.scopes = scopes 
        startSession(payload, qrDiv, qrReadyCallback, renewCallback)
    })
}

function startSession(request_payload, qrDiv, qrReadyCallback, callback) {
    document.getElementById(qrDiv).innerHTML = ""
    let payload = btoa(JSON.stringify(request_payload))
    let darkcolor= '#000000'
    let lightcolor= '#ffffff'
    let qrcode = new QRCode(qrDiv, {
        text: payload,
        width: 275,
        height: 275,
        colorDark : darkcolor,
        colorLight : lightcolor,
        correctLevel : QRCode.CorrectLevel.H
    }); 
    
    if (qrReadyCallback) {
        qrReadyCallback(request_payload)
    }
    console.log(request_payload)

    if (sessionPoller) {
        clearInterval(sessionPoller)
        sessionPoller = null
    }

    let timeout = 60
    pollAuthSessionResponse(request_payload.session, timeout*1000, function(payload, error) {
        callback(payload, error)   
    })


}

function pollAuthSessionResponse(sessionId, counter, callback) {
    clearInterval(sessionPoller)
    let frequency = 500;
    counter -= frequency

    let data = {
        functionname: 'checksession',
        sessionId: sessionId
    }

    jQuery.ajax({
        type: "POST",
        url: bidSDK.api,
        dataType: 'json',
        data: data,
        success: function (obj, textstatus) {
            if (obj) {
                callback(obj, null)
            }
            else if (counter <= 0) {
                //timeout
                console.log("retries done.. timing out.")
                callback(null, {error: "timeout"})
            }
            else {//re try
                console.log("retry after " + frequency + " ms")
                
                sessionPoller = setInterval(pollAuthSessionResponse, frequency, sessionId, counter, callback)
            }
        }
    })
}
