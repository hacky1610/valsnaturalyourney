const {Builder, By, Key, until} = require('selenium-webdriver');
 
(async function example() {
  let driver = await new Builder().forBrowser('firefox').build();
  try {
    await driver.get('https://vals-natural-journey.de/');
    await driver.wait(until.titleIs('Accueil - Vals Natural Journe'), 1000);
  } finally {
    await driver.quit();
  }
})();
