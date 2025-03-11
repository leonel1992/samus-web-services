-- -----------
-- FOLLETOS --
-- -----------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('flayers', 'Folletos', '', '/folletos/');

INSERT INTO `permissions` (`id`, `action`, `module`) VALUES
('access--flayers', 'access', 'flayers');

INSERT INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
('admin---access--flayers', 1, 'admin', 'access--flayers'),
('advanced---access--flayers', 1, 'advanced', 'access--flayers'),
('client---access--flayers', 0, 'client', 'access--flayers');


-- -----------------------------
-- FOLLETOS DE TASAS POR PAIS --
-- -----------------------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('flayers-country-rates', 'Folletos', 'Tasas por país', '/folletos/tasas-por-pais');


-- ------------------------------
-- FOLLETOS DE TASAS GENERALES --
-- ------------------------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('flayers-general-rates', 'Folletos', 'Tasas generales', '/folletos/tasas-generales');


-- -----------------------------
-- FOLLETOS DE REDES SOCIALES --
-- -----------------------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('flayers-social-media', 'Folletos', 'Redes sociales', '/folletos/redes-sociales');