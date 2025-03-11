-- ------------------
-- TIPOS DE MONEDA --
-- ------------------
INSERT INTO `currency_type` (`id`, `name`) VALUES
('crypto', 'Cripto'),
('currency', 'Divisa');


-- --------------------
-- MONEDAS INICIALES --
-- --------------------
INSERT INTO `currencies` (`id`, `type`, `code`, `symbol`, `name`) VALUES
('ars', 'currency', 'ARS', '$', 'Peso Argentino'),
('bob', 'currency', 'BOB', 'Bs', 'Boliviano'),
('brl', 'currency', 'BRL', 'R$', 'Real Brasileño'),
('clp', 'currency', 'CLP', '$', 'Peso Chileno'),
('cop', 'currency', 'COP', '$', 'Peso Colombiano'),
('crc', 'currency', 'CRC', '₡', 'Colón Costarricense'),
('dop', 'currency', 'DOP', 'RD$', 'Peso Dominicano'),
('eur', 'currency', 'EUR', '€', 'Euro (España)'),
('mxn', 'currency', 'MXN', '$', 'Peso Mexicano'),
('pab', 'currency', 'PAB', 'B/. ', 'Balboa Panameño'),
('pen', 'currency', 'PEN', 'S/.', 'Sol Peruano'),
('usd', 'currency', 'USD', '$', 'Dólar Estadounidense'),
('uyu', 'currency', 'UYU', '$', 'Peso Uruguayo'),
('ves', 'currency', 'VES', 'Bs. ', 'Bolívar Soberano'),
('btc', 'crypto', 'BTC', NULL, 'Bitcoin'),
('usdt', 'crypto', 'USDT', NULL, 'Tether');