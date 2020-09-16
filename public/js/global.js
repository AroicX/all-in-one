/**
 * Created by EMMABIDEM on 12/8/14.
 */
window.onload = Main();
function Main()
{
    var bWidth = window.innerWidth;
    var bHeight = window.innerHeight;
    var sWidth = screen.width;
    var sHeight = screen.height;
// amount of scroll down the page
    var scHeight = window.pageYOffset;

    // write values to console
    console.log('The document is ready now' + ' Browser info initialized');
    console.log('Browser width : ' + bWidth);
    console.log('Browser height : ' + bHeight);
    console.log('Screen width : ' + sWidth);
    console.log('Screen height : ' + sHeight);
    console.log('Amount of scroll downwards : ' + scHeight);

    CheckFileApi();

    var nav = Find('main-nav');
    ToggleNav(nav);
}

// CUSTOM //

function ToggleNav(nav){

    var ypos;
    ypos = window.pageYOffset;
    if(browserReloaded() && ypos > 150){

        //change nav bg
        AddClass(nav, 'bg-major-b');
        AddClass(nav, 'navbar-fixed-top');

    }

    function yScroll() {

        ypos = window.pageYOffset;

        if(ypos > 150){

            //change nav bg
            AddClass(nav, 'bg-major-b');
            AddClass(nav, 'navbar-fixed-top');

        }else {
            RemoveClass(nav, 'bg-major-b');
            RemoveClass(nav, 'navbar-fixed-top');
        }

    }

    AddEventListener(window,'scroll',yScroll);


}




// animated functions
function AddAnimationToElement(elem,animation,infinite)
{
    var Elem = Find(elem);

    if(Elem != null)
    {
        if(infinite == true)
        {
            $(Elem).addClass('animated infinite '+ animation);

        }else if(infinite == false)
        {
            $(Elem).addClass('animated '+ animation);

        }else
        {
            $(Elem).addClass('animated '+ animation);
        }

    }else
    {
        WriteToConsole('Cannot find element with the attribute '+ elem);
    }

}

function OnAnimationEnd(elem,func)
{
    var Elem = Find(elem);
    if(Elem != null)
    {
        $(Elem).on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',func);
    }else
    {
        WriteToConsole('Cannot find the element with the attribute '+ elem);
    }
}

function SetDuration(elem,time)
{
    var Elem = Find(elem);

    if(Elem != null)
    {
        $(Elem).css(
            {
                '-webkit-animation-duration': parseFloat(time)+'s',
                '-o-animation-duration': parseFloat(time)+'s',
                '-moz-animation-duration': parseFloat(time)+'s',
                '-ms-animation-duration': parseFloat(time)+'s',
                'animation-duration': parseFloat(time)+'s'
            });
    }else
    {
        WriteToConsole('Cannot find the element with the attribute '+ elem);
    }
}

function SetDelay(elem,time)
{
    var Elem = Find(elem);

    if(Elem != null)
    {
        $(Elem).css(
            {
                '-webkit-animation-delay': parseFloat(time)+'s',
                '-o-animation-delay': parseFloat(time)+'s',
                '-moz-animation-delay': parseFloat(time)+'s',
                '-ms-animation-delay': parseFloat(time)+'s',
                'animation-delay': parseFloat(time)+'s'
            });
    }else
    {
        WriteToConsole('Cannot find the element with the attribute '+ elem);
    }
}

function browserReloaded(){

    //check for navigation time API support
    if (window.performance) {

        console.info("API supported");

        if(performance.navigation.type == 1) {

            return true;

        }else {

            return false;
        }

    }else{
        console.info("API not supported");
        return false;
    }



}

function SetIterationCount(elem,iteration)
{
    var Elem = Find(elem);

    if(Elem != null)
    {
        $(Elem).css(
            {
                '-webkit-animation-iteration-count': iteration,
                '-o-animation-iteration-count': iteration,
                '-moz-animation-iteration-count': iteration,
                '-ms-animation-iteration-count': iteration,
                'animation-iteration-count': iteration
            });
    }else
    {
        WriteToConsole('Cannot find the element with the attribute '+ elem);
    }
}

//custom functions

function AddEventListener(elem,event,func)
{
    elem.addEventListener(event,func,false);
}

function GetId(id)
{
    return document.getElementById(id);
}

var c;
function Find(selector)
{
    if(selector == '')
    {
        alert('no value was supplied into function Find().')
    }else
    {
        c = document.querySelector(selector);
        if(c == null)
        {
            c = document.querySelector('#'+selector);
            if(c == null)
            {
                c = document.querySelector('.'+selector);
                if(c == null)
                {
                    WriteToConsole('The element does not contain an id or a class attribute');
                }else
                {
                    return c;
                }

            }
            else
            {
                return c;
            }
        }else
        {
            return c;
        }
    }
}

function WriteToConsole(text)
{
    if(text != "")
    {
        console.log(text);
    }
}

function toCharArray(text) {
    var array = [];
    var length = text.length;
    for (var i = 0; i < length; i++) {
        array[i] = text.charAt(i);
    }
    return array;
}

var textTimer;
function TextLooper(elem, textArray, time)
{
    if (textArray.length > 0) {
        var textCont = Find(elem);
        textCont.innerHTML += textArray.shift();
    }
    else {
        clearTimeout(textTimer);
    }
    textTimer = setTimeout(function () {
        TextLooper(elem, textArray, time);
    }, time);
}

function Dismiss(elem,delay)
{
    var Elem = Find(elem);
    var time = parseInt(delay);

    if(Elem != null)
    {
        if(Elem.innerHTML != "")
        {
           var timerId = setTimeout(function(){ AddClass(Elem,'hide'); },time);

            if($(Elem).hasClass('hide'))
            {
                clearTimeout(timerId);
            }
        }
    }
}

function AddClass(elem,classname)
{

    if (elem != null)
    {
        if ($(elem).hasClass(classname))
        {
            WriteToConsole('The element ' + elem + ' already has the class name ' + classname);
        }
        else
        {
            $(elem).addClass(classname);
        }
    }
    else
    {
        WriteToConsole('The element ' + elem + ' does not exist!');
    }
}

function RemoveClass(elem,classname)
{

    if (elem != null)
    {
        if ($(elem).hasClass(classname))
        {
            $(elem).removeClass(classname);
        }
        else
        {
            WriteToConsole('The element ' + elem + ' already has the class name ' + classname);
        }
    }
    else
    {
        WriteToConsole('The element ' + elem + ' does not exist!');
    }
}

function CheckFileApi()
{
    var flag;
    // Check for the various File API support.
    if (window.File && window.FileReader && window.FileList && window.Blob)
    {
        // Great success! All the File APIs are supported.
        flag = true;
        WriteToConsole('All file APIs are supported');
    } else
    {
        flag = false;
        WriteToConsole('None of the file APIs are supported');
    }

    return flag;
}

var timer;
function CountDown(d,h,m,s)
{
    var xmas = new Date(Date.parse("December 20, 2015 00:01:00"));
    var now = new Date();
    var timeDiff = xmas.getTime() - now.getTime();
    var info = Find('days');
    if(timeDiff <= 0)
    {
        clearTimeout(timer);
    }
    var sec = Math.floor(timeDiff / 1000);
    var min = Math.floor(sec / 60);
    var hr = Math.floor(min / 60);
    var dys = Math.floor(hr / 24);

    hr %= 24;
    min %= 60;
    sec %= 60;

    d.innerHTML = dys;
    h.innerHTML = hr;
    m.innerHTML = min;
    s.innerHTML = sec;
    info.innerHTML = dys;

    timer = setTimeout(function(){ CountDown(d,h,m,s); },1000);
}

function ScrollLevel(axis)
{
    if(axis == "height" || axis == "Height" || axis == "HEIGHT")
    {
        return window.pageYOffset; // exact num of pixels that the users had scroll content down in the page
    }
    else if(axis == "width" || axis == "Width" || axis == "WIDTH")
    {
        return window.pageXOffset; // exact num of pixels that the users had scroll content horizontally in the page
    }
}
function ScrollToBox(elem)
{
    var dis = 40;
    var scrollY = 0;
    var speed = 24;
    var element = Find(elem);
    var currY = window.pageYOffset; // exact num of pixels that the users had scroll content down in the page
    var tarY = element.offsetTop; // gets the vertical height
    // tarY rep whatever div in the page when the function is called
    //offsetTop returns exactly how many pixels the element is from the top of the page or its parent element.

    var bodyH = document.body.offsetHeight; // gets the body height
    var yPos = currY + window.innerHeight;

    var animator = setTimeout('ScrollToBox(\''+elem+'\')', speed); // repeats the function to create animation

    if(yPos > bodyH )
    {
        clearTimeout(animator); // clear animation
    }
    else
    {
        if(currY < tarY - dis)
        {
            scrollY = currY + dis;
            window.scroll(0, scrollY);
        }else{clearTimeout(animator);} // clear animation
    }
}

function ResetScroll(elem)
{
    var dis = 40;
    var scrollY = 0;
    var speed = 24;

    var element = Find(elem);
    var currY = window.pageYOffset; // exact num of pixels that the users had scroll content down in the page
    var tarY = element.offsetTop; // gets the vertical height

    var animator = setTimeout('ResetScroll(\''+elem+'\')', speed); // repeats the function to create animation

    if(currY > tarY)
    {
        scrollY = currY - dis;
        window.scroll(0, scrollY);
    }else{clearTimeout(animator);} // clear animation
}
String.prototype.Capitalize = function()
{
    return this.charAt(0).toUpperCase() + this.slice(1);
};

