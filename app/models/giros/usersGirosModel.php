<?php
    require_once __DIR__ . '/../db/countriesModel.php';

class UsersGirosModel extends ORM {

	protected ?PDO $connServices;
	protected ?PDO $connGiros;

    public string $table = 'usuarios';
	public string $query = "SELECT * FROM `usuarios` ORDER BY `name` ASC";
	private string $pathCountries = __DIR__ ."/../../../../giros/public/data/paises.json";

	public function __construct(?PDO $connServices) {
		$dbName = $_SERVER['SERVER_NAME'] === 'localhost' ? 'default.giros' : 'giros.samusgroup.com';
		
        $this->connServices = $connServices;
        $this->connGiros = DatabaseService::init($dbName);
		parent::__construct($this->connGiros, $this->table);
	}

	public function getParseItem(?array $item): array|null {
        if ($item) {
			$dataName = $this->getDataName($item['NOMBRE']);
			$dataCountry = $this->getDataCountry($item['PAIS']);

			return [
				'code' => intval($item['ID_US']),
				'rol' => $this->getRol($item['TIPO']),
				'user' => strtolower($item['EMAIL']),
				'name' => $dataName['name'],
				'last_name' => $dataName['last_name'],
				'country' => $dataCountry['id'],
				'phone' => $this->getPhone($item['TELEF'], $dataCountry['prefix']),
				'phone_prefix' => $dataCountry['prefix'],
				'address' => $item['DIRECC'],
				'gender' => $item['SEXO'],
			];
        } return $item;
    }

	private function getDataName(string $fullName) {

		$formatted = ucwords(strtolower($fullName));
		$parts = explode(' ', $formatted);
		$count = count($parts);

		$firstName = '';
		$lastName = '';
	
		if ($count == 2) {
			$firstName = $parts[0];
			$lastName = $parts[1];
		} elseif ($count > 2) {
			$firstName = "{$parts[0]} {$parts[1]}";
			$lastName = implode(' ', array_slice($parts, 2));
		} else {
			$firstName = $parts[0];
			$lastName = '';
		}
	
		return [
			'name' => $firstName,
			'last_name' => $lastName
		];
	}

	private function getDataCountry(string $country): array {
		$countries = JSON::open($this->pathCountries);
		if ($countries && is_array($countries) && isset($countries[$country])) {
			$countriesModel = new CountriesModel($this->connServices);
			$countriesData = $countriesModel->getByKey('iso_2', $countries[$country]['codigo']);
			if ($countriesData->success) {
				return $countriesModel->getParseItem($countriesData->data);
			}
		} return [];
	}

	private function getPhone($phone, $prefix) {
		if (strpos($phone, $prefix) === 0) {
			$phone = substr($phone, strlen($prefix));
		} return preg_replace('/\D/', '', $phone);
	}
	
	private function getRol(?string $rol): string|null {
		return match ($rol) {
			'AD' => 'admin',
			'OP' => 'agent',
			'OF' => 'office',
			'CL' => 'client',
			default => null,
		};
	}

	//-------------------------------------------------

	public function getUserData() {
		if (!empty($_SESSION['data-giros']['code']) && 
			!empty($_SESSION['data-giros']['user']) && 
			!empty($_SESSION['data-giros']['pass'])) {
			$data = $this->getByKeys([
				'ID_US' => $_SESSION['data-giros']['code'],
				'EMAIL' => $_SESSION['data-giros']['user'],
				'CLAVE' => $_SESSION['data-giros']['pass']
			]);

			if ($data->success) {
				$data->data = $this->getParseItem($data->data);
			} return $data;
		} 
		
		return new ResultData('', []);
	}
}