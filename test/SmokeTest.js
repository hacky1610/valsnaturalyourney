const {Builder, By, Key, until} = require('selenium-webdriver');
const firefox = require('selenium-webdriver/firefox');
//const siteUri = 'http://localhost';
const siteUri = 'https://vals-natural-journey.de';

let driver =  new Builder().forBrowser('firefox').setFirefoxOptions(new firefox.Options().headless()).build();

driver.get(siteUri).then(function(){
  driver.findElement(By.className('homebar')).then(function(webElement) {
    console.log("Found");
  },
  function(err) {
      console.log(err);
      process.exit(-1);
  }
  );
});
