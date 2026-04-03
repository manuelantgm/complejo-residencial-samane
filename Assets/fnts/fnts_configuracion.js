$(function () {
  bsCustomFileInput.init();

  // function to display image before upload
  $("input.image").change(function() {
    var file = this.files[0];
    var url = URL.createObjectURL(file);
    $(this).closest(".row").find(".preview_img").attr("src", url);
  });
});
let Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
  if(document.querySelector("#formConfiguration")){
        let formConfiguration = document.querySelector("#formConfiguration");
        formConfiguration.onsubmit = function(e) {
            e.preventDefault();
            let srtNombreEmpresa = document.querySelector('#txtNomEmp').value;
            let strDireccionEmpresa = document.querySelector('#txtDireccion').value;
            let strTelEmpresa = document.querySelector('#txtTel').value;
            
            if(srtNombreEmpresa == '' || strDireccionEmpresa == '' || strTelEmpresa == '')
            {
                Swal.fire({
                  title: "Atención!",
                  text: "Los campos con (*) son obligatorios.",
                  icon: "info"
                });
                return false;
            }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Configuracion/setConfig'; 
            let formData = new FormData(formConfiguration);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                      console.log(objData);
                        Toast.fire({
                          icon: objData.icon,
                          title: objData.title,
                          text: objData.msg
                        });
                    }else{
                        Swal.fire({
                          title: objData.title,
                          text: objData.msg,
                          icon: objData.icon
                        });
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
}, false);

window.addEventListener('load', function() {

}, false);