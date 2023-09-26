<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panfleto del Evento: {{ $event['name_event'] }}</title>
    <!-- Agregar enlaces a los estilos de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-semibold mb-4">{{ $event['name_event'] }}</h1>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2">
                    <p class="text-lg"><strong>Tipo de Evento:</strong> {{ $event['type_event'] }}</p>
                    <p class="text-lg"><strong>Fecha de Registro:</strong> {{ $event['date_register'] }}</p>
                    <p class="text-lg"><strong>Fecha de Inicio:</strong> {{ $event['date_start'] }}</p>
                    <p class="text-lg"><strong>Fecha de Fin:</strong> {{ $event['date_end'] }}</p>
                    <p class="text-lg"><strong>Hora de Inicio:</strong> {{ $event['hour_start'] }}</p>
                    <p class="text-lg"><strong>Hora de Fin:</strong> {{ $event['hour_end'] }}</p>
                </div>
                <div class="w-full md:w-1/2">
                    <p class="text-lg"><strong>Fecha de Inicio de Registro:</strong> {{ $event['register_start_date'] }}
                    </p>
                    <p class="text-lg"><strong>Fecha de Fin de Registro:</strong> {{ $event['register_end_date'] }}</p>
                    <p class="text-lg"><strong>Evento organizado por:</strong> {{ $event['event_host'] }}</p>
                    <p class="text-lg"><strong>Email de contacto:</strong> {{ $event['email'] }}</p>
                    <p class="text-lg"><strong>Telefono de contacto:</strong> {{ $event['phone_number'] }}</p>
                </div>
            </div>
            <div class="mt-8">
                <h2 class="text-2xl font-semibold">Descripción del Evento</h2>
                <p class="mt-2 text-gray-700">
                    {{ $event['description_event'] }}
                </p>
            </div>
        </div>
    </div>
    <!-- Imagen -->
    <div class="container mx-auto mt-4">
        <img src="data:image/png;base64, {{ $event['thumbnail'] }}" alt="Miniatura del evento" class="max-w-full h-auto">
    </div>

</body>

</html>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panfleto del Evento: {{ $event['name_event'] }}</title>
</head>
<body>
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-semibold mb-4">{{ $event['name_event'] }}</h1>
            <p class="text-lg"><strong>Tipo de Evento:</strong> {{ $event['type_event'] }}</p>
            <p class="text-lg"><strong>Fecha de Registro:</strong> {{ $event['date_register'] }}</p>
            <p class="text-lg"><strong>Fecha de Inicio:</strong> {{ $event['date_start'] }}</p>
            <p class="text-lg"><strong>Fecha de Fin:</strong> {{ $event['date_end'] }}</p>
            <p class="text-lg"><strong>Hora de Inicio:</strong> {{ $event['hour_start'] }}</p>
            <p class="text-lg"><strong>Hora de Fin:</strong> {{ $event['hour_end'] }}</p>
            <p class="text-lg"><strong>Fecha de Inicio de Registro:</strong> {{ $event['register_start_date'] }}</p>
            <p class="text-lg"><strong>Fecha de Fin de Registro:</strong> {{ $event['register_end_date'] }}</p>
            <p class="text-lg"><strong>Sede:</strong> {{ $event['sede_id'] }}</p>
            <p class="text-lg"><strong>A quien va dirigido:</strong> {{ $event['aquien_va_dirigido'] }}</p>
            <p class="text-lg"><strong>Director CT:</strong> {{ $event['director_CT_only'] }}</p>
            <p class="text-lg"><strong>Area Administrativa:</strong> {{ $event['administrative_area_only'] }}</p>
            <p class="text-lg"><strong>Area Administrativa:</strong> {{ $event['administrative_area_participants_id'] }}</p>
            <p class="text-lg"><strong>Centro de trabajo:</strong> {{ $event['workplace_center_participants_id'] }}</p>
            <p class="text-lg"><strong>Evento Host:</strong> {{ $event['event_host'] }}</p>
            <p class="text-lg"><strong>Email:</strong> {{ $event['email'] }}</p>
            <p class="text-lg"><strong>Telefono:</strong> {{ $event['phone_number'] }}</p>
            <p class="text-lg"><strong>Visible Data Host:</strong> {{ $event['visible_data_host'] }}</p>
            <p class="text-lg"><strong>Asignado Host:</strong> {{ $event['asigned_host'] }}</p>
            <p class="text-lg"><strong>Hay Actividad:</strong> {{ $event['have_event_activity'] }}</p>
            <p class="text-lg"><strong>Notificacion:</strong> {{ $event['notification_enabled'] }}</p>
            <p class="text-lg"><strong>Grupo:</strong> {{ $event['group_event'] }}</p>

            <div class="mt-8">
                <h2 class="text-2xl font-semibold">Descripción del Evento</h2>
                <p class="mt-2 text-gray-700">{{ $event['description_event'] }}</p>
            </div>
        </div>
    </div>

    <!-- Agregar el enlace a la imagen en miniatura -->
<!-- <div class="container mx-auto mt-4">
        <img src="{{ asset($event['thumbnail']) }}" alt="Miniatura del evento" class="max-w-full h-auto">
    </div>

</body>
</html> -->
