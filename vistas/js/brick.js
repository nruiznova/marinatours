const mp = new MercadoPago('APP_USR-ea1279d1-86c2-4a67-a31b-931cc05c1f6d', {
    locale: 'es-CO',
});
const bricksBuilder = mp.bricks();

const renderPaymentBrick = async (bricksBuilder) => {

    const montoStr = getCookieValue("pagoActual"); 
    let amount = parseFloat(montoStr);
    
    if (!amount || isNaN(amount) || amount < 1000) {
        console.log("El monto debe ser válido y mayor a $1.000 para procesar el pago.");
        return;
    }
    
    // ✅ Agregar el 5% al monto
    amount = amount * 1.05; // equivale a amount + (amount * 0.05)
    
    // ✅ Si lo necesitas con solo 2 decimales:
    amount = parseFloat(amount.toFixed(2));


    function normalizeCookie(value) {
        return value === undefined || value === "undefined" ? null : value;
    }

    const data = {
        id_habitacion: normalizeCookie(getCookieValue("idHabitacion")),
        id_usuario: normalizeCookie(getCookieValue("id_user")),
        pago_reserva: normalizeCookie(getCookieValue("pagoReserva")),
        numero_transaccion: null,
        codigo_reserva: normalizeCookie(getCookieValue("codigoReserva")),
        descripcion_reserva: normalizeCookie(getCookieValue("infoHabitacion")),
        fecha_ingreso: normalizeCookie(getCookieValue("fechaIngreso")),
        fecha_salida: normalizeCookie(getCookieValue("fechaSalida")),
        acompañantes: normalizeCookie(getCookieValue("acompañantes")),
        firstName: normalizeCookie(getCookieValue("firstName")),
        lastName: normalizeCookie(getCookieValue("lastName")),
        tipo_identificacion: normalizeCookie(getCookieValue("tipo_identificacion")),
        numero_identificacion: normalizeCookie(getCookieValue("numero_identificacion")),
        celular: normalizeCookie(getCookieValue("celular")),
        correo: normalizeCookie(getCookieValue("correo")),
        hospedaje: normalizeCookie(getCookieValue("hospedaje")),
        abono: normalizeCookie(getCookieValue("abono")),
        cuotas: normalizeCookie(getCookieValue("cuotas")),
        montoPagar: normalizeCookie(getCookieValue("pagoReserva")),
        valorCuotas: normalizeCookie(getCookieValue("valorCuotas")),
        pagoCuotas: normalizeCookie(getCookieValue("pagoCuotas")),
    };

    // console.log("montoPagar:", data.montoPagar);

    const res = await fetch("/api/crear_preferencia.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    });

    const result = await res.json();
    console.log("Respuesta:", result);

    const settings = {
        initialization: {
            /*
             "amount" es el monto total a pagar por todos los medios de pago con excepción de la Cuenta de Mercado Pago y Cuotas sin tarjeta de crédito, las cuales tienen su valor de procesamiento determinado en el backend a través del "preferenceId"
            */
            amount: amount,
            preferenceId: data.preference_id,
        },
        customization: {
            paymentMethods: {
                //   ticket: "all",
                //   bankTransfer: "all",
                creditCard: "all",
                prepaidCard: "all",
                debitCard: "all",
                mercadoPago: "all",
            },
        },
        callbacks: {
            onReady: () => {


            },
            onSubmit: ({
                selectedPaymentMethod,
                formData
            }) => {
                console.log("onSubmit llamado con método:", selectedPaymentMethod);
                // callback llamado al hacer clic en el botón enviar datos
                //   return new Promise((resolve, reject) => {
                //      fetch("/api/procesar_pago.php", {
                //       method: "POST",
                //       headers: {
                //          "Content-Type": "application/json",
                //       },
                //       body: JSON.stringify(formData),
                //      })
                //       .then((response) => response.json())
                //       .then((response) => {
                //          // recibir el resultado del pago
                //          resolve();
                //       })
                //       .catch((error) => {
                //          // manejar la respuesta de error al intentar crear el pago
                //          reject();
                //       });
                //   });
                formData.payer = {
                    address: {
                        street_name: document.getElementById("form-checkout__streetName")?.value.trim(),
                        street_number: document.getElementById("form-checkout__streetNumber")?.value.trim(),
                        neighborhood: document.getElementById("form-checkout__neighborhood")?.value.trim(),
                        city: document.getElementById("form-checkout__city")?.value.trim(),
                        zip_code: document.getElementById("form-checkout__zipCode")?.value.trim()
                        // federal_unit: document.getElementById("federalUnit")?.value.trim()
                    },
                    phone: {
                        area_code: document.getElementById("form-checkout__phoneAreaCode")?.value.trim(),
                        number: document.getElementById("form-checkout__phoneNumber")?.value.trim()
                    }
                };

                return new Promise((resolve, reject) => {
                    fetch("/api/procesar_pago.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(formData),
                        })
                        // .then((response) => response.json())
                        // .then((response) => {
                        //   // Si la respuesta contiene los datos necesarios, redirigir al Status Screen
                        //   if (
                        //     response.payment_id &&
                        //     response.status_detail &&
                        //     response.external_reference
                        //   ) {
                        //     const statusUrl = `https://www.mercadopago.com.co/checkout/v1/payment/status?payment_id=${response.payment_id}&status=${response.status_detail}&external_reference=${response.external_reference}`;
                        //     window.location.href = statusUrl;
                        //   } else {
                        //     // Si hay error pero sin datos suficientes para redirigir
                        //     alert(response.message || "Ocurrió un error inesperado.");
                        //     resolve(); // Terminar la promesa de todas formas
                        //   }
                        // })
                        // .catch((error) => {
                        //   alert("Error al conectar con el servidor. Intenta nuevamente.");
                        //   console.error(error);
                        //   reject(); // Error en la promesa
                        // });
                        .then((response) => response.json())
                        .then((response) => {
                            if (response.payment_id && response.status_detail && response.external_reference) {
                                // Obtiene el contenedor donde quieres mostrar el Status Screen
                                const statusContainer = document.getElementById('statusBrick_container');
                                const bricksBuilder = mp.bricks();

                                // bricksBuilder.create('statusScreen', statusContainer, {
                                //   initialization: {
                                //     paymentId: response.payment_id,
                                //     status: response.status_detail,
                                //     externalReference: response.external_reference
                                //   },
                                //   callbacks: {
                                //     onFinish: () => {
                                //       // Aquí puedes redirigir al usuario si quieres
                                //       window.location.href = '/index.php?pagina=exito';
                                //     }
                                //   }
                                // });
                                const renderStatusScreenBrick = async (bricksBuilder) => {

                                    // document.getElementById("statusScreenBrick_container").style.display = "block"; // por si estaba oculto
                                    console.log(response)

                                    const settings = {
                                        initialization: {
                                            paymentId: response.payment_id, // id de pago para mostrar
                                            status: response.status_detail,
                                            externalReference: response.external_reference
                                        },
                                        callbacks: {
                                            onReady: () => {
                                                /*
                                                  Callback llamado cuando Brick está listo.
                                                  Aquí puede ocultar cargamentos de su sitio, por ejemplo.
                                                */
                                                document.getElementById("paymentBrick_container").style.display = "none";
                                            },
                                            onError: (error) => {
                                                // callback llamado solicitada para todos los casos de error de Brick
                                                console.error(error);
                                            },
                                        },
                                        customization: {
                                            backUrls: {
                                                //   'error': 'https://marinatourscartagena.com.co/',
                                                'return': 'https://marinatourscartagena.com.co/'
                                            }
                                        }
                                    };
                                    window.statusScreenBrickController = await bricksBuilder.create(
                                        'statusScreen',
                                        'statusScreenBrick_container',
                                        settings,
                                    );
                                };
                                renderStatusScreenBrick(bricksBuilder);
                                resolve();

                            } else {
                                console.log(response)
                                alert(response.message || "Error al procesar el pago.");
                                resolve();
                            }
                        });
                });
            },
            onError: (error) => {
                // callback llamado para todos los casos de error de Brick
                console.error(error);
            },
        },
    };
    window.paymentBrickController = await bricksBuilder.create(
        "payment",
        "paymentBrick_container",
        settings
    );
};
renderPaymentBrick(bricksBuilder);

function getCookieValue(name) {
    const regex = new RegExp(`(^| )${name}=([^;]+)`);
    const match = document.cookie.match(regex);
    if (match) {
        return match[2];
    }
}