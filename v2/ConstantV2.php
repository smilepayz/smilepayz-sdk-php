<?php

/**
 * param
 */
const CURRENCY_IDR = "IDR";
const CURRENCY_THB = "THB";
const CURRENCY_BRL = "BRL";
const CURRENCY_INR = "INR";
const CURRENCY_MXN = "MXN";


const INDONESIA_CODE = 10;
const THAILAND_CODE = 11;
const INDIA_CODE = 12;
const BRAZIL_CODE = 13;

const MEXICO_CODE = 14;

const TRADE_TYPE_PAY_IN = 1;
const TRADE_TYPE_PAY_OUT = 2;

/**
 * DateTime
 */
const F_0 = "yyyy-MM-dd'T'HH:mm:ssXXX";

/**
 * Payin_API.
 * From docs API
 */
const PAY_IN_API = "/v2.0/transaction/pay-in";

/**
 * Payout_API.
 * From docs API
 */
const PAY_OUT_API = "/v2.0/disbursement/cash-out";


const CONTENT_TYPE = "application/json";


const BASE_URL= 'https://gateway.smilepayz.com';
const BASE_URL_SANDBOX='https://sandbox-gateway.smilepayz.com';
const MERCHANT_ID='your merchant id';
const MERCHANT_ID_SANDBOX='your merchant id in sandbox';
const MERCHANT_SECRET='merchant secret';
const MERCHANT_SECRET_SANDBOX='merchant secret in sandbox ';
/**
 * Example: MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCksGjVIWAYoM9O9o0cm0wezA/+/8UFL1EL4DSOpKxsPn68PdZzEdmeuowl7EbLLzI4e3jW+u1bK9F4qatZW4lMQ4fJLs84QGfXftHG/Om1fjT9U2RSKzBYSuXRBjnM5HlvxhrYedHlcfO3EKbU2RUv2AxGGb210OeBSaFFtRXAvyIMkDo9YHOZSF0vm0x67ws0QoVH7fZiE/rkKWJJyg+pwY4rNqMZ1qin/8qt7bBIiRWOMHgMd077JATZ2GqXrbvAer90gKXLPqWgU0O6J8DCHKrxMLAsjoyAcfSWgOVTtdLIve1/aUdA2nH7+43jEfh0fSucpcEMVb6HDU7jh1AFAgMBAAECggEADh0iNtW/5wxtB87gZAm5GdCSNF/WEi4ua26hAnKBZltqwBYqmTz34f8JwLxBius2ChomzoG9srkMICOmUCekmhkVe3vb/W2jmJfBQaTuIIQ65VTuvY3+/CobDPFUJceU0qvvJAs4nknIQbGXIpmiE7IXxzAwjnLjTDSzsgYlYZm8fS1UV3UnOWtgcZyNkSfJ38j9nIpONwf9JUWWXXLy3r27UHVxy4D+uXXOh0IAVfXebstsO3cWSxctSPdEMGmzNJH/AB9hfF11p9VuWwNsx3wM2G67ct/6NGoyqPOcCgV8GhqxCzdrY/DQwmN/EF+lnbI4cIlvEG8hIYEJVOaVwQKBgQDAxZTnvMh7OBx/TGdSpU+yGMs36ruoR3wBomm6AI9prM/clL2kr05w10nGM+SWb1hLNkiYVd1MLtkkh+pDtflEl6M4myDaaad2ddcr8DfvmFFSIJI74C8c/EInVI+GlmzXvopp1uco6/3qsG+ou0sroMnkjLkKjviAB+bOFQEopQKBgQDatNCiwW5wRkBzzPXL8t5cbmesSHBIQRl1ViKVHjXHkmVxCa/iItgnqMI7wyT93TE6cJ3foJJo+vHo58WrdzZc8FBD0X6IgRDnl42/HZAzHmg33IMFQraUtuvz22X8pTHpWcsVczRDU3Y85jXjSuLmkGLYc1z4xN7TN9U3/t2L4QKBgQCjYlM0nmLlXMd6dU1VVNtZPX5wJDltBTlrQTaO+Y6TqG58rGyXuiWnqjDTFoR1pGWXSaj5xDzOJx7PwYqiXQeqRUOH5KNRux6+Xl5C1VTzc4vpKcYHjZkg3gVLxHXpQnF54fr6fbRqkKojUesxfZzWm27CkSr8cfTYvtm2bUMQKQKBgDUkAh3Jyj/VkguRHZg0pvrmiKI/56hmyPzNtRFuibq4Q5W3uNjFhqf8RVWoEPDuMev1OScBKRIBB46D4m/LQ5ZJffc8i/Y3Bhh/pp1tXYBOPxxzpBI/J4Xy/FoAUUOWEA6XFtVbbLN/MBeUCDv2EjPbmWjmfwyjKVFBG7nDX6mBAoGAQqhG1iw8Yqt7tliDGueYkOJuITX6cqdWURwcF3mv2HD4tPlOLQjuOG9AQ3P+jRLLhEBMbz7MHMTAU2RCOltku0UuI6nVGD3MK4wPA1rxLdf8vO+JaCodWW1XITVlMslztTx74BlfNkjsYHnt8oP5iDX5chy3yuKg1vCAm4Ehsko=
 * 
 */
const PRIVATE_KEY='merchant private key ';
const PUBLIC_KEY='platform public key';

