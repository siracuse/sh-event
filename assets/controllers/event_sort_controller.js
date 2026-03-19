import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["list", "pagination"];

    filter(event) {
        const selected = event.currentTarget.value;
        const cards = this.listTarget.querySelectorAll(".event-grid");

        cards.forEach(card => {
            if (selected === "all" || card.dataset.type === selected) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });

        // 🔥 Gestion de la pagination
        if (selected === "all") {
            this.paginationTarget.style.display = "block";
        } else {
            this.paginationTarget.style.display = "none";
        }
        this.element.scrollIntoView({ behavior: "smooth" });
    }
}