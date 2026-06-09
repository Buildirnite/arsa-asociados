<?php

namespace App\Support;

use App\Models\Appointment;
use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * Genera los horarios disponibles para agendar una cita.
 *
 * Configuración del estudio:
 *  - Atención: lunes a sábado (sin domingos).
 *  - Horario: 09:00 a 18:00.
 *  - Duración de cada cita: 45 minutos.
 */
class AppointmentSlots
{
    public const OPEN_HOUR   = 9;
    public const CLOSE_HOUR  = 18;
    public const DURATION    = 45; // minutos
    public const MAX_DAYS_AHEAD = 60;

    /** ¿El día está dentro del horario de atención (lun–sáb)? */
    public static function isWorkingDay(CarbonInterface $date): bool
    {
        return ! $date->isSunday();
    }

    /**
     * Todos los bloques horarios de un día, en formato "H:i".
     *
     * @return array<int, string>
     */
    public static function slotsForDay(CarbonInterface $date): array
    {
        if (! self::isWorkingDay($date)) {
            return [];
        }

        $slots = [];
        $start = $date->copy()->setTime(self::OPEN_HOUR, 0);
        $close = $date->copy()->setTime(self::CLOSE_HOUR, 0);

        while ($start->copy()->addMinutes(self::DURATION)->lessThanOrEqualTo($close)) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(self::DURATION);
        }

        return $slots;
    }

    /**
     * Bloques realmente disponibles de un día: descarta los ya reservados
     * y los que ya pasaron (si la fecha es hoy).
     *
     * @return array<int, string>
     */
    public static function availableForDay(CarbonInterface $date): array
    {
        $taken = Appointment::active()
            ->whereDate('scheduled_at', $date->toDateString())
            ->get()
            ->map(fn (Appointment $a) => $a->scheduled_at->format('H:i'))
            ->all();

        $now = Carbon::now();

        return array_values(array_filter(self::slotsForDay($date), function (string $slot) use ($date, $taken, $now) {
            if (in_array($slot, $taken, true)) {
                return false;
            }

            [$h, $m] = explode(':', $slot);
            $slotTime = $date->copy()->setTime((int) $h, (int) $m);

            return $slotTime->greaterThan($now);
        }));
    }

    /** ¿La fecha es válida para agendar (lun–sáb, no pasada, dentro del rango)? */
    public static function isBookableDate(CarbonInterface $date): bool
    {
        $today = Carbon::today();

        return self::isWorkingDay($date)
            && $date->greaterThanOrEqualTo($today)
            && $date->lessThanOrEqualTo($today->copy()->addDays(self::MAX_DAYS_AHEAD));
    }
}
