const lang = localStorage.getItem('language');

$(document).ready(function() {
    if (lang != null) {
        showTraslate(lang);
    } else {
        showTraslate('ES');
    }
})

function showTraslate(id) {
    $('.idioma').text(id);
    $('.lang').each(function(index, element) {
        $(this).text(arrLang[id][$(this).attr('key')]);
    })
    $('.tool').each(function(index,element) {
        $(this).attr('data-tooltip',arrLang[id][$(this).attr('key')])
    })
}

function showEs() {
    showTraslate('ES');
    localStorage.setItem('language', 'ES');
}

function showEn() {
    showTraslate('EN');
    localStorage.setItem('language', 'EN');
}

function showEs2() {
    showTraslate('ES');
    localStorage.setItem('language', 'ES');
    destroyTable('tblFacturas');
    initTable2('tblFacturas');
}

function showEn2() {
    showTraslate('EN');
    localStorage.setItem('language', 'EN');
    destroyTable('tblFacturas');
    initTable2('tblFacturas');
}

var arrLang = {
    'ES': {
        'inicio': 'Inicio',
        'quienes': '¿Quiénes Somos?',
        'contactenos': 'Contáctanos',
        'inicioPT': 'Party Town | Inicio',
        'quienesPT': 'Party Town | ¿Quiénes Somos?',
        'contactenosPT': 'Party Town | Contáctenos',
        'preguntasPT': 'Party Town | Preguntas frecuentes',
        'formularioPT': 'Party Town | Formularios',
        'carritoPT': 'Party Town | Carrito de venta',
        'ventasPT': 'Party Town | Mis ventas',
        'datosPT': 'Party Town | Datos personales',
        'recuperar': 'Recuperar contraseña',
        'verificar': 'Verificar',
        'recCuenta': 'Recuperar cuenta',
        'restContra': 'Restablecer contraseña',
        'historia': 'Historia',
        'siguenos': 'Síguenos',
        'otros': 'Otros',
        'tel': 'Teléfono:',
        'correo': 'Correo Electrónico:',
        'preguntas': 'Preguntas frecuentes',
        'IS&R': 'Iniciar Sesión y Registrarse',
        'mapa': 'Mapa del Sitio',
        'derecho': 'Derecho de Autor',
        'mision': 'Misión',
        'vision': 'Visión',
        'acceder': 'Acceder',
        'iniciar': 'INICIAR SESIÓN',
        'crear': 'CREAR CUENTA',
        'nombres': "Nombres:",
        'apellidos': 'Apellidos:',
        'genero': 'Género:',
        'fecha': 'Fecha de nacimiento:',
        'contra': 'Contraseña:',
        'conf': 'Confirmar contraseña:',
        'codigo': 'Código de verificación:',
        'olvidado': '¿Haz olvidado tu contraseña?',
        'env': 'Se te ha enviado un código al correo',
        'des': 'la cual te servirá para desbloquear tu cuenta.',
        'masculino': 'Masculino',
        'femenino': 'Femenino',
        'seleccione': 'Seleccione su género',
        'pt': 'La mejor tienda en línea',
        'ver': 'Ver más',
        'descr': 'Descripción:',
        'precio': 'Precio USD($):',
        'cantidad': 'Cantidad:',
        'subtotal': 'Total parcial USD($):',
        'totalPagar': 'Total a Pagar',
        'detalle': 'Detalle de producto',
        'buscador': 'Buscador',
        'leido': 'He leído y acepto los',
        'term': 'Términos y condiciones de uso',
        'cerrar': 'Cerrar sesión',
        'carrito': 'Carrito de compras',
        'pagar': 'Pagar',
        'factu': 'Facturación',
        'ventas': 'Mis ventas',
        'datos': 'Datos personales',
        'f&h': 'FECHA Y HORA',
        'dire': 'DIRECCIÓN',
        'estado': 'ESTADO',
        'acciones': 'ACCIONES',
        'detfac': 'Detalle factura',
        'prod': 'PRODUCTO',
        'cant': 'CANTIDAD',
        'sub': 'TOTAL PARCIAL',
        'topa': 'Total a Pagar:',
        'envios': 'ENVÍOS',
        'impuestos': 'IMPUESTOS',
        'gastos': 'GASTOS DE ENVÍOS',
        'formas': 'FORMAS DE PAGO',
        'garantia': 'GARANTÍA',
        'contacto': 'CONTACTO',
        'acepto': 'Acepto',
        'cambio': 'Cambiar contraseña',
        'contraActual': 'Contraseña actual',
        'contraNueva': 'Contraseña nueva',
        'quienDescr': 'Party Town facilita al cliente la organización de una fiesta, pues todo lo que el cliente podría buscar, se encuentra en un mismo sitio.Dicha empresa se enfoca en los artículos no comestibles para una fiesta.Party Town es una empresa comercial que compra y distribuye productos de terceros, sin manufacturar productos propios.El objetivo de Party Town es tener una presencia en los alrededores de la primera central de compras, identificar situaciones a mejorar, reconocer patrones en las demografías de los clientes y recibir retroalimentación por parte de los visitantes, personal e inversores. ',
        'missionDetail': 'Ser la mayor cadena de distribuidoras especializadas en suplementos para fiestas, reuniones y eventos especiales en El Salvador;proporcionando alta satisfacción, confianza y experiencia a nuestros clientes mediante el uso de artículos de la mejor calidad, servicios exclusivos y una atención primaria hacia el consumidor.',
        'visionDetail': 'Ser la mayor cadena de distribuidoras especializadas en suplementos para fiestas, reuniones y eventos especiales en El Salvador;proporcionando alta satisfacción, confianza y experiencia a nuestros clientes mediante el uso de artículos de la mejor calidad, servicios exclusivos y una atención primaria hacia el consumidor.',
        'footer': 'Party Town como empresa busca hacer la vida del consumidor más fácil, al reunir en un sólo lugar todos los elementos que podrían considerarse como esenciales y/o básicos en una fiesta. Ofreciendo todo en un mismo local, poniendo énfasis en una calidad consistentemente alta y precios razonablemente accesibles;para poder ofrecer al cliente una experiencia agradable, ligera y sin quitar el enfoque de su mente en una fiesta para recordar.',
        'historiaDet': 'Party Town es fundada en el año de 2019, por dos jóvenes emprededores que quieren facilitar la compra de articulos necesarios para realizar una fiestas tantos empresariales, juveniles, infantiles, boda, graduacion, entre otros eventos. Ofreciendo todo en un mismo local, poniendo énfasis en una calidad consistentemente alta y precios razonablemente accesibles;para poder ofrecer al cliente una experiencia agradable, ligera y sin quitar el enfoque de su mente en una fiesta para recordar. Party Town siempre está ubicada en Av.Las Magnolias, San Salvador, cerca del Hotel Barceló.',
        'firstp': 'A través de la tienda de Party Town podrá adquirir productos para organizar fiestas o eventos.',
        'e1': 'Enviamos los pedidos a cualquier lugar de El Salvador, se aplicará un costo adicional.',
        'e2': 'La entrega se realizará en un plazo de aproximado 5 días laborales, para los envíos por mensajería. Si en caso no le llega en ese plazo de tiempo, por favor contactarsé con PartyTown en cualquier medio que está en la página de Contáctenos, también solo tiene 1 días hábil después de hecho la compra para cancelar su pedido, si no lo cancela se toma que quiere el producto y se rige a nuestra normas.',
        'i1': 'Todos los artículos que aparecen en la Tienda Party Town, incluyen el IVA correspondient en El Salvador.',
        'f1': 'El pago del producto en la tienda online se hará con las tarjetas VISA y MASTERCARD. El número de su tarjeta se enviará a través de un sistema bancario de alta seguridad para comprobar su validez y hacer el cobro. Sólo guardaremos los datos de la tarjeta hasta que hayamos gestionado su pedido.',
        'g1': 'Los precios citados no incluyen los gastos de envío dentro de territorio nacional. Así que se le aumentará al precio los gastos del envío, lo cual el aumento varía depende al lugar donde se dejará la venta.Este es un importe adicional que no está contemplado en el total que se indicará en el detalle de pedido.',
        'g2': 'Dispone de un plazo de 3 días hábiles para devolver los productos una vez recibidos. Cambiaremos el artículo o, si lo prefiere, le devolveremos el dinero, con talón o mediante ingreso en cuenta bancaria, solo sí se demustra que el producto venía con defectos de fábrica.',
        'c1': 'Si desea alguna información adicional, puede ponerse en contacto con nosotros a través de los números 7892-1343 y 7892-1232 o al correo electrónico gerencia@partytown.com',
        'comentario': 'Comentario',
        'valoracion': 'Valoración',
        'cliente': 'Cliente:',
        'registrar': 'Registrar',
        'btnIS': 'Acceder',
        'guardar': 'Guardar',
        'cancelar': 'Cancelar',
        'facturar': 'Facturar',
        'dir': 'Dirección:',
        'realizar': 'Realizar factura',
        'pregEnv': 'Pregunta sobre envío',
        'pregInc': 'Pregunta sobre incidencia',
        'pregProy': 'Pregunta sobre el proyecto',
        'pregProd': 'Pregunta sobre el producto',
        'q1': '¿Cuántas cuesta el envío?',
        'q2': '¿Cuánto se tardaría el envio?',
        'q3': 'Cuentan con una atención al cliente',
        'q4': '¿Se permiten devoluciones?',
        'q5': '¿Cómo puedo contactar con Party Town?',
        'q6': '¿Qué hago si me llega el producto dañado durante el transporte?',
        'q7': '¿Quién está detrás de la página?',
        'q8': '¿Cómo surgió la idea?',
        'q9': '¿El producto es de buena calidad?',
        'q10': '¿El producto es auténtico?',
        'pq1': 'Dependiendo al lugar donde se irá a dejar sería el costo adicional, solamente a nivel de la zona metropolitana de San Salvador no se le agregaría el costo.',
        'pq2': 'El envio se tardaria de 2 a 3 dás hábiles, depende la demanda diaria de pedidos que tenemos puede ser que se tarde hasta 5 días. Ya pasado los 5 días y no ha recibido su pedido, por favor comunicarse con Party Town.',
        'pq3': 'Si, Party Town cuenta con un atención al cliente en la cual pueden hacer llegar un reclamo o queja sobre nuestros servicios.',
        'pq4': 'Se permitirán devoluciones siempre y cuando el porducto este dañado de fabrica o durante el traslado, pero si el producto esta en promoción no se permitirá devolución.',        
        'pq5': 'Nos puede contactar por medio de Facebook, Twitter, Instagram, además por llamada teléfonica a los números: 7892-1232 y 7892-1343, y al correo electronico gerencia@gmail.com.',
        'pq6': 'Puede al instante avisarle al repartidor, para que notifique y se le haga la devolución de su dinero o esperar el reenvío del producto',
        'pq7': 'Los fundadores de Party Town, dos jóvenes que se pueden a pensar que no existe un lugar donde no se puede comprar en línea todo los necesario para organizar una fiesta.',
        'pq8': 'Viendo lo díficil y tardado que es organizar una fiesta, decidimos poner una tienda en linea para facilitarle al organizador, la compra de utensilios para el eventos y así ya no ir de tienda en tienda buscando sus articulos, sino que a la puerta de su casa los recibirá.',
        'pq9': 'Claro que sí, nuestro producto son de la mejor calidad para que no tenga problemas a la hora de su evento o fiesta.',
        'pq10': 'Todos los productos son auténticos, ningún productos es una copia.',
        'volverInicio': 'Volver al Inicio',
        'buscar': 'Buscar',
        'modificar': 'Modificar',
        'camb': 'Cambio de contraseña',
    },
    'EN': {
        'inicio': 'Home',
        'quienes': 'About us',
        'contactenos': 'Contact us',
        'inicioPT': 'Party Town | Home',
        'quienesPT': 'Party Town | About us',
        'contactenosPT': 'Party Town | Contact us',
        'preguntasPT': 'Party Town | Fequently asked questions',
        'formularioPT': 'Party Town | Forms',
        'carritoPT': 'Party Town | Shopping cart',
        'ventasPT': 'Party Town | My sales',
        'datosPT': 'Party Town | Personal information',
        'recuperar': 'Recover password',
        'recCuenta': 'Recover account',
        'restContra': 'Reset password',
        'verificar': 'Check',
        'historia': 'History',
        'siguenos': 'Follow us',
        'otros': 'Others',
        'tel': 'Telephone:',
        'correo': 'Email:',
        'preguntas': 'Fequently asked questions',
        'IS&R': 'Login and Register',
        'mapa': 'Site map',
        'derecho': 'Copyright',
        'mision': 'Mission',
        'vision': 'Vision',
        'factu': 'Billing',
        'acceder': 'To Access',
        'iniciar': 'LOGIN',
        'crear': 'REGISTER',
        'nombres': 'Names:',
        'apellidos': 'Surnames:',
        'fecha': 'Date of birth:',
        'contra': 'Password:',
        'conf': 'Confirm Password:',
        'codigo': 'Verification code:',
        'genero': 'Gender:',
        'env': 'You have been sent to be the code to mail',
        'des': 'which will serve you to unlock your account.',
        'olvidado': 'Have you forgotten your password?',
        'masculino': 'Male',
        'femenino': 'Female',
        'seleccione': 'Select your gender',
        'pt': 'The best online store',
        'ver': 'See more',
        'descr': 'Description:',
        'precio': 'Price USD($)',
        'cantidad': 'Quantity:',
        'subtotal': 'Subtotal USD($):',
        'totalPagar': 'Total to Pay',
        'detalle': 'Product detail',
        'buscador': 'Searcher',
        'leido': 'I have read and accept the',
        'term': 'Terms and conditions of use',
        'cerrar': 'Sign off',
        'carrito': 'Shopping cart',
        'pagar': 'To pay',
        'ventas': 'My sales',
        'datos': 'Personal information',
        'f&h': 'DATE AND TIME',
        'dire': 'ADDRESS',
        'estado': 'STATUS',
        'acciones': 'ACTIONS',
        'detfac': 'Invoice detail',
        'prod': 'PRODUCT',
        'cant': 'QUANTITY',
        'sub': 'SUBTOTAL',
        'envios': 'SHIPPING',
        'impuestos': 'TAXES',
        'formas': 'PAYMENT METHODS',
        'gastos': 'SHIPPING COST',
        'garantia': 'WARRANTY',
        'contacto': 'CONTACT',
        'acepto': 'I agree',
        'topa': 'Total to pay:',
        'cambio': 'Change password',
        'contraActual': 'Current password',
        'contraNueva': 'New password',
        'quienDescr': 'Party Town eases the shopping experience of the customer, since we offer everything he/she would ever want, under one roof. Said bussiness its focused on the non-edible items for a party. Party Town is a comercial venture that buys and distributes items from third party manufacturers, without manufacturing its own products. The goal of PT is to have a solid presence around the first distributing central, identify situations that need improvement, recognize demographic patterns of the clients and receive feedback on behalf of the visitors and investors.',
        'missionDetail': 'Be the biggest chain of specialized distributors of supplies for parties, meetings and special events in El Salvador; providing a high degree of satisfaction, trust and experience to our clients through the use of items of the best quality, exclusive services and a premium customer service.',
        'visionDetail': 'Be at the year 2024 a leading corporation in the market of specialized distributing stores in El Salvador, with a significant amount of franchises all over the country.',
        'footer': 'Party Town as a bussiness seeks to make the life of the customer easier, gathering in one single place every item that may considered essential (or not so essential) or basic in a party. Offering everything under one roof, making emphasis in consistently high quality and prices reasonably affordable; all to offer the client a nice, lightweight experience without deviating from the focus on their mind of having a great, memorable party.',
        'historiaDet': 'Party Town was founded in 2019, by two young entrepeneurs that wanted to facilitate the obtaining of necessary supplies for bussiness, juveniles, children\'s, weddings, graduations and more celebrations. Offering everything inside the same building, making emphasis in a consistently high quality and affordable prices; giving to the client a nice, swift experience and not making them lose the focus on having a celebration to remember. Party is always located on Av. Las Magnolias, near the Barceló Hotel.',
        'firstp': 'Through the Party Town store you can purchase products to organize parties or events.',
        'e1': 'We ship orders anywhere in El Salvador, an additional cost will apply.',
        'e2': 'Delivery will be made within approximately 5 business days, for courier shipments. If in case it does not arrive in that period of time, please contact PartyTown in any means that is on the Contact Us page, you also only have 1 business days after the purchase to cancel your order, if you do not cancel it, it is taken Who wants the product and is governed by our standards.',
        'i1': 'All items that appear in the Party Town Store, include the corresponding IVA at El Salvador.',
        'f1': 'The payment of the product in the online store will be made with VISA and MASTERCARD cards. Your card number will be sent through a high security banking system to verify its validity and make the payment. We will only save the card details until we have managed your order.',
        'g1': 'The prices quoted do not include shipping costs within national territory. So the shipping costs will be increased to the price, which the increase varies depending on where the sale will be left. This is an additional amount that is not included in the total that will be indicated in the order detail.',
        'g2': 'You have a period of 3 business days to return the products once received. We will change the item or, if you prefer, we will refund your money, with a check or by bank account deposit, only if it is proven that the product came with factory defects.',
        'c1': 'If you would like additional information, you can contact us through the numbers 7892-1343 and 7892-1232 or email to gerencia@partytown.com',
        'comentario': 'Comments',
        'valoracion': 'Assessment',
        'cliente': 'Customer:',
        'registrar': 'To register',
        'btnIS': 'To access',
        'guardar': 'Save',
        'cancelar': 'Cancel',
        'facturar': 'Bill',
        'dir': 'Address:',
        'realizar': 'Make invoice',
        'pregEnv': 'Shipping Question',
        'pregInc': 'Issue Question',
        'pregProy': 'Question about the project',
        'pregProd': 'Question about the product',
        'q1': 'How many does shipping cost?',
        'q2': 'How long would the shipment take?',
        'q3': 'They have a customer service',
        'q4': 'Are returns allowed?',
        'q5': 'How can I contact Party Town?',
        'q6': 'What do I do if the product damaged during transport arrives?',
        'q7': 'Who is behind the page?',
        'q8': 'How did the idea come about?',
        'q9': 'Is the product of good quality?',
        'q10': 'Is the product authentic?',
        'pq1': 'Depending on the place where it will be left would be the additional cost, only at the level of the metropolitan area of ​​San Salvador the cost would not be added.',
        'pq2': 'The shipment would take 2 to 3 business days, it depends on the daily demand for orders that we have, it may take up to 5 days. After 5 days and you have not received your order, please contact Party Town.',
        'pq3': 'Yes, Party Town has a customer service where they can make a complaint or complaint about our services.',
        'pq4': 'Returns will be allowed as long as the product is damaged at the factory or during the transfer, but if the product is in promotion, no return will be allowed.',        
        'pq5': 'You can contact us through Facebook, Twitter, Instagram, also by phone call to the numbers: 7892-1232 and 7892-1343, and to the email gerencia@gmail.com.',
        'pq6': 'You can instantly notify the delivery man, so that he can notify you and have your money returned or wait for the product to be resent',
        'pq7': 'The founders of Party Town, two young people who may think that there is no place where you cannot buy everything you need to organize a party online.',
        'pq8': 'Seeing how difficult and delayed it is to organize a party, we decided to put an online store to facilitate the organizer, the purchase of utensils for the events and thus no longer go from store to store looking for their items, but to the door of his house You will receive them.',
        'pq9': 'Of course, our product is of the best quality so you do not have problems at the time of your event or party.',
        'pq10': 'All products are authentic, no products is a copy.',
        'volverInicio': 'Back to',
        'buscar': 'Search',
        'modificar': 'Modify',
        'camb': 'Change of password',
    }
}