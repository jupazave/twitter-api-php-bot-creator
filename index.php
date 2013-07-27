<?php
    ini_set('display_errors', 1);
    require_once('TwitterAPIExchange.php');

    include_once('config.php');

    $url = 'https://api.twitter.com/1.1/search/tweets.json';
    $getfield = '?q=' . $config['twitter_search' ] . '&count=1';
    $requestMethod = 'GET';

    $twitter = new TwitterAPIExchange($config['settings']);
    $response = $twitter->setGetfield($getfield)
                        ->buildOauth($url, $requestMethod)
                        ->performRequest();

    $obj = json_decode($response, true);
    $tweet_id = $obj['statuses'][0]['id'];
    $tweet_screen_name = $obj['statuses'][0]['user']['screen_name'];
    $tweet_name = $obj['statuses'][0]['user']['name'];

    $rand = array_rand($config['text_strings'], 1);

    $status = "@" . $tweet_screen_name . " Hey " . $tweet_name . $config['text_strings'][$rand];

    $url = 'https://api.twitter.com/1.1/statuses/update.json';
    $requestMethod = 'POST';

    $postFields =  array(
        'status' => $status,
        'in_reply_to_status_id' => $tweet_id
        );

    $twitter = new TwitterAPIExchange($config['settings']);
    $response = $twitter->buildOauth($url, $requestMethod)
    ->setPostfields($postFields)
    ->performRequest();

    $obj = json_decode($response, true);
    $tweet_id = $obj['statuses'][0]['id'];
    $tweet_screen_name = $obj['statuses'][0]['user']['screen_name'];
    $tweet_name = $obj['statuses'][0]['user']['name'];
