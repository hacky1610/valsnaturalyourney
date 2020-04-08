
var MemberSpace = window.MemberSpace || {subdomain: "bullfrogicosahedrone7e3squarespace"};
(function(d){
  var s = d.createElement("script");
  s.src = "https://cdn.memberspace.com/scripts/widgets.js";
  var e = d.getElementsByTagName("script")[0];
  e.parentNode.insertBefore(s,e);
}(document));

function IsAdminMode()
{
  return jQuery(".tve-draggable").length > 0;
}

function AddToMailerLite(mail,firstName, plans)
{
  plans.forEach(function(plan) {
    if(plan.includes("BOOST LA POUSSE DE TES CHEVEUX"))
    {
      jQuery.ajax({
        type: "POST",
        url: 'https://vals-natural-journey.de/wp-content/themes/hamzahshop/inc/MemberSpaceMailerlite.php',
        dataType: 'json',
        data: {email: mail, firstName: firstName, groupName: "Members Challenge Boost Jan 2020"}
      });
    }

  });
  
 
}

(function() {
    MemberSpace.onReady = MemberSpace.onReady || [];
    MemberSpace.onReady.push(function(args) {
      if(IsAdminMode())
      {
          return;
      }

      AddToMailerLite(args.member.email,args.member.firstName,args.member.plans);

      if($(".vnj-container").length > 0) //Show member button if no landing page
      {
        $("#__memberspace_memberlogin_button").css("display","block");
      }


      jQuery(".CourseButton").each(function()
      {
        const b = $( this );
        let uri = b.children("a").prop("href");
        uri = uri.replace(/\/$/, ''); //remove last /
        const s = uri.split("/");
        const id = (s[s.length -1]).toLowerCase();
        jQuery.ajax({
          url: "https://bullfrogicosahedrone7e3squarespace.memberspace.com/api/site/configuration?subdomain=bullfrogicosahedrone7e3squarespace&pathname=%2F" + id + "%2F",
          context: document.body,
          xhrFields: {
            withCredentials: true
         }
        }).done(function(data) {
          if(data.pageAccess.access !== "allow")
          {
            let tooltiptext = "The lesson will be available soon"
            let regResult = data.pageAccess.access.match(/blocked_by_drip_([0-9]+)/);

            if(regResult !== null)
            {
              if(regResult.length === 2)
              { 
                  tooltiptext = `Disponible sous ${regResult[1]} jour(s)`;
              }
            }

            regResult = data.pageAccess.access.match(/outside-viewing-window-([0-9]+)/);

            if(regResult !== null)
            {
              if(regResult.length === 2)
              { 
                  var date = new Date(regResult[1] * 1000);
                  var dateText = date.toLocaleDateString("fr",{ weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
                  tooltiptext = `Disponible sur: ${dateText}`;
              }
            }

            b.addClass("vnj-tooltip");
            b.append("<span class='vnj-tooltiptext'>" + tooltiptext +"</span>")
            const link = b.children("a");
            link.addClass("memberspace-disabled-button");

            b.click(function(){
              $("#vnj-modal-title").empty();
              $("#vnj-modal-text").empty();
              $("#vnj-modal-title").append("Pas encore disponible");
              $("#vnj-modal-text").append(tooltiptext);
              $('#vnj-modal').modal();
            }

            );
          }
        });
       
      });
    });
  }());
	


