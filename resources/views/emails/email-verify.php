<div style="font-family: Arial, sans-serif; background: linear-gradient(to bottom right, #fff0f5, #ffe4f1, #fce7f3); padding: 40px; border-radius: 25px; text-align: center; color: #333;">

    <!-- Emoji decorativo -->
    <div style="font-size:50px; margin-bottom:20px;">
        💌
    </div>

    <h2 style="font-size:28px; color:#ec4899; margin-bottom:10px;">¡Verifica tu correo!</h2>
    <p style="font-size:16px; margin-bottom:20px;">Hola {{ $user->name }}, confirma tu dirección de correo electrónico</p>

    <div style="background:#fbcfe8; padding:20px; border-radius:15px; margin:20px 0; box-shadow: 0 4px 12px rgba(236, 72, 153, 0.2);">
        <p style="margin:5px 0; font-size:15px; color:#be185d;">
            Para completar tu registro, necesitamos que verifiques tu cuenta
        </p>
        <p style="margin:15px 0; font-size:14px; color:#9d174d;">
            Haz clic en el botón de abajo para confirmar tu correo
        </p>
    </div>
    
    <p style="font-size:14px; color:#ec4899;">¡Estamos emocionados de tenerte con nosotros! 🌸</p>

    <a href="{{ $verificationUrl }}" style="display:inline-block; margin-top:25px; padding:12px 25px; background: linear-gradient(to right, #f9a8d4, #f43f5e); color:white; font-weight:bold; border-radius:12px; text-decoration:none; transition: all 0.3s;">
        Verificar mi correo
    </a>

    <p style="font-size:12px; color:#9ca3af; margin-top:30px;">
        Si no creaste esta cuenta, puedes ignorar este correo
    </p>
</div>