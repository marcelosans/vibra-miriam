<div style="font-family: Arial, sans-serif; background: linear-gradient(to bottom right, #fff0f5, #ffe4e1, #fde2e4); padding: 40px; border-radius: 25px; text-align: center; color: #333;">

    <!-- Emoji decorativo -->
    <div style="font-size:50px; margin-bottom:20px;">
        ❌
    </div>

    <h2 style="font-size:28px; color:#dc2626; margin-bottom:10px;">¡Cita Cancelada!</h2>
    <p style="font-size:16px; margin-bottom:20px;">Hola {{ $user->name }}, tu cita ha sido cancelada:</p>

    <div style="background:#fecaca; padding:20px; border-radius:15px; margin:20px 0; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);">
       <p style="margin:5px 0; font-weight:bold; color:#be185d;">
            Fecha: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
        </p>
        <p style="margin:5px 0; font-weight:bold; color:#be185d;">
            Hora: {{ \Carbon\Carbon::parse($time)->format('H:i') }}
        </p>
    </div>

    <p style="font-size:14px; margin-bottom:20px; color:#7f1d1d;">Lamentamos los inconvenientes</p>
    <p style="font-size:14px; color:#dc2626;">¡Gracias por tu comprensión! 🧁</p>

    <a href="{{ url('/mis-citas') }}" style="display:inline-block; margin-top:25px; padding:12px 25px; background: linear-gradient(to right, #f87171, #b91c1c); color:white; font-weight:bold; border-radius:12px; text-decoration:none; transition: all 0.3s;">
        Ver mis citas
    </a>
</div>
