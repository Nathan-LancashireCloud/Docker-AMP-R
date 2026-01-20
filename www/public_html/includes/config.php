<?php
// Error configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php/error.log');

// Secure environment variable retrieval
function getEnvVar($name, $default = null) {
    return getenv($name) ?: $default;
}

// Database configuration
$dbConfig = [
    'host'     => getEnvVar('MYSQL_HOST', 'db'),
    'database' => getEnvVar('MYSQL_DATABASE'),
    'username' => getEnvVar('MYSQL_USER'),
    'password' => getEnvVar('MYSQL_PASSWORD')
];

// RedisClient configuration
$redisConfig = [
    'host' => getEnvVar('REDIS_HOST', 'redis'),
    'port' => getEnvVar('REDIS_PORT', 6379)
];

// Database functions
function connectDB($config) {
    try {
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        return new PDO($dsn, $config['username'], $config['password'], $options);
    } catch (PDOException $e) {
        error_log("MySQL Connection Error: " . $e->getMessage());
        return null;
    }
}

// RedisClient functions
function connectRedis($config) {
    try {
        $redis = new Redis();
        $redis->connect($config['host'], $config['port'], 2);
        return $redis;
    } catch (Exception $e) {
        error_log("RedisClient Connection Error: " . $e->getMessage());
        return null;
    }
}

// Initialize connections
$db = connectDB($dbConfig);
$redis = connectRedis($redisConfig);

// System info
$phpVersion = phpversion();
$serverInfo = $_SERVER['SERVER_SOFTWARE'];
