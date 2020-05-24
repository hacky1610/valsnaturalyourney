const {Builder, By, Key, until} = require('selenium-webdriver');
const firefox = require('selenium-webdriver/firefox');
 


let driver =  new Builder().forBrowser('firefox').setFirefoxOptions(new firefox.Options().headless()).build();

driver.get('https://vals-natural-journey.de/').then(function(){
    driver.getTitle().then(function(title) {
      console.log(title);
      driver.quit();
      throw "Foo";
    });
});
