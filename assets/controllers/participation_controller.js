import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["message", "button", "count"];

    async participate(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const url = button.href;
        const countDOM = this.countTarget;
        const count = parseInt(this.countTarget.textContent, 10);
        console.log(count);

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            const data = await response.json();

            this.showMessage(data.message, "success");

            // 🔁 Mise à jour bouton
            button.textContent = "Je me désinscris";
            button.href = url.replace("register", "remove");
            button.setAttribute(
                "data-action",
                "click->participation#unsubscribe"
            );

            countDOM.textContent = count + 1;

        } catch (error) {
            console.error(error);
            this.showMessage("Erreur lors de la participation", "error");
        }
    }

    async unsubscribe(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const url = button.href;
        const count = parseInt(this.countTarget.textContent, 10);

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            const data = await response.json();

            this.showMessage(data.message, "success");

            // 🔁 Mise à jour bouton
            button.textContent = "Participer";
            button.href = url.replace("remove", "register");
            button.setAttribute(
                "data-action",
                "click->participation#participate"
            );

            this.countTarget.textContent = count - 1;

        } catch (error) {
            console.error(error);
            this.showMessage("Erreur lors de la désinscription", "error");
        }
    }

    showMessage(text, type) {
        this.messageTarget.textContent = text;
        this.messageTarget.className = `flash-message ${type}`;
        this.messageTarget.style.display = "block";

        setTimeout(() => {
            this.messageTarget.style.display = "none";
        }, 3000);
    }
}