
function flashTitleNotification(newTitle, interval) {
    let originalTitle = document.title; // Store the original title
    let isFlashing = false; // Flag to keep track of the notification state

    if (isFlashing) {
        return; // Don't start another flash while one is already active
    }

    isFlashing = true;

    const flashInterval = setInterval(function () {
        document.title = (document.title === originalTitle) ? newTitle : originalTitle;
    }, interval);

    // Stop the flashing after a specific duration (e.g., 5 seconds)
    setTimeout(function () {
        clearInterval(flashInterval);
        document.title = originalTitle;
        isFlashing = false;
    }, interval); // Adjust the duration as needed

    // flashTitleNotification("New Message!", 500); // Flash "New Message!" every 500 milliseconds
}


export default {
    flashTitleNotification
}