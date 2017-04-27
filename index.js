var  onGermanClick = function()
{
    localStorage['valsLang'] = "DE";
    window.location.reload();
};

var  onEnglishClick = function()
{
    localStorage['valsLang'] = "EN";
    window.location.reload();
};

var translateElements = function(elements)
{
    for (var i = 0; i < elements.length; i++) {
        if(elements[i].innerHTML.includes("$$"))
        {
                var langIndex = 0;
                if(localStorage['valsLang'] === "EN")
                {
                    var langIndex = 1
                }
                elements[i].innerHTML = elements[i].innerHTML.split("$$")[langIndex];
        }
}
}

var addTranslationButtons = function()
{
    var imDe = document.createElement("img"); 
imDe.setAttribute("src","http://u.jimdo.com/www63/o/s362d948e0470e8b4/img/id147e7198eca3565/1387375963/std/image.png");
imDe.setAttribute("onClick","onGermanClick()");   
imDe.height=20;// Append the text to <li>

var imEn = document.createElement("img"); 
imEn.setAttribute("src","http://u.jimdo.com/www63/o/s362d948e0470e8b4/img/idf7db0abf48ff3b3/1387375979/std/image.png");
imEn.setAttribute("onClick","onEnglishClick()");   
imEn.height=20;// Append the text to <li>

 
if(localStorage['valsLang'] === "EN")
{
    $(".jtpl-header__inner")[0].appendChild(imDe); 
}
else
{
     $(".jtpl-header__inner")[0].appendChild(imEn);
}
}

var translate = function()
{
    if(window.location.href.includes( ".jimdo.com"))
    {
        return;
    }
     if(localStorage['valsLang'] === "EN")
    {
        var translation = document.body.innerHTML.replace(/verfügbar/g,"available");
        translation = translation.replace(/Gesamtpreis, zzgl. Versandkosten/g,"Price incl. shipping");
        translation = translation.replace(/Tage Lieferzeit/g,"Days delivery time");
        translation = translation.replace(/In den Warenkorb/g,"Add to basket");
        document.body.innerHTML = translation;
    }
    addTranslationButtons();    
    
    translateElements($(".description"));
    translateElements(document.getElementsByClassName("j-module n j-text"));
    translateElements($("h1"));
}

 var setWidth = function(className,size){
 var elements = document.getElementsByClassName(className);
 if(elements != null && elements.length == 1)
 elements[0].style.width = size;
 }
 
  var setHeight = function(className,size){
 var elements = document.getElementsByClassName(className);
 if(elements != null && elements.length == 1)
 elements[0].style.height = size;
 }

 window.onload = function(e){
 /*Shop Image vergrößern*/
 setWidth("cc-shop-product-img","400px");
 setWidth("cc-product-superzoom","400px");
 setWidth("cc-shop-product-main-image photo","400px");
 if(window.location.href.match(/valeries-handmade-jewelry\.de\/\w+/i))
 {
      setHeight("jtpl-header--image","200px");
 }

 
 translate();
 }

 var imageMousOver = function(sender, eventArgs)
 {
 // alert(sender);
 }

 window.onscroll = function(e){
 var header = $(".jtpl-header")[0];
 var rectHeader = header.getBoundingClientRect();

 var body = $(".jtpl-section-main")[0];
 var rectBody = body.getBoundingClientRect();

 var header_inner = $(".jtpl-header__inner")[0];
 var cart = document.getElementsByClassName("j-cart")[0];


 var image = header_inner.getElementsByTagName("img")[0];
 image.onmouseover=imageMousOver;

 var defaultHeaderHeight = 100;
 var maxMargin = 30;
 var cartTop = 4;


 if(rectBody.top < defaultHeaderHeight)
 {
 header.style.marginTop = "0px";
 header.style.opacity = "1.0";
 header_inner.style.height = "50px";
 image.style.maxWidth = "50%";
 if (cart !== undefined){
          cart.style.top = cartTop + "px";
     //console.log("Test");
        }
 }
 else
 {
 if(rectBody.top < (maxMargin + defaultHeaderHeight))
 {
 var margin = (rectBody.top - defaultHeaderHeight) ;
 header_inner.style.height = 50 + margin * 100 / 50 + "px";
 image.style.maxWidth = 50 + + margin * 100 / 50 + "%";
 header.style.marginTop = margin + "px";

 header.style.opacity = 1- (0.75 * (margin /60));
 console.log("Header Height: " + header_inner.style.height + " Margin: " + margin);
 
  if (cart !== undefined){
        cart.style.top = cartTop +margin + "px";
      //console.log("Test");
  }
 
 }
 else
 {
 header.style.marginTop = maxMargin + "px";
 header.style.opacity = "0.75";
 header_inner.style.height = defaultHeaderHeight + "px";
 image.style.maxWidth = "100%";
  if (cart !== undefined){
      cart.style.top = "55px";
      //console.log("Test");
 }
 }

 }
 }

