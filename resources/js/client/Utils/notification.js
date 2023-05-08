import Notification from "@/Argon/components/Notification";
import { useToast } from "vue-toastification";

export function runToast(pos, type, ownText, ownIcon) {
    const text =
        "Welcome to <b>Vue Argon Dashboard Pro</b> - a beautiful resource for every web developer";
    const icon = "ni ni-bell-55";
    const content = {
        component: Notification,
        props: {
            ownText: ownText,
            ownIcon: ownIcon,
            icon: icon,
            text: text,
            type: type,
        },
    };
    const toast = useToast();
    toast(content, {
        hideProgressBar: true,
        icon: false,
        closeButton: false,
        position: pos,
    });
}
