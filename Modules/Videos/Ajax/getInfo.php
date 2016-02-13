<?php

$vidID = explode( '?v=', $_POST['url'] );
$vidID = $vidID[1];

echo file_get_contents( 'https://www.googleapis.com/youtube/v3/videos?id=' . $vidID . '&part=snippet&key=' . YOUTUBE_KEY );