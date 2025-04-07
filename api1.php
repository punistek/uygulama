<?php
header("Content-Type: application/json");

$data = [
    [
        "title" => "TRT 1",
        "image" => "https://example.com/img/trt1.png",
        "url" => "https://asil-link.com/kanal1.mp4",
        "referer" => "https://referer.com",
        "origin" => "https://origin.com",
        "cookie" => "cookie1",
        "agent" => "Mozilla/5.0",
        "mime" => "video/mp4",
        "drm" => "TRT 1 Canlı"
    ],
    [
        "title" => "TRT Spor",
        "image" => "https://example.com/img/trtspor.png",
        "url" => "https://asil-link.com/kanal2.mp4",
        "referer" => "https://referer2.com",
        "origin" => "https://origin2.com",
        "cookie" => "cookie2",
        "agent" => "Mozilla/5.0",
        "mime" => "video/mp4",
        "drm" => "TRT Spor Canlı"
    ]
];

echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
