import Growl from "../core/js/notification/notification.js";

window.onload = Load();

async function Load(){
    try {
        Promise.all(
            [

            ]
        );
    } catch (error) {
        console.error(`Error: ${error.toString()}`);
    }
}


function question(){
    Growl("Private methods will not be listed.");
}

