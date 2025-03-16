
-- TIPOS DE DOCUMENTOS DE IDENTIFICACION POR PAIS
INSERT IGNORE INTO `countries_dnis` (`id`, `code`, `name`, `country`) VALUES 

-- Argentina
('arg-dni', 'DNI', 'Documento Nacional de Identidad', 'arg'),  
('arg-dniex', 'DNIEX', 'DNI para Extranjeros', 'arg'),  
('arg-cuil', 'CUIL', 'Código Único de Identificación Laboral', 'arg'),  
('arg-cuit', 'CUIT', 'Código Único de Identificación Tributaria', 'arg'),  
('arg-pas', 'PAS', 'Pasaporte', 'arg'),  
('arg-other', 'OTRO', 'Otro', 'arg'),

-- Bolivia
('bol-ci', 'CI', 'Cédula de Identidad', 'bol'),  
('bol-cie', 'CIE', 'Carnet de Identidad para Extranjeros', 'bol'),  
('bol-run', 'RUN', 'Registro Único Nacional', 'bol'),  
('bol-pas', 'PAS', 'Pasaporte', 'bol'),  
('bol-other', 'OTRO', 'Otro', 'bol'),

-- Brasil
('bra-rg', 'RG', 'Registro General (Cédula de Identidad)', 'bra'),  
('bra-cin', 'CIN', 'Carnet de Identidad Nacional', 'bra'),  
('bra-cpf', 'CPF', 'Registro de Personas Físicas', 'bra'),  
('bra-cnh', 'CNH', 'Licencia Nacional de Conducir', 'bra'),  
('bra-crnm', 'CRNM', 'Carnet de Registro Nacional de Migración', 'bra'),  
('bra-pas', 'PAS', 'Pasaporte', 'bra'),  
('bra-titulo', 'Título', 'Carnet de Elector', 'bra'),  
('bra-crlv', 'CRLV', 'Certificado de Registro y Licenciamiento de Vehículo', 'bra'),  
('bra-other', 'OTRO', 'Otro', 'bra'),

-- Chile
('chl-rut', 'RUT', 'Rol Único Tributario', 'chl'),  
('chl-run', 'RUN', 'Rol Único Nacional', 'chl'),  
('chl-ci', 'CI', 'Cédula de Identidad', 'chl'),  
('chl-pas', 'PAS', 'Pasaporte', 'chl'),  
('chl-ce', 'CE', 'Carnet de Extranjería', 'chl'),  
('chl-dni', 'DNI', 'Documento Nacional de Identidad (para extranjeros con convenios)', 'chl'),  
('chl-other', 'OTRO', 'Otro', 'chl'),

-- Colombia
('col-rc', 'RC', 'Registro Civil de Nacimiento', 'col'),  
('col-ti', 'TI', 'Tarjeta de Identidad', 'col'),  
('col-cc', 'CC', 'Cédula de Ciudadanía', 'col'),  
('col-pas', 'PAS', 'Pasaporte', 'col'),  
('col-nit', 'NIT', 'Número de Identificación Tributaria', 'col'),  
('col-ce', 'CE', 'Cédula de Extranjería', 'col'),  
('col-te', 'TE', 'Tarjeta de Extranjería', 'col'),  
('col-ppt', 'PPT', 'Permiso por Protección Temporal', 'col'),  
('col-die', 'DIE', 'Documento de Identificación de Extranjero', 'col'),  
('col-other', 'OTRO', 'Otro', 'col'),

-- Costa Rica
('cri-cid', 'CID', 'Cédula de Identidad', 'cri'),  
('cri-pas', 'PAS', 'Pasaporte', 'cri'),  
('cri-dimex', 'DIMEX', 'Documento de Identificación Migratoria para Extranjeros', 'cri'),  
('cri-nite', 'NITE', 'Número de Identificación Tributaria Especial', 'cri'),  
('cri-other', 'OTRO', 'Otro', 'cri'),

-- Ecuador
('ecu-ci', 'CI', 'Cédula de Identidad', 'ecu'),
('ecu-pas', 'PAS', 'Pasaporte', 'ecu'),
('ecu-ruc', 'RUC', 'Registro Único de Contribuyentes', 'ecu'),
('ecu-ce', 'CE', 'Carnet de Extranjería', 'ecu'),
('ecu-other', 'OTRO', 'Otro', 'ecu'),

-- España
('esp-dni', 'DNI', 'Documento Nacional de Identidad', 'esp'),
('esp-nie', 'NIE', 'Número de Identificación de Extranjero', 'esp'),
('esp-pas', 'PAS', 'Pasaporte', 'esp'),
('esp-tie', 'TIE', 'Tarjeta de Identidad de Extranjero', 'esp'),
('esp-other', 'OTRO', 'Otro', 'esp'),

-- México
('mex-ine', 'INE', 'Credencial para Votar (INE)', 'mex'),
('mex-curp', 'CURP', 'Clave Única de Registro de Población', 'mex'),
('mex-pas', 'PAS', 'Pasaporte', 'mex'),
('mex-rfc', 'RFC', 'Registro Federal de Contribuyentes', 'mex'),
('mex-dtv', 'DTV', 'Documento de Identidad y Viaje para Menores', 'mex'),
('mex-other', 'OTRO', 'Otro', 'mex'),

-- Panamá
('pan-ced', 'CED', 'Cédula de Identidad Personal', 'pan'),
('pan-pas', 'PAS', 'Pasaporte', 'pan'),
('pan-ruc', 'RUC', 'Registro Único de Contribuyentes', 'pan'),
('pan-crp', 'CRP', 'Carné de Residente Permanente', 'pan'),
('pan-cpt', 'CPT', 'Carné Provisional de Residencia', 'pan'),
('pan-other', 'OTRO', 'Otro', 'pan'),

-- Perú
('per-dni', 'DNI', 'Documento Nacional de Identidad', 'per'),
('per-ce', 'CE', 'Carné de Extranjería', 'per'),
('per-pas', 'PAS', 'Pasaporte', 'per'),
('per-ruc', 'RUC', 'Registro Único de Contribuyentes', 'per'),
('per-other', 'OTRO', 'Otro', 'per'),

-- Portugal
('prt-cc', 'CC', 'Tarjeta de Ciudadano', 'prt'),
('prt-pas', 'PAS', 'Pasaporte', 'prt'),
('prt-nif', 'NIF', 'Número de Identificación Fiscal', 'prt'),
('prt-niss', 'NISS', 'Número de Identificación de la Seguridad Social', 'prt'),
('prt-other', 'OTRO', 'Otro', 'prt'),

-- República Dominicana
('dom-ced', 'CED', 'Cédula de Identidad y Electoral', 'dom'),  
('dom-pas', 'PAS', 'Pasaporte', 'dom'),  
('dom-rnc', 'RNC', 'Registro Nacional del Contribuyente', 'dom'),  
('dom-pnm', 'PNM', 'Permiso Nacional de Movilidad', 'dom'),  
('dom-other', 'OTRO', 'Otro', 'dom'),  

-- Uruguay
('ury-ci', 'CI', 'Cédula de Identidad', 'ury'),
('ury-pas', 'PAS', 'Pasaporte', 'ury'),
('ury-rut', 'RUT', 'Registro Único Tributario', 'ury'),
('ury-dpta', 'DPTA', 'Documento Provisorio para Solicitantes de Asilo', 'ury'),
('ury-other', 'OTRO', 'Otro', 'ury'),

-- Estados Unidos
('usa-realid', 'REALID', 'Identificación Real', 'usa'),
('usa-pas', 'PAS', 'Pasaporte', 'usa'),
('usa-ssn', 'SSN', 'Número de Seguro Social', 'usa'),
('usa-ead', 'EAD', 'Documento de Autorización de Empleo', 'usa'),
('usa-other', 'OTRO', 'Otro', 'usa'),

-- Venezuela
('ven-ci', 'CI', 'Cédula de Identidad', 'ven'),
('ven-pas', 'PAS', 'Pasaporte', 'ven'),
('ven-rif', 'RIF', 'Registro de Información Fiscal', 'ven'),
('ven-other', 'OTRO', 'Otro', 'ven');