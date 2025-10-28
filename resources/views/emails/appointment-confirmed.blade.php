<div style="font-family: Arial, sans-serif; background: linear-gradient(to bottom right, #fff0f5, #ffe4f1, #fce7f3); padding: 40px; border-radius: 25px; text-align: center; color: #333;">

    <!-- Emoji decorativo -->
    <div style="font-size:50px; margin-bottom:20px;">
        🌸
    </div>

    <h2 style="font-size:28px; color:#ec4899; margin-bottom:10px;">¡Cita Confirmada!</h2>
    <p style="font-size:16px; margin-bottom:20px;">Hola {{ $user->name }}, tu cita ha sido reservada exitosamente:</p>

    <div style="background:#fbcfe8; padding:20px; border-radius:15px; margin:20px 0; box-shadow: 0 4px 12px rgba(236, 72, 153, 0.2);">
        <p style="margin:5px 0; font-weight:bold; color:#be185d;">Fecha: {{ $date }}</p>
        <p style="margin:5px 0; font-weight:bold; color:#be185d;">Hora: {{ $time }}</p>
    </div>

    <p style="font-size:14px; margin-bottom:20px; color:#9d174d;">Recibirás un recordatorio 24 horas antes de tu cita.</p>
    <p style="font-size:14px; color:#ec4899;">¡Gracias por confiar en nosotros! 🧁</p>

    <a href="{{ url('/mis-citas') }}" style="display:inline-block; margin-top:25px; padding:12px 25px; background: linear-gradient(to right, #f9a8d4, #f43f5e); color:white; font-weight:bold; border-radius:12px; text-decoration:none; transition: all 0.3s;">
        Ver mis citas
    </a>
</div>
