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
        .card { background: #f9f8f5; border-left: 3px solid #d4a843; padding: 20px; margin: 8px 0 20px; }
        .card .when { font-size: 20px; font-weight: bold; color: #1a1a2e; }
        .card .area { font-size: 13px; color: #6b7280; margin-top: 6px; }
        .footer { background: #f9f8f5; padding: 16px 32px; font-size: 11px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Arsa &amp; Asociados</h1>
            <p>Confirmación de cita</p>
        </div>
        <div class="body">
            <p>Estimado/a <strong>{{ $appointment->name }}</strong>,</p>
            <p>Su cita ha quedado <strong>agendada</strong>. Estos son los detalles:</p>
            <div class="card">
                <div class="when">{{ $appointment->scheduled_at->locale('es')->isoFormat('dddd D [de] MMMM') }}</div>
                <div class="when" style="font-size:16px;color:#b8860b;">a las {{ $appointment->scheduled_at->format('H:i') }} hrs</div>
                @if($appointment->area)<div class="area">Tema: {{ $appointment->area }}</div>@endif
            </div>
            <p>Si necesita reprogramar o cancelar, respóndanos a este correo o escríbanos por WhatsApp al <strong>+569 3067 6693</strong>.</p>
            <p style="margin-top:24px;font-size:13px;color:#9ca3af;">Le esperamos. Equipo de Arsa &amp; Asociados.</p>
        </div>
        <div class="footer">
            Arsa &amp; Asociados — Asesoría Jurídica · Santiago de Chile · arsajuridico.cl
        </div>
    </div>
</body>
</html>
