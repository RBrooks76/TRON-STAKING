module["exports"] = {
    apps: [
        {
            name: "trongoogol",
            script: "athe_zelsviukpwui.js",
            watch: !0,
            ignore_watch: [
                "logs/*",
                "public",
                "public/*"
            ],
            output: "logs/pm2/out.log",
            error: "logs/pm2/error.log",
            log: "logs/pm2/combined.outerr.log",
            env_production: {
                NODE_ENV: "prod"
            }
        }]
}