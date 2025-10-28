<div style="font-family: Arial, sans-serif; background: linear-gradient(to bottom right, #fff7ed, #fff1e0, #fff3e0); padding: 40px; border-radius: 25px; text-align: center; color: #333;">

    <!-- Emoji decorativo -->
    <div style="font-size:50px; margin-bottom:20px;">
        ⏰
    </div>

    <h2 style="font-size:28px; color:#d97706; margin-bottom:10px;">¡Queda 24 horas para tu cita!</h2>
    <p style="font-size:16px; margin-bottom:20px;">Hola {{ $user->name }}, tu cita está programada para mañana:</p>

    <div style="background:#fed7aa; padding:20px; border-radius:15px; margin:20px 0; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.2);">
        <p style="margin:5px 0; font-weight:bold; color:#b45309;">Fecha: {{ $date }}</p>
        <p style="margin:5px 0; font-weight:bold; color:#b45309;">Hora: {{ $time }}</p>
    </div>

    <p style="font-size:14px; margin-bottom:20px; color:#78350f;">Te recomendamos confirmar tu asistencia</p>
    <p style="font-size:14px; color:#d97706;">¡Nos vemos pronto! 🧁</p>

    <a href="{{ url('/mis-citas') }}" style="display:inline-block; margin-top:25px; padding:12px 25px; background: linear-gradient(to right, #fbbf24, #b45309); color:white; font-weight:bold; border-radius:12px; text-decoration:none; transition: all 0.3s;">
        Ver mis citas
    </a>
</div>
