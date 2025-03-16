-- TIPOS DE COMPAÑIA POR PAIS

INSERT IGNORE INTO `countries_companies` (`id`, `code`, `name`, `country`) VALUES

-- Argentina
('arg-sa', 'SA', 'Sociedad Anónima', 'arg'),
('arg-srl', 'SRL', 'Sociedad de Responsabilidad Limitada', 'arg'),
('arg-sas', 'SAS', 'Sociedad por Acciones Simplificada', 'arg'),
('arg-mono', 'MONO', 'Monotributista', 'arg'),
('arg-coop', 'COOP', 'Cooperativa', 'arg'),
('arg-ac', 'AC', 'Asociación Civil', 'arg'),
('arg-fund', 'FUND', 'Fundación', 'arg'),
('arg-other', 'OTRA', 'Otra', 'arg'),

-- Bolivia
('bol-sa', 'SA', 'Sociedad Anónima', 'bol'),
('bol-srl', 'SRL', 'Sociedad de Responsabilidad Limitada', 'bol'),
('bol-eu', 'EU', 'Empresa Unipersonal', 'bol'),
('bol-scs', 'SCS', 'Sociedad en Comandita Simple', 'bol'),
('bol-sca', 'SCA', 'Sociedad en Comandita por Acciones', 'bol'),
('bol-coop', 'COOP', 'Cooperativa', 'bol'),
('bol-other', 'OTRA', 'Otra', 'bol'),

-- Brasil
('bra-sa', 'SA', 'Sociedad Anónima', 'bra'),
('bra-eireli', 'EIRELI', 'Empresa Individual de Responsabilidad Limitada', 'bra'),
('bra-mei', 'MEI', 'Microemprendedor Individual', 'bra'),
('bra-ltda', 'LTDA', 'Sociedad de Responsabilidad Limitada', 'bra'),
('bra-snc', 'SNC', 'Sociedad en Nombre Colectivo', 'bra'),
('bra-scs', 'SCS', 'Sociedad en Comandita Simple', 'bra'),
('bra-sca', 'SCA', 'Sociedad en Comandita por Acciones', 'bra'),
('bra-other', 'OTRA', 'Otra', 'bra'),

-- Chile
('chl-sa', 'SA', 'Sociedad Anónima', 'chl'),
('chl-srl', 'SRL', 'Sociedad de Responsabilidad Limitada', 'chl'),
('chl-eirl', 'EIRL', 'Empresa Individual de Responsabilidad Limitada', 'chl'),
('chl-spa', 'SPA', 'Sociedad por Acciones', 'chl'),
('chl-scs', 'SCS', 'Sociedad en Comandita Simple', 'chl'),
('chl-sca', 'SCA', 'Sociedad en Comandita por Acciones', 'chl'),
('chl-other', 'OTRA', 'Otra', 'chl'),

-- Colombia
('col-sa', 'SA', 'Sociedad Anónima', 'col'),
('col-sas', 'SAS', 'Sociedad por Acciones Simplificada', 'col'),
('col-eu', 'EU', 'Empresa Unipersonal', 'col'),
('col-ltda', 'LTDA', 'Sociedad de Responsabilidad Limitada', 'col'),
('col-scs', 'SCS', 'Sociedad en Comandita Simple', 'col'),
('col-sca', 'SCA', 'Sociedad en Comandita por Acciones', 'col'),
('col-other', 'OTRA', 'Otra', 'col'),

-- Costa Rica
('cri-sa', 'SA', 'Sociedad Anónima', 'cri'),
('cri-srl', 'SRL', 'Sociedad de Responsabilidad Limitada', 'cri'),
('cri-eirl', 'EIRL', 'Empresa Individual de Responsabilidad Limitada', 'cri'),
('cri-other', 'OTRA', 'Otra', 'cri'),

-- República Dominicana
('dom-sa', 'SA', 'Sociedad Anónima', 'dom'),
('dom-srl', 'SRL', 'Sociedad de Responsabilidad Limitada', 'dom'),
('dom-eirl', 'EIRL', 'Empresa Individual de Responsabilidad Limitada', 'dom'),
('dom-other', 'OTRA', 'Otra', 'dom'),

-- Ecuador
('ecu-sa', 'SA', 'Sociedad Anónima', 'ecu'),
('ecu-cia-ltda', 'CIA LTDA', 'Compañía de Responsabilidad Limitada', 'ecu'),
('ecu-pn', 'PN', 'Persona Natural con Negocio', 'ecu'),
('ecu-other', 'OTRA', 'Otra', 'ecu'),

-- España
('esp-sa', 'SA', 'Sociedad Anónima', 'esp'),
('esp-sl', 'SL', 'Sociedad Limitada', 'esp'),
('esp-slu', 'SLU', 'Sociedad Limitada Unipersonal', 'esp'),
('esp-scoop', 'SCOOP', 'Sociedad Cooperativa', 'esp'),
('esp-aie', 'AIE', 'Agrupación de Interés Económico', 'esp'),
('esp-other', 'OTRA', 'Otra', 'esp'),

-- México
('mex-sa', 'SA', 'Sociedad Anónima', 'mex'),
('mex-s-de-rl', 'S DE RL', 'Sociedad de Responsabilidad Limitada', 'mex'),
('mex-sas', 'SAS', 'Sociedad por Acciones Simplificada', 'mex'),
('mex-snc', 'SNC', 'Sociedad en Nombre Colectivo', 'mex'),
('mex-scs', 'SCS', 'Sociedad en Comandita Simple', 'mex'),
('mex-sca', 'SCA', 'Sociedad en Comandita por Acciones', 'mex'),
('mex-other', 'OTRA', 'Otra', 'mex'),

-- Panamá
('pan-sa', 'SA', 'Sociedad Anónima', 'pan'),
('pan-srl', 'SRL', 'Sociedad de Responsabilidad Limitada', 'pan'),
('pan-eirl', 'EIRL', 'Empresa Individual de Responsabilidad Limitada', 'pan'),
('pan-other', 'OTRA', 'Otra', 'pan'),

-- Perú
('per-sa', 'SA', 'Sociedad Anónima', 'per'),
('per-sac', 'SAC', 'Sociedad Anónima Cerrada', 'per'),
('per-srl', 'SRL', 'Sociedad de Responsabilidad Limitada', 'per'),
('per-eirl', 'EIRL', 'Empresa Individual de Responsabilidad Limitada', 'per'),
('per-scs', 'SCS', 'Sociedad en Comandita Simple', 'per'),
('per-sca', 'SCA', 'Sociedad en Comandita por Acciones', 'per'),
('per-other', 'OTRA', 'Otra', 'per'),

-- Portugal
('prt-sa', 'SA', 'Sociedad Anónima', 'prt'),
('prt-lda', 'LDA', 'Sociedad por Cuotas', 'prt'),
('prt-eirl', 'EIRL', 'Empresa Individual de Responsabilidad Limitada', 'prt'),
('prt-other', 'OTRA', 'Otra', 'prt'),

-- Uruguay
('ury-sa', 'SA', 'Sociedad Anónima', 'ury'),
('ury-srl', 'SRL', 'Sociedad de Responsabilidad Limitada', 'ury'),
('ury-sas', 'SAS', 'Sociedad por Acciones Simplificada', 'ury'),
('ury-snc', 'SNC', 'Sociedad en Nombre Colectivo', 'ury'),
('ury-scs', 'SCS', 'Sociedad en Comandita Simple', 'ury'),
('ury-sca', 'SCA', 'Sociedad en Comandita por Acciones', 'ury'),
('ury-other', 'OTRA', 'Otra', 'ury'),

-- Estados Unidos
('usa-llc', 'LLC', 'Compañía de Responsabilidad Limitada', 'usa'),
('usa-c-corp', 'C CORP', 'Corporación', 'usa'),
('usa-s-corp', 'S CORP', 'Corporación S', 'usa'),
('usa-lp', 'LP', 'Sociedad Limitada', 'usa'),
('usa-sp', 'SP', 'Propietario Único', 'usa'),
('usa-other', 'OTRA', 'Otra', 'usa'),

-- Venezuela
('ven-sa', 'SA', 'Sociedad Anónima', 'ven'),
('ven-srl', 'SRL', 'Sociedad de Responsabilidad Limitada', 'ven'),
('ven-ca', 'CA', 'Compañía Anónima', 'ven'),
('ven-scs', 'SCS', 'Sociedad en Comandita Simple', 'ven'),
('ven-sca', 'SCA', 'Sociedad en Comandita por Acciones', 'ven'),
('ven-other', 'OTRA', 'Otra', 'ven');