-- -------------
-- PANEL USER --
-- -------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('panel-home', 'Panel', 'Inicio', '/panel');

INSERT INTO `permissions` (`id`, `action`, `module`) VALUES
('access--panel-home', 'access', 'panel-home');

INSERT INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
('admin---access--panel-home', 1, 'admin', 'access--panel-home'),
('advanced---access--panel-home', 1, 'advanced', 'access--panel-home'),
('client---access--panel-home', 1, 'client', 'access--panel-home');