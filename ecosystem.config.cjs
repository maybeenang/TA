module.exports = {
    apps: [
        {
            name: "sispela",
            script: "php",
            args: "artisan octane:start --port=3002 --admin-port=2020 --caddyfile=Caddyfile",
            autorestart: true,
        },
        {
            name: "sispela-worker",
            script: "php",
            args: "artisan queue:work --queue=default --sleep=3 --tries=3",
            autoresart: true,
        },
    ],
};
