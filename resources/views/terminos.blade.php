@extends('layouts.app')

@section('title', 'Términos y condiciones')

@section('content')

    <section class="text-center mb-12">
        <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-2">
            TÉRMINOS Y CONDICIONES DE USO
        </h2>
        <p class="text-lg text-gray-400">
            Última actualización: 02-nov-2025
        </p>
    </section>

    <section class="bg-gray-900 p-6 sm:p-10 rounded-xl shadow-2xl text-left">
        <p class="text-base text-gray-300 mb-8">
            VGStorm es una tienda en línea dedicada a la venta de videojuegos, consolas relacionados con el sector gaming, usted acepta estar sujeto a los presentes Términos y Condiciones.
        </p>
        
        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">1. Aceptación de los Términos</h3>
        <p class="text-gray-300 mb-6">
            Al registrarse, realizar una compra o navegar por el sitio, el Usuario declara que ha leído, entendido y aceptado estos Términos y Condiciones en su totalidad. Si no está de acuerdo con alguno de los puntos, debe abstenerse de utilizar los servicios ofrecidos por VGStorm.
        </p>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">2. Uso del Sitio Web</h3>
        <div class="space-y-4 mb-6">
            <p class="font-medium text-lg text-white">2.1 Cuenta del Usuario</p>
            <ul class="list-disc list-inside space-y-1 text-gray-300 ml-4">
                <li>El Usuario es responsable de mantener la confidencialidad de su contraseña y de todas las actividades que ocurran bajo su cuenta.</li>
                <li>El Usuario debe proporcionar información precisa y completa durante el proceso de registro y compra.</li>
                <li>La Empresa se reserva el derecho de suspender o cancelar cuentas que proporcionen información falsa o incumplan estos Términos.</li>
            </ul>

            <p class="font-medium text-lg text-white">2.2 Contenido y Conducta</p>
            <ul class="list-disc list-inside space-y-1 text-gray-300 ml-4">
                <li>El Usuario se compromete a no utilizar el sitio para fines ilícitos o que dañen la imagen de VGStorm o de terceros.</li>
                <li>Queda prohibida la publicación de contenido ofensivo, difamatorio, ilegal o que viole derechos de propiedad intelectual.</li>
            </ul>
        </div>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">3. Condiciones de Venta y Precios</h3>
        <div class="space-y-4 mb-6">
            <p class="font-medium text-lg text-white">3.1 Pedidos</p>
            <p class="text-gray-300 ml-4">La confirmación de un pedido no implica la aceptación de la venta hasta que VGStorm haya confirmado la disponibilidad del producto y el pago haya sido verificado.</p>

            <p class="font-medium text-lg text-white">3.2 Precios y Moneda</p>
            <p class="text-gray-300 ml-4">Todos los precios se muestran en Pesos Colombianos. En caso de error manifiesto en el precio, el pedido será cancelado.</p>

            <p class="font-medium text-lg text-white">3.3 Formas de Pago</p>
            <p class="text-gray-300 ml-4">Aceptamos pagos a través de Tarjetas de Crédito/Débito (Visa, Mastercard), PayPal.</p>
        </div>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">4. Envíos y Entregas</h3>
        <div class="space-y-4 mb-6">
            <p class="font-medium text-lg text-white">4.1 Tiempos de Entrega</p>
            <p class="text-gray-300 ml-4">Los tiempos de entrega son estimados y varían según la ubicación. El Usuario será notificado del número de seguimiento tan pronto como el pedido sea enviado. Plazo estimado: 5 a 10 días hábiles.</p>

            <p class="font-medium text-lg text-white">4.2 Riesgo de Pérdida</p>
            <p class="text-gray-300 ml-4">El riesgo de pérdida de los productos pasa al Usuario en el momento de la entrega por parte del transportista.</p>
        </div>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">5. Política de Devoluciones y Garantías</h3>
        <div class="space-y-4 mb-6">
            <p class="font-medium text-lg text-white">5.1 Devoluciones</p>
            <p class="text-gray-300 ml-4">Solo se aceptarán devoluciones de productos defectuosos o incorrectos, o en el caso de retracto dentro de los 15 días siguientes a la recepción, siempre y cuando el producto se encuentre en su empaque original y sin abrir (para videojuegos y consolas).</p>

            <p class="font-medium text-lg text-white">5.2 Garantía</p>
            <p class="text-gray-300 ml-4">La garantía aplicable a los productos de hardware como consolas, es la ofrecida por el fabricante. VGStorm actuará como intermediario para facilitar la gestión de la garantía, pero no es la responsable final.</p>
        </div>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">6. Propiedad Intelectual</h3>
        <p class="text-gray-300 mb-6">Todo el contenido del sitio web, incluyendo textos, gráficos, logotipos, imágenes de productos y software, es propiedad de VGStorm o de sus proveedores de contenido y está protegido por las leyes de propiedad intelectual. El uso no autorizado de dicho material está estrictamente prohibido.</p>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">7. Limitación de Responsabilidad</h3>
        <p class="text-gray-300 mb-6">VGStorm no será responsable de daños indirectos, incidentales, especiales o consecuentes que resulten del uso o la incapacidad de usar los productos o el sitio web, excepto en la medida requerida por la ley aplicable.</p>

        <h3 class="text-2xl font-semibold text-blue-400 mb-3 border-b border-gray-700 pb-1">8. Ley Aplicable y Jurisdicción</h3>
        <p class="text-gray-300 mb-8">Estos Términos y Condiciones se rigen e interpretan de acuerdo con las leyes de la República de Colombia. Cualquier disputa se someterá a la jurisdicción exclusiva de los tribunales de la Ciudad de Medellin.</p>

        <h3 class="text-xl font-semibold text-purple-400 mb-3">Contacto</h3>
        <p class="text-gray-300">
            Para cualquier pregunta o aclaración sobre estos Términos y Condiciones, por favor contáctenos a:
            <br>
            <span class="font-medium">Correo electrónico:</span> soporte@vgstorm.com
            <br>
            <span class="font-medium">Dirección:</span> Av. Gaming #101, Col. Digital, CP 21310, Medellin.
        </p>

    </section>

@endsection