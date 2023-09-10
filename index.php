<?php
header('Content-Type: application/json');
$slack_name = isset($_GET['slack_name']) ? htmlspecialchars($_GET['slack_name']) : '';
$track = isset($_GET['track']) ? htmlspecialchars($_GET['track']) : '';


$currentUTC = gmdate('Y-m-d\TH:i\Z');
$currentDay = gmdate('l');
$clientOffsetHours = 0;

// Validate the client's offset is within +/-2 hours
if ($clientOffsetHours < -2 || $clientOffsetHours > 2) {
    // Return an error response with a 400 status code
    http_response_code(400);
    echo json_encode(['error' => 'Invalid offset. Offset must be between -2 and 2 hours.']);
} else {
    $adjustedUTC = gmdate('Y-m-d\TH:i:s\Z', strtotime("$currentUTC + $clientOffsetHours hours"));
/*
{
  "slack_name": "example_name",
  "current_day": "Monday",
  "utc_time": "2023-08-21T15:04:05Z",
  "track": "backend",
  "github_file_url": "https://github.com/username/repo/blob/main/file_name.ext",
  "github_repo_url": "https://github.com/username/repo",
  “status_code”: 200
}
*/
    // Create the JSON response
    $response = [
        "slack_name"=> $slack_name,
        "current_day"=> $currentDay,
        "utc_time"=> $adjustedUTC,
        "track"=> $track,
        "github_file_url"=> "https://github.com/tasiukwaplong/hng/blob/main/index.php",
        "github_repo_url"=> "https://github.com/tasiukwaplong/hng",
        "status_code"=> 200
    ];

    // Return the JSON response with a 200 status code
    http_response_code(200);
    echo json_encode($response);
}
