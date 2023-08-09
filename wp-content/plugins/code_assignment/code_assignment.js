var current_codes = {};
var last_codes = {};
  
function deepCompare(obj1, obj2) {
    // Convert the objects to JSON strings
    let obj1String = JSON.stringify(obj1);
    let obj2String = JSON.stringify(obj2);      
    // Compare the JSON strings
    return obj1String === obj2String;
}
    // should I put html escape to protect from XSS attack?
function htmlEscape(input) {
    // return input.replace(/[&<>"'/]/g, function(match) {
    //     switch (match) {
    //         case '&':
    //             return '&amp;';
    //         case '<':
    //             return '&lt;';
    //         case '>':
    //             return '&gt;';
    //         case '"':
    //             return '&quot;';
    //         case "'":
    //             return '&#39;';
    //         case '/':
    //             return '&#x2F;';
    //         default:
    //             return match;
    //     }
    // });
    return input;
}
// Get post ID function
function get_assignment_post_id(){
    // Get the value of assignment id
    let post_id = 0;
    if (typeof POST_ID_CURRENT !== 'undefined' && POST_ID_CURRENT){
        post_id = POST_ID_CURRENT;
        console.log("post id is extracted from POST_ID_CURRENT: " + post_id);
    } else if (elementorFrontendConfig.post.id){
        post_id = elementorFrontendConfig.post.id;
        console.log("post id is extracted from elementorFrontendConfig.post.id: " + post_id);
    } else {
        console.log("post_id is not defined!");
    }
    return post_id;
}
// jQuery(document).ready(function($) {  

    // send code to the server
    function submitCodeToAPI(){
        for(var widget_id in current_codes) {
            current_code = current_codes[widget_id];
            last_code = last_codes[widget_id]; // it can be undefined
            iframe_element = document.getElementById(widget_id);
            if (iframe_element === null){
                continue;
            }
            ide_for_iframe = iframe_element.getAttribute('ide');
            // check is empty?
            if (!deepCompare(current_code, last_code) && current_code) {
                // Get the value of assignment id
                let post_id = get_assignment_post_id();
                // Sanitize and escape the code data to prevent XSS attacks
                let sanitizedCode = htmlEscape(current_code);
                
                const data = {
                    post_id: post_id,
                    widget_id: widget_id,
                    ide_for_iframe: ide_for_iframe,
                    code: sanitizedCode
                };
                console.log("Payload:" + JSON.stringify(data, "I don't understand", 4));
                const url_to_submit_code = '/wordpress/wp-json/code-assignment/v1/submit-code';
                fetch(url_to_submit_code, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': window.vibebp.xnonce, // Make sure to localize this value in your WordPress script
                    },
                    body: JSON.stringify(data),
                }).then(response => {
                    return response.json();
                }).then(jsonResponse => {
                    console.log({jsonResponse})
                }).catch(error => {
                    // Handle any errors
                    console.error("Some error occured: " + error);
                });
                // save the last code
                last_codes[widget_id] = current_code;
                last_widget_id = widget_id;
                wp.data.dispatch("vibebp").addNotification({
                    text: "Code is saved",
                });
            } else {
                // console.log('Received message with invalid data or the same code'); // TODO: comment me
            }
        }
    }
    // Add only one listener to save code
    window.addEventListener('message', function(event) { // addEventListener
        // Validate the event source
        if (event.origin !== 'https://trinket.io') {
            console.log('Received message from an untrusted source.');
            return;
        }
        console.log(event);
        let current_widget_id = document.activeElement.getAttribute("id");
        current_codes[current_widget_id] = event.data.code;
        // uncomment if you want self DDos
        // submitCodeToAPI();
        console.log("current_widget_id: " + current_widget_id);
        console.log("current_code: " );
        console.log(current_codes[current_widget_id]);
    });

    function defineStudentCode(iframe_element){
            const url = iframe_element.src;
            const widget_id = iframe_element.id;
            let decoded_code = null;
            if (iframe_element.getAttribute('ide') === "trinket-iframe"){
                const startPos = url.indexOf('#code=') + 6;
                const encodedCode = url.slice(startPos);
                decoded_code = decodeURIComponent(encodedCode);
            }
            current_codes[widget_id] = decoded_code;
            last_codes[widget_id] = decoded_code;
    }

    function defineStudentAllCode(){
        iframe_elements = document.getElementsByClassName('iframe-suot');
        for(let i = 0; i < iframe_elements.length; i++) {
            e = iframe_elements[i];
            defineStudentCode(e);
        }
    }

    document.addEventListener("DOMContentLoaded", function(){
        defineStudentAllCode();
    });
    
    setInterval (submitCodeToAPI, 5000);    
// });

function randomInRange(min, max) {
    return Math.random() * (max - min) + min;
}

async function loadParticles(options) {
    console.log('Async function.');
    await loadFireworksPreset(tsParticles);
    await tsParticles.load(options);
}





function fireworks_suot(){
    const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 1000 };
    const particleCount = 500; //  (timeLeft / duration_firework)
    const n_fire = 5;
    // since particles fall down, start a bit higher than random
    confetti(
        Object.assign({}, defaults, {
          particleCount,
          origin: {x: 0, y: 0}
        //   origin: { x: randomInRange(0, 100), y: randomInRange(0, 100) },
        })
      );
      confetti(
        Object.assign({}, defaults, {
          particleCount,
          origin: {x: 1, y: 0}
        //   origin: { x: randomInRange(0, 100), y: randomInRange(0, 100) },
        })
      );
}

function getRandomMessage(isGoodResult) {
    const bad_result = [
        "Ошибка! Попробуй еще раз, у тебя обязательно получится!",
        "Ответ неверен. Внимательно изучи задание.",
    ];

    const good_result = [
        "Молодец! Продолжай в том же духе!",
        "Молодец! Задание выполнено!",
        "Молодец! Задание успешно выполнено!",
        "Супер! Задание выполнено правильно!"
    ];
    const messageArray = isGoodResult ? good_result : bad_result;
    const randomIndex = Math.floor(Math.random() * messageArray.length);

    return messageArray[randomIndex];
}

function showCongratulations(isGoodResult) {
    const messageElement = document.getElementById('congratulationsMessage');
    textElement = messageElement.querySelector('.congratulations-content');
    textElement.innerHTML = getRandomMessage(isGoodResult);
    messageElement.style.display = 'block';

    setTimeout(() => {
        messageElement.style.display = 'none';
    }, 5000);
}

// Send code to autograder
function sendToAutoGrader(button){
    // Get the parent element (the container) of the button
    let container = button.parentElement;
    let btn = container.querySelector('.autograder-button');
    loader = container.querySelector('.loader');
    check = container.querySelector('.check');
    iframe_element = container.querySelector('.iframe-suot');
    widget_id = iframe_element.id;
    ide_for_iframe = iframe_element.getAttribute('ide');
    // Get the value of assignment id
    let post_id = get_assignment_post_id();
    setTimeout(() => {
        loader.classList.add('active');
        check.classList.add('active');
        const url_to_check_code = '/wordpress/wp-json/code-assignment/v1/check-code';
        if (!current_codes.hasOwnProperty(widget_id)){
            defineStudentCode(iframe_element);
        }
        current_code = current_codes[widget_id];
        // Sanitize and escape the code data to prevent XSS attacks
        let sanitizedCode = htmlEscape(current_code);
        // Check code before sending a request
        // ...
        const data = {
            post_id: post_id,
            widget_id: widget_id,
            ide_for_iframe: ide_for_iframe,
            code: sanitizedCode
        };
        fetch(url_to_check_code, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': window.vibebp.xnonce, // Make sure to localize this value in your WordPress script
            },
            body: JSON.stringify(data),
        }).then(response => {
            return response.json();
        }).then(jsonResponse => {
            console.log({jsonResponse});
            score = jsonResponse['run']['output']['score'];
            if (score['failed'] === 0){
                fireworks_suot();
                showCongratulations(true);
                // const configs = { 
                //     preset: "fireworks"
                // };
                // loadParticles(configs).then(console.log("LOADED"));;
            }else{
                showCongratulations(false);
            }
            wp.data.dispatch("vibebp").addNotification({
                text: `Passed: ${score['passed']}, Failed: ${score['failed']}`,
            });
            
        }).catch(error => {
            // Handle any errors
            console.error("Some error occured: " + error);
        });
    }, 1000);
    loader.classList.remove('active');
    check.classList.remove('active');
   
    console.log("Button is pressed");
}
