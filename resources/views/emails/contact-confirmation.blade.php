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
        .body { padding: 32px; font-size: 15px; line-height: 1.6; color: #374151; }
        .body p { margin: 0 0 16px; }
        .message-box { background: #f9f8f5; border-left: 3px solid #d4a843; padding: 16px; margin: 8px 0 20px; font-size: 14px; color: #4b5563; }
        .cta { display: inline-block; background: #25D366; color: #ffffff; text-decoration: none; font-weight: bold; font-size: 14px; padding: 12px 24px; }
        .footer { background: #f9f8f5; padding: 16px 32px; font-size: 11px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Arsa &amp; Asociados</h1>
            <p>Confirmación de su consulta</p>
        </div>
        <div class="body">
            <p>Estimado/a <strong>{{ $name }}</strong>,</p>
            <p>Hemos recibido su consulta correctamente. Gracias por contactar a <strong>Arsa &amp; Asociados</strong>. Un miembro de nuestro equipo la revisará y le responderá a la brevedad.</p>
            <p style="font-size:13px;color:#6b7280;margin-bottom:6px;">Esto fue lo que nos envió:</p>
            <div class="message-box">{{ $message }}</div>
            <p>Si su consulta es urgente, puede escribirnos directamente por WhatsApp:</p>
            <p>
                <a class="cta" href="https://wa.me/56930676693">Escribir por WhatsApp</a>
            </p>
            <p style="margin-top:24px;font-size:13px;color:#9ca3af;">Este es un mensaje automático, no es necesario que responda a este correo.</p>
        </div>
        <div class="footer">
            Arsa &amp; Asociados — Asesoría Jurídica · Santiago de Chile · arsajuridico.cl
        </div>
    </div>
</body>
</html>
