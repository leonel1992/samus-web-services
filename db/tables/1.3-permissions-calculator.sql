-- -------------
-- CALCULADORA --
-- -------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('calculator', 'Calculadora', '', '/calculadora/');

INSERT INTO `permissions` (`id`, `action`, `module`) VALUES
('access--calculator', 'access', 'calculator');

INSERT INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
('admin---access--calculator', 1, 'admin', 'access--calculator'),
('advanced---access--calculator', 1, 'advanced', 'access--calculator'),
('client---access--calculator', 0, 'client', 'access--calculator');


-- ----------------------
-- CALCULADORA OFICINA --
-- ----------------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('calculator-office', 'Calculadora', 'Oficina', '/calculadora/oficina');


-- ---------------------------
-- CALCULADORA PREFERENCIAL --
-- ---------------------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('calculator-preference', 'Calculadora', 'Preferencial', '/calculadora/preferencial');


-- ----------------------
-- CALCULADORA PUBLICA --
-- ----------------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('calculator-public', 'Calculadora', 'Pública', '/calculadora/publica');


-- -----------------------
-- CALCULADORA RECARGAS --
-- -----------------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('calculator-recharges', 'Calculadora', 'Recargas', '/calculadora/recargas');
