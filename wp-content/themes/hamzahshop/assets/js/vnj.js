
$( document ).ready(function() {
	$("#vnj-jewellery-image").on("click", ShowJewellery);
	$("#vnj-shirt-image").on("click", ShowShirts);
    $("#vnj-ebook-image").on("click", ShowEbooks);
    $(".lp-button").removeClass("button");
    $(".lp-button").addClass("btn btn-primary");
    $(".dropdown-toggle").dropdown();

    if (!$("body").hasClass("logged-in")) {
      $("#menu-item-2170").hide();
    }
    

});

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


function ScrollToProducts(className)
{
	$('html, body').animate({
    scrollTop: $("." + className).offset().top - 100
    }, 'slow');
}

function ShowJewellery()
{
	$(".vnj-jewellery").addClass("visible");
	$(".vnj-shirt").removeClass("visible");
	$(".vnj-ebook").removeClass("visible");
	
	ScrollToProducts("vnj-jewellery");
}

function ShowShirts()
{
	$(".vnj-jewellery").removeClass("visible");
	$(".vnj-shirt").addClass("visible");
	$(".vnj-ebook").removeClass("visible");
	
	ScrollToProducts("vnj-shirt");
}

function ShowEbooks()
{
	$(".vnj-jewellery").removeClass("visible");
	$(".vnj-shirt").removeClass("visible");
	$(".vnj-ebook").addClass("visible");
	
	ScrollToProducts("vnj-ebook");
}


function SwitchTabToReviews()
{
	$(".woocommerce-tabs").tabs();
	$(".woocommerce-tabs").tabs("option", "active", 1);
	$(".reviews_tab").addClass("active");
	$(".description_tab").removeClass("active");
	$(".vnj-notify-review").removeClass("vnj-notify-visible");
	
	var all = $(".woocommerce-review__author").map(function() {
    return this;
	}).get();
	
	$('html, body').animate({
    scrollTop: $(all[2]).offset().top - 100
    }, 'slow');
}

function ShowPopup(message, icon,delay, template)
{
	$.notify(
		{
			message: message,
			icon: icon
		},
		{
			type: "info",
			icon_type: "img",
			placement: {
				from: "bottom",
				align: "left"
			},
			delay: delay,
			timer: 1000,
			template: template 
		});
	
}

function ShowOrderPopup(title, message, icon, link)
{
	var additionalClass = "";
	if($(".cookie-notice-container").length == 1)
	   additionalClass = "vnj-notify-cookie";
	
	var template = 	'<div data-notify="container" class="col-xs-11 col-sm-3 alert vnj-notify vnj-notify-orders ' + additionalClass +'" role="alert">' +
					'<div class="vnj-notify-icon">' + 
						'<span data-notify="icon"></span> ' +
					'</div>' + 
					'<div class="vnj-notify-message">' + 
						'<a href="' + link + '" class="title link" >' + title + '</a>' +
						'<span class="message" data-notify="message">{2}</span>' +
					'</div>' + 
						'<div class="vnj-notify-close">' + 
						'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>' +
					'</div>' + 
					'</div>' 
	
	ShowPopup(message,icon, 15000,template);
		
	
	setTimeout(() => 
	{
		$(".vnj-notify-orders").addClass("vnj-notify-visible");
	}, 5000);
}

function GetReviewTemplate(title, linkSnippet)
{
		return	'<div data-notify="container" class="col-xs-11 col-sm-3 alert vnj-notify vnj-notify-review" role="alert">' +
					'<div class="vnj-notify-icon">' + 
						'<span data-notify="icon"></span> ' +
					'</div>' + 
					'<div class="vnj-notify-message">' + 
						'<span class="title" >' + title + '</span>' +	
						'<span class="message" data-notify="message">{2}</span>' +
						linkSnippet +
					'</div>' + 
						'<div class="vnj-notify-close">' + 
						'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>' +
					'</div>' + 
					'</div>' ;
}

function ShowReviewPopup(title, message, icon, link)
{
	var template = 	GetReviewTemplate(title,'<a class="message link" href="' + link + '#tab-reviews">clique pour voir son commentaire</a>' );
	
	ShowPopup(message,icon, 35000,template)
	
	setTimeout(() => 
	{
		$(".vnj-notify-review").addClass("vnj-notify-visible");
	}, 20000);
}


function ShowReviewPopupSameSite(title, message, icon)
{
	var template = 	GetReviewTemplate(title, '<span class="message link" onclick="SwitchTabToReviews()">clique pour voir son commentaire</span>');
	
	ShowPopup(message,icon, 35000,template)
	
	setTimeout(() => 
	{
		$(".vnj-notify-review").addClass("vnj-notify-visible");
	}, 20000);
}


	var website = "https://vals-natural-journey.de";	
	var phpFunctions = website + "/wp-content/themes/hamzahshop/inc/vnj.php";


	var SendGetSync = function(url, parser) {
	  return new Promise(function(resolve, reject) {
		/*stuff using username, password*/
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if(parser != null)
					resolve(parser(this.responseText));
				else
					resolve(this.responseText);
			}
			else if(this.readyState == 4 && this.status != 200)
			{
				reject("Error");
			}
		};
		xmlhttp.open("GET",url , true);
		xmlhttp.send();
	  });
	}
		
	function GetLanguage(code) {
		var url = phpFunctions + "?func=GetLanguage&code=" + code;
		return SendGetSync(url);
	}
	
	function GetProduct(id) {
		var url = phpFunctions + "?func=GetProduct&id=" + id;
		return SendGetSync(url, JSON.parse);
	}
	
	function getAllOrders()
	{
		var url = phpFunctions + "?func=GetAllOrders";
		return SendGetSync(url, JSON.parse);
	}
	
	function getAllReviews(id)
	{
		var url = phpFunctions + "?func=GetAllReviews&id=" + id;
		return SendGetSync(url, JSON.parse);	
	}
	
	function GetOrderMessage(name, country, diff_formated)
	{
			var myRe = /^[AEIOU]/g;
			if(myRe.exec(country) != null)
			{
				return name + " d\'" + country + " a acheté ce produit " + diff_formated;
			}
			else
			{
				return name + " de " + country + " a acheté ce produit " + diff_formated;
			}	
	}
	
	function GetMillisecondsDiff(date1, date2)
	{
		if (date1 < date2) {
			var milisec_diff = date2 - date1;
		}else{
			var milisec_diff = date1 - date2;
		}
		return milisec_diff;
	}
	
	function GetDays(date1, date2) {
		return Math.floor(GetMillisecondsDiff(date1,date2) / 1000 / 60 / (60 * 24));
	}
	
	function GetTimeString(date)
	{
		var datetime = new Date( date ).getTime();
		var now = new Date().getTime();
		
		var diff = new Date(GetMillisecondsDiff(now,datetime));
		
		var days = GetDays(datetime,now);
		var diffHours = days * 24 + diff.getHours();
		if(diffHours <= 24) //weniger als 24 stunden
		{
			if(diffHours <= 1) //weniger als eine Stunde
				diff_formated = "il y a " + diff.getMinutes() + " minutes";
			else //zwischen einer und 24 Stunden
				diff_formated = "il y a " + diffHours + " heures";
		}
		else if(diffHours <= 48)
			diff_formated = "il y a " + days + " jour";
		else if(diffHours <= 80)
			diff_formated = "il y a " + days + " jours";
		else
			diff_formated = "récemment";
		
		return diff_formated;
		
	}
	
	
	function getAllReviews2(id)
	{
		var url = "https://vals-natural-journey.de/wp-json/wc/v2/products/" + id + "/reviews?consumer_key=ck_e3b74a274632a79a51f2e92809c392a30b7e8266&consumer_secret=cs_fa92ad1ba2a3742e8ee3fa72161e650e871ee069";
		return SendGetSync(url, JSON.parse);
	}
	
	function getLastOrder()
	{
		 return new Promise(function(resolve, reject) {
			getAllOrders().then((body) => {
				resolve(body[Math.floor((Math.random() * 3) + 0)]); //TODO: Random Order
			})
		 });
	}
	
	function getLastReview(id)
	{
		return new Promise(function(resolve,reject) {
			getAllReviews(id).then((body) => {
				resolve(body[body.length - 1]);
				
			});
		});
	}

	

	function ShowOrder()
	{
		getLastOrder().then((lastorder) => {
			var productId = lastorder.line_items[0].product_id;
			var orderId = lastorder.id;
			
			var shownOrders = getCookie("ShownOrder").split(",");
			if(shownOrders.includes(orderId.toString()))
				return;
			
			setCookie("ShownOrder",shownOrders + "," + orderId,2);

			GetProduct(productId).then((p) => {

				GetLanguage(lastorder.billing.country).then((country) => {
					var productName = p.name;
					var name = lastorder.billing.first_name;
					name =  name[0].toUpperCase() + name.substring(1);
					var image = p.images[0].src;
					var link = p.permalink;
					var time = GetTimeString(lastorder.date_created);
					var message = GetOrderMessage(name, country,time);
					ShowOrderPopup(productName,message,image,link);
				});	
			});

		});
	}
	
	function ShowReview()
	{		
		GetProduct(512).then((prod) => {
			getLastReview(prod.id).then((review) => 
			{
				if(review != null)
				{
					var shownReviews = getCookie("ShownReview").split(",");
					if(shownReviews.includes(review.id.toString()))
						return;
					setCookie("ShownReview",shownReviews + "," + review.id,2);
					
					var name =  review.name;  
					var rating = review.rating;
					name =  name[0].toUpperCase() + name.substring(1);
					var message = "Note de " + rating + " étoiles par " + name + ", ";
					
					if(window.location.href == prod.permalink)
					{
						ShowReviewPopupSameSite(prod.name, message,prod.images[0].src);
					}
					else
					{
						ShowReviewPopup(prod.name, message,prod.images[0].src,prod.permalink);
					}
				}
			});
		});
		
		
	}

