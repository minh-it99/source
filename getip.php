<?php
// Lấy địa chỉ IP của người dùng chính xác
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($ipList as $ip) {
            $ip = trim($ip);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return $ip;
            }
        }
    }
    if (!empty($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        return $_SERVER['REMOTE_ADDR'];
    }
    return '0.0.0.0';
}


function get_nearest_timezone2($cur_lat, $cur_long, $country_code = '') {
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
                                    : DateTimeZone::listIdentifiers();

    if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

        $time_zone = '';
        $tz_distance = 0;

        //only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {

            foreach($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat   = $location['latitude'];
                $tz_long  = $location['longitude'];

                $theta    = $cur_long - $tz_long;
                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat))) 
                + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));
                // echo '<br />'.$timezone_id.' '.$distance; 

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone   = $timezone_id;
                    $tz_distance = $distance;
                } 

            }
        }
        return  $time_zone;
    }
    return 'unknown';
}

// Lấy thông tin IP từ ipinfo.io với xử lý lỗi tốt hơn
function getUserIPInfo() {
    $userIP = getUserIP();

    if ($userIP === '0.0.0.0') {
        return ["error" => "Không thể xác định địa chỉ IP của bạn."];
    }

    $apiToken = "1272fa553e2680"; // Token API của bạn
    $url = "https://web-api.nordvpn.com/v1/ips/lookup/{$userIP}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Tắt SSL nếu VPS có vấn đề với chứng chỉ SSL

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    // Kiểm tra lỗi cURL
    if ($response === false) {
        return ["error" => "Lỗi cURL: " . $curlError];
    }

    // Kiểm tra HTTP code
    if ($httpCode !== 200) {
        return ["error" => "API trả về mã lỗi HTTP: " . $httpCode];
    }

    // Giải mã JSON trả về
    $data = json_decode($response, true);
    
    // Kiểm tra nếu JSON bị lỗi hoặc không hợp lệ
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ["error" => "Phản hồi JSON không hợp lệ."];
    }

    return [
        "ip" => $data['ip'] ?? 'Không xác định',
        "city" => $data['city'] ?? 'Không xác định',
        "region" => $data['region'] ?? 'Không xác định',
        "country" => $data['country'] ?? 'Không xác định',
        "org" => $data['isp'] ?? 'Không xác định',
        "timezone" => get_nearest_timezone2($data['latitude'], $data['longitude'], $data['country_code'] ?? '') ?? 'Không xác định',
    ];
}

$ipInfo = getUserIPInfo();
$ip = $ipInfo['ip'] ?? 'Không xác định';
$city = $ipInfo['city'] ?? 'Không xác định';
$region = $ipInfo['region'] ?? 'Không xác định';
$country = $ipInfo['country'] ?? 'Không xác định';
$org = $ipInfo['org'] ?? 'Không xác định';
$timezone = $ipInfo['timezone'] ?? 'Không xác định';
?>
