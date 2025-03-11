<?php
class ipData {
    public ?string $city;
    public ?string $state;
    public ?string $country;
    public ?string $continent;
    public ?string $timezone;

    public function __construct(
        ?string $city = null,
        ?string $state = null,
        ?string $country = null,
        ?string $continent = null,
        ?string $timezone = null
    ) {
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->continent = $continent;
        $this->timezone = $timezone;
    }
}