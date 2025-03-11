-- --------------
-- ADMINISTRAR --
-- --------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('manage', 'Administrar', '', '');

INSERT INTO `permissions` (`id`, `action`, `module`) VALUES
('access--manage', 'access', 'manage');

INSERT INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
('admin---access--manage', 1, 'admin', 'access--manage'),
('advanced---access--manage', 1, 'advanced', 'access--manage'),
('client---access--manage', 0, 'client', 'access--manage');


-- ----------------------
-- ADMINISTRAR BINANCE --
-- ----------------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('manage-binance', 'Administrar', 'Binance', '/admin/binance');

INSERT INTO `permissions` (`id`, `action`, `module`) VALUES
('access--manage-binance', 'access', 'manage-binance');

INSERT INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
('admin---access--manage-binance', 1, 'admin', 'access--manage-binance'),
('advanced---access--manage-binance', 1, 'advanced', 'access--manage-binance'),
('client---access--manage-binance', 0, 'client', 'access--manage-binance');


-- --------------------
-- ADMINISTRAR TASAS --
-- --------------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('manage-rates', 'Administrar', 'Tasas', '/admin/tasas');

INSERT INTO `permissions` (`id`, `action`, `module`) VALUES
('access--manage-rates', 'access', 'manage-rates');

INSERT INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
('admin---access--manage-rates', 1, 'admin', 'access--manage-rates'),
('advanced---access--manage-rates', 1, 'advanced', 'access--manage-rates'),
('client---access--manage-rates', 0, 'client', 'access--manage-rates');