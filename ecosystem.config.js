module.exports = {
    apps: [
        {
            name: "laravel-caddy",
            interpreter: "none",
            cwd: "/var/www/laravel",
            script: "/usr/bin/frankenphp",
            args: "run --config /var/www/laravel/Caddyfile",
            autorestart: true,
            watch: false,
            max_memory_restart: "1G",
            env: {
                NODE_ENV: "production",
                // Jika perlu environment variables khusus
            },
            output: "/var/log/pm2/laravel-caddy-out.log",
            error: "/var/log/pm2/laravel-caddy-err.log",
            merge_logs: true,
            log_date_format: "YYYY-MM-DD HH:mm:ss",
        },
    ],
};
