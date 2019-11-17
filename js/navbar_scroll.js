var lastPosition = window.pageYOffset;

window.onscroll = function() 
{
    var currentPosition = window.pageYOffset;

    if(lastPosition > currentPosition) 
    {
        document.getElementById("mainNav").style.top = "0";
    } 
    else 
    {
        document.getElementById("mainNav").style.top = "-100px";
    }

    lastPosition = currentPosition;
}