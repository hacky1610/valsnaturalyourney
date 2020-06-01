const {Builder, By, Key, until} = require('selenium-webdriver');
const firefox = require('selenium-webdriver/firefox');
var assert = require('assert');//const siteUri = 'http://localhost';
const siteUri = 'https://vals-natural-journey.de';
let driver =  new Builder().forBrowser('firefox').setFirefoxOptions(new firefox.Options().headless()).build();


describe('Website', function() {
  describe('Homepage', function() {
    it('can be loaded', async () => {
      await driver.get(siteUri);
      let home = await driver.findElement(By.className('home'))
      assert.ok(true);
  });
});

  describe('Product page', function() {
    it('can be loaded', async () => {
      await driver.get(siteUri + "/product/la-recette-pour-des-cheveux-long-foo/");
      let home = await driver.findElement(By.className('single_add_to_cart_button'))
      assert.ok(true);
  });


  });
});

