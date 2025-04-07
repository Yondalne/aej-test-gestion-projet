// import './bootstrap';
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css"; // Import du CSS des toasts
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

const toastOptions = {
    position: "top-right",
    timeout: 5000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false,
};
createInertiaApp({
    progress: {
        color: "#4B5563",
    },
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Toast, toastOptions)
            .mount(el);
    },
});

const toast = useToast();

// Intercepter les erreurs de validation
router.on("error", (errors) => {
    if (Object.keys(errors).length > 0) {
        // Afficher le premier message d'erreur comme toast
        const firstError = Object.values(errors)[0];
        if (Array.isArray(firstError) && firstError.length > 0) {
            toast.error(firstError[0]);
        }
    }
});

// Intercepter les réponses
router.on("finish", (event) => {
    // Si le statut HTTP est 422 (Unprocessable Entity - erreurs de validation)
    if (event.detail.visit.response?.status === 422) {
        // Déjà géré par l'intercepteur d'erreurs ci-dessus
        return;
    }

    // Pour les autres erreurs HTTP (500, 404, etc.)
    if (
        event.detail.visit.response &&
        event.detail.visit.response.status >= 400
    ) {
        toast.error(
            `Erreur ${event.detail.visit.response.status}: Une erreur est survenue`
        );
    }
});
