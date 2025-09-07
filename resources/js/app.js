import "./bootstrap";

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";

Alpine.plugin(persist);
window.Alpine = Alpine;

import "./theme";

Alpine.start();
