import.meta.glob(["../images/**"]);
import "./bootstrap";
import collapse from "@alpinejs/collapse";
import anchor from "@alpinejs/anchor";

document.addEventListener(
    "alpine:init",
    () => {
        const modules = import.meta.glob("./plugins/**/*.js", { eager: true });

        for (const path in modules) {
            window.Alpine.plugin(modules[path].default);
        }
        window.Alpine.plugin(collapse);
        window.Alpine.plugin(anchor);

        window.Alpine.store("dialogLaporanVerifikasi", {
            isValidating: false,
            isValidationDone: false,
            toggleIsValidating() {
                this.isValidating = !this.isValidating;
            },
            reportId: null,
            validationResults: {},
        });
    },
    { once: true },
);
