const {Builder, By, Key, until} = require('selenium-webdriver');
const firefox = require('selenium-webdriver/firefox');
var assert = require('assert');//const siteUri = 'http://localhost';
const siteUri = 'https://vals-natural-journey.de';
let driver =  new Builder().forBrowser('firefox').setFirefoxOptions(new firefox.Options().headless()).build();

function sleep(ms) {
  return new Promise((resolve) => {
    setTimeout(resolve, ms);
  });
} 

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
      await driver.get(siteUri + "/product/la-recette-pour-des-cheveux-longs/");
      let addToCartButton = await driver.findElement(By.className('single_add_to_cart_button'))
      assert.ok(true);
    });

    it('can be added to cart', async () => {
      await driver.get(siteUri + "/product/la-recette-pour-des-cheveux-longs/");
      let addToCartButton = await driver.findElement(By.className('single_add_to_cart_button'))
      await addToCartButton.click();
      await sleep(5000)
      let message = await driver.findElement(By.className('woocommerce-message'))
      assert.ok(true);
    });


  });

  describe('Cart', function() {

    it('can be filled', async () => {
      await driver.get(siteUri + "/product/la-recette-pour-des-cheveux-longs/");
      let addToCartButton = await driver.findElement(By.className('single_add_to_cart_button'))
      await addToCartButton.click();
      await sleep(5000)
      await driver.get(siteUri + "/warenkorb/");
      let checkoutButton = await driver.findElement(By.className('checkout-button'))
      assert.ok(true);
    });


  });
});

