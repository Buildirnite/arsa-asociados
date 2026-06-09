<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #1a1a2e; background: #f5f5f0; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-top: 4px solid #b8860b; }
        .header { background: #0d0d1a; padding: 28px 32px; }
        .header h1 { color: #d4a843; font-size: 18px; margin: 0; letter-spacing: 1px; }
        .header p { color: #6b7280; font-size: 12px; margin: 4px 0 0; }
        .body { padding: 32px; }
        .field { margin-bottom: 20px; }
        .label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #9ca3af; margin-bottom: 4px; }
        .value { font-size: 15px; color: #1a1a2e; }
        .message-box { background: #f9f8f5; border-left: 3px solid #d4a843; padding: 16px; margin-top: 8px; }
        .footer { background: #f9f8f5; padding: 16px 32px; font-size: 11px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Arsa &amp; Asociados</h1>
            <p>Nueva consulta recibida desde el sitio web</p>
        </div>
        <div class="body">
            <div class="field">
                <div class="label">Nombre</div>
                <div class="value">{{ $name }}</div>
            </div>
            <div class="field">
                <div class="label">Correo electrónico</div>
                <div class="value">{{ $email }}</div>
            </div>
            @if($phone)
            <div class="field">
                <div class="label">Teléfono</div>
                <div class="value">{{ $phone }}</div>
            </div>
            @endif
            <div class="field">
                <div class="label">Consulta</div>
                <div class="message-box">{{ $message }}</div>
            </div>
        </div>
        <div class="footer">
            Este mensaje fue enviado desde el formulario de contacto de arsajuridico.cl
        </div>
    </div>
</body>
</html>
