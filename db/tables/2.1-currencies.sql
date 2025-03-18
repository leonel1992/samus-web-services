
-- TIPOS DE MONEDA 
INSERT IGNORE INTO `currencies_types` (`id`, `name`) VALUES
('crypto', 'Cripto'),
('currency', 'Divisa');


-- MONEDAS 
INSERT IGNORE INTO `currencies` (`id`, `type`, `code`, `symbol`, `digits`,`name`) VALUES
('ars', 'currency', 'ARS', '$', 2, 'Peso Argentino'),
('bob', 'currency', 'BOB', 'Bs', 2, 'Boliviano'),
('brl', 'currency', 'BRL', 'R$', 2, 'Real Brasileño'),
('clp', 'currency', 'CLP', '$', 2, 'Peso Chileno'),
('cop', 'currency', 'COP', '$', 2, 'Peso Colombiano'),
('crc', 'currency', 'CRC', '₡', 2, 'Colón Costarricense'),
('dop', 'currency', 'DOP', 'RD$', 2, 'Peso Dominicano'),
('eur', 'currency', 'EUR', '€', 2, 'Euro (España)'),
('mxn', 'currency', 'MXN', '$', 2, 'Peso Mexicano'),
('pab', 'currency', 'PAB', 'B/. ', 2, 'Balboa Panameño'),
('pen', 'currency', 'PEN', 'S/.', 2, 'Sol Peruano'),
('usd', 'currency', 'USD', '$', 2, 'Dólar Estadounidense'),
('uyu', 'currency', 'UYU', '$', 2, 'Peso Uruguayo'),
('ves', 'currency', 'VES', 'Bs. ', 2, 'Bolívar Soberano'),
('btc', 'crypto', 'BTC', NULL, 8, 'Bitcoin'),
('usdt', 'crypto', 'USDT', NULL, 4, 'Tether');