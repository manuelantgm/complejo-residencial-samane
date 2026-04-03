$(function () {
    // Summernote
    $('#summernote').summernote();
});
document.addEventListener('DOMContentLoaded', function(){
	//Send message
    if(document.querySelector("#formWhatsAppDifussion")){
        let formWhatsAppDifussion = document.querySelector("#formWhatsAppDifussion");
        formWhatsAppDifussion.onsubmit = function(e) {
            e.preventDefault();
            
            let strDifussion = document.querySelector('#summernote').value;
            

            if(strDifussion == '' )
            {
                $('#modalFormWhatsAppDifusion').modal("hide");
                Swal.fire({
                    title: "MENSAJE VACIO",
                    text: "El mensaje no puede ir vacio.",
                    icon: "info",
                    confirmButtonColor: "#3d9970",
                    confirmButtonText: "<i class='fa-regular fa-circle-check'></i> Ok",
                }).then((result) => {
                    
                    if (result.isConfirmed) 
                    {
                        $('#modalFormWhatsAppDifusion').modal("show");
                    }

                });
                return false;
            }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Whatsappdiffusion/diffusion'; 
            let formData = new FormData(formWhatsAppDifussion);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {

                        formWhatsAppDifussion.reset();
                        $('#modalFormWhatsAppDifusion').modal("hide");

                        Swal.fire({
                            title: objData.title,
                            text: objData.msg,
                            icon: objData.icon,
                            confirmButtonColor: "#3d9970",
                            confirmButtonText: "<i class='fa-regular fa-circle-check'></i> Ok",
                        }).then((result) => {
                            
                            if (result.isConfirmed) 
                            {
                                //$('#modalFormWhatsAppDifusion').modal("show");
                            }

                        });
                    }else{
                        $('#modalFormWhatsAppDifusion').modal("hide");
                        Swal.fire({
                            title: objData.title,
                            text: objData.msg,
                            icon: objData.icon,
                            confirmButtonColor: "#3d9970",
                            confirmButtonText: "<i class='fa-regular fa-circle-check'></i> Ok",
                        }).then((result) => {
                            
                            if (result.isConfirmed) 
                            {
                                //$('#modalFormWhatsAppDifusion').modal("show");
                            }

                        });
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
}, false);

function controlTag(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; 
    else if (tecla==0||tecla==9)  return true;
    patron =/[0-9\s]/;
    n = String.fromCharCode(tecla);
    return patron.test(n); 
}

function testText(txtString){
    var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);
    if(stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}

function testEntero(intCant){
    var intCantidad = new RegExp(/^([0-9])*$/);
    if(intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}

function fntEmailValidate(email){
    var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})$/);
    if (stringEmail.test(email) == false){
        return false;
    }else{
        return true;
    }
}

function fntValidText(){
	let validText = document.querySelectorAll(".validText");
    validText.forEach(function(validText) {
        validText.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testText(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}				
		});
	});
}

function fntValidNumber(){
	let validNumber = document.querySelectorAll(".validNumber");
    validNumber.forEach(function(validNumber) {
        validNumber.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testEntero(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}				
		});
	});
}

function fntValidEmail(){
	let validEmail = document.querySelectorAll(".validEmail");
    validEmail.forEach(function(validEmail) {
        validEmail.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!fntEmailValidate(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}				
		});
	});
}

function formatPhoneJS(telefono){
    telefono = telefono.replace(/\D/g, ''); // limpiar caracteres no numéricos

    if(telefono.length === 11 && telefono.startsWith("1")){
        let codigo = telefono.substring(1,4);
        let parte1 = telefono.substring(4,7);
        let parte2 = telefono.substring(7,11);
        return "(" + codigo + ") " + parte1 + "-" + parte2;
    }

    if(telefono.length === 10){
        let codigo = telefono.substring(0,3);
        let parte1 = telefono.substring(3,6);
        let parte2 = telefono.substring(6,10);
        return "(" + codigo + ") " + parte1 + "-" + parte2;
    }

    return telefono;
}


function VentanaCentrada(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
  window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
}

window.addEventListener('load', function() {
	fntValidText();
	fntValidEmail(); 
	fntValidNumber();
}, false);