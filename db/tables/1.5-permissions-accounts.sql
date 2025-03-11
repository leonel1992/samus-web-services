-- ----------
-- CUENTAS --
-- ----------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('accounts', 'Cuentas', '', '');

INSERT INTO `permissions` (`id`, `action`, `module`) VALUES
('access--accounts', 'access', 'accounts');

INSERT INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
('admin---access--accounts', 1, 'admin', 'access--accounts'),
('advanced---access--accounts', 1, 'advanced', 'access--accounts'),
('client---access--accounts', 0, 'client', 'access--accounts');