var buttonstyle = {
  layout: "horizontal",
  color: "gold",
  shape: "pill",
  label: "pay",
  tagline: "false",
  size: "medium"
};
var openWelcomePage = function() {
  jQuery(
    "<a href=&quot;https://vals-natural-journey.de/bienvenue-au-programme-chevelure-raiponce/&quot; target=&quot;_blank&quot;>&nbsp;</a>"
  )[0].click();
};
var onsuccess = function(data, actions) {
  openWelcomePage();
};
var oneTimeOrder = function(data, actions) {
  return actions.order.create({
    purchase_units: [
      {
        amount: { value: "197" }
      }
    ]
  });
};
var normalThreeTime = function(data, actions) {
  return actions.subscription.create({
    plan_id: "P-1ND27580UR020413JLZLOXPA"
  });
};
var normalFiveime = function(data, actions) {
  return actions.subscription.create({
    plan_id: "P-02Y32915G1658292GLZLOX7I"
  });
};
jQuery(document).ready(function() {
  jQuery(".tcb-button-link").on("click", function() {
    var id = ".one-time-button";
    jQuery(id).empty();
    paypal_sdk
      .Buttons({
        createOrder: oneTimeOrder,
        onApprove: onsuccess,
        style: buttonstyle,
        locale: "fr_FR"
      })
      .render(id);

    var id = ".normal-three-time-button";
    jQuery(id).empty();
    paypal_sdk
      .Buttons({
        createSubscription: normalThreeTime,
        onApprove: onsuccess,
        style: buttonstyle,
        locale: "fr_FR"
      })
      .render(id);

    var id = ".normal-five-time-button";
    jQuery(id).empty();
    paypal_sdk
      .Buttons({
        createSubscription: normalFiveime,
        onApprove: onsuccess,
        style: buttonstyle,
        locale: "fr_FR"
      })
      .render(id);
  });
});
