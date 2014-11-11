<?php
return array(

    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */

    /**
     * Storage
     */
    'storage' => 'Session',

    /**
     * Consumers
     */
    'consumers' => array(

        /**
         * Facebook
         */
        'Facebook' => array(
            'client_id'     => '1535813146638728',
            'client_secret' => '10b1fa9694746c0419747fe61a66edf5',
            'scope'         => array('email'),
        ),

        'Google' => array(
            'client_id'     => '196849152053-5uv7q5vkhjkt7bqclbd2ftng1b91fbg6.apps.googleusercontent.com',
            'client_secret' => 'miRAGJIsnZ6mwGIcQk5t1h9d',
            'scope'         => array('userinfo_email', 'userinfo_profile'),
        ),

    )

);