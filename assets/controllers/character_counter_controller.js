import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["input", "counter"];

    static values = {
        max: Number
    };

    connect() {
        this.update();
    }

    update() {
        const length = this.inputTarget.value.length;
        const max = this.maxValue;

        this.counterTarget.textContent = `${length} / ${max}`;

        // Optionnel : gestion des couleurs
        if (length > max) {
            this.counterTarget.style.color = "red";
        } else if (length > max * 0.8) {
            this.counterTarget.style.color = "orange";
        } else {
            this.counterTarget.style.color = "gray";
        }
    }
}