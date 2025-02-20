# Ultimate Crypto Portfolio Tracker & Analytics Hub!

Seamlessly aggregate all your wallet and exchange data into one powerful dashboard. Track, analyze, and optimize your crypto holdings like never before!

## Goals

All Your Crypto in One Place – Our platform consolidates your assets and trades across multiple exchanges and wallets, starting with Binance.

🔹 Real-Time Insights – Get up-to-date portfolio tracking, trade history analysis, and performance metrics.

🔹 Advanced Analytics – Gain deep insights with historical data, profit/loss tracking, and asset allocation breakdowns.

🔹 Secure & Private – We prioritize security with read-only API-based integrations, ensuring your data remains safe and cannot be modified.

## Features so far

* Import binance historical trade + sync recent trades via read-only API
* Compute Profit/Loss per asset and pessimistic average price

## Status

So far only binance API has been integrated. Next is Kraken.

## Getting started

#### 1. Requirement

- Requires a webserver with rewrite, mysql compatible database and PHP 8+
- Composer

#### 2. Install

1. copy the files to the server
2. run `composer install` in .admin folder
3. rename .env.example; add your database and configurations
4. run the deploy script in console or navigate to public/install.php

```
$ composer run-script deploy
```

5. Navigate to /.admin

6. Log in with your chosen root user

#### Customization:
- Full API (https://apigoat.com/docs/api/)
- Easy class hooks to customize (https://apigoat.com/docs/using-hooks-with-php/)

It is build on top of Slim4 and Propel Orm via The ApiGoat build engine.
For documentation on APIgoat build standards, check [apigoat.com](https://apigoat.com/).

Licenced under MIT