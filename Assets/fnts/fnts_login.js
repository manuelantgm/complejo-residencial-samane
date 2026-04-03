let divLoading = document.querySelector("#loader");
let Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
document.addEventListener('DOMContentLoaded', function(){

    if(document.querySelector("#formLogin")){
        let formLogin = document.querySelector("#formLogin");
        formLogin.onsubmit = function(e) {
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmail').value;
            let strPassword = document.querySelector('#loginPass').value;

            if(strEmail == "")
            {
                Toast.fire({
                    icon: 'question',
                    title: 'El nombre de usuario y/o email no es valido, asegurate de que sea el correcto.'
                });
                return false;
            }else if(strPassword == ""){
                Toast.fire({
                    icon: 'question',
                    title: 'La contraseña no es valida, asegurate de que sea la correcta.'
                });
                return false;
            }else{
                divLoading.style.display = "block";
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/loginUser'; 
                var formData = new FormData(formLogin);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState != 4) return;
                    if(request.status == 200){
                        var objData = JSON.parse(request.responseText);
                        if(objData.status)
                        {
                            //window.location = base_url+'/dashboard';
                            window.location.reload(false);
                        }else{
                            Swal.fire({
                              title: "Atención",
                              text: objData.msg,
                              icon: "error",
                              confirmButtonColor: "#31817e"
                            });
                            document.querySelector('#loginPass').value = "";
                        }
                    }else{
                        Swal.fire({
                              title: "Atención",
                              text: "Error en el proceso",
                              icon: "error",
                              confirmButtonColor: "#31817e"
                            });
                    }
                    divLoading.style.display = "none";
                    return false;
                }
            }
        }
    }

    if(document.querySelector("#formRecetPass")){       
        let formRecetPass = document.querySelector("#formRecetPass");
        formRecetPass.onsubmit = function(e) {
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmailReset').value;
            if(strEmail == "")
            {
                swal("Por favor", "Escribe tu correo electrónico.", "error");
                return false;
            }else{
                divLoading.style.display = "flex";
                var request = (window.XMLHttpRequest) ? 
                                new XMLHttpRequest() : 
                                new ActiveXObject('Microsoft.XMLHTTP');
                                
                var ajaxUrl = base_url+'/Login/resetPass'; 
                var formData = new FormData(formRecetPass);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState != 4) return;

                    if(request.status == 200){
                        var objData = JSON.parse(request.responseText);
                        if(objData.status)
                        {
                            swal({
                                title: "",
                                text: objData.msg,
                                type: "success",
                                confirmButtonText: "Aceptar",
                                closeOnConfirm: false,
                            }, function(isConfirm) {
                                if (isConfirm) {
                                    window.location = base_url;
                                }
                            });
                        }else{
                            swal("Atención", objData.msg, "error");
                        }
                    }else{
                        swal("Atención","Error en el proceso", "error");
                    }
                    divLoading.style.display = "none";
                    return false;
                }   
            }
        }
    }

    if(document.querySelector("#formCambiarPass")){
        let formCambiarPass = document.querySelector("#formCambiarPass");
        formCambiarPass.onsubmit = function(e) {
            e.preventDefault();

            let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
            let idUsuario = document.querySelector('#idUsuario').value;

            if(strPassword == "" || strPasswordConfirm == ""){
                swal("Por favor", "Escribe la nueva contraseña." , "error");
                return false;
            }else{
                if(strPassword.length < 5 ){
                    swal("Atención", "La contraseña debe tener un mínimo de 5 caracteres." , "info");
                    return false;
                }
                if(strPassword != strPasswordConfirm){
                    swal("Atención", "Las contraseñas no son iguales." , "error");
                    return false;
                }
                loading.style.display = "flex";
                var request = (window.XMLHttpRequest) ? 
                            new XMLHttpRequest() : 
                            new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/setPassword'; 
                var formData = new FormData(formCambiarPass);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState != 4) return;
                    if(request.status == 200){
                        var objData = JSON.parse(request.responseText);
                        if(objData.status)
                        {
                            swal({
                                title: "",
                                text: objData.msg,
                                type: "success",
                                confirmButtonText: "Iniciar sessión",
                                closeOnConfirm: false,
                            }, function(isConfirm) {
                                if (isConfirm) {
                                    window.location = base_url+'/login';
                                }
                            });
                        }else{
                            swal("Atención",objData.msg, "error");
                        }
                    }else{
                        swal("Atención","Error en el proceso", "error");
                    }
                    divLoading.style.display = "none";
                }
            }
        }
    }

}, false);

if(document.querySelector("#btnFacebook")){
   let btnFacebook =  document.querySelector("#btnFacebook");
   btnFacebook.onclick = function(e){
        toastWarning();
   }
}

if(document.querySelector("#btnGoogle")){
   let btnGoogle =  document.querySelector("#btnGoogle");
   btnGoogle.onclick = function(e){
        toastWarning();
   }
}

if(document.querySelector("#btnInstagram")){
   let btnInstagram =  document.querySelector("#btnInstagram");
   btnInstagram.onclick = function(e){
        toastWarning();
   }
}

/*===== FOCUS =====*/
const inputs = document.querySelectorAll(".form__input");

/*=== Add focus ===*/
function addfocus(){
    let parent = this.parentNode.parentNode
    parent.classList.add("focus")
}

/*=== Remove focus ===*/
function remfocus(){
    let parent = this.parentNode.parentNode
    if(this.value == ""){
        parent.classList.remove("focus")
    }
}

/*=== To call function===*/
inputs.forEach(input=>{
    input.addEventListener("focus",addfocus)
    input.addEventListener("blur",remfocus)
})


const showHiddenPass = (loginPass, loginEye) =>{
    const input = document.getElementById(loginPass),
         iconEye = document.getElementById(loginEye)

   iconEye.addEventListener('click', () =>{
      // Change password to text
      if(input.type === 'password'){
         // Switch to text
         input.type = 'text'

         // Icon change
         iconEye.classList.add('fa-eye')
         iconEye.classList.remove('fa-eye-slash')
      } else{
         // Change to password
         input.type = 'password'

         // Icon change
         iconEye.classList.remove('fa-eye')
         iconEye.classList.add('fa-eye-slash')
      }
      // Focus
      input.focus();
   });
}

showHiddenPass('loginPass','login-eye');
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