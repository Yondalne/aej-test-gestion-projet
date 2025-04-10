// resources/js/Composables/useToastTypes.js
import { h } from "vue";
import { useToast } from "vue-toastification";

export function useToastTypes() {
    const toast = useToast();

    // Toast pour les succès avec icône personnalisée
    const successToast = (message) => {
        return toast.success({
            component: h("div", { class: "flex items-center" }, [
                h("div", { class: "mr-2" }, [
                    h(
                        "svg",
                        {
                            class: "w-5 h-5",
                            xmlns: "http://www.w3.org/2000/svg",
                            viewBox: "0 0 20 20",
                            fill: "currentColor",
                        },
                        [
                            h("path", {
                                "fill-rule": "evenodd",
                                d: "M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z",
                                "clip-rule": "evenodd",
                            }),
                        ]
                    ),
                ]),
                h("div", {}, message),
            ]),
        });
    };

    // Toast pour les erreurs avec icône personnalisée
    const errorToast = (message) => {
        return toast.error({
            component: h("div", { class: "flex items-center" }, [
                h("div", { class: "mr-2" }, [
                    h(
                        "svg",
                        {
                            class: "w-5 h-5",
                            xmlns: "http://www.w3.org/2000/svg",
                            viewBox: "0 0 20 20",
                            fill: "currentColor",
                        },
                        [
                            h("path", {
                                "fill-rule": "evenodd",
                                d: "M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z",
                                "clip-rule": "evenodd",
                            }),
                        ]
                    ),
                ]),
                h("div", {}, message),
            ]),
        });
    };

    return {
        successToast,
        errorToast,
    };
}
