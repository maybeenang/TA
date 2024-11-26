export default function (Alpine) {
    Alpine.directive("image-viewer", (el, directive) => {
        if (directive.value === "input") handleInput(el, Alpine);
        else if (directive.value === "previewer") handlePreviewer(el, Alpine);
        else handleRoot(el, Alpine);
    }).before("bind");
}

function handleRoot(el, Alpine) {}

function handleInput(el, Alpine) {
    Alpine.bind(el, () => {
        return {
            "x-init"() {
                this.__init();
            },
            "x-data"() {
                return {
                    __previewer: null,
                    __previewrContainer: null,
                    __file: null,
                    __init() {
                        this.__previewer = this.$refs["image-previewer"];
                        this.__previewrContainer = this.$refs["image-previewer-container"];
                    },
                    __updatePreview() {
                        console.log("Updating preview...");

                        if (!this.__file) {
                            this.__previewer.src = "";
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = (event) => {
                            this.__previewrContainer.classList.remove("bg-gray-200");
                            this.__previewer.src = event.target.result;
                        };

                        reader.readAsDataURL(this.__file);

                        console.log("Preview updated!");
                    },
                    __handleInput(event) {
                        this.__file = event.target.files[0];
                        event.target.files = event.target.files;
                        this.__updatePreview();
                    },
                };
            },
            ":id"() {
                return this.$id("image-input");
            },
            "x-on:change"() {
                return this.__handleInput(this.$event);
            },
        };
    });
}
