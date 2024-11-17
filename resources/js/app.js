import "./bootstrap";

import collapse from "@alpinejs/collapse";
import anchor from "@alpinejs/anchor";
import { embed, pdfobjectversion } from "pdfobject";

document.addEventListener(
    "alpine:init",
    () => {
        const modules = import.meta.glob("./plugins/**/*.js", { eager: true });

        for (const path in modules) {
            window.Alpine.plugin(modules[path].default);
        }
        window.Alpine.plugin(collapse);
        window.Alpine.plugin(anchor);

        window.embed = embed;
    },
    { once: true },
);
