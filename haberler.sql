--
-- Tablo için tablo yapısı `haberler`
--

CREATE TABLE `haberler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `h1` varchar(255) NOT NULL,
  `main_text` longtext NOT NULL,
  `slug_url` varchar(255) NOT NULL,
  `original_link` varchar(255) DEFAULT NULL,
  `original_title` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `kategori` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_url` (`slug_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
