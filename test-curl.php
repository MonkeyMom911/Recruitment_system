<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

$output = curl_exec($ch);

if ($output === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo 'Curl success!';
}

curl_close($ch);
