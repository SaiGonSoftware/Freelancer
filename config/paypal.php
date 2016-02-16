<?php
return array(
    // set your paypal credential
    'client_id' => 'AQ0KTqzxHtdHMzSwM5dSquFdvvbb9w-Dazm4mtSEymDSCYBeQ9XZgcOot5ehvbHAU1kUWQHBz-0a9oFu',
    'secret' => 'EL1_e7iZt2NYWqvcVkrmIgMIu0BKYcr4LUYFgiwso657rp5IBxe0QsQ5cdAIETinNFYzrbR41hYV1C_B',

    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);