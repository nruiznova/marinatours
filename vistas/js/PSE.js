document.getElementById("formPSE").addEventListener("submit", async function(e) {
  e.preventDefault(); // evita recarga de página
          
  let loader = document.getElementById("loader");
  loader.style.display = "flex"; // mostrar loader

  let formData = new FormData(this);

  try {
    let response = await fetch("https://marinatourscartagena.com.co/controladores/procesar_pse.php", {
      method: "POST",
      body: formData
    });

    let data = await response.json();
    loader.style.display = "none"; // ocultar loader
    if(data.returnCode == 'SUCCESS'){
      window.location.href = data.pseURL;
    } else {
      let text = data.errorDetails;
      if(data.returnCode == 'FAIL_EXCEEDEDLIMIT'){
        text = 'El monto ingresado en la transacción excede los límites establecidos para la reserva, por favor modifica la información e intenta de nuevo.'
      }
      if(data.returnCode == 'FAIL_SERVICENOTEXISTSORNOTCONFIGURED'){
        text = 'El servicio enviado con la transacción no existe o no se encuentra configurado';
      }
      swal.fire({
        icon:"error",
        title:"No se pudo procesar el pago",
        text,
        showConfirmButton: true,
        confirmButtonText: "Cerrar"	
      });
    }

  } catch (err) {
    loader.style.display = "none";
    swal.fire({
      icon:"error",
      title: "Error!",
      text: err,
      showConfirmButton: true,
      confirmButtonText: "Cerrar"	
    });
  }
});