<?php
// ==================================================================
// === AYARLAR BÖLÜMÜ ===
// ==================================================================

// --- Veritabanı Bağlantı Bilgileri ---
define('DB_HOST', 'localhost');
define('DB_USER', 'u271340643_root');
define('DB_PASS', 'B>BC#85h');
define('DB_NAME', 'u271340643_altinoran');

// --- Genel Site Ayarları ---
define('SITE_BASE_URL', 'https://www.altinorankimya.com/haberler/'); // Haberlerin bulunduğu ana klasörün URL'si
define('PUBLICATION_NAME', 'Altın Oran Kimya'); // Sitenizin veya yayınınızın adı
define('PUBLICATION_LANG', 'tr'); // Yayın dili
define('SITE_DESCRIPTION', 'Altın Oran Kimya - En güncel haberler ve gelişmeler.'); // RSS için site açıklaması

// --- Google News Site Haritası Ayarları ---
define('SITEMAP_FILE', 'news-sitemap.xml'); // Oluşturulacak Google News Site Haritası dosyasının adı
define('SITEMAP_URL_LIFETIME_HOURS', 48);   // Haberlerin site haritasında kalma süresi (saat)

// --- RSS Feed Ayarları ---
define('RSS_FILE_NAME', 'rss.xml'); // Oluşturulacak RSS dosyasının adı
define('RSS_ITEM_LIMIT', 20);      // RSS feed'inde gösterilecek son haber sayısı

// --- Resim Oluşturma Ayarları ---
define('FONT_PATH', __DIR__ . '/font/Oswald-Bold.ttf');
define('BACKGROUND_DIR', __DIR__ . '/arkaplan/');
define('IMAGE_SAVE_DIR', __DIR__ . '/HaberResim/');

// === YENİ: Google Indexing API Ayarı ===
define('GOOGLE_CREDENTIALS_FILE', __DIR__ . '/credentials.json'); // Google servis hesabı anahtar dosyasının yolu

// --- Saat Dilimi Ayarı (ÇOK ÖNEMLİ) ---
date_default_timezone_set('Europe/Istanbul');

// --- Hata Raporlama (Geliştirme için açık bırakıldı) ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ==================================================================
// === DEMO MODU (GET İsteği ile Resim Testi için) ===
// ==================================================================
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['title'])) {
    $demo_title = $_GET['title'];
    $demo_slug = 'demo-' . time();
    generate_news_image($demo_title, $demo_slug, true); // Resmi oluştur ve tarayıcıya bas
    exit;
}

// ==================================================================
// === API İŞLEMLERİ (POST İstekleri İçin Ana Mantık) ===
// ==================================================================

// Scriptin geri kalanının JSON döndüreceğini belirt
header('Content-Type: application/json; charset=utf-8');

// Veritabanı bağlantısı kur
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset("utf8mb4");
$conn->query("SET time_zone = '+03:00'");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Veritabanı bağlantı hatası: ' . $conn->connect_error]);
    exit;
}

// Sadece POST isteklerini kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Sadece POST istekleri kabul edilir.']);
    exit;
}

// Gelen JSON verisini al ve çöz
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// JSON formatını kontrol et
if (json_last_error() !== JSON_ERROR_NONE || $data === null) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz JSON formatı.']);
    exit;
}

// Gerekli alanların gelip gelmediğini kontrol et
$required_fields = ['title', 'description', 'h1', 'main_text', 'slug_url', 'original_link', 'original_title'];
foreach ($required_fields as $field) {
    if (!isset($data[$field])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => "Eksik alan: {$field}"]);
        exit;
    }
}

// Haberi veritabanına ekle
$created_at_time = date('Y-m-d H:i:s');
$kategori = 'Araba'; // Kategori'yi burada belirliyoruz
$stmt = $conn->prepare("INSERT INTO haberler (title, description, h1, main_text, slug_url, original_link, original_title, created_at, kategori) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss",
    $data['title'],
    $data['description'],
    $data['h1'],
    $data['main_text'],
    $data['slug_url'],
    $data['original_link'],
    $data['original_title'],
    $created_at_time,
    $kategori
);

if ($stmt->execute()) {
    $last_id = $stmt->insert_id;

    // 1. Haber resmini oluştur
    $image_path = generate_news_image($data['title'], $data['slug_url']);

    // Resim başarıyla oluşturulduysa veritabanını güncelle
    if ($image_path) {
        $update_stmt = $conn->prepare("UPDATE haberler SET image_path = ? WHERE id = ?");
        $update_stmt->bind_param("si", $image_path, $last_id);
        $update_stmt->execute();
        $update_stmt->close();
    }

    // 2. Google News Site Haritasını güncelle
    $sitemap_updated = update_news_sitemap($data);

    // 3. RSS Feed'i güncelle
    $rss_updated = update_rss_feed($conn);

    // === YENİ: Google Indexing API Çağrısı ===
    // 4. Haberi Google Indexing API'ye gönder
    $haber_url_for_google = SITE_BASE_URL . $data['slug_url'];
    $indexing_result = send_to_google_indexing_api($haber_url_for_google, GOOGLE_CREDENTIALS_FILE);
    // ==========================================

    // Başarı mesajını oluştur
    $message = 'Haber başarıyla eklendi.';
    $message .= $image_path ? ' Haber resmi oluşturuldu.' : ' Ancak haber resmi oluşturulamadı.';
    $message .= $sitemap_updated ? ' Site haritası güncellendi.' : ' Ancak site haritası güncellenemedi.';
    $message .= $rss_updated ? ' RSS feed güncellendi.' : ' Ancak RSS feed güncellenemedi.';

    // === YENİ: Indexing sonucunu mesaja ekle ===
    $message .= ' Google Indexing API: ' . ($indexing_result['success'] ? 'Talep başarıyla gönderildi.' : 'Talep gönderilemedi!');


    // Başarılı API cevabını döndür
    echo json_encode([
        'status' => 'success',
        'message' => $message,
        'id' => $last_id,
        'image_path' => $image_path,
        'sitemap_url' => SITE_BASE_URL . SITEMAP_FILE,
        'rss_feed_url' => SITE_BASE_URL . RSS_FILE_NAME,
        'indexing_status' => $indexing_result // === YENİ: Indexing sonucunun detayları
    ]);

} else {
    // Veritabanı ekleme hatası durumunda
    http_response_code(500);
    if ($conn->errno == 1062) { // 1062: Duplicate entry hatası
         echo json_encode(['status' => 'error', 'message' => 'Haber eklenemedi: Bu `slug_url` zaten mevcut. (' . $data['slug_url'] . ')']);
    } else {
         echo json_encode(['status' => 'error', 'message' => 'Haber eklenemedi: ' . $stmt->error]);
    }
}

// Bağlantıları kapat
$stmt->close();
$conn->close();


// ==================================================================
// === YARDIMCI FONKSİYONLAR ===
// ==================================================================

// === YENİ EKLENEN FONKSİYONLAR: Google Indexing API ===

/**
 * Standart Base64'ü JWT için gereken URL-güvenli Base64'e dönüştürür.
 * @param string $data Kodlanacak veri.
 * @return string URL-güvenli Base64 formatında kodlanmış veri.
 */
function base64UrlEncode(string $data): string {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 * Google Indexing API'ye kütüphane kullanmadan, "vanilya PHP" ile bir URL gönderir.
 * @param string $url Gönderilecek URL.
 * @param string $credentialsPath `credentials.json` dosyasının yolu.
 * @return array Sonuçları içeren bir dizi.
 */
function send_to_google_indexing_api(string $url, string $credentialsPath): array {
    $response = ['success' => false, 'message' => '', 'details' => null];
    try {
        if (!file_exists($credentialsPath)) throw new Exception("Kimlik doğrulama dosyası bulunamadı: {$credentialsPath}");
        $credentials = json_decode(file_get_contents($credentialsPath), true);
        if (!$credentials) throw new Exception("Kimlik doğrulama dosyası okunamadı veya geçersiz JSON.");

        $clientEmail = $credentials['client_email'];
        $privateKey = $credentials['private_key'];
        $tokenUri = $credentials['token_uri'];

        $jwtHeader = base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $now = time();
        $jwtPayload = base64UrlEncode(json_encode([
            'iss' => $clientEmail,
            'scope' => 'https://www.googleapis.com/auth/indexing',
            'aud' => $tokenUri,
            'exp' => $now + 3600,
            'iat' => $now
        ]));

        $dataToSign = $jwtHeader . '.' . $jwtPayload;
        $signature = '';
        if (!openssl_sign($dataToSign, $signature, $privateKey, 'sha256WithRSAEncryption')) throw new Exception("JWT imzası oluşturulamadı: " . openssl_error_string());
        $jwt = $dataToSign . '.' . base64UrlEncode($signature);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUri);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer', 'assertion' => $jwt]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tokenResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode != 200) throw new Exception("Erişim jetonu alınamadı. Yanıt: " . $tokenResponse);
        $tokenData = json_decode($tokenResponse, true);
        $accessToken = $tokenData['access_token'];

        $apiUrl = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
        $apiRequestData = json_encode(['url' => $url, 'type' => 'URL_UPDATED']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $apiRequestData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . $accessToken]);
        $apiResponse = curl_exec($ch);
        $apiHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($apiHttpCode === 200) {
            $response['success'] = true;
            $response['message'] = 'URL başarıyla Google Indexing API\'ye gönderildi.';
            $response['details'] = json_decode($apiResponse, true);
        } else {
            throw new Exception("API'den beklenmedik durum kodu: {$apiHttpCode}. Yanıt: " . $apiResponse);
        }
    } catch (Exception $e) {
        $response['message'] = 'Hata oluştu: ' . $e->getMessage();
    }
    return $response;
}

// ==================================================================

/**
 * Verilen başlık ile haber için bir tanıtım resmi oluşturur.
 * @param string $title Resmin üzerine yazılacak başlık.
 * @param string $slug Kaydedilecek dosyanın adı (uzantısız).
 * @param bool $output_to_browser Demoda anlık çıktı için true yapın.
 * @return string|false Başarılı olursa kaydedilen dosyanın yolu, olmazsa false.
 */
function generate_news_image($title, $slug, $output_to_browser = false) {
    // ... Sizin mevcut kodunuz ...
    if (!is_dir(BACKGROUND_DIR) || !is_readable(BACKGROUND_DIR)) { error_log("HATA: Arkaplan dizini yok: ".BACKGROUND_DIR); return false; }
    $backgrounds = glob(BACKGROUND_DIR . '*.webp');
    if (empty($backgrounds)) { error_log("HATA: Arkaplan dizini boş."); return false; }
    $random_background = $backgrounds[array_rand($backgrounds)];
    if (!file_exists(FONT_PATH)) { error_log("HATA: Font dosyası yok: ".FONT_PATH); return false; }
    if (!function_exists('imagecreatefromwebp')) { error_log("HATA: GD kütüphanesinde WebP desteği yok."); return false; }

    $image = @imagecreatefromwebp($random_background);
    if (!$image) { error_log("HATA: Arkaplan resmi işlenemedi: ".$random_background); return false; }

    $width = imagesx($image);
    $height = imagesy($image);
    $white = imagecolorallocate($image, 255, 255, 255);
    $padding = $width * 0.1;
    $font_size = $height / 10;
    $text_box_width = $width - (2 * $padding);

    $wrapped_text = '';
    $words = explode(' ', $title);
    $line = '';
    foreach ($words as $word) {
        $test_line = $line . ($line ? ' ' : '') . $word;
        $bbox = imagettfbbox($font_size, 0, FONT_PATH, $test_line);
        if ($bbox[2] > $text_box_width) {
            $wrapped_text .= ($wrapped_text ? "\n" : "") . $line;
            $line = $word;
        } else {
            $line = $test_line;
        }
    }
    $wrapped_text .= ($wrapped_text ? "\n" : "") . $line;

    while (true) {
        $bbox = imagettfbbox($font_size, 0, FONT_PATH, $wrapped_text);
        $text_height = abs($bbox[7] - $bbox[1]);
        if ($text_height > $height - (2 * $padding) && $font_size > 10) {
            $font_size -= 2;
        } else {
            break;
        }
    }

    $bbox = imagettfbbox($font_size, 0, FONT_PATH, $wrapped_text);
    $text_width = $bbox[2] - $bbox[0];
    $text_height = abs($bbox[7] - $bbox[1]);
    $x = ($width - $text_width) / 2;
    $y = (($height - $text_height) / 2) + abs($bbox[7]);

    imagettftext($image, $font_size, 0, $x, $y, $white, FONT_PATH, $wrapped_text);

    if ($output_to_browser) {
        header('Content-Type: image/jpeg');
        imagejpeg($image);
    } else {
        if (!is_dir(IMAGE_SAVE_DIR)) { mkdir(IMAGE_SAVE_DIR, 0755, true); }
        if (!is_writable(IMAGE_SAVE_DIR)) { error_log("HATA: Resim kaydetme dizinine yazılamıyor."); return false; }
        $save_path_relative = 'HaberResim/' . $slug . '.jpg';
        $save_path_absolute = IMAGE_SAVE_DIR . $slug . '.jpg';
        imagejpeg($image, $save_path_absolute, 90);
    }

    imagedestroy($image);
    return $output_to_browser ? true : ($save_path_relative ?? false);
}


/**
 * Google News standartlarına uyumlu bir site haritası oluşturur veya günceller.
 * @param array $new_article_data Yeni eklenen haberin verileri.
 * @return bool Başarılı olursa true, olmazsa false.
 */
function update_news_sitemap($new_article_data) {
    // ... Sizin mevcut kodunuz ...
    $sitemap_path = SITEMAP_FILE;
    $new_article_location = SITE_BASE_URL . $new_article_data['slug_url'];
    define('NEWS_SITEMAP_NS', 'http://www.google.com/schemas/sitemap-news/0.9');
    $xml_root_string = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="' . NEWS_SITEMAP_NS . '"></urlset>';
    $valid_articles = [];
    if (file_exists($sitemap_path) && filesize($sitemap_path) > 0) {
        libxml_use_internal_errors(true);
        $existing_xml = simplexml_load_file($sitemap_path);
        if ($existing_xml !== false) {
            $expiration_time = time() - (SITEMAP_URL_LIFETIME_HOURS * 3600);
            foreach ($existing_xml->url as $url_node) {
                $news_data = $url_node->children(NEWS_SITEMAP_NS)->news;
                if (!$news_data || (string)$url_node->loc == $new_article_location) continue;
                $publication_date_str = (string)$news_data->children(NEWS_SITEMAP_NS)->publication_date;
                if (strtotime($publication_date_str) >= $expiration_time) {
                    $valid_articles[] = ['loc' => (string)$url_node->loc, 'publication_date' => $publication_date_str, 'title' => (string)$news_data->children(NEWS_SITEMAP_NS)->title];
                }
            }
        }
        libxml_clear_errors();
    }
    array_unshift($valid_articles, ['loc' => $new_article_location, 'publication_date' => date(DATE_W3C), 'title' => $new_article_data['title']]);
    $final_xml = new SimpleXMLElement($xml_root_string);
    foreach ($valid_articles as $article) {
        $url_entry = $final_xml->addChild('url');
        $url_entry->addChild('loc', htmlspecialchars($article['loc'], ENT_XML1, 'UTF-8'));
        $news_block = $url_entry->addChild('news:news', '', NEWS_SITEMAP_NS);
        $publication_block = $news_block->addChild('news:publication', '', NEWS_SITEMAP_NS);
        $publication_block->addChild('news:name', PUBLICATION_NAME, NEWS_SITEMAP_NS);
        $publication_block->addChild('news:language', PUBLICATION_LANG, NEWS_SITEMAP_NS);
        $news_block->addChild('news:publication_date', $article['publication_date'], NEWS_SITEMAP_NS);
        $news_block->addChild('news:title', htmlspecialchars($article['title'], ENT_XML1, 'UTF-8'), NEWS_SITEMAP_NS);
    }
    $dom = new DOMDocument("1.0", "UTF-8");
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($final_xml->asXML());
    if (!$dom->save($sitemap_path)) {
        error_log("Hata: " . SITEMAP_FILE . " dosyasına yazılamadı.");
        return false;
    }
    return true;
}

/**
 * Veritabanındaki son haberleri çekerek standartlara uygun bir RSS 2.0 feed dosyası oluşturur.
 * @param mysqli $db_connection Aktif veritabanı bağlantısı.
 * @return bool Başarılı olursa true, hata olursa false döner.
 */
function update_rss_feed($db_connection) {
    // ... Sizin mevcut kodunuz ...
    $limit = RSS_ITEM_LIMIT;
    $stmt = $db_connection->prepare("SELECT title, slug_url, description, created_at FROM haberler ORDER BY created_at DESC LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        error_log("RSS Hatası: Veritabanı sorgusu başarısız. " . $db_connection->error);
        return false;
    }

    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    $rss = $dom->createElement('rss');
    $rss->setAttribute('version', '2.0');
    $rss->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:atom', 'http://www.w3.org/2005/Atom');
    $dom->appendChild($rss);

    $channel = $dom->createElement('channel');
    $rss->appendChild($channel);

    $atomLink = $dom->createElement('atom:link');
    $atomLink->setAttribute('href', SITE_BASE_URL . RSS_FILE_NAME);
    $atomLink->setAttribute('rel', 'self');
    $atomLink->setAttribute('type', 'application/rss+xml');
    $channel->appendChild($atomLink);

    $channel->appendChild($dom->createElement('title', PUBLICATION_NAME));
    $channel->appendChild($dom->createElement('link', SITE_BASE_URL));
    $channel->appendChild($dom->createElement('description', SITE_DESCRIPTION));
    $channel->appendChild($dom->createElement('language', PUBLICATION_LANG));
    $channel->appendChild($dom->createElement('lastBuildDate', date(DATE_RFC2822)));

    while ($row = $result->fetch_assoc()) {
        $item = $dom->createElement('item');
        $channel->appendChild($item);

        $item->appendChild($dom->createElement('title', $row['title']));

        $link = SITE_BASE_URL . $row['slug_url'];
        $item->appendChild($dom->createElement('link', $link));

        $guid = $dom->createElement('guid', $link);
        $guid->setAttribute('isPermaLink', 'true');
        $item->appendChild($guid);

        $pubDate = date(DATE_RFC2822, strtotime($row['created_at']));
        $item->appendChild($dom->createElement('pubDate', $pubDate));

        $descriptionNode = $dom->createElement('description');
        $descriptionNode->appendChild($dom->createCDATASection($row['description']));
        $item->appendChild($descriptionNode);
    }

    $stmt->close();

    if ($dom->save(RSS_FILE_NAME)) {
        return true;
    } else {
        error_log("Hata: " . RSS_FILE_NAME . " dosyasına yazılamadı.");
        return false;
    }
}
?>
