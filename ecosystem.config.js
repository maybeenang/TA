module.exports = {
    apps: [
        {
            name: "maybeenang-portoif",
            interpreter: "none",
            cwd: "/var/www/laravel",
            script: "/usr/bin/frankenphp",
            args: "run --config /var/www/laravel/Caddyfile",
            autorestart: true,
            watch: false,
            max_memory_restart: "1G",
            output: "/var/log/pm2/laravel-caddy-out.log",
            error: "/var/log/pm2/laravel-caddy-err.log",
            merge_logs: true,
            log_date_format: "YYYY-MM-DD HH:mm:ss",
        },
    ],
};
