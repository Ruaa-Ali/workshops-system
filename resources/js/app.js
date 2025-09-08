import "./bootstrap";

// import Alpine from "alpinejs";

document.addEventListener("alpine:init", () => {
    Alpine.store("theme", {
        // Check for a saved theme preference or default to 'light'
        current: localStorage.getItem("theme") || "light",

        init() {
            // Apply the theme on page load
            if (this.current === "dark") {
                document.documentElement.classList.add("dark");
            }

            this.updateBodyAttribute();
        },

        toggle() {
            this.current = this.current === "light" ? "dark" : "light";
            localStorage.setItem("theme", this.current);
            document.documentElement.classList.toggle("dark");
            this.updateBodyAttribute();
        },

        updateBodyAttribute() {
            if (this.current === "dark") {
                document.body.setAttribute("theme", "dark");
            } else {
                document.body.removeAttribute("theme");
            }
        },
    });
});

// Alpine.start();
