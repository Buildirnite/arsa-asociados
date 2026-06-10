{{-- Campo de teléfono con botón directo a WhatsApp.
     Espera: $phone (texto libre) y, opcionalmente, $name del cliente.
     Normaliza el número a formato internacional de WhatsApp (solo dígitos). --}}
@php
    $digits = preg_replace('/\D+/', '', (string) ($phone ?? ''));

    // Normalización para números chilenos.
    if (str_starts_with($digits, '56')) {
        $waNumber = $digits;                       // ya trae código de país
    } elseif (strlen($digits) === 9 && str_starts_with($digits, '9')) {
        $waNumber = '56' . $digits;                // móvil sin código país
    } elseif (strlen($digits) === 8) {
        $waNumber = '569' . $digits;               // sin 9 ni código país
    } else {
        $waNumber = $digits;                       // dejar tal cual (otros países / casos raros)
    }

    $waText = rawurlencode(
        'Hola' . (!empty($name) ? ' ' . $name : '') . ', le contactamos de Arsa & Asociados respecto a su consulta.'
    );
@endphp
<div class="field">
    <div class="label">Teléfono</div>
    <div class="value">{{ $phone }}</div>
    @if(strlen($waNumber) >= 11)
        <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}"
           target="_blank"
           style="display:inline-block; margin-top:10px; background:#25D366; color:#ffffff; font-size:14px; font-weight:bold; text-decoration:none; padding:11px 20px; border-radius:6px;">
            Contactar por WhatsApp
        </a>
    @endif
</div>
