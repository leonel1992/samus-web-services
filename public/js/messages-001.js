// CONTAINER MESSAGE (BUILDING - ERROR) --------------------------------------------

window.onload = setDimensContainerMessage;
window.onresize = setDimensContainerMessage;

function setDimensContainerMessage() {
    try {
        let container = document.getElementsByClassName("message-view");
        let message = document.getElementsByClassName("text-view");
        let image = document.getElementsByClassName("image-view");
        let img = image[0].childNodes[1];

        if (window.getComputedStyle) {

            let containerComputedStyle = getComputedStyle(container[0], null);
            let messageComputedStyle = getComputedStyle(message[0], null);
            let imgComputedStyle = getComputedStyle(img, null);
    
            let spacingHeight = containerComputedStyle.height.replace("px", "") * 0.04;
            let containerHeight = containerComputedStyle.height.replace("px", "") * 1.0;
            let containerWidth = containerComputedStyle.width.replace("px", "") * 1.0 - 30;
            let messageHeight = messageComputedStyle.height.replace("px", "") * 1.0;
            let imgHeigth = imgComputedStyle.height.replace("px", "") * 1.0;
            let imgWidth = imgComputedStyle.width.replace("px", "") * 1.0;
            let imgRatio = imgWidth / imgHeigth;
    
            let imageHeight = containerHeight - messageHeight - spacingHeight * 2;
            let imageWidth = imageHeight * imgRatio;
    
            if (imageWidth > containerWidth) {
                spacingHeight += (imageHeight - containerWidth / imgRatio) / 2;
                imageHeight = containerWidth / imgRatio;
                img.style.height = imageHeight + "px";
                img.style.width = 'auto';
            } else {
                img.style.width = imageWidth + "px";
                img.style.height = 'auto';
            }
    
            image[0].style.top = spacingHeight +"px";
            image[0].style.height = imageHeight +"px";
            message[0].style.top = (spacingHeight + imageHeight) +"px";
    
        } else {
            image[0].style.top = "2vh";
            image[0].style.height = "60vh"
            message[0].style.bottom = "2vh";
        }
    } catch (error) {} 
}