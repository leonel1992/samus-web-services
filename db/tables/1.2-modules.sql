
-- PANEL USER 
INSERT IGNORE INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('account-home', 'Cuenta', 'Inicio', '/cuenta');


-- CALCULADORA 
INSERT IGNORE INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('calculator', 'Calculadora', NULL, '/calculadora');

-- ('calculator-office', 'Calculadora', 'Oficina', '/calculadora/oficina'),
-- ('calculator-preference', 'Calculadora', 'Preferencial', '/calculadora/preferencial'),
-- ('calculator-public', 'Calculadora', 'Pública', '/calculadora/publica'),
-- ('calculator-recharges', 'Calculadora', 'Recargas', '/calculadora/recargas');


-- FOLLETOS 
INSERT IGNORE INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('flayers', 'Folletos', NULL, '/folletos');

-- ('flayers-country-rates', 'Folletos', 'Tasas por país', '/folletos/tasas-por-pais'),
-- ('flayers-general-rates', 'Folletos', 'Tasas generales', '/folletos/tasas-generales'),
-- ('flayers-social-media', 'Folletos', 'Redes sociales', '/folletos/redes-sociales');


-- CUENTAS 
INSERT IGNORE INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('accounts', 'Cuentas', NULL, '/cuentas');


-- CLIENTES 
INSERT IGNORE INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('customers', 'Clientes', NULL, '/clientes');


-- USUARIOS 
INSERT IGNORE INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('users', 'Usuarios', NULL, '/usuarios');


-- REGISTROS 
INSERT IGNORE INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('records', 'Registros', NULL, '/registros');


-- SEGURIDAD 
INSERT IGNORE INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('security', 'Seguridad', NULL, '/seguridad');


-- ADMINISTRAR 
INSERT IGNORE INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('manage', 'Administrar', NULL, '/admin');

-- ('manage-binance', 'Administrar', 'Binance', '/admin/binance'),
-- ('manage-rates', 'Administrar', 'Tasas', '/admin/tasas');


-- AJUSTES 
INSERT IGNORE INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('settings', 'Ajustes', NULL, '/ajustes'),

('settings-currencies', 'Ajustes', 'Monedas', '/ajustes/monedas'),
('settings-countries', 'Ajustes', 'Países', '/ajustes/paises'),
('settings-processors', 'Ajustes', 'Procesadores', '/ajustes/procesadores'),
('settings-payment-methods', 'Ajustes', 'Métodos de pago', '/ajustes/metodos-de-pago'),

('settings-actions', 'Ajustes', 'Acciones', '/ajustes/acciones'),
('settings-modules', 'Ajustes', 'Módulos', '/ajustes/modulos'),
('settings-permissions', 'Ajustes', 'Permisos', '/ajustes/permisos'),
('settings-roles', 'Ajustes', 'Roles', '/ajustes/roles');