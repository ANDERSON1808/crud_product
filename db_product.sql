
CREATE DATABASE
    `bd_product`
    /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */
    /*!80016 DEFAULT ENCRYPTION='N' */
;
-- bd_product.failed_jobs definition

CREATE TABLE
    `failed_jobs` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
        `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
        `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
        `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
        `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- bd_product.migrations definition

CREATE TABLE
    `migrations` (
        `id` int unsigned NOT NULL AUTO_INCREMENT,
        `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `batch` int NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- bd_product.password_resets definition

CREATE TABLE
    `password_resets` (
        `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        KEY `password_resets_email_index` (`email`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- bd_product.productos definition

CREATE TABLE
    `productos` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `referencia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `nombre_de_producto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `observaciones` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `precio` double(10, 2) NOT NULL,
        `impuesto` double(5, 2) NOT NULL,
        `cantidad` bigint NOT NULL,
        `estado` enum('activo', 'inactivo') COLLATE utf8mb4_unicode_ci DEFAULT 'activo',
        `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `productos_referencia_unique` (`referencia`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- bd_product.users definition

CREATE TABLE
    `users` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `email_verified_at` timestamp NULL DEFAULT NULL,
        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `users_email_unique` (`email`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;