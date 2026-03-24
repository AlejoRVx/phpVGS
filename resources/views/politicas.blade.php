@extends('layouts.app')

@section('title', 'Políticas de privacidad')

@section('content')

    <section class="text-center mb-12">
        <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-2">
            POLÍTICA DE PRIVACIDAD
        </h2>
        <p class="text-lg text-gray-400">
            Última actualización: 02-nov-2025
        </p>
    </section>

    <section class="bg-gray-900 p-6 sm:p-10 rounded-xl shadow-2xl text-left">
        <p class="text-base text-gray-300 mb-8">
            En VGStorm valoramos su privacidad y nos comprometemos a proteger la información personal que comparte con nosotros. Esta Política de Privacidad describe cómo recopilamos, utilizamos, divulgamos y protegemos su información en relación con el uso de nuestro sitio web y servicios.
        </p>
        
        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">1. Información que Recopilamos</h3>
        <p class="text-gray-300 mb-4">Recopilamos la siguiente información personal necesaria para la prestación de nuestros servicios:</p>
        
        <div class="space-y-4 mb-6">
            <p class="font-medium text-lg text-white">1.1 Información proporcionada por el Usuario</p>
            <ul class="list-disc list-inside space-y-1 text-gray-300 ml-4">
                <li>Datos de Registro: Nombre, dirección de correo electrónico, contraseña (encriptada).</li>
                <li>Datos de Compra: Nombre completo, productos, cantidad y precio</li>
                <li>Comunicaciones: Información contenida en correspondencia con nuestro servicio de atención al cliente.</li>
            </ul>

            <p class="font-medium text-lg text-white">1.2 Información de Uso y Seguimiento</p>
            <ul class="list-disc list-inside space-y-1 text-gray-300 ml-4">
                <li>Cookies: Utilizamos cookies y tecnologías similares para rastrear la actividad en nuestro servicio y mantener la sesión activa (ver Sección 4).</li>
            </ul>
        </div>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">2. Uso de la Información Recopilada</h3>
        <p class="text-gray-300 mb-4">Utilizamos su información personal para los siguientes fines:</p>
        <ul class="list-disc list-inside space-y-2 text-gray-300 ml-4 mb-6">
            <li>Procesar y gestionar sus pedidos, incluyendo el envío y la entrega.</li>
            <li>Administrar su cuenta de usuario y brindarle acceso a las funciones del sitio.</li>
            <li>Mejorar nuestros productos, servicios y la experiencia del usuario.</li>
            <li>Comunicarnos con usted sobre el estado de su pedido, promociones o información relevante del sitio (si ha consentido recibir marketing).</li>
            <li>Garantizar la seguridad de nuestra plataforma y prevenir el fraude.</li>
        </ul>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">3. Protección y Almacenamiento de Datos</h3>
        <p class="text-gray-300 mb-4">La seguridad de sus datos es nuestra prioridad:</p>
        <ul class="list-disc list-inside space-y-2 text-gray-300 ml-4 mb-6">
            <li>Implementamos medidas técnicas y organizativas para proteger su información contra el acceso no autorizado, la divulgación, la alteración o la destrucción.</li>
            <li>Las contraseñas se almacenan mediante cifrado (hashing).</li>
            <li>No almacenamos información completa de tarjetas de crédito; esto es manejado por nuestros procesadores de pago externos seguros.</li>
        </ul>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">4. Uso de Cookies</h3>
        <p class="text-gray-300 mb-4">Una cookie es un pequeño archivo de texto que se almacena en su dispositivo. Utilizamos cookies para:</p>
        <ul class="list-disc list-inside space-y-2 text-gray-300 ml-4 mb-6">
            <li>Mantener su sesión abierta ("Recuérdame").</li>
            <li>Recordar sus preferencias y configuraciones.</li>
            <li>Analizar el tráfico del sitio para mejorar el servicio.</li>
        </ul>
        <p class="text-gray-300 ml-4 mb-6">Usted tiene la opción de aceptar o rechazar las cookies modificando la configuración de su navegador. Sin embargo, si deshabilita las cookies, es posible que algunas partes del sitio no funcionen correctamente.</p>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">5. Derechos del Usuario (Derechos ARCO)</h3>
        <p class="text-gray-300 mb-4">Usted tiene derecho a:</p>
        <ul class="list-disc list-inside space-y-2 text-gray-300 ml-4 mb-8">
            <li>Acceso: Solicitar una copia de la información personal que tenemos sobre usted.</li>
            <li>Rectificación: Corregir cualquier dato inexacto o incompleto.</li>
            <li>Cancelación: Solicitar la eliminación de su información personal de nuestros registros.</li>
            <li>Oposición: Oponerse al procesamiento de sus datos personales.</li>
        </ul>

        <h3 class="text-xl font-semibold text-purple-400 mb-3">Contacto para Asuntos de Privacidad</h3>
        <p class="text-gray-300">
            Si tiene preguntas sobre esta Política de Privacidad o desea ejercer sus derechos como usuario, por favor contáctenos a:
            <br>
            <span class="font-medium">Responsable:</span> Departamento de Privacidad VGStorm
            <br>
            <span class="font-medium">Correo electrónico:</span> privacidad@vgstorm.com
            <br>
            <span class="font-medium">Dirección:</span> Av. Gaming #101, Col. Digital, CP 21310, Medellin.
        </p>

    </section>

@endsection