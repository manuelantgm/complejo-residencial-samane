const toastSuccess = () =>{
    createToast("toast-success","fa-regular fa-circle-check");
}
const toastWarning = () =>{
    createToast("toast-warning","fa-solid fa-triangle-exclamation");
}

const createToast = (classToast, classIcon) => {
    const listToast = document.querySelector("#list-toast");

    const toast = document.createElement("div");
    toast.setAttribute("class","toast " + classToast);

    const icon = document.createElement("i");
    icon.setAttribute("class","toast-icon "+classIcon);

    const message = document.createElement("div");
    message.setAttribute("class","toast-message");
    message.innerHTML = "Estamos realizando un mantenimiento a esta funcionalidad, trabajamos para que la tengas disponible próximamente. Valoramos tu comprensión.";

    const close = document.createElement("i");
    close.setAttribute("class","fa-solid fa-circle-xmark");
    close.addEventListener("click", () => {
        closeToast(close);
    });
    setTimeout(function () {
        closeToast(close);
    }, 3000)

    toast.appendChild(icon);
    toast.appendChild(message);
    toast.appendChild(close);

    listToast.appendChild(toast);
}

const closeToast = (e) =>{
    e.parentNode.remove();
}