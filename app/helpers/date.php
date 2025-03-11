<?php

class Date extends DateTime {

    public const FORMAT_COMPLETE_MYSQL = 'Y-m-d H:i:s';
    public const FORMAT_DATE_MYSQL = 'Y-m-d';
    public const FORMAT_COMPLETE = 'd-m-Y h:i a';
    public const FORMAT_DATE = 'd/m/Y';
    public const FORMAT_HOUR = 'h:i a';

    public function __construct(string $time = "now", string $timezone = 'UTC') {
        parent::__construct($time, new DateTimeZone($timezone));
    }

    public function setDateTimezone(string $timezone): void {
        $this->setTimezone(new DateTimeZone($timezone));
    }

    /*---------------------------------*/

    public function addSeconds(int $seconds): void {
        $this->add(DateInterval::createFromDateString("$seconds second"));
    } 

    public function addMinutes(int $minutes): void {
        $this->add(DateInterval::createFromDateString("$minutes minute"));
    } 

    public function addDays(int $days): void {
        $this->add(DateInterval::createFromDateString("$days day"));
    } 

    public function addMonths(int $months): void {
        $this->add(DateInterval::createFromDateString("$months month"));
    }

    public function addYears(int $years): void {
        $this->add(DateInterval::createFromDateString("$years year"));
    }

    /*---------------------------------*/

    public function subSeconds(int $seconds): void {
        $this->sub(DateInterval::createFromDateString("$seconds second"));
    }

    public function subMinutes(int $minutes): void {
        $this->sub(DateInterval::createFromDateString("$minutes minute"));
    } 

    public function subDays(int $days): void {
        $this->sub(DateInterval::createFromDateString("$days day"));
    }

    public function subMonths(int $months): void {
        $this->sub(DateInterval::createFromDateString("$months month"));
    }

    public function subYears(int $years): void {
        $this->sub(DateInterval::createFromDateString("$years year"));
    }

    /*---------------------------------*/

    public function formatLarge(bool $includeHour = true): string {
        $day = $this->format('j');
        $year = $this->format('Y');
        $hour = $this->formatHour();
        $date = $this->formatLargeDay();
        $month = $this->formatLargeMonth();
        
        switch ($GLOBALS['lang']) {
            case 'es':
                $conect = ($this->format('h') == '1') ? "a la" : "a las";
                return "$date, $day de $month de $year $conect $hour";

            default:
                return "$date, $month $day, $year at $hour";
        } 
    }

    public function formatLargeDay(): string {
        switch ($GLOBALS['lang']) {
            case 'es':
                return match ($this->format('N')) {
                    '1' => 'lunes',
                    '2' => 'martes',
                    '3' => 'miércoles',
                    '4' => 'jueves',
                    '5' => 'viernes',
                    '6' => 'sábado',
                    '7' => 'domingo',
                    default => '',
                };
            default:
                return $this->format('l');
        } 
    }

    public function formatLargeMonth(): string {
        switch ($GLOBALS['lang']) {
            case 'es':
                return match ($this->format('n')) {
                    '1' => 'Enero',
                    '2' => 'Febrero',
                    '3' => 'Marzo',
                    '4' => 'Abril', // Se corrigió "Abrirl" -> "Abril"
                    '5' => 'Mayo',
                    '6' => 'Junio',
                    '7' => 'Julio',
                    '8' => 'Agosto',
                    '9' => 'Septiembre',
                    '10' => 'Octubre',
                    '11' => 'Noviembre',
                    '12' => 'Diciembre',
                    default => '',
                };
            default:
                return $this->format('F');
        } 
    }

    /*---------------------------------*/

    public function formatCompleteMySQL(): string {
        return $this->format(self::FORMAT_COMPLETE_MYSQL);
    }

    public function formatComplete(): string {
        return $this->format(self::FORMAT_COMPLETE);
    }

    public function formatDateMySQL(): string {
        return $this->format(self::FORMAT_DATE_MYSQL);
    }

    public function formatDate(): string {
        return $this->format(self::FORMAT_DATE);
    }

    public function formatHour(): string {
        return $this->format(self::FORMAT_HOUR);
    }

}
